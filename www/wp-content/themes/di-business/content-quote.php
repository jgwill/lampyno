<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix single-posst'); ?>>
	<div class="content-first" itemscope itemtype="http://schema.org/CreativeWork">
		
		<div class="content-second">
			<h1 class="the-title entry-title" itemprop="headline"><?php the_title(); ?></h1>
		</div>
				
		<div class="content-third">
		
			<?php
			if( get_theme_mod( 'post_meta_disply', '1' ) == 1 ) {
				di_business_entry_meta();
			}
			?>

			<div class="entry-content" itemprop="text">
					
				<?php
				if( get_theme_mod( 'single_post_thumbnail', '1' ) == '1' ) {
					di_business_post_thumbnail();
				}
				?>
					
				<?php the_content(); ?>
					
				<div class="clearfix pdt20"></div>
					
				<?php
				wp_link_pages( array(
						'before'           => '<p class="pagelinks">' . __( 'Pages:', 'di-business' ),
						'after'            => '</p>',
						'link_before'      => '<span class="pagelinksa">',
						'link_after'       => '</span>',
						)
				);
				?>
					
				<?php
				if( get_theme_mod( 'post_tags_disply', '1' ) == '1' ) { 
					if( has_tag() ) { ?>
						<div class="singletags"><?php the_tags( '', ' ', '' ); ?></div>
				<?php
					}
				}
				?>
					
			</div>
			
		</div>
		
	</div>
</div>
