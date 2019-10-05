<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/******************** IDYLLIC CUSTOMIZE REGISTER *********************************************/
add_action( 'customize_register', 'idyllic_customize_register_wordpress_default' );
function idyllic_customize_register_wordpress_default( $wp_customize ) {
	$wp_customize->add_panel( 'idyllic_wordpress_default_panel', array(
		'priority' => 5,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'WordPress Settings', 'idyllic' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'idyllic_customize_register_options');
function idyllic_customize_register_options( $wp_customize ) {
	$wp_customize->add_panel( 'idyllic_options_panel', array(
		'priority' => 6,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Options', 'idyllic' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'idyllic_customize_register_frontpage_options');
function idyllic_customize_register_frontpage_options( $wp_customize ) {
	$wp_customize->add_panel( 'idyllic_frontpage_panel', array(
		'priority' => 7,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Frontpage Template', 'idyllic' ),
		'description' => '',
	) );
}

add_action( 'customize_register', 'idyllic_customize_register_featuredcontent' );
function idyllic_customize_register_featuredcontent( $wp_customize ) {
	$wp_customize->add_panel( 'idyllic_featuredcontent_panel', array(
		'priority' => 8,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Slider Options', 'idyllic' ),
		'description' => '',
	) );
}