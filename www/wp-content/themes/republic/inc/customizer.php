<?php
/**
 * republic Theme Customizer
 *
 * @package republic
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function republic_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline'  )->title		= __('Site Titles & Tagline','republic');
	$wp_customize->get_section( 'title_tagline'  )->panel		= 'panel_general';
	$wp_customize->get_section( 'title_tagline'  )->priority	= 10;	
	$wp_customize->get_section( 'header_image'  )->panel	= 'panel_general';
	$wp_customize->get_section( 'colors'  )->panel	= 'republic_theme_colorcustomize';
	$wp_customize->get_section( 'colors'  )->title	= __( 'Logo Text Color','republic' );
    $wp_customize->get_section('background_image')->panel = 'panel_general';


	// Theme important links started
   class republic_Important_Links extends WP_Customize_Control {

      public $type = "republic-important-links";

      public function render_content() {
         //Add Theme instruction
		 $republic_features = array(
		 'Features' => array(
               'text' => __('Features 1', 'republic'),
               'text' => __('Features 2', 'republic'),
               'text' => __('Features 3', 'republic'),
               'text' => __('Features 4', 'republic'),
            ), 
		 
		 );
		 echo '<ul><b>
			<li>' . esc_attr__( '* Fully Mobile Responsive', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Dedicated Option Panel', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Customize Theme Color', 'republic' ) . '</li>
			<li>' . esc_attr__( '* WooCommerce & bbPress Support', 'republic' ) . '</li>
			<li>' . esc_attr__( '* SEO Optimized', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Control Individual Meta Option like: Category, date, Author, Tags etc. ', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Full Support', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Google Fonts', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Theme Color Customization', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Custom CSS', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Website Layout', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Select Number of Columns', 'republic' ) . '</li>
			<li>' . esc_attr__( '* Website Width Control', 'republic' ) . '</li>
			</b></ul>
		 ';
         $important_links = array(
		 
            'theme-info' => array(
               'link' => esc_url('https://www.insertcart.com/product/republic-wordpress-theme/'),
               'text' => __('Republic Pro', 'republic'),
            ),
            'support' => array(
               'link' => esc_url('https://www.insertcart.com/contact-us/'),
               'text' => __('Contact us', 'republic'),
            ),         
			'Documentation' => array(
               'link' => esc_url('https://www.insertcart.com/republic-wordpress-theme-setup-and-documentation/'),
               'text' => __('Documentation', 'republic'),
            ),			 
         );
         foreach ($important_links as $important_link) {
            echo '<p><a target="_blank" href="' . esc_url($important_link['link']) . '" >' . esc_attr($important_link['text']) . ' </a></p>';
         }
               }

   }
      $wp_customize->add_section('republic_important_links', array(
      'priority' => 1,
      'title' => __('Upgrade to Pro', 'republic'),
   ));

   $wp_customize->add_setting('republic_important_links', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'republic_links_sanitize'
   ));

   $wp_customize->add_control(new republic_Important_Links($wp_customize, 'important_links', array(
      'section' => 'republic_important_links',
      'settings' => 'republic_important_links'
   )));
/**********************************************
* General Settings
**********************************************/	
	if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'panel_general', array(
			'priority' => 30,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'General Settings', 'republic' )
		) );
	
	// /* Background	*/		
		// $wp_customize->add_section( 'republic_general_background' , array(
				// 'title'       => __( 'Background Settings', 'republic' ),
				// 'priority'    => 30,
				// 'panel' => 'panel_general'
		// ));
                  // //Background Color
        // $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
				// 'label'    => __( 'Background Color', 'republic' ),
				// 'section'  => 'republic_general_background',
				// 'settings' => 'background_color',
				// 'priority'    => 1,
		// )));
                  // //Background image
        // $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background_image', array(
				// 'label'    => __( 'Background Image', 'republic' ),
				// 'section'  => 'republic_general_background',
				// 'settings' => 'background_image',
				// 'priority'    => 1,
		// )));
	
                
                $wp_customize->add_section('custom_section_css',
		array(
			'title'			=> __( 'Custom CSS', 'republic' ),			
			'panel'			=> 'panel_general',
                        'priority'    => 32
		)
	);
                $wp_customize->add_setting('custom_css',
		array(
			'default'			=> '',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		)
	);
                $wp_customize->add_control('custom_css',
		array(

			'settings'		=> 'custom_css',
			'section'		=> 'custom_section_css',
			'type'			=> 'textarea',
			'label'			=> __( 'Custom CSS', 'republic' ),
			'description'	=> __( 'Define custom CSS be used for your site. Do not enclose in script tags.', 'republic' ),
		)
	);
                
