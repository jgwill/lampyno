<?php function busiprof_archive_page_customizer( $wp_customize ) {

	$wp_customize->add_section(
        'breadcrumbs_setting',
        array(
            'title' => __('Archive page title','busiprof'),
            'description' =>'',
			'priority' => 126,
			)
    );
	
		$wp_customize->add_setting(
		'busiprof_theme_options[archive_prefix]',
		array(
			'default' => __('Archive','busiprof'),
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'busiprof_template_page_sanitize_text',
			'type' => 'option',
		)	
		);
		$wp_customize->add_control(
		'busiprof_theme_options[archive_prefix]',
		array(
			'label' => __('Archive','busiprof'),
			'section' => 'breadcrumbs_setting',
			'type' => 'text',
		)
		);
		
	
	$wp_customize->add_setting(
    'busiprof_theme_options[category_prefix]',
    array(
        'default' => __('Category','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type' => 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[category_prefix]',array(
    'label'   => __('Category','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text'
	));

	$wp_customize->add_setting(
    'busiprof_theme_options[author_prefix]',
    array(
        'default' => __('All posts by','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type' => 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[author_prefix]',array(
    'label'   => __('Author','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text'
	));
	
	$wp_customize->add_setting(
    'busiprof_theme_options[tag_prefix]',
    array(
        'default' => __('Tag','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type' => 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[tag_prefix]',array(
    'label'   => __('Tag','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text'
	));
	
	
	$wp_customize->add_setting(
    'busiprof_theme_options[search_prefix]',
    array(
        'default' => __('Search results for','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type'	=> 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[search_prefix]',array(
    'label'   => __('Search','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text',
	));
	
	$wp_customize->add_setting(
    'busiprof_theme_options[404_prefix]',
    array(
        'default' => __('404','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type'	=> 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[404_prefix]',array(
    'label'   => __('404','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text'
	));
	
	
	$wp_customize->add_setting(
    'busiprof_theme_options[shop_prefix]',
    array(
        'default' => __('Shop','busiprof'),
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'busiprof_template_page_sanitize_text',
		'type'	=> 'option',
		)
	);	
	$wp_customize->add_control( 'busiprof_theme_options[shop_prefix]',array(
    'label'   => __('Shop','busiprof'),
    'section' => 'breadcrumbs_setting',
	 'type' => 'text'
	));
}
add_action( 'customize_register', 'busiprof_archive_page_customizer' );

	function busiprof_template_page_sanitize_text( $input ) {

			return wp_kses_post( force_balance_tags( $input ) );

	}

?>