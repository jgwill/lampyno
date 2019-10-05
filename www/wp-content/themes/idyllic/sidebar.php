<?php
/**
 * The sidebar containing the main Sidebar area.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
	$idyllic_settings = idyllic_get_theme_options();
	global $idyllic_content_layout;
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'idyllic_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}

if( 'default' == $layout ) { //Settings from customizer
	if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')){ ?>

<aside id="secondary" class="widget-area" role="complementary">
<?php }
}else{ // for page/ post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
<aside id="secondary" class="widget-area" role="complementary">
  <?php }
	}?>
  <?php 
	if( 'default' == $layout ) { //Settings from customizer
		if(($idyllic_settings['idyllic_sidebar_layout_options'] != 'nosidebar') && ($idyllic_settings['idyllic_sidebar_layout_options'] != 'fullwidth')): ?>
  <?php dynamic_sidebar( 'idyllic_main_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	}else{ // for page/post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){
			dynamic_sidebar( 'idyllic_main_sidebar' );
			echo '</aside><!-- end #secondary -->';
		}
	}