endif;
 
/***********************************************
* Woocommerce Store
***********************************************/
	if (class_exists('woocommerce')) { 
		$wp_customize->add_panel( 'republic_panel_woocommerce', array(
			'priority' => 32,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Woocommerce', 'republic' )
		) );
                	
					
	$wp_customize->add_section( 'republic_woo_settings' , 
                            array(
				'title'       => __( 'Woo settings & Options', 'republic' ),
				'priority'    => 30,				
				'panel' => 'republic_theme_colorcustomize'
		));
         //Show or Hide woo product
                 $wp_customize->add_setting('woocommerce_share_buttons',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'woocommerce_share_buttons',
                         array (
                             
                             'settings'		=> 'woocommerce_share_buttons',
                             'section'		=> 'republic_woo_settings',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Share from single product', 'republic' )
			
                             
                         )  )); 
			
	

        }
        
        else {
            
	$wp_customize->add_panel( 'republic_panel_woocommerce', array(
		'priority' => 32,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'WooCommerce', 'republic' )
	) );
	/* Notice WooCommerce Not Installed */		
	$wp_customize->add_section( 'republic_woocommercenot' , array(
		'title'       => __( 'WooCommerce Not Installed', 'republic' ),
		'description' => __('Please install WooCommerce plugin to show these options','republic'),
		'priority'    => 30,                                
		'panel' => 'republic_panel_woocommerce'
	));

	$wp_customize->add_setting("woonotinstall", 
		 array(
			 'default' => __('WooCommerce not installed','republic'), 
			 'sanitize_callback' => 'esc_textarea',
			 "transport" => "postMessage",
			 ));
	$wp_customize->add_control(new WP_Customize_Control( $wp_customize, "woonotinstall",
		array(
		'section'  => 'republic_woocommercenot',
		"settings" => "woonotinstall",            
		'priority'    => 1,
	)	));
                 
                 
        }

