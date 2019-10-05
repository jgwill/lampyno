<?php
/**
 * Responsible for showing admin notices.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Responsible for the privacy policy.
 *
 * @since      5.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Notices {

	/**
	 * Register actions and filters.
	 *
	 * @since    5.0.0
	 */
	public static function init() {
		add_filter( 'wprm_admin_notices', array( __CLASS__, 'new_user_notice' ) );
	}

	/**
	 * Get all notices to show.
	 *
	 * @since    5.0.0
	 */
	public static function get_notices() {
		$notices_to_display = array();
		$current_user_id = get_current_user_id();

		if ( $current_user_id ) {
			$notices = apply_filters( 'wprm_admin_notices', array() );
			$dismissed_notices = get_user_meta( $current_user_id, 'wprm_dismissed_notices', false );

			foreach ( $notices as $notice ) {
				// Check capability.
				if ( isset( $notice['capability'] ) && ! current_user_can( $notice['capability'] ) ) {
					continue;
				}

				// Check if user has already dismissed notice.
				if ( isset( $notice['id'] ) && in_array( $notice['id'], $dismissed_notices ) ) {
					continue;
				}

				$notices_to_display[] = $notice;
			}
		}

		return $notices_to_display;
	}

	/**
	 * Show a notice to new users.
	 *
	 * @since    5.0.0
	 */
	public static function new_user_notice( $notices ) {
		$count = wp_count_posts( WPRM_POST_TYPE )->publish;

		if ( 3 >= intval( $count ) ) {
			$notices[] = array(
				'id' => 'new_user',
				'title' => __( 'Welcome to WP Recipe Maker', 'wp-recipe-maker' ),
				'text' => __( 'Not sure how to get started?', 'wp-recipe-maker' ) . ' <a href="' . esc_url( admin_url( 'admin.php?page=wprm_faq' ) ). '">' . __( 'Check out our documentation!', 'wp-recipe-maker' ) . '</a>',
			);
		}

		return $notices;
	}
}

WPRM_Notices::init();
