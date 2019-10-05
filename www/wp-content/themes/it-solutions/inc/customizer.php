<?php
/**
 * IT Solutions Theme Customizer
 *
 * @package IT Solutions
 */
function it_solutions_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'it_solutions_custom_header_args', array(
		'default-text-color'     => '949494',
		'width'                  => 1600,
		'height'                 => 200,
		'wp-head-callback'       => 'it_solutions_header_style',
 		'default-text-color' => false,
 		'header-text' => false,
	) ) );
}
add_action( 'after_setup_theme', 'it_solutions_custom_header_setup' );
if ( ! function_exists( 'it_solutions_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see it_solutions_custom_header_setup().
 */
function it_solutions_header_style() {
	$header_text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() ) :
	?>
		.header {
			background: url(<?php echo esc_url(get_header_image()); ?>) no-repeat;
			background-position: center top;
		}
	<?php endif; ?>	
	</style>
	<?php
}
endif; // it_solutions_header_style 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */ 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function it_solutions_customize_register( $wp_customize ) {
	//Add a class for titles
    class it_solutions_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#3dbad5',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => esc_html__('Color Scheme','it-solutions'),			
			 'description'	=> esc_html__('More color options in PRO Version','it-solutions'),	
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	// Slider Section		
	$wp_customize->add_section( 'slider_section', array(
            'title' => esc_html__('Slider Settings', 'it-solutions'),
            'priority' => null,
            'description'	=> esc_html__('Featured Image Size Should be ( 1400 X 789 ) More slider settings available in PRO Version','it-solutions'),		
        )
    );
	$wp_customize->add_setting('page-setting7',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'it_solutions_sanitize_integer'
	));
	$wp_customize->add_control('page-setting7',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide one:','it-solutions'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting8',array(
			'default' => '0',
			'capability' => 'edit_theme_options',			
			'sanitize_callback'	=> 'it_solutions_sanitize_integer'
	));
	$wp_customize->add_control('page-setting8',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide two:','it-solutions'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting9',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'it_solutions_sanitize_integer'
	));
	$wp_customize->add_control('page-setting9',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide three:','it-solutions'),
			'section'	=> 'slider_section'
	));	
	//Slider hide
	$wp_customize->add_setting('hide_slides',array(
			'sanitize_callback' => 'it_solutions_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_slides', array(
    	   'section'   => 'slider_section',    	 
		   'label'	=> esc_html__('Uncheck To Show Slider','it-solutions'),
    	   'type'      => 'checkbox'
     )); // Slider Section		 
	 
	$wp_customize->add_section('header_top_bar',array(
			'title'	=> esc_html__('Header Topbar','it-solutions'),				
			'description'	=> esc_html__('More social icon available in PRO Version','it-solutions'),		
			'priority'		=> null
	));
	
	$wp_customize->add_setting('fb_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('fb_link',array(
			'label'	=> esc_html__('Add facebook link here','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'fb_link'
	));	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('twitt_link',array(
			'label'	=> esc_html__('Add twitter link here','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'twitt_link'
	));
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('gplus_link',array(
			'label'	=> esc_html__('Add google plus link here','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'gplus_link'
	));
	$wp_customize->add_setting('linked_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('linked_link',array(
			'label'	=> esc_html__('Add linkedin link here','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'linked_link'
	));
	$wp_customize->add_setting('top_tagline',array(
			'default'	=> null,
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('top_tagline',array(
			'label'	=> esc_html__('Add tagline here.','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'top_tagline'
	));		
	$wp_customize->add_setting('contact_mail',array(
			'default'	=> null,
			'sanitize_callback'	=> 'sanitize_email'
	));
	
	$wp_customize->add_control('contact_mail',array(
			'label'	=> esc_html__('Add you email here','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'contact_mail'
	));
	$wp_customize->add_setting('contact_no',array(
			'default'	=> null,
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('contact_no',array(
			'label'	=> esc_html__('Add contact number here.','it-solutions'),
			'section'	=> 'header_top_bar',
			'setting'	=> 'contact_no'
	));	
	
	//Hide Header Top Bar
	$wp_customize->add_setting('hide_header_topbar',array(
			'sanitize_callback' => 'it_solutions_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_header_topbar', array(
    	   'section'   => 'header_top_bar',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','it-solutions'),
    	   'type'      => 'checkbox'
     )); 	//Hide Header Top Bar		 

	// Home Section One
	$wp_customize->add_section('section_thumb_with_content', array(
		'title'	=> esc_html__('Home Section One','it-solutions'),
		'description'	=> esc_html__('Select Page from the dropdown for section','it-solutions'),
		'priority'	=> null
	));	

	$wp_customize->add_setting('sec-column-left1',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec-column-left1',array('type' => 'dropdown-pages',
			'section' => 'section_thumb_with_content',
	));	
	
	$wp_customize->add_setting('sec-column-left2',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec-column-left2',array('type' => 'dropdown-pages',
			'section' => 'section_thumb_with_content',
	));		
 	
	$wp_customize->add_setting('sec-column-left3',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec-column-left3',array('type' => 'dropdown-pages',
			'section' => 'section_thumb_with_content',
	));		
 	
	$wp_customize->add_setting('sec-column-left4',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec-column-left4',array('type' => 'dropdown-pages',
			'section' => 'section_thumb_with_content',
	));	

	//Hide Section 	
	$wp_customize->add_setting('hide_home_secwith_content',array(
			'sanitize_callback' => 'it_solutions_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_home_secwith_content', array(
    	   'section'   => 'section_thumb_with_content',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','it-solutions'),
    	   'type'      => 'checkbox'
     )); // Hide Section 	
	 
	// Home Section 2
	$wp_customize->add_section('section_two', array(
		'title'	=> esc_html__('Home Section Two','it-solutions'),
		'description'	=> esc_html__('Select Page from the dropdown','it-solutions'),
		'priority'	=> null
	));	

	$wp_customize->add_setting('page-column1',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'page-column1',array('type' => 'dropdown-pages',
			'section' => 'section_two',
	));	
	
	//Hide Section
	$wp_customize->add_setting('hide_sectiontwo',array(
			'sanitize_callback' => 'it_solutions_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_sectiontwo', array(
    	   'section'   => 'section_two',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','it-solutions'),
    	   'type'      => 'checkbox'
     )); //Hide Section
	 
	// Home Section Three
	$wp_customize->add_section('section_hm3', array(
		'title'	=> esc_html__('Home Section Three','it-solutions'),
		'description'	=> esc_html__('Select Page from the dropdown for section','it-solutions'),
		'priority'	=> null
	));	
	
	$wp_customize->add_setting('section3_title',array(
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section3_title',array(
			'label'	=> __('Add title for section title','it-solutions'),
			'section'	=> 'section_hm3',
			'setting'	=> 'section1_title'
	));	
	
	$wp_customize->add_setting('sec3-bx1',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx1',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));	
	
	$wp_customize->add_setting('sec3-bx2',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx2',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));		
 	
	$wp_customize->add_setting('sec3-bx3',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx3',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));		
 	
	$wp_customize->add_setting('sec3-bx4',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx4',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));	
 	
	$wp_customize->add_setting('sec3-bx5',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx5',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));		
 	
	$wp_customize->add_setting('sec3-bx6',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'it_solutions_sanitize_integer',
		));
	$wp_customize->add_control(	'sec3-bx6',array('type' => 'dropdown-pages',
			'section' => 'section_hm3',
	));		

	//Hide Section 	
	$wp_customize->add_setting('hide_hm3_content',array(
			'sanitize_callback' => 'it_solutions_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_hm3_content', array(
    	   'section'   => 'section_hm3',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','it-solutions'),
    	   'type'      => 'checkbox'
     )); // Hide Section 	 

	$wp_customize->add_section('footer_main',array(
			'title'	=> esc_html__('Footer Area','it-solutions'),
			'description'	=> esc_html__('Manager Footer From Widgets >> Footer Column 1, Footer Column 2, Footer Column 3, Footer Column 4','it-solutions'),			
			'priority'	=> null,
	));	
	
    $wp_customize->add_setting('it_solutions_options[footer-info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new it_solutions_Info( $wp_customize, 'footer_main', array(
        'section' => 'footer_main',
        'settings' => 'it_solutions_options[footer-info]',
        'priority' => null
        ) )
    );  	
	
}
add_action( 'customize_register', 'it_solutions_customize_register' );
//Integer
function it_solutions_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
function it_solutions_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

//setting inline css.
function it_solutions_custom_css() {
    wp_enqueue_style(
        'it-solutions-custom-style',
        get_template_directory_uri() . '/css/it-solutions-custom-style.css'
    );
        $color = get_theme_mod( 'color_scheme' ); //E.g. #e64d43
		$header_text_color = get_header_textcolor();
        $custom_css = "
					#sidebar ul li a:hover,				
					.head-info-area .right .phntp .phoneno strong,					
					.blog_lists h4 a:hover,
					.recent-post h6 a:hover,
					.recent-post a:hover,
					.design-by a,
					.slide_info h2 span,
					.emltp a,
					.logo h2 span,
					.fancy-title h2 span,
					.nivo-controlNav a.active,
					.postmeta a:hover,
					.recent-post .morebtn:hover, .sitenav ul li a:hover, .sitenav ul li.current_page_item a, .sitenav ul li.menu-item-has-children.hover, .sitenav ul li.current-menu-parent a.parent, .left-fitbox a:hover h3, .right-fitbox a:hover h3, .tagcloud a, .servicebox:hover h3
					{ 
						 color: {$color} !important;
					}
					.pagination .nav-links span.current, .pagination .nav-links a:hover,
					#commentform input#submit:hover,
					.wpcf7 input[type='submit'],
					a.ReadMore,
					.section2button,
					input.search-submit,
					.slide_info .slide_more,
					.serviceboxbg:hover a.serv-read,
					.home_section2_content h2:after,
					.center-title h2:after,
					.featuresbox-area:hover
					{ 
					   background-color: {$color} !important;
					}
					.titleborder span:after{border-bottom-color: {$color} !important;}
				";
        wp_add_inline_style( 'it-solutions-custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'it_solutions_custom_css' );          
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function it_solutions_customize_preview_js() {
	wp_enqueue_script( 'it_solutions_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'it_solutions_customize_preview_js' );