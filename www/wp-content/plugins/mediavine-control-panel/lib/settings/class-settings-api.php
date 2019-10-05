<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\MCP\Settings' ) && ! class_exists( 'Mediavine\MCP\Settings_API' ) ) {

	class Settings_API extends Settings {

		public static $instance;

		private $api_root = 'mcp-settings';

		private $api_version = 'v1';

		public $default_response = array(
			'errors' => array(),
		);

		/**
		 * Makes sure class is only instantiated once
		 *
		 * @return object Instantiated class
		 */
		static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();

				// Only open routes if user can login or dev
				add_action( 'rest_api_init', array( self::$instance, 'routes' ) );
			}

			return self::$instance;
		}

		/**
		 * Merges the response data into a single data object
		 *
		 * @param array|object $inbound_data Data to be merged into current data
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response REST response with new data
		 */
		public function set_response_data( $inbound_data = array(), \WP_REST_Response $response ) {
			$response_data         = array();
			$response_data['data'] = $inbound_data;

			if ( isset( $response->data ) ) {
				if ( isset( $response->data->data ) ) {
					$response_data = array_merge( $response_data['data'], (array) $response->data->data );
				}
				if ( isset( $response->data['data'] ) ) {
					$response_data = array_merge( $response_data['data'], (array) $response->data['data'] );
				}
			}
			$response->data = $response_data;

			return $response;
		}

		/**
		 * Middleware to run a series of callbacks to the REST response
		 *
		 * @param array $actions functions to be run
		 * @param \WP_REST_Request $request Current REST request
		 * @return \WP_REST_Response Updated REST response
		 */
		public function middleware( $actions = array(), \WP_REST_Request $request ) {
			$self = self::get_instance();

			$response = new \WP_REST_Response( $self->default_response );

			if ( ! $actions ) {
				return $response;
			}

			foreach ( $actions as $action ) {
				$response = call_user_func( $action, $request, $response );
				if ( is_wp_error( $response ) ) {
					$error    = $response;
					$response = new \WP_REST_Response( $error, $error->get_error_code() );
					break;
				}
			}

			return $response;
		}

		/**
		 * Sanitizes params for safe submission
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response with sanitized params
		 */
		public function sanitize( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$sanitized = $request->sanitize_params();

			if ( is_wp_error( $sanitized ) ) {
				return new \WP_Error(
					403, __( 'Entry Not Created', 'mediavine' ), array(
						'message' => __( 'Unsafe Content Submission', 'mediavine' ),
					)
				);
			}

			return $response;
		}

		/**
		 * Created or update a Trellis setting through the WP REST API
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response outputting added/modified Trellis setting
		 */
		public function editable( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params     = $request->get_params();
			$collection = self::upsert( $params );
			$response->set_status( 201 );

			$response = $this->set_response_data( $collection, $response );

			return $response;
		}

		/**
		 * Gets all Trellis settings through the WP REST API
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response outputting found Trellis settings
		 */
		public function readable( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$collection = self::read_all();
			$response   = $this->set_response_data( $collection, $response );

			return $response;
		}

		/**
		 * Gets all Trellis settings from a group through the WP REST API
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response outputting found Trellis settings
		 *                           from group or WP Error if group not found
		 */
		public function single_readable( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params  = $request->get_params();
			$setting = self::read_one( $params['slug'] );

			$response = $this->set_response_data( $setting, $response );
			if ( is_wp_error( $response->data['data'] ) ) {
				$response->set_status( 404 );
			}

			return $response;
		}

		/**
		 * Gets single Trellis setting through the WP REST API
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response outputting Trellis setting
		 *                           or WP Error if setting slug not found
		 */
		public function group_readable( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params     = $request->get_params();
			$collection = self::read_group( $params['group'] );

			$response = $this->set_response_data( $collection, $response );
			if ( is_wp_error( $response->data['data'] ) ) {
				$response->set_status( 404 );
			}

			return $response;
		}

		/**
		 * Deletes single Terllis setting through the WP REST API
		 *
		 * @param \WP_REST_Request $request Current REST request
		 * @param \WP_REST_Response $response Current REST response
		 * @return \WP_REST_Response Updated REST response outputting 204 status if deleted
		 *                           or 404 status if setting not found
		 */
		public function deletable( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params  = $request->get_params();
			$setting = self::delete_one( $params['slug'] );

			$response = $this->set_response_data( array(), $response );
			$response->set_status( 204 );

			if ( ! $setting ) {
				$response->set_status( 404 );
			}

			return $response;
		}

		/**
		 * Registers the WP REST API routes for Trellis
		 *
		 * @return void
		 */
		public function routes() {
			$route_namespace = $this->api_root . '/' . $this->api_version;

			register_rest_route(
				$route_namespace, '/settings', array(
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'editable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'readable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/settings/group/(?P<group>\S+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'group_readable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/settings/(?P<slug>\S+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'single_readable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'editable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::DELETABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return $this->middleware(
								array(
									array( $this, 'sanitize' ),
									array( $this, 'deletable' ),
								),
								$request
							);
						},
						'permission_callback' => function ( \WP_REST_Request $request ) {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);
		}
	}
}
