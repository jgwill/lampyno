<?php
/**
 * Handle the recipe printing.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe printing.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Print {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'print_page' ) );

		add_filter( 'wprm_get_template', array( __CLASS__, 'print_credit' ), 10, 3 );
	}

	/**
	 * Check if someone is trying to reach the print page.
	 *
	 * @since    1.3.0
	 */
	public static function print_page() {
		preg_match( '/[\/\?]wprm_print[\/=](collection|\d+)(\/)?(\?.*)?(\/\?.*)?$/', $_SERVER['REQUEST_URI'], $print_url ); // Input var okay.
		$recipe_id = isset( $print_url[1] ) ? $print_url[1] : false; 

		if ( $recipe_id ) {
			// Prevent WP Rocket lazy image loading on print page.
			add_filter( 'do_rocket_lazyload', '__return_false' );

			switch ( $recipe_id ) {
				case 'collection':
					if ( WPRM_Addons::is_active( 'recipe-collections' ) ) {
						header( 'HTTP/1.1 200 OK' );
						require( WPRMPRC_DIR . 'templates/public/print.php' );
						flush();
						exit;
					}
				default:
					$recipe_id = intval( $recipe_id );
					if ( WPRM_POST_TYPE === get_post_type( $recipe_id ) ) {
						$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

						// Redirect if recipe is not published (and setting enabled).
						if ( WPRM_Settings::get( 'print_published_recipes_only' ) ) {
							if ( 'publish' !== $recipe->post_status() ) {
								wp_redirect( home_url() );
								exit();
							}
						}

						header( 'HTTP/1.1 200 OK' );
						require( WPRM_DIR . 'templates/public/print.php' );
						flush();
						exit;
					}
			}
		}
	}

	/**
	 * Add credit to the print page.
	 *
	 * @since    1.12.0
	 * @param    mixed $template Template we're filtering.
	 * @param    mixed $recipe   Recipe being printed.
	 * @param    mixed $type     Type of the template.
	 */
	public static function print_credit( $template, $recipe, $type ) {
		if ( 'print' === $type ) {
			$credit = WPRM_Settings::get( 'print_credit' );

			if ( $credit ) {
				$template .= '<div id="wprm-print-footer">' . WPRM_Template_Helper::recipe_placeholders( $recipe, $credit ) . '</div>';
			}
		}

		return $template;
	}
}

WPRM_Print::init();
