<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package republic
 */

get_header(); ?>

	<div id="primary" class="medium-8 large-8 columns content-area">
		<main id="main" class="site-main" role="main">
<?php get_template_part( 'template-parts/content-none', '404' ); ?>
			

		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
