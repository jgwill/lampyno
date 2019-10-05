<?php
/**
 * Display all idyllic functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */

/************************************************************************************************/
if ( ! function_exists( 'idyllic_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function idyllic_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width=790;
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('post-thumbnails');

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'Main Menu', 'idyllic' ),
		'side-nav-menu' => __( 'Side Menu', 'idyllic' ),
		'footermenu' => __( 'Footer Menu', 'idyllic' ),
		'social-link'  => __( 'Add Social Icons Only', 'idyllic' ),
	) );

	/* 
	* Enable support for custom logo. 
	*
	*/ 
	add_theme_support( 'custom-logo', array(
		'flex-width' => true, 
		'flex-height' => true,
	) );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'gutenberg', array(
			'colors' => array(
				'#ff4530',
			),
		) );
	add_theme_support( 'align-wide' );

	//Indicate widget sidebars can use selective refresh in the Customizer. 
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'idyllic_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( array( 'css/editor-style.css') );

	/**
	* Making the theme Woocommrece compatible
	*/

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
endif; // idyllic_setup
add_action( 'after_setup_theme', 'idyllic_setup' );

/***************************************************************************************/
function idyllic_content_width() {
	if ( is_page_template( 'page-templates/gallery-template.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1170;
	}
}
add_action( 'template_redirect', 'idyllic_content_width' );

/***************************************************************************************/
if(!function_exists('idyllic_get_theme_options')):
	function idyllic_get_theme_options() {
	    return wp_parse_args(  get_option( 'idyllic_theme_options', array() ), idyllic_get_option_defaults_values() );
	}
endif;

/***************************************************************************************/
require get_template_directory() . '/inc/customizer/idyllic-default-values.php';
require get_template_directory() . '/inc/settings/idyllic-functions.php';
require get_template_directory() . '/inc/settings/idyllic-common-functions.php';
require get_template_directory() . '/inc/jetpack.php';

if (!is_child_theme()){
	require get_template_directory() . '/inc/welcome-notice.php';
}

/************************ Idyllic Sidebar  *****************************/
require get_template_directory() . '/inc/widgets/widgets-functions/register-widgets.php';

/************************ Idyllic Customizer  *****************************/
require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/functions/register-panel.php';
function idyllic_customize_register( $wp_customize ) {
if(!class_exists('Idyllic_Plus_Features')){
	class Idyllic_Customize_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
			<a title="<?php esc_html_e( 'Review Us', 'idyllic' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/idyllic/' ); ?>" target="_blank" id="about_idyllic">
			<?php esc_html_e( 'Review Us', 'idyllic' ); ?>
			</a><br/>
			<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/idyllic/' ); ?>" title="<?php esc_html_e( 'Theme Instructions', 'idyllic' ); ?>" target="_blank" id="about_idyllic">
			<?php esc_html_e( 'Theme Instructions', 'idyllic' ); ?>
			</a><br/>
			<a href="<?php echo esc_url( 'https://tickets.themefreesia.com/' ); ?>" title="<?php esc_html_e( 'Support Tickets', 'idyllic' ); ?>" target="_blank" id="about_idyllic">
			<?php esc_html_e( 'Forum', 'idyllic' ); ?>
			</a><br/>
			<a href="<?php echo esc_url( 'https://www.facebook.com/themefreesia/' ); ?>" title="<?php esc_html_e( 'Facebook', 'idyllic' ); ?>" target="_blank" id="about_idyllic">
			<?php esc_html_e( 'Facebook', 'idyllic' ); ?>
			</a><br/>
			<a href="<?php echo esc_url( 'https://twitter.com/themefreesia' ); ?>" title="<?php esc_html_e( 'Twitter', 'idyllic' ); ?>" target="_blank" id="about_idyllic">
			<?php esc_html_e( 'Twitter', 'idyllic' ); ?>
			</a><br/>
		<?php
		}
	}
	$wp_customize->add_section('idyllic_upgrade_links', array(
		'title'					=> __('Important Links', 'idyllic'),
		'priority'				=> 1000,
	));
	$wp_customize->add_setting( 'idyllic_upgrade_links', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Idyllic_Customize_upgrade(
		$wp_customize,
		'idyllic_upgrade_links',
			array(
				'section'				=> 'idyllic_upgrade_links',
				'settings'				=> 'idyllic_upgrade_links',
			)
		)
	);
}	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'idyllic_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'idyllic_customize_partial_blogdescription',
		) );
	}
	require get_template_directory() . '/inc/customizer/functions/frontpage-features.php' ;
	require get_template_directory() . '/inc/customizer/functions/design-options.php';
	require get_template_directory() . '/inc/customizer/functions/theme-options.php';
	require get_template_directory() . '/inc/customizer/functions/featured-content-customizer.php' ;
}
if(!class_exists('Idyllic_Plus_Features')){
	// Add Upgrade to Plus Button.
	require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade-plus/class-customize.php' );
}
/** 
* Render the site title for the selective refresh partial. 
* @see idyllic_customize_register() 
* @return void 
*/ 
function idyllic_customize_partial_blogname() { 
bloginfo( 'name' ); 
} 

