<?php
/**
 * Created by PhpStorm.
 * User: venkat
 * Date: 2/5/16
 * Time: 4:32 PM        
 */

include_once( get_template_directory() . '/admin/kirki/kirki.php' );     
include_once( get_template_directory() . '/admin/kirki-helpers/class-modulus-kirki.php' );
       
Modulus_Kirki::add_config( 'modulus', array(     
	'capability'    => 'edit_theme_options',                  
	'option_type'   => 'theme_mod',           
) );             
       
// modulus option start //   

//  site identity section // 

Modulus_Kirki::add_section( 'title_tagline', array(
	'title'          => __( 'Site Identity','modulus' ),
	'description'    => __( 'Site Header Options', 'modulus'),       
	'priority'       => 8,         													
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'logo_title',
	'label'    => __( 'Enable Logo as Title', 'modulus' ),
	'section'  => 'title_tagline',
	'type'     => 'switch',
	'priority' => 5,
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',   
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'tagline',
	'label'    => __( 'Show site Tagline', 'modulus' ), 
	'section'  => 'title_tagline',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'on',
) );

// home panel //

Modulus_Kirki::add_panel( 'home_options', array(     
	'title'       => __( 'Home', 'modulus' ),
	'description' => __( 'Home Page Related Options', 'modulus' ),     
) );  

// home page type section

Modulus_Kirki::add_section( 'home_type_section', array(
	'title'          => __( 'Home - General Settings','modulus' ),
	'description'    => __( 'Home Page options', 'modulus'),
	'panel'          => 'home_options', // Not typically needed. 
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_home_default_content',
	'label'    => __( 'Enable Home Page Default Content', 'modulus' ),
	'section'  => 'home_type_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	
	'default'  => 'off',
	'tooltip' => __('Enable home page default content ( home page content )','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'home_sidebar',
	'label'    => __( 'Enable sidebar on the Home page', 'modulus' ),
	'section'  => 'home_type_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	
	'default'  => 'off',
	'tooltip' => __('Disable by default. If you want to display the sidebars in your frontpage, turn this Enable.','modulus'),
) );
  

// Slider section

Modulus_Kirki::add_section( 'slider_section', array(
	'title'          => __( 'Slider Section','modulus' ),
	'description'    => __( 'Home Page Slider Related Options', 'modulus'),
	'panel'          => 'home_options', // Not typically needed. 
) );
Modulus_Kirki::add_field( 'modulus', array(  
	'settings' => 'enable_slider',
	'label'    => __( 'Enable Slider Post ( Section )', 'modulus' ),
	'section'  => 'slider_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ),
	),
	'default'  => 'on',
	
	'tooltip' => __('Enable Slider Post in home page','modulus'),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'slider_cat',
	'label'    => __( 'Slider Posts category', 'modulus' ),
	'section'  => 'slider_section',
	'type'     => 'select',
	'choices' => Kirki_Helper::get_terms( 'category' ),
	'active_callback' => array(
		array(
			'setting'  => 'enable_slider',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Create post ( Goto Dashboard => Post => Add New ) and Post Featured Image ( Preferred size is 1200 x 450 pixels ) as taken as slider image and Post Content as taken as Flexcaption.','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'slider_count',
	'label'    => __( 'No. of Sliders', 'modulus' ),
	'section'  => 'slider_section',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 999,
		'step' => 1,
	),
	'default'  => 2,
	'active_callback' => array(
		array(
			'setting'  => 'enable_slider',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Enter number of slides you want to display under your selected Category','modulus'),
) );

// magazine page content section 

Modulus_Kirki::add_section( 'sidebar-widgets-magazine-page', array(   
	'title'          => __( 'Magazine Content Section','modulus' ),
	'description'    => __( 'You can use the following widgets here ( modulus: Featured Category Slider, modulus: Highlighted Post, modulus: Magazine Posts Boxed )', 'modulus'),
	'panel'          => 'home_options', // Not typically needed.
) );
     
// service section 

Modulus_Kirki::add_section( 'service_section', array(
	'title'          => __( 'Service Section','modulus' ),
	'description'    => __( 'Home Page - Service Related Options', 'modulus'),
	'panel'          => 'home_options', // Not typically needed. 
) );

Modulus_Kirki::add_field( 'modulus', array( 
	'settings' => 'enable_service',
	'label'    => __( 'Enable Service Section', 'modulus' ),
	'section'  => 'service_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),

	'default'  => 'on',
	'tooltip' => __('Enable service section in home page','modulus'),
) ); 
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'service_count',
	'label'    => __( 'No. of Service Section', 'modulus' ),
	'description' => __('Save the Settings, and Reload this page to Configure the service section','modulus'),
	'section'  => 'service_section',
	'type'     => 'number',
	'choices' => array(
		'min' => 3,
		'max' => 99,
		'step' => 3,
	),
	'default'  => 3,
	'active_callback' => array(
		array(
			'setting'  => 'enable_service',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Enter number of service page you want to display','modulus'),
) );

if ( get_theme_mod('service_count', 3) > 0 ) {
 $service = get_theme_mod('service_count', 3);
 		for ( $i = 1 ; $i <= $service ; $i++ ) {
             //Create the settings Once, and Loop through it.
 			Modulus_Kirki::add_field( 'modulus', array(
				'settings' => 'service_'.$i,
				'label'    => sprintf(__( 'Service Section #%1$s', 'modulus' ), $i ),
				'section'  => 'service_section',
				'type'     => 'dropdown-pages',	
				//'tooltip' => __('Create Page ( Goto Dashboard => Page =>Add New ) and Page Featured Image ( Preferred size is 100 x 100 pixels )','modulus'),
				'active_callback' => array(
					array(
						'setting'  => 'enable_service',
						'operator' => '==',
						'value'    => true,
					),
                ), 
               // 'description' => __('Create Page ( Goto Dashboard => Page =>Add New ) and Page Featured Image ( Preferred size is 100 x 100 pixels )','modulus'),
        
			) );
 		}
}

// latest blog section 

Modulus_Kirki::add_section( 'latest_blog_section', array(
	'title'          => __( 'Latest Blog Section','modulus' ),
	'description'    => __( 'Home Page - Latest Blog Options', 'modulus'),
	'panel'          => 'home_options', // Not typically needed. 
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_recent_post_service',
	'label'    => __( 'Enable Recent Post Section', 'modulus' ),
	'section'  => 'latest_blog_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),

	'default'  => 'on',
	'tooltip' => __('Enable recent post section in home page','modulus'),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'recent_posts_count',
	'label'    => __( 'No. of Recent Posts', 'modulus' ),
	'section'  => 'latest_blog_section',
	'type'     => 'number',
	'choices' => array(
		'min' => 3,
		'max' => 99,
		'step' => 3,
	),
	'default'  => 3,
	'active_callback' => array(
		array(
			'setting'  => 'enable_recent_post_service',
			'operator' => '==',
			'value'    => true,
		),

    ),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'recent_posts_exclude', 
	'label'    => __( 'Exclude the Posts from Home Page. Post IDs, separated by commas', 'modulus' ),
	'section'  => 'latest_blog_section',
	'type'     => 'text',
	'active_callback' => array(
		array(
			'setting'  => 'enable_recent_post_service',
			'operator' => '==',
			'value'    => true,
		),
		
    ),
) );

// general panel   

Modulus_Kirki::add_panel( 'general_panel', array(   
	'title'       => __( 'General Settings', 'modulus' ),  
	'description' => __( 'general settings', 'modulus' ),         
) );

//  Page title bar section // 

Modulus_Kirki::add_section( 'header-pagetitle-bar', array(   
	'title'          => __( 'Page Title Bar & Breadcrumb','modulus' ),
	'description'    => __( 'Page Title bar related options', 'modulus'),
	'panel'          => 'general_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'page_titlebar',  
	'label'    => __( 'Page Title Bar', 'modulus' ),
	'section'  => 'header-pagetitle-bar', 
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		1 => __( 'Show Bar and Content', 'modulus' ),
		2 => __( 'Show Content Only ', 'modulus' ),
		3 => __('Hide','modulus'),
    ),
    'default' => 1,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'page_titlebar_text',  
	'label'    => __( 'Page Title Bar Text', 'modulus' ),
	'section'  => 'header-pagetitle-bar', 
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		1 => __( 'Show', 'modulus' ),
		2 => __( 'Hide', 'modulus' ), 
    ),
    'default' => 1,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'breadcrumb',  
	'label'    => __( 'Breadcrumb', 'modulus' ),
	'section'  => 'header-pagetitle-bar', 
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ),
	),
	'default'  => 'on',
) ); 

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'breadcrumb_char',
	'label'    => __( 'Breadcrumb Character', 'modulus' ),
	'section'  => 'header-pagetitle-bar',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		1 => __( ' >> ', 'modulus' ),
		2 => __( ' // ', 'modulus' ),
		3 => __( ' > ', 'modulus' ),
	),
	'default'  => 1,
	'active_callback' => array(
		array(
			'setting'  => 'breadcrumb',
			'operator' => '==',
			'value'    => true,
		),
	),
	//'sanitize_callback' => 'allow_htmlentities'
) );

