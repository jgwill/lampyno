<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package republic
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'republic' ); ?></a>

<?php get_template_part('template-parts/topmenu'); ?>
<header itemscope itemtype="http://schema.org/WPHeader" id="masthead" class="site-header" role="banner">
 <div class="header-area">
	<div class="mylogo">
          <?php			
	if ( function_exists( 'the_custom_logo' )  ) {
				the_custom_logo();			 
			 }			
	if ( is_front_page() && is_home() ) : ?>
		<div class="site-branding">
			<h1 itemprop="headline" class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
	<?php else : ?>		
		<div class="site-branding">
			<p itemprop="headline" class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
	<?php endif; ?>	
                 </div>
          <div class="asidelogo">
                <?php if (!dynamic_sidebar('topareawid') ) : endif; ?>
            </div>
    </div>
	
	
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i> <?php esc_html_e( 'Menu', 'republic' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu-top-container' ) ); ?>
		</nav><!-- #site-navigation -->    
	</header><!-- #masthead -->
<?php if( get_theme_mod('hide_slider')==true){ echo wp_kses_post(republic_slider()); }?>
	<div id="content" class="site-content">
            <?php if (!dynamic_sidebar('belownavi-1') ) : endif; ?>
			
	<div class="large-12 columns belownavi">
	
	<?php if (get_theme_mod('hide_news_ticker') !='1') { echo wp_kses_post(republic_ticker()); }?>
            
        </div>
       
