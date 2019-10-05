<?php

namespace Mediavine\Create;

use Mediavine\API_Services;
use \WP_REST_Request as Request;
use \WP_REST_Response as Response;
use Mediavine\WordPress\Support\Arr;


// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Products' ) ) {

	class Products_API extends Products {

		public function valid_product( \WP_REST_Request $request, \WP_REST_Response $response ) {
			return $response;
		}

		public function upsert( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$product          = $request->get_params();
			$result           = null;
			$or_statement     = array();
			$fields_to_update = [
				'id',
				'created',
				'modified',
				'title',
				'link',
				'thumbnail_id',
				'remote_thumbnail_uri',
			];
			$product          = Arr::only( $product['data'], $fields_to_update );

			// Attempt to create a new thumbnail if there isn't one
			if ( ! empty( $product['remote_thumbnail_uri'] ) ) {
				$product = static::prepare_product_thumbnail( $product );
			}

			$result = array();
			if ( ! empty( $product['id'] ) ) {
				// Check for id in params
				$found_product = self::$models_v2->mv_products->find_one( $product['id'] );

				if ( $found_product ) {
					// If id exists, update
					$result = self::$models_v2->mv_products->update(
						$product
					);
				}
			}

			if ( ! $result && ! empty( $product['link'] ) ) {
				// If not, check for product with same link
				// If exists, return
				$result = self::$models_v2->mv_products->find_one(
					array(
						'where' => array(
							'link' => $product['link'],
						),
					)
				);
			}

			// If not, create
			if ( empty( $result ) ) {
				$result = self::$models_v2->mv_products->create( $product );
			}

			if ( empty( $result ) ) {
				return new \WP_Error( 404, __( 'Entry Not Found', 'mediavine' ), array( 'message' => __( 'The Product could not be found', 'mediavine' ) ) );
			}
			$data     = self::$api_services->prepare_item_for_response( $result, $request );
			$response = API_Services::set_response_data( $data, $response );
			$response->set_status( 201 );

			return $response;
		}

		public function find( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$allowed_params = array(
				'title',
			);
			$params         = $request->get_params();
			$query_args     = array();
			if ( isset( $response->query_args ) ) {
				$query_args = $response->query_args;
			}

			$query_args['where'] = array();

			if ( isset( $params['search'] ) ) {
				$query_args['where']['title'] = $params['search'];
			}

			if ( ! empty( $params ) ) {
				foreach ( $params as $param => $value ) {
					if ( in_array( $param, $allowed_params, true ) ) {
						$query_args['where'][ $param ] = $value;
					}
				}
			}

			$products = self::$models_v2->mv_products->find( $query_args );

			if ( wp_is_numeric_array( $products ) ) {
				$data = array();
				foreach ( $products as $product ) {
					$product->thumbnail_uri = wp_get_attachment_url( $product->thumbnail_id );
					$product->creations     = Products::get_product_creations( $product->id );
					$data[]                 = self::$api_services->prepare_item_for_response( $product, $request );
				}

				$response->set_status( 200 );
			}
			$response = API_Services::set_response_data( $data, $response );
			$response->header( 'X-Total-Items', self::$models_v2->mv_products->get_count( $query_args ) );
			return $response;
		}

		public function find_one( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params  = $request->get_params();
			$product = self::$models_v2->mv_products->find_one( $params['id'] );

			if ( empty( $product ) ) {
				return new \WP_Error( 404, __( 'Entry Not Found', 'mediavine' ), array( 'message' => __( 'The Product could not be found', 'mediavine' ) ) );
			}
			if ( isset( $product->thumbnail_id ) ) {
				$product->thumbnail_uri = wp_get_attachment_url( $product->thumbnail_id );
			}
			$product->creations = Products::get_product_creations( $product->id );

			$data     = self::$api_services->prepare_item_for_response( $product, $request );
			$response = API_Services::set_response_data( $data, $response );
			$response->set_status( 200 );

			return $response;
		}

		/**
		 * Get pagination details for products neighboring given product.
		 *
		 * @param Request $request
		 * @param Response $response
		 * @return Response $response
		 */
		public function get_pagination_links( Request $request, Response $response ) {
			$product = $response->get_data()['data'];

			$product['links'] = Paginator::make_links( 'mv_products', [ 'id', 'object_id', 'title' ], $product['id'] );

			return API_Services::set_response_data( $product, $response );
		}

		public function scrape( \WP_REST_Request $request, \WP_REST_Response $response ) {

			$params = $request->get_params();
			$link   = $params['link'];

			$results = self::$models_v2->mv_products->find_one(
				array(
					'where' => array(
						'link' => $link,
					),
				)
			);

			// If the result doesn't exist or doesn't have a thumbnail, we make a fresh attempt.
			if ( ! $results || empty( $results->thumbnail_id ) ) {
				$scraper = new \Mediavine\Create\LinkScraper;
				$results = $scraper->scrape( $link );
			}

			if ( ! $results ) {
				return new \WP_Error( 404, __( 'No Data Found', 'mediavine' ), array( 'message' => __( 'The Product link scrape did not turn up any results', 'mediavine' ) ) );
			}
			if ( isset( $results->thumbnail_id ) && empty( $results->thumbnail_uri ) ) {
				$results->thumbnail_uri = wp_get_attachment_url( $results->thumbnail_id );
			}
			$response = API_Services::set_response_data( $results, $response );
			$response->set_status( 200 );

			return $response;
		}

		public function destroy( \WP_REST_Request $request, \WP_REST_Response $response ) {
			$params = $request->get_params();

			$deleted      = self::$models_v2->mv_products->delete( $params['id'] );
			$deleted_maps = self::$models_v2->mv_products_map->delete(
				array(
					'where' => array(
						'product_id' => $params['id'],
					),
				)
			);

			if ( ! $deleted ) {
				return new \WP_Error( 409, __( 'Entry Could Not Be Deleted', 'mediavine' ), array( 'message' => __( 'A conflict occurred and the Product could not be deleted', 'mediavine' ) ) );
			}
			$data     = self::$api_services->prepare_item_for_response( $deleted, $request );
			$response = API_Services::set_response_data( $data, $response );
			$response->set_status( 204 );

			return $response;
		}
	}

}
