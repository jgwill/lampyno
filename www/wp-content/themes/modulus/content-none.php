
<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package modulus
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'modulus' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf('%1$s <a href="%2$s">%3$s</a>',__('Ready to publish your first post?','modulus'),esc_url( admin_url( 'post-new.php' ) ), __('Get Started Here','modulus'));?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'modulus' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'modulus' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
