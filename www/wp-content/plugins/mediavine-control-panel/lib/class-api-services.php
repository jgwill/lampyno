<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\MCP\API_Services' ) ) {

	class API_Services {

		public $default_response = array(
			'errors' => array(),
		);

		public $default_status = 400;

		private static $instance = null;

		function _constructor() {
			$this->set_defaults();
		}

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->set_defaults();
			}
			return self::$instance;
		}

		function set_defaults() {
			$this->default_response['errors'][] = array(
				'id'     => 'mv-error-42',
				'status' => 400,
				'type'   => 'error',
				'title'  => __( 'Bad Request', 'mediavine' ),
				'detail' => __( 'Missing required input', 'mediavine' ),
			);
			return $this;
		}

		function normalize_errors( $errors, $status, $error_msg, $type = 'error' ) {
			$date      = new \DateTime();
			$timestamp = $date->getTimestamp();
			$error_id  = 'mv-error-' . $timestamp;

			$new_error = array(
				'id'      => $error_id,
				'status'  => $status,
				'type'    => $type,
				'title'   => __( 'Bad Request', 'mediavine' ),
				'details' => __( 'We\'re missing important information', 'mediavine' ),
			);

			if ( ! empty( $error_msg['title'] ) ) {
				$new_error['title'] = $error_msg['title'];
			}

			if ( ! empty( $error_msg['details'] ) ) {
				$new_error['details'] = $error_msg['details'];
			}

			$errors[] = $new_error;

			return $errors;
		}

		function prepare_collection_links( $request ) {
			$route  = $request->get_route();
			$params = $request->get_params();

			$links         = array();
			$links['self'] = esc_url_raw( rtrim( rest_url(), '/' ) ) . $route;
			$links['next'] = $links['self'];

			if ( is_array( $params ) ) {
				$query_string = http_build_query( $params );

				if ( ! empty( $query_string ) ) {
					$links['self'] = $links['self'] . '?' . $query_string;
				}

				$next_params = array();
				if ( ! isset( $params['page'] ) ) {
					$next_params['page'] = 2;
				}
				if ( isset( $params['page'] ) ) {
					$next_params['page'] = intval( $params['page'] ) + 1;
				}
				$next_query_string = http_build_query( $next_params );
				$links['next']     = $links['next'] . '?' . $next_query_string;
			}

			return $links;

		}

		function process_inbound( \WP_REST_Request $request ) {

			$params = $request->get_params();

			if ( ! isset( $params['data'] ) ) {
				return $params;
			}

			$simplified_array = $params['data']['attributes'];

			if ( isset( $params['data']['id'] ) ) {
				$simplified_array['id'] = $params['data']['id'];
			}

			if ( isset( $params['id'] ) ) {
				$simplified_array['id'] = $params['id'];
			}

			return $simplified_array;

		}

		function append_relationships( $item, $response_data, $relationships ) {

			$all_relationships = $relationships;

			if ( ! empty( $item->object_id ) ) {
				$item_permalink = get_the_permalink( $item->object_id );
				$post_title     = get_the_title( $item->object_id );
				$post_type      = get_post_type( $item->object_id );

				$all_relationships[ $post_type ]                        = array();
				$all_relationships[ $post_type ]['id']                  = $item->object_id;
				$all_relationships[ $post_type ]['attributes']['title'] = $post_title;
				if ( isset( $item_permalink ) ) {
					$all_relationships[ $post_type ]['links'] = array(
						'self' => $item_permalink,
					);
				}
			}

			if ( ! empty( $all_relationships ) ) {
				$response_data['relationships'] = $all_relationships;
			}

			return $response_data;
		}

		function prepare_item_for_response( $item, $request, $relationships = array() ) {
			$route         = $request->get_route();
			$response_data = array();

			$response_data['type'] = $item->type;
			$response_data['id']   = intval( $item->id );
			unset( $item->id );
			unset( $item->type );
			foreach ( $item as $key => $value ) {
				$response_data['attributes'][ $key ] = '';
				if ( $item->{$key} ) {
					$response_data['attributes'][ $key ] = $value;
				}

				// Make dates UNIX timestamps
				if ( in_array( $key, array( 'created', 'modified' ), true ) ) {
					$response_data['attributes'][ $key ] = mysql2date( 'U', $value );
				}
			}

			$response_data = $this->append_relationships( $item, $response_data, $relationships );

			if ( isset( $response_data['attributes']['instructions'] ) ) {
				$response_data['attributes']['instructions_rendered'] = do_shortcode( $response_data['attributes']['instructions'] );
			}

			if ( isset( $response_data['attributes']['notes'] ) ) {
				$response_data['attributes']['notes_rendered'] = do_shortcode( $response_data['attributes']['notes'] );
			}

			return $response_data;
		}
	}

}
