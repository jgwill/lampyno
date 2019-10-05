<?php

/**
 * Theme Options Panel.
 *
 * @package Photography Blog
 */

$default = photography_blog_get_default_theme_options();

/*slider and its property section*/
require get_template_directory().'/inc/customizer/slider.php';
require get_template_directory().'/inc/customizer/featured-page.php';
require get_template_directory().'/inc/customizer/featured-blog.php';

// Add Theme Options Panel.
$wp_customize->add_panel('theme_option_panel',
	array(
		'title'      => esc_html__('Theme Options', 'photography-blog'),
		'priority'   => 200,
		'capability' => 'edit_theme_options',
	)
);

/*layout management section start */
$wp_customize->add_section('theme_option_section_settings',
	array(
		'title'      => esc_html__('Layout Management', 'photography-blog'),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

/*Home Page Layout*/
$wp_customize->add_setting('enable_overlay_option',
	array(
		'default'           => $default['enable_overlay_option'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'photography_blog_sanitize_checkbox',
	)
);
$wp_customize->add_control('enable_overlay_option',
	array(
		'label'    => esc_html__('Enable Banner Overlay', 'photography-blog'),
		'section'  => 'theme_option_section_settings',
		'type'     => 'checkbox',
		'priority' => 150,
	)
);

/*Home Page Layout*/
$wp_customize->add_setting('homepage_layout_option',
	array(
		'default'           => $default['homepage_layout_option'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'photography_blog_sanitize_select',
	)
);
$wp_customize->add_control('homepage_layout_option',
	array(
		'label'       => esc_html__('Theme Layout', 'photography-blog'),
		'section'     => 'theme_option_section_settings',
		'choices'     => array(
			'full-width' => esc_html__('Full Width', 'photography-blog'),
			'boxed'      => esc_html__('Boxed', 'photography-blog'),
		),
		'type'     => 'select',
		'priority' => 160,
	)
);

/*Global Layout*/
$wp_customize->add_setting('global_layout',
	array(
		'default'           => $default['global_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'photography_blog_sanitize_select',
	)
);
$wp_customize->add_control('global_layout',
	array(
		'label'          => esc_html__('Sidebar Options', 'photography-blog'),
		'section'        => 'theme_option_section_settings',
		'choices'        => array(
			'left-sidebar'  => esc_html__('Left Sidebar', 'photography-blog'),
			'right-sidebar' => esc_html__('Right Sidebar', 'photography-blog'),
			'no-sidebar'    => esc_html__('No Sidebar', 'photography-blog'),
		),
		'type'     => 'select',
		'priority' => 170,
	)
);

// Setting - read_more_button_text.
$wp_customize->add_setting('read_more_button_text',
	array(
		'default'           => $default['read_more_button_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control('read_more_button_text',
	array(
		'label'    => esc_html__('Button Text for Read More', 'photography-blog'),
		'section'  => 'theme_option_section_settings',
		'type'     => 'text',
		'priority' => 170,
	)
);

/*content excerpt in global*/
$wp_customize->add_setting('excerpt_length_global',
	array(
		'default'           => $default['excerpt_length_global'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'photography_blog_sanitize_positive_integer',
	)
);
$wp_customize->add_control('excerpt_length_global',
	array(
		'label'       => esc_html__('Archive Excerpt Length', 'photography-blog'),
		'section'     => 'theme_option_section_settings',
		'type'        => 'number',
		'priority'    => 175,
		'input_attrs' => array('min' => 1, 'max' => 200, 'style' => 'width: 150px;'),

	)
);


// Pagination Section.
$wp_customize->add_section('pagination_section',
	array(
		'title'      => esc_html__('Pagination Options', 'photography-blog'),
		'priority'   => 110,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting pagination_type.
$wp_customize->add_setting('pagination_type',
	array(
		'default'           => $default['pagination_type'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'photography_blog_sanitize_select',
	)
);
$wp_customize->add_control('pagination_type',
	array(
		'label'    => esc_html__('Pagination Type', 'photography-blog'),
		'section'  => 'pagination_section',
		'type'     => 'select',
		'choices'  => array(
			'default' => esc_html__('Numeric', 'photography-blog'),
			'Older / Newer Post' => esc_html__('Default (Older / Newer Post)', 'photography-blog'),
		),
		'priority' => 100,
	)
);

// Footer Section.
$wp_customize->add_section('footer_section',
	array(
		'title'      => esc_html__('Footer Options', 'photography-blog'),
		'priority'   => 130,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting copyright_text.
$wp_customize->add_setting('copyright_text',
	array(
		'default'           => $default['copyright_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control('copyright_text',
	array(
		'label'    => esc_html__('Footer Copyright Text', 'photography-blog'),
		'section'  => 'footer_section',
		'type'     => 'text',
		'priority' => 120,
	)
);