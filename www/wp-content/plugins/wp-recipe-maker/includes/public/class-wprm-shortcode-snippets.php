<?php
/**
 * Handle the recipe snippets shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.6.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe snippets shortcode.
 *
 * @since      5.6.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Shortcode_Snippets {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_shortcode( 'wprm-recipe-snippet', array( __CLASS__, 'recipe_snippet_shortcode' ) );

		add_filter( 'the_content', array( __CLASS__, 'automatically_add_recipe_snippets' ), 20 );
		add_filter( 'get_the_excerpt', array( __CLASS__, 'remove_automatic_snippets' ), 9 );
		add_filter( 'get_the_excerpt', array( __CLASS__, 'readd_automatic_snippets' ), 11 );
	}

	/**
	 * Output for the recipe snippet shortcode.
	 *
	 * @since	4.1.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function recipe_snippet_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'template' => '',
		), $atts, 'wprm_recipe_snippet' );

		if ( ! is_feed() && ! is_front_page() && is_singular() && is_main_query() ) {
			$recipe = WPRM_Template_Shortcodes::get_current_recipe_id();

			if ( $recipe ) {
				WPRM_Assets::load();

				if ( 'legacy' === WPRM_Settings::get( 'recipe_template_mode' ) ) {
					$alignment = WPRM_Settings::get( 'recipe_snippets_alignment' );
					return '<div class="wprm-recipe-snippets" style="text-align: ' . esc_attr( $alignment ) . ';">' . do_shortcode( WPRM_Settings::get( 'recipe_snippets_text' ) ) . '</div>';
				} else {
					$template = false;
					$template_slug = trim( $atts['template'] );
	
					if ( $template_slug ) {
						$template = WPRM_Template_Manager::get_template_by_slug( $template_slug );
					}
	
					if ( ! $template ) {
						$template = WPRM_Template_Manager::get_template_by_type( 'snippet' );
					}

					if ( $template ) {
						// Add to used templates.
						WPRM_Template_Manager::add_used_template( $template );

						return '<div class="wprm-recipe wprm-recipe-snippet wprm-recipe-template-' . $template['slug'] . '">' . do_shortcode( $template['html'] ) . '</div>';
					}
				}
			}
		}

		return '';
	}

	/**
	 * Automatically add recipe snippets above the post content.
	 *
	 * @since    1.26.0
	 * @param	 mixed $content Content we want to filter before it gets passed along.
	 */
	public static function automatically_add_recipe_snippets( $content ) {
		if ( ! is_feed() && ! is_front_page() && is_single() && is_main_query() ) {

			if ( 'legacy' === WPRM_Settings::get( 'recipe_template_mode' ) && WPRM_Settings::get( 'recipe_snippets_automatically_add' ) ) {
				$snippet = do_shortcode( '[wprm-recipe-snippet]' );
				$content = '<div class="wprm-automatic-recipe-snippets">' . $snippet . '</div>' . $content;
			} else if ( 'modern' === WPRM_Settings::get( 'recipe_template_mode' ) && WPRM_Settings::get( 'recipe_snippets_automatically_add_modern' ) ) {
				$snippet = do_shortcode( '[wprm-recipe-snippet]' );
				$content = $snippet . $content;
			}
		}

		return $content;
	}


	/**
	 * Don't automatically add snippets when getting the excerpt.
	 *
	 * @since    5.6.0
	 */
	public static function remove_automatic_snippets( $excerpt ) {
		remove_filter( 'the_content', array( __CLASS__, 'automatically_add_recipe_snippets' ), 20 );
		return $excerpt;
	}
	public static function readd_automatic_snippets( $excerpt ) {
		add_filter( 'the_content', array( __CLASS__, 'automatically_add_recipe_snippets' ), 20 );
		return $excerpt;
	}
}

WPRM_Shortcode_Snippets::init();