/***********************************************
* Social Profiles
***********************************************/
            if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'republic_panel_social', array(
			'priority' => 33,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Social Media', 'republic' )
		) );
		
		$wp_customize->add_section( 'republic_socialshare' , array(
				'title'       => __( 'Social Share in Post', 'republic' ),

				'panel' => 'republic_panel_social'
		));
		
		//Show or Hide woo product
                 $wp_customize->add_setting('republic_sharelink',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_sharelink',
                         array (
                             
                             'settings'		=> 'republic_sharelink',
                             'section'		=> 'republic_socialshare',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Social Post Share buttons', 'republic' )
			
                             
                         )  )); 
		
		
		$wp_customize->add_section( 'republic_social_links' , array(
				'title'       => __( 'Social Profile Links Footer', 'republic' ),
				'priority'    => 30	,
				'panel' => 'republic_panel_social'
		));
            
			
			//Show or Hide woo product
                 $wp_customize->add_setting('republic_hidefotshare',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',			
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_hidefotshare',
                         array (
                             
                             'settings'		=> 'republic_hidefotshare',
                             'section'		=> 'republic_social_links',
                             'type'		=> 'checkbox',
							 'priority'    => 1,							 
                             'label'		=> __( 'Hide Social Post Share buttons', 'republic' )
			
                             
                         )  )); 
			
                /* Facebook */	
		 $wp_customize->add_setting("republic_facebook", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_facebook",
                          array(              
                              "label" => __("Facebook Link", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_facebook',
                                'type' => 'url',
                                'priority'    => 2,
                             )	));
	/* Twitter */		
		
		 $wp_customize->add_setting("republic_twitter", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_twitter",
                          array(              
                              "label" => __("Twitter Link", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_twitter',
                                'type' => 'url',
                                'priority'    => 3,
                             )	));
	/* Google Plus */		
		
		 $wp_customize->add_setting("republic_googleplus", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_googleplus",
                          array(              
                              "label" => __("Google Plus Link", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_googleplus',
                                'type' => 'url',
                                'priority'    => 4,
                             )	));
	/* Linkedin */		
		
		 $wp_customize->add_setting("republic_linkedin", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_linkedin",
                          array(              
                              "label" => __("LinkedIn", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_linkedin',
                                'type' => 'url',
                                'priority'    => 5,
                              
                             )	));

	/* dribbble */		
		
		 $wp_customize->add_setting("republic_dribbble", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_dribbble",
                          array(              
                              "label" => __("Dribbble", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_dribbble',
                                'type' => 'url',
                                'priority'    => 6,
                             )	));
		/* vimeo */		
		
		 $wp_customize->add_setting("republic_vimeo", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_vimeo",
                          array(              
                              "label" => __("Vimeo", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_vimeo',
                                'type' => 'url',
                                'priority'    => 7,
                             )	));	
                 /* rss */		
		
		 $wp_customize->add_setting("republic_rss", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_rss",
                          array(              
                              "label" => __('RSS Feed', 'republic'),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_rss',
                                'type' => 'url',
                                'priority'    => 8,
                             )	));
                 
                /* instagram */		
		
		 $wp_customize->add_setting("republic_instagram", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_instagram",
                          array(              
                              "label" => __("Instagram", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_instagram',
                                'type' => 'url',
                                'priority'    => 9,
                             )	)); 
                 
                /* pinterest */		
		
		 $wp_customize->add_setting("republic_pinterest", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_pinterest",
                          array(              
                              "label" => __("Pinterest", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_pinterest',
                                'type' => 'url',
                                'priority'    => 10,
                             )	)); 
                 
                  /* youtube */		
		
		 $wp_customize->add_setting("republic_youtube", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_youtube",
                          array(              
                              "label" => __("Youtube", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_youtube',
                                'type' => 'url',
                                'priority'    => 11,
                             )	)); 
                 
                  /* skype */		
		
		 $wp_customize->add_setting("republic_skype", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_skype",
                          array(              
                              "label" => __("Skype", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_skype',
                                'type' => 'url',
                                'priority'    => 12,
                             )	)); 
                 
                  /* flickr */		
		
		 $wp_customize->add_setting("republic_flickr", 
                         array(
                             'default' =>'',
                             'sanitize_callback' => 'esc_url_raw',
                             'capability' => 'edit_theme_options',
                             'type' => 'theme_mod',
                             'transport' => 'postMessage'
                             
                             ));
		 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "republic_flickr",
                          array(              
                              "label" => __("Flickr", "republic"),
                                'section'  => 'republic_social_links',
                                'settings' => 'republic_flickr',
                                'type' => 'url',
                                'priority'    => 13,
                             )	)); 
                 
                 endif;
  
/***********************************************
* Sidebar Widget
***********************************************/
		$wp_customize->add_panel( 'republic_theme_widgets', array(
			'priority' => 34,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Popular\Recent Post in sidebar', 'republic' )
		) );
