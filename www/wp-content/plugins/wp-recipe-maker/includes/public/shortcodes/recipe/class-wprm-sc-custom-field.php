<?php
/**
 * Handle the recipe custom field shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe custom field shortcode.
 *
 * @since      5.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Custom_Field extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-recipe-custom-field';

	public static function init() {
		self::$attributes = array(
			'id' => array(
				'default' => '0',
			),
			'key' => array(
				'default' => '',
				'type' => 'dropdown',
				'options' => 'custom_fields',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'image_size' => array(
				'default' => 'thumbnail',
				'type' => 'image_size',
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	5.2.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$output = '';
		// Show teaser for Premium only shortcode in Template editor.
		if ( $atts['is_template_editor_preview'] ) {
			$output = '<div class="wprm-template-editor-premium-only">Custom Fields are only available in the <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/">WP Recipe Maker Pro Bundle</a>.</div>';
		}

		$recipe = WPRM_Template_Shortcodes::get_recipe( $atts['id'] );

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}
}

WPRM_SC_Custom_Field::init();