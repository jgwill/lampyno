<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package republic
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function republic_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'type' => 'scroll',	  //Accepts two different values: scroll or click.
		'footer_widgets' => false, //If footer widgets are present, the scroll type will be set to click so the widgets are accessible.
		'posts_per_page' => false, //How many posts are loaded each time Infinite Scroll acts
		'wrapper'        => true,
		'render'    => 'republic_infinite_scroll_render', //it appends, and utilizes template parts in the content-{post format}.php
		'footer'    => 'page',
	) );
} // end function republic_jetpack_setup
add_action( 'after_setup_theme', 'republic_jetpack_setup' );

function republic_infinite_scroll_render() {
	echo '<ul class="large-block-grid-3">';
	while ( have_posts() ) {
		the_post();
		echo '<li>';
		get_template_part( 'template-parts/content', get_post_format() );
		echo '</li>';
	}
	
	echo '</ul>';
} // end function republic_infinite_scroll_render