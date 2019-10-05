<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @package Advance_Blog
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses advance_blog_header_style()
 */
function advance_blog_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'advance_blog_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 2000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'advance_blog_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'advance_blog_custom_header_setup' );

if ( ! function_exists( 'advance_blog_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see advance_blog_custom_header_setup().
 */
function advance_blog_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // advance_blog_header_style