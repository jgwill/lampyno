<div id="random-post">
<h4><?php _e('Random Posts','republic'); ?></h4>
<ul class="medium-block-grid-2 large-block-grid-2">
<?php 
	$args = array(
	'ignore_sticky_posts' => true,
	'showposts' => 4,
	'orderby' => 'rand'	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
?>
<li><div class="latest-post">
<div class="randomimg">
<a title="<?php esc_attr(the_title()); ?>" href="<?php esc_url(the_permalink()); ?>" rel="bookmark">
<?php if ( has_post_thumbnail() ) { ?>
<a href="<?php esc_url(the_permalink());?>" rel="bookmark"><?php the_post_thumbnail('republic_republicrandom'); ?></a>
<?php } else { ?>
<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_template_directory_uri() ); ?>/images/thumb.jpg" class="blog-post-img"></a>
<?php } ?>
</div>
<div class="randomdesc">
<a title="<?php esc_attr(the_title()); ?>" href="<?php esc_url(the_permalink()); ?>" rel="bookmark"><?php esc_attr(the_title()); ?></a>
<div class="desc"><?php esc_html(the_excerpt()); ?></div>
<?php endwhile; ?>
</div></li></ul>
<?php endif; ?>			 <?php wp_reset_postdata(); ?>

<div style="clear:both;">
</div>
</div>