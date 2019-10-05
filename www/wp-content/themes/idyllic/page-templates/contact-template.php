<?php
/**
 * Template Name: Contact Template
 *
 * Displays the contact page template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
get_header();
	global $idyllic_settings;
	$idyllic_settings = wp_parse_args(  get_option( 'idyllic_theme_options', array() ),  idyllic_get_option_defaults_values() );
	global $idyllic_content_layout;
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'idyllic_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	} ?>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php the_title();?></h1>
			<!-- .page-title -->
			<?php idyllic_breadcrumb(); ?><!-- .breadcrumb -->
		</header><!-- .page-header -->
		<?php
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				if('' != get_the_content()) : ?>
		<div class="googlemaps_widget">
			<div class="maps-container">
				<?php if ( is_active_sidebar( 'idyllic_form_for_contact_page' ) ) :
				dynamic_sidebar( 'idyllic_form_for_contact_page' );
			endif;  ?>
			</div>
		</div> <!-- end .googlemaps_widget -->
		<?php endif; ?>
			<div class="entry-content clearfix">
			<?php 
			the_content();
			comments_template();
				}
			}
			else { ?>
			<h2 class="entry-title"> <?php esc_html_e( 'No Posts Found.', 'idyllic' ); ?> </h2>
			<?php
			} ?>
			</div> <!-- end #entry-content -->
		</main> <!-- end #main -->
	</div> <!-- #primary -->
	<?php 
	if( 'default' == $layout ) { //Settings from customizer
		if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')){ ?>
	<aside id="secondary" class="widget-area" role="complementary">
	<?php }
	}else{ // for page/ post
			if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<?php }
		}
		if ( is_active_sidebar( 'idyllic_contact_page_sidebar' ) ) :
			dynamic_sidebar( 'idyllic_contact_page_sidebar' );
		endif;?>
		<?php 
		if( 'default' == $layout ) { //Settings from customizer
			if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')): ?>
	</aside><!-- end #secondary -->
	<?php endif;
		}else{ // for page/post
			if(($layout != 'no-sidebar') && ($layout != 'full-width')){
				echo '</aside><!-- end #secondary -->';
			} 
		} ?>
</div><!-- end .wrap -->
<?php
get_footer();