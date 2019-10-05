<?php 
/**
 * IT Solutions functions and definitions
 *
 * @package IT Solutions
 */
 global $content_width;
 if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */ 
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! function_exists( 'it_solutions_setup' ) ) : 
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function it_solutions_setup() {
	load_theme_textdomain( 'it-solutions', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('woocommerce');
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_post_type_support( 'page', 'excerpt' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 125,
		'flex-height' => true,
	) );	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'it-solutions' ),		
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_editor_style( 'editor-style.css' );
} 
endif; // it_solutions_setup
add_action( 'after_setup_theme', 'it_solutions_setup' );
function it_solutions_widgets_init() { 	
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'it-solutions' ),
		'description'   => esc_html__( 'Appears on blog page sidebar', 'it-solutions' ),
		'id'            => 'sidebar-1',
		'before_widget' => '',		
		'before_title'  => '<h3 class="widget-title titleborder"><span>',
		'after_title'   => '</span></h3><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'it-solutions' ),
		'description'   => esc_html__( 'Appears on page footer', 'it-solutions' ),
		'id'            => 'fc-1',
		'before_widget' => '',		
		'before_title'  => '<h5>',
		'after_title'   => '</h5><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'it-solutions' ),
		'description'   => esc_html__( 'Appears on page footer', 'it-solutions' ),
		'id'            => 'fc-2',
		'before_widget' => '',		
		'before_title'  => '<h5>',
		'after_title'   => '</h5><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'it-solutions' ),
		'description'   => esc_html__( 'Appears on page footer', 'it-solutions' ),
		'id'            => 'fc-3',
		'before_widget' => '',		
		'before_title'  => '<h5>',
		'after_title'   => '</h5><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );	
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'it-solutions' ),
		'description'   => esc_html__( 'Appears on page footer', 'it-solutions' ),
		'id'            => 'fc-4',
		'before_widget' => '',		
		'before_title'  => '<h5>',
		'after_title'   => '</h5><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
	) );		
	
}
add_action( 'widgets_init', 'it_solutions_widgets_init' );
function it_solutions_font_url(){
		$font_url = '';		
		/* Translators: If there are any character that are not
		* supported by Roboto Condensed, trsnalate this to off, do not
		* translate into your own language.
		*/
		$robotocondensed = _x('on','Roboto Condensed:on or off','it-solutions');		
		/* Translators: If there has any character that are not supported 
		*  by Scada, translate this to off, do not translate
		*  into your own language.
		*/
		$scada = _x('on','Scada:on or off','it-solutions');	
		$lato = _x('on','Lato:on or off','it-solutions');	
		$roboto = _x('on','Roboto:on or off','it-solutions');
		$opensans = _x('on','Open Sans:on or off','it-solutions');
		$assistant = _x('on','Assistant:on or off','it-solutions');
		$lora = _x('on','Lora:on or off','it-solutions');
		$kaushanscript = _x('on','Kaushan Script:on or off','it-solutions');
		
		if('off' !== $robotocondensed ){
			$font_family = array();
			if('off' !== $robotocondensed){
				$font_family[] = 'Roboto Condensed:300,400,600,700,800,900';
			}
			if('off' !== $lato){
				$font_family[] = 'Lato:100,100i,300,300i,400,400i,700,700i,900,900i';
			}
			if('off' !== $roboto){
				$font_family[] = 'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i';
			}
			if('off' !== $opensans){
				$font_family[] = 'Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
			}	
			if('off' !== $assistant){
				$font_family[] = 'Assistant:200,300,400,600,700,800';
			}	
			if('off' !== $lora){
				$font_family[] = 'Lora:400,400i,700,700i';
			}			
			if('off' !== $kaushanscript){
				$font_family[] = 'Kaushan Script:400';
			}					
			$query_args = array(
				'family'	=> urlencode(implode('|',$font_family)),
			);
			$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
		}
	return $font_url;
	}
function it_solutions_scripts() {
	wp_enqueue_style('it-solutions-font', it_solutions_font_url(), array());
	wp_enqueue_style( 'it-solutions-basic-style', get_stylesheet_uri() );
	wp_enqueue_style( 'it-solutions-editor-style', get_template_directory_uri()."/editor-style.css" );
	wp_enqueue_style( 'it-solutions-animation-style', get_template_directory_uri()."/css/animation.css" );
	wp_enqueue_style( 'nivo-slider', get_template_directory_uri()."/css/nivo-slider.css" );
	wp_enqueue_style( 'it-solutions-main-style', get_template_directory_uri()."/css/responsive.css" );		
	wp_enqueue_style( 'it-solutions-base-style', get_template_directory_uri()."/css/style_base.css" );
	wp_enqueue_script( 'jquery-nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery') );
	wp_enqueue_script( 'it-solutions-custom-js', get_template_directory_uri() . '/js/custom.js' );	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'it_solutions_scripts' );


define('IT_SOLUTIONS_SKTTHEMES_URL','https://www.sktthemes.org/','it-solutions');
define('IT_SOLUTIONS_SKTTHEMES_PRO_THEME_URL','https://www.sktthemes.org/shop/it-solution-wordpress-theme/','it-solutions');
define('IT_SOLUTIONS_SKTTHEMES_FREE_THEME_URL','https://www.sktthemes.org/shop/free-software-company-wordpress-theme/','it-solutions');
define('IT_SOLUTIONS_SKTTHEMES_THEME_DOC','http://sktthemesdemo.net/documentation/itsolution-documentation/','it-solutions');
define('IT_SOLUTIONS_SKTTHEMES_LIVE_DEMO','https://sktperfectdemo.com/demos/it-solutions/','it-solutions');
define('IT_SOLUTIONS_SKTTHEMES_THEMES','https://www.sktthemes.org/themes/','it-solutions');
/**
 * Custom template for about theme.
 */
require get_template_directory() . '/inc/about-themes.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
// get slug by id
function it_solutions_get_slug_by_id($id) {
	$post_data = get_post($id, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug; 
}
if ( ! function_exists( 'it_solutions_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function it_solutions_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;
require_once get_template_directory() . '/customize-pro/example-1/class-customize.php';
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function it_solutions_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_html(get_bloginfo( 'pingback_url' ) ));
	}
}
add_action( 'wp_head', 'it_solutions_pingback_header' );
add_filter( 'body_class','it_solutions_body_class' );
function it_solutions_body_class( $classes ) {
 	$hideslide = get_theme_mod('hide_slides', 1);
	if (!is_home() && is_front_page()) {
		if( $hideslide == '') {
			$classes[] = 'enableslide';
		}
	}
    return $classes;
}
/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function it_solutions_custom_excerpt_length( $excerpt_length ) {
    return 19;
}
add_filter( 'excerpt_length', 'it_solutions_custom_excerpt_length', 999 );
/**
 *
 * Style For About Theme Page
 *
 */
function it_solutions_admin_about_page_css_enqueue($hook) {
   if ( 'appearance_page_it_solutions_guide' != $hook ) {
        return;
    }
    wp_enqueue_style( 'it-solutions-about-page-style', get_template_directory_uri() . '/css/it-solutions-about-page-style.css' );
}
add_action( 'admin_enqueue_scripts', 'it_solutions_admin_about_page_css_enqueue' );