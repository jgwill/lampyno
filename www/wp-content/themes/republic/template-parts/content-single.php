<?php
/**
 * @package republic
 */
?>
<?php republic_breadcrumbs(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php republic_posted_on(); ?>
			<?php if (get_theme_mod('republic_sharelink' ) !='1' ){ republic_close_summary_div(); }?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<div id="singlead"> <?php if (!dynamic_sidebar('singlepostwid') ) : endif; ?></div>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'republic' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php republic_entry_footer(); 	?>
		
		</footer><!-- .entry-footer -->
<div class="author-bio">
<ul class="medium-block-grid-1">
<li>
<div class="large-2 columns"><?php  echo get_avatar( get_the_author_meta('ID'), 120 ); ?></div>
<div class="large-10 columns">
<div class="author-title"> <?php esc_attr('Article By :', 'republic'); ?> <?php the_author_posts_link(); ?></div>
	<?php echo esc_html(the_author_meta('description')); ?>
	<div class="author-meta">
	 
	 <?php if( get_the_author_meta('url')): ?>
	 <a href="<?php esc_url(the_author_meta('url')); ?>"><i class="fa fa-globe"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('facebook')): ?>
	  <a href="<?php esc_url(the_author_meta('facebook')); ?>"><i class="fa fa-facebook-official"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('youtube')): ?>
	 <a href="<?php esc_url(the_author_meta('youtube')); ?>"><i class="fa fa-youtube-square"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('twitter')): ?>
	 <a href="<?php esc_url(the_author_meta('twitter')); ?>"><i class="fa fa-twitter-square"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('pinterest')): ?>
	 <a href="<?php esc_url(the_author_meta('pinterest')); ?>"><i class="fa fa-pinterest-square"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('googleplus')): ?>
	 <a href="<?php esc_url(the_author_meta('googleplus')); ?>"><i class="fa fa-google-plus-square"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('instagram')): ?>
	 <a href=<?php esc_url(the_author_meta('instagram')); ?>"><i class="fa fa-instagram"></i></a>
	 <?php else : endif; ?>
	 <?php if( get_the_author_meta('rss')): ?>
	 <a href="<?php esc_url(the_author_meta('rss')); ?>"><i class="fa fa-rss-square"></i></a>
	 <?php else : endif; ?>
	</div>
</div></li></ul></div>
	<?php if ( get_theme_mod('republic_randompost' ) !='1') { get_template_part('/template-parts/random-posts');} ?>
	   
</article><!-- #post-## -->
