<?php
// Refresh and postMeaage / partial refresh handle.
function di_business_pr_handle( $wp_customize ) {
	// Full refresh on logo select or switch.
	$wp_customize->get_setting( 'custom_logo' )->transport 	= 'refresh';

	// Blog name partial refresh handle.
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-name-pr',
		'render_callback' => function() {
			return esc_attr( get_bloginfo( 'name' ) );
		},
	) );

	// Blog tagline / description partial refresh handle.
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description-pr',
		'render_callback' => function() {
			return esc_attr( get_bloginfo( 'description' ) );
		},
	) );

	// Blog header_image partial refresh handle.
	$wp_customize->get_setting( 'header_image' )->transport   = 'refresh';
	$wp_customize->selective_refresh->add_partial( 'header_image', array(
		'selector' => '.wp-custom-header',
	) );

	// Top Main menu partial refresh handle.
	$wp_customize->add_setting(
		'top_main_menu_hidden_field', array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'top_main_menu_hidden_field', array(
			'priority' => 25,
			'type'     => 'hidden',
			'section'  => 'menu_locations',
		)
	);

	$wp_customize->get_setting( 'top_main_menu_hidden_field' )->transport   = 'refresh';
	$wp_customize->selective_refresh->add_partial( 'top_main_menu_hidden_field', array(
			'selector'	=> '.nav.navbar-nav.primary-menu',
		)
	);

	// For back to top icon.
	$wp_customize->get_setting( 'back_to_top' )->transport   = 'refresh';
	$wp_customize->selective_refresh->add_partial( 'back_to_top', array(
			'selector'	=> '#back-to-top',
		)
	);

	// For sidebar menu.
	$wp_customize->get_setting( 'sb_menu_onoff' )->transport   = 'refresh';
	$wp_customize->selective_refresh->add_partial( 'sb_menu_onoff', array(
			'selector'	=> '.side-menu-menu-button',
		)
	);

	// For social profile.
	$wp_customize->get_setting( 'sprofile_link_facebook' )->transport   = 'refresh';
	$wp_customize->selective_refresh->add_partial( 'sprofile_link_facebook', array(
			'selector'	=> '.sicons_ctmzr',
		)
	);

}
add_action( 'customize_register', 'di_business_pr_handle', 9999999 );