/** 
* Render the site tagline for the selective refresh partial. 
* @see idyllic_customize_register() 
* @return void 
*/ 
function idyllic_customize_partial_blogdescription() { 
bloginfo( 'description' ); 
}
add_action( 'customize_register', 'idyllic_customize_register' );
/******************* Idyllic Header Display *************************/
function idyllic_header_display(){
	$idyllic_settings = idyllic_get_theme_options();

$header_display = $idyllic_settings['idyllic_header_display'];

	if ($header_display == 'header_logo' || $header_display == 'header_text' || $header_display == 'show_both')	{
		echo '<div id="site-branding">';
			if($header_display != 'header_text'){
				idyllic_the_custom_logo();
			}
			echo '<div id="site-detail">';
				if (is_home() || is_front_page()){ ?>
				<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
				<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_html(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				<?php if(is_home() || is_front_page()){ ?>
				</h1>  <!-- end .site-title -->
				<?php } else { ?> </h2> <!-- end .site-title --> <?php }

				$site_description = get_bloginfo( 'description', 'display' );
				if ($site_description){?>
					<div id="site-description"> <?php bloginfo('description');?> </div> <!-- end #site-description -->
		<?php }
		echo '</div></div>'; // end #site-branding
	}

}
add_action('idyllic_site_branding','idyllic_header_display');

if ( ! function_exists( 'idyllic_the_custom_logo' ) ) : 
 	/** 
 	 * Displays the optional custom logo. 
 	 * Does nothing if the custom logo is not available. 
 	 */ 
 	function idyllic_the_custom_logo() { 
		if ( function_exists( 'the_custom_logo' ) ) { 
			the_custom_logo(); 
		}
 	} 
endif;

/* Idyllic Template */
require get_template_directory() . '/inc/front-page/about-us.php';
require get_template_directory() . '/inc/front-page/fact-figure-box.php';
require get_template_directory() . '/inc/front-page/front-page-features.php';
require get_template_directory() . '/inc/front-page/latest-from-blog.php';
require get_template_directory() . '/inc/front-page/portfolio-box.php';
require get_template_directory() . '/inc/front-page/our-testimonial.php';
require get_template_directory() . '/inc/front-page/team-member.php';
/************** Footer Menu *************************************/
function idyllic_footer_menu_section(){
	if(has_nav_menu('footermenu')):
		$args = array(
			'theme_location' => 'footermenu',
			'container'      => '',
			'items_wrap'     => '<ul>%3$s</ul>',
		);
		echo '<nav id="footer-navigation" role="navigation" aria-label="'. esc_attr__('Footer Menu','idyllic').'">';
		wp_nav_menu($args);
		echo '</nav><!-- end #footer-navigation -->';
	endif;
}
add_action( 'idyllic_footer_menu', 'idyllic_footer_menu_section' );