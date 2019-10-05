<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( is_product() ) {

	// It is a single product page.
	$woo_layout = esc_attr( get_theme_mod( 'woo_singleprod_layout', 'fullw' ) );
	if( $woo_layout == 'rights' || $woo_layout == 'lefts' ) {
		get_sidebar( 'shop' );
	}

} else {

	$woo_layout = esc_attr( get_theme_mod( 'woo_layout', 'fullw' ) );
	if( $woo_layout == 'rights' || $woo_layout == 'lefts' ) {
		get_sidebar( 'shop' );
	}

}
