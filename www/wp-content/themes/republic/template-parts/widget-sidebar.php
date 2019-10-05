<?php

/* 
 * This file contain code for republic widget.
 * 
 * @package republic
 */

 ?>


<ul class="tabs" data-tab role="tablist">
  <li class="tab-title active" role="presentational"><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1"><?php echo esc_attr(get_theme_mod("popular_widget_name","Popular Post")); ?></a></li>
  <li class="tab-title" role="presentational"><a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" controls="panel2-2"><?php echo esc_attr(get_theme_mod("recent_widget_name","Recent Post")); ?></a></li>
 </ul>
<div class="tabs-content">
  <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
 
 
	<?php 
		$republic_popularposts = array( 
			'ignore_sticky_posts' => true,
			'showposts' => esc_attr(get_theme_mod('republic_widget_range','5')),
			'orderby' => 'comment_count',
							);
		$the_query = new WP_Query( $republic_popularposts );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<div class="sidebarwidget1">
		<?php if ( has_post_thumbnail() ) {the_post_thumbnail('republic_themewidget');} else { ?>
            <img src="<?php echo esc_url(get_template_directory_uri().'/images/thumb.jpg');?>" width="65" height="65"/>
		<?php } ?> 
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
                <br /><div class="widgetinfo"><i class="fa fa-comments-o"></i><?php comments_number(); ?></div>
		<div class="clear"></div>
		</div>			
		<?php endwhile;  endif; wp_reset_postdata(); ?>

    
  </section>
  <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
	<?php 
		$republic_recentposts = array( 
			'ignore_sticky_posts' => true,
			'showposts' => esc_attr(get_theme_mod('republic_widget_range','5')),
			'orderby' => 'date',
							);
		$the_query = new WP_Query( $republic_recentposts );
		if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<div class="sidebarwidget1">
		<?php if ( has_post_thumbnail() ) {the_post_thumbnail('republic_themewidget');} else { ?>
			<img src="<?php echo esc_url(get_template_directory_uri().'/images/thumb.jpg');?>" width="65px" height="65px"/>
		<?php } ?> 
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
                <br /><div class="widgetinfo"><?php republic_posted_on(); ?></div>
		<div class="clear"></div>
		</div>			
		<?php endwhile;  endif;  wp_reset_postdata(); ?>
  </section>
</div>