//Show or Hide Widget
                 $wp_customize->add_setting('hide_sidebar_widget',
		// $args
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'hide_sidebar_widget',
                         array (
                             
                             'settings'		=> 'hide_sidebar_widget',
                             'section'		=> 'republic_theme_widget1',
                             'type'			=> 'checkbox',                             
			'label'			=> __( 'Hide these Posts', 'republic' )
			
                             
                         )  ));
	/* Popular\Latest Post Widget */		
		$wp_customize->add_section( 'republic_theme_widget1' , array(
				'title'       => __( 'Popular/Latest Posts', 'republic' ),
				'priority'    => 30,                              
				'panel' => 'republic_theme_colorcustomize'
		));

		
       $wp_customize->add_setting('republic_widget_range',
		array(
			'default'			=> '5',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_select'
		));
                 
                 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'republic_widget_range',
		array(
			'settings'		=> 'republic_widget_range',
			'section'		=> 'republic_theme_widget1',
			'type'			=> 'select',
			'label'			=> __( 'Choose Numbers post to display', 'republic' ),
			'choices'		=> array(
				'1' => __( '1', 'republic' ),
				'2' => __( '2', 'republic' ),
				'3' => __( '3', 'republic' ),
				'4' => __( '4', 'republic' ),
				'5' => __( '5', 'republic' ),			
				'6' => __( '6', 'republic' ),			
				'7' => __( '7', 'republic' ),			
				'8' => __( '8', 'republic' ),			
				'9' => __( '9', 'republic' ),			
				'10' => __( '10', 'republic' )			
			)
		)));
                 
                 //Popular widget name
                 $wp_customize->add_setting('popular_widget_name',
		array(
			'default'		=> __('Popular Posts','republic'),
			'type'			=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
                       'sanitize_callback'	=> 'sanitize_text_field'
		));
                 
                 
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'popular_widget_name',
                         array (
                             
                             'settings'		=> 'popular_widget_name',
                             'section'		=> 'republic_theme_widget1',
                             'type'			=> 'text',
			'label'			=> __( 'Popular Post name', 'republic' )
			
                             
                         )  ));
                         
                 //Recent widget name
                 $wp_customize->add_setting('recent_widget_name',
		array(
			'default'		=> __('Recent Posts','republic'),
			'type'			=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
                       'sanitize_callback'	=> 'republic_sanitize_nohtml'
		));
                 
                 
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'recent_widget_name',
                         array (
                             
                             'settings'		=> 'recent_widget_name',
                             'section'		=> 'republic_theme_widget1',
                             'type'			=> 'text',
			'label'			=> __( 'Recent Post name', 'republic' )
			
                             
                         )  ));
                     
   
                        
/***********************************************
* Theme Color Customize
***********************************************/
if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'republic_theme_colorcustomize', array(
			'priority' => 35,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Theme Settings & Color', 'republic' )
		) );

      
  
/*************Theme Options****************/       
   $wp_customize->add_section( 'republic_themeoption' , array(
				'title'       => __( 'Theme Features', 'republic' ),
				'priority'    => 35,
				'panel' => 'republic_theme_colorcustomize'
		));              
    //Hide new ticker
              $wp_customize->add_setting('republic_backtotop',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_backtotop',
                         array (
                             
                             'settings'		=> 'republic_backtotop',
                             'section'		=> 'republic_themeoption',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Back to Top Icon', 'republic' )
			
                             
                         )  )); 

 //Post Date
              $wp_customize->add_setting('republic_posted_date',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_posted_date',
                         array (
                             
                             'settings'		=> 'republic_posted_date',
                             'section'		=> 'republic_themeoption',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Check to Hide Post meta date ', 'republic' )
			
                             
                         )  ));   						 

						  //Hide random post
              $wp_customize->add_setting('republic_randompost',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_randompost',
                         array (
                             
                             'settings'		=> 'republic_randompost',
                             'section'		=> 'republic_themeoption',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Check to Hide random post ', 'republic' )
			
                             
                         )  ));
  //Hide comment number
              $wp_customize->add_setting('comment_number',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'comment_number',
                         array (
                             
                             'settings'		=> 'comment_number',
                             'section'		=> 'republic_themeoption',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Check to Hide Comment Number ', 'republic' )
			
                             
                         )  )); 						 
/*************ticker****************/       
   $wp_customize->add_section( 'republic_ticker' , array(
				'title'       => __( 'News Ticker', 'republic' ),
				'priority'    => 31,
				'panel' => 'republic_theme_colorcustomize'
		));              
    //Hide new ticker
              $wp_customize->add_setting('hide_news_ticker',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'hide_news_ticker',
                         array (
                             
                             'settings'		=> 'hide_news_ticker',
                             'section'		=> 'republic_ticker',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide News Ticker', 'republic' )
			
                             
                         )  ));    
						 
	//Choose Category One
 $wp_customize->add_setting('tickercategory', array(
        'default'        => '1',
          'sanitize_callback'	=> 'republic_sanitize_html'         
		));
$wp_customize->add_control(
    new WP_Customize_Category_Control(   $wp_customize,
        'tickercategory',
        array(
			'label'    => __('News Ticker Category (Only display category which has at least one post.','republic' ),
			'settings' => 'tickercategory',
			'section'		=> 'republic_ticker'
        )
    )
);

                  //Ticker name
                 $wp_customize->add_setting('ticker_name',
		array(
			'default'		=> __('News','republic'),
			'type'			=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
                       'sanitize_callback'	=> 'sanitize_text_field'
		));
                 
                 
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'ticker_name',
                         array (
                             
                             'settings'		=> 'ticker_name',
                             'section'		=> 'republic_ticker',
                             'type'			=> 'text',
			'label'			=> __( 'Put Name for news ticker box', 'republic' )
			
                             
                         )  ));
  
                 
