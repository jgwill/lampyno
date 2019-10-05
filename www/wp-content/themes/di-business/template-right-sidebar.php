<?php
/**
 * Template Name: Page with Right Sidebar
 *
 */
?>

<?php get_header(); ?>

<?php
if( get_post_meta( get_the_id(), '_di_business_show_breadcrumb', true ) == 1 ) {
	di_business_breadcrumbs();
}
?>

<div class="col-md-8">
	<div class="left-content" >
	<?php
	while( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		
		comments_template();
		
	endwhile;
	?>

	</div>
</div>
<?php get_sidebar( 'page' ); ?>
<?php get_footer(); ?>



