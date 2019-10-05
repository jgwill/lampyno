<?php

namespace Mediavine\Create;

use Mediavine\API_Services;


// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Products' ) ) {

	class Products_Map_API extends Products {

		public function valid_product( \WP_REST_Request $request, \WP_REST_Response $response ) {
			return $response;
		}

		public function upsert( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params      = $request->get_params();
			$creation_id = $params['id'];

			$deleted_count = Products_Map::delete_all_products_maps( $creation_id );
			$products_map  = $params['data'];

			if ( empty( $products_map ) ) {
				$data     = array();
				$response = API_Services::set_response_data( $data, $response );
				$response->set_status( 200 );
				return $response;
			}

			foreach ( $products_map as &$product_map ) {
				if ( ! isset( $product_map['product_id'] ) && isset( $product_map['id'] ) ) {
					$product_map['product_id'] = $product_map['id'];
				}

				unset( $product_map['id'] );
				unset( $product_map['type'] );

				$product_map['creation'] = $creation_id;

				// Attempt to create a new thumbnail if there isn't one
				if ( ! empty( $product_map['remote_thumbnail_uri'] ) ) {
					$product_map = static::prepare_product_thumbnail( $product_map );
				}

				if ( empty( $product_map['title'] ) ) {
					continue;
				}

				$upsert_properties = array( 'link' => $product_map['link'] );

				if ( isset( $product_map['product_id'] ) ) {
					$upsert_properties = array( 'id' => $product_map['product_id'] );
				}

				$product = self::$models_v2->mv_products->upsert(
					$product_map,
					$upsert_properties
				);

				if ( empty( $product ) ) {
					return new \WP_Error( 404, __( 'Entry Not Found', 'mediavine' ), array( 'message' => __( 'The Product could not be found', 'mediavine' ) ) );
				}

				if ( empty( $product_map['product_id'] ) ) {
					$product_map['product_id'] = $product->id;
				}

				$product_map = self::$models_v2->mv_products_map->create( $product_map );

				$product_map->thumbnail_uri = wp_get_attachment_url( $product_map->thumbnail_id );
			}

			if ( ! empty( $products_map ) ) {
				$data     = $products_map;
				$response = API_Services::set_response_data( $data, $response );
				$response->set_status( 201 );
			}

			return $response;
		}

		public function find( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$data   = array();
			$params = $request->get_params();

			$query_args = array();
			if ( isset( $response->query_args ) ) {
				$query_args = $response->query_args;
			}

			$product_maps = self::$models_v2->mv_products_map->find(
				array(
					'where' => array(
						'creation' => $params['id'],
					),
				)
			);

			usort( $product_maps, array( '\Mediavine\Create\Products_Map', 'sort_product_map' ) );

			if ( wp_is_numeric_array( $product_maps ) ) {
				foreach ( $product_maps as $product_map ) {
					$product_map->thumbnail_uri = wp_get_attachment_url( $product_map->thumbnail_id );
					$data[]                     = $product_map;
				}

				$response->set_status( 200 );
			}

			$response = API_Services::set_response_data( $data, $response );
			$response->header( 'X-Total-Items', self::$models_v2->mv_products_map->get_count( $query_args ) );

			return $response;
		}

		public function destroy( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params = $request->get_params();

			$deleted = self::$models_v2->mv_products_map->delete( $params['id'] );

			if ( ! $deleted ) {
				return new \WP_Error( 409, __( 'Entry Could Not Be Deleted', 'mediavine' ), array( 'message' => __( 'A conflict occurred and the Product Maps could not be deleted', 'mediavine' ) ) );
			}
			$data     = self::$api_services->prepare_item_for_response( $deleted, $request );
			$response = API_Services::set_response_data( $data, $response );
			$response->set_status( 204 );

			return $response;
		}
	}

}
