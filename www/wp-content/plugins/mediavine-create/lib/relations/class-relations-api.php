<?php

namespace Mediavine\Create;

use Mediavine\API_Services;
use Mediavine\MV_DBI;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Supplies' ) ) {

	class Relations_API extends Creations {

		public function content_search( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$sanitized = $request->sanitize_params();

			if ( is_wp_error( $sanitized ) ) {
				return new \WP_Error( 'Missing Required Field', __( 'Unsafe Data', 'mediavine' ) );
			}

			$params = $request->get_params();

			if ( empty( $params['search'] ) ) {
				return new \WP_Error( 'Missing Required Field', __( 'Missing required field Search', 'mediavine' ) );
			}

			global $wpdb;

			$query_args = array(
				'where' => array(),
				'limit' => 1000,
			);

			$creation_search = array();

			$search_term = $params['search'];

			if ( isset( $params['search'] ) ) {
				$creation_search['published'] = $params['search'];
				$query_args['select']         = array( 'id', 'id as relation_id', 'canonical_post_id', 'description', 'title', "'card' AS content_type", 'type AS secondary_type', 'thumbnail_id' );
			}
			$statement = "SELECT id, id as canonical_post_id, id as relation_id, post_title as title, 'post' as content_type, post_type as secondary_type FROM $wpdb->posts WHERE post_title LIKE '%%%s%%' AND post_status = 'publish' AND post_type IN ('post', 'page')";

			if ( isset( $params['all'] ) ) {
				$search_term = array(
					$search_term,
					$search_term,
				);
				$statement   = "SELECT id, id as canonical_post_id, id as relation_id, post_title as title, 'post' as content_type FROM $wpdb->posts WHERE (post_title LIKE '%%%s%%' OR post_content LIKE '%%%s%%') AND post_status = 'publish' AND post_type IN ('post', 'page')";
			}

			$prepared = $wpdb->prepare( $statement, $search_term );

			$results = $wpdb->get_results( $prepared );

			foreach ( $results as &$post ) {
				$post->thumbnail_id  = get_post_thumbnail_id( $post->id );
				$post->thumbnail_uri = wp_get_attachment_url( $post->thumbnail_id );
			}

			$creations = self::$models_v2->mv_creations->find( $query_args, $creation_search );

			foreach ( $creations as &$creation ) {
				$creation->thumbnail_uri = wp_get_attachment_url( $creation->thumbnail_id );
			}

			$response = API_Services::set_response_data(
				array(
					'creations' => $creations,
					'posts'     => $results,
				), $response
			);

			$response->set_status( 200 );

			return $response;
		}

		public function read_creation_relations( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params = $request->get_params();
			$data   = array();

			if ( isset( $params['id'] ) ) {
				$data = Relations::get_creation_relations( $params['id'] );
			}

			if ( ! wp_is_numeric_array( $data ) ) {
				return new \WP_Error( 404, __( 'No Entries Found', 'mediavine' ), array( 'message' => __( 'No relations were found for the given Creation', 'mediavine' ) ) );
			}
			foreach ( $data as &$relation ) {
				$relation = self::$api_services->prepare_item_for_response( $relation, $request );
			}
			$response = API_Services::set_response_data( $data, $response );
			$response->set_status( 200 );

			return $response;
		}

		public function set_relations( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params      = $request->get_params();
			$creation_id = $params['id'];
			$type        = $params['type'];

			$deleted = Relations::delete_all_relations( $creation_id, $type );

			$data = $params['data'];

			if ( ! wp_is_numeric_array( $data ) ) {
				return $response;
			}

			$relations = [];
			foreach ( $data as &$relation ) {
				$relation['creation'] = $creation_id;
				$relation['type']     = $type;
				if ( isset( $relation['thumbnail_uri'] ) && empty( $relation['thumbnail_id'] ) ) {
					$relation['thumbnail_id'] = \Mediavine\Images::get_attachment_id_from_url( $relation['thumbnail_uri'] );
				}
				$relations[] = $relation;
			}
			self::$models_v2->mv_relations->create_many( $relations );
			$relations = Relations::get_creation_relations( $creation_id );
			$relations = self::$api_services->prepare_items_for_response( $relations, $request );

			$response = API_Services::set_response_data( $relations, $response );
			$response->set_status( 201 );
			return $response;
		}

	}

}
