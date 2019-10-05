<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/********************* Set Default Value if not set ***********************************/
	if ( !get_theme_mod('idyllic_theme_options') ) {
		set_theme_mod( 'idyllic_theme_options', idyllic_get_option_defaults_values() );
	}
/********************* IDYLLIC RESPONSIVE AND CUSTOM CSS OPTIONS ***********************************/
function idyllic_responsiveness() {
	$idyllic_settings = idyllic_get_theme_options();
	if( $idyllic_settings['idyllic_responsive'] == 'on' ) { ?>
	<meta name="viewport" content="width=device-width" />
	<?php } else { ?>
	<meta name="viewport" content="width=1170" />
	<?php  }
}
add_filter( 'wp_head', 'idyllic_responsiveness');

/******************************** EXCERPT LENGTH *********************************/
function idyllic_excerpt_length($idyllic_excerpt_length) {
	$idyllic_settings = idyllic_get_theme_options();
	if( is_admin() ){
		return absint($idyllic_excerpt_length);
	}

	$idyllic_excerpt_length = $idyllic_settings['idyllic_excerpt_length'];
	return absint($idyllic_excerpt_length);
}
add_filter('excerpt_length', 'idyllic_excerpt_length');

/********************* CONTINUE READING LINKS FOR EXCERPT *********************************/
function idyllic_continue_reading() {
	if( is_admin() ){
		return '&hellip; ';
	}

	return '&hellip; ';
}
add_filter('excerpt_more', 'idyllic_continue_reading');

/***************** USED CLASS FOR BODY TAGS ******************************/
function idyllic_body_class($idyllic_class) {
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_blog_layout = $idyllic_settings['idyllic_blog_layout'];
	$idyllic_site_layout = $idyllic_settings['idyllic_design_layout'];
	$idyllic_header_design_layout = $idyllic_settings['idyllic_header_design_layout'];
	if ($idyllic_site_layout =='boxed-layout') {
		$idyllic_class[] = 'boxed-layout';
	}elseif ($idyllic_site_layout =='small-boxed-layout') {
		$idyllic_class[] = 'boxed-layout-small';
	}else{
		$idyllic_class[] = '';
	}
	if(!is_single()){
		if ($idyllic_blog_layout == 'medium_image_display'){
			$idyllic_class[] = "small-image-blog";
		}elseif($idyllic_blog_layout == 'two_column_image_display'){
			$idyllic_class[] = "two-column-blog";
		}else{
			$idyllic_class[] = "";
		}
	}
	if(is_page_template('page-templates/idyllic-corporate.php')) {
			$idyllic_class[] = 'idyllic-corporate';
	}

	if($idyllic_header_design_layout == ''){
		$idyllic_class[] = '';
	}elseif($idyllic_header_design_layout == 'top-logo-title'){
		$idyllic_class[] = 'top-logo-title';
	}elseif($idyllic_header_design_layout == 'box-slider'){
		$idyllic_class[] = 'box-slider';
	}elseif($idyllic_header_design_layout == 'header-item-one'){
		$idyllic_class[] = 'header-item-one';
	}else{
		$idyllic_class[] = 'header-item-two';
	}
	return $idyllic_class;
}
add_filter('body_class', 'idyllic_body_class');

/********************** SCRIPTS FOR DONATE/ UPGRADE BUTTON ******************************/
function idyllic_customize_scripts() {
	wp_enqueue_style( 'idyllic_customizer_custom', get_template_directory_uri() . '/inc/css/idyllic-customizer.css');
}
add_action( 'customize_controls_print_scripts', 'idyllic_customize_scripts');

/**************************** SOCIAL MENU *********************************************/
function idyllic_social_links_display() {
		if ( has_nav_menu( 'social-link' ) ) : ?>
	<div class="social-links clearfix">
	<?php
		wp_nav_menu( array(
			'container' 	=> '',
			'theme_location' => 'social-link',
			'depth'          => 1,
			'items_wrap'      => '<ul>%3$s</ul>',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
		) );
	?>
	</div><!-- end .social-links -->
	<?php endif; ?>
<?php }
add_action ('idyllic_social_links', 'idyllic_social_links_display');

/******************* DISPLAY BREADCRUMBS ******************************/
function idyllic_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb home">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}

