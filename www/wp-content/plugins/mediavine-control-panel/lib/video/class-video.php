<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\MCP\Video' ) ) {

	class Video {

		private $api_route = 'mv-video';

		private $api_version = 'v1';

		private $api = null;

		private $includes = array(
			'class-video-api.php',
		);

		/**
		 * Parse Content and Replace Embed with new Shortcode
		 * @param  string $content   a string content block, presumably post_content
		 * @param  string $slug      Slug for a Mediavine Video
		 * @param  string $shortcode The created shortcode to replace the original embed
		 * @return string            content with the tags repaced with a shortcode
		 */
		public static function replace_embed( $content, $slug, $shortcode ) {

			$re = '/&lt;div id="' . $slug . '".*?\s?\n?.*?&lt;\/script&gt;/Um';

			preg_match_all( $re, $content, $matches, PREG_SET_ORDER, 0 );
			if ( isset( $matches[0] ) ) {
				foreach ( $matches[0] as $match ) {
					$content = preg_replace( $re, $shortcode, $content );
				}
			}

			$re = '/<div id="' . $slug . '".*?\s?\n?.*?<\/script>/Um';

			preg_match_all( $re, $content, $matches, PREG_SET_ORDER, 0 );

			if ( isset( $matches[0] ) ) {
				foreach ( $matches[0] as $match ) {
					$content = preg_replace( $re, $shortcode, $content );
				}
			}
			$re = '/<script[^>]+mediavine.com\/videos\/' . $slug . '.*?<\/script>/Um';

			preg_match_all( $re, $content, $matches, PREG_SET_ORDER, 0 );

			if ( isset( $matches[0] ) ) {
				foreach ( $matches[0] as $match ) {
					$content = preg_replace( $re, $shortcode, $content );
				}
			}

			return $content;
		}

		/**
		 * SQL Query to Find Embeds using HTML and Script tags
		 * @param  [type] $params [description]
		 * @return [type]         [description]
		 */
		public static function find_legacy_video_embeds( $params = null ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'posts';
			$video_url  = $wpdb->esc_like( '//video.mediavine.com/videos' );
			$video_url  = '%' . $video_url . '%';
			$script_url = $wpdb->esc_like( '//scripts.mediavine.com/videos' );
			$script_url = '%' . $script_url . '%';
			// @codingStandardsIgnoreStart
			$video_posts = $wpdb->get_results( $wpdb->prepare( "SELECT id, post_title AS title, post_type as type FROM {$table_name} WHERE (post_type NOT IN ('revision', 'attachment', 'nav_menu_item') AND ( (post_content LIKE %s) OR (post_content LIKE %s) ) )", array( $video_url, $script_url ) ) );
			// @codingStandardsIgnoreEnd
			return $video_posts;
		}

		/**
		 * Parse Tag Embeds to Shortcodes
		 * @param  array $data array of api data including id, title, type
		 * @return boolean     true if succesffully replaced
		 */
		public static function parse_to_shortcode( $data ) {
			$post = get_post( $data['id'] );

			if ( empty( $post ) ) {
				return false;
			}

			$content          = $post->post_content;
			$video_in_content = true;

			while ( $video_in_content ) {
				$get_embed = '/&lt;div id=".{20}".*?\s?\n?.*?&lt;\/script&gt;/Um';
				preg_match( $get_embed, $content, $embed_match, PREG_OFFSET_CAPTURE, 0 );

				if ( isset( $embed_match[0][0] ) ) {
					$parts = '/\.mediavine.com\/videos\/(?P<slug>\S+)\.js|data-ratio="(?P<ratio>\S+)"|data-sticky="(?P<sticky>\S+)"|data-volume="(?P<volume>\S+)"/mU';

					preg_match_all( $parts, $embed_match[0][0], $matches, PREG_SET_ORDER, 0 );

					if ( empty( $matches ) ) {
						return false;
					}

					$attributes = array();
					$slug       = null;
					foreach ( $matches as $match ) {
						if ( ! empty( $match['ratio'] ) ) {
							$attributes[] = 'aspectRatio="' . $match['ratio'] . '"';
						}
						if ( ! empty( $match['slug'] ) ) {
							$slug         = $match['slug'];
							$attributes[] = 'key="' . $match['slug'] . '"';
						}
						if ( ! empty( $match['volume'] ) ) {
							$attributes[] = 'volume="' . $match['volume'] . '"';
						}
						if ( ! empty( $match['sticky'] ) ) {
							$attributes[] = 'sticky="true"';
						}
					}

					if ( $slug ) {
						$shortcode = '[mv_video ' . implode( ' ', $attributes ) . ']';
						$content   = self::replace_embed( $content, $slug, $shortcode );
					} else {
						$video_in_content = false;
					}
				} else {
					$video_in_content = false;
				}
			}

			$video_in_content = true;
			while ( $video_in_content ) {
				$get_embed = '/<div id=".{20}".*?\s?\n?.*?<\/script>/Um';
				preg_match( $get_embed, $content, $embed_match, PREG_OFFSET_CAPTURE, 0 );

				if ( isset( $embed_match[0][0] ) ) {
					$parts = '/\.mediavine.com\/videos\/(?P<slug>\S+)\.js|data-ratio="(?P<ratio>\S+)"|data-sticky="(?P<sticky>\S+)"/mU';

					preg_match_all( $parts, $embed_match[0][0], $matches, PREG_SET_ORDER, 0 );

					if ( empty( $matches ) ) {
						return false;
					}

					$attributes = array();
					$slug       = null;
					foreach ( $matches as $match ) {
						if ( ! empty( $match['ratio'] ) ) {
							$attributes[] = 'aspectRatio="' . $match['ratio'] . '"';
						}
						if ( ! empty( $match['slug'] ) ) {
							$slug         = $match['slug'];
							$attributes[] = 'key="' . $match['slug'] . '"';
						}
						if ( ! empty( $match['sticky'] ) ) {
							$attributes[] = 'sticky="true"';
						}
					}

					if ( $slug ) {
						$shortcode = '[mv_video ' . implode( ' ', $attributes ) . ']';
						$content   = self::replace_embed( $content, $slug, $shortcode );
					} else {
						$video_in_content = false;
					}
				} else {
					$video_in_content = false;
				}
			}

			$video_in_content = true;
			while ( $video_in_content ) {
				$get_embed = '/<script[^>]+mediavine.com\/videos\/([^\.]+).*?<\/script>/';
				preg_match( $get_embed, $content, $embed_match );

				if ( isset( $embed_match ) ) {
					$slug         = $embed_match[1];
					$attributes[] = 'key="' . $slug . '"';
					$shortcode    = '[mv_video ' . implode( ' ', $attributes ) . ']';
					$content      = self::replace_embed( $content, $slug, $shortcode );
				}
				$video_in_content = false;
			}

			$post->post_content = $content;

			$updated_post = wp_update_post( $post );

			if ( $updated_post ) {
				return true;
			}
			return false;

		}

		private function load_dependencies() {
			foreach ( $this->includes as $file ) {
				$filepath = plugin_dir_path( __FILE__ ) . $file;
				if ( ! $filepath ) {
					triggor_error( sprintf( 'Error location %s for inclusion', $file ), E_USER_ERROR );
				}
				require_once $filepath;
			}
		}

		/**
		 * Adds async to enqueued mv_video tags
		 * @param  string  $tag  script tag to be outputted
		 * @param  string  $handle  enqueue handle that's defined in enqueue
		 * @return string  script tag to be outputted
		 */
		function add_async_attribute( $tag, $handle ) {
			$prefix = 'mv_video_';
			if ( substr( $handle, 0, strlen( $prefix ) ) === $prefix ) {
				return str_replace( ' src', ' async data-noptimize src', $tag );
			}

			return $tag;
		}

		/**
		 * Create the markup for embedded Mediavine Videos
		 * @param  array $settings contains necessary variables for creation of embed
		 * @return string          HTML to render div and script tag for Mediavine Videos
		 */
		function script_embed_template( $settings ) {
			if ( empty( $settings['key'] ) ) {
				return '';
			}

			if ( is_search() && function_exists( 'relevanssi_init' ) ) {
				return '';
			}

			$script_uri = '//video.mediavine.com/videos/' . $settings['key'] . '.js';
			wp_enqueue_script( 'mv_video_' . $settings['key'], $script_uri, array(), \MV_Control_Panel::VERSION, true );

			return '<div id="' . $settings['key'] . '" class="mediavine-video__target" ' . $settings['ratio'] . ' ' . $settings['volume'] . ' ' . $settings['sticky'] . ' ' . $settings['disable_optimize'] . ' ' . $settings['disable_autoplay'] . '></div>';
		}

		/**
		 * Render markup via shortcode to display Mediavine Videos
		 * @param  array $attributes Attributes from post shortcode
		 * @return string            HTML to render div and script tag for Mediavine Videos
		 */
		function video_script_shortcode( $attributes ) {
			if ( is_admin() ) {
				return '';
			}

			if ( empty( $attributes['key'] ) ) {
				return '';
			}

			// Normalize sticky attribute because we aren't actually setting anything on sticky
			$flipped_attributes = array_unique( array_flip( $attributes ) );
			if ( isset( $flipped_attributes['sticky'] ) ) {
				$attributes['sticky'] = 'true';
			}

			if ( isset( $flipped_attributes['donotoptimizeplacement'] ) ) {
				$attributes['donotoptimizeplacement'] = 'true';
			}

			if ( isset( $flipped_attributes['donotautoplaynoroptimizeplacement'] ) ) {
				$attributes['donotautoplaynoroptimizeplacement'] = 'true';
			}

			$settings = array(
				'disable_optimize' => '',
				'disable_autoplay' => '',
				'sticky'           => '',
				'ratio'            => '',
				'volume'           => 'data-volume="70"',
			);

			if ( isset( $attributes['key'] ) ) {
				$settings['key'] = $attributes['key'];
			}

			if ( isset( $attributes['sticky'] ) && ( 'true' === $attributes['sticky'] ) ) {
				$settings['sticky']           = 'data-sticky="1" data-autoplay="1"';
				$settings['disable_optimize'] = 'data-disable-optimize="1"';
			}

			if ( isset( $attributes['donotoptimizeplacement'] ) && ( 'true' === $attributes['donotoptimizeplacement'] ) ) {
				$settings['disable_optimize'] = 'data-disable-optimize="1"';
			}

			if ( isset( $attributes['donotautoplaynoroptimizeplacement'] ) && ( 'true' === $attributes['donotautoplaynoroptimizeplacement'] ) ) {
				$settings['disable_optimize'] = 'data-disable-optimize="1"';
				$settings['disable_autoplay'] = 'data-disable-autoplay="1"';
			}

			$allowed_aspect_ratios = array(
				'16:9',
				'4:3',
				'1:1',
				'3:4',
				'9:16',
			);

			if ( isset( $attributes['aspectratio'] ) ) {
				if ( in_array( $attributes['aspectratio'], $allowed_aspect_ratios, true ) ) {
					$settings['ratio'] = 'data-ratio="' . $attributes['aspectratio'] . '"';
				}
			}

			if ( isset( $attributes['volume'] ) ) {
				$settings['volume'] = 'data-volume="' . $attributes['volume'] . '"';
			}

			$template = $this->script_embed_template( $settings );

			$allowed_html = array(
				'div' => array(
					'id'                        => array(),
					'data-value'                => array(),
					'data-sticky'               => array(),
					'data-autoplay'             => array(),
					'data-ratio'                => array(),
					'data-volume'               => array(),
					'data-disable-auto-upgrade' => array(),
					'data-disable-optimize'     => array(),
					'data-disable-autoplay'     => array(),
				),
			);

			return wp_kses( $template, $allowed_html );
		}

		/**
		 * Link functions to WP Lifecycle
		 * @return null No return initialization function
		 */
		function init() {

			$this->load_dependencies();

			$this->api = new Video_API();

			add_filter( 'script_loader_tag', array( $this, 'add_async_attribute' ), 10, 2 );
			add_shortcode( 'mv_video', array( $this, 'video_script_shortcode' ) );
			add_action( 'rest_api_init', array( $this, 'routes' ) );
		}

		/**
		 * Create Routes for Settings API
		 *
		 * @return none
		 */
		function routes() {
			$route_namespace = $this->api_route . '/' . $this->api_version;

			register_rest_route(
				$route_namespace, '/videos/find-tags', array(
					'methods'             => 'GET',
					'callback'            => array( $this->api, 'find_legacy_embeds' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				)
			);

			register_rest_route(
				$route_namespace, '/videos/replace-tags', array(
					'methods'             => 'POST',
					'callback'            => array( $this->api, 'replace_legacy_embed' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				)
			);
		}

	}

}
