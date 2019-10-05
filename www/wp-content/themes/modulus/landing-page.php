<?php
/**
 * Template Name: Landing Page 
 *
 * @package modulus
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>  
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
  
<body <?php body_class(); ?>>  
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'modulus' ); ?></a>
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
	    </div><!-- .row -->
	</div>
</div>
<?php wp_footer(); ?>

</body>
</html>
