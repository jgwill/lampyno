<?php 
function busiprof_general_settings( $wp_customize ){

/* Home Page Panel */
	$wp_customize->add_panel( 'general_settings', array(
		'priority'       => 125,
		'capability'     => 'edit_theme_options',
		'title'      => __('General settings', 'busiprof'),
	) );
	
	/* Front Page section */
	$wp_customize->add_section( 'front_page_section' , array(
		'title'      => __('Front page', 'busiprof'),
		'panel'  => 'general_settings',
		'priority'   => 0,
   	) );
	
		// Enable Front Page
		$wp_customize->add_setting(
			'busiprof_theme_options[front_page]', 
			array(
			'default' => 'yes',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'type'=>'option'
		));
		
		$wp_customize->add_control(
			'busiprof_theme_options[front_page]', 
			array(
				'label'    => __('Enable front page','busiprof' ),
				'section'  => 'front_page_section',
				'type'     => 'radio',
				'choices' => array(
					'yes'=>'ON',
					'no'=>'OFF'
				)
		));
		
	/* custom logo section */
	$wp_customize->add_section( 'logo_section' , array(
		'title'      => __('Custom logo', 'busiprof'),
		'panel'  => 'general_settings',
		'priority'   => 1,
   	) );
	
		// Logo
		$wp_customize->add_setting( 'busiprof_theme_options[upload_image]',array('type' => 'option', 'sanitize_callback' => 'sanitize_text_field') );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'busiprof_theme_options[upload_image]', array(
			'label'    => __( 'Upload logo', 'busiprof' ),
			'section'  => 'logo_section',
			'settings' => 'busiprof_theme_options[upload_image]',
		) ) );
		
		// width
		$wp_customize->add_setting( 'busiprof_theme_options[width]', array( 'default' => 138 , 'type' => 'option','sanitize_callback' => 'sanitize_text_field'	) );
		$wp_customize->add_control(	'busiprof_theme_options[width]', 
			array(
				'label'    => __('Enter Logo Width', 'busiprof' ),
				'section'  => 'logo_section',
				'type'     => 'text',
		));
		
		// height
		$wp_customize->add_setting( 'busiprof_theme_options[height]', array( 'default' => 49 , 'type' => 'option','sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(	'busiprof_theme_options[height]', 
			array(
				'label'    => __('Enter Logo Height', 'busiprof' ),
				'section'  => 'logo_section',
				'type'     => 'text',
		));
		
		// enable logo text
		$wp_customize->add_setting( 'busiprof_theme_options[enable_logo_text]' , array(
		'default' => false,
		'sanitize_callback' => 'sanitize_text_field',
		'type'=>'option'
		) );
		$wp_customize->add_control('busiprof_theme_options[enable_logo_text]' , array(
		'label'          => __( 'Enable logo text', 'busiprof' ),
		'section'        => 'logo_section',
		'type'           => 'checkbox'
		) );
		
	/* custom css section */
	$wp_customize->add_section( 'custom_css_section' , array(
		'title'      => __('Custom CSS', 'busiprof'),
		'panel'  => 'general_settings',
		'priority'   => 2,
   	) );
	
		// custom css
		$wp_customize->add_setting( 'busiprof_theme_options[busiprof_custom_css]', array( 'default' => '' , 'type' => 'option', 'sanitize_callback'    => 'wp_filter_nohtml_kses',
		'sanitize_js_callback' => 'wp_filter_nohtml_kses', ) );
		$wp_customize->add_control(	'busiprof_theme_options[busiprof_custom_css]', 
			array(
				'label'    => __('Custom CSS', 'busiprof' ),
				'section'  => 'custom_css_section',
				'type'     => 'textarea',
		));
	

	/* footer section */
	$wp_customize->add_section( 'footer_copy_section' , array(
		'title'      => __('Footer copyright settings', 'busiprof'),
		'panel'  => 'general_settings',
		'priority'   => 3,
   	) );
	
		// copyright text
		$wp_customize->add_setting( 'busiprof_theme_options[footer_copyright_text]', array( 'default' => '<p>All Rights Reserved by BusiProf. Designed and Developed by <a href="'.esc_url('http://www.webriti.com').'" target="_blank">WordPress Theme</a>.</p> ' , 'type' => 'option', 'sanitize_callback' => 'busiprof_copyright_sanitize_text' ) );
		$wp_customize->add_control(	'busiprof_theme_options[footer_copyright_text]', 
			array(
				'label'    => __( 'Copyright text','busiprof' ),
				'section'  => 'footer_copy_section',
				'type'     => 'textarea',
		));
		
		function busiprof_copyright_sanitize_text( $input ) {

		return wp_kses_post( force_balance_tags( $input ) );

		}
	
		function busiprof_copyright_sanitize_html( $input ) {

		return force_balance_tags( $input );

		}
		
}
add_action( 'customize_register', 'busiprof_general_settings' );

/**
 * Add selective refresh for Front page section section controls.
 */
function busiprof_register_copyright_section_partials( $wp_customize ){

$wp_customize->selective_refresh->add_partial( 'busiprof_theme_options[footer_copyright_text]', array(
		'selector'            => '.site-info .col-md-7 p',
		'settings'            => 'busiprof_theme_options[footer_copyright_text]',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'busiprof_theme_options[upload_image]', array(
		'selector'            => '.navbar-header a',
		'settings'            => 'busiprof_theme_options[upload_image]',
	
	) );
}

add_action( 'customize_register', 'busiprof_register_copyright_section_partials' );