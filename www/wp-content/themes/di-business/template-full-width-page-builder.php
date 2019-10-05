<?php
/**
 * Template Name: Full Width for Page Builder
 *
 */
?>

<?php get_header( 'full-width-page-builder' ); ?>

<?php
if( get_post_meta( get_the_id(), '_di_business_show_breadcrumb', true ) == 1 )
{
	echo "<div class='row pdt20'>";
	di_business_breadcrumbs();
	echo "</div>";
}
?>

	<?php
	while( have_posts() ) : the_post();
		
		get_template_part( 'template-parts/content-page', 'full-width-page-builder' );

		comments_template();
		
	endwhile;
	?>

<?php get_footer( 'full-width-page-builder' ); ?>