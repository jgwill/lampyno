<?php

namespace Mediavine\Create;

use Mediavine\WordPress\Support\Str;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Creations_Views' ) ) {

	class Creations_Views_Hooks extends Creations_Views {

		public static function card_style_square_hooks() {
			add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image_container' ), 30 );
			add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 20 );
			add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 40 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 20 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 30 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 40 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 50 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 60 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 70 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 80 );
			add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
		}

		public static function card_style_centered_hooks() {
			add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 40 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 50 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 60 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 70 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 20 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 30 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 40 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 50 );
			add_action( 'mv_create_card_video_script', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video_script' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 60 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 70 );
			add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
		}

		public static function card_style_centered_dark_hooks() {
			add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 40 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 50 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 60 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 70 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 20 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 30 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 40 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 50 );
			add_action( 'mv_create_card_video_script', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video_script' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 60 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 70 );
			add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
		}

		public static function card_style_big_image_hooks() {
			add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 20 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
			// 'mv_create_rating' is included in print button template
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 40 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 50 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 60 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 70 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 80 );
			add_action( 'mv_create_card_video_script', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video_script' ), 10 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 90 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 100 );
			add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
		}

		public static function list_style_square_hooks() {
			add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 10 );
			add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 20 );
			add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_list' ), 10 );
			add_action( 'mv_create_list_after_single', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_list_ads' ), 10, 3 );
			add_action( 'mv_create_list_after_row', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_list_ads_grid' ), 10, 3 );
		}

		public static function mv_create_schema( $args ) {
			global $id;
			$schema_display = true;
			// Check isset so old cards still display schema,
			// and check empty because of some PHP interpreting `! $var` as strict with 0 strings
			if (
				isset( $args['creation']['schema_display'] ) &&
				empty( $args['creation']['schema_display'] )
			) {
				$schema_display = false;
			}

			// We don't want to output JSON-LD for display in non-canonical posts.
			if ( $id !== (int) $args['creation']['canonical_post_id'] ) {
				$schema_display = false;
			}

			// We don't want to output the JSON-LD to RSS feeds
			if ( is_feed() ) {
				$schema_display = false;
			}

			if ( 'list' === $args['creation']['type'] ) {
				$schema_display = self::check_list_for_schema_items( $args, $schema_display );
			}

			if ( empty( $args['print'] ) && $schema_display && ! empty( $args['creation']['json_ld'] ) ) {
				echo '<script type="application/ld+json">' . $args['creation']['json_ld'] . '</script>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Determine whether or not a list should display schema.
		 *
		 * Checks the items to see if any should be included in schema. If not, don't display.
		 * This will prevent old schema from displaying when items that _should_ display have
		 * been removed from the list, preventing the JSON+LD generation from overwriting the value
		 * in the database.
		 *
		 * @param array $args the whole $args variable
		 * @param boolean $schema_display
		 * @return boolean $should_schema_display
		 */
		public static function check_list_for_schema_items( $args, $schema_display = true ) {
			// If something has already determined that the schema shouldn't display, don't display it.
			if ( ! $schema_display ) {
				return $schema_display;
			}
			$list_items            = $args['creation']['list_items'];
			$should_schema_display = array_filter(
				$list_items,
				function( $item ) {
					// first check that the item type is valid for schema generation
					if ( 'text' === $item['content_type'] ) {
						return false;
					}

					$link = null;
					if ( $item['url'] ) {
						$link = $item['url'];
					} elseif ( ! empty( $item['canonical_post_id'] ) ) {
						$link = get_the_permalink( $item['canonical_post_id'] );
					}
					// if there is no link or it's invalid, don't include it
					if ( ! $link || ! wp_http_validate_url( $link ) ) {
						return false;
					}

					// Don't add external URLs to JSON-LD
					$permalink_host = parse_url( $link );
					$current_host   = parse_url( home_url() );
					// If the link is a subdomain, we want to keep it in the JSON-LD
					// If the link is neither a subdomain nor the primary domain, skip it
					if ( ! Str::contains( $current_host['host'], $permalink_host['host'] ) && ! Str::is( $current_host['host'], $permalink_host['host'] ) ) {
						return false;
					}

					return true;
				}
			);
			return ! empty( $should_schema_display );
		}

		public static function mv_create_title( $args ) {
			self::$views->the_view( 'shortcode-mv-create-title', $args );
		}

		public static function mv_create_pin_button( $args ) {
			// Build Pinterest specific args
			if (
				isset( $args['creation']['pinterest_img'] ) &&
				isset( $args['creation']['pinterest_url'] ) &&
				isset( $args['creation']['pinterest_description'] )
			) {
				$args['pinterest'] = [
					'img'         => $args['creation']['pinterest_img'],
					'url'         => $args['creation']['pinterest_url'],
					'description' => strip_tags( $args['creation']['pinterest_description'] ),
				];

				self::$views->the_view( 'shortcode-mv-create-pin-button', $args );
			}
		}

		public static function mv_create_image_container( $args ) {
			self::$views->the_view( 'shortcode-mv-create-image-container', $args );
		}

		public static function mv_create_image( $args ) {
			self::$views->the_view( 'shortcode-mv-create-image', $args );
		}

		public static function mv_create_rating( $args ) {
			self::$views->the_view( 'shortcode-mv-create-rating', $args );
		}

		public static function mv_create_print_button( $args ) {
			self::$views->the_view( 'shortcode-mv-create-print-button', $args );
		}

		public static function mv_create_description( $args ) {
			self::$views->the_view( 'shortcode-mv-create-description', $args );
		}

		public static function mv_create_times( $args ) {
			self::$views->the_view( 'shortcode-mv-create-times', $args );
		}

		// Displays div for Mediavine ads if Mediavine Control Panel is installed
		public static function mv_create_ad_div( $args ) {
			if (
				class_exists( 'MV_Control_Panel' ) ||
				class_exists( 'MVCP' )
			) {
				$attributes = null;
				if ( 'recipe' !== $args['type'] ) {
					$attributes = ' data-disable-chicory="1"';
				}

				echo wp_kses_post( '<div class="mv-create-target mv-create-primary-unit"><div class="mv_slot_target" data-slot="recipe"' . $attributes . '></div></div>' );
			}
		}

		public static function mv_create_supplies( $args ) {
			self::$views->the_view( 'shortcode-mv-create-supplies', $args );
		}

		public static function mv_create_instructions( $args ) {
			self::$views->the_view( 'shortcode-mv-create-instructions', $args );
		}

		public static function mv_create_notes( $args ) {
			self::$views->the_view( 'shortcode-mv-create-notes', $args );
		}

		public static function mv_create_video( $args ) {
			self::$views->the_view( 'shortcode-mv-create-video', $args, '', true );
		}

		public static function mv_create_products( $args ) {
			self::$views->the_view( 'shortcode-mv-create-products', $args );
		}

		public static function mv_create_nutrition( $args ) {
			self::$views->the_view( 'shortcode-mv-create-nutrition', $args );
		}

		public static function mv_create_list( $args ) {
			if ( empty( $args['creation']['layout'] ) ) {
				return;
			}
			self::$views->the_view( 'shortcode-mv-create-list-' . $args['creation']['layout'], $args );
		}

		/**
		 * Insert ads into `Grid` style lists.
		 *
		 * Because grid-styled lists operate on a different counter, we need
		 * a separate function to determine ad positions.
		 *
		 * This function takes the row count (instead of the index count) and
		 * determines the ad insertion based on number of rows between ads
		 * (as opposed to number of list items between ads).
		 *
		 * @param array $args
		 * @param int $row the row of list items we're on
		 * @param int $count the total number of list items
		 * @return void
		 */
		public static function mv_create_list_ads_grid( $args, $row, $count ) {
			if (
				// make sure there should be ads at all
				(
					class_exists( 'MV_Control_Panel' ) ||
					class_exists( 'MVCP' )
				) &&
				// make sure there are items in the list
				! empty( $args['creation']['list_items_between_ads'] ) &&
				// make sure we're not on the print page
				! $args['print'] &&
				// easy return by making sure this isn't the first row
				( 1 !== $row ) &&
				// if there is a remainder when dividing the row count by the list items between ads seting,
				// we know it is not the correct row to insert an ad
				( 0 === $row % $args['creation']['list_items_between_ads'] ) &&
				// multiply the row by 2 to determine the index of the last item.
				// if it's less than the total number of items, we can insert an ad because
				// the ad will not be the last item in the list. If the index is greater than or equal
				// to the total count of items, we don't want to place an ad.
				( $row * 2 ) < $count
			) {
				echo '<div class="mv-list-adwrap"><div class="mv_slot_target" data-slot="content"></div></div>';
			}
		}

		/**
		 * Insert ads into lists.
		 *
		 * @param array $args
		 * @param int $i the index of the list item
		 * @param int $count the total number of list items
		 * @return void
		 */
		public static function mv_create_list_ads( $args, $i, $count ) {
			if (
				// make sure there should be ads at all
				(
					class_exists( 'MV_Control_Panel' ) ||
					class_exists( 'MVCP' )
				) &&
				// make sure there are items in the list
				! empty( $args['creation']['list_items_between_ads'] ) &&
				// make sure we're not on the print page
				! $args['print'] &&
				// if there is no remainder when dividing the index plus one (to account for 0-indexing)
				// by the number of items between ads setting, we know it is the correct item to insert an ad
				( 0 === ( $i + 1 ) % $args['creation']['list_items_between_ads'] ) &&
				// if there are remaining items, we can insert an ad. if this is the last item, we
				// don't want any ads
				( $i + 1 ) !== $count
			) {
				echo '<div class="mv-list-adwrap"><div class="mv_slot_target" data-slot="content"></div></div>';
			}
		}

		public static function mv_create_footer( $args ) {
			self::$views->the_view( 'shortcode-mv-create-footer', $args );
		}
	}

}
