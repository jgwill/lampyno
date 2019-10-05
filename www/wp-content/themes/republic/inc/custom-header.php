<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package republic
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses republic_header_style()
 * @uses republic_admin_header_style()
 * @uses republic_admin_header_image()
 */
function republic_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'republic_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1284,
		'height'                 => 250,            
		'flex-height'            => true,
		'flex-width'            => true,
		'wp-head-callback'       => 'republic_header_style',
		'admin-head-callback'    => 'republic_admin_header_style',
		'admin-preview-callback' => 'republic_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'republic_custom_header_setup' );

if ( ! function_exists( 'republic_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see republic_custom_header_setup().
 */
 
 function republic_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="republic-header-css">
	<?php
		// Has the text been hidden?
		if ( 'blank' === $text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php endif; ?>
	<?php
		if ( ! empty( $header_image ) ) :
	?>
		.header-area {
			background-image: url(<?php header_image(); ?>) ;
			background-size: cover;
		}
		@media (max-width: 767px) {
			.header-area {
				background-size: 768px auto;
			}
		}
		@media (max-width: 359px) {
			.header-area {
				background-size: 360px auto;
			}
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // republic_header_style

if ( ! function_exists( 'republic_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see republic_custom_header_setup().
 */
function republic_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // republic_admin_header_style

if ( ! function_exists( 'republic_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see republic_custom_header_setup().
 */
function republic_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // republic_admin_header_image