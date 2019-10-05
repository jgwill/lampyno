<?php
get_header();
$archive_layout = esc_attr( get_theme_mod( 'blog_archive_layout', 'rights' ) );
?>
<div class="<?php if( $archive_layout == 'rights' ) { echo 'col-md-8'; } elseif( $archive_layout == 'lefts' ) { echo 'col-md-8 layoutleftsidebar'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >
		
		<?php if( is_archive() ) { ?>
		<div class="content-first postsloop">
			
			<div class="content-second">
				<h1 class="the-title"><?php the_archive_title(); ?></h1>
			</div>
				
			<?php the_archive_description( '<div class="content-third">', '</div>' ); ?>
				
		</div>
		<?php } ?>
		
		<?php if( is_search() ) { ?>
		<div class="content-first">
			
			<div class="content-second">
				<h1 class="the-title"><?php printf( __( 'Search Results for: %s', 'di-business' ), get_search_query() ); ?></h1>
			</div>
				
		</div>
		<?php } ?>
		
		
		<?php
		if( have_posts() ) {
			echo '<div class="dimasonry">';

			while( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'loop' );

			endwhile;

			echo '</div>';

			di_business_posts_pagination();

		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</div>
</div>
<?php if( $archive_layout == 'rights' || $archive_layout == 'lefts' ) { get_sidebar(); } ?>
<?php get_footer(); ?>
