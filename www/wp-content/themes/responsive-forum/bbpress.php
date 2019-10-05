<?php
get_header();
$bbpress_layout = get_theme_mod( 'bbpress_layout', 'fullw' );
?>
<div class="<?php if( $bbpress_layout == 'rights' ) { echo 'col-md-8'; } elseif( $bbpress_layout == 'lefts' ) { echo 'col-md-8 layoutleftsidebar'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >
	<?php
	while( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );
		
		comments_template();
		
	endwhile;
	?>

	</div>
</div>
<?php
if( $bbpress_layout == 'rights' || $bbpress_layout == 'lefts' ) { get_sidebar( 'bbpress' ); }
get_footer();
?>
