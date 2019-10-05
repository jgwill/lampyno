<?php
if(! function_exists('modulus_footer_credits') ) {
	function modulus_footer_credits() { 
		printf( '<p> %1$s <a href="%2$s" target="_blank"> %3$s</a> %4$s <a href="%5$s" target="_blank" rel="designer">%6$s</a></p>', __('Powered by','modulus'), esc_url( 'http://wordpress.org/'), __('WordPress.','modulus'), __('Theme: Modulus by','modulus'), esc_url('http://www.webulousthemes.com/'), __('Webulous Themes','modulus')) ;
    }  
}
					 
add_action('modulus_credits','modulus_footer_credits');

/* MORE TEXT VALUE */

add_filter( 'the_content_more_link','modulus_more_text_value');   
if(! function_exists('modulus_more_text_value') ) {
	function modulus_more_text_value( ) {
		$more_text = get_theme_mod('more_text');
		if( $more_text && !empty( $more_text ) ) {
			$more_link_text = sprintf(__('%1$s','modulus'), $more_text );
		}else{
			$more_link_text = __('Read More','modulus');
		}
		return '<p class="portfolio-readmore"><a class="btn btn-mini more-link" href="' . get_permalink() . '">'.$more_link_text.'</a></p>';
	} 
}

/**
 * Configuration sample for the Kirki Customizer.
 * The function's argument is an array of existing config values
 * The function returns the array with the addition of our own arguments
 * and then that result is used in the kirki/config filter
 *
 * @param $config the configuration array
 *
 * @return array
 */

function modulus_demo_configuration_sample_styling( $config ) {
	return wp_parse_args( array(
		'color_accent' => '#03a9f4',
		'color_back'   => '#FFFFFF',
		'width'   => '320px',
	), $config );
}
add_filter( 'kirki/config', 'modulus_demo_configuration_sample_styling' );    

add_action('modulus_blog_layout_class_wrapper_before','modulus_blog_layout_wrapper_class_before');
if(! function_exists('modulus_blog_layout_wrapper_class_before') ) {

	function modulus_blog_layout_wrapper_class_before() {
		$blog_layout = get_theme_mod('blog_layout',1);
		switch ( $blog_layout ) {
			case 2: ?>
				<div class="eight columns blog-box two-col-blog">	
	<?php	break;
	        case 3: ?>
			    <div class="one-third column blog-box">
	<?php	break;
	        case 4: ?>
			    <div class="eight columns masonry-post blog-box">
	<?php	break;
			case 5: ?>  
			   <div class="one-third column masonry-post blog-box">	
	<?php	break;

		}
	}
}
   
add_action('modulus_blog_layout_class_wrapper_after','modulus_blog_layout_class_wrapper_after');
if(! function_exists('modulus_blog_layout_class_wrapper_after') ) {
	function modulus_blog_layout_class_wrapper_after() {
	    $blog_layout = get_theme_mod('blog_layout',1 );
		   if(  isset( $blog_layout ) && $blog_layout  > 1 ) { ?>
	          </div>
	<?php	}
	}
}

add_action('wp_head', 'modulus_masonry_custom_js');
if(! function_exists('modulus_masonry_custom_js') ) {

	function modulus_masonry_custom_js() {

	  if( get_theme_mod('blog_layout',1) == 4 || get_theme_mod('blog_layout',1) == 5 ) { ?>

	    <script type="text/javascript">
		    jQuery(document).ready( function($) {
				  $('.masonry-blog-content').imagesLoaded(function () {
			            $('.masonry-blog-content').masonry({
			                itemSelector: '.masonry-post',
			                gutter: 0,
			                transitionDuration: 0,
			            }).masonry('reloadItems');
			      });
		    });
	    </script> 

<?php }
	}
}

add_action('modulus_before_header','modulus_before_header_video');
if(!function_exists('modulus_before_header_video')){
	function modulus_before_header_video() {
		 if(function_exists('the_custom_header_markup') ) { ?>
		    <div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>
	    <?php } 
	}
}