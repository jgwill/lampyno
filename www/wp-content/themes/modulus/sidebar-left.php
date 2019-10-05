<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package modulus
 */


 $sidebar_position = get_theme_mod( 'sidebar_position', 'right' );  ?>
 
 <?php if ( is_page_template('template-twosidebar.php') || 'two-sidebar' == $sidebar_position || is_page_template('template-twosidebarleft.php') || is_page_template('template-twosidebarright.php') || 'two-sidebar-left' == $sidebar_position || 'two-sidebar-right' == $sidebar_position ) { ?>
      <div id="secondary" class="widget-area four columns" role="complementary">
 <?php	}else { ?>
        <div id="secondary" class="widget-area five columns" role="complementary">
	<?php } ?>

    <div class="left-sidebar">
		<?php if( is_active_sidebar( 'sidebar-left' ) &&  ( is_page_template('template-twosidebar.php') || 'two-sidebar' == $sidebar_position || is_page_template('template-twosidebarleft.php') || is_page_template('template-twosidebarright.php') || 'two-sidebar-left' == $sidebar_position || 'two-sidebar-right' == $sidebar_position )  ) {
				dynamic_sidebar( 'sidebar-left' );
		}else { ?>
            <aside id="search" class="widget widget_search">
			   <h4 class="widget-title"><?php _e( 'Search', 'modulus' ); ?></h4>
				<?php get_search_form(); ?>
			</aside>
<?php   } ?>
	</div>

</div><!-- #secondary -->
