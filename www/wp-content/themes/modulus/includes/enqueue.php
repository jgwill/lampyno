<?php 

/**
 * Enqueue scripts and styles.  
 */
function modulus_scripts() {    
	wp_enqueue_style( 'modulus-roboto', modulus_theme_font_url('Roboto:400,700'), array(), 20141212 );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), 20150224 );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), 20150224 );
	wp_enqueue_style( 'rippler', get_template_directory_uri() . '/css/rippler.css', array(), 20150224 );
	wp_enqueue_style( 'modulus-style', get_stylesheet_uri() );

	wp_enqueue_script( 'modulus-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'modulus-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );   
	}
	wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '2.4.0', true );
	wp_enqueue_script( 'jquery-rippler', get_template_directory_uri() . '/js/jquery.rippler.min.js', array('jquery'), true );
	wp_enqueue_script( 'modulus-custom', get_template_directory_uri() . '/js/custom.js', array(), '1.0.0', true );
	
	if( get_theme_mod('sticky_header',false) ){
		wp_enqueue_script( 'modulus-custom-sticky', get_template_directory_uri() . '/js/custom-sticky.js', array('jquery'), '1.0.0', true );
	}
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '2.4.0', true );
	wp_enqueue_script('masonry');
	
	
}
add_action( 'wp_enqueue_scripts', 'modulus_scripts' );    
	
/**
 * Register Google fonts.
 *
 * @return string
 */
function modulus_theme_font_url($font) {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Font, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Font: on or off', 'modulus' ) ) {
		$font_url = esc_url( add_query_arg( 'family', urlencode($font), "//fonts.googleapis.com/css" ) );
	}

	return $font_url;
}

function modulus_admin_enqueue_scripts( $hook ) {
	//if( strpos($hook, 'modulus_upgrade') ) {
		wp_enqueue_style( 
			'font-awesome', 
			get_template_directory_uri() . '/css/font-awesome.min.css', 
			array(), 
			'4.3.0', 
			'all' 
		);
		wp_enqueue_style( 
			'modulus-admin', 
			get_template_directory_uri() . '/admin/css/admin.css', 
			array(), 
			'1.0.0', 
			'all' 
		);
	//}
}
add_action( 'admin_enqueue_scripts', 'modulus_admin_enqueue_scripts' );


function modulus_admin_customizer_enqueue_scripts(){
	   wp_enqueue_script( 
			'modulus-customizer-review-script', 
			get_template_directory_uri() . '/admin/js/script.js',
			array('jquery'),
			'1.0.0',
			true
		); 
	   wp_enqueue_style( 
			'modulus-customizer-css', 
			get_template_directory_uri() . '/admin/css/customizer.css', 
			array(), 
			'1.0.0', 
			'all' 
		);
}
add_action( 'admin_enqueue_scripts', 'modulus_admin_customizer_enqueue_scripts');