<?php get_header(); ?>
<div class="col-md-8">
	<div class="left-content" >
		<div class="content-first single-posst">
		
			<div class="content-second">
				<h1 class="the-title"><?php esc_attr_e( 'Oops! That page can not be found.', 'di-business' ); ?></h1>
			</div>
			
			<div class="content-third">
				<p><?php esc_attr_e( 'It looks like nothing was found at this location. Maybe try a search?', 'di-business' ); ?></p>
				<br />
				<?php get_search_form(); ?>
			</div>
			
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
