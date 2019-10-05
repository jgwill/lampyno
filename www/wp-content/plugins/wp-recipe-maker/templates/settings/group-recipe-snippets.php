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

$recipe_snippets = array(
	'id' => 'recipeSnippets',
	'name' => __( 'Recipe Snippets', 'wp-recipe-maker' ),
	'subGroups' => array(
		array(
			'description' => __( 'Use the [wprm-recipe-snippet] shortcode or automatically add a snippet above the post content with the setting. Can be used for the Jump to Recipe and Print Recipe buttons, for example.', 'wp-recipe-maker' ),
			'documentation' => 'https://help.bootstrapped.ventures/article/28-recipe-snippets',
			'dependency' => array(
				'id' => 'recipe_template_mode',
				'value' => 'modern',
			),
			'settings' => array(
				array(
					'id' => 'recipe_snippets_automatically_add_modern',
					'name' => __( 'Automatically add snippets', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'recipe_snippets_template',
					'name' => __( 'Template to output', 'wp-recipe-maker' ),
					'description' => __( 'Use shortcodes where you want the snippets to appear.', 'wp-recipe-maker' ),
					'type' => 'dropdownTemplateModern',
					'default' => 'snippet-basic-buttons',
				),
				array(
					'name' => __( 'Template Editor', 'wp-recipe-maker' ),
					'documentation' => 'https://help.bootstrapped.ventures/article/53-template-editor',
					'type' => 'button',
					'button' => __( 'Open the Template Editor', 'wp-recipe-maker' ),
					'link' => admin_url( 'admin.php?page=wprm_template_editor' ),
				),
			),
		),
		array(
			'description' => __( 'Use the [wprm-recipe-snippet] shortcode or automatically add a snippet above the post content with the setting. Can be used for the Jump to Recipe and Print Recipe buttons, for example.', 'wp-recipe-maker' ),
			'documentation' => 'https://help.bootstrapped.ventures/article/28-recipe-snippets',
			'dependency' => array(
				'id' => 'recipe_template_mode',
				'value' => 'legacy',
			),
			'settings' => array(
				array(
					'id' => 'recipe_snippets_automatically_add',
					'name' => __( 'Automatically add snippets', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => false,
				),
				array(
					'id' => 'recipe_snippets_text',
					'name' => __( 'Text to output', 'wp-recipe-maker' ),
					'description' => __( 'Use shortcodes where you want the snippets to appear.', 'wp-recipe-maker' ),
					'type' => 'text',
					'default' => '[wprm-recipe-jump] [wprm-recipe-print]',
				),
				array(
					'id' => 'recipe_snippets_alignment',
					'name' => __( 'Snippet Alignment', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'left' => __( 'Left', 'wp-recipe-maker' ),
						'center' => __( 'Center', 'wp-recipe-maker' ),
						'right' => __( 'Right', 'wp-recipe-maker' ),
					),
					'default' => 'center',
				),
				array(
					'id' => 'recipe_snippets_background_color',
					'name' => __( 'Background Color', 'wp-recipe-maker' ),
					'type' => 'color',
					'default' => '#2c3e50',
					'dependency' => array(
						array(
							'id' => 'recipe_snippets_automatically_add',
							'value' => true,
						),
						array(
							'id' => 'features_custom_style',
							'value' => true,
						),
					),
				),
				array(
					'id' => 'recipe_snippets_text_color',
					'name' => __( 'Text Color', 'wp-recipe-maker' ),
					'type' => 'color',
					'default' => '#ffffff',
					'dependency' => array(
						array(
							'id' => 'recipe_snippets_automatically_add',
							'value' => true,
						),
						array(
							'id' => 'features_custom_style',
							'value' => true,
						),
					),
				),
			),
		),
	),
);
