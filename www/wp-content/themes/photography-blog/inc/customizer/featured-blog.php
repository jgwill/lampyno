<?php
/**
 * Featured Blog section
 *
 * @package Photography_Blog
 */

$default = photography_blog_get_default_theme_options();

// Fearured Blog Section.
$wp_customize->add_section('featured_blog_settings',
    array(
        'title'      => esc_html__('Featured Image Gallery', 'photography-blog'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - show_slider_section.
$wp_customize->add_setting('enable_featured_blog',
    array(
        'default'           => $default['enable_featured_blog'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'photography_blog_sanitize_checkbox',
    )
);
$wp_customize->add_control('enable_featured_blog',
    array(
        'label'    => esc_html__('Enable Featured Blog', 'photography-blog'),
        'section'  => 'featured_blog_settings',
        'type'     => 'checkbox',
        'priority' => 100,
    )
);


// Setting - drop down category for slider.
$wp_customize->add_setting('select_category_for_featured_blog',
    array(
        'default'           => $default['select_category_for_featured_blog'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(new Photography_Blog_Dropdown_Taxonomies_Control($wp_customize, 'select_category_for_featured_blog',
    array(
        'label'           => esc_html__('Select Category for Featured Blog', 'photography-blog'),
        'section'         => 'featured_blog_settings',
        'type'            => 'dropdown-taxonomies',
        'taxonomy'        => 'category',
        'priority'        => 130,
        'active_callback' => 'photography_blog_is_select_cat_slider',

    )));
