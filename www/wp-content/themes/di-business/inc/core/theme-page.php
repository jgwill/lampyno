<?php

add_action( 'admin_menu', 'di_business_theme_page' );
function di_business_theme_page() {
	add_theme_page(
		__( 'Di Business Theme', 'di-business' ),
		__( 'Di Business Theme', 'di-business' ),
		'manage_options',
		'di-business-theme',
		'di_business_theme_page_callback'
	);
}

function di_business_theme_page_callback() {
?>
	<div class="wrap">
		<h1><?php _e( 'Di Business Theme Info', 'di-business' ); ?></h1>
		<br />
		<div class="container-fluid" style="border: 2px dashed #C3C3C3;">
			<div class="row">

				<div class="col-md-6" style="padding:0px;">
					<img class="img-fluid" src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>" />
				</div>

				<div class="col-md-6">

					<h2><?php _e( 'Di Business WordPress Theme', 'di-business' ); ?></h2>

					<p style="font-size:16px;"><?php _e( 'Di Business is a Responsive, SEO Friendly, Multi Purpose, Customizable and Powerful WordPress Theme for professionals. it is fully compatible with WooCommerce plugin so it can be also use for ecommerce websites.', 'di-business' ); ?></p>

					<p style="font-size:16px;"><?php _e( 'Theme Features: One Click Demo Import, Typography Options, Header Layouts, Footer Widgets with Layouts, Blog Options, Sidebar Menu, Sticky Main Menu Options, Back To Top Icons with Option, Page Preloader icon with Option, Logo Option, Header Image Option, Header Widgets, Page and Post Widgets, Social Profile Widget, Recent Posts with Thumbnail Widget, Translation Ready, SEO Friendly, Page Builder Templates, Landing Page Template, WooCommerce Ready, Contact Form 7 Ready.', 'di-business' ); ?></p>

					<?php
					if( ! function_exists( 'di_business_pro' ) ) {
					?>
					<p style="font-size:16px;"><b><?php _e( 'Di Business Pro Features: ', 'di-business' ); ?></b><?php _e( 'Widget Area Creation and Selection, Advance Header Image Options, Slider in Header, All Color Options, Options to Update Footer Front Credit Link, Premium Support.', 'di-business' ); ?><p>
					<?php
					}
					?>

					<div style="text-align: center;" >

						<a target="_blank" class="btn btn-outline-success btn-sm" href="http://demo.dithemes.com/di-business/" role="button"><?php _e( 'Theme Demo', 'di-business' ); ?></a>

						<a target="_blank" class="btn btn-outline-success btn-sm" href="https://dithemes.com/di-business-free-wordpress-theme-documentation/" role="button"><?php _e( 'Theme Docs', 'di-business' ); ?></a>

						<a target="_blank" class="btn btn-outline-success btn-sm" href="<?php echo get_dashboard_url().'customize.php'; ?>" role="button"><?php _e( 'Theme Options', 'di-business' ); ?></a>

						<?php
						if( function_exists( 'di_business_pro' ) ) {
						?>
						<a target="_blank" class="btn btn-outline-success btn-sm" href="https://dithemes.com/my-tickets/" role="button"><?php _e( 'Get Premium Support', 'di-business' ); ?></a>
						<?php
						} else {
						?>
						<a target="_blank" class="btn btn-outline-success btn-sm" href="https://dithemes.com/product/di-business-pro-wordpress-theme/" role="button"><?php _e( 'Get Di Business Pro', 'di-business' ); ?></a>
						<?php
						}
						?>

					</div>
					<br />

				</div>
			</div>
		</div>
	</div>
<?php
}


// Enqueue js css files only if pagenow is themes.php and query string is page=di-business-them.
global $pagenow;
if ( 'themes.php' === $pagenow  && 'page=di-business-theme' === $_SERVER['QUERY_STRING'] ) {
	add_action( 'admin_enqueue_scripts', 'di_business_admin_js_css' );
}

function di_business_admin_js_css() {
	// Load bootstrap css.
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '4.0.0', 'all' );
	// Load bootstrap js.
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery' ), '4.0.0', true );
}
