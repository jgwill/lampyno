<?php
include_once('includes/core/core.php');
	include_once 'inc/installs.php';
	include_once 'template-parts/slider.php';	
	include_once 'inc/metabox.php';
	include_once 'inc/pagemetabox.php';
/**
 * republic functions and definitions
 *
 * @package republic
 */

if ( ! function_exists( 'republic_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function republic_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on republic, use a find and replace
	 * to change 'republic' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'republic', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('bbpress');
// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
	//Woocommerce theme support 
	add_theme_support( 'woocommerce' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
        set_post_thumbnail_size( 300, 300 );
        add_image_size( 'republic_themewidget', 65, 65 );
        add_image_size( 'republic_indeximagebig', 320, 200 );
        add_image_size( 'republic_indeximage', 85, 85 );
        add_image_size( 'republic_latestthumbimg', 220, 125 );
        add_image_size( 'republic_republicrandom', 90, 90 );
		
	add_theme_support( 'custom-logo', array(
	'height'      => 120,
	'width'       => 320,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'topmenu' => esc_html__( 'Top Menu', 'republic' ),
		'primary' => esc_html__( 'Primary Menu', 'republic' ),
 		'footer-menu' => esc_html__('Footer Menu', 'republic'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
        /*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css') );

	// Set up the WordPress core custom background feature.
	
add_theme_support( 'custom-background', apply_filters( 'republic_custom_background_args', array( 
 	        'default-color' => 'f3f3f3', 
 	        'default-image' => '', 
 	    ) ) ); 

}
endif; // republic_setup
add_action( 'after_setup_theme', 'republic_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function republic_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'republic_content_width', 700 );
        if ( ! isset( $content_width ) ) $content_width = 700;
}
add_action( 'after_setup_theme', 'republic_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function republic_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'republic' ),
		'id'            => 'sidebar-1',
		'description'   => __('Sidebar widget for all pages included Post, Pages, Index and archives', 'republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Top Header Area', 'republic' ),
		'id'            => 'topareawid',
		'description'   => __('Top Header widget are show on right side of logo between two menus','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Below Navigation', 'republic' ),
		'id'            => 'belownavi-1',
		'description'   => __('This widget show just above content and below main navigation','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Single Post Widget', 'republic' ),
		'id'            => 'singlepostwid',
		'description'   => __('It shows in single posts after title and before content','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 1', 'republic' ),
		'id'            => 'footer-1',
		'description'   => __('Footer widget area first from left','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 2', 'republic' ),
		'id'            => 'footer-2',
		'description'   => __('Footer widget area second from left','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 3', 'republic' ),
		'id'            => 'footer-3',
		'description'   => __('Footer widget area Third from left','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget 4', 'republic' ),
		'id'            => 'footer-4',
		'description'   => __('Footer widget area fourth from left','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Blog Post [Pro Only]', 'republic' ),
		'id'            => 'fp-blogpost',
		'description'   => __('Widget After blog post in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 1 [Pro Only]', 'republic' ),
		'id'            => 'fp-catea',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 2 [Pro Only]', 'republic' ),
		'id'            => 'fp-cateb',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 3 [Pro Only]', 'republic' ),
		'id'            => 'fp-catec',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 4 [Pro Only]', 'republic' ),
		'id'            => 'fp-cated',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 5 [Pro Only]', 'republic' ),
		'id'            => 'fp-catee',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 6 [Pro Only]', 'republic' ),
		'id'            => 'fp-catef',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 7 [Pro Only]', 'republic' ),
		'id'            => 'fp-categ',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page - After Category 8 [Pro Only]', 'republic' ),
		'id'            => 'fp-cateh',
		'description'   => __('Widget After category block in front page','republic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'republic_widgets_init' );


/**
 * Enqueue scripts into theme
 */
require get_template_directory() . '/inc/enqueue-scripts.php';
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
//require get_template_directory() . '/inc/customizer-section.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * custom-function file.
 */
require get_template_directory() . '/inc/custom-function.php';


function republic_contactmethods( $contactmethods ) {
    // Add Youtube
    $contactmethods['youtube'] = __('Youtube','republic');
    // Add Google Plus
    $contactmethods['googleplus'] = __('Google+','republic');
    // Add Twitter
    $contactmethods['twitter'] = __('Twitter','republic');
    //Add Facebook
    $contactmethods['facebook'] = __('Facebook','republic'); 
	// Add Pinterest
    $contactmethods['pinterest'] = __('Pinterest','republic');
	// Add Instagram
    $contactmethods['instagram'] = __('Instagram','republic');
	//Add RSS
    $contactmethods['rss'] = __('RSS','republic');
    return $contactmethods;
    }
add_filter('user_contactmethods','republic_contactmethods',10,1);

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/template-parts/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'republic_register_required_plugins' );

function republic_register_required_plugins() {

   $plugins = array(

	
		
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),

	);


	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.


);	tgmpa( $plugins, $config );

}