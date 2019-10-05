<?php

// Add CSS files.
function responsive_forum_enqueue_style() {
	// Load main css file of parent theme.
    wp_enqueue_style( 'di-business-style-default', get_template_directory_uri() . '/style.css' );

    // Load this child theme css after all parent css files.
    wp_enqueue_style( 'responsive-forum-style',  get_stylesheet_directory_uri() . '/style.css', array( 'bootstrap', 'font-awesome', 'di-business-style-default', 'di-business-style-core', 'di-business-style-woo' ), wp_get_theme()->get('Version'), 'all');
}
add_action( 'wp_enqueue_scripts', 'responsive_forum_enqueue_style' );

// Recommend bbPress plugin.
function responsive_forum_recomn_plugins() {

	$plugins = array(
		array(
			'name'      => __( 'bbPress', 'responsive-forum' ),
			'slug'      => 'bbpress',
			'required'  => false,
		),
	);

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'responsive_forum_recomn_plugins' );

// Register bbPress Sidebar.
function responsive_forum_sidebar_registration() {
	register_sidebar( array(
		'name'			=> __( 'bbPress Sidebar', 'responsive-forum' ),
		'id'			=> 'sidebar_bbpress',
		'description'	=> __( 'Widgets for bbPress Pages.', 'responsive-forum' ),
		'before_widget'	=> '<div id="%1$s" class="widget_sidebar_main clearfix %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3 class="right-widget-title">',
		'after_title'	=> '</h3>',
	) );
}
add_action( 'widgets_init', 'responsive_forum_sidebar_registration' );


// bbPress Options.
function responsive_forum_bbpress_cus_options() {

	Kirki::add_config( 'responsive_forum_config', array(
		'capability'    => 'edit_theme_options',
		'option_type'   => 'theme_mod',
	) );

	Kirki::add_section( 'bbpress_options', array(
	    'title'          => __( 'bbPress Options', 'responsive-forum' ),
	    'capability'     => 'edit_theme_options',
	    'priority'		=> 100,
	) );

	Kirki::add_field( 'responsive_forum_config', array(
		'type'        => 'radio-image',
		'settings'    => 'bbpress_layout',
		'label'       => __( 'bbPress Pages Layout', 'responsive-forum' ),
		'section'     => 'bbpress_options',
		'default'     => 'fullw',
		'choices'     => array(
			'fullw'	  => get_template_directory_uri() . '/assets/images/fullw.png',
			'rights'  => get_template_directory_uri() . '/assets/images/rights.png',
			'lefts'   => get_template_directory_uri() . '/assets/images/lefts.png',
		),
	) );
}
add_action( 'init', 'responsive_forum_bbpress_cus_options' );
