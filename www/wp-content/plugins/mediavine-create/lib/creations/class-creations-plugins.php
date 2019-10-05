<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Creations' ) ) {

	/**
	 * Class to make Creations compatible with other plugins
	 */
	class Creations_Plugins extends Creations {

		public static $instance = null;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		function init() {
			add_action( 'comment_rating_field_pro_rating_input_save_rating', array( $this, 'update_creation_rating_from_comment_rating_field' ), 10, 3 );
			add_action( 'wp_head', array( $this, 'mv_preclude_srp_json_ld' ), 9 );
			add_action( 'mv_create_card_preview_render_head', array( $this, 'genesis_load_stylesheet' ) );
			add_action( 'mv_create_card_before_print_render', array( $this, 'maybe_remove_wp_accessibility_helper_container' ) );
		}

		/**
		 * Hook run when comment with rating from Comment Rating Field is updated
		 *
		 * @param int $comment_id Comment ID
		 * @param array $group Comment Rating Field group and settings
		 * @param int $rating Rating from comment
		 * @return void
		 */
		public function update_creation_rating_from_comment_rating_field( $comment_id, $group, $rating ) {
			$Reviews_Models = new Reviews_Models();

			// Get associated create cards
			$comment      = get_comment( $comment_id );
			$post_id      = $comment->comment_post_ID;
			$creation_ids = self::get_creation_ids_by_post( $post_id );

			if ( empty( $creation_ids ) ) {
				return;
			}

			// Build review
			$review = array(
				'author_email'   => $comment->comment_author_email,
				'author_name'    => $comment->comment_author,
				'rating'         => $rating,
				'review_content' => $comment->comment_content,
			);

			foreach ( $creation_ids as $creation_id ) {
				$review['creation'] = $creation_id;
				$Reviews_Models->create_review( $review );
			}
		}

		/**
		 * Removes duplicate SRP JSON when Create or FoodFanatic post exists
		 *
		 * @return false|void
		 */
		public function mv_preclude_srp_json_ld() {
			global $post;
			if (
				$post &&
				strpos( $post->post_content, 'mv_create' ) === false &&
				strpos( $post->post_content, 'www.foodfanatic.com/recipes' ) === false
			) {
				return false;
			}
			if ( class_exists( '\SimpleRecipePro\Recipes_Schema' ) ) {
				$_GET['print'] = true;
			}
		}

		/**
		 * Enqueues Genesis styles into theme
		 */
		public function genesis_load_stylesheet() {
			if ( function_exists( 'genesis_load_stylesheet' ) ) {
				genesis_load_stylesheet();
			}
		}

		/**
		 * if active, disable the render of the wp accessibility helper container
		 */
		public function maybe_remove_wp_accessibility_helper_container() {
			if ( has_action( 'wp_footer', 'wp_access_helper_create_container' ) ) {
				remove_action( 'wp_footer', 'wp_access_helper_create_container' );
			}
		}
	}
}
