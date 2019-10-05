<?php
/**
 * Responsible for handling the find ratings tool.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.6.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Responsible for handling the find ratings tool.
 *
 * @since      5.6.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Tools_Find_Ratings {

	/**
	 * Register actions and filters.
	 *
	 * @since	5.6.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 20 );
		add_action( 'wp_ajax_wprm_finding_ratings', array( __CLASS__, 'ajax_finding_ratings' ) );
	}

	/**
	 * Add the tools submenu to the WPRM menu.
	 *
	 * @since	5.6.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( null, __( 'Finding Ratings', 'wp-recipe-maker' ), __( 'Finding Ratings', 'wp-recipe-maker' ), WPRM_Settings::get( 'features_tools_access' ), 'wprm_finding_ratings', array( __CLASS__, 'finding_ratings' ) );
	}

	/**
	 * Get the template for the finding ratings page.
	 *
	 * @since    2.2.0
	 */
	public static function finding_ratings() {
		$args = array(
			'post_type' => WPRM_POST_TYPE,
			'post_status' => 'all',
			'posts_per_page' => -1,
			'fields' => 'ids',
		);

		$posts = get_posts( $args );

		// Make sure rating DB is on latest version.
		WPRM_Rating_Database::update_database( '0.0' );

		// Only when debugging.
		if ( WPRM_Tools_Manager::$debugging ) {
			$result = self::find_ratings( $posts ); // Input var okay.
			var_dump( $result );
			die();
		}

		// Handle via AJAX.
		wp_localize_script( 'wprm-admin', 'wprm_tools', array(
			'action' => 'finding_ratings',
			'posts' => $posts,
			'args' => array(),
		));

		require_once( WPRM_DIR . 'templates/admin/menu/tools/finding-ratings.php' );
	}

	/**
	 * Find ratings through AJAX.
	 *
	 * @since    2.1.0
	 */
	public static function ajax_finding_ratings() {
		if ( check_ajax_referer( 'wprm', 'security', false ) ) {
			$posts = isset( $_POST['posts'] ) ? json_decode( wp_unslash( $_POST['posts'] ) ) : array(); // Input var okay.

			$posts_left = array();
			$posts_processed = array();

			if ( count( $posts ) > 0 ) {
				$posts_left = $posts;
				$posts_processed = array_map( 'intval', array_splice( $posts_left, 0, 10 ) );

				$result = self::find_ratings( $posts_processed );

				if ( is_wp_error( $result ) ) {
					wp_send_json_error( array(
						'redirect' => add_query_arg( array( 'sub' => 'advanced' ), admin_url( 'admin.php?page=wprm_tools' ) ),
					) );
				}
			}

			wp_send_json_success( array(
				'posts_processed' => $posts_processed,
				'posts_left' => $posts_left,
			) );
		}

		wp_die();
	}

	/**
	 * Find recipes in posts to link parents.
	 *
	 * @since	2.1.0
	 * @param	array $posts IDs of posts to search.
	 */
	public static function find_ratings( $posts ) {
		foreach ( $posts as $post_id ) {
			$recipe = WPRM_Recipe_Manager::get_recipe( $post_id );

			if ( $recipe ) {
				// Get comment ratings.
				$comments = array();

				if ( $recipe->parent_post_id() ) {
					$args = array(
						'post_id' => $recipe->parent_post_id(),
						'status' => array( 'all', 'trash' ),
					);
					$comments = get_comments( $args );
				}

				foreach ( $comments as $comment ) {
					$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'wprm-comment-rating', true ) );

					if ( ! $comment_rating ) {
						// Check for EasyRecipe or WP Tasty rating.
						$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'ERRating', true ) );
					}

					if ( ! $comment_rating ) {
						// Check for Cookbook rating.
						$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'cookbook_comment_rating', true ) );
					}

					if ( ! $comment_rating ) {
						// Check for SRP rating.
						$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'recipe_rating', true ) );
					}

					if ( ! $comment_rating ) {
						// Check for Comment Rating Field rating.
						$crfp_ratings = get_comment_meta( $comment->comment_ID, 'crfp', true );

						if ( is_array( $crfp_ratings ) ) {
							$comment_rating = intval( reset( $crfp_ratings ) );
						}
					}

					if ( $comment_rating ) {
						$rating = array(
							'date' => $comment->comment_date,
							'comment_id' => $comment->comment_ID,
							'user_id' => $comment->user_id,
							'ip' => $comment->comment_author_IP,
							'rating' => $comment_rating,
						);

						WPRM_Rating_Database::add_or_update_rating( $rating );
					}
				}

				// Get user ratings.
				// SRP User Ratings.
				$srp_user_ratings = get_post_meta( $recipe->parent_post_id(), '_ratings', true );

				if ( $srp_user_ratings ) {
					$srp_user_ratings = json_decode( $srp_user_ratings, true );

					foreach ( $srp_user_ratings as $user_or_ip => $rating_value ) {
						if ( '' . intval( $user_or_ip ) === '' . $user_or_ip ) {
							$rating = array(
								'recipe_id' => $recipe->id(),
								'user_id' => $user_or_ip,
								'ip' => '',
								'rating' => $rating_value,
							);
						} else {
							$rating = array(
								'recipe_id' => $recipe->id(),
								'user_id' => 0,
								'ip' => $user_or_ip,
								'rating' => $rating_value,
							);
						}

						WPRM_Rating_Database::add_or_update_rating( $rating );
					}
				}

				// WPRM User Ratings.
				$user_ratings = get_post_meta( $post_id, 'wprm_user_ratings' );

				foreach ( $user_ratings as $user_rating ) {
					if ( isset( $user_rating['rating'] ) ) {
						$rating = array(
							'date' => '2000-01-01 00:00:00',
							'recipe_id' => $post_id,
							'user_id' => $user_rating['user'],
							'ip' => $user_rating['ip'],
							'rating' => $user_rating['rating'],
						);

						WPRM_Rating_Database::add_or_update_rating( $rating );
					}
				}

				// Always update recipe rating cache.
				WPRM_Rating::update_recipe_rating( $recipe->ID() );
			}
		}
	}
}

WPRM_Tools_Find_Ratings::init();
