<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package modulus
 */

get_header(); ?>
<div id="content" class="site-content">
		<div class="container">
		
	<?php do_action('modulus_two_sidebar_left'); ?>	

	<div id="primary" class="content-area <?php modulus_layout_class(); ?>  columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

		<?php 
			if(  get_theme_mod ('numeric_pagination',true) && function_exists( 'modulus_pagination' ) ) : 
					modulus_pagination();
				else :
					modulus_post_nav();     
				endif; 
		?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php do_action('modulus_two_sidebar_right'); ?>	
		
<?php get_footer(); ?>
