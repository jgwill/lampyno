<?php

/**
 * The Author template for our theme.
 *
 *
 * @package republic
 */
get_header(); ?>

<div id="primary" class="medium-8 large-8 columns content-area">
		<main id="main" class="site-main" role="main">

<!-- This sets the $curauth variable -->
<div class="author-bio">
<ul class="medium-block-grid-1">
<li>

    <?php 
    
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
     echo '<div class="large-2 columns">'; echo get_avatar( get_the_author_meta( 'ID' ), 96 ); echo '</div>';
	 echo '<div class="large-10 columns">';
	 echo '<h2>'; esc_attr('About: ','republic');  
     echo esc_attr($curauth->nickname); echo '</h2>';
    
     if($curauth->first_name){echo '('.esc_attr($curauth->first_name) .' '. esc_attr($curauth->last_name).')';}
     if($curauth->description) { echo '</p>'.esc_html($curauth->description);}
	 echo '<div class="author-meta">'; 
if($curauth->user_url) { echo '<a href="'.esc_url($curauth->user_url).'"><i class="fa fa-globe"></i></a>';} 
if($curauth->facebook) { echo '<a href="'.esc_url($curauth->facebook).'"><i class="fa fa-facebook-official"></i></a>';}
if($curauth->youtube) { echo '<a href="'.esc_url($curauth->youtube).'"><i class="fa fa-youtube-square"></i></a>';}
if($curauth->twitter) { echo '<a href="'.esc_url($curauth->twitter).'"><i class="fa fa-twitter-square"></i></a>';}
if($curauth->pinterest) { echo '<a href="'.esc_url($curauth->pinterest).'"><i class="fa fa-pinterest-square"></i></a>';}
if($curauth->googleplus) { echo '<a href="'.esc_url($curauth->googleplus).'"><i class="fa fa-google-plus-square"></i></a>';}
if($curauth->instagram) { echo '<a href="'.esc_url($curauth->instagram).'"><i class="fa fa-instagram"></i></a>';}
if($curauth->rss) { echo '<a href="'.esc_url($curauth->rss).'"><i class="fa fa-rss-square"></i></a>';}

	 echo '</div></div>';
        
 ?>
<!-- The Loop -->
</li></ul>
</div>
  <h2><?php esc_attr('Posts by','republic'); ?> <?php echo esc_attr($curauth->nickname); ?>:</h2>
  <ul class="large-block-grid-3">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<li>
        <?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>
</li>
    <?php endwhile; 
	
 republic_paging_nav(); 
	else: ?>
        <p><?php esc_attr('No posts by this author.','republic'); ?></p>

    <?php endif; ?>
</ul>
<!-- End Loop -->
                </main>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>