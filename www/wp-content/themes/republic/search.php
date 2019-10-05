<?php
/**
 * The template for displaying search results pages.
 *
 * @package republic
 */

get_header(); ?>

	<section id="primary" class="medium-8 large-8 columns content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'republic' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->
<ul class="large-block-grid-3">
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
<li>
				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>

</li>
			<?php endwhile; ?>
			<?php republic_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>
</ul>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
