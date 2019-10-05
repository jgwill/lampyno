<?php
/**
 * This template to displays woocommerce page
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */

get_header();
	$idyllic_settings = idyllic_get_theme_options();
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
			<?php woocommerce_content(); ?>
		</main><!-- end #main -->
	</div> <!-- #primary -->
<?php 
if( 'default' == $layout ) { //Settings from customizer
	if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')){ ?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php }
} 
	if( 'default' == $layout ) { //Settings from customizer
		if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')): ?>
		<?php dynamic_sidebar( 'idyllic_woocommerce_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	}
?>
</div><!-- end .wrap -->
<?php
get_footer();