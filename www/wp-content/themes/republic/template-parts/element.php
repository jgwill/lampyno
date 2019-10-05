<!-----Element 2---->

<?php
$getcateid2 = get_theme_mod('republic_catechoose2'); 
 ?>
	<div class="large-12 column level two">
	<!---Title of Index Elements-->
		<span class="label front-label two">
			<a href="<?php echo esc_url( get_category_link( $getcateid2 ) ); ?>" title="<?php echo get_cat_name($getcateid2); ?>"><?php if($getcateid2){ echo get_cat_name($getcateid2); } else { echo 'Category 2'; } ?></a>
		</span>
		<a href="<?php echo esc_url( get_category_link( $getcateid2 ) ); ?>" class="viewposts" title="<?php echo get_cat_name($getcateid2); ?>"><?php _e('View all','republic'); ?> <i class="fa fa-caret-right"></i></a>
	</div>

<?php

	$showposts = 5; // actual results are twice this value
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$argsmm=array(
	  'posts_per_page' => $showposts,
	  'cat' => $getcateid2, 
	  'paged' => $paged,
	  'ignore_sticky_posts' => true,
	  'orderby' => 'post_date',
	  'order' => 'DESC',
	  'post_status' => 'publish',
	);

	$custom_query = new WP_Query($argsmm);
	$i = 0;
	while($custom_query->have_posts()) : $custom_query->the_post();
	
	if($i==0){ 
?>
	<div class="small-12 medium-6 large-6 columns bigleft">
<?php if ( get_theme_mod('comment_number' ) !='1') { echo '<div class="comment"><p>'; printf( _nx( '1', '%1$s', get_comments_number(), 'comments title', 'republic' ), number_format_i18n( get_comments_number() ) ); echo '<p></div>'; } if ( has_post_thumbnail() ) { ?>
	<a href="<?php esc_url(the_permalink());?>"><?php the_post_thumbnail('republic_indeximagebig'); ?></a>
<?php } else { ?>
	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_template_directory_uri() ); ?>/images/thumb.jpg" class="blog-post-img"></a>
<?php } ?>
	<h2><a title="<?php esc_attr(the_title()); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
	<?php esc_attr(the_title()); ?></a></h2>
	<div class="entry-meta">
	<?php republic_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php esc_html(the_excerpt()); ?>
	<div class="clear"></div>
<?php $i++; } else { ?>

<div class="large-6 columns rightpost">

<div class="large-12 columns">
<?php if ( has_post_thumbnail() ) { ?>
<a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('republic_indeximage'); ?></a>
<?php } else { ?>
<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_template_directory_uri() ); ?>/images/thumb.jpg" class="blog-post-img"></a>
<?php } ?>
<h2><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<div class="entry-meta"><span class="posted-on"><?php echo get_the_modified_date(); ?></span></div>

<div class="clear"></div></div>
<?php  } ?>  
</div>
<?php endwhile; ?>
<?php wp_reset_postdata();  ?>