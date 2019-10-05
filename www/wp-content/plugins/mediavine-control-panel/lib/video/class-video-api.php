<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\MCP\Video' ) ) {

	class Video_API extends Video {

		function __construct() {
			$this->api_services = API_Services::get_instance();
		}

		/**
		 * Find old html tag video embeds
		 * @param  \WP_Rest_Request $request WP API Request Object
		 * @return \WP_Rest_Response         JSON API Response
		 */
		public function find_legacy_embeds( \WP_Rest_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$posts_data = \Mediavine\MCP\Video::find_legacy_video_embeds();

			$response         = array();
			$response['data'] = $posts_data;
			$status_code      = 200;

			return new \WP_REST_Response( $response, $status_code );
		}

		/**
		 * Replace Tag embeds with Shortcode
		 * @param  \WP_Rest_Request $request WP API Request Object
		 * @return \WP_Rest_Response         JSON API Response
		 */
		public function replace_legacy_embed( \WP_Rest_Request $request ) {
			$response    = $this->api_services->default_response;
			$status_code = $this->api_services->default_status;

			$sanitized = $request->sanitize_params();
			$params    = $request->get_params();

			if ( is_wp_error( $sanitized ) ) {
				$status_code        = 403;
				$response['errors'] = $this->api_services->normalize_errors(
					$response['errors'], $status_code, array(
						'title'   => __( 'Unsafe Content Submission', 'mediavine' ),
						'details' => __( 'Your submission includes unsafe characters', 'mediavine' ),
					), 'error'
				);
				return new \WP_REST_Response( $response, $status_code );
			}

			if ( empty( $params['data'] ) ) {
				$status_code        = 403;
				$response['errors'] = $this->api_services->normalize_errors(
					$response['errors'], $status_code, array(
						'title'   => __( 'No Data Provided', 'mediavine' ),
						'details' => __( 'Your submission didn\'t have any data', 'mediavine' ),
					), 'error'
				);
				return new \WP_REST_Response( $response, $status_code );
			}

			$data = $params['data'];

			$outbound = array(
				'data' => array(),
			);

			foreach ( $data as $post ) {
				$res                  = \Mediavine\MCP\Video::parse_to_shortcode( $post );
				$post['tag_replaced'] = $res;
				$outbound['data'][]   = $post;
			}

			$response    = $outbound;
			$status_code = 200;

			return new \WP_REST_Response( $response, $status_code );
		}

	}
}