endif; 
/***********************************************
* Main Index page
***********************************************/
if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'republic_theme_mainindex', array(
			'priority' => 35,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Main Index Page', 'republic' )
		) );
		$wp_customize->add_section( 'republic_frontpageindex' , array(
				'title'       => __( 'Enable Front Page', 'republic' ),
				'panel' => 'republic_theme_mainindex'
		));
		
		  //Show or Hide woo product
      $wp_customize->add_setting('republic_enablefrontpage',	
		array(
			'default'			=> true,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
		 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_enablefrontpage',
				 array (
					 
					 'settings'		=> 'republic_enablefrontpage',
					 'section'		=> 'republic_frontpageindex',
					 'type'		=> 'checkbox',                             
					'label'		=> __( 'Enable Custom Front Page', 'republic')	
					 
				 )  ));			
		
		$wp_customize->add_section( 'republic_theme_featuredarea' , array(
				'title'       => __( 'Featured Area', 'republic' ),
				'panel' => 'republic_theme_mainindex'
		));
		
		
		   $wp_customize->add_setting('featured_image',
		array(
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_image'
		)
	);
                $wp_customize->add_control(
		new WP_Customize_Image_Control(	$wp_customize,	'featured_image1',
			array(
				'settings'		=> 'featured_image',
				'section'		=> 'republic_theme_featuredarea',
				'label'			=> __( 'Featured Image', 'republic' )
				
			)
		)
	);
                
                 $wp_customize->add_setting('featured_textarea',
		array(
			
                    'default'			=> __('This is Features Area Put text or HTML here','republic'),
			'type'			=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback' => 'republic_sanitize_html'
		)
	);
                $wp_customize->add_control('featured_textarea',
		array(
			'settings'		=> 'featured_textarea',
			'section'		=> 'republic_theme_featuredarea',
			'type'			=> 'textarea',
			'label'			=> __( 'Featured Area text', 'republic' ),
			'description'	=> __( 'Write anything you want about image or website. HTML allowed here.', 'republic' ),
		)
	);
                
                
		$wp_customize->add_section( 'republic_theme_frontpage' , array(
				'title'       => __( 'Front Page Customize', 'republic' ),
				'panel' => 'republic_theme_mainindex'
		));
 //Blog Label Color
  $wp_customize->add_setting('blog_front_name',
		array(
			'default'		=> __('Blog Posts','republic'),
			'type'			=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
                       'sanitize_callback'	=> 'republic_sanitize_nohtml'
		));
                 
                 
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'blog_front_name',
                         array (
                             
                             'settings'		=> 'blog_front_name',
                             'section'		=> 'republic_theme_frontpage',
                             'type'			=> 'text',
							'label'			=> __( 'Latest Posts label name change', 'republic' )
			
                             
                         )  ));
						 
	   //Show or Hide woo product
                 $wp_customize->add_setting('republic_catehidelatest',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_catehidelatest',
                         array (
                             
                             'settings'		=> 'republic_catehidelatest',
                             'section'		=> 'republic_theme_frontpage',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Latest Posts', 'republic' )
			
                             
                         )  ));					 
 $wp_customize->add_setting('bloglabel_color',
	
		array(
			'default'			=> '#ff3838',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_hex_color'
		)
	);
                 $wp_customize->add_control(new WP_Customize_Color_Control ($wp_customize,'bloglabel_color',
                         array (
                             
                             'settings'		=> 'bloglabel_color',
                             'section'		=> 'republic_theme_frontpage'
			
                             
                         )  ));
						 
   $wp_customize->add_setting('republic_latestpost_range',
		array(
			'default'			=> '5',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_select'
		));
                 
                 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'republic_latestpost_range',
		array(
			'settings'		=> 'republic_latestpost_range',
			'section'		=> 'republic_theme_frontpage',
			'type'			=> 'select',
			'choices'		=> array(
				'3' => __( '3', 'republic' ),
				'6' => __( '6', 'republic' ),
				'9' => __( '9', 'republic' ),
				'12' => __( '12', 'republic' ),
				'15' => __( '15', 'republic' ),
				'18' => __( '18', 'republic' ),
				'21' => __( '21', 'republic' ),
			)
		)));  
                
                         
                 //Blog Posts name
 //Choose Category One
 $wp_customize->add_setting('republic_catechoose1', array(
        'default'        => '1',
          'sanitize_callback'	=> 'republic_sanitize_html'         
		));
