<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Photography_Blog
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
$global_layout = photography_blog_get_option('global_layout');
if ($global_layout == 'no-sidebar'){
    return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
