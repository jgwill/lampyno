<?php
/**
 * Displays the header content
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php
$pixgraphy_settings = pixgraphy_get_theme_options(); ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php 
	if ( function_exists( 'wp_body_open' ) ) {

		wp_body_open();

	} ?>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content','pixgraphy');?></a>
<!-- Masthead ============================================= -->
<header id="masthead" class="site-header" role="banner">
		<div class="top-header" <?php if( get_header_image() != '' ){ ?>style="background-image:url('<?php echo esc_url(get_header_image()); ?>');" <?php } ?>>
			<div class="container clearfix">
				<?php
				if( is_active_sidebar( 'pixgraphy_header_info' )) {
					dynamic_sidebar( 'pixgraphy_header_info' );
				}
				if($pixgraphy_settings['pixgraphy_top_social_icons'] == 0):
					echo '<div class="header-social-block">';
						do_action('social_links');
					echo '</div>'.'<!-- end .header-social-block -->';
				endif;
				do_action('pixgraphy_site_branding'); ?>
			</div> <!-- end .container -->
		</div> <!-- end .top-header -->
		<?php
		$enable_slider = $pixgraphy_settings['pixgraphy_enable_slider'];
		pixgraphy_slider_value();
		if ($enable_slider=='frontpage'|| $enable_slider=='enitresite'){
			 if(is_front_page() && ($enable_slider=='frontpage') ) {
				if($pixgraphy_settings['pixgraphy_slider_type'] == 'default_slider') {
						pixgraphy_page_sliders();
				}else{
					if(class_exists('Pixgraphy_Plus_Features')):
						do_action('pixgraphy_image_sliders');
					endif;
				}
			}
			if($enable_slider=='enitresite'){
				if($pixgraphy_settings['pixgraphy_slider_type'] == 'default_slider') {
						pixgraphy_page_sliders();
				}else{
					if(class_exists('Pixgraphy_Plus_Features')):
						do_action('pixgraphy_image_sliders');
					endif;
				}
			}
		} ?>
		<!-- Main Header============================================= -->
				<div id="sticky_header">
					<div class="container clearfix">
						<!-- Main Nav ============================================= -->
						<?php
							if (has_nav_menu('primary')) { ?>
						<?php $args = array(
							'theme_location' => 'primary',
							'container'      => '',
							'items_wrap'     => '<ul id="primary-menu" class="menu nav-menu">%3$s</ul>',
							); ?>
						<nav id="site-navigation" class="main-navigation clearfix" role="navigation" aria-label="<?php esc_attr_e('Main Menu','pixgraphy');?>">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<span class="line-one"></span>
					  			<span class="line-two"></span>
					  			<span class="line-three"></span>
						  	</button>
							<?php wp_nav_menu($args);//extract the content from apperance-> nav menu ?>
						</nav> <!-- end #site-navigation -->
						<?php } else {// extract the content from page menu only ?>
						<nav id="site-navigation" class="main-navigation clearfix" role="navigation" aria-label="<?php esc_attr_e('Main Menu','pixgraphy');?>">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<span class="line-one"></span>
					  			<span class="line-two"></span>
					  			<span class="line-three"></span>
						  	</button>
							<?php	wp_page_menu(array('menu_class' => 'menu', 'items_wrap'     => '<ul id="primary-menu" class="menu nav-menu">%3$s</ul>')); ?>
						</nav> <!-- end #site-navigation -->
						<?php }
						$search_form = $pixgraphy_settings['pixgraphy_search_custom_header'];
						if (1 != $search_form) { ?>
							<button id="search-toggle" class="header-search"></button>
							<div id="search-box" class="clearfix">
								<?php get_search_form();?>
							</div>  <!-- end #search-box -->
						<?php } 

			echo '</div> <!-- end .container -->
			</div> <!-- end #sticky_header -->';
	?>
</header> <!-- end #masthead -->
<!-- Main Page Start ============================================= -->
<div id="content">
<?php if($pixgraphy_settings['pixgraphy_photography_layout'] == 'photography_layout' && !is_page() && !is_single()){
	if( is_404()  || is_search() || is_archive()):
		if($pixgraphy_settings['pixgraphy_photography_layout'] == 'photography_layout'){
			if (class_exists ('WooCommerce') && (is_shop () || is_product_category () || is_product_tag ())) { ?>
			<div class="container clearfix">
			<?php }else{
				if(is_404()){ ?>
				<div class="container clearfix">
				<?php }
				// silence is golden
			}
		}else{ ?>
	 	<div class="container clearfix">
		<?php }
	else: ?> 		
	<main id="main" role="main">
	<?php endif;
}else{ ?>
<div class="container clearfix">
<?php }
if(is_home() ){
// silence is golden;
}else{
	if(is_category() || is_tag() || is_author()|| has_post_format() || is_archive()){
		if($pixgraphy_settings['pixgraphy_photography_layout'] == 'photography_layout'){
			//silence is golder?>
		<?php }
	}else{ 
	$custom_page_title = apply_filters( 'pixgraphy_filter_title', '' );?>
	<div class="page-header">
		<?php if ( is_front_page()) : ?>
			<h2 class="page-title"><?php echo esc_html($custom_page_title); ?></h2>
			<!-- .page-title -->
		<?php else : ?>
			<h1 class="page-title"><?php echo esc_html($custom_page_title); ?></h1>
			<!-- .page-title -->
		<?php endif; ?>
		<?php pixgraphy_breadcrumb(); ?>
		<!-- .breadcrumb -->
	</div>
	<!-- .page-header -->
	<?php }
}