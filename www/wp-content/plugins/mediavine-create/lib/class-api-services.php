<?php

namespace Mediavine;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Mediavine\API_Services' ) ) {

	class API_Services {

		public $default_response = array(
			'errors' => array(),
		);

		public $default_status = 400;

		private static $instance = null;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->set_defaults();
			}
			return self::$instance;
		}

		public static function middleware( $actions = array(), \WP_REST_Request $request ) {
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

		public function permitted( \WP_REST_Request $request ) {
			$sanitized = $request->sanitize_params();
			if ( is_wp_error( $sanitized ) ) {
				return false;
			}
			return \Mediavine\Permissions::is_user_authorized();
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

		function normalize_inbound( $params ) {
			if ( ! isset( $params['data'] ) ) {
				return $params;
			}

			// Some requests won't have the attributes key, so we don't want to fail here.
			$simplified_array = $params;
			if ( isset( $params['data']['attributes'] ) ) {
				$simplified_array = $params['data']['attributes'];
			}

			if ( isset( $params['data']['id'] ) ) {
				$simplified_array['id'] = $params['data']['id'];
			}

			if ( isset( $params['id'] ) ) {
				$simplified_array['id'] = $params['id'];
			}

			if ( isset( $params['data']['type'] ) ) {
				$simplified_array['type'] = $params['data']['type'];
			}

			return $simplified_array;
		}

		function process_pagination( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params     = $request->get_params();
			$query_args = array( 'where' => array() );

			if ( ! empty( $params['limit'] ) ) {
				$limit               = sanitize_text_field( $params['limit'] );
				$query_args['limit'] = $limit;
			}

			if ( isset( $params['page'] ) ) {
				$page = intval( sanitize_text_field( $params['page'] ) );
				if ( empty( $limit ) ) {
					$limit = get_option( 'posts_per_page' );
				}
				if ( 1 < $page ) {
					$page_offset          = $limit * ( $page - 1 );
					$query_args['offset'] = $page_offset;
				}
			}

			if ( ! empty( $params['offset'] ) ) {
				$offset               = sanitize_text_field( $params['offset'] );
				$query_args['offset'] = $offset;
			}

			if ( ! empty( $params['order_by'] ) ) {
				$query_args['order_by'] = sanitize_text_field( $params['order_by'] );
			}

			if ( ! empty( $params['order'] ) ) {
				$query_args['order'] = sanitize_text_field( $params['order'] );
			}

			if ( empty( $params['order_by'] ) ) {
				$query_args['order_by'] = 'id';
			}

			$response->query_args = $query_args;

			return $response;
		}

		public static function set_response_data( $inbound_data = array(), \WP_REST_Response $response ) {
			$response_data['data'] = $inbound_data;

			if ( isset( $response->data ) ) {
				if ( isset( $response->data->data ) ) {
					$response_data = array_merge( $response_data['data'], (array) $response->data->data );
				}
				if ( isset( $response->data['data'] ) ) {
					$response_data = array_merge( (array) $response_data['data'], (array) $response->data['data'] );
				}
			}
			$response->data = $response_data;
			return $response;
		}

		function process_inbound( \WP_REST_Request $request ) {

			$params = $request->get_params();

			return $this->normalize_inbound( $params );
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

			$response_data['id'] = intval( $item->id );
			unset( $item->id );
			foreach ( $item as $key => $value ) {
				$response_data[ $key ] = '';
				if ( $item->{$key} || ( 0 === $item->{$key} ) || ( '0' === $item->{$key} ) || is_array( $item->{$key} ) ) {
					$response_data[ $key ] = $value;
				}

				// Make dates UNIX timestamps
				if ( in_array( $key, array( 'created', 'modified', 'published' ), true ) ) {
					$response_data[ $key ] = mysql2date( 'U', $value );
				}

				if ( in_array( $key, array( 'thumbnail_id' ), true ) ) {
					$response_data['thumbnail_uri'] = wp_get_attachment_url( $value );
				}

				if ( in_array( $key, array( 'author', 'category' ), true ) ) {
					$response_data[ $key ] = '';
					if ( ! empty( $value ) ) {
						$term = get_term( $value, 'category' ); // TEMP
						if ( ! empty( $term->name ) ) {
							$response_data[ $key ] = $term->name;
						}
					}
				}
			}

			$response_data = $this->append_relationships( $item, $response_data, $relationships );

			return $response_data;
		}

		function prepare_items_for_response( $items, $request, $relationships = array() ) {
			$prepared_items = [];

			foreach ( $items as $item ) {
				$prepared_items[] = $this->prepare_item_for_response( $item, $request, $relationships );
			}

			return $prepared_items;
		}

		public static function get_term_name( $term_id ) {
			$term = get_term( $term_id );
			if ( is_wp_error( $term ) ) {
				return '';
			}

			$term_name = '';
			if ( ! empty( $term->name ) ) {
				$term_name = $term->name;
			}

			return $term_name;
		}
	}
}

