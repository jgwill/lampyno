<?php 

	/**Includes reqired resources here**/
	define('BUSI_TEMPLATE_DIR_URI',get_template_directory_uri());
	define('BUSI_TEMPLATE_DIR',get_template_directory());
	define('BUSI_THEME_FUNCTIONS_PATH',BUSI_TEMPLATE_DIR.'/functions');

	require_once('theme_setup_data.php');

	//Files for custom - defaults menus
	require( BUSI_THEME_FUNCTIONS_PATH . '/menu/busiprof_nav_walker.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/menu/default_menu_walker.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/woo/woocommerce.php' );
	require( BUSI_THEME_FUNCTIONS_PATH .'/font/font.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/breadcrumbs/breadcrumbs.php');


	// Theme functions file including
	require( BUSI_THEME_FUNCTIONS_PATH . '/scripts/script.php');
	require( BUSI_THEME_FUNCTIONS_PATH . '/widgets/custom-widgets.php' ); // for footer widget
	require( BUSI_THEME_FUNCTIONS_PATH . '/commentbox/comment-function.php' ); // for custom contact widget

	// customizer files include
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/customizer-pro-feature.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_general_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_sections_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/cust_pro.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/customizer.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/customizer-archive.php');
	require( BUSI_THEME_FUNCTIONS_PATH . '/wpml-pll/functions.php' );
	
	function busiprof_customizer_css() {
		wp_enqueue_style( 'busiprof-customizer-info', get_template_directory_uri() . '/css/pro-feature.css' );
	}
	add_action( 'admin_init', 'busiprof_customizer_css' );

	//theme ckeck plugin required 	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('woocommerce');
	
	//content width
	if ( ! isset( $content_width ) ) $content_width = 750;	


	if ( ! function_exists( 'busiporf_setup' ) ) :
	function busiporf_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'busiprof', get_template_directory() . '/lang' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	
	// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );
	
	// supports featured image
	add_theme_support( 'post-thumbnails' );
	
	//Added Woocommerce Galllery Support
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'busiprof' )
	) );
	
	
} // busiporf_setup
endif;
	
	add_action( 'after_setup_theme', 'busiporf_setup' );
	
	
	function busiprof_inline_style() {
	$custom_css              = '';
	
	
	$busiprof_service_content = get_theme_mod(
		'busiprof_service_content', json_encode(
			array(
				array(
					'color'      => '#e91e63',
				),
				array(
					'color'      => '#00bcd4',
				),
				array(
					'color'      => '#4caf50',
				),
			)
		)
	);
	
	if ( ! empty( $busiprof_service_content ) ) {
		$busiprof_service_content = json_decode( $busiprof_service_content );
		
		
		foreach ( $busiprof_service_content as $key => $features_item ) {
			$box_nb = $key + 1;
			if ( ! empty( $features_item->color ) ) {
				
				$color = ! empty( $features_item->color ) ? apply_filters( 'busiprof_translate_single_string', $features_item->color, 'Features section' ) : '';
				
				$custom_css .= '.service-box:nth-child(' . esc_attr( $box_nb ) . ') .service-icon {
                            color: ' . esc_attr( $color ) . ';
				}';
				
				
			}
		}
	}
	wp_add_inline_style( 'style', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'busiprof_inline_style' );	



add_action( 'after_switch_theme', 'import_busiprof_child_theme_data_in_busiprof_theme' );
/**
* Import theme mods when switching from Busiprof child theme to Busiprof
*/
function import_busiprof_child_theme_data_in_busiprof_theme() {

    // Get the name of the previously active theme.
    $previous_theme = strtolower( get_option( 'theme_switched' ) );

    if ( ! in_array(
        $previous_theme, array(
            'vdequator',
			'vdperanto',
			'arzine',
			'lazyprof',
        )
    ) ) {
        return;
    }

    // Get the theme mods from the previous theme.
    $previous_theme_content = get_option( 'theme_mods_' . $previous_theme );

    if ( ! empty( $previous_theme_content ) ) {
        foreach ( $previous_theme_content as $previous_theme_mod_k => $previous_theme_mod_v ) {
            set_theme_mod( $previous_theme_mod_k, $previous_theme_mod_v );
        }
    }
} 
?>