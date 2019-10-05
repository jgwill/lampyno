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

$recipe_print = array(
	'id' => 'recipePrint',
	'name' => __( 'Print Version', 'wp-recipe-maker' ),
	'subGroups' => array(
		array(
			'name' => __( 'Default Print Template by Recipe Type', 'wp-recipe-maker' ),
			'dependency' => array(
				'id' => 'recipe_template_mode',
				'value' => 'modern',
			),
			'settings' => array(
				array(
					'id' => 'default_print_template_modern',
					'name' => __( 'Food Recipe Print Template', 'wp-recipe-maker' ),
					'description' => __( 'Default print template to use for the food recipes on your website.', 'wp-recipe-maker' ),
					'type' => 'dropdownTemplateModern',
					'default' => 'compact',
				),
				array(
					'id' => 'default_howto_print_template_modern',
					'name' => __( 'How-to Instructions Print Template', 'wp-recipe-maker' ),
					'description' => __( 'Default print template to use for the how-to instructions on your website.', 'wp-recipe-maker' ),
					'type' => 'dropdownTemplateModern',
					'default' => 'compact-howto',
				),
				array(
					'id' => 'default_other_print_template_modern',
					'name' => __( 'Other Recipe Print Template', 'wp-recipe-maker' ),
					'description' => __( 'Default print template to use for the "other (no metadata)" recipes on your website.', 'wp-recipe-maker' ),
					'type' => 'dropdownTemplateModern',
					'default' => 'compact',
				),
			),
		),
		array(
			'name' => __( 'Appearance', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'default_print_template',
					'name' => __( 'Default Print Template', 'wp-recipe-maker' ),
					'type' => 'dropdownTemplateLegacy',
					'default' => 'clean',
					'dependency' => array(
						'id' => 'recipe_template_mode',
						'value' => 'legacy',
					),
				),
				array(
					'id' => 'print_show_recipe_image',
					'name' => __( 'Show Recipe Image', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'print_show_instruction_images',
					'name' => __( 'Show Instruction Images', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'print_credit',
					'name' => __( 'Print Credit', 'wp-recipe-maker' ),
					'description' => __( 'Optional text to show at the bottom of the print page. You can use HTML and the following placeholders:', 'wp-recipe-maker' ) . ' %recipe_name% %recipe_url% %recipe_date%',
					'type' => 'richTextarea',
					'default' => '',
				),
			),
		),
		array(
			'name' => __( 'Advanced', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'metadata_pinterest_disable_print_page',
					'name' => __( 'Disable pinning on print page', 'wp-recipe-maker' ),
					'description' => __( 'Enable this setting if you want to prevent people from pinning your print page to Pinterest.', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
			),
		),
	),
);
