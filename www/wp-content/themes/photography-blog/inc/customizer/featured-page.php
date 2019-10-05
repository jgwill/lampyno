<?php
$default = photography_blog_get_default_theme_options();

// Slider Main Section.
$wp_customize->add_section('featured_page_settings',
    array(
        'title'      => esc_html__('Featured Page Options', 'photography-blog'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting -featured page.
$wp_customize->add_setting('enable_featured_page_section',
    array(
        'default'           => $default['enable_featured_page_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'photography_blog_sanitize_checkbox',
    )
);
$wp_customize->add_control('enable_featured_page_section',
    array(
        'label'    => esc_html__('Enable Featured Page', 'photography-blog'),
        'section'  => 'featured_page_settings',
        'type'     => 'checkbox',
        'priority' => 100,
    )
);

$wp_customize->add_setting('select_featured_page', array(
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'photography_blog_sanitize_dropdown_pages',
));

$wp_customize->add_control('select_featured_page', array(
        'input_attrs' => array(
            'style'      => 'width: 50px;',
        ),
        'label'           => esc_html__('Select Featured Page from', 'photography-blog'),
        'section'         => 'featured_page_settings',
        'type'            => 'dropdown-pages',
        'priority'        => 110,
    )
);
$wp_customize->add_setting('featured_page_button_text',
    array(
        'default'           => $default['featured_page_button_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('featured_page_button_text',
    array(
        'label'    => esc_html__('Section Button Text', 'photography-blog'),
        'section'  => 'featured_page_settings',
        'type'     => 'text',
        'priority' => 120,
    )
);

$wp_customize->add_setting('featured_page_additional_button_text',
    array(
        'default'           => $default['featured_page_additional_button_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('featured_page_additional_button_text',
    array(
        'label'    => esc_html__('Additional Button Text', 'photography-blog'),
        'section'  => 'featured_page_settings',
        'type'     => 'text',
        'priority' => 120,
    )
);

$wp_customize->add_setting('featured_page_additional_button_link',
    array(
        'default'           => $default['featured_page_additional_button_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('featured_page_additional_button_link',
    array(
        'label'    => esc_html__('Additional Button URL', 'photography-blog'),
        'section'  => 'featured_page_settings',
        'type'     => 'text',
        'priority' => 120,
    )
);