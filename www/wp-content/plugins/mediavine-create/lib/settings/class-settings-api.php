<?php

namespace Mediavine;

if ( class_exists( 'Mediavine\Settings' ) ) {

	class Settings_API extends Settings {

		private $api_services = null;

		function __construct() {
			$this->api_services = API_Services::get_instance();
		}

		/**
		 * API Function to create Settings, capable of processing both bulk and singular items
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function create( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$sanitized = $request->sanitize_params();
			$params    = $request->get_params();

			if ( is_wp_error( $sanitized ) ) {
				$status_code        = 403;
				$response['errors'] = $this->api_services->normalize_errors(
					$response['errors'], $status_code, array(
						'title'   => __( 'Unsafe Content Submission', 'mediavine' ),
						'details' => __( 'You\'re submission includes unsafe characters', 'mediavine' ),
					), 'error'
				);
				return new \WP_REST_Response( $response, $status_code );
			}

			$collection = array();

			if ( wp_is_numeric_array( $params ) ) {
				foreach ( $params as $setting ) {
					$stored = self::create_settings( $setting );
					if ( $stored ) {
						$stored       = self::extract( $stored );
						$collection[] = $this->api_services->prepare_item_for_response( $stored, $request );
					}
				}
			}

			if ( ! empty( $collection ) ) {
				$response    = array();
				$response    = $collection;
				$status_code = 201;
				return new \WP_REST_Response( $response, $status_code );
			}

			$stored = self::create_settings( $params );

			if ( $stored ) {
				$stored      = self::extract( $stored );
				$response    = array();
				$response    = $this->api_services->prepare_item_for_response( $stored, $request );
				$status_code = 201;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to read Settings Collection
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function read( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$settings = self::$models->mv_settings->find();

			if ( $settings ) {
				$collection = array();
				foreach ( $settings as $setting ) {
					$setting      = self::extract( $setting );
					$collection[] = $this->api_services->prepare_item_for_response( $setting, $request );
				}
				$response          = array();
				$response['links'] = $this->api_services->prepare_collection_links( $request );
				$response          = $collection;
				$status_code       = 200;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		public function read_by_group( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;
			$params      = $request->get_params();
			$settings    = self::$models->mv_settings->find(
				array(
					'where' => array(
						'`group`' => $params['slug'],
					),
				)
			);

			if ( $settings ) {
				$collection = array();
				foreach ( $settings as $setting ) {
					$setting      = self::extract( $setting );
					$collection[] = $this->api_services->prepare_item_for_response( $setting, $request );
				}
				$response          = array();
				$response['links'] = $this->api_services->prepare_collection_links( $request );
				$response          = $collection;
				$status_code       = 200;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to read Single Settings by setting id
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function read_single( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$params     = $request->get_params();
			$setting_id = intval( $params['id'] );
			$setting    = self::$models->mv_settings->find_one(
				array(
					'col' => 'id',
					'key' => $params['id'],
				)
			);

			if ( $setting ) {
				$setting     = self::extract( $setting );
				$response    = array();
				$response    = $this->api_services->prepare_item_for_response( $setting, $request );
				$status_code = 200;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to read Single Settings by setting slug
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function read_single_by_slug( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$params  = $request->get_params();
			$setting = self::$models->mv_settings->find_one(
				array(
					'col' => 'slug',
					'key' => $params['slug'],
				)
			);

			if ( $setting ) {
				$setting     = self::extract( $setting );
				$response    = array();
				$response    = $this->api_services->prepare_item_for_response( $setting, $request );
				$status_code = 200;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to read update Settings by setting using upsert methods
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function update( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$sanitized = $request->sanitize_params();
			$params    = $request->get_params();

			if ( is_wp_error( $sanitized ) ) {
				$status_code        = 403;
				$response['errors'] = $this->api_services->normalize_errors(
					$response['errors'], $status_code, array(
						'title'   => __( 'Unsafe Content Submission', 'mediavine' ),
						'details' => __( 'You\'re submission includes unsafe characters', 'mediavine' ),
					), 'error'
				);
				return new \WP_REST_Response( $response, $status_code );
			}

			$stored = $this->process_create( $params );

			if ( $stored ) {
				$response    = array();
				$response    = $this->api_services->prepare_item_for_response( $stored, $request );
				$status_code = 201;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to read update single Setting
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function update_single( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$params     = $request->get_params();
			$setting_id = intval( $params['id'] );
			$setting    = self::$models->mv_settings->upsert( $params );

			if ( in_array( $setting->slug, \Mediavine\Create\Plugin::$create_settings_slugs, true ) ) {
				\Mediavine\Create\Publish::add_all_to_publish_queue();
			}

			if ( $setting ) {
				$setting     = self::extract( $setting );
				$response    = array();
				$response    = $this->api_services->prepare_item_for_response( $setting, $request );
				$status_code = 200;
				return new \WP_REST_Response( $response, $status_code );
			}

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * API Function to delete single Setting by setting ID
		 *
		 * @param  \WP_REST_Request object request object via API
		 * @return \WP_REST_Response object for output as JSON data
		 */
		public function delete( \WP_REST_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$sanitized = $request->sanitize_params();
			$params    = $request->get_params();

			$setting_id = intval( $params['id'] );

			$deleted = self::$models->mv_settings->delete( $setting_id );

			if ( $deleted ) {
				$response    = array();
				$status_code = 204;
			}

			return new \WP_REST_Response( $response, $status_code );
		}

	}
}
