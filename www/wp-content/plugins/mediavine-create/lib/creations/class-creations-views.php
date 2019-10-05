<?php

namespace Mediavine\Create;

use Mediavine\Settings;
use Mediavine\WordPress\Support\Arr;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Creations' ) ) {

	class Creations_Views extends Creations {

		public static $instance = null;

		public static $multiple_recipes = false;

		public static $multiple_howtos = false;

		public static $multiple_lists = false;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		function init() {
			add_action( 'init', array( $this, 'add_image_sizes' ) );
			add_action( 'image_size_names_choose', array( $this, 'add_image_size_names' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_head', array( $this, 'lists_rounded_corners' ) );
			add_action( 'wp_head', array( $this, 'css_variables' ) );

			add_filter( 'script_loader_tag', array( $this, 'add_async_attribute' ), 10, 2 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'allow_data_attributes' ), 10, 2 );

			add_shortcode( 'mv_create', array( $this, 'mv_create_shortcode' ) );
			add_shortcode( 'mv_recipe', array( $this, 'mv_recipe_shortcode' ) );

			// If MCP is disabled, we don't want a dead shortcode displayed
			if ( ! shortcode_exists( 'mv_video' ) ) {
				add_shortcode( 'mv_video', '__return_false' );
			}

		}

		public function css_variables() {
			$color           = \Mediavine\Settings::get_setting( 'mv_create_color' );
			$secondary_color = \Mediavine\Settings::get_setting( 'mv_create_secondary_color' );

			if ( empty( $color ) || empty( $secondary_color ) ) {
				return;
			}

			$color_alt = Creations_Views_Colors::darken( $color, 20 );
			if ( Creations_Views_Colors::is_dark( $color ) ) {
				$color_alt = Creations_Views_Colors::lighten( $color, 20 );
			}

			$color_hover = Creations_Views_Colors::darken( $color_alt, 20 );
			if ( Creations_Views_Colors::is_dark( $color_alt ) ) {
				$color_hover = Creations_Views_Colors::lighten( $color_alt, 20 );
			}

			$secondary_color_alt = Creations_Views_Colors::darken( $secondary_color, 20 );
			if ( Creations_Views_Colors::is_dark( $secondary_color ) ) {
				$color_alt = Creations_Views_Colors::lighten( $secondary_color, 20 );
			}

			$secondary_color_hover = Creations_Views_Colors::darken( $secondary_color_alt, 20 );
			if ( Creations_Views_Colors::is_dark( $secondary_color_alt ) ) {
				$secondary_color_hover = Creations_Views_Colors::lighten( $secondary_color_alt, 20 );
			}

			$secondary_color_text = '#000';
			if ( Creations_Views_Colors::is_dark( $secondary_color ) ) {
				$secondary_color_text = '#fff';
			}

			?>
				<style>
					.mv-create-card {
						--mv-create-base: <?php echo esc_attr( $color ); ?>!important;
						--mv-create-alt: <?php echo esc_attr( $color_alt ); ?>!important;
						--mv-create-alt-hover: <?php echo esc_attr( $color_hover ); ?>!important;
						--mv-create-base-trans: <?php echo esc_attr( Creations_Views_Colors::to_rgba( $color, .8 ) ); ?>!important;
						--mv-create-secondary-base: <?php echo esc_attr( $secondary_color ); ?>!important;
						--mv-create-secondary-alt: <?php echo esc_attr( $secondary_color_alt ); ?>!important;
						--mv-create-secondary-alt-hover: <?php echo esc_attr( $secondary_color_hover ); ?>!important;
						--mv-create-secondary-base-trans: <?php echo esc_attr( Creations_Views_Colors::to_rgba( $secondary_color, .8 ) ); ?>!important;
						--mv-star-fill: <?php echo esc_attr( Creations_Views_Colors::mix( $secondary_color, '#fff' ) ); ?>!important;
						--mv-star-fill-hover: <?php echo esc_attr( $secondary_color ); ?>!important;
					}
				</style>
			<?php
		}

		public function add_image_sizes() {
			$img_sizes = apply_filters( 'mv_create_image_sizes', self::$img_sizes, __FUNCTION__ );
			foreach ( $img_sizes as $img_size => $img_meta ) {
				add_image_size( $img_size, $img_meta['width'], $img_meta['height'], $img_meta['crop'] );
			}
		}
		public function add_image_size_names( $sizes ) {
			$img_sizes                  = apply_filters( 'mv_create_image_sizes', self::$img_sizes, __FUNCTION__ );
			$mv_create_image_size_names = array();

			foreach ( $img_sizes as $img_size => $img_meta ) {
				$mv_create_image_size_names[ $img_size ] = $img_meta['name'];
			}

			$new_sizes = apply_filters( 'mv_create_image_size_names', $mv_create_image_size_names );
			$sizes     = array_merge( $sizes, $new_sizes );
			return $sizes;
		}

		public function allow_data_attributes( $allowed, $context ) {
			if ( 'post' === $context ) {
				$allowed['div']['data-mv-create-total-ratings'] = true;
				$allowed['div']['data-mv-create-rating']        = true;
				$allowed['div']['data-mv-create-id']            = true;
				$allowed['div']['data-mv-pinterest-desc']       = true;
				$allowed['div']['data-mv-pinterest-img-src']    = true;
				$allowed['div']['data-mv-pinterest-url']        = true;
				$allowed['div']['data-mv-create-object-id']     = true;
				$allowed['div']['data-mv-create-assets-url']    = true;
				$allowed['div']['data-mv-rest-url']             = true;
				$allowed['div']['data-list-content-type']       = true;
				$allowed['div']['data-link-href']               = true;
				$allowed['div']['data-disable-chicory']         = true;
				$allowed['div']['data-slot']                    = true;
			}
			$allowed['img']['nopin']          = true;
			$allowed['img']['data-pin-media'] = true;
			$allowed['img']['data-pin-nopin'] = true;

			$allowed['iframe']['src']             = true;
			$allowed['iframe']['frameborder']     = true;
			$allowed['iframe']['allow']           = true;
			$allowed['iframe']['allowfullscreen'] = true;

			$allowed['img']['srcset'] = true;
			$allowed['img']['sizes']  = true;

			return $allowed;
		}

		public function register_styles() {
			$style_url = apply_filters( 'mv_recipe_stylesheet', Plugin::assets_url() . 'client/build/style.' . Plugin::VERSION . '.css' );
			wp_register_style( 'mv-create-card/css', $style_url, array(), Plugin::VERSION );
		}

		/**
		 * Adds async to enqued script
		 *
		 * @param string $tag        script tag to be outputted
		 * @param string $handle     enque handle
		 * @return string script tag to be outputted
		 */
		public function add_async_attribute( $tag, $handle ) {
			$prefix = Plugin::PLUGIN_DOMAIN . '/client.js';
			if ( substr( $handle, 0, strlen( $prefix ) ) === $prefix ) {
				$tag = str_replace( ' src', ' async data-noptimize src', $tag );
			}

			return $tag;
		}

		public function register_scripts() {
			$handle     = Plugin::PLUGIN_DOMAIN . '/client.js';
			$script_url = Plugin::assets_url() . 'client/build/bundle.' . Plugin::VERSION . '.js';
			if ( apply_filters( 'mv_create_dev_mode', false ) ) {
				$script_url = '//localhost:8080/bundle.js';
			}
			wp_register_script( $handle, $script_url, array(), Plugin::VERSION, true );

			// Get user-supplied element to mount reviews UI on, but revert to null if "enable" option isn't set.
			$reviews_div            = \Mediavine\Settings::get_setting( self::$settings_group . '_public_reviews_el' );
			$public_reviews_enabled = \Mediavine\Settings::get_setting( self::$settings_group . '_enable_public_reviews' );
			if ( empty( $public_reviews_enabled ) ) {
				$reviews_div = null;
			}

			// Set ratings prompt threshold based on setting
			$review_prompt_always     = \Mediavine\Settings::get_setting( self::$settings_group . '_enable_review_prompt_always' );
			$ratings_prompt_threshold = 5.5;
			if ( ! $review_prompt_always ) {
				$ratings_prompt_threshold = 4;
			}

			// Allow filter override of ratings prompy and submit thresholds
			$ratings_prompt_threshold = apply_filters( 'mv_create_ratings_prompt_threshold', $ratings_prompt_threshold );
			$ratings_submit_threshold = apply_filters( 'mv_create_ratings_submit_threshold', 4 );

			$px_btwn_ads = \Mediavine\Settings::get_setting( self::$settings_group . '_ad_density' );

			wp_localize_script(
				$handle, 'MV_CREATE_SETTINGS', array(
					'__API_ROOT__'         => rest_url(),
					'__REVIEWS_DIV__'      => $reviews_div,
					'__PROMPT_THRESHOLD__' => $ratings_prompt_threshold,
					'__SUBMIT_THRESHOLD__' => $ratings_submit_threshold,
					'__PX_BETWEEN_ADS__'   => $px_btwn_ads,
				)
			);

			wp_localize_script(
				$handle, 'MV_CREATE_I18N', array(
					'COMMENTS'             => __( 'Comments', 'mediavine' ),
					'COMMENTS_AND_REVIEWS' => __( 'Comments & Reviews', 'mediavine' ),
					'RATING'               => __( 'Rating', 'mediavine' ),
					'REVIEWS'              => __( 'Reviews', 'mediavine' ),
					'RATING_SUBMITTED'     => __( 'Your rating has been submitted. Write a review below (optional).', 'mediavine' ),
					/* translators: Number of reviews for a card by title */
					'X_REVIEWS_FOR'        => __( '%1$s Reviews for %2$s', 'mediavine' ),
					'LOADING'              => __( 'Loading', 'mediavine' ),
					'VIEW_MORE'            => __( 'View More', 'mediavine' ),
					/* translators: Number of reviews */
					'NUM_REVIEWS'          => __( '%s Reviews', 'mediavine' ),
					'REVIEW'               => __( 'Review', 'mediavine' ),
					/* translators: Rating for a card */
					'NUM_STARS'            => __( '%s Stars', 'mediavine' ),
					'STARS'                => __( 'Stars', 'mediavine' ),
					'STAR'                 => __( 'Star', 'mediavine' ),
					'TITLE'                => __( 'Title', 'mediavine' ),
					'ANONYMOUS_USER'       => __( 'Anonymous User', 'mediavine' ),
					'NO_TITLE'             => __( 'No Title', 'mediavine' ),
					'CONTENT'              => __( 'Content', 'mediavine' ),
					'NO_RATINGS'           => __( 'No Ratings', 'mediavine' ),
					'NAME'                 => __( 'Name', 'mediavine' ),
					'EMAIL'                => __( 'Email', 'mediavine' ),
					'REVIEW_TITLE'         => __( 'Review Title', 'mediavine' ),
					'REVIEW_CONTENT'       => __( 'Review', 'mediavine' ),
					'CONSENT'              => __( 'To submit this review, I consent to the collection of this data.', 'mediavine' ),
					'SUBMIT'               => __( 'Submit', 'mediavine' ),
					'SUBMITTING'           => __( 'Submitting', 'mediavine' ),
					'UPDATE'               => __( 'Update Review', 'mediavine' ),
					'THANKS_RATING'        => __( 'Thanks for the rating!', 'mediavine' ),
					'DID_YOU_MAKE_THIS'    => __( 'Did you make this?', 'mediavine' ),
					'LEAVE_REVIEW'         => __( 'Leave a review?', 'mediavine' ),
					'THANKS_REVIEW'        => __( 'Thanks for the review!', 'mediavine' ),
					'PRINT'                => __( 'Print', 'mediavine' ),
					'YIELD'                => __( 'Yield', 'mediavine' ),
					'SERVING_SIZE'         => __( 'Serving Size', 'mediavine' ),
					'AMOUNT_PER_SERVING'   => __( 'Amount Per Serving', 'mediavine' ),
					'CUISINE'              => __( 'Cuisine', 'mediavine' ),
					'PROJECT_TYPE'         => __( 'Project Type', 'mediavine' ),
					'TYPE'                 => __( 'Type', 'mediavine' ),
					'CATEGORY'             => __( 'Category', 'mediavine' ),
					'RECOMMENDED_PRODUCTS' => __( 'Recommended Products', 'mediavine' ),
					'AFFILIATE_NOTICE'     => __( 'As an Amazon Associate and member of other affiliate programs, I earn from qualifying purchases.', 'mediavine' ),
					'TOOLS'                => __( 'Tools', 'mediavine' ),
					'MATERIALS'            => __( 'Materials', 'mediavine' ),
					'INGREDIENTS'          => __( 'Ingredients', 'mediavine' ),
					'INSTRUCTIONS'         => __( 'Instructions', 'mediavine' ),
					'NOTES'                => __( 'Notes', 'mediavine' ),
					'CALORIES'             => __( 'Calories', 'mediavine' ),
					'TOTAL_FAT'            => __( 'Total Fat', 'mediavine' ),
					'SATURATED_FAT'        => __( 'Saturated Fat', 'mediavine' ),
					'TRANS_FAT'            => __( 'Trans Fat', 'mediavine' ),
					'UNSATURATED_FAT'      => __( 'Unsaturated Fat', 'mediavine' ),
					'CHOLESTEROL'          => __( 'Cholesterol', 'mediavine' ),
					'SODIUM'               => __( 'Sodium', 'mediavine' ),
					'CARBOHYDRATES'        => __( 'Carbohydrates', 'mediavine' ),
					'NET_CARBOHYDRATES'    => __( 'Net Carbohydrates', 'mediavine' ),
					'FIBER'                => __( 'Fiber', 'mediavine' ),
					'SUGAR'                => __( 'Sugar', 'mediavine' ),
					'SUGAR_ALCOHOLS'       => __( 'Sugar Alcohols', 'mediavine' ),
					'PROTEIN'              => __( 'Protein', 'mediavine' ),
				)
			);
		}

		public static function create_wp_kses( $allowed, $context ) {
			// Create card specifics
			$allowed['div']['data-mv-create-total-ratings'] = true;
			$allowed['div']['data-mv-create-rating']        = true;
			$allowed['div']['data-mv-create-id']            = true;
			$allowed['div']['data-mv-pinterest-desc']       = true;
			$allowed['div']['data-mv-pinterest-img-src']    = true;
			$allowed['div']['data-mv-pinterest-url']        = true;
			$allowed['div']['data-mv-create-object-id']     = true;
			$allowed['div']['data-mv-create-assets-url']    = true;
			$allowed['div']['data-mv-rest-url']             = true;
			$allowed['div']['data-derive-font-from']        = true;

			// Video Shortcode
			$allowed['div']['data-value']        = true;
			$allowed['div']['data-sticky']       = true;
			$allowed['div']['data-autoplay']     = true;
			$allowed['div']['data-ratio']        = true;
			$allowed['div']['data-volume']       = true;
			$allowed['script']['type']           = true;
			$allowed['script']['src']            = true;
			$allowed['script']['async']          = true;
			$allowed['script']['data-noptimize'] = true;

			$allowed['img']['nopin']          = true;
			$allowed['img']['data-pin-media'] = true;
			$allowed['img']['data-pin-nopin'] = true;

			$allowed['input']['type']  = true;
			$allowed['input']['name']  = true;
			$allowed['input']['value'] = true;

			$allowed['button']['data-mv-print'] = true;

			$allowed['a']['data-derive-button-from'] = true;

			return $allowed;
		}

		public static function prep_creation_view( $atts ) {
			global $id;
			$creation = self::$models_v2->mv_creations->find_one( $atts['key'] );

			// We need a creation id to move any further, meaning creation does exist
			if ( empty( $creation->id ) ) {
				return;
			}
			// These are to be removed later
			$creation = self::restore_video_data( $creation );
			$creation = \Mediavine\Create\Products::restore_product_images( $creation );

			// Check if post is associated to card
			$associated_posts = [];
			if ( ! empty( $creation->associated_posts ) ) {
				$associated_posts = json_decode( $creation->associated_posts );
			}
			if ( is_singular() && ! in_array( $id, $associated_posts, true ) ) {
				self::associate_post_with_creation( $creation->id, $id );
			}

			// This stays forever.
			// This method checks several factors to decide if the card needs
			// to be republished before being displayed. It allows us to add cards
			// to a `republish_queue` when things need to be fixed en masse.
			$creation = \Mediavine\Create\Publish::maybe_republish( $creation );

			$published_creation = json_decode( $creation->published, true );

			// If a card specifies its own layout (for instance, for Lists)
			// it should override the style
			if ( ! empty( $atts['layout'] ) ) {
				$atts['style'] = $atts['layout'];
			}

			if ( $published_creation ) {
				$published_creation['classes'] = array(
					'mv-create-card',
					'mv-create-card-' . $atts['key'],
					'mv-' . $atts['type'] . '-card',
					'mv-create-card-style-' . str_replace( '/', '-', $atts['style'] ),
				);

				// Only have mv-no-js class if not print
				if ( empty( $atts['print'] ) ) {
					$published_creation['classes'][] = 'mv-no-js';
				}

				// Add specific classes to print layout
				if ( ! empty( $atts['print'] ) ) {
					$published_creation['classes'][] = 'mv-create-xl';
					$published_creation['classes'][] = 'js';
				}

				$aggressive_buttons = \Mediavine\Settings::get_setting( self::$settings_group . '_aggressive_buttons' );
				if ( $aggressive_buttons ) {
					$published_creation['classes'][] = 'mv-create-aggressive-buttons';
				}

				// We don't want to waste resources for lists
				if ( 'list' !== $atts['type'] ) {
					// Forced settings classes
					$uppercase = \Mediavine\Settings::get_setting( self::$settings_group . '_force_uppercase' );
					if ( $uppercase || is_null( $uppercase ) ) { // Null means no setting, so we get default
						$published_creation['classes'][] = 'mv-create-has-uppercase';
					}
					$aggressive_lists = \Mediavine\Settings::get_setting( self::$settings_group . '_aggressive_lists' );
					if ( $aggressive_lists ) {
						$published_creation['classes'][] = 'mv-create-aggressive-lists';
					}
					$use_ugly_nutrition_display = \Mediavine\Settings::get_setting( self::$settings_group . '_use_realistic_nutrition_display' );
					if ( $use_ugly_nutrition_display ) {
						$published_creation['classes'][] = 'mv-create-traditional-nutrition';
					}

					// Set Pinterest description as image alt text so browser extension picks it up
					if ( isset( $published_creation['images']['mv_create_vert'] ) ) {
						$pin_img                                        = $published_creation['images']['mv_create_vert'];
						$pin_img_alt_text                               = 'alt="' . $published_creation['pinterest_description'] . '"';
						$published_creation['images']['mv_create_vert'] = str_replace( 'class', "$pin_img_alt_text class", $pin_img );
					}

					// Print view
					if ( $atts['print'] ) {
						$published_creation['classes'][] = 'mv-create-print-view';

						// Hide images on print
						$mv_create_enable_print_thumbnails = \Mediavine\Settings::get_setting( self::$settings_group . '_enable_print_thumbnails' );
						if ( empty( $mv_create_enable_print_thumbnails ) ) {
							$published_creation['classes'][] = 'mv-create-hide-img';
						}
					}
				}

				// Add image tags
				$img_sizes                    = apply_filters( 'mv_create_image_sizes', self::$img_sizes, __FUNCTION__ );
				$published_creation['images'] = \Mediavine\View_Loader::get_mv_image_tags( $published_creation, $img_sizes );

				// Determine if card has an image
				$has_img_class = 'mv-create-no-image';
				if ( ! is_null( $published_creation['images'] ) ) {
					$has_img_class = 'mv-create-has-image';
				}

				$published_creation['classes'][] = $has_img_class;

				$published_creation['classes'] = implode( ' ', $published_creation['classes'] );

				// Get Pinterest settings
				$pinterest_location = \Mediavine\Settings::get_setting( self::$settings_group . '_pinterest_location', 'mv-creation-pin-button' );

				$published_creation['pinterest_class'] = $pinterest_location;

				if ( isset( $published_creation['images'] ) && isset( $published_creation['images']['mv_create_vert'] ) && 'off' !== $pinterest_location ) {
					// Set Pinterest description as image alt text so browser extension picks it up
					$pin_img                                        = $published_creation['images']['mv_create_vert'];
					$pin_img_alt_text                               = 'alt="' . $published_creation['pinterest_description'] . '"';
					$published_creation['images']['mv_create_vert'] = str_replace( 'class', "$pin_img_alt_text class", $pin_img );

					$has_img_class = 'mv-create-no-image';
					if ( ! is_null( $published_creation['images'] ) ) {
						$has_img_class = 'mv-create-has-image';
					}

					$published_creation['pinterest_display'] = true;

					if ( empty( $published_creation['pinterest_description'] ) ) {
						$published_creation['pinterest_description'] = $published_creation['title'];
					}

					if ( empty( $published_creation['pinterest_url'] ) ) {
						$published_creation['pinterest_url'] = get_the_permalink();
					}

					if ( empty( $published_creation['pinterest_img_id'] ) ) {
						$published_creation['pinterest_img_id'] = $published_creation['thumbnail_id'];
					}
				}

				// Remove Pinterest image if the Pinterest button display is set to off
				if ( isset( $published_creation['images'] ) && 'off' === $pinterest_location ) {
					unset( $published_creation['images']['mv_create_vert'] );
				}

				// Enable override of author by default copyright
				if ( \Mediavine\Settings::get_setting( self::$settings_group . '_copyright_override' ) ) {
					$published_creation['author'] = \Mediavine\Settings::get_setting( self::$settings_group . '_copyright_attribution' );
				}

				$published_creation_pinterest_img = wp_get_attachment_image_src( $published_creation['pinterest_img_id'], 'mv_creation_vert' );
				if ( is_array( $published_creation_pinterest_img ) ) {
					$published_creation['pinterest_img'] = $published_creation_pinterest_img[0];
				}

				if ( 'list' === $atts['type'] && ! empty( $published_creation['list_items'] ) && is_array( $published_creation['list_items'] ) ) {
					$atts['layout'] = $published_creation['layout'];
					$img_sizes      = apply_filters( 'mv_create_image_sizes', self::$img_sizes, __FUNCTION__ );

					// Order list items by position because we can't guarantee DB write order
					usort(
						$published_creation['list_items'], function( $a, $b ) {
						if ( $a['position'] > $b['position'] ) {
							return 1;
						}
						if ( $b['position'] > $a['position'] ) {
							return -1;
						}
						return 0;
						}
					);

					$published_creation['list_items_between_ads'] = \Mediavine\Settings::get_setting( self::$settings_group . '_list_items_between_ads', 3 );
					foreach ( $published_creation['list_items'] as $key => &$item ) {

						// Thumbnail url logic
						$layout_image_sizes   = array(
							'circles'  => 'mv_create_1x1',
							'grid'     => 'mv_create_16x9',
							'hero'     => 'mv_create_vert',
							'numbered' => 'mv_create_vert',
						);
						$thumbnail_image_size = 'mv_create_1x1';
						if ( array_key_exists( $atts['layout'], $layout_image_sizes ) ) {
							$thumbnail_image_size = $layout_image_sizes[ $atts['layout'] ];
						}

						// Generate thumbnail if it doesn't exist
						\Mediavine\Images::check_image_size( $item['thumbnail_id'], $img_sizes );
						$alt_text = get_post_meta( $item['thumbnail_id'], '_wp_attachement_image_alt', true );
						if ( empty( $alt_text ) ) {
							$alt_text = $item['title'];
						}
						$item['thumbnail_url'] = wp_get_attachment_image(
							$item['thumbnail_id'],
							$thumbnail_image_size,
							false,
							array(
								'class'          => 'mv-list-single-img no_pin ggnoads',
								'alt'            => $alt_text,
								'data-pin-nopin' => 'true',
							)
						);

						$item['pinterest_url'] = wp_get_attachment_image_url(
							$item['thumbnail_id'],
							'mv_create_vert',
							false
						);

						// Get permalink for all non-external items, including CPTs
						if ( 'external' !== $item['content_type'] ) {
							$item['url'] = get_the_permalink( $item['canonical_post_id'] );
						}

						// Provide button text
						if ( ! empty( $item['link_text'] ) ) {
							$item['btn_text'] = $item['link_text'];
						} elseif ( 'recipe' === $item['secondary_type'] ) {
							$item['btn_text'] = __( 'Get the Recipe', 'mediavine' );
						} elseif ( 'diy' === $item['secondary_type'] ) {
							$item['btn_text'] = __( 'Read the Guide', 'mediavine' );
						} else {
							$item['btn_text'] = __( 'Continue Reading', 'mediavine' );
						}

						if ( 'card' === $item['content_type'] ) {
							// We don't wany any unassociated cards
							if ( empty( $item['canonical_post_id'] ) ) {
								unset( $published_creation['list_items'][ $key ] );
								continue;
							}

							$item['url']  = get_the_permalink( $item['canonical_post_id'] );
							$item_data    = \mv_create_get_creation( $item['relation_id'], true );
							$item['data'] = array();

							$item_meta = json_decode( $item['meta'] );

							// Add meta types
							if ( is_array( $item_meta ) ) {
								if ( in_array( 'prep_time', $item_meta, true ) && ! empty( $item_data->prep_time ) ) {
									$item['data'][] = array( __( 'Prep Time' ), $item_data->prep_time->output );
								}
								if ( in_array( 'active_time', $item_meta, true ) && ! empty( $item_data->active_time ) ) {
									$item['data'][] = array( __( 'Active Time' ), $item_data->active_time->output );
								}
								if ( in_array( 'total_time', $item_meta, true ) && ! empty( $item_data->total_time ) ) {
									$item['data'][] = array( __( 'Total Time' ), $item_data->total_time->output );
								}
								if ( in_array( 'yield', $item_meta, true ) && ! empty( $item_data->yield ) ) {
									$item['data'][] = array( __( 'Yield' ), $item_data->yield );
								}
								if ( in_array( 'category', $item_meta, true ) && ! empty( $item_data->category ) ) {
									$term           = \get_term( $item_data->category, 'category' );
									$item['data'][] = array( __( 'Category' ), $term->name );
								}
								// Recipes
								if ( in_array( 'calories', $item_meta, true ) && ! empty( $item_data->nutrition ) ) {
									$item['data'][] = array( __( 'Calories' ), $item_data->nutrition->calories );
								}
								if ( in_array( 'cuisine', $item_meta, true ) && ! empty( $item_data->secondary_term ) ) {
									$term           = \get_term( $item_data->secondary_term, 'mv_cuisine' );
									$item['data'][] = array( __( 'Cuisine' ), $term->name );
								}
								// DIY
								if ( in_array( 'project_type', $item_meta, true ) && ! empty( $item_data->secondary_term ) ) {
									$term           = \get_term( $item_data->secondary_term, 'mv_project_types' );
									$item['data'][] = array( __( 'Project Type' ), $term->name );
								}
								if ( in_array( 'cost', $item_meta, true ) && ! empty( $item_data->estimated_cost ) ) {
									$item['data'][] = array( __( 'Cost' ), $item_data->estimated_cost );
								}
								if ( in_array( 'difficulty', $item_meta, true ) && ! empty( $item_data->difficulty ) ) {
									$item['data'][] = array( __( 'Difficulty' ), $item_data->difficulty );
								}
							}
						}

						$item = self::create_list_item_extra( $item );
					}
				}

				// Remove hardcoded ad hints from instructions
				$published_creation['instructions'] = str_replace( '<div class="mv-create-target"><div class="mv_slot_target" data-slot="recipe"></div></div>', '', $published_creation['instructions'] );

				// Sanitize empty-ish fields, which may contain nothing but empty p tags
				$fields_to_check = array( 'instructions', 'notes' );
				// Loop over fields
				foreach ( $fields_to_check as $field ) {
					$temp = $published_creation[ $field ];
					// Strip out HTML tags
					$no_more_tags   = strip_tags( $temp );
					$no_more_spaces = preg_replace( '/\s+/', '', $no_more_tags );
					// If the -stripped- string doesn't have any content, we set to null
					if ( ! strlen( $no_more_spaces ) ) {
						$published_creation[ $field ] = null;
					}
				}

				// Prevent multiple JSON-LD for Lists and How Tos
				if (
					( self::$multiple_recipes && 'recipe' === $atts['type'] ) ||
					( self::$multiple_howtos && 'diy' === $atts['type'] ) ||
					( self::$multiple_lists && 'list' === $atts['type'] )
				) {
					unset( $published_creation['json_ld'] );
				}

				$is_canonical = false;
				if ( $id === (int) $published_creation['canonical_post_id'] ) {
					$is_canonical = true;
				}

				// Only set howto to true if JSON_LD is outputted
				if (
					$is_canonical &&
					! empty( $published_creation['json_ld'] ) &&
					'recipe' === $atts['type'] &&
					// Reverse of what is used to display JSON-LD
					! (
						// Check isset so old cards still display schema,
						// and check empty because of some PHP interpreting `! $var` as strict with 0 strings
						isset( $published_creation['schema_display'] ) &&
						empty( $published_creation['schema_display'] )
					)
				) {
					self::$multiple_recipes = true;
				}

				// Only set howto to true if JSON_LD is outputted
				if (
					$is_canonical &&
					! empty( $published_creation['json_ld'] ) &&
					'diy' === $atts['type'] &&
					// Reverse of what is used to display JSON-LD
					! (
						// Check isset so old cards still display schema,
						// and check empty because of some PHP interpreting `! $var` as strict with 0 strings
						isset( $published_creation['schema_display'] ) &&
						empty( $published_creation['schema_display'] )
					)
				) {
					self::$multiple_howtos = true;
				}

				// Only set list to true if JSON_LD is outputted
				if (
					$is_canonical &&
					! empty( $published_creation['json_ld'] ) &&
					'list' === $atts['type'] &&
					// Reverse of what is used to display JSON-LD
					! (
						// Check isset so old cards still display schema,
						// and check empty because of some PHP interpreting `! $var` as strict with 0 strings
						isset( $published_creation['schema_display'] ) &&
						empty( $published_creation['schema_display'] )
					)
				) {
					self::$multiple_lists = true;
				}
			}

			$published_creation['custom_fields'] = json_decode( $published_creation['custom_fields'], true );

			return $published_creation;
		}

		/**
		 * Gets image size setting
		 * @return string Image size setting
		 */
		public static function get_image_size() {
			return \Mediavine\Settings::get_setting( self::$settings_group . '_photo_ratio', 'mv_create_16x9' );
		}

		/**
		 * Perfoms nutrition logic for frontend card render
		 * @param array array with nutrition values
		 * @return array|false updated nutrition values or false if none exist
		 */
		public static function get_nutrition_data( $nutrition ) {
			$nutrition_output = array(
				'items' => array(),
			);

			if ( ! empty( $nutrition ) ) {
				$use_ugly_nutrition_display = \Mediavine\Settings::get_setting( self::$settings_group . '_use_realistic_nutrition_display' );
				$nutrition_facts            = array(
					'calories'        => array(
						'name'  => __( 'Calories', 'mediavine' ),
						'unit'  => null,
						'class' => 'calories',
					),
					'total_fat'       => array(
						'name'  => __( 'Total Fat', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'total-fat',
					),
					'saturated_fat'   => array(
						'name'  => __( 'Saturated Fat', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'saturated-fat mv-create-nutrition-indent',
					),
					'trans_fat'       => array(
						'name'  => __( 'Trans Fat', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'trans-fat mv-create-nutrition-indent',
					),
					'unsaturated_fat' => array(
						'name'  => __( 'Unsaturated Fat', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'unsaturated-fat mv-create-nutrition-indent',
					),
					'cholesterol'     => array(
						'name'  => __( 'Cholesterol', 'mediavine' ),
						'unit'  => 'mg',
						'class' => 'cholesterol',
					),
					'sodium'          => array(
						'name'  => __( 'Sodium', 'mediavine' ),
						'unit'  => 'mg',
						'class' => 'sodium',
					),
					'carbohydrates'   => array(
						'name'  => __( 'Carbohydrates', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'carbohydrates',
					),
					'net_carbs'       => array(
						'name'  => __( 'Net Carbohydrates', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'net-carbohydrates mv-create-nutrition-indent',
					),
					'fiber'           => array(
						'name'  => __( 'Fiber', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'fiber mv-create-nutrition-indent',
					),
					'sugar'           => array(
						'name'  => __( 'Sugar', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'sugar mv-create-nutrition-indent',
					),
					'sugar_alcohols'  => array(
						'name'  => __( 'Sugar Alcohols', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'sugar-alcohols mv-create-nutrition-indent',
					),
					'protein'         => array(
						'name'  => __( 'Protein', 'mediavine' ),
						'unit'  => 'g',
						'class' => 'protein',
					),
				);
				foreach ( $nutrition_facts as $slug => $nutrition_fact ) {
					if ( isset( $nutrition[ $slug ] ) && ( ! empty( $nutrition[ $slug ] ) || 0 === $nutrition[ $slug ] || '0' === $nutrition[ $slug ] ) ) {
						$nutrition_label             = ( $use_ugly_nutrition_display ) ? $nutrition_fact['name'] : $nutrition_fact['name'] . ':';
						$nutrition_output['items'][] = array(
							'slug'  => $slug,
							'label' => $nutrition_label,
							'value' => $nutrition[ $slug ],
							'unit'  => $nutrition_fact['unit'],
							'class' => $nutrition_fact['class'],
						);
					}
				}
			}

			if ( ! empty( $nutrition_output['items'] ) ) {
				$nutrition_output['number_of_servings'] = $nutrition['number_of_servings'];
				$nutrition_output['serving_size']       = $nutrition['serving_size'];
				return $nutrition_output;
			}

			return false;
		}

		public static function create_list_item_extra( $item ) {
			ob_start();
			?>
				<div class="mv-list-meta">
				<?php
				if ( isset( $item['data'] ) ) {
					foreach ( $item['data'] as $value ) {
					?>
						<span class="mv-list-meta-item">
							<strong><?php echo esc_html( $value[0] ); ?></strong> <?php echo wp_kses_post( $value[1] ); ?>
						</span>
					<?php
					}
				}
				?>
				</div>
			<?php
			$item['extra'] = ob_get_clean();

			// Prevent empty-ish content
			$item['extra'] = preg_replace( '/^\s*$/', '', $item['extra'] );
			return $item;
		}

		/**
		 * Converts the rounded corner setting to a CSS variable
		 *
		 * @return void
		 */
		public function lists_rounded_corners() {
			$radius_enabled = \Mediavine\Settings::get_setting( 'mv_create_lists_rounded_corners' );
			?>
			<style>
				:root {
					--mv-create-radius: <?php echo esc_attr( $radius_enabled ); ?>;
				}
			</style>
			<?php
		}

		// [mv_create] shortcode
		public function mv_create_shortcode( $atts, $content = null ) {
			// Return if no key
			if ( empty( $atts['key'] ) || 'undefined' === $atts['key'] ) {
				return;
			}

			// Base for themes is create
			$atts['base'] = 'create';

			// Use recipe if no type
			if ( empty( $atts['type'] ) ) {
				$atts['type'] = 'recipe';
			}

			// Get version
			$atts['version'] = apply_filters( 'mv_create_style_version', $this->card_style_version, $atts );

			// Add allowed html for description
			$atts['allowed_html'] = array(
				'a'      => array(
					'href'   => array(),
					'title'  => array(),
					'target' => array(),
					'rel'    => array(),
				),
				'em'     => array(),
				'strong' => array(),
				'p'      => array(),
				'br'     => array(),
			);

			// Get card style
			$default_card_style = 'square';
			$card_style         = \Mediavine\Settings::get_setting( self::$settings_group . '_card_style' );

			if ( ! empty( $card_style ) ) {
				$default_card_style = $card_style;
			}

			if ( empty( $atts['style'] ) ) {
				$atts['style'] = $default_card_style;
			}

			// Print view
			$print = false;
			if ( isset( $atts['print'] ) ) {
				$print = true;
			}
			$atts['print'] = $print;

			// Build layout with card style hooks
			$card_type = 'card';
			if ( 'list' === $atts['type'] ) {
				$card_type = 'list';
			}

			$card_style_hook_function = $card_type . '_style_' . str_replace( '-', '_', $atts['style'] ) . '_hooks';
			if ( ! method_exists( 'Mediavine\Create\Creations_Views_Hooks', $card_style_hook_function ) ) {
				$card_style_hook_function = 'card_style_square_hooks';
				if ( 'list' === $atts['type'] ) {
					$card_style_hook_function = 'list_style_square_hooks';
					$atts['style']            = 'default';
				}
			}
			Creations_Views_Hooks::$card_style_hook_function( $atts['type'], $atts['version'] );

			// Hooks for template overrides cannot be removed unless they are run AFTER we have hooked them
			do_action( 'mv_create_modify_card_style_hooks', $atts['style'], $atts['type'] );

			// Prep creation
			$atts['creation'] = self::prep_creation_view( $atts );

			// Don't display a card if there's no creation data
			if ( empty( $atts['creation'] ) ) {
				return;
			}

			// Don't display a list if there are no list items
			if ( 'list' === $atts['creation']['type'] && empty( $atts['creation']['list_items'] ) ) {
				return;
			}

			$atts['allow_reviews'] = \Mediavine\Settings::get_setting( self::$settings_group . '_allow_reviews' );

			$attrs_to_be_normalized = array( 'author', 'notes', 'description', 'instructions' );

			foreach ( $attrs_to_be_normalized as $attr ) {
				if ( ! empty( $atts['creation'][ $attr ] ) ) {
					$atts['creation'][ $attr ] = static::normalize_block_tags( $atts['creation'][ $attr ] );
					$atts['creation'][ $attr ] = str_replace( '&quot;', '"', $atts['creation'][ $attr ] );
				}
			}

			$atts['creation']['secondary_term_label'] = __( 'Type', 'mediavine' );
			if ( 'recipe' === $atts['creation']['type'] ) {
				$atts['creation']['secondary_term_label'] = __( 'Cuisine', 'mediavine' );
			}
			if ( 'diy' === $atts['creation']['type'] ) {
				$atts['creation']['secondary_term_label'] = __( 'Project Type', 'mediavine' );
			}

			$atts['enable_nutrition']                = \Mediavine\Settings::get_setting( self::$settings_group . '_enable_nutrition' );
			$atts['use_realistic_nutrition_display'] = \Mediavine\Settings::get_setting( self::$settings_group . '_use_realistic_nutrition_display' );
			$atts['ad_density']                      = \Mediavine\Settings::get_setting( self::$settings_group . 'mv_create_ad_density' );

			// Add old keys to array if custom template
			$has_custom_v1_template = apply_filters( 'mv_create_style_version', false );
			if ( 'v1' === $has_custom_v1_template ) {
				$atts['disable_nutrition'] = ! $atts['enable_nutrition'];
				$atts['disable_reviews']   = ! $atts['allow_reviews'];
			}

			// Run filter for wp_kses output and then remove after shortcode added
			add_filter( 'wp_kses_allowed_html', array( $this, 'create_wp_kses' ), 2, 10 );

			/**
			 * Fires immediately before Create card template has been built
			 *
			 * @param array $atts All card attributes used to generate card
			 */
			do_action( 'mv_create_card_before_render', $atts );

			$creation_view = self::$views->get_view( 'shortcode-mv-create.php', $atts );

			/**
			 * Fires immediately after Create card template has been built
			 *
			 * @param array $atts All card attributes used to generate card
			 * @param array $creation_view Rendered HTML of Create card
			 */
			do_action( 'mv_create_card_after_render', $atts, $creation_view );

			// We have some overlapping actions that can create duplicate content if we don't clean up after a card is rendered.
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 10 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 20 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 40 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 50 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 60 );
			remove_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 70 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 20 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 10 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 20 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 40 );
			remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_list' ), 10 );
			remove_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			remove_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 20 );
			remove_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
			remove_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );

			remove_filter( 'wp_kses_allowed_html', array( $this, 'create_wp_kses' ), 10 );

			if ( ! empty( $creation_view ) ) {
				if ( ! apply_filters( 'mv_create_dev_mode', false ) ) {
					wp_enqueue_style( 'mv-create-card/css' );
				}
				wp_enqueue_script( Plugin::PLUGIN_DOMAIN . '/client.js' );

				// Force Autoptimize to NOT aggregate inline scripts so it doesn't break JS
				add_filter( 'autoptimize_js_include_inline', '__return_false' );

				// Converts heading tags down if setting requires
				$creation_view = self::adjust_headings_level( $creation_view, $atts['creation'] );

				/**
				 * Filters the rendered Create card content
				 *
				 * @param array $atts List of attributes used to render card
				 */
				$creation_view = apply_filters( 'mv_create_card_render', $creation_view, $atts );

				return $creation_view;
			}

			return false;
		}

		public static function prep_creation_times( $creation, array $additionals = array() ) {
			$prepared_times = array();
			$times_to_parse = array(
				'prep_time',
				'active_time',
				'additional_time',
				'perform_time',
				'total_time',
			);
			$times_to_parse = apply_filters( 'mv_times_to_parse', $times_to_parse );

			$creation_times         = array();
			$creation_times_keys    = array();
			$creation_times_objects = Arr::only( $creation, $times_to_parse );
			$creation_times_objects = array_filter( $creation_times_objects );
			foreach ( $creation_times_objects as $key => $time ) {
				$creation_times[ $key ] = (array) $time;
				$creation_times_keys[]  = $key;
			}
			if ( empty( $creation_times ) ) {
				return $prepared_times;
			}

			if ( empty( $creation['time_display'] ) ) {
				$creation['time_display'] = 'prep_time,active_time,additional_time';
			}
			$time_display_order = trim( $creation['time_display'], ',' );
			$time_display_order = explode( ',', $time_display_order );
			$time_display_order = array_intersect( $time_display_order, $creation_times_keys );

			foreach ( $time_display_order as $time_display ) {
				$label = '';
				if ( ! empty( $creation[ $time_display . '_label' ] ) ) {
					$label = $creation[ $time_display . '_label' ];
				}

				$prepared_time = static::prep_creation_time( $creation_times[ $time_display ], $time_display, $label );
				if ( ! empty( $prepared_time ) ) {
					$prepared_times[] = $prepared_time;
				}
			}

			if ( count( $prepared_times ) && ! empty( $creation['total_time']['output'] ) ) {
				$prepared_times[] = array(
					'time'  => $creation['total_time']['output'],
					'label' => __( 'Total Time', 'mediavine' ),
					'class' => 'total',
				);
			}

			// We will set additionals if DIY type and nothing previously added
			if ( 'diy' === $creation['type'] && empty( $additionals ) ) {
				$diy_additionals = array(
					'difficulty'     => array(
						'value' => $creation['difficulty'],
						'label' => __( 'Difficulty', 'mediavine' ),
					),
					'estimated_cost' => array(
						'value' => $creation['estimated_cost'],
						'label' => __( 'Estimated Cost', 'mediavine' ),
					),
				);
				$additionals     = apply_filters( 'mv_create_diy_additionals', $diy_additionals, $creation );
			}

			if ( ! empty( $additionals ) ) {
				foreach ( $additionals as $meta => $data ) {
					if ( is_array( $data ) && ! empty( $data['value'] ) && ! empty( $data['label'] ) ) {
						$prepared_times[] = array(
							'time'  => $data['value'],
							'label' => $data['label'],
							'class' => $meta,
						);
					}
				}
			}

			return $prepared_times;
		}

		public static function prep_creation_time( $time_array, $time_display, $label ) {
			$time = array();
			if ( ! is_array( $time_array ) || ! isset( $time_array['output'] ) ) {
				return $time;
			}

			$prepared_time = array();

			if ( ! empty( $time_array['output'] ) ) {
				$prepared_time['time']  = $time_array['output'];
				$prepared_time['label'] = $label;
				$prepared_time_class    = explode( '_time', $time_display );
				$prepared_time['class'] = $prepared_time_class[0];
			}

			return $prepared_time;
		}

		// [mv_recipe] shortcode
		public function mv_recipe_shortcode( $atts, $content = null ) {
			$creation = self::$models_v2->mv_creations->find_one(
				array(
					'where' => array(
						'original_object_id' => $atts['post_id'],
					),
				)
			);
			if ( empty( $creation->id ) ) {
				return false;
			}
			$atts['key']  = $creation->id;
			$atts['type'] = 'recipe';
			return $this->mv_create_shortcode( $atts );
		}

		/**
		 * Checks for existence of a custom field for a given Creation and returns its value or a default value.
		 *
		 * @param array $creation Specifically `$args['creation']` as used in card styles
		 * @param string $slug The slug of the desired custom field
		 * @param string $default The value to return if no custom field data is found
		 * @return string|mixed
		 */
		public static function get_custom_field( $creation, $slug, $default = '' ) {
			$value = $default;
			if ( ! empty( $creation['custom_fields'][ $slug ] ) ) {
				$value = $creation['custom_fields'][ $slug ];
			} else {
				$value = Settings::get_setting( $slug );
			}
			return $value;
		}

		/**
		 * Given a string that might contain block tags leftover from EZR, transform into valid HTML
		 *
		 * Supported:
		 *   - [br] --> line break
		 *   - [url:<id>]...[/url] --> <a> tag with href of permalink of post with ID <id>
		 *   - [url...href...]...[/url] --> <a> tag with href
		 *   - [b]...[/b] --> <strong> tag
		 *   - [i]...[/i] --> <em> tag
		 *   - [u]...[/u] --> <u> tag
		 */
		public static function normalize_block_tags( $string ) {
			// Replace line breaks
			$string = str_replace( '[br]', '<br/>', $string );

			// Replace strong and em tags
			$string = preg_replace( '/\[b](.*?)\[\/b]/', '<strong>$1</strong>', $string );
			$string = preg_replace( '/\[i](.*?)\[\/i]/', '<em>$1</em>', $string );
			$string = preg_replace( '/\[u](.*?)\[\/u]/', '<u>$1</u>', $string );

			// Replace links with href
			$string = preg_replace( '/\[url([^]]+href[^]]+)](.*?)\[\/url]/', '<a $1>$2</a>', $string );

			// Replace links with ids
			$string = preg_replace_callback(
				'/\[url:(\d+)](.*)\[\/url]/', function( $matches ) {
				$permalink = get_the_permalink( $matches[1] );
				return '<a href="' . $permalink . '">' . $matches[2] . '</a>';
				}, $string
			);

			return $string;
		}

		/**
		 * Reduces headings from h1s to h2s and down if setting is set
		 *
		 * @param string $creation_view Current output of creation card
		 * @param array $creation Current creation data
		 * @return string Output of creation card
		 */
		public static function adjust_headings_level( $creation_view, $creation ) {
			// Only adjust if setting to adjust set to true and title not hidden
			if (
				'h2' === \Mediavine\Settings::get_setting( self::$settings_group . '_primary_headings', 'h2' ) &&
				empty( $creation['title_hide'] )
			) {
				$headings = [
					'<h3'  => '<h4',
					'</h3' => '</h4',
					'<h2'  => '<h3',
					'</h2' => '</h3',
					'<h1'  => '<h2',
					'</h1' => '</h2',
				];

				foreach ( $headings as $old => $new ) {
					$creation_view = str_replace( $old, $new, $creation_view );
				}
			}

			return $creation_view;
		}

		/**
		 * Inline script to disable mediavine pagespeed on print views
		 *
		 * Will only display if `mv-script-wrapper` has been added to page
		 *
		 * @return void
		 */
		public function print_inline_script() {
			wp_add_inline_script(
				Plugin::PLUGIN_DOMAIN . '/client.js', '
				window.$mediavine = window.$mediavine || {}
				window.$mediavine.web = window.$mediavine.web || {}
				window.$mediavine.web.disable_pagespeed = true

				document.addEventListener("load", window.setTimeout(function(){ window.print() }, 1500) );
			'
			);

			add_filter( 'mv_trellis_nonasync_js_handles', [ $this, 'disable_client_async' ] );
		}

		/**
		 * make sure trellis adds the inline script for printing cards
		 *
		 * @param array $disallowed_handles array of script handles to exclude from async/defering
		 * @return array
		 */
		public function disable_client_async( $disallowed_handles ) {
			$disallowed_handles[] = Plugin::PLUGIN_DOMAIN . '/client.js';
			return $disallowed_handles;
		}

		public function print_view( \WP_REST_Request $request ) {
			header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
			$api_services = new \Mediavine\API_Services;
			$params       = $api_services->process_inbound( $request );
			$creation     = self::$models_v2->mv_creations->find_one( $params['id'] );

			add_action( 'wp_enqueue_scripts', array( $this, 'print_inline_script' ) );

			add_action(
				'mv_create_card_footer', function( $args ) {
				if ( isset( $args['creation'] ) && isset( $args['creation']['canonical_post_id'] ) ) {
					echo '<span class="mv-create-canonical-link">' . esc_url( get_the_permalink( $args['creation']['canonical_post_id'] ) ) . '</span>';
				}
				}, 100
			);

			if ( empty( $creation ) ) {
				header( 'HTTP/1.0 404 Not Found' );
				esc_html_e( 'No Card with ID found', 'mediavine' );
				exit();
			}

			$print_title = apply_filters( 'mv_create_print_title', esc_html( $creation->title . ' - ' . get_bloginfo( 'name' ) ) );
			$canonical   = get_permalink( $creation->canonical_post_id );

			// Use recipe if no type
			$default_type = 'recipe';
			if ( ! empty( $creation->type ) ) {
				$default_type = $creation->type;
			}

			$card_style       = apply_filters( 'mv_create_print_card_style', 'default' );
			$card_style_array = explode( '/', $card_style );
			if ( 'recipes' !== $card_style_array[0] ) {
				$card_style = 'recipes/' . trim( $card_style, '/' );
			}
			$card_style = apply_filters( 'mv_create_' . $default_type . '_print_card_style', $card_style );

			/**
			 * last chance to add/remove things before output
			 */
			do_action( 'mv_create_card_before_print_render' );
			?>
			<!DOCTYPE html>
<html>
<head>
<title><?php echo esc_html( $print_title ); ?></title>
<meta name="robots" content="none">
<meta name="pinterest" content="nopin" description="Sorry, you can't pin print pages." />
<meta property="og:url" content="<?php echo esc_attr( $canonical ); ?>" />
<link rel="canonical" href="<?php echo esc_attr( $canonical ); ?>">
<?php
	do_action(
		'mv_create_print_head', array(
			'creation'   => $creation,
			'card_style' => $card_style,
			'type'       => $default_type,
		)
	);
?>
<?php wp_head(); ?>

</head>
<body>

			<?php
			/**
			 * mv_create_print_before hook.
			 */
			do_action(
				'mv_create_print_before', array(
					'creation'   => $creation,
					'card_style' => $card_style,
					'type'       => $default_type,
				)
			);

			self::$views->the_view(
				'v1/print-mv-create.php', array(
					'creation'   => $creation,
					'card_style' => $card_style,
					'type'       => $default_type,
				)
			);

			/**
			 * mv_create_print_after hook.
			 */
			do_action(
				'mv_create_print_after', array(
					'creation'   => $creation,
					'card_style' => $card_style,
					'type'       => $default_type,
				)
			);
			?>

<?php wp_footer(); ?>
</body>
</html>

			<?php
			exit();
		}
	}
}
