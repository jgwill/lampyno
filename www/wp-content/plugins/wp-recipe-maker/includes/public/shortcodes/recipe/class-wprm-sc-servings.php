<?php
/**
 * Handle the recipe servings shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe servings shortcode.
 *
 * @since      3.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Servings extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-recipe-servings';

	public static function init() {
		self::$attributes = array(
			'id' => array(
				'default' => '0',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'adjustable' => array (
				'default' => 'tooltip',
				'type' => 'dropdown',
				'options' => 'adjustable_servings',
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.2.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$recipe = WPRM_Template_Shortcodes::get_recipe( $atts['id'] );
		if ( ! $recipe || ! $recipe->servings() ) {
			return '';
		}

		// Output.
		$classes = array(
			'wprm-recipe-servings',
			'wprm-recipe-details',
			'wprm-block-text-' . $atts['text_style'],
		);

		$output = '<span class="' . implode( ' ', $classes ) . '">' . $recipe->servings() . '</span>';

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}
}

WPRM_SC_Servings::init();