<?php
/**
 * Template for the plugin settings structure.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/settings
 */

$adjustable_servings = array(
	'id' => 'adjustableServings',
	'name' => __( 'Adjustable Servings', 'wp-recipe-maker' ),
	'description' => __( 'Allow visitors to adjust the serving size of your recipes.', 'wp-recipe-maker' ),
	'documentation' => 'https://help.bootstrapped.ventures/article/23-adjustable-servings',
	'required' => 'premium',
	'subGroups' => array(
		array(
			'dependency' => array(
				'id' => 'recipe_template_mode',
				'value' => 'legacy',
			),
			'settings' => array(
				array(
					'id' => 'features_adjustable_servings',
					'name' => __( 'Enable Adjustable Servings', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => true,
				),
				array(
					'id' => 'servings_changer_display',
					'name' => __( 'Display Type', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'tooltip_slider' => __( 'Slider in Tooltip', 'wp-recipe-maker' ),
						'text_field' => __( 'Text Field', 'wp-recipe-maker' ),
					),
					'dependency' => array(
						'id' => 'features_adjustable_servings',
						'value' => true,
					),
					'default' => 'tooltip_slider',
				),
			),
		),
		array(
			'settings' => array(
				array(
					'id' => 'adjustable_servings_round_to_decimals',
					'name' => __( 'Round quantity to', 'wp-recipe-maker' ),
					'description' => __( 'Number of decimals to round a quantity to after adjusting the serving size.', 'wp-recipe-maker' ),
					'type' => 'number',
					'suffix' => 'decimals',
					'default' => '2',
				),
			),
		),
	),
);
