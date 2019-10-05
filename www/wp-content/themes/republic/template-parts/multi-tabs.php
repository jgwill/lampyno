<?php

/**
 * The multi-tab containing the front page area.
 *
 * @package republic
 */
?>

<div class="medium-8 large-8 column">
<?php do_action('front_page_column1'); ?>
<?php if (get_theme_mod("republic_catehidelatest")!='1') { ?>
<div class="large-12 column level blog">
	<!---Title of Index Elements-->
		<span class="label front-label blog">
			<?php echo esc_attr(get_theme_mod('blog_front_name','Latest Posts')); ?>
		</span>
	</div>
 <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3 latest-post">

<?php
     $republic_args = array( 
    'ignore_sticky_posts' => true,
    'showposts' => esc_attr(get_theme_mod('republic_latestpost_range','6')),
    'orderby' => 'date',  );
    $the_query = new WP_Query( $republic_args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();
     echo '<li>';
	 if ( get_theme_mod('comment_number' ) !='1') { echo '<div class="comment"><p>'; printf( esc_html(_nx( '1', '%1$s', get_comments_number(), 'comments title', 'republic' )), number_format_i18n( get_comments_number() ) ); echo '<p></div>'; } 
    if ( has_post_thumbnail() ) {
    echo '<a href="';
     the_permalink();
     echo '">';
    the_post_thumbnail('republic_latestthumbimg');
    echo '</a>';
    }
    else {
  
    echo'<a href="';
    the_permalink();
    echo '"><img src="';
    echo esc_url(get_template_directory_uri() ); 
    echo '/images/220thumb.jpg" class="blog-post-img"></a>';
    }
    echo '<h2><a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a></h2>';

    echo '<div class="clear"></div></li>';
    endwhile; endif; wp_reset_postdata(); 
 
  
  ?>  
</ul>
<?php }
	 if (get_theme_mod("republic_catehide1")!='1') { get_template_part( 'template-parts/element1' ); }
	 if (get_theme_mod("republic_catehide2")!='1') {  get_template_part( 'template-parts/element' ); }
	if (get_theme_mod("republic_catehide3")!='1') {  get_template_part( 'template-parts/element2' ); }
?>
</div>
<?php get_sidebar(); ?>