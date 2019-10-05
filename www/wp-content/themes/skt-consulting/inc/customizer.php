<?php
/**
 * Event Planners Theme Customizer
 *
 * @package SKT Consulting
 */
function skt_consulting_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'skt_consulting_custom_header_args', array(
		'default-text-color'     => '949494',
		'width'                  => 1600,
		'height'                 => 200,
		'wp-head-callback'       => 'skt_consulting_header_style',
 		'default-text-color' => false,
 		'header-text' => false,
	) ) );
}
add_action( 'after_setup_theme', 'skt_consulting_custom_header_setup' );
if ( ! function_exists( 'skt_consulting_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see skt_consulting_custom_header_setup().
 */
function skt_consulting_header_style() {
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
endif; // skt_consulting_header_style 
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
function skt_consulting_customize_register( $wp_customize ) {
	//Add a class for titles
    class skt_consulting_Info extends WP_Customize_Control {
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
			'default'	=> '#4208bc',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => esc_html__('Color Scheme','skt-consulting'),			
			 'description'	=> esc_html__('More color options in PRO Version','skt-consulting'),	
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	// Slider Section		
	$wp_customize->add_section( 'slider_section', array(
            'title' => esc_html__('Slider Settings', 'skt-consulting'),
            'priority' => null,
            'description'	=> esc_html__('Featured Image Size Should be ( 1400 X 872 ) More slider settings available in PRO Version','skt-consulting'),		
        )
    );
	$wp_customize->add_setting('page-setting7',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'skt_consulting_sanitize_integer'
	));
	$wp_customize->add_control('page-setting7',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide one:','skt-consulting'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting8',array(
			'default' => '0',
			'capability' => 'edit_theme_options',			
			'sanitize_callback'	=> 'skt_consulting_sanitize_integer'
	));
	$wp_customize->add_control('page-setting8',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide two:','skt-consulting'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting9',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'skt_consulting_sanitize_integer'
	));
	$wp_customize->add_control('page-setting9',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide three:','skt-consulting'),
			'section'	=> 'slider_section'
	));	
	//Slider hide
	$wp_customize->add_setting('hide_slides',array(
			'sanitize_callback' => 'skt_consulting_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_slides', array(
    	   'section'   => 'slider_section',    	 
		   'label'	=> esc_html__('Uncheck To Show Slider','skt-consulting'),
    	   'type'      => 'checkbox'
     )); // Slider Section	
	 
// Home Section 1
	$wp_customize->add_section('section_one', array(
		'title'	=> esc_html__('Home Section One','skt-consulting'),
		'description'	=> esc_html__('Select Page from the dropdown','skt-consulting'),
		'priority'	=> null
	));	
	
	$wp_customize->add_setting('section1_title',array(
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section1_title',array(
			'label'	=> __('Add section top title','skt-consulting'),
			'section'	=> 'section_one',
			'setting'	=> 'section1_title'
	));		

	$wp_customize->add_setting('page-column1',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'page-column1',array('type' => 'dropdown-pages',
			'section' => 'section_one',
	));	
	
	//Hide Section
	$wp_customize->add_setting('hide_sectionone',array(
			'sanitize_callback' => 'skt_consulting_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_sectionone', array(
    	   'section'   => 'section_one',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','skt-consulting'),
    	   'type'      => 'checkbox'
     )); //Hide Section	
	 
	 
	 
// Home Section 2
	$wp_customize->add_section('section_two', array(
		'title'	=> esc_html__('Home Section Two','skt-consulting'),
		'description'	=> esc_html__('Select Page from the dropdown','skt-consulting'),
		'priority'	=> null
	));	
	
	$wp_customize->add_setting('section2_title',array(
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section2_title',array(
			'label'	=> __('Add section top title','skt-consulting'),
			'section'	=> 'section_two',
			'setting'	=> 'section2_title'
	));		

	$wp_customize->add_setting('page-column2',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'page-column2',array('type' => 'dropdown-pages',
			'section' => 'section_two',
	));	
	
	//Hide Section
	$wp_customize->add_setting('hide_sectiontwo',array(
			'sanitize_callback' => 'skt_consulting_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_sectiontwo', array(
    	   'section'   => 'section_two',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','skt-consulting'),
    	   'type'      => 'checkbox'
     )); //Hide Section	 	 	 	 

	// Home Section 3
	$wp_customize->add_section('hm_section_3', array(
		'title'	=> esc_html__('Home Section Three','skt-consulting'),
		'description'	=> esc_html__('Select Page from the dropdown for section','skt-consulting'),
		'priority'	=> null
	));	
	
	$wp_customize->add_setting('section3_title',array(
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section3_title',array(
			'label'	=> __('Add title for section title 1','skt-consulting'),
			'section'	=> 'hm_section_3',
			'setting'	=> 'section3_title'
	));	
	
	
	$wp_customize->add_setting('section3_title2',array(
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('section3_title2',array(
			'label'	=> __('Add title for section title 2','skt-consulting'),
			'section'	=> 'hm_section_3',
			'setting'	=> 'section3_title2'
	));		
	
	$wp_customize->add_setting('third-column-left1',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left1',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));	
	
	$wp_customize->add_setting('third-column-left2',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left2',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));		
 	
	$wp_customize->add_setting('third-column-left3',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left3',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));	
	
	$wp_customize->add_setting('third-column-left4',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left4',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));	
		
	$wp_customize->add_setting('third-column-left5',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left5',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));		
		
	$wp_customize->add_setting('third-column-left6',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left6',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));	
		
	$wp_customize->add_setting('third-column-left7',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left7',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));	
		
	$wp_customize->add_setting('third-column-left8',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left8',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));		
		
	$wp_customize->add_setting('third-column-left9',	array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback' => 'skt_consulting_sanitize_integer',
		));
	$wp_customize->add_control(	'third-column-left9',array('type' => 'dropdown-pages',
			'section' => 'hm_section_3',
	));		

	//Hide Section 	
	$wp_customize->add_setting('hide_home_third_content',array(
			'sanitize_callback' => 'skt_consulting_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_home_third_content', array(
    	   'section'   => 'hm_section_3',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','skt-consulting'),
    	   'type'      => 'checkbox'
     )); // Hide Section 
	 
	// Social Icons 
	$wp_customize->add_section('social_sec',array(
			'title'	=> esc_html__('Footer Social Settings','skt-consulting'),				
			'description'	=> esc_html__('More social icon available in PRO Version','skt-consulting'),		
			'priority'		=> null
	));
	$wp_customize->add_setting('fb_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	$wp_customize->add_control('fb_link',array(
			'label'	=> esc_html__('Add Facebook link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'fb_link'
	));	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('twitt_link',array(
			'label'	=> esc_html__('Add Twitter link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'twitt_link'
	));
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('gplus_link',array(
			'label'	=> esc_html__('Add Google plus link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'gplus_link'
	));
	$wp_customize->add_setting('youtube_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('youtube_link',array(
			'label'	=> esc_html__('Add Youtube link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'youtube_link'
	));	
	$wp_customize->add_setting('instagram_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('instagram_link',array(
			'label'	=> esc_html__('Add Instagram link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'instagram_link'
	));		
	$wp_customize->add_setting('linkedin_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('linkedin_link',array(
			'label'	=> esc_html__('Add Linkedin link here','skt-consulting'),
			'section'	=> 'social_sec',
			'setting'	=> 'linkedin_link'
	));	
	// Social Icons 	 			 	
	
}
add_action( 'customize_register', 'skt_consulting_customize_register' );
//Integer
function skt_consulting_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
function skt_consulting_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

//setting inline css.
function skt_consulting_custom_css() {
    wp_enqueue_style(
        'skt-consulting-custom-style',
        get_template_directory_uri() . '/css/skt-consulting-custom-style.css'
    );
        $color = get_theme_mod( 'color_scheme' ); //E.g. #e64d43
		$header_text_color = get_header_textcolor();
        $custom_css = "
					#sidebar ul li a,
					.cols-3 ul li.current_page_item a,				
					.phone-no strong,					
					.left a:hover,
					.blog_lists h4 a:hover,
					.recent-post h6 a:hover,
					.recent-post a:hover,
					.design-by a,
					.fancy-title h2 span,
					.postmeta a:hover,
					.left-fitbox a:hover h3, .right-fitbox a:hover h3, .tagcloud a,
					.slide_info h2 span,
					.hm-rightcols h2 small, .hm-leftcols h2 small,
					.smalltitle,
					.sitenav ul li.current_page_item a,
					.aboutboxcol-content h3 a:hover,
					.sitenav ul li.menu-item-has-children.hover, .sitenav ul li.current-menu-parent a.parent, .sitenav ul li a:hover
					{ 
						 color: {$color} !important;
					}
					.pagination .nav-links span.current, .pagination .nav-links a:hover,
					#commentform input#submit:hover,
					.nivo-controlNav a.active,								
					.wpcf7 input[type='submit'],
					a.ReadMore,
					.section2button,
					input.search-submit,
					.slide_info .slide_more,
					.recent-post .morebtn:hover, 
					.titlebg-block
					{ 
					   background-color: {$color} !important;
					}
					.titleborder span:after{border-bottom-color: {$color} !important;}
				";
        wp_add_inline_style( 'skt-consulting-custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'skt_consulting_custom_css' );          
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skt_consulting_customize_preview_js() {
	wp_enqueue_script( 'skt_consulting_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'skt_consulting_customize_preview_js' );