$wp_customize->add_control(
    new WP_Customize_Category_Control(   $wp_customize,
        'republic_catechoose1',
        array(
            'label'    => 'Font Page Category 1',
            'settings' => 'republic_catechoose1',
         'section'		=> 'republic_theme_frontpage'
        )
    )
);
 $wp_customize->add_setting('republic_catehide1',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_catehide1',
                         array (
                             
                             'settings'		=> 'republic_catehide1',
                             'section'		=> 'republic_theme_frontpage',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Category 1', 'republic' )
			
                             
                         )  ));
 $wp_customize->add_setting('republic_catecolorone',
	
		array(
			'default'			=> '#3B81DE',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_hex_color'
		)
	);
                 $wp_customize->add_control(new WP_Customize_Color_Control ($wp_customize,'republic_catecolorone',
                         array (
                             
                             'settings'		=> 'republic_catecolorone',
                             'section'		=> 'republic_theme_frontpage'
			
                             
                         )  ));	
 //Choose Category Two
 $wp_customize->add_setting('republic_catechoose2', array(
        'default'        => '1',
               'sanitize_callback'	=> 'republic_sanitize_html'   
		));
$wp_customize->add_control(
    new WP_Customize_Category_Control(   $wp_customize,
        'republic_catechoose2',
        array(
            'label'    => 'Font Page Category 2',
            'settings' => 'republic_catechoose2',
         'section'		=> 'republic_theme_frontpage'
        )
    )
);
 $wp_customize->add_setting('republic_catehide2',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_catehide2',
                         array (
                             
                             'settings'		=> 'republic_catehide2',
                             'section'		=> 'republic_theme_frontpage',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Category 2', 'republic' )
			
                             
                         )  ));
 $wp_customize->add_setting('republic_catecolortwo',
	
		array(
			'default'			=> '#00D066',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_hex_color'
		)
	);
                 $wp_customize->add_control(new WP_Customize_Color_Control ($wp_customize,'republic_catecolortwo',
                         array (
                             
                             'settings'		=> 'republic_catecolortwo',
                             'section'		=> 'republic_theme_frontpage'
			
                             
                         )  ));			 
 //Choose Category Three
 $wp_customize->add_setting('republic_catechoose3', array(
        'default'        => '1',
                   'sanitize_callback'	=> 'republic_sanitize_html'   
		));
$wp_customize->add_control(
    new WP_Customize_Category_Control(   $wp_customize,
        'republic_catechoose3',
        array(
            'label'    => 'Font Page Category 3',
            'settings' => 'republic_catechoose3',
         'section'		=> 'republic_theme_frontpage'
        )
    )
);
 $wp_customize->add_setting('republic_catehide3',
	
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'republic_catehide3',
                         array (
                             
                             'settings'		=> 'republic_catehide3',
                             'section'		=> 'republic_theme_frontpage',
                             'type'		=> 'checkbox',                             
                            'label'		=> __( 'Hide Category 3', 'republic' )
			
                             
                         )  ));
 $wp_customize->add_setting('republic_catecolorthree',
	
		array(
			'default'			=> '#FFC107',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'sanitize_hex_color'
		)
	);
                 $wp_customize->add_control(new WP_Customize_Color_Control ($wp_customize,'republic_catecolorthree',
                         array (
                             
                             'settings'		=> 'republic_catecolorthree',
                             'section'		=> 'republic_theme_frontpage'
			
                             
                         )  ));
         
endif; 
/***********************************************
* Sidebar Widget
***********************************************/
if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'republic_slider', array(
			'priority' => 38,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Slider', 'republic' )
                    
		) );

 $wp_customize->add_section( 'slider_section' , array(
				'title'       => __( 'Slider Settings', 'republic' ),
				'priority'    => 31,
				'panel' => 'republic_slider'
		));   
