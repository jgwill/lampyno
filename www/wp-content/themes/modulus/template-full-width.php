<?php
/**
 * Template Name:  Full Width Template
 *
 * @package modulus
 */

get_header(); 


get_template_part( 'breadcrumb' ); ?>

	<?php do_action('modulus_before_content'); ?>
	<?php do_action('modulus_single_page_flexslider_featured_image'); ?>	
	<div id="content" class="site-content">
		<div class="container">

		<div id="primary" class="content-area sixteen columns">

			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>    

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->


<?php get_footer(); ?>
