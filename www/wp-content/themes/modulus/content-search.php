<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package modulus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	<div class="title-meta">
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<span class="date-structure">				
					<span class="dd"><?php the_time('j M Y'); ?></span>
				</span>
				
			</div><!-- .entry-meta -->
			<?php endif; ?>
	</div>
		<br class="clear">
</header><!-- .entry-header -->

	<div class="entry-summary">    
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
<!--<?php if ( 'post' == get_post_type() ): ?>-->
	<footer class="entry-footer">     
		<?php modulus_entry_footer(); ?>   
	</footer><!-- .entry-footer -->
<?php endif;?>

</article><!-- #post-## -->
