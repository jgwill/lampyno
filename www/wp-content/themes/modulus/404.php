<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package modulus
 */

get_header(); ?>
<div id="content" class="site-content">
		<div class="container">

	<div id="primary" class="content-area eleven columns">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'modulus' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'modulus' ); ?></p>

					<?php get_search_form(); ?>

					
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
