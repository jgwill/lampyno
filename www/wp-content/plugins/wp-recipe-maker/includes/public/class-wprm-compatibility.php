<?php
/**
 * Handle compabitility with other plugins/themes.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle compabitility with other plugins/themes.
 *
 * @since      3.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Compatibility {

	/**
	 * Register actions and filters.
	 *
	 * @since	3.2.0
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'yoast_seo' ) );
		add_action( 'divi_extensions_init', array( __CLASS__, 'divi' ) );

		// Elementor.
		add_action( 'elementor/controls/controls_registered', array( __CLASS__, 'elementor_controls' ) );
		add_action( 'elementor/preview/enqueue_styles', array( __CLASS__, 'elementor_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', array( __CLASS__, 'elementor_widgets' ) );

		add_filter( 'wpupg_output_grid_post', array( __CLASS__, 'wpupg_set_recipe_id' ) );
	}

	/**
	 * Yoast SEO Compatibility.
	 *
	 * @since	3.2.0
	 */
	public static function yoast_seo() {
		if ( defined( 'WPSEO_VERSION' ) ) {
			wp_enqueue_script( 'wprm-yoast-compatibility', WPRM_URL . 'assets/js/other/yoast-compatibility.js', array( 'jquery' ), WPRM_VERSION, true );
		}
	}

	/**
	 * Divi Builder Compatibility.
	 *
	 * @since	5.1.0
	 */
	public static function divi() {
		// require_once( WPRM_DIR . 'templates/divi/includes/extension.php' );
	}


	/**
	 * Elementor Compatibility.
	 *
	 * @since	5.0.0
	 */
	public static function elementor_controls() {
		include( WPRM_DIR . 'templates/elementor/control.php' );
		\Elementor\Plugin::$instance->controls_manager->register_control( 'wprm-recipe-select', new WPRM_Elementor_Control() );
	}
	public static function elementor_styles() {
		// Make sure default assets load.
		WPRM_Assets::load();
	}
	public static function elementor_widgets() {
		include( WPRM_DIR . 'templates/elementor/widget.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new WPRM_Elementor_Widget() );
	}

	/**
	 * Recipes in WP Ultimate Post Grid Compatibility.
	 *
	 * @since	4.2.0
	 * @param	mixed $post Post getting shown in the grid.
	 */
	public static function wpupg_set_recipe_id( $post ) {
		if ( WPRM_POST_TYPE === $post->post_type ) {
			WPRM_Template_Shortcodes::set_current_recipe_id( $post->ID );
		}

		return $post;
	}
}

WPRM_Compatibility::init();
