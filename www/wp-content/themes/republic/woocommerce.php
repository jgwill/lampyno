<?php
/**
 * The template for displaying woocommerce products.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package republic
 */

get_header(); ?>

	<div id="primary" class="large-12 columns content-area">
		<main id="main" class="site-main" role="main">
		
			<?php woocommerce_content(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