//  pagination section // 

Modulus_Kirki::add_section( 'general-pagination', array(   
	'title'          => __( 'Pagination','modulus' ),
	'description'    => __( 'Pagination related options', 'modulus'),
	'panel'          => 'general_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'numeric_pagination',
	'label'    => __( 'Numeric Pagination', 'modulus' ),   
	'section'  => 'general-pagination',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Numbered', 'modulus' ),
		'off' => esc_attr__( 'Next/Previous', 'modulus' )
	),
	'default'  => 'on',
) );

// skin color panel 

Modulus_Kirki::add_panel( 'skin_color_panel', array(   
	'title'       => __( 'Skin Color', 'modulus' ),  
	'description' => __( 'Color Settings', 'modulus' ),         
) );

// Change Color Options

Modulus_Kirki::add_section( 'primary_color_field', array(
	'title'          => __( 'Change Color Options','modulus' ),
	'description'    => __( 'This will reflect in links, buttons,Navigation and many others. Choose a color to match your site.', 'modulus'),
	'panel'          => 'skin_color_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_primary_color',
	'label'    => __( 'Enable Custom Primary color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'primary_color',
	'label'    => __( 'Primary color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'color',
	'default'  => '#E5493A',
	'choices'  => array(
	    'alpha' => true,
	),
	'active_callback' => array(
		array (
			'setting'  => 'enable_primary_color',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output' => array(
		array(
			'element'  => 'input[type="text"]:focus,
							input[type="email"]:focus,
							input[type="url"]:focus,
							input[type="password"]:focus,
							input[type="search"]:focus,
							.flexslider .flex-caption a,
							.widget_tag_cloud a ,
							textarea:focus,
							.title-divider:before,
							.services-wrapper .service:hover,
							.services-wrapper .service:hover .service-content ',
		    'property' => 'border-color',
		),
		array(
			'element'  => '.flexslider .flex-direction-nav a:hover,
							.woocommerce #content input.button:hover, 
							.woocommerce #respond input#submit:hover, 
							.woocommerce a.button:hover, 
							.woocommerce button.button:hover, 
							.woocommerce input.button:hover, 
							.woocommerce-page #content input.button:hover,
							.woocommerce-page #respond input#submit:hover, 
							.woocommerce-page a.button:hover, 
							.woocommerce-page button.button:hover, 
							.woocommerce-page input.button:hover
							.nav-wrap,.main-navigation .sub-menu li a:hover, .main-navigation .children li a:hover,
							.light-blue,.light-blue-text,.nav-links .nav-previous:hover a,
							.more-link .nav-previous:hover a, .comment-navigation .nav-previous:hover a, 
							.nav-links .nav-next:hover a,
							.more-link .nav-next:hover a, .comment-navigation .nav-next:hover a ,
							.more-link .nav-next:hover a .meta-nav, .comment-navigation .nav-next:hover a .meta-nav, 
							 a.more-link:hover,a.more-link:hover .meta-nav,ol.webulous_page_navi li ,
							ol.webulous_page_navi .bpn-next-link, ol.webulous_page_navi .bpn-prev-link,
							.top-right ul li:hover a ,.share-box ul li a:hover,.hentry.sticky ,
							.page-links ,.main-navigation button.menu-toggle:hover,.widget_tag_cloud a ,
							.site-footer .footer-widgets .widget_calendar table caption,.flexslider .flex-caption a,blockquote,
							.title-divider:after,.services-wrapper .service .demo-thumb,.flexslider .flex-direction-nav a:hover,
							.woocommerce #content nav.woocommerce-pagination ul li a:focus,
							.woocommerce a.remove,.woocommerce #content table.cart a.remove, 
							.woocommerce table.cart a.remove,.woocommerce-page #content table.cart a.remove,
							 .woocommerce-page table.cart a.remove,.woocommerce #content div.product .woocommerce-tabs ul.tabs li a:hover, 
							 .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce-page #content div.product 
							 .woocommerce-tabs ul.tabs li a:hover, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a:hover, 
							 .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
							  .woocommerce div.product .woocommerce-tabs ul.tabs li.active, 
							  .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, 
							  .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
							  .woocommerce #content nav.woocommerce-pagination ul li a:hover, 
							  .woocommerce #content nav.woocommerce-pagination ul li span.current, 
							  .woocommerce nav.woocommerce-pagination ul li a:focus, 
							  .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, 
							  .woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
							   .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, 
							   .woocommerce-page #content nav.woocommerce-pagination ul li span.current,
							    .woocommerce-page nav.woocommerce-pagination ul li a:focus, 
							    .woocommerce-page nav.woocommerce-pagination ul li a:hover,.nav-wrap, 
							    .woocommerce-page nav.woocommerce-pagination ul li span.current,input[type="submit"]:hover,
							    .site-footer .scroll-to-top,.site-footer .scroll-to-top:hover,.primary .sticky',
			'property' => 'background-color',
		),
		
		array(
			'element'  => '.cart-subtotal .amount,.woocommerce .woocommerce-breadcrumb a:hover, 
								.woocommerce-page .woocommerce-breadcrumb a:hover,.free-home .post-wrapper .btn-readmore,
								.free-home .post-wrapper .entry-meta span:hover i, .free-home .post-wrapper .entry-meta span:hover a ,
								.free-home .post-wrapper .entry-meta span:hover,.free-home .post-wrapper h3 a:hover,
								.free-home .title-divider:before,.free-home .services-wrapper .service:hover h4,
								.site-info .widget_nav_menu a:hover,.site-info p a ,.site-footer .footer-widgets a:hover,
								.site-footer .footer-widgets #calendar_wrap a,.widget-area .widget_rss a ,.widget_calendar table th a, 
								.widget_calendar table td a,#secondary #recentcomments a,.widget-area ul li a:hover,
								.flexslider .flex-caption h1:before, .flexslider .flex-caption h2:before, .flexslider .flex-caption h3:before, 
								.flexslider .flex-caption h4:before, .flexslider .flex-caption h5:before, .flexslider .flex-caption h6:before,
								.breadcrumb a,.post-wrapper .btn-readmore,.post-wrapper .entry-meta span:hover i, 
								.post-wrapper .entry-meta span:hover a,.post-wrapper .entry-meta span:hover,.post-wrapper h3 a:hover,
								.services-wrapper .service:hover h4,.title-divider:before,.hentry.post h1 a:hover,.top-nav ul li:hover a,
								.branding .site-branding .site-title a:hover:first-letter,a,input[type=text]:focus:not([readonly]) + label,
								input[type=password]:focus:not([readonly]) + label,
								input[type=email]:focus:not([readonly]) + label,
								input[type=url]:focus:not([readonly]) + label,
								input[type=time]:focus:not([readonly]) + label,
								input[type=date]:focus:not([readonly]) + label,.site-branding .site-title a,
								input[type=datetime-local]:focus:not([readonly]) + label,
								input[type=tel]:focus:not([readonly]) + label,
								input[type=number]:focus:not([readonly]) + label,
								input[type=search]:focus:not([readonly]) + label,
								textarea.materialize-textarea:focus:not([readonly]) + label ,	
								ol.comment-list .reply:before, .comment-author .fn a:hover,ol.comment-list article .fn:hover,
								.comment-metadata a:hover,.hentry.sticky h1.entry-title a:hover,
							.hentry.sticky a:hover,a,.nav-links .nav-next:hover a .meta-nav,.nav-links .nav-previous:hover a .meta-nav',

			'property' => 'color',
		),
		
		array(
			'element' => 'input[type=text],
							input[type=password],
							input[type=email],
							input[type=url],
							input[type=time],
							input[type=date],
							input[type=datetime-local],
							input[type=tel],
							input[type=number],
							input[type=search],
							textarea.materialize-textarea, input[type=text]:focus:not([readonly]),
							input[type=password]:focus:not([readonly]),
							input[type=email]:focus:not([readonly]),
							input[type=url]:focus:not([readonly]),
							input[type=time]:focus:not([readonly]),
							input[type=date]:focus:not([readonly]),
							input[type=datetime-local]:focus:not([readonly]),
							input[type=tel]:focus:not([readonly]),
							input[type=number]:focus:not([readonly]),
							input[type=search]:focus:not([readonly]),
							textarea.materialize-textarea:focus:not([readonly]),.widget-area h4.widget-title',
			'property' => 'border-bottom-color',
		),
		
	),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_nav_bg_color',
	'label'    => __( 'Enable Navigation Bar BG Color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'nav_bg_color',
	'label'    => __( 'Navigation Bar BG Color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'color',
	'default'  => '#03a9f4',
	'choices'  => array(
	    'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_nav_bg_color',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output' => array(
		array(
			'element' => '.nav-wrap',
			'property' => 'background-color',
		),
		array(
			'element' => '.nav-wrap',
			'property' => 'background-color',
			'media_query' => '@media(max-width: 600px)',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_nav_hover_color',
	'label'    => __( 'Enable Navigation Hover color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );    
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'nav_hover_color',
	'label'    => __( 'Navigation Hover Color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'color',
	'default'  => '#33363a',
	'choices'  => array(
	    'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_nav_hover_color',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output' => array(
		array(
			'element' => '.main-navigation li:hover::before,.main-navigation li:hover,
						.main-navigation .current_page_item::before, 
						.main-navigation .current-menu-item::before, .main-navigation .current_page_ancestor::before,
						.main-navigation .current-menu-parent::before,
						.main-navigation .current_page_item, .main-navigation .current-menu-item, .main-navigation .current_page_ancestor, 
						.main-navigation .current-menu-parent > a,.main-navigation .sub-menu, 
						.main-navigation .children,.main-navigation .sub-menu li a, .main-navigation .children li a',
			'property' => 'background-color',
		),
		array(
			'element' => '.main-navigation li:hover::after,.main-navigation .current_page_item::after, .main-navigation .current-menu-item::after, 
			.main-navigation .current_page_ancestor::after, .main-navigation .current-menu-parent::after',
			'property' => 'color',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_dd_hover_color',
	'label'    => __( 'Enable Custom Navigation Dropdown Hover color ', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'dd_hover_color',
	'label'    => __( 'Navigation Dropdown Hover Color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'color',
	'default'  => '#33363a',
	'choices'  => array(
	    'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_dd_hover_color',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output' => array(
		
		array(
			'element' => '.main-navigation .sub-menu .current_page_item > a, 
						.main-navigation .sub-menu .current-menu-item > a, .main-navigation .sub-menu .current_page_ancestor > a, 
						.main-navigation .children .current_page_item > a, .main-navigation .children .current-menu-item > a,
						.main-navigation .children .current_page_ancestor > a,.main-navigation .sub-menu li a:hover, 
						.main-navigation .children li a:hover',
			'property' => 'background-color',
		),
       array(
			'element' => '.main-navigation .sub-menu .current_page_item > a,
			              .main-navigation .children .current_page_item >a',
			'property' => 'color',
			'media_query' => '@media(max-width: 600px)',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_rippler_color',
	'label'    => __( 'Enable Custom Rippler color ', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'rippler_color',
	'label'    => __( 'Rippler Color', 'modulus' ),
	'section'  => 'primary_color_field',
	'type'     => 'color',
	'default'  => '#fff',
	'choices'  => array(
	    'alpha' => true,
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_rippler_color',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output' => array(
		
		array(
			'element' => '.rippler-default .rippler-div ',
			'property' => 'background-color',
		),
	),
) );

// typography panel //

Modulus_Kirki::add_panel( 'typography', array( 
	'title'       => __( 'Typography', 'modulus' ),
	'description' => __( 'Typography and Link Color Settings', 'modulus' ),
) );
   
    Modulus_Kirki::add_section( 'typography_section', array(
		'title'          => __( 'General Settings','modulus' ),
		'description'    => __( 'General Settings', 'modulus'),
		'panel'          => 'typography', // Not typically needed.
	) );
	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'custom_typography',
		'label'    => __( 'Enable Custom Typography', 'modulus' ),
		'description' => __('Save the Settings, and Reload this page to Configure the typography section','modulus'),
		'section'  => 'typography_section',
		'type'     => 'switch',
		'choices' => array(
			'on'  => esc_attr__( 'Enable', 'modulus' ),
			'off' => esc_attr__( 'Disable', 'modulus' )
		),
		'tooltip' => __('Turn on to customize typography and turn off for default typography','modulus'),
		'default'  => 'off',
	) );

$typography_setting = get_theme_mod('custom_typography',false );
if( $typography_setting ) :

        $body_font = get_theme_mod('body_family','Roboto');		        
	    $body_color = get_theme_mod( 'body_color','#33363a' );   
		$body_size = get_theme_mod( 'body_size','16');
		$body_weight = get_theme_mod( 'body_weight','regular');
		$body_weight == 'bold' ? $body_weight = '700':  $body_weight = 'regular';
		

	Modulus_Kirki::add_section( 'body_font', array(
		'title'          => __( 'Body Font','modulus' ),
		'description'    => __( 'Specify the body font properties', 'modulus'),
		'panel'          => 'typography', // Not typically needed.
	) ); 


	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'body',
		'label'    => __( 'Body Settings', 'modulus' ),
		'section'  => 'body_font', 
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $body_font,
			'variant'        => $body_weight,
			'font-size'      => $body_size.'px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => $body_color,
		),
		'output'      => array(
			array(
				'element' => 'body',
				//'suffix' => '!important',
			),
		),
	) );


	Modulus_Kirki::add_section( 'heading_section', array(
		'title'          => __( 'Heading Font','modulus' ),
		'description'    => __( 'Specify typography of H1, H2, H3, H4, H5, H6', 'modulus'),
		'panel'          => 'typography', // Not typically needed.
	) );
	

	$h1_font = get_theme_mod('h1_family','Roboto');
	$h1_color = get_theme_mod( 'h1_color','#33363a' );
	$h1_size = get_theme_mod( 'h1_size','48');
	$h1_weight = get_theme_mod( 'h1_weight','700');
	$h1_weight == 'bold' ? $h1_weight = '700' : $h1_weight = 'regular';

	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h1',
		'label'    => __( 'H1 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $h1_font,
			'variant'        => $h1_weight,
			'font-size'      => $h1_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h1_color,
		),
		'output'      => array(
			array(
				'element' => 'h1',
			),
		),
		
	) );

	$h2_font = get_theme_mod('h2_family','Roboto');
	$h2_color = get_theme_mod( 'h2_color','#33363a' );
	$h2_size = get_theme_mod( 'h2_size','36');
	$h2_weight = get_theme_mod( 'h2_weight','700');
	$h2_weight == 'bold' ? $h2_weight = '700' : $h2_weight = 'regular';

	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h2',
		'label'    => __( 'H2 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $h2_font,
			'variant'        => $h2_weight,
			'font-size'      => $h2_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h2_color,
		),
		'output'      => array(
			array(
				'element' => 'h2',
			),
		),
		
	) );

	$h3_font = get_theme_mod('h3_family','Roboto');
	$h3_color = get_theme_mod( 'h3_color','#33363a' );
	$h3_size = get_theme_mod( 'h3_size','30');
	$h3_weight = get_theme_mod( 'h3_weight','700');
	$h3_weight == 'bold' ? $h3_weight = '700' : $h3_weight = 'regular';

	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h3',
		'label'    => __( 'H3 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default' => array(
			'font-family'    => $h3_font,
			'variant'        => $h3_weight,
			'font-size'      => $h3_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h3_color,
		),
		'output'      => array(
			array(
				'element' => 'h3',
			),
		),
		
	) );

	$h4_font = get_theme_mod('h4_family','Roboto');
	$h4_color = get_theme_mod( 'h4_color','#33363a' );
	$h4_size = get_theme_mod( 'h4_size','24');
	$h4_weight = get_theme_mod( 'h4_weight','700');
	$h4_weight == 'bold' ? $h4_weight = '700' : $h4_weight = 'regular';


	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h4',
		'label'    => __( 'H4 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $h4_font,
			'variant'        => $h4_weight,
			'font-size'      => $h4_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h4_color,
		),
		'output'      => array(
			array(
				'element' => 'h4',
			),
		),
		
	) );

    $h5_font = get_theme_mod('h5_family','Roboto');
	$h5_color = get_theme_mod( 'h5_color','#33363a' );
	$h5_size = get_theme_mod( 'h5_size','18');
	$h5_weight = get_theme_mod( 'h5_weight','700');
	$h5_weight == 'bold' ? $h5_weight = '700' : $h5_weight = 'regular';


	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h5',
		'label'    => __( 'H5 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $h5_font,
			'variant'        => $h5_weight,
			'font-size'      => $h5_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h5_color,
		),
		'output'      => array(
			array(
				'element' => 'h5',
			),
		),
		
	) );

	$h6_font = get_theme_mod('h6_family','Roboto');
	$h6_color = get_theme_mod( 'h6_color','#33363a' );
	$h6_size = get_theme_mod( 'h6_size','16');
	$h6_weight = get_theme_mod( 'h6_weight','700');
	$h6_weight == 'bold' ? $h6_weight = '700' : $h6_weight = 'regular';


	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'h6',
		'label'    => __( 'H6 Settings', 'modulus' ),
		'section'  => 'heading_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => $h6_font,
			'variant'        => $h6_weight,
			'font-size'      => $h6_size.'px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'color'          => $h6_color,
		),
		'output'      => array(
			array(
				'element' => 'h6',
			),
		),
		
	) );

	// navigation font 
	Modulus_Kirki::add_section( 'navigation_section', array(
		'title'          => __( 'Navigation Font','modulus' ),
		'description'    => __( 'Specify Navigation font properties', 'modulus'),
		'panel'          => 'typography', // Not typically needed.
	) );

	Modulus_Kirki::add_field( 'modulus', array(
		'settings' => 'navigation_font',
		'label'    => __( 'Navigation Font Settings', 'modulus' ),
		'section'  => 'navigation_section',
		'type'     => 'typography',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => '400',
			'font-size'      => '15px',
			'line-height'    => '1.8', 
			'letter-spacing' => '0',
			'color'          => '#ffffff',
		),
		'output'      => array(
			array(
				'element' => '.main-navigation a,.main-navigation ul ul a,
							.main-navigation a:hover, .main-navigation .current_page_item > a,
							 .main-navigation .current-menu-item > a, .main-navigation .current-menu-parent > a, 
							 .main-navigation .current_page_ancestor > a, .main-navigation .current_page_parent > a',
			),
		),
	) );
