<?php
/**
 * Template Name: Landing Page for Page Builder
 *
 */
?>

<?php get_header( 'landing-page' ); ?>

	<?php
	while( have_posts() ) : the_post();
		
		get_template_part( 'template-parts/content-page', 'landing-page' );

		comments_template();
		
	endwhile;
	?>
	
<?php get_footer( 'landing-page' ); ?>
