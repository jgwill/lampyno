<?php
/**
 * Handle the recipe instructions shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.3.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe instructions shortcode.
 *
 * @since      3.3.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Instructions extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-recipe-instructions';

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
			'group_tag' => array(
				'default' => 'h4',
				'type' => 'dropdown',
				'options' => 'header_tags',
			),
			'group_style' => array(
				'default' => 'bold',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'list_style' => array(
				'default' => 'decimal',
				'type' => 'dropdown',
				'options' => 'list_style_types',
			),
			'text_margin' => array(
				'default' => '0px',
				'type' => 'size',
			),
			'image_size' => array(
				'default' => 'thumbnail',
				'type' => 'image_size',
			),
			'image_alignment' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
			),
			'image_position' => array(
				'default' => 'after',
				'type' => 'dropdown',
				'options' => array(
					'before' => 'Before Text',
					'after' => 'After Text',
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
		if ( ! $recipe || ! $recipe->instructions() ) {
			return '';
		}

		// Output.
		$classes = array(
			'wprm-recipe-instructions-container',
			'wprm-block-text-' . $atts['text_style'],
		);

		$output = '<div class="' . implode( ' ', $classes ) . '">';

		if ( $atts['header'] ) {
			$classes = array(
				'wprm-recipe-header',
				'wprm-recipe-instructions-header',
				'wprm-block-text-' . $atts['header_style'],
			);

			$tag = trim( $atts['header_tag'] );
			$output .= '<' . $tag . ' class="' . implode( ' ', $classes ) . '">' . __( $atts['header'], 'wp-recipe-maker' ) . '</' . $tag . '>';
		}

		$instructions = $recipe->instructions();
		foreach ( $instructions as $group_index => $instruction_group ) {
			$output .= '<div class="wprm-recipe-instruction-group">';

			if ( $instruction_group['name'] ) {
				$classes = array(
					'wprm-recipe-group-name',
					'wprm-recipe-instruction-group-name',
					'wprm-block-text-' . $atts['group_style'],
				);

				$tag = trim( $atts['group_tag'] );
				$output .= '<' . $tag . ' class="' . implode( ' ', $classes ) . '">' . $instruction_group['name'] . '</' . $tag . '>';
			}

			$output .= '<ul class="wprm-recipe-instructions">';

			foreach ( $instruction_group['instructions'] as $index => $instruction ) {
				$list_style_type = 'checkbox' === $atts['list_style'] ? 'none' : $atts['list_style'];
				$style = 'list-style-type: ' . $list_style_type . ';';
				$output .= '<li id="wprm-recipe-' . $recipe->id() . '-step-' . $group_index . '-' . $index . '" class="wprm-recipe-instruction" style="' . $style . '">';

				// Output checkbox.
				if ( 'checkbox' === $atts['list_style'] ) {
					$output = apply_filters( 'wprm_recipe_instructions_shortcode_checkbox', $output );
				}

				if ( 'before' === $atts['image_position'] && $instruction['image'] ) {
					$output .= '<div class="wprm-recipe-instruction-image" style="text-align: ' . $atts['image_alignment'] . ';">' . self::instruction_image( $recipe, $instruction, $atts['image_size'] ) . '</div> ';
				}
				if ( $instruction['text'] ) {
					$text_style = '';
					if ( '0px' !== $atts['text_margin'] ) {
						$text_style = ' style="margin-bottom: ' . $atts['text_margin'] . '"';
					}

					$text = parent::clean_paragraphs( $instruction['text'] );
					$output .= '<div class="wprm-recipe-instruction-text"' . $text_style . '>' . $text . '</div> ';
				}
				if ( 'after' === $atts['image_position'] && $instruction['image'] ) {
					$output .= '<div class="wprm-recipe-instruction-image" style="text-align: ' . $atts['image_alignment'] . ';">' . self::instruction_image( $recipe, $instruction, $atts['image_size'] ) . '</div> ';
				}

				$output .= '</li>';
			}

			$output .= '</ul>';
			$output .= '</div>';
		}

		$output .= '</div>';

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}

	/**
	 * Output an instruction image.
	 *
	 * @since	3.3.0
	 * @param	mixed $recipe			  Recipe to output the instruction for.
	 * @param	mixed $instruction		  Instruction to output the image for.
	 * @param	mixed $default_image_size Default image size to use.
	 */
	private static function instruction_image( $recipe, $instruction, $default_image_size ) {
		$settings_size = 'legacy' === WPRM_Settings::get( 'recipe_template_mode' ) ? WPRM_Settings::get( 'template_instruction_image' ) : false;
		$size = $settings_size ? $settings_size : $default_image_size;

		preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
		if ( ! empty( $match ) ) {
			$size = array( intval( $match[1] ), intval( $match[2] ) );
		}

		$img = wp_get_attachment_image( $instruction['image'], $size );

		// Prevent instruction image from getting stretched in Gutenberg preview.
		if ( isset( $GLOBALS['wp']->query_vars['rest_route'] ) && '/wp/v2/block-renderer/wp-recipe-maker/recipe' === $GLOBALS['wp']->query_vars['rest_route'] ) {
			$image_data = wp_get_attachment_image_src( $instruction['image'], $size );
			if ( $image_data[1] ) {
				$style = 'max-width: ' . $image_data[1] . 'px;';

				if ( false !== stripos( $img, ' style="' ) ) {
					$img = str_ireplace( ' style="', ' style="' . $style, $img );
				} else {
					$img = str_ireplace( '<img ', '<img style="' . $style . '" ', $img );
				}
			}
		}

		// Disable instruction image pinning.
		if ( WPRM_Settings::get( 'pinterest_nopin_instruction_image' ) ) {
			$img = str_ireplace( '<img ', '<img data-pin-nopin="true" ', $img );
		}

		// Clickable images.
		if ( WPRM_Settings::get( 'instruction_image_clickable' ) ) {
			$settings_size = WPRM_Settings::get( 'clickable_image_size' );

			preg_match( '/^(\d+)x(\d+)$/i', $settings_size, $match );
			if ( ! empty( $match ) ) {
				$size = array( intval( $match[1] ), intval( $match[2] ) );
			} else {
				$size = $settings_size;
			}

			$clickable_image = wp_get_attachment_image_src( $instruction['image'], $size );
			$clickable_image_url = $clickable_image && isset( $clickable_image[0] ) ? $clickable_image[0] : '';
			if ( $clickable_image_url ) {
				$img = '<a href="' . esc_url( $clickable_image_url ) . '">' . $img . '</a>';
			}
		}

		return $img;
	}
}

WPRM_SC_Instructions::init();