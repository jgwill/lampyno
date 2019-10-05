<?php
/**
 * @package modulus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
$single_featured_image = get_theme_mod( 'single_featured_image',true );
$single_featured_image_size = get_theme_mod ('single_featured_image_size','1');
if ( $single_featured_image ) :
	 if ( $single_featured_image_size == '1' ) :?>
	 		<div class="post-thumb">
	 <?php  if( has_post_thumbnail() && ! post_password_required() ) :   
				the_post_thumbnail('modulus-blog-large-width'); 
			
			endif;?>
			</div><?php
		 elseif( $single_featured_image_size == '2' ): ?>
		 	<div class="post-thumb"><?php
		 	if( has_post_thumbnail() && ! post_password_required() ) :   
					the_post_thumbnail('modulus-small-featured-image-width');
			
			endif;?>
			</div><?php
	endif; 
endif ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php if ( get_theme_mod('enable_single_post_top_meta',true ) ): ?>
		    <div class="entry-meta">
		    <?php if(function_exists('modulus_entry_top_meta') ) {
		         modulus_entry_top_meta();
		     } ?>
			</div><!-- .entry-meta -->
	<?php endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages: ', 'modulus' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

<?php if ( get_theme_mod('enable_single_post_bottom_meta', true ) ): ?>
	<footer class="entry-footer">
	<?php if(function_exists('modulus_entry_bottom_meta') ) {
		    modulus_entry_bottom_meta();
		} ?>
	</footer><!-- .entry-footer -->
<?php endif;?>

</article><!-- #post-## -->

	<?php modulus_post_nav(); ?>
	




