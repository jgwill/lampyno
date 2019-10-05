<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/*********** IDYLLIC ADD THEME SUPPORT FOR INFINITE SCROLL **************************/
function idyllic_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'idyllic_jetpack_setup' );