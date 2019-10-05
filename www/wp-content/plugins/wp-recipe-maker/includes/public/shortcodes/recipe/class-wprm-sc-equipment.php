<?php
/**
 * Handle the recipe equipment shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.3.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe equipment shortcode.
 *
 * @since      3.3.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Equipment extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-recipe-equipment';

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
			'display_style' => array(
				'default' => 'list',
				'type' => 'dropdown',
				'options' => array(
					'list' => 'List',
					'images' => 'Images',
				),
			),
			'list_style' => array(
				'default' => 'disc',
				'type' => 'dropdown',
				'options' => 'list_style_types',
				'dependency' => array(
					'id' => 'display_style',
					'value' => 'list',
				),
			),
			'image_size' => array(
				'default' => '100x100',
				'type' => 'image_size',
				'dependency' => array(
					'id' => 'display_style',
					'value' => 'images',
				),
			),
			'image_alignment' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Centered',
					'right' => 'Right',
					'spaced' => 'Spaced Evenly',
				),
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.3.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$recipe = WPRM_Template_Shortcodes::get_recipe( $atts['id'] );
		if ( ! $recipe || ! $recipe->equipment() ) {
			return '';
		}

		// Output.
		$classes = array(
			'wprm-recipe-equipment-container',
			'wprm-block-text-' . $atts['text_style'],
		);

		$output = '<div class="' . implode( ' ', $classes ) . '">';

		if ( $atts['header'] ) {
			$classes = array(
				'wprm-recipe-header',
				'wprm-recipe-equipment-header',
				'wprm-block-text-' . $atts['header_style'],
			);

			$tag = trim( $atts['header_tag'] );
			$output .= '<' . $tag . ' class="' . implode( ' ', $classes ) . '">' . __( $atts['header'], 'wp-recipe-maker' ) . '</' . $tag . '>';
		}

		if ( 'list' === $atts['display_style'] ) {
			$output .= '<ul class="wprm-recipe-equipment wprm-recipe-equipment-list">';
			foreach ( $recipe->equipment() as $equipment ) {
				$list_style_type = 'checkbox' === $atts['list_style'] ? 'none' : $atts['list_style'];
				$style = 'list-style-type: ' . $list_style_type . ';';
				$output .= '<li class="wprm-recipe-equipment-item" style="' . $style . '">';

				// Output checkbox.
				if ( 'checkbox' === $atts['list_style'] ) {
					$output = apply_filters( 'wprm_recipe_equipment_shortcode_checkbox', $output );
				}

				// Equipment link.
				$name = apply_filters( 'wprm_recipe_equipment_shortcode_link', $equipment['name'], $equipment );

				$output .= '<div class="wprm-recipe-equipment-name">' . $name . '</div>';
				$output .= '</li>';
			}
			$output .= '</ul>';
		} else {
			$output = apply_filters( 'wprm_recipe_equipment_shortcode_display', $output, $atts, $recipe );
		}

		$output .= '</div>';

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}
}

WPRM_SC_Equipment::init();