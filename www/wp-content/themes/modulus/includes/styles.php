<?php

function modulus_custom_styles($custom) {
$custom = '';	

   /* Heder background image */
   $header_image = get_theme_mod('header_image') ;
    if( $header_image  ) {    		

        $bg_size = get_theme_mod('header_bg_size','auto');
        $bg_repeat = get_theme_mod('header_bg_repeat','repeat'); 
        $bg_attachment =  get_theme_mod('header_bg_attachment','scroll'); 
        $bg_position =   get_theme_mod('header_bg_position','left top'); 
        $bg_height = get_theme_mod('header_bg_height','150');  

        $custom .= ".header-image {  background-position: ". $bg_position. ";
				    background-repeat: ". $bg_repeat . ";  
				    background-size: ". $bg_size ." ;
				    min-height: ". $bg_height ."px;  
				    background-attachment : ". $bg_attachment .";
				    position: relative; }"."\n";
   }

   $header_bg_color = get_theme_mod('header_bg_color') ;
   if( $header_bg_color ) {   
     $bg_color =  get_theme_mod('header_bg_color','#ffffff');
     $custom .= ".header-image { background-color: ". $bg_color ."\n";
   }

	$sticky_header_position = get_theme_mod('sticky_header_position') ;
	if( $sticky_header_position == 'bottom') {
		$custom .= ".nav-wrap.sticky-nav {  top: auto!important;
			bottom:0%; }"."\n";	
		$custom .= ".nav-wrap.sticky-nav .nav-menu .sub-menu {  top: auto;
			bottom:100%; }"."\n";	
	}	

	   $page_title_bar = get_theme_mod('page_titlebar');
     switch ($page_title_bar) {
          case 2:
               $custom .= ".breadcrumb {
                    background-color: transparent;
                    background-image: none;
               }"."\n";
               $custom .= ".breadcrumb .breadcrumb-right,.breadcrumb .breadcrumb-left h4 {
                  color:#33363a;
            }"."\n";
               break;         
          case 3:
               $custom .= ".breadcrumb{
                    display: none;
               }"."\n";
               break;         
     }

     $page_title_bar_status = get_theme_mod('page_titlebar_text');
     if( $page_title_bar_status == 2 ) {
              $custom .= ".breadcrumb .breadcrumb-left h4 {
                    display: none;
               }"."\n";
     }

	//Output all the styles     
	wp_add_inline_style( 'modulus-style', $custom );	
}


add_action( 'wp_enqueue_scripts', 'modulus_custom_styles' );  
