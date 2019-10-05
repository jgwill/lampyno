<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<div class="content-first">
	
		<div class="entry-content" itemprop="text">
			<?php the_content(); ?>
		</div>
					
		<?php
		wp_link_pages( array(
			'before'           => '<p class="pagelinks">' . __( 'Pages:', 'di-business' ),
			'after'            => '</p>',
			'link_before'      => '<span class="pagelinksa">',
			'link_after'       => '</span>',
		) );
		?>

	</div>
</div>
