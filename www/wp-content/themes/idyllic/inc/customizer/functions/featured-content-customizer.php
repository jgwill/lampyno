<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/******************** IDYLLIC SLIDER SETTINGS ******************************************/
$idyllic_settings = idyllic_get_theme_options();
$wp_customize->add_section( 'featured_content', array(
	'title' => __( 'Slider Settings', 'idyllic' ),
	'priority' => 140,
	'panel' => 'idyllic_featuredcontent_panel'
));

$wp_customize->add_section( 'slider_category_content', array(
	'title' => __( 'Select Category Slider', 'idyllic' ),
	'priority' => 150,
	'panel' => 'idyllic_featuredcontent_panel'
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_slider_design_layout]', array(
	'default' => $idyllic_settings['idyllic_slider_design_layout'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_slider_design_layout]', array(
	'priority'=>10,
	'label' => __('Slider Design Layout', 'idyllic'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'layer-slider' => __('Layer Slider','idyllic'),
		'multi-slider' => __('Multi slider','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_enable_slider]', array(
	'default' => $idyllic_settings['idyllic_enable_slider'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_enable_slider]', array(
	'priority'=>20,
	'label' => __('Enable Slider', 'idyllic'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'frontpage' => __('Front Page','idyllic'),
		'enitresite' => __('Entire Site','idyllic'),
		'disable' => __('Disable Slider','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_secondary_button_color', array(
	'default'           => '#3dace1',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'idyllic_secondary_button_color', array( // Secondary Button Color
	'priority'					=> 30,
	'label'=> __('Secondary Button Color', 'idyllic'),
	'section'     => 'featured_content',
) ) );

$wp_customize->add_setting('idyllic_theme_options[idyllic_secondary_text]', array(
	'default' =>$idyllic_settings['idyllic_secondary_text'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_secondary_text]', array(
	'priority' =>40,
	'label' => __('Secondary Button Text', 'idyllic'),
	'section' => 'featured_content',
	'type' => 'text',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_secondary_url]', array(
	'default' =>$idyllic_settings['idyllic_secondary_url'],
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_secondary_url]', array(
	'priority' =>50,
	'label' => __('Secondary Button Url', 'idyllic'),
	'section' => 'featured_content',
	'type' => 'text',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_animation_effect]', array(
	'default' => $idyllic_settings['idyllic_animation_effect'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_animation_effect]', array(
	'priority'=>60,
	'label' => __('Animation Effect', 'idyllic'),
	'description' => __('This feature will not work on Multi Slider','idyllic'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'slide' => __('Slide','idyllic'),
		'fade' => __('Fade','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_slideshowSpeed]', array(
	'default' => $idyllic_settings['idyllic_slideshowSpeed'],
	'sanitize_callback' => 'idyllic_numeric_value',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_slideshowSpeed]', array(
	'priority'=>70,
	'label' => __('Set the speed of the slideshow cycling', 'idyllic'),
	'section' => 'featured_content',
	'type' => 'text',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_animationSpeed]', array(
	'default' => $idyllic_settings['idyllic_animationSpeed'],
	'sanitize_callback' => 'idyllic_numeric_value',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_animationSpeed]', array(
	'priority'=>80,
	'label' => __(' Set the speed of animations', 'idyllic'),
	'description' => __('This feature will not work on Animation Effect set to fade','idyllic'),
	'section' => 'featured_content',
	'type' => 'text',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_slider_content_bg_color]', array(
	'default' =>$idyllic_settings['idyllic_slider_content_bg_color'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_slider_content_bg_color]', array(
	'priority' =>90,
	'label' => __('Slider Content With background color', 'idyllic'),
	'description' => __('This feature will not work on Multislider','idyllic'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
	'on' => __('Show Background Color','idyllic'),
	'off' => __('Hide Background Color','idyllic'),
	),
));

/* Select your category to display Slider */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_category_slider]', array(
		'default'				=>array(),
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'idyllic_sanitize_latest_from_blog_select',
		'type'				=> 'option'
	));
$wp_customize->add_control(
	new Idyllic_Category_Control(
	$wp_customize,
	'idyllic_theme_options[idyllic_category_slider]',
		array(
			'priority' 				=> 10,
			'label'					=> __('Select Slider Category','idyllic'),
			'description'			=> __('By default it will display all post','idyllic'),
			'section'				=> 'slider_category_content',
			'settings'				=> 'idyllic_theme_options[idyllic_category_slider]',
			'type'					=>'select'
		)
	)
);