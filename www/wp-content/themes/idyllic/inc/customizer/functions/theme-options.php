<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
$idyllic_settings = idyllic_get_theme_options();
/********************** IDYLLIC WORDPRESS DEFAULT PANEL ***********************************/
$wp_customize->add_section('header_image', array(
'title' => __('Header Media', 'idyllic'),
'priority' => 20,
'panel' => 'idyllic_wordpress_default_panel'
));
$wp_customize->add_section('colors', array(
'title' => __('Colors', 'idyllic'),
'priority' => 30,
'panel' => 'idyllic_wordpress_default_panel'
));
$wp_customize->add_section('background_image', array(
'title' => __('Background Image', 'idyllic'),
'priority' => 40,
'panel' => 'idyllic_wordpress_default_panel'
));
$wp_customize->add_section('nav', array(
'title' => __('Navigation', 'idyllic'),
'priority' => 50,
'panel' => 'idyllic_wordpress_default_panel'
));
$wp_customize->add_section('static_front_page', array(
'title' => __('Static Front Page', 'idyllic'),
'priority' => 60,
'panel' => 'idyllic_wordpress_default_panel'
));
$wp_customize->add_section('title_tagline', array(
	'title' => __('Site Title & Logo Options', 'idyllic'),
	'priority' => 10,
	'panel' => 'idyllic_wordpress_default_panel'
));

$wp_customize->add_section('idyllic_custom_header', array(
	'title' => __('Idyllic Options', 'idyllic'),
	'priority' => 503,
	'panel' => 'idyllic_options_panel'
));
$wp_customize->add_section('idyllic_footer_image', array(
	'title' => __('Footer Background Image', 'idyllic'),
	'priority' => 510,
	'panel' => 'idyllic_options_panel'
));

/********************  IDYLLIC THEME OPTIONS ******************************************/
$wp_customize->add_setting('idyllic_theme_options[idyllic_header_display]', array(
	'capability' => 'edit_theme_options',
	'default' => $idyllic_settings['idyllic_header_display'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_header_display]', array(
	'label' => __('Site Logo/ Text Options', 'idyllic'),
	'priority' => 102,
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'header_text' => __('Display Site Title Only','idyllic'),
		'header_logo' => __('Display Site Logo Only','idyllic'),
		'show_both' => __('Show Both','idyllic'),
		'disable_both' => __('Disable Both','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_logo_high_resolution]', array(
	'default' => $idyllic_settings['idyllic_logo_high_resolution'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_logo_high_resolution]', array(
	'priority'=>110,
	'label' => __('Logo for high resolution screen(Use 2X size image)', 'idyllic'),
	'section' => 'title_tagline',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_slider_button]', array(
	'default' => $idyllic_settings['idyllic_slider_button'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_slider_button]', array(
	'priority'=>10,
	'label' => __('Disable Slider Button', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_search_custom_header]', array(
	'default' => $idyllic_settings['idyllic_search_custom_header'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_search_custom_header]', array(
	'priority'=>20,
	'label' => __('Disable Search Form', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_side_menu]', array(
	'default' => $idyllic_settings['idyllic_side_menu'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_side_menu]', array(
	'priority'=>25,
	'label' => __('Disable Side Menu', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_stick_menu]', array(
	'default' => $idyllic_settings['idyllic_stick_menu'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_stick_menu]', array(
	'priority'=>30,
	'label' => __('Disable Stick Menu', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_scroll]', array(
	'default' => $idyllic_settings['idyllic_scroll'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_scroll]', array(
	'priority'=>40,
	'label' => __('Disable Goto Top', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_top_social_icons]', array(
	'default' => $idyllic_settings['idyllic_top_social_icons'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_top_social_icons]', array(
	'priority'=>50,
	'label' => __('Disable Top Social Icons', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_side_menu_social_icons]', array(
	'default' => $idyllic_settings['idyllic_side_menu_social_icons'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_side_menu_social_icons]', array(
	'priority'=>60,
	'label' => __('Disable Side Menu Social Icons', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_buttom_social_icons]', array(
	'default' => $idyllic_settings['idyllic_buttom_social_icons'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_buttom_social_icons]', array(
	'priority'=>70,
	'label' => __('Disable Bottom Social Icons', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_wow_effect]', array(
	'default' => $idyllic_settings['idyllic_wow_effect'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_wow_effect]', array(
	'priority'=>80,
	'label' => __('Disable WOW Effect', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_display_page_single_featured_image]', array(
	'default' => $idyllic_settings['idyllic_display_page_single_featured_image'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_display_page_single_featured_image]', array(
	'priority'=>100,
	'label' => __('Disable Page/Single Featured Image', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_fullwidth_feature_single_post]', array(
	'default' => $idyllic_settings['idyllic_fullwidth_feature_single_post'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_fullwidth_feature_single_post]', array(
	'priority'=>110,
	'label' => __('Display full width feature image in single post', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_main_menu]', array(
	'default' => $idyllic_settings['idyllic_disable_main_menu'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_main_menu]', array(
	'priority'=>120,
	'label' => __('Disable Main Menu', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_reset_all]', array(
	'default' => $idyllic_settings['idyllic_reset_all'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'idyllic_reset_alls',
	'transport' => 'postMessage',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_reset_all]', array(
	'priority'=>130,
	'label' => __('Reset all default settings. (Refresh it to view the effect)', 'idyllic'),
	'section' => 'idyllic_custom_header',
	'type' => 'checkbox',
));

/********************** Footer Background Image ***********************************/
$wp_customize->add_setting( 'idyllic_theme_options[idyllic-img-upload-footer-image]',array(
	'default'	=> $idyllic_settings['idyllic-img-upload-footer-image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'idyllic_theme_options[idyllic-img-upload-footer-image]', array(
	'label' => __('Footer Background Image','idyllic'),
	'description' => __('Image will be displayed on footer','idyllic'),
	'priority'	=> 50,
	'section' => 'idyllic_footer_image',
	)
));