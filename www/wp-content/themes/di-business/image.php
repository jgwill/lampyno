<?php get_header(); ?>

<div class="col-md-8">
	<div class="left-content" >
		
		<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div <?php post_class('clearfix single-posst'); ?>>
			<div class="content-first">
			
				<div class="content-second">
					<h1 class="the-title entry-title" id="post-<?php the_ID(); ?>" ><?php the_title(); ?></h1>
				</div>
				
				<div class="content-third">
					<div class="entry-content">
						<div class="entry-attachment">
						<?php echo wp_get_attachment_image( get_the_ID(), 'full', "", array() );  ?>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif;  ?> 

	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>