/*********************** idyllic Category SLIDERS ***********************************/
function idyllic_category_sliders() {
	$idyllic_settings = idyllic_get_theme_options();
	global $idyllic_excerpt_length;
	$slider_custom_text = $idyllic_settings['idyllic_secondary_text'];
	$slider_custom_url = $idyllic_settings['idyllic_secondary_url'];
	$idyllic_slider_design_layout = $idyllic_settings['idyllic_slider_design_layout'];
	$idyllic_slider_animation_option = $idyllic_settings['idyllic_slider_animation_option'];
	$query = new WP_Query(array(
					'posts_per_page' =>  intval($idyllic_settings['idyllic_category_slider_number']),
					'post_type' => array(
						'post'
					) ,
					'category__in' => intval($idyllic_settings['idyllic_category_slider']),
				));
	if($query->have_posts() && !empty($idyllic_settings['idyllic_category_slider'])){
		$idyllic_category_sliders_display = '';
		$slider_animation_classes='';
		if($idyllic_slider_animation_option == 'animation-bottom'){
			$slider_animation_classes = 'animation-bottom';
		}elseif($idyllic_slider_animation_option == 'animation-top'){
			$slider_animation_classes = 'animation-top';
		}elseif($idyllic_slider_animation_option == 'animation-left'){
			$slider_animation_classes = 'animation-left';
		}elseif($idyllic_slider_animation_option == 'animation-right'){
			$slider_animation_classes = 'animation-right';
		}elseif($idyllic_slider_animation_option == 'no-animation'){
			$slider_animation_classes = '';
		}
		$idyllic_category_sliders_display 	.= '<div class="main-slider '.esc_attr($slider_animation_classes).'">';
		if($idyllic_slider_design_layout=='layer-slider'){
			$idyllic_category_sliders_display 	.= '<div class="layer-slider">';
		}else{
			$idyllic_category_sliders_display 	.= '<div class="multi-slider">';
		}
		$idyllic_category_sliders_display 	.= '<ul class="slides">';
		while ($query->have_posts()):$query->the_post();
			$attachment_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src($attachment_id,'idyllic_slider_image');
			$title_attribute = apply_filters('the_title', get_the_title(get_queried_object_id()));
			$excerpt = get_the_excerpt();
				$idyllic_category_sliders_display    	.= '<li>';
				if ($image_attributes) {
					$idyllic_category_sliders_display 	.= '<div class="image-slider" title="'.the_title_attribute('echo=0').'"' .' style="background-image:url(' ."'" .esc_url($image_attributes[0])."'" .')">';
				}else{
					$idyllic_category_sliders_display 	.= '<div class="image-slider">';
				}
				$idyllic_category_sliders_display 	.= '<article class="slider-content">';
				if ($title_attribute != '' || $excerpt != '') {
					$idyllic_category_sliders_display 	.= '<div class="slider-text-content">';

					if ($excerpt != '') {
							$idyllic_category_sliders_display .= '<p class="slider-text">'.wp_strip_all_tags( get_the_excerpt(), true ).'</p><!-- end .slider-text -->';
					}
					$remove_link = $idyllic_settings['idyllic_slider_link'];
						if($remove_link == 0){
							if ($title_attribute != '') {
								$idyllic_category_sliders_display .= '<h2 class="slider-title"><a href="'.esc_url(get_permalink()).'" title="'.the_title_attribute('echo=0').'" rel="bookmark">'.get_the_title().'</a></h2><!-- .slider-title -->';
							}
						}else{
							$idyllic_category_sliders_display .= '<h2 class="slider-title">'.get_the_title().'</h2><!-- .slider-title -->';
						}
					$idyllic_category_sliders_display 	.= '</div><!-- end .slider-text-content -->';
				}
				if($idyllic_settings['idyllic_slider_button'] == 0){
					$idyllic_category_sliders_display 	.='<div class="slider-buttons">';
					$excerpt_text = $idyllic_settings['idyllic_tag_text'];
					if($excerpt_text == '' || $excerpt_text == 'Continue Reading') :
						$idyllic_category_sliders_display 	.= '<a title='.'"'.the_title_attribute('echo=0'). '"'. ' '.'href="'.esc_url(get_permalink()).'"'.' class="btn-default vivid-red">'.esc_html__('Continue reading', 'idyllic').'</a>';
					else:
						$idyllic_category_sliders_display 	.= '<a title='.'"'.the_title_attribute('echo=0'). '"'. ' '.'href="'.esc_url(get_permalink()).'"'.' class="btn-default vivid-red">'.esc_attr($idyllic_settings[ 'idyllic_tag_text' ]).'</a>';
					endif;
				
					if(!empty($slider_custom_text)){
						$idyllic_category_sliders_display 	.= '<a title="'.esc_attr($slider_custom_text).'"' .' href="'.esc_url($slider_custom_url). '"'. ' class="btn-default vivid-blue" target="_blank">'.esc_attr($slider_custom_text). '</a>';
					}
					
					$idyllic_category_sliders_display 	.= '</div><!-- end .slider-buttons -->';
				}
				$idyllic_category_sliders_display 	.='</article><!-- end .slider-content --> ';
				$idyllic_category_sliders_display 	.='</div><!-- end .image-slider -->
				</li>';
			endwhile;
			wp_reset_postdata();
			$idyllic_category_sliders_display .= '</ul><!-- end .slides -->
				</div> <!-- end .layer-slider -->
			</div> <!-- end .main-slider -->';
				echo $idyllic_category_sliders_display;
			}
}
/*************************** ENQUEING STYLES AND SCRIPTS ****************************************/
function idyllic_scripts() {
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_stick_menu = $idyllic_settings['idyllic_stick_menu'];
	wp_enqueue_script('idyllic-main', get_template_directory_uri().'/js/idyllic-main.js', array('jquery'), false, true);
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_style( 'idyllic-style', get_stylesheet_uri() );
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/font-awesome/css/font-awesome.min.css');

	if($idyllic_settings['idyllic_wow_effect'] ==0){
		wp_enqueue_style('idyllic-animate', get_template_directory_uri().'/assets/wow/css/animate.min.css');
		wp_enqueue_script('wow', get_template_directory_uri().'/assets/wow/js/wow.min.js', array('jquery'), false, true);
		wp_enqueue_script('idyllic-wow-settings', get_template_directory_uri().'/assets/wow/js/wow-settings.js', array('jquery'), false, true);
	}

	if($idyllic_stick_menu != 1):
		wp_enqueue_script('jquery-sticky', get_template_directory_uri().'/assets/sticky/jquery.sticky.min.js', array('jquery'), false, true);
	wp_enqueue_script('idyllic-sticky-settings', get_template_directory_uri().'/assets/sticky/sticky-settings.js', array('jquery'), false, true);
	endif;
	wp_enqueue_script('waypoints', get_template_directory_uri().'/js/jquery.waypoints.min.js', array('jquery'), false, true);
	wp_enqueue_script('counterup', get_template_directory_uri().'/js/jquery.counterup.min.js', array('jquery'), false, true);
	wp_enqueue_script('idyllic-navigation', get_template_directory_uri().'/js/navigation.js', array('jquery'), false, true);
	wp_enqueue_script('jquery-flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'), false, true);
	wp_enqueue_script('idyllic-slider', get_template_directory_uri().'/js/flexslider-setting.js', array('jquery-flexslider'), false, true);
	wp_enqueue_script('idyllic-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array('jquery'), false, true);
	if($idyllic_settings['idyllic_disable_fact_figure_number_count']!=1){
		wp_enqueue_script('idyllic-number-counter', get_template_directory_uri().'/js/number-counter.js', array('jquery'), false, true);

	}
	$idyllic_animation_effect   = esc_attr($idyllic_settings['idyllic_animation_effect']);
	$idyllic_slideshowSpeed    = absint($idyllic_settings['idyllic_slideshowSpeed'])*1000; // Set the speed of the slideshow cycling, in milliseconds
	$idyllic_animationSpeed = absint($idyllic_settings['idyllic_animationSpeed'])*100; //Set the speed of animations, in milliseconds
	wp_localize_script(
		'idyllic-slider',
		'idyllic_slider_value',
		array(
			'idyllic_animation_effect'   => $idyllic_animation_effect,
			'idyllic_slideshowSpeed'    => $idyllic_slideshowSpeed,
			'idyllic_animationSpeed' => $idyllic_animationSpeed,
		)
	);
	wp_enqueue_script( 'idyllic-slider' );
	if( $idyllic_settings['idyllic_responsive'] == 'on' ) {
		wp_enqueue_style('idyllic-responsive', get_template_directory_uri().'/css/responsive.css');
	}
	/********* Adding Multiple Fonts ********************/
	$idyllic_googlefont = array();
	array_push( $idyllic_googlefont, 'Arimo:400,400i,700');
	array_push( $idyllic_googlefont, 'Lustria');
	$idyllic_googlefonts = implode("|", $idyllic_googlefont);
	wp_register_style( 'idyllic-google-fonts', '//fonts.googleapis.com/css?family='.$idyllic_googlefonts);
	wp_enqueue_style( 'idyllic-google-fonts' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Custom Css */
	$idyllic_internal_css='';
	if ($idyllic_settings['idyllic_slider_content_bg_color'] =='on'){
		$idyllic_internal_css .= '/* Slider Content With background color */
		.slider-text-content {
			background-color: rgba(255, 255, 255, 0);
			border: 1px solid rgba(255, 255, 255, 0);
			margin-bottom: 20px;
			outline: 1px solid rgba(255, 255, 255, 0);
			padding: 30px 30px 5px;
			transition: all 0.7s ease 0.7s;
		}

		.flex-active-slide .slider-text-content {
			background-color: rgba(255, 255, 255, 0.5);
			border: 1px solid rgba(255, 255, 255, 0.15);
			outline: 6px solid rgba(255, 255, 255, 0.5);
		}

		.multi-slider .slider-text-content {
			background-color: transparent;
			padding: 0;
			margin: 0;
		}

		.header-item-one.sld-plus .multi-slider .slider-text-content,
		.header-item-two.sld-plus .multi-slider .slider-text-content {
			padding: 0;
			margin: 0;
		}';
	}
	if ($idyllic_settings['idyllic_logo_high_resolution'] !=0){
		$idyllic_internal_css .= '/* Logo for high resolution screen(Use 2X size image) */
		.custom-logo-link .custom-logo {
			height: 80px;
			width: auto;
		}

		.top-logo-title .custom-logo-link {
			display: inline-block;
		}

		.top-logo-title .custom-logo {
			height: auto;
			width: 50%;
		}

		.top-logo-title #site-detail {
			display: block;
			text-align: center;
		}

		@media only screen and (max-width: 767px) { 
			.top-logo-title .custom-logo-link .custom-logo {
				width: 60%;
			}
		}

		@media only screen and (max-width: 480px) { 
			.top-logo-title .custom-logo-link .custom-logo {
				width: 80%;
			}
		}';
	}

	if($idyllic_settings['idyllic_header_display']=='header_logo'){
		$idyllic_internal_css .= '
		#site-branding #site-title, #site-branding #site-description{
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}';
	}

	if ($idyllic_settings['idyllic_fullwidth_feature_single_post'] !=0){
		$idyllic_internal_css .= '/* Display full width feature image in single post */
		.single-featured-image-header {
			margin: 0;
			max-width: 100%;
		}';
	}
	for ( $i=1; $i <= $idyllic_settings['idyllic_total_features'] ; $i++ ) {
		$feature_wrap_color = get_theme_mod('idyllic_feature_wrap_icon_color_'. $i,'');
		$fact_figure_box_color = get_theme_mod('idyllic_fact_figure_color_box_'. $i,'');
		if($feature_wrap_color!=''){
			$idyllic_internal_css .= '/* Front Page features Multi Color ' .absint($i).'*/
			.our-feature-box .four-column .feature-content-wrap.feature-wrap-color-'.absint($i).',
			.our-feature-one .four-column .feature-icon.icon-color-'.absint($i).' {
				background-color: '.esc_attr($feature_wrap_color).';
			}';
		}

		if($fact_figure_box_color!=''){
			$idyllic_internal_css .= '/* Front Page features Multi Color ' .absint($i).'*/
			.fact-figure-box .four-column:nth-child(4n+' .absint($i).') .counter:after {
				background-color: '.esc_attr($fact_figure_box_color).';
			}';
		}
	}

	$idyllic_secondary_button_color = get_theme_mod('idyllic_secondary_button_color','#3dace1');
	$idyllic_fact_figure_button_color = get_theme_mod('idyllic_fact_figure_button_color','#333333');
	if($idyllic_secondary_button_color !='#3dace1'){
		$idyllic_internal_css .='/* Slider Secondary Buton Color */
			.vivid-blue {
				background-color: '. esc_attr($idyllic_secondary_button_color).';
			}';
	}
	if($idyllic_fact_figure_button_color !='#333333'){
		$idyllic_internal_css .='/* Fact and Figure Button Color */
			.btn-default.dark {
				background-color: '. esc_attr($idyllic_fact_figure_button_color).';
			}';
	}
	wp_add_inline_style( 'idyllic-style', wp_strip_all_tags($idyllic_internal_css) );
}
add_action( 'wp_enqueue_scripts', 'idyllic_scripts' );