<?php 

/**
 * Enqueue scripts and styles.
 */
function republic_scripts(){
/* Add Foundation CSS */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'foundation-min', get_template_directory_uri() . '/foundation/css/foundation.min.css' );
    wp_enqueue_style('normalize', get_template_directory_uri()."/foundation/css/normalize.css",array(),'5.1.1','screen');
	wp_enqueue_style( 'republic-customcss', get_template_directory_uri() . '/css/custom.css' );
	
	wp_enqueue_style( 'republic-style', get_stylesheet_uri() );	
	
	/* Add Foundation JS */
    wp_enqueue_script( 'republic-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script('republic-backscript', get_template_directory_uri().'/js/scroll.js', array('jquery'), '1.0', false );
	
	wp_enqueue_script('republic-smoothscroll', get_template_directory_uri().'/foundation/js/foundation/foundation.orbit.js', array(), '1.0', false );
if( get_theme_mod('hide_slider')==true){	
	wp_enqueue_script('republic-orbit', get_template_directory_uri().'/js/smoothscroll.js', array(), '1.0', false );
}
if ( is_rtl() ) {
	wp_enqueue_style( 'republic-rtl-css', get_template_directory_uri() . '/css/rtl.css' );
}
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'republic_scripts' );
function republic_register_scripts() {
    wp_register_script('foundation-js', get_template_directory_uri()."/foundation/js/foundation.min.js", array('jquery'),'5.1.1',true); 
   

  wp_enqueue_script(array('foundation-js'));
}
add_action('wp_enqueue_scripts','republic_register_scripts');

function republic_footerscript() {
    wp_enqueue_script(
        'level_footersc',
        get_template_directory_uri() . '/js/footersc.js',
        array('jquery'),
        '1.0',
        true
    );

}

add_action('wp_enqueue_scripts', 'republic_footerscript',10);
/**
 * Enqueue script for custom customize control.
 */
function republic_custom_customize_enqueue() {
	wp_enqueue_style( 'republic_customizer-css', get_stylesheet_directory_uri() . '/css/customizer-css.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'republic_custom_customize_enqueue' );