//Show or Hide Widget
        $wp_customize->add_setting('hide_slider',
		array(
			'default'			=> false,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_checkbox'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'hide_slider',
                         array (
                             
                             'settings'		=> 'hide_slider',
                             'section'		=> 'slider_section',
                             'type'		=> 'checkbox',                             
							'label'			=> __( 'Show slider', 'republic' )
			
                             
                         )  ));
						 
						 
	//Disable caption
			$wp_customize->add_setting('slider_caption',
			array(
			'default'			=> 'block',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'republic_sanitize_select'
			)
			);
			$wp_customize->add_control(new WP_customize_control ($wp_customize,'slider_caption',
				 array (
					 
					 'settings'		=> 'slider_caption',
					 'section'		=> 'slider_section',
					 'type'			=> 'radio',                             
					'label'			=> __( 'Show or Hide Caption Text', 'republic' ),
					'choices' => array(          
							'block' => __('Show','republic'),
							'none' => __('Hide','republic'),
                         )

					 
				 )  ));					 
						 
	   $wp_customize->add_setting('republic_slider_range',
		array(
			'default'			=> '5',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
            'transport' 		=> 'postMessage',
			'sanitize_callback'	=> 'republic_sanitize_select'
		));
                 
                 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'republic_slider_range',
		array(
			'settings'		=> 'republic_slider_range',
			'section'		=> 'slider_section',
			'type'			=> 'select',
			'label'			=> __( 'Choose slides to display', 'republic' ),
			'choices'		=> array(
				'2' => __( '1', 'republic' ),
				'3' => __( '2', 'republic' ),
				'4' => __( '3', 'republic' ),
				'5' => __( '4', 'republic' ),
				'6' => __( '5', 'republic' ),
			)
		)));
		 //Width of slider
 $wp_customize->add_setting('range_fieldslide',
		array(
			'default'			=> 100,
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			 'sanitize_callback'	=> 'republic_sanitize_html'   
		)
	);
              
						 
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize,'range_fieldslide',
  array(
    'type'        => 'range',
	'settings'		=> 'range_fieldslide',
    'priority'    => 10,
    'section'     => 'slider_section',
    'label'       => 'Slider Width',
    'description' => 'Control width of slider in Percentage % max:100, min:59.',
    'input_attrs' => array(
        'min'   => 59,
        'max'   => 100,
        'step'  => 5,
    ),
) ));
		
		
	
		
                 
                     
                     /* Slide 1	*/		
		$wp_customize->add_section( 'republic_slide1' , array(
				'title'       => __( 'Add Slide 1', 'republic' ),
				'priority'    => 31,
				'panel' => 'republic_slider'
		));

		$wp_customize->add_setting( 'slide_image1', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image1', array(
				'label'    => __( 'Image 1', 'republic' ),
				'section'  => 'republic_slide1',
				'settings' => 'slide_image1',
				'priority'    => 1,
		)));
                 $wp_customize->add_setting("slide_caption1", 
                         array(
                            'default' => __('Slide 1 caption text','republic'), 
                             'sanitize_callback' => 'republic_sanitize_html',
                              ));
		 $wp_customize->add_control(new WP_Customize_Control( $wp_customize, "slide_caption1",
                            array(
                                "label" => __("Slide 1 caption text", "republic"),
                                'section'  => 'republic_slide1',
                                "settings" => "slide_caption1",
                                "type" => "textarea",
                                     
        )	));
	

                     /* Slide 2	*/		
		$wp_customize->add_section( 'republic_slide2' , array(
				'title'       => __( 'Add Slide 2', 'republic' ),
				'priority'    => 32,
				'panel' => 'republic_slider'
		));

		$wp_customize->add_setting( 'slide_image2', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image2', array(
				'label'    => __( 'Image 2', 'republic' ),
				'section'  => 'republic_slide2',
				'settings' => 'slide_image2',
				'priority'    => 1,
		)));
                 $wp_customize->add_setting("slide_caption2", 
                         array(
                            'default' => __('Slide 2 caption text','republic'), 
                             'sanitize_callback' => 'republic_sanitize_html',
                              ));
		 $wp_customize->add_control(new WP_Customize_Control( $wp_customize, "slide_caption2",
                            array(
                                "label" => __("Slide 2 caption text", "republic"),
                                'section'  => 'republic_slide2',
                                "settings" => "slide_caption2",
                                "type" => "textarea",
                                     
        )	));
                 
                    /* Slide 3	*/		
		$wp_customize->add_section( 'republic_slide3' , array(
				'title'       => __( 'Add Slide 3', 'republic' ),
				'priority'    => 33,
				'panel' => 'republic_slider'
		));

		$wp_customize->add_setting( 'slide_image3', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image3', array(
				'label'    => __( 'Image 3', 'republic' ),
				'section'  => 'republic_slide3',
				'settings' => 'slide_image3',
				'priority'    => 1,
		)));
                 $wp_customize->add_setting("slide_caption3", 
                         array(
                            'default' => __('Slide 3 caption text','republic'), 
                             'sanitize_callback' => 'republic_sanitize_html',
                              ));
		 $wp_customize->add_control(new WP_Customize_Control( $wp_customize, "slide_caption3",
                            array(
                                "label" => __("Slide 3 caption text", "republic"),
                                'section'  => 'republic_slide3',
                                "settings" => "slide_caption3",
                                "type" => "textarea",
                                     
        )	));
                 
                    /* Slide 4	*/		
		$wp_customize->add_section( 'republic_slide4' , array(
				'title'       => __( 'Add Slide 4', 'republic' ),
				'priority'    => 44,
				'panel' => 'republic_slider'
		));

		$wp_customize->add_setting( 'slide_image4', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image4', array(
				'label'    => __( 'Image 4', 'republic' ),
				'section'  => 'republic_slide4',
				'settings' => 'slide_image4',
				'priority'    => 1,
		)));
                 $wp_customize->add_setting("slide_caption4", 
                         array(
                            'default' => __('Slide 4 caption text','republic'), 
                             'sanitize_callback' => 'republic_sanitize_html',
                              ));
		 $wp_customize->add_control(new WP_Customize_Control( $wp_customize, "slide_caption4",
                            array(
                                "label" => __("Slide 4 caption text", "republic"),
                                'section'  => 'republic_slide4',
                                "settings" => "slide_caption4",
                                "type" => "textarea",
                                     
        )	));
                 
                       /* Slide 5	*/		
		$wp_customize->add_section( 'republic_slide5' , array(
				'title'       => __( 'Add Slide 5', 'republic' ),
				'priority'    => 55,
				'panel' => 'republic_slider'
		));

		$wp_customize->add_setting( 'slide_image5', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image5', array(
				'label'    => __( 'Image 5', 'republic' ),
				'section'  => 'republic_slide5',
				'settings' => 'slide_image5',
				'priority'    => 1,
		)));
                 $wp_customize->add_setting("slide_caption5", 
                         array(
                            'default' => __('Slide 5 caption text','republic'), 
                             'sanitize_callback' => 'republic_sanitize_html',
                              ));
		 $wp_customize->add_control(new WP_Customize_Control( $wp_customize, "slide_caption5",
                            array(
                                "label" => __("Slide 5 caption text Upgrade to pro for more slides", "republic"),
                                'section'  => 'republic_slide5',
                                "settings" => "slide_caption5",
                                "type" => "textarea",
                                     
        )	));                 
	endif;
}

add_action("customize_register","republic_customize_register");
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function republic_customize_preview_js() {
	wp_enqueue_script( 'republic_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'republic_customize_preview_js' );

function republic_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
function republic_sanitize_nohtml( $nohtml ) {
	return wp_filter_nohtml_kses( $nohtml );
}
function republic_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


function republic_registers() {
	wp_register_script( 'republic_customizer_script', get_template_directory_uri() . '/js/republic_customizer.js', array("jquery","republic_jquery_ui"), '20120206', true  );
	wp_enqueue_script( 'republic_customizer_script' );
	
	wp_localize_script( 'republic_customizer_script', 'republic-cust-script', array(
		'documentation' => __( 'Documentation', 'republic' ),
		'pro' => __('Upgrade to Pro','republic'),
		'support' => __('Support Forum','republic')
		
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'republic_registers' );


function republic_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}
function republic_sanitize_css( $css ) {
	return wp_strip_all_tags( $css );
}

function republic_sanitize_html( $value ) {
		return $value;
        
}
if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;','republic' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}