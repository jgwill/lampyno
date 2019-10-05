<?php

	namespace Mediavine\Create;

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {
	class Reviews extends Plugin {

		public $review_table = 'mv_reviews';

		public $reviews_api = null;

		function init() {
			$this->reviews_api = Reviews_API::get_instance();
			$this->reviews_api->init();
			add_filter( 'allowed_http_origin', '__return_true' );
			add_action( 'rest_api_init', array( $this, 'reviews_routes' ) );
			add_action( 'the_content', array( $this, 'inject_reviews' ) );
		}

		function inject_reviews( $content ) {
			if ( ! is_single() ) {
				return $content;
			}

			return $content . '<div id="mv-recipe-reviews"></div>';
		}

		public static function get_reviews( $creation_id, $args = array() ) {
			if ( ! isset( $creation_id ) ) {
				return new \WP_Error( 'no_value', __( 'Creation ID was not set in function call', 'mediavine' ), array( 'message' => __( 'A Creation ID was not included in the request', 'mediavine' ) ) );
;
			}

			if ( ! is_numeric( $creation_id ) ) {
				return new \WP_Error( 'non_numeric', __( 'Creation ID value was not a number', 'mediavine' ), array( 'message' => __( 'A Creation ID varable was included but was non-numeric', 'mediavine' ) ) );
;
			}

			$limit  = 50;
			$offset = 0;

			if ( isset( $args['limit'] ) ) {
				$limit = $args['limit'];
			}

			if ( isset( $args['offset'] ) ) {
				$limit = $args['offset'];
			}

			$reviews = self::$models_v2->mv_reviews->find(
				array(
					'limit'  => $limit,
					'offset' => $offset,
					'where'  => array(
						'creation' => $creation_id,
					),
				)
			);

			return $reviews;
		}

		function reviews_routes() {

			$route_namespace = $this->api_route . '/' . $this->api_version;

			register_rest_route(
				$route_namespace, '/reviews', array(
					array(
						'methods'  => 'POST',
						'callback' => array( $this->reviews_api, 'create_reviews' ),
					),
					array(
						'methods'  => 'GET',
						'callback' => array( $this->reviews_api, 'read_reviews' ),
					),
				)
			);

			register_rest_route(
				$route_namespace, '/reviews/(?P<id>\d+)', array(
					array(
						'methods'             => 'GET',
						'callback'            => array( $this->reviews_api, 'read_single_review' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
					array(
						'methods'  => 'POST',
						'callback' => array( $this->reviews_api, 'update_single_review' ),
					),
					array(
						'methods'             => 'DELETE',
						'callback'            => array( $this->reviews_api, 'delete_single_review' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
				)
			);

		}

	}
}