endif; 


// header panel //

Modulus_Kirki::add_panel( 'header_panel', array(     
	'title'       => __( 'Header', 'modulus' ),
	'description' => __( 'Header Related Options', 'modulus' ), 
) );  

Modulus_Kirki::add_section( 'header', array(
	'title'          => __( 'General Header','modulus' ),
	'description'    => __( 'Header options', 'modulus'),
	'panel'          => 'header_panel', // Not typically needed.  
) );    

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_text_color',
	'label'    => __( 'Header Text Color', 'modulus' ),
	'section'  => 'header',
	'type'     => 'color',
	'choices'  => array(
	    'alpha' => true,
	),
	'default'  => '#ffffff', 
	'output'   => array(
		array(
			'element'  => '.main-navigation a,.main-navigation ul ul a,
							.main-navigation a:hover, .main-navigation .current_page_item > a,
							 .main-navigation .current-menu-item > a, .main-navigation .current-menu-parent > a, 
							 .main-navigation .current_page_ancestor > a, .main-navigation .current_page_parent > a',
			'property' => 'color',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_search',
	'label'    => __( 'Enable to Show Search box in Header', 'modulus' ), 
	'section'  => 'header',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'on',
) );



/* STICKY HEADER section */   

Modulus_Kirki::add_section( 'stricky_header', array(
	'title'          => __( 'Sticky Menu','modulus' ),
	'description'    => __( 'sticky header', 'modulus'),
	'panel'          => 'header_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array(    
	'settings' => 'sticky_header',
	'label'    => __( 'Enable Sticky Header', 'modulus' ),
	'section'  => 'stricky_header',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'sticky_header_position',
	'label'    => __( 'Enable Sticky Header Position', 'modulus' ),
	'section'  => 'stricky_header',
	'type'     => 'radio-buttonset',
	'choices' => array(
		'top'  => esc_attr__( 'Top', 'modulus' ),
		'bottom' => esc_attr__( 'Bottom', 'modulus' )
	),
	'active_callback'    => array(
		array(
			'setting'  => 'sticky_header',
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'top',
) );

Modulus_Kirki::add_section( 'scroll_to_top', array(
	'title'          => __( 'Scroll to Top','modulus' ),
	'description'    => __( 'Scroll to Top Button', 'modulus'),
	'panel'          => 'header_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array(    
	'settings' => 'scroll_to_top_button',
	'label'    => __( 'Enable Scroll to Top', 'modulus' ),
	'section'  => 'scroll_to_top',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'on',
) );

/*
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_top_margin',
	'label'    => __( 'Header Top Margin', 'modulus' ),
	'description' => __('Select the top margin of header in pixels','modulus'),
	'section'  => 'header',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 1000,
		'step' => 1,
	),
	//'default'  => '213',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_bottom_margin',
	'label'    => __( 'Header Bottom Margin', 'modulus' ),
	'description' => __('Select the bottom margin of header in pixels','modulus'),
	'section'  => 'header',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 1000,
		'step' => 1,
	),
	//'default'  => '213',
) );*/

Modulus_Kirki::add_section( 'header_image', array(
	'title'          => __( 'Header Background Image & Video','modulus' ),
	'description'    => __( 'Custom Header Image & Video options', 'modulus'),
	'panel'          => 'header_panel', // Not typically needed.  
) );

Modulus_Kirki::add_field( 'modulus', array(   
	'settings' => 'header_bg_size',
	'label'    => __( 'Header Background Size', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'radio-buttonset', 
    'choices' => array(
		'cover'  => esc_attr__( 'Cover', 'modulus' ),
		'contain' => esc_attr__( 'Contain', 'modulus' ),
		'auto'  => esc_attr__( 'Auto', 'modulus' ),
		'inherit'  => esc_attr__( 'Inherit', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => '.header-image',
			'property' => 'background-size',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_image',
			'operator' => '!=',
			'value'    => 'remove-header',
		),
	),
	'default'  => 'cover',
	'tooltip' => __('Header Background Image Size','modulus'),
) );

/*Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_height',
	'label'    => __( 'Header Background Image Height', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'number',
	'choices' => array(
		'min' => 100,
		'max' => 600,
		'step' => 1,
	),
	'default'  => '213',
) ); */
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_bg_repeat',
	'label'    => __( 'Header Background Repeat', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'no-repeat' => esc_attr__('No Repeat', 'modulus'),
        'repeat' => esc_attr__('Repeat', 'modulus'),
        'repeat-x' => esc_attr__('Repeat Horizontally','modulus'),
        'repeat-y' => esc_attr__('Repeat Vertically','modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.header-image',
			'property' => 'background-repeat',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_image',
			'operator' => '!=',
			'value'    => 'remove-header',
		),
	),
	'default'  => 'repeat',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_bg_position', 
	'label'    => __( 'Header Background Position', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'center top' => esc_attr__('Center Top', 'modulus'),
        'center center' => esc_attr__('Center Center', 'modulus'),
        'center bottom' => esc_attr__('Center Bottom', 'modulus'),
        'left top' => esc_attr__('Left Top', 'modulus'),
        'left center' => esc_attr__('Left Center', 'modulus'),
        'left bottom' => esc_attr__('Left Bottom', 'modulus'),
        'right top' => esc_attr__('Right Top', 'modulus'),
        'right center' => esc_attr__('Right Center', 'modulus'),
        'right bottom' => esc_attr__('Right Bottom', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.header-image',
			'property' => 'background-position',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_image',
			'operator' => '!=',
			'value'    => 'remove-header',
		),
	), 
	'default'  => 'center center',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_bg_attachment',
	'label'    => __( 'Header Background Attachment', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'scroll' => esc_attr__('Scroll', 'modulus'),
        'fixed' => esc_attr__('Fixed', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.header-image',
			'property' => 'background-attachment',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_image',
			'operator' => '!=',
			'value'    => 'remove-header',
		),
	),
	'default'  => 'scroll',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_overlay',
	'label'    => __( 'Enable Header( Background ) Overlay', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'switch',    
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
  
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'header_overlay_color',
	'label'    => __( 'Header Overlay ( Background )color', 'modulus' ),
	'section'  => 'header_image',
	'type'     => 'color',  
	'choices'  => array(
	    'alpha' => true,
	),
	'default'  => '#ffffff', 
	'output'   => array(
		array(
			'element'  => '.overlay-header',
			'property' => 'background-color',
		),
	), 
	'active_callback' => array(
		array(
			'setting'  => 'header_overlay',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

/*
/* e-option start */
/*
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'custon_favicon',
	'label'    => __( 'Custom Favicon', 'modulus' ),
	'section'  => 'header',
	'type'     => 'upload',
	'default'  => '',
) ); */
/* e-option start */ 
/* Blog page section */


/* Blog panel */

Modulus_Kirki::add_panel( 'blog_panel', array(     
	'title'       => __( 'Blog', 'modulus' ),
	'description' => __( 'Blog Related Options', 'modulus' ),     
) ); 
Modulus_Kirki::add_section( 'blog', array(
	'title'          => __( 'Blog Page','modulus' ),
	'description'    => __( 'Blog Related Options', 'modulus'),
	'panel'          => 'blog_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'blog-slider',
	'label'    => __( 'Enable to show the slider on blog page', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'off',
	'tooltip' => __('To show the slider on posts page','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'blog_slider_cat',
	'label'    => __( 'Blog Slider Posts category', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'select',
	'choices' => Kirki_Helper::get_terms( 'category' ),
	'active_callback' => array(
		array(
			'setting'  => 'blog-slider',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Create post ( Goto Dashboard => Post => Add New ) and Post Featured Image ( Preferred size is 1200 x 450 pixels ) as taken as slider image and Post Content as taken as Flexcaption.','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'blog_slider_count',
	'label'    => __( 'No. of Sliders', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 999,
		'step' => 1,
	),
	'default'  => 2,
	'active_callback' => array(
		array(
			'setting'  => 'blog-slider',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Enter number of slides you want to display under your selected Category','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'blog_layout',
	'label'    => __( 'Select Blog Page Layout you prefer', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'select',
	'multiple'  => 1,
	'choices' => array(
		1  => esc_attr__( 'Default ( One Column )', 'modulus' ),
		2 => esc_attr__( 'Two Columns ', 'modulus' ),
		3 => esc_attr__( 'Three Columns ( Without Sidebar ) ', 'modulus' ),
		4 => esc_attr__( 'Two Columns With Masonry', 'modulus' ),
		5 => esc_attr__( 'Three Columns With Masonry ( Without Sidebar ) ', 'modulus' ),
		6 => esc_attr__( 'Full Width ', 'modulus' ),
	),
	'default'  => 1,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'featured_image',
	'label'    => __( 'Enable Featured Image', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
	'tooltip' => __('Enable Featured Image for blog page','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'more_text',
	'label'    => __( 'More Text', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'text',
	'description' => __('Text to display in case of text too long','modulus'),
	'default' => __('Read More','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'featured_image_size',
	'label'    => __( 'Choose the Featured Image Size for Blog Page', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'select',
	'multiple'  => 1,
	'choices' => array(
		1 => esc_attr__( 'Large Featured Image', 'modulus' ),
		2 => esc_attr__( 'Small Featured Image', 'modulus' ),
		3 => esc_attr__( 'Original Size', 'modulus' ),
		4 => esc_attr__( 'Medium', 'modulus' ),
		5 => esc_attr__( 'Large', 'modulus' ), 
	),
	'default'  => 1,
	'active_callback' => array(
		array(
			'setting'  => 'featured_image',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Set large and medium image size: Goto Dashboard => Settings => Media', 'modulus') ,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_single_post_top_meta',
	'label'    => __( 'Enable to display top post meta data', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
	'tooltip' => __('Enable to Display Top Post Meta Details. This will reflect for blog page, single blog page, blog full width & blog large templates','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_post_top_meta',
	'label'    => __( 'Activate and Arrange the Order of Top Post Meta elements', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'sortable',
	'choices'     => array(
		1 => esc_attr__( 'date', 'modulus' ),
		2 => esc_attr__( 'author', 'modulus' ),
		3 => esc_attr__( 'comment', 'modulus' ),
		4 => esc_attr__( 'category', 'modulus' ),
		5 => esc_attr__( 'tags', 'modulus' ),
		6 => esc_attr__( 'edit', 'modulus' ),
	),
	'default'  => array(1, 2, 6),
	'active_callback' => array(
		array(
			'setting'  => 'enable_single_post_top_meta',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Click above eye icon in order to activate the field, This will reflect for blog page, single blog page, blog full width & blog large templates','modulus'),

) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'enable_single_post_bottom_meta',
	'label'    => __( 'Enable to display bottom post meta data', 'modulus' ),
	'section'  => 'blog', 
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'tooltip' => __('Enable to Display Top Post Meta Details. This will reflect for blog page, single blog page, blog full width & blog large templates','modulus'),
	'default'  => 'on',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_post_bottom_meta',
	'label'    => __( 'Activate and arrange the Order of Bottom Post Meta elements', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'sortable',
	'choices'     => array(
		1 => esc_attr__( 'date', 'modulus' ),
		2 => esc_attr__( 'author', 'modulus' ),
		3 => esc_attr__( 'comment', 'modulus' ),
		4 => esc_attr__( 'category', 'modulus' ),
		5 => esc_attr__( 'tags', 'modulus' ),
		6 => esc_attr__( 'edit', 'modulus' ),
	),
	'default'  => array(3,4,5),
	'active_callback' => array(
		array(
			'setting'  => 'enable_single_post_bottom_meta',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Click above eye icon in order to activate the field, This will reflect for blog page, single blog page, blog full width & blog large templates','modulus'),
) );


/* Single Blog page section */

Modulus_Kirki::add_section( 'single_blog', array(
	'title'          => __( 'Single Blog Page','modulus' ),
	'description'    => __( 'Single Blog Page Related Options', 'modulus'),
	'panel'          => 'blog_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_featured_image',
	'label'    => __( 'Enable Single Post Featured Image', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
	'tooltip' => __('Enable Featured Image for Single Post Page','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_featured_image_size',
	'label'    => __( 'Choose the featured image display type for Single Post Page', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'radio',
	'choices' => array(
		1  => esc_attr__( 'Large Featured Image', 'modulus' ),
		2 => esc_attr__( 'Small Featured Image', 'modulus' ),
		3 => esc_attr__( 'FullWidth Featured Image', 'modulus' ),
	),
	'default'  => 1,
	'active_callback' => array(
		array(
			'setting'  => 'single_featured_image',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'author_bio_box',
	'label'    => __( 'Enable Author Bio Box below single post', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'off',
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'related_posts',
	'label'    => __( 'Show Related Posts', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'off',
	'tooltip' => __('Show the Related Post for Single Blog Page','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'social_sharing_box',
	'label'    => __( 'Show social sharing options box below single post', 'modulus' ),
	'section'  => 'blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'related_posts_hierarchy',
	'label'    => __( 'Related Posts Must Be Shown As:', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'radio',
	'choices' => array(
		1  => esc_attr__( 'Related Posts By Tags', 'modulus' ),
		2 => esc_attr__( 'Related Posts By Categories', 'modulus' ) 
	),
	'default'  => 1,
	'active_callback' => array(
		array(
			'setting'  => 'related_posts',
			'operator' => '==',
			'value'    => true,
		),
    ),
    'tooltip' => __('Select the Hierarchy','modulus'),

) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'comments',
	'label'    => __( ' Show Comments', 'modulus' ),
	'section'  => 'single_blog',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
	'tooltip' => __('Show the Comments for Single Blog Page','modulus'),
) );
/* FOOTER SECTION 
footer panel */

Modulus_Kirki::add_panel( 'footer_panel', array(     
	'title'       => __( 'Footer', 'modulus' ),
	'description' => __( 'Footer Related Options', 'modulus' ),     
) );  

Modulus_Kirki::add_section( 'footer', array(
	'title'          => __( 'Footer','modulus' ),
	'description'    => __( 'Footer related options', 'modulus'),
	'panel'          => 'footer_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_widgets',
	'label'    => __( 'Footer Widget Area', 'modulus' ),
	'description' => sprintf(__('Select widgets, Goto <a href="%1$s"target="_blank"> Customizer </a> => Widgets','modulus'),admin_url('customize.php') ),
	'section'  => 'footer',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
/* Choose No.Of Footer area */
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_widgets_count',
	'label'    => __( 'Choose No.of widget area you want in footer', 'modulus' ),
	'section'  => 'footer',
	'type'     => 'radio-buttonset',
	'choices' => array(
		1  => esc_attr__( '1', 'modulus' ),
		2  => esc_attr__( '2', 'modulus' ),
		3  => esc_attr__( '3', 'modulus' ),
		4  => esc_attr__( '4', 'modulus' ),
	),
	'default'  => 4,
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'copyright',
	'label'    => __( 'Footer Copyright Text', 'modulus' ),
	'section'  => 'footer',
	'type'     => 'textarea',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_top_margin',
	'label'    => __( 'Footer Top Margin', 'modulus' ),
	'description' => __('Select the top margin of footer in pixels','modulus'),
	'section'  => 'footer',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 1000,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.site-footer',
			'property' => 'margin-top',
			'units' => 'px',
		),
	),
	'default'  => 0,
) );

/* CUSTOM FOOTER BACKGROUND IMAGE 
footer background image section  */

Modulus_Kirki::add_section( 'footer_image', array(
	'title'          => __( 'Footer Image','modulus' ),
	'description'    => __( 'Custom Footer Image options', 'modulus'),
	'panel'          => 'footer_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_image',
	'label'    => __( 'Upload Footer Background Image', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'upload',
	'default'  => '',
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-image',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_size',
	'label'    => __( 'Footer Background Size', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'radio-buttonset',
    'choices' => array(
		'cover'  => esc_attr__( 'Cover', 'modulus' ),
		'contain' => esc_attr__( 'Contain', 'modulus' ),
		'auto'  => esc_attr__( 'Auto', 'modulus' ),
		'inherit'  => esc_attr__( 'Inherit', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-size',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'cover',
	'tooltip' => __('Footer Background Image Size','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_repeat',
	'label'    => __( 'Footer Background Repeat', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'no-repeat' => esc_attr__('No Repeat', 'modulus'),
        'repeat' => esc_attr__('Repeat', 'modulus'),
        'repeat-x' => esc_attr__('Repeat Horizontally','modulus'),
        'repeat-y' => esc_attr__('Repeat Vertically','modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-repeat',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'repeat',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_position',
	'label'    => __( 'Footer Background Position', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'center top' => esc_attr__('Center Top', 'modulus'),
        'center center' => esc_attr__('Center Center', 'modulus'),
        'center bottom' => esc_attr__('Center Bottom', 'modulus'),
        'left top' => esc_attr__('Left Top', 'modulus'),
        'left center' => esc_attr__('Left Center', 'modulus'),
        'left bottom' => esc_attr__('Left Bottom', 'modulus'),
        'right top' => esc_attr__('Right Top', 'modulus'),
        'right center' => esc_attr__('Right Center', 'modulus'),
        'right bottom' => esc_attr__('Right Bottom', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-position',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'center center',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_attachment',
	'label'    => __( 'Footer Background Attachment', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'scroll' => esc_attr__('Scroll', 'modulus'),
        'fixed' => esc_attr__('Fixed', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-attachment',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'scroll',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_overlay',
	'label'    => __( 'Enable Footer( Background ) Overlay', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
  
Modulus_Kirki::add_field( 'modulus', array(  
	'settings' => 'footer_overlay_color',
	'label'    => __( 'Footer Overlay ( Background )color', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'color',  
	'choices'  => array(
	    'alpha' => true,
	),
	'default'  => '', 
	'active_callback' => array(
		array(
			'setting'  => 'footer_overlay',  	
			'operator' => '==',
			'value'    => true,
		),
	),
	'output'   => array(
		array(
			'element'  => '.overlay-footer',
			'property' => 'background-color',
		),
	),
) );


// single page section //

Modulus_Kirki::add_section( 'single_page', array(
	'title'          => __( 'Single Page','modulus' ),
	'description'    => __( 'Single Page Related Options', 'modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_page_featured_image',
	'label'    => __( 'Enable Single Page Featured Image', 'modulus' ),
	'section'  => 'single_page',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'single_page_featured_image_size',
	'label'    => __( 'Single Page Featured Image Size', 'modulus' ),
	'section'  => 'single_page',
	'type'     => 'radio-buttonset',
	'choices' => array(
		1  => esc_attr__( 'Normal', 'modulus' ),
		2 => esc_attr__( 'FullWidth', 'modulus' ) 
	),
	'default'  => 1,
	'active_callback' => array(
		array(
			'setting'  => 'single_page_featured_image',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );

// Layout section //

Modulus_Kirki::add_section( 'layout', array(
	'title'          => __( 'Layout','modulus' ),
	'description'    => __( 'Layout Related Options', 'modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'site-style',
	'label'    => __( 'Site Style', 'modulus' ),
	'section'  => 'layout',
	'type'     => 'radio-buttonset',
	'choices' => array(
		'wide' =>  esc_attr__('Wide', 'modulus'),
        'boxed' =>  esc_attr__('Boxed', 'modulus'),
        'fluid' =>  esc_attr__('Fluid', 'modulus'),  
        //'static' =>  esc_attr__('Static ( Non Responsive )', 'modulus'),
    ),
	'default'  => 'wide',
	'tooltip' => __('Select the default site layout. Defaults to "Wide".','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'sidebar_position',
	'label'    => __( 'Main Layout', 'modulus' ),
	'section'  => 'layout',
	'type'     => 'radio-image',   
	'description' => __('Select main content and sidebar arranmodulusent.','modulus'),
	'choices' => array(
		'left' =>  get_template_directory_uri() . '/admin/kirki/assets/images/2cl.png',
        'right' =>  get_template_directory_uri() . '/admin/kirki/assets/images/2cr.png',
        'two-sidebar' =>  get_template_directory_uri() . '/admin/kirki/assets/images/3cm.png',  
        'two-sidebar-left' =>  get_template_directory_uri() . '/admin/kirki/assets/images/3cl.png',
        'two-sidebar-right' =>  get_template_directory_uri() . '/admin/kirki/assets/images/3cr.png',
        'fullwidth' =>  get_template_directory_uri() . '/admin/kirki/assets/images/1c.png',
        'no-sidebar' =>  get_template_directory_uri() . '/images/no-sidebar.png',
    ),
	'default'  => 'right',
	'tooltip' => __('This layout will be reflected in all pages unless unique layout template is set for specific page','modulus'),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'body_top_margin',
	'label'    => __( 'Body Top Margin', 'modulus' ),
	'description' => __('Select the top margin of body element in pixels','modulus'),
	'section'  => 'layout',
	'type'     => 'number',
	'choices' => array(
		'min' => 0,
		'max' => 200,
		'step' => 1,
	),
	'active_callback'    => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'margin-top',
			'units'    => 'px',
		),
	),
	'default'  => 0,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'body_bottom_margin',
	'label'    => __( 'Body Bottom Margin', 'modulus' ),
	'description' => __('Select the bottom margin of body element in pixels','modulus'),
	'section'  => 'layout',
	'type'     => 'number',
	'choices' => array(
		'min' => 0,
		'max' => 200,
		'step' => 1,
	),
	'active_callback'    => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'margin-bottom',
			'units'    => 'px',
		),
	),
	'default'  => 0,
) );

/* LAYOUT SECTION  */
/*
Modulus_Kirki::add_section( 'layout', array(
	'title'          => __( 'Layout','modulus' ),   
	'description'    => __( 'Layout settings that affects overall site', 'modulus'),
	'panel'          => 'modulus_options', // Not typically needed.
) );



Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'primary_sidebar_width',
	'label'    => __( 'Primary Sidebar Width', 'modulus' ),
	'section'  => 'layout',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'1' => __( 'One Column', 'modulus' ),
		'2' => __( 'Two Column', 'modulus' ),
		'3' => __( 'Three Column', 'modulus' ),
		'4' => __( 'Four Column', 'modulus' ),
		'5' => __( 'Five Column ', 'modulus' ),
	),
	'default'  => '5',  
	'tooltip' => __('Select the width of the Primary Sidebar. Please note that the values represent grid columns. The total width of the page is 16 columns, so selecting 5 here will make the primary sidebar to have a width of approximately 1/3 ( 4/16 ) of the total page width.','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'secondary_sidebar_width',
	'label'    => __( 'Secondary Sidebar Width', 'modulus' ),
	'section'  => 'layout',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'1' => __( 'One Column', 'modulus' ),
		'2' => __( 'Two Column', 'modulus' ),
		'3' => __( 'Three Column', 'modulus' ),
		'4' => __( 'Four Column', 'modulus' ),
		'5' => __( 'Five Column ', 'modulus' ),
	),            
	'default'  => '5',  
	'tooltip' => __('Select the width of the Secondary Sidebar. Please note that the values represent grid columns. The total width of the page is 16 columns, so selecting 5 here will make the primary sidebar to have a width of approximately 1/3 ( 4/16 ) of the total page width.','modulus'),
) ); 

*/
 //  social network panel //

modulus_Kirki::add_panel( 'social_panel', array(
	'title'        =>__( 'Social Networks', 'modulus'),
	'description'  =>__( 'social networks', 'modulus'),
	'priority'  =>11,	
));

//social sharing box section

modulus_Kirki::add_section( 'social_sharing_box', array(
	'title'          =>__( 'Social Sharing Box', 'modulus'),
	'description'   =>__('Social Sharing box related options', 'modulus'),
	'panel'			 =>'social_panel',
));

modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'facebook_sb',
	'label'    => __( 'Enable facebook sharing option below single post', 'modulus' ),
	'section'  => 'social_sharing_box',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'twitter_sb',
	'label'    => __( 'Enable twitter sharing option below single post', 'modulus' ),
	'section'  => 'social_sharing_box',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'linkedin_sb',
	'label'    => __( 'Enable linkedin sharing option below single post', 'modulus' ),
	'section'  => 'social_sharing_box',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'google-plus_sb',
	'label'    => __( 'Enable googleplus sharing option below single post', 'modulus' ),
	'section'  => 'social_sharing_box',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );

modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'email_sb',
	'label'    => __( 'Enable email sharing option below single post', 'modulus' ),
	'section'  => 'social_sharing_box',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );


/* FOOTER SECTION 
footer panel */

Modulus_Kirki::add_panel( 'footer_panel', array(     
	'title'       => __( 'Footer', 'modulus' ),
	'description' => __( 'Footer Related Options', 'modulus' ),     
) );  

Modulus_Kirki::add_section( 'footer', array(
	'title'          => __( 'Footer','modulus' ),
	'description'    => __( 'Footer related options', 'modulus'),
	'panel'          => 'footer_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_widgets',
	'label'    => __( 'Footer Widget Area', 'modulus' ),
	'description' => sprintf(__('Select widgets, Goto <a href="%1$s"target="_blank"> Customizer </a> => Widgets','modulus'),admin_url('customize.php') ),
	'section'  => 'footer',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'on',
) );
/* Choose No.Of Footer area */
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_widgets_count',
	'label'    => __( 'Choose No.of widget area you want in footer', 'modulus' ),
	'section'  => 'footer',
	'type'     => 'radio-buttonset',
	'choices' => array(
		1  => esc_attr__( '1', 'modulus' ),
		2  => esc_attr__( '2', 'modulus' ),
		3  => esc_attr__( '3', 'modulus' ),
		4  => esc_attr__( '4', 'modulus' ),
	),
	'default'  => 4,
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'copyright',
	'label'    => __( 'Footer Copyright Text', 'modulus' ),
	'section'  => 'footer',
	'type'     => 'textarea',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_top_margin',
	'label'    => __( 'Footer Top Margin', 'modulus' ),
	'description' => __('Select the top margin of footer in pixels','modulus'),
	'section'  => 'footer',
	'type'     => 'number',
	'choices' => array(
		'min' => 1,
		'max' => 1000,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.site-footer',
			'property' => 'margin-top',
			'units' => 'px',
		),
	),
	'default'  => 0,
) );

/* CUSTOM FOOTER BACKGROUND IMAGE 
footer background image section  */

Modulus_Kirki::add_section( 'footer_image', array(
	'title'          => __( 'Footer Image','modulus' ),
	'description'    => __( 'Custom Footer Image options', 'modulus'),
	'panel'          => 'footer_panel', // Not typically needed.
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_image',
	'label'    => __( 'Upload Footer Background Image', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'upload',
	'default'  => '',
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-image',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_size',
	'label'    => __( 'Footer Background Size', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'radio-buttonset',
    'choices' => array(
		'cover'  => esc_attr__( 'Cover', 'modulus' ),
		'contain' => esc_attr__( 'Contain', 'modulus' ),
		'auto'  => esc_attr__( 'Auto', 'modulus' ),
		'inherit'  => esc_attr__( 'Inherit', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-size',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'cover',
	'tooltip' => __('Footer Background Image Size','modulus'),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_repeat',
	'label'    => __( 'Footer Background Repeat', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'no-repeat' => esc_attr__('No Repeat', 'modulus'),
        'repeat' => esc_attr__('Repeat', 'modulus'),
        'repeat-x' => esc_attr__('Repeat Horizontally','modulus'),
        'repeat-y' => esc_attr__('Repeat Vertically','modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-repeat',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'repeat',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_position',
	'label'    => __( 'Footer Background Position', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'center top' => esc_attr__('Center Top', 'modulus'),
        'center center' => esc_attr__('Center Center', 'modulus'),
        'center bottom' => esc_attr__('Center Bottom', 'modulus'),
        'left top' => esc_attr__('Left Top', 'modulus'),
        'left center' => esc_attr__('Left Center', 'modulus'),
        'left bottom' => esc_attr__('Left Bottom', 'modulus'),
        'right top' => esc_attr__('Right Top', 'modulus'),
        'right center' => esc_attr__('Right Center', 'modulus'),
        'right bottom' => esc_attr__('Right Bottom', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-position',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'center center',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_bg_attachment',
	'label'    => __( 'Footer Background Attachment', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'scroll' => esc_attr__('Scroll', 'modulus'),
        'fixed' => esc_attr__('Fixed', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.footer-image',
			'property' => 'background-attachment',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'footer_bg_image',
			'operator' => '=',
			'value'    => true,
		),
	),
	'default'  => 'scroll',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_overlay',
	'label'    => __( 'Enable Footer( Background ) Overlay', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' )
	),
	'default'  => 'off',
) );
  
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'footer_overlay_color',
	'label'    => __( 'Footer Overlay ( Background )color', 'modulus' ),
	'section'  => 'footer_image',
	'type'     => 'color',
	'choices'  => array(
	    'alpha' => true,
	),
	'default'  => '#E5493A', 
	'active_callback' => array(
		array(
			'setting'  => 'footer_overlay',
			'operator' => '==',
			'value'    => true,
		),
	),
	'output'   => array(
		array(
			'element'  => '.overlay-footer',
			'property' => 'background-color',
		),
	),
) );

//  slider panel //

Modulus_Kirki::add_panel( 'slider_panel', array(   
	'title'       => __( 'Slider Settings', 'modulus' ),  
	'description' => __( 'Flex slider related options', 'modulus' ), 
	'priority'    => 11,    
) );

//  flexslider section  //

Modulus_Kirki::add_section( 'flex_caption_section', array(
	'title'          => __( 'Flexcaption Settings','modulus' ),
	'description'    => __( 'Flexcaption Related Options', 'modulus'),
	'panel'          => 'slider_panel', // Not typically needed.
) );
Modulus_Kirki::add_field( 'modulus', array( 
	'settings' => 'enable_flex_caption_edit',
	'label'    => __( 'Enable Custom Flexcaption Settings', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'switch',
	'choices' => array(
		'on'  => esc_attr__( 'Enable', 'modulus' ),
		'off' => esc_attr__( 'Disable', 'modulus' ) 
	),
	'default'  => 'off',
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_bg',
	'label'    => __( 'Select Flexcaption Background Color', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'color',
	'default'  => 'rgba(51,54,58,0.5)',
	'choices'  => array(
	    'alpha' => true,
	),
	'output'   => array(
		array(
			'element'  => '.flex-caption',
			'property' => 'background-color',
			'suffix' => '!important',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_align',
	'label'    => __( 'Select Flexcaption Alignment', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'select',
	'default'  => 'center',
	'choices' => array(
		'left' => esc_attr__( 'Left', 'modulus' ),
		'right' => esc_attr__( 'Right', 'modulus' ),
		'center' => esc_attr__( 'Center', 'modulus' ),
		'justify' => esc_attr__( 'Justify', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => '.home .flexslider .slides .flex-caption p,.home .flexslider .slides .flex-caption h1, .home .flexslider .slides .flex-caption h2, .home .flexslider .slides .flex-caption h3, .home .flexslider .slides .flex-caption h4, .home .flexslider .slides .flex-caption h5, .home .flexslider .slides .flex-caption h6,.flexslider .slides .flex-caption,.flexslider .slides .flex-caption h1, .flexslider .slides .flex-caption h2, .flexslider .slides .flex-caption h3, .flexslider .slides .flex-caption h4, .flexslider .slides .flex-caption h5, .flexslider .slides .flex-caption h6,.flexslider .slides .flex-caption p,.flexslider .slides .flex-caption',
			'property' => 'text-align',
			//'suffix' => '!important',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );
 Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_bg_position',
	'label'    => __( 'Select Flexcaption Background Horizontal Position', 'modulus' ),
	'tooltip' => __('Select how far from left, Default value Left = 10 ( in % )','modulus'),
	'section'  => 'flex_caption_section',
	'type'     => 'number',
	'default'  => '10',
	'choices'     => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.flexslider .slides .flex-caption,.home .flexslider .slides .flex-caption',
			'property' => 'left',
			'suffix' => '%',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) ); 
 Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_bg_vertical_position',
	'label'    => __( 'Select Flexcaption Background Vertical Position', 'modulus' ),
	'tooltip' => __('Select how far from bottom, Default value Bottom = 8 ( in % )','modulus'),
	'section'  => 'flex_caption_section',
	'type'     => 'number',
	'default'  => '8',
	'choices'     => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.flexslider .slides .flex-caption,.home .flexslider .slides .flex-caption',
			'property' => 'bottom',
			'suffix' => '%',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) ); 
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_bg_width',
	'label'    => __( 'Select Flexcaption Background Width', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'number',
	'default'  => '80',
	'tooltip' => __('Select Flexcaption Background Width , Default width value 80','modulus'),
	'choices'     => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.flexslider .slides .flex-caption,.home .flexslider .slides .flex-caption',
			'property' => 'width',
			'suffix' => '%',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) ); 
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_responsive_bg_width',
	'label'    => __( 'Select Responsive Flexcaption Background Width', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'number',
	'default'  => '100',
	'tooltip' => __('Select Responsive Flexcaption Background Width, Default width value 100 ( This value will apply for max-width: 768px )','modulus'),
	'choices'     => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1, 
	),
	'output'   => array(
		array(
			'element'  => '.flexslider .slides .flex-caption,.home .flexslider .slides .flex-caption',
			'property' => 'width',
			'media_query' => '@media (max-width: 768px)',
			'value_pattern' => 'calc($%)',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'flexcaption_color',
	'label'    => __( 'Select Flexcaption Font Color', 'modulus' ),
	'section'  => 'flex_caption_section',
	'type'     => 'color',
	'default'  => '#fff',
	'choices'  => array(
	    'alpha' => true,
	),
	'output'   => array(
		array(
			'element'  => '.flex-caption,.home .flexslider .slides .flex-caption p,.home .flexslider .slides .flex-caption p a,.flexslider .slides .flex-caption p,.home .flexslider .slides .flex-caption h1, .home .flexslider .slides .flex-caption h2, .home .flexslider .slides .flex-caption h3, .home .flexslider .slides .flex-caption h4, .home .flexslider .slides .flex-caption h5, .home .flexslider .slides .flex-caption h6,.flexslider .slides .flex-caption h1,.flexslider .slides .flex-caption h2,.flexslider .slides .flex-caption h3,.flexslider .slides .flex-caption h4,.flexslider .slides .flex-caption h5,.flexslider .slides .flex-caption h6',
			'property' => 'color',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'enable_flex_caption_edit',
			'operator' => '==',
			'value'    => true,
		),
    ),
) );

 if( class_exists( 'WooCommerce' ) ) {
	Modulus_Kirki::add_section( 'woocommerce_section', array(
		'title'          => __( 'WooCommerce','modulus' ),
		'description'    => __( 'Theme options related to woocommerce', 'modulus'),
		'priority'       => 11, 

		'theme_supports' => '', // Rarely needed.
	) );
	Modulus_Kirki::add_field( 'woocommerce', array(
		'settings' => 'woocommerce_sidebar',
		'label'    => __( 'Enable Woocommerce Sidebar', 'modulus' ),
		'description' => __('Enable Sidebar for shop page','modulus'),
		'section'  => 'woocommerce_section',
		'type'     => 'switch',
		'choices' => array(
			'on'  => esc_attr__( 'Enable', 'modulus' ),
			'off' => esc_attr__( 'Disable', 'modulus' ) 
		),

		'default'  => 'on',
	) );
}
	
// background color ( rename )

Modulus_Kirki::add_section( 'colors', array(
	'title'          => __( 'Background Color','modulus' ),
	'description'    => __( 'This will affect overall site background color', 'modulus'),
	//'panel'          => 'skin_color_panel', // Not typically needed.
	'priority' => 11,
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_color',
	'label'    => __( 'General Background Color', 'modulus' ),
	'section'  => 'colors',
	'type'     => 'color',
	'choices'  => array(
	    'alpha' => true,
	),
	'default'  => '#ffffff',
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-color',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'content_background_color',
	'label'    => __( 'Content Background Color', 'modulus' ),
	'section'  => 'colors',
	'type'     => 'color',
	'description' => __('when you are select boxed layout content background color will reflect the grid area','modulus'), 
	'choices'  => array(
	    'alpha' => true,
	), 
	'default'  => '#ffffff',
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-color',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
	),
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_image',
	'label'    => __( 'General Background Image', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'upload',
	'default'  => '',
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-image',
		),
	),
) );

// background image ( general & boxed layout ) //


Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_repeat',
	'label'    => __( 'General Background Repeat', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'no-repeat' => esc_attr__('No Repeat', 'modulus'),
        'repeat' => esc_attr__('Repeat', 'modulus'),
        'repeat-x' => esc_attr__('Repeat Horizontally','modulus'),
        'repeat-y' => esc_attr__('Repeat Vertically','modulus'),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-repeat',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'general_background_image',
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'repeat',  
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_size',
	'label'    => __( 'General Background Size', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
    'choices' => array(
		'cover'  => esc_attr__( 'Cover', 'modulus' ),
		'contain' => esc_attr__( 'Contain', 'modulus' ),
		'auto'  => esc_attr__( 'Auto', 'modulus' ),
		'inherit'  => esc_attr__( 'Inherit', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-size',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'general_background_image',
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'cover',  
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_attachment',
	'label'    => __( 'General Background Attachment', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'scroll' => esc_attr__('Scroll', 'modulus'),
        'fixed' => esc_attr__('Fixed', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-attachment',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'general_background_image',
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'fixed',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'general_background_position',
	'label'    => __( 'General Background Position', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'center top' => esc_attr__('Center Top', 'modulus'),
        'center center' => esc_attr__('Center Center', 'modulus'),
        'center bottom' => esc_attr__('Center Bottom', 'modulus'),
        'left top' => esc_attr__('Left Top', 'modulus'),
        'left center' => esc_attr__('Left Center', 'modulus'),
        'left bottom' => esc_attr__('Left Bottom', 'modulus'),
        'right top' => esc_attr__('Right Top', 'modulus'),
        'right center' => esc_attr__('Right Center', 'modulus'),
        'right bottom' => esc_attr__('Right Bottom', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => 'body',
			'property' => 'background-position',
		),
	),
	'active_callback'    => array(
		array(
			'setting'  => 'general_background_image', 
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'center top',  
) );


/* CONTENT BACKGROUND ( boxed background image )*/

Modulus_Kirki::add_field( 'modulus', array(  
	'settings' => 'content_background_image',
	'label'    => __( 'Content Background Image', 'modulus' ),
	'description' => __('when you are select boxed layout content background image will reflect the grid area','modulus'),
	'section'  => 'background_image',
	'type'     => 'upload',
	'default'  => '',
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-image',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
	),
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'content_background_repeat',
	'label'    => __( 'Content Background Repeat', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'no-repeat' => esc_attr__('No Repeat', 'modulus'),
        'repeat' => esc_attr__('Repeat', 'modulus'),
        'repeat-x' => esc_attr__('Repeat Horizontally','modulus'),
        'repeat-y' => esc_attr__('Repeat Vertically','modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-repeat',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
		array(
			'setting'  => 'content_background_image', 
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'repeat',  
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'content_background_size',
	'label'    => __( 'Content Background Size', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
    'choices' => array(
		'cover'  => esc_attr__( 'Cover', 'modulus' ),
		'contain' => esc_attr__( 'Contain', 'modulus' ),
		'auto'  => esc_attr__( 'Auto', 'modulus' ),
		'inherit'  => esc_attr__( 'Inherit', 'modulus' ),
	),
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-size',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
		array(
			'setting'  => 'content_background_image', 
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'cover',  
) );

Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'content_background_attachment',
	'label'    => __( 'Content Background Attachment', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'scroll' => esc_attr__('Scroll', 'modulus'),
        'fixed' => esc_attr__('Fixed', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-attachment',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
		array(
			'setting'  => 'content_background_image', 
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'fixed',  
) );
Modulus_Kirki::add_field( 'modulus', array(
	'settings' => 'content_background_position',
	'label'    => __( 'Content Background Position', 'modulus' ),
	'section'  => 'background_image',
	'type'     => 'select',
	'multiple'    => 1,
	'choices'     => array(
		'center top' => esc_attr__('Center Top', 'modulus'),
        'center center' => esc_attr__('Center Center', 'modulus'),
        'center bottom' => esc_attr__('Center Bottom', 'modulus'),
        'left top' => esc_attr__('Left Top', 'modulus'),
        'left center' => esc_attr__('Left Center', 'modulus'),
        'left bottom' => esc_attr__('Left Bottom', 'modulus'),
        'right top' => esc_attr__('Right Top', 'modulus'),
        'right center' => esc_attr__('Right Center', 'modulus'),
        'right bottom' => esc_attr__('Right Bottom', 'modulus'),
	),
	'output'   => array(
		array(
			'element'  => '.boxed-container',
			'property' => 'background-position',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'site-style',
			'operator' => '==',
			'value'    => 'boxed',
		),
		array(
			'setting'  => 'content_background_image', 
			'operator' => '==',
			'value'    => true,
		),
	),
	'default'  => 'center top',  
) );

do_action('wbls-modulus_pro_customizer_options');
do_action('modulus_child_customizer_options');
