<?php
/**
 * Handle the recipe nutrition label shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      4.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe nutrition label shortcode.
 *
 * @since      4.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Nutrition_Label extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-nutrition-label';

	public static function init() {
		self::$attributes = array(
			'id' => array(
				'default' => '0',
			),
			'style' => array(
				'default' => 'label',
				'type' => 'dropdown',
				'options' => array(
					'label' => 'Label',
					'simple' => 'Simple Text',
				),
			),
			'label_background_color' => array(
				'default' => '#ffffff',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'label',
				),
			),
			'label_text_color' => array(
				'default' => '#000000',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'label',
				),
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'style',
					'value' => 'label',
					'type' => 'inverse',
				),
			),
			'header' => array(
				'default' => '',
				'type' => 'text',
			),
			'header_tag' => array(
				'default' => 'h3',
				'type' => 'dropdown',
				'options' => 'header_tags',
				'dependency' => array(
					'id' => 'header',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'header_style' => array(
				'default' => 'bold',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'header',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'label_color' => array(
				'default' => '#777777',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'value_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'label_separator' => array(
				'default' => ': ',
				'type' => 'text',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'label_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'nutrition_separator' => array(
				'default' => ' | ',
				'type' => 'text',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'unit_separator' => array(
				'default' => '',
				'type' => 'text',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'daily' => array(
				'default' => '0',
				'type' => 'toggle',
				'dependency' => array(
					'id' => 'style',
					'value' => 'simple',
				),
			),
			'align' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Aligned left',
					'center' => 'Aligned center',
					'right' => 'Aligned right',
				),
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	4.0.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$recipe = WPRM_Template_Shortcodes::get_recipe( $atts['id'] );
		if ( ! $recipe || 'disabled' === $atts['align'] ) {
			return '';
		}

		$output = '';

		// Show teaser for Premium only shortcode in Template editor.
		if ( $atts['is_template_editor_preview'] ) {
			$output = '<div class="wprm-template-editor-premium-only">The Nutrition Label is only available in <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/">WP Recipe Maker Premium</a>.</div>';
		}

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}
}

WPRM_SC_Nutrition_Label::init();