<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package modulus
 */

$sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
 if ( is_page_template('template-twosidebar.php') || 'two-sidebar' == $sidebar_position || is_page_template('template-twosidebarleft.php') || is_page_template('template-twosidebarright.php') || 'two-sidebar-left' == $sidebar_position || 'two-sidebar-right' == $sidebar_position ) { ?>
<div id="secondary" class="widget-area four columns" role="complementary">
 <?php	}else { ?>
        <div id="secondary" class="widget-area five columns" role="complementary">
	<?php } ?>
	<div class="left-sidebar">
<?php
		      do_action('modulus_before_sidebar_right_widget');
		      do_action('modulus_sidebar_right_widget');
		      do_action('modulus_after_sidebar_right_widget');
		?>

	</div>
</div><!-- #secondary -->

