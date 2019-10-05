<?php
/**
 * Displays the header content
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php
$idyllic_settings = idyllic_get_theme_options();
$idyllic_header_design_layout = $idyllic_settings['idyllic_header_design_layout']; ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif;
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php 
	if ( function_exists( 'wp_body_open' ) ) {

		wp_body_open();

	} ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#site-content-contain"><?php esc_html_e('Skip to content','idyllic');?></a>
<!-- Masthead ============================================= -->
<header id="masthead" class="site-header <?php if($idyllic_header_design_layout=='header-item-one'): echo esc_attr('header-text-light'); endif;?>" role="banner">
	<div class="header-wrap">
			<?php the_custom_header_markup(); ?>
		<!-- Top Header============================================= -->
		<div class="top-header">
			<?php if(is_active_sidebar( 'idyllic_header_info' ) || has_nav_menu( 'social-link' )): ?>
			<div class="top-bar">
				<div class="wrap">
					<?php
					if( is_active_sidebar( 'idyllic_header_info' )) {
						dynamic_sidebar( 'idyllic_header_info' );
					}
					if($idyllic_settings['idyllic_top_social_icons'] == 0):
						echo '<div class="header-social-block">';
							do_action('idyllic_social_links');
						echo '</div>'.'<!-- end .header-social-block -->';
					endif; ?>
				</div><!-- end .wrap -->
			</div><!-- end .top-bar -->
			<?php endif; ?>

			<!-- Main Header============================================= -->
			<div id="sticky-header" class="clearfix">
				<div class="wrap">
					<div class="main-header clearfix">

						<!-- Main Nav ============================================= -->
						<?php do_action('idyllic_site_branding'); //<!-- end .custom-logo-link --> 
						if($idyllic_settings['idyllic_disable_main_menu']==0){ ?>
							<nav id="site-navigation" class="main-navigation clearfix" role="navigation" aria-label="<?php esc_attr_e('Main Menu','idyllic');?>">
							<?php if (has_nav_menu('primary')) {
								$args = array(
								'theme_location' => 'primary',
								'container'      => '',
								'items_wrap'     => '<ul id="primary-menu" class="menu nav-menu">%3$s</ul>',
								); ?>
							
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
									<span class="line-bar"></span>
								</button><!-- end .menu-toggle -->
								<?php wp_nav_menu($args);//extract the content from apperance-> nav menu
								} else {// extract the content from page menu only ?>
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
									<span class="line-bar"></span>
								</button><!-- end .menu-toggle -->
								<?php	wp_page_menu(array('menu_class' => 'menu', 'items_wrap'     => '<ul id="primary-menu" class="menu nav-menu">%3$s</ul>'));
								} ?>
							</nav> <!-- end #site-navigation -->
						<?php }
						 $search_form = $idyllic_settings['idyllic_search_custom_header'];
						if (1 != $search_form) { ?>
							<button id="search-toggle" class="header-search" type="button"></button>
							<div id="search-box" class="clearfix">
								<?php get_search_form();?>
							</div>  <!-- end #search-box -->
						<?php }
						$idyllic_side_menu = $idyllic_settings['idyllic_side_menu'];
						if(1 != $idyllic_side_menu){ 
							if (has_nav_menu('side-nav-menu') || (has_nav_menu( 'social-link' ) && $idyllic_settings['idyllic_side_menu_social_icons'] == 0 ) || is_active_sidebar( 'idyllic_side_menu' )):?>
								<button class="show-menu-toggle" type="button">			
									<span class="sn-text"><?php _e('Menu Button','idyllic'); ?></span>
									<span class="bars"></span>
							  	</button>
					  	<?php endif;
					  	} ?>
					</div><!-- end .main-header -->
				</div> <!-- end .wrap -->
			</div><!-- end #sticky-header -->

		</div><!-- end .top-header -->
		<?php if(1 != $idyllic_side_menu){
			if (has_nav_menu('side-nav-menu') || (has_nav_menu( 'social-link' ) && $idyllic_settings['idyllic_side_menu_social_icons'] == 0 ) || is_active_sidebar( 'idyllic_side_menu' )): ?>
				<aside class="side-menu-wrap">
				  	<div class="side-menu">
				  		<button class="hide-menu-toggle" type="button">
							<span class="bars"></span>
					  	</button>
						<?php if (has_nav_menu('side-nav-menu')) {
							$args = array(
								'theme_location' => 'side-nav-menu',
								'container'      => '',
								'items_wrap'     => '<ul class="side-menu-list">%3$s</ul>',
								); ?>
						<nav class="side-nav-wrap" role="navigation" aria-label="<?php esc_attr_e('Sidebar Menu','idyllic');?>">
							<?php wp_nav_menu($args); ?>
						</nav><!-- end .side-nav-wrap -->
						<?php }
						if($idyllic_settings['idyllic_side_menu_social_icons'] == 0):
							do_action('idyllic_social_links');
						endif;

						if( is_active_sidebar( 'idyllic_side_menu' )) {
							echo '<div class="side-widget-tray">';
								dynamic_sidebar( 'idyllic_side_menu' );
							echo '</div> <!-- end .side-widget-tray -->';
						} ?>
					</div><!-- end .side-menu -->
				</aside><!-- end .side-menu-wrap -->
		<?php endif;
		} ?>
	</div><!-- end .header-wrap -->
	<!-- Main Slider ============================================= -->
	<?php
		$enable_slider = $idyllic_settings['idyllic_enable_slider'];
		if ($enable_slider=='frontpage'|| $enable_slider=='enitresite'){
			 if(is_front_page() && ($enable_slider=='frontpage') ) {

			 	do_action('idyllic_extra_sliders_hook');

				if($idyllic_settings['idyllic_slider_type'] == 'default_slider') {
						idyllic_category_sliders();
				}else{
					if(class_exists('Idyllic_Plus_Features')):
						do_action('idyllic_image_sliders');
					endif;
				}
			}
			if($enable_slider=='enitresite'){

				do_action('idyllic_extra_sliders_hook');

				if($idyllic_settings['idyllic_slider_type'] == 'default_slider') {
						idyllic_category_sliders();
				}else{
					if(class_exists('Idyllic_Plus_Features')):
						do_action('idyllic_image_sliders');
					endif;
				}
			}
		} ?>
</header> <!-- end #masthead -->
<?php
$idyllic_display_page_single_featured_image = $idyllic_settings['idyllic_display_page_single_featured_image'];
if(is_single() || is_page()){
		if(has_post_thumbnail() && $idyllic_display_page_single_featured_image == 0 ){?>
<!-- Single post and Page image ============================================= -->
		<div class="single-featured-image-header"><?php the_post_thumbnail(); ?></div>
		<?php }
} ?>
<!-- Main Page Start ============================================= -->
<div id="site-content-contain" class="site-content-contain">
	<div id="content" class="site-content">
