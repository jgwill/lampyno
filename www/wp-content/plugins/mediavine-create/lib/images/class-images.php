<?php

namespace Mediavine;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\Images' ) ) {

	class Images {

		const DB_VERSION = '0.1.0';

		public $api_route = 'mv-images';

		public $api_version = 'v1';

		public static $api_services = null;

		public static $models = null;

		public $images_table = 'mv_images';

		public $images_api = null;

		public $images_models = null;

		public $images_views = null;

		private $includes = array(
			'class-images-api.php',
			'class-images-models.php',
		);

		/**
		 * Get size information for all currently-registered image sizes.
		 *
		 * @global $_wp_additional_image_sizes
		 * @uses   get_intermediate_image_sizes()
		 * @return array $sizes Data for all currently-registered image sizes.
		 */
		public static function get_image_sizes( $image_sizes = null ) {
			global $_wp_additional_image_sizes;
			$sizes = array();
			if ( empty( $image_sizes ) ) {
				$image_sizes = get_intermediate_image_sizes();
			}
			foreach ( $image_sizes as $_size ) {
				if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large', 'full' ), true ) ) {
					$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
					$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
					$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
				} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
					$sizes[ $_size ] = array(
						'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
						'height' => $_wp_additional_image_sizes[ $_size ]['height'],
						'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
					);
				}
			}
			return $sizes;
		}

		/**
		 * Generates all image sizes of an image uploaded to media
		 *
		 * Image sizes can be filtered with mv_intermediate_image_sizes_advanced
		 *
		 * @param  int|string $image_id Attachment ID of the thumbail
		 * @param  array  List of image sizes
		 * @return array      Generated attachment metadata including new sizes
		 */
		public static function generate_intermediate_sizes( $image_id, array $img_sizes = array() ) {
			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				include( ABSPATH . 'wp-admin/includes/image.php' );
			}

			$original_attach_data = wp_get_attachment_metadata( $image_id );

			/**
			 * Filters to return early from generate_intermediate_sizes
			 *
			 * We have found some servers have issues with the core `wp_generate_attachment_metadata` function
			 *
			 * @param bool $$return early True to return early
			 */
			$return_early = apply_filters( 'mv_generate_intermediate_sizes_return_early', false );
			if ( $return_early ) {
				return $original_attach_data;
			}

			/**
			 * TODO: add Sentry reporting
			 */
			if ( 'array' !== gettype( $original_attach_data ) ) {
				return false;
			}

			// Filter out currently existing sizes
			if ( ! empty( $original_attach_data['sizes'] ) ) {
				foreach ( $img_sizes as $img_size => $img_meta ) {
					if ( 'mv_create_16x9_medium_res' === $img_size ) {
						if ( // We're not sure if WordPress sometimes saves as strings and other times as integers...
							! empty( $original_attach_data['sizes'][ $img_size ]['height'] ) &&
							(
								'240' === $original_attach_data['sizes'][ $img_size ]['height'] ||
								240 === $original_attach_data['sizes'][ $img_size ]['height']
							)
						) {
							continue;
						}
					}
					if ( ! empty( $original_attach_data['sizes'][ $img_size ] ) ) {
						unset( $img_sizes[ $img_size ] );
					}
				}
			}

			$img_sizes = apply_filters( 'mv_intermediate_image_sizes_advanced', $img_sizes, $image_id );

			// Only generate sizes we want
			add_filter(
				'intermediate_image_sizes_advanced', function() use ( $img_sizes ) {
					return $img_sizes;
				}
			);

			$attached_file = get_attached_file( $image_id );

			// No file found, so we will just return the current data
			if ( ! empty( $attached_file ) && 'string' !== gettype( $attached_file ) ) {
				return $original_attach_data;
			}

			$new_attach_data = wp_generate_attachment_metadata( $image_id, $attached_file );

			// Merge to original attach data so we don't lose other image sizes or metadata
			if ( ! empty( $new_attach_data['sizes'] ) ) {
				if ( ! empty( $original_attach_data['sizes'] ) ) {
					$original_attach_data['sizes'] = array_merge( $original_attach_data['sizes'], $new_attach_data['sizes'] );
				} else {
					$original_attach_data['sizes'] = $new_attach_data['sizes'];
				}
			}

			$new_meta = wp_update_attachment_metadata( $image_id, $original_attach_data );

			return $new_meta;
		}

		/**
		 * @param  array
		 * @return array with additional values
		 */
		public static function prep_image( $params ) {
			if ( ! empty( $params['object_id'] ) ) {
				if ( empty( $params['image_size'] ) ) {
					$params['image_size'] = 'full';
				}

				$image_meta = wp_get_attachment_metadata( $params['object_id'] );
				$image_data = wp_get_attachment_image_src( $params['object_id'], $params['image_size'] );
				$image_full = wp_get_attachment_image_src( $params['object_id'], 'full' );

				$params['image_url']           = $image_data[0];
				$params['image_url_full_size'] = $image_full[0];
				$params['image_srcset']        = ''; // wpdb:insert won't insert NULL
				$params['image_srcset_sizes']  = ''; // wpdb:insert won't insert NULL

				if ( is_array( $image_meta ) ) {
					$size_array   = array( $image_data[1], $image_data[2] );
					$srcset       = wp_calculate_image_srcset( $size_array, $image_data[0], $image_meta, $params['object_id'] );
					$srcset_sizes = wp_calculate_image_sizes( $size_array, $image_data[0], $image_meta, $params['object_id'] );

					if ( $srcset && $srcset_sizes ) {
						$params['image_srcset']       = $srcset;
						$params['image_srcset_sizes'] = $srcset_sizes;
					}
				}
			}

			return $params;
		}

		/**
		 * Returns HTML image with srcset data
		 *
		 * @param  array|string $image Image array with 'image_url', 'image_srcset'
		 *                      (optional), and 'image_srcset_sizes' (optional).
		 *                      String also accepted with just image URL.
		 * @param  string $image_class class name for image tag
		 * @return string HTML <img> tag
		 */
		public static function mv_image_tag( $image, $image_meta, $image_alt_text = null ) {
			$img_tag    = null;
			$img_url    = null;
			$img_class  = null;
			$srcset     = null;
			$pinterest  = null;
			$attributes = ' ';

			if ( is_string( $image ) ) {
				$img_url = esc_url( $image );
			}

			if ( is_array( $image ) ) {
				if ( ! empty( $image['image_url'] ) ) {
					$img_url = esc_url( $image['image_url'] );
				}
				if ( ! empty( $image['image_srcset'] ) && ! empty( $image['image_srcset_sizes'] ) ) {
					$srcset = ' srcset="' . $image['image_srcset'] . '" sizes="' . $image['image_srcset_sizes'] . '"';
				}
			}

			if ( ! empty( $image_meta['class'] ) ) {
				$img_class = ' class="' . $image_meta['class'] . '"';
			}

			if ( 'mv_create_vert' !== $image['image_size'] ) {
				$attributes .= 'data-pin-nopin="true" ';
			}

			if ( ! empty( $image_alt_text ) ) {
				$attributes .= 'alt="' . $image_alt_text . '" ';
			}

			// Full resolution image for pinterest
			if ( ! empty( $image['image_url_full_size'] ) && $image['image_url_full_size'] !== $img_url ) {
				$pinterest = ' data-pin-media="' . $image['image_url_full_size'] . '"';
			}

			if ( ! empty( $img_url ) ) {
				$img_tag = '<img src="' . $img_url . '"' . $img_class . $attributes . $srcset . $pinterest . '>';
			}

			return $img_tag;
		}

		public static function is_image_correct_dimensions( $img_id, $img_size ) {
			$img_meta  = wp_get_attachment_image_src( $img_id, $img_size );
			$size_meta = self::get_image_sizes( array( $img_size ) );

			if ( is_array( $img_meta ) && is_array( $size_meta )
				&& ! empty( $size_meta[ $img_size ] )
				&& $img_meta[1] >= $size_meta[ $img_size ]['width']
				&& $img_meta[2] >= $size_meta[ $img_size ]['height']
			) {
				return true;
			}
			return false;
		}

		/**
		 * Finds the highest available resolution with the correct ratio
		 *
		 * @param   int     $img_id           Image ID
		 * @param   string  $img_size         Un-suffixed size resolution to test against
		 * @param   array   $available_sizes  (Optional) List of sizes to test against
		 * @return  string                    Highest possible resolution image size
		 */
		public static function get_highest_available_image_size( $img_id, $img_size, $available_sizes = null ) {
			$prefix      = $img_size;
			$image_sizes = self::get_image_sizes();
			$resolutions = apply_filters(
				'mv_create_image_resolutions', array(
					'_medium_res',
					'_medium_high_res',
					'_high_res',
				)
			);

			foreach ( $image_sizes as $size => $size_meta ) {
				foreach ( $resolutions as $resolution ) {
					if ( is_array( $available_sizes ) ) {
						// Don't check images that aren't available
						if ( empty( $available_sizes[ $prefix . $resolution ] ) ) {
							continue;
						}
					}
					if ( $size === $prefix . $resolution ) {
						$is_bigger_size = \Mediavine\Images::is_image_correct_dimensions( $img_id, $size );
						if ( $is_bigger_size ) {
							$img_size = $size;
						}
					}
				}
			}

			return $img_size;
		}

		/**
		 * Checks that Create sizes exist for ID and generates if they don't
		 *
		 * This only checks for the lowest size image (mv_create_1x1) so that smaller
		 * images aren't continuously rebuilt. Images smaller than that size will
		 * unfortunately have to deal with the performance hit, but should be rare
		 *
		 * @param int|string $image_id ID of the image to check
		 * @param array $create_image_sizes Sizes to be generated if they exist
		 * @param boolean $return Return the $image_meta
		 * @return array|void Image meta if $return is true
		 */
		public static function check_image_size( $image_id, $create_image_sizes = array(), $return = false ) {
			$image_sizes = self::get_image_sizes();

			// We will check for our 1x1 image, but in the case it's been filtered out, we return
			if ( empty( $image_sizes['mv_create_1x1'] ) ) {
				return;
			}

			$image_meta = wp_get_attachment_image_src( $image_id, 'mv_create_1x1' );

			// Check given image with correct size and return true if correct
			if (
				! empty( $image_meta ) &&
				$image_sizes['mv_create_1x1']['width'] === $image_meta[1] &&
				$image_sizes['mv_create_1x1']['height'] === $image_meta[2]
			) {
				if ( $return ) {
					return $image_meta;
				}

				return;
			}

			// Generate image sizes
			self::generate_intermediate_sizes( $image_id, $create_image_sizes );

			if ( $return ) {
				$image_meta = wp_get_attachment_image_src( $image_id, 'mv_create_1x1' );

				return $image_meta;
			}

			return;
		}

		public static function download_image_from_url( $img_src ) {

			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				include( ABSPATH . 'wp-admin/includes/image.php' );
			}
			$origin = $img_src;

			// Fetch image data
			$img_response = wp_remote_get( $img_src );
			if ( is_wp_error( $img_response ) ) {
				// Handle error
				return false;
			}

			if ( ! isset( $img_response['body'] ) ) {
				return false;
			}

			$img_data   = $img_response['body'];
			$img_name   = basename( $img_src );
			$upload_dir = wp_upload_dir();
			$path       = null;
			// Save as WP attachment
			// Check folder permission and define file location
			if ( wp_mkdir_p( $upload_dir['path'] ) ) {
				$path = $upload_dir['path'] . '/';
			} else {
				$path = $upload_dir['basedir'] . '/';
			}

			$unique_filename = wp_unique_filename( $path, $img_name );
			$filename        = basename( $unique_filename );

			// Check image file type
			$wp_filetype = wp_check_filetype( $filename, null );
			$type        = $wp_filetype['type'] ? '' : '.jpg';
			$file        = $path . $filename . $type;
			file_put_contents( $file, $img_data );

			$attachment = array(
				'post_mime_type' => $wp_filetype['type'] ? $wp_filetype['type'] : 'image/jpeg',
				'post_title'     => sanitize_file_name( $filename ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			// Create the attachment
			$attach_id = wp_insert_attachment( $attachment, $file );

			if ( 0 === $attach_id ) {
				return null;
			}

			update_post_meta( $attach_id, 'origin_uri', $origin );
			// Define attachment metadata
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			$update_data = wp_update_attachment_metadata( $attach_id, $attach_data );

			return $attach_id;
		}

		/**
		 * Given an image URL, return thumbnail id. Fetches based on the following strategy:
		 * - Check for existing image with http, then https
		 * - Fetch external image based on url
		 * - Fetch external image based on url prepended with https
		 * - Fetch external image based on url prepended with http
		 * - Return 0 (image does not exist)
		 *
		 * @param  string $url String url that should reference and image
		 * @return number Attachment id
		 */
		public static function get_attachment_id_from_url( $url ) {

			$attachment_id = null;

			if ( ! $url ) {
				return $attachment_id;
			}

			$postmeta = new \Mediavine\MV_DBI( 'postmeta' );
			$result   = $postmeta->find_one(
				array(
					'col' => 'meta_value',
					'key' => $url,
				)
			);

			if ( isset( $result->post_id ) ) {
				return $result->post_id;
			}

			$posts_model = new \Mediavine\MV_DBI( 'posts' );

			$stripped       = explode( '//', $url );
			$protocol       = $stripped[0];
			$uri            = $stripped[1];
			$attachment_url = $protocol . '//' . $uri;

			// Get the upload directory paths
			$upload_dir_paths = wp_upload_dir();

			// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
			if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

				// Strip the thumbnail dimensions from the url
				$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

				// Find the attachment post by guid
				$local_attachment = $posts_model->find_one(
					array(
						'col' => 'guid',
						'key' => $attachment_url,
					)
				);

				if ( ! empty( $local_attachment ) ) {
					return $local_attachment->ID;
				}
			}

			// If that failed, try downloading the image from the original $url
			$attachment_id_from_url = self::download_image_from_url( $url );

			if ( $attachment_id_from_url ) {
				return $attachment_id_from_url;
			}

			// Still failed? Wow. Try from the formatted $attachment_url
			$attachment_id_from_url = self::download_image_from_url( $attachment_url );

			if ( $attachment_id_from_url ) {
				return $attachment_id_from_url;
			}

			// Oh well, return 0
			return $attachment_id;
		}

		function init() {
			$this->load_dependencies();

			$this->images_api = new Images_API();
			$this->images_api->init();

			$this->images_models = new Images_Models();
			$this->images_models->init();

			self::$api_services = API_Services::get_instance();

			self::$models             = new Models();
			self::$models->{'images'} = new MV_DBI( $this->images_table );

			add_action( 'edit_attachment', array( $this, 'updated_image' ) );
			add_action( 'rest_api_init', array( $this, 'images_routes' ) );
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

		public function updated_image( $image_id ) {
			$args          = array(
				'limit' => 500, // Should never reach this, but will prevent a timeout
				'where' => array(
					'object_id' => intval( $image_id ),
				),
			);
			$affected_rows = self::$models->images->find( $args );

			// TODO: Create update in bulk method in ORM
			foreach ( $affected_rows as $row ) {
				$updated_image = self::prep_image( (array) $row );
				self::$models->images->update( $updated_image, $updated_image['id'], false );
			}

			// TODO: Run publish recipe function after image table updated
			do_action( 'mv_image_updated', $image_id );
		}

		function images_routes() {

			$route_namespace = $this->api_route . '/' . $this->api_version;

			register_rest_route(
				$route_namespace, '/images', array(
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => array( $this->images_api, 'create_image' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->images_api, 'read_images' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/images/bulk', array(
					array(
						'methods'             => \WP_REST_server::READABLE,
						'callback'            => array( $this->images_api, 'fetch_media_urls' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/images/(?P<id>\d+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->images_api, 'read_single_image' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => array( $this->images_api, 'update_single_image' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
					array(
						'methods'             => \WP_REST_Server::DELETABLE,
						'callback'            => array( $this->images_api, 'delete_single_image' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/images/verify-integrity', [
					[
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->images_api, 'verify_integrity' ),
						'permission_callback' => function () {
							return \Mediavine\Permissions::is_user_authorized();
						},
					],
				]
			);

		}

	}
}
