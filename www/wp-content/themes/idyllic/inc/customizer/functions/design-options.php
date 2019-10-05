<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
$idyllic_settings = idyllic_get_theme_options();
/******************** IDYLLIC LAYOUT OPTIONS ******************************************/
$wp_customize->add_section('idyllic_layout_options', array(
	'title' => __('Layout Options', 'idyllic'),
	'priority' => 102,
	'panel' => 'idyllic_options_panel'
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_header_design_layout]', array(
	'default' => $idyllic_settings['idyllic_header_design_layout'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_header_design_layout]', array(
	'priority' =>10,
	'label' => __('Multi Header Design Layout', 'idyllic'),
	'description' => __('Header design one and two is not supported for multi slider','idyllic'),
	'section' => 'idyllic_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'' => __('Default','idyllic'),
		'top-logo-title' => __('Top/center logo & site title','idyllic'),
		'box-slider' => __('Box slider','idyllic'),
		'header-item-one' => __('Header Design One (Use Dark Image in Slider)','idyllic'),
		'header-item-two' => __('Header Design Two','idyllic'),
	),
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_responsive]', array(
	'default' => $idyllic_settings['idyllic_responsive'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_responsive]', array(
	'priority' =>20,
	'label' => __('Responsive Layout', 'idyllic'),
	'section' => 'idyllic_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'on' => __('ON ','idyllic'),
		'off' => __('OFF','idyllic'),
	),
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_blog_layout]', array(
	'default' => $idyllic_settings['idyllic_blog_layout'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_blog_layout]', array(
	'priority' =>30,
	'label' => __('Blog Layout', 'idyllic'),
	'section'    => 'idyllic_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'large_image_display' => __('Blog with large Image','idyllic'),
		'medium_image_display' => __('Blog with small Image','idyllic'),
		'two_column_image_display' => __('Blog with Two Column','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_entry_meta_single]', array(
	'default' => $idyllic_settings['idyllic_entry_meta_single'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_entry_meta_single]', array(
	'priority'=>40,
	'label' => __('Disable Entry Meta from Single Page', 'idyllic'),
	'section' => 'idyllic_layout_options',
	'type' => 'select',
	'choices' => array(
		'show' => __('Display Entry Format','idyllic'),
		'hide' => __('Hide Entry Format','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_entry_meta_blog]', array(
	'default' => $idyllic_settings['idyllic_entry_meta_blog'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_entry_meta_blog]', array(
	'priority'=>50,
	'label' => __('Disable Entry Meta from Blog Page', 'idyllic'),
	'section' => 'idyllic_layout_options',
	'type'	=> 'select',
	'choices' => array(
		'show-meta' => __('Display Entry Meta','idyllic'),
		'hide-meta' => __('Hide Entry Meta','idyllic'),
	),
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_blog_content_layout]', array(
   'default'        => $idyllic_settings['idyllic_blog_content_layout'],
   'sanitize_callback' => 'idyllic_sanitize_select',
   'type'                  => 'option',
   'capability'            => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_blog_content_layout]', array(
   'priority'  =>55,
   'label'      => __('Blog Content Display', 'idyllic'),
   'section'    => 'idyllic_layout_options',
   'type'       => 'select',
   'checked'   => 'checked',
   'choices'    => array(
       'fullcontent_display' => __('Blog Full Content Display','idyllic'),
       'excerptblog_display' => __(' Excerpt  Display','idyllic'),
   ),
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_design_layout]', array(
	'default'        => $idyllic_settings['idyllic_design_layout'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type'                  => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_design_layout]', array(
	'priority'  =>60,
	'label'      => __('Design Layout', 'idyllic'),
	'section'    => 'idyllic_layout_options',
	'type'       => 'select',
	'checked'   => 'checked',
	'choices'    => array(
		'full-width-layout' => __('Full Width Layout','idyllic'),
		'boxed-layout' => __('Boxed Layout','idyllic'),
		'small-boxed-layout' => __('Small Boxed Layout','idyllic'),
	),
));