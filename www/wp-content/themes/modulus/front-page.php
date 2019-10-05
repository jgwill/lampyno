<?php
/**
 * The front page template file.
 *
 *
 * @package modulus
 */
if ( 'posts' == get_option( 'show_on_front' ) ) { 
	   get_template_part('home');
	} else {

	
get_header(); 
	if ( get_theme_mod('page-builder' ) ) {     
		if( get_theme_mod('flexslider') ) {   
			echo do_shortcode( get_theme_mod('flexslider') );
		} ?>

		<div id="content" class="site-content container">
			<?php  if( get_theme_mod('home_sidebar',false ) ) { ?>
				<div id="primary" class="content-area eleven columns">
			<?php }else { ?>
			    <div id="primary" class="content-area sixteen columns">
			<?php } ?>
				<main id="main" class="site-main" role="main">
					<?php
						while ( have_posts() ) : the_post();       
							the_content();
						endwhile;
					?>
					
			     </main><!-- #main -->
		    </div><!-- #primary -->
<?php	} else {
	
		
		$home_slider = get_theme_mod('enable_slider',true); 
			if($home_slider) {
                get_template_part('category-slider');
			}		
		?>

	<div id="content" class="site-content free-home <?php modulus_free_home_container(); ?>">	

	<div id="primary" class="content-area <?php modulus_free_home_primary(); ?>">
		<main id="main" class="site-main" role="main">
			<?php do_action('modulus_service_content_before'); ?>
	<?php if( get_theme_mod('enable_service',true ) ) {  ?>
			<div class="container">	
		
		<?php
			   do_action('service_content_before');  
      
			$service = get_theme_mod('service_count',3 );
		    $service_pages = array();
		    for ( $i = 1 ; $i <= $service ; $i++ ) {
				$service_page = absint(get_theme_mod('service_'.$i));
				if( $service_page ){
                    $service_pages[] = $service_page;
				}
		    }

			if( $service_pages && !empty( $service_pages ) ) {
				$args = array(
					'post_type' => 'page',
					'post__in' => $service_pages,
					'posts_per_page' => -1 ,
					'orderby' => 'post__in'
				);

				$query = new WP_Query($args);
				if( $query->have_posts()) : ?>
					<div class="services-wrapper row">
						<h1 class="title-divider"><?php echo apply_filters('modulus_service_title', __('Our Services','modulus') ); ?></h1>
						<?php while($query->have_posts()) :
								$query->the_post(); ?>
								    <div class="one-third service column">
								    	<?php if( has_post_thumbnail() ) : ?>
								    		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail('modulus-recent_page_img'); ?></a>
								    	<?php endif; ?>
								    	<div class="service-content">
								    	    <?php the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
									    	<?php the_content(); ?>
								    	</div>
								    </div>
						<?php endwhile; ?>
					</div>

				<?php endif; ?>   
				<?php  
					$query = null;
					$args = null;
					wp_reset_postdata(); 
			} 	else {?>
				<div class="services-wrapper row">
					<h1 class="title-divider"><?php _e('Our Services','modulus');?></h1>
					 <div class="one-third service column">
					     <?php echo '<img width="150" height="150" src="' . get_stylesheet_directory_uri() . '/images/page1.png" alt="" >';?>	
						  <div class="service-content">
							  <h4><?php _e('Service Section #1','modulus');?></h4>
					 	      <p><?php _e('You haven\'t created any service page yet. Create Page. Go to Customizer and click Home => Service Section => #1 and select page from  dropdown page list.','modulus');?></p>
						  </div>
					</div>
					<div class="one-third service column">
					<?php echo '<img width="150" height="150" src="' . get_stylesheet_directory_uri() . '/images/page2.png" alt="" >';?>	
						  <div class="service-content">
							  <h4><?php _e('Service Section #2','modulus');?></h4>
					 	      <p><?php _e('You haven\'t created any service page yet. Create Page. Go to Customizer and click Home => Service Section => #2 and select page from  dropdown page list.','modulus');?></p>
						  </div>
					</div>
					<div class="one-third service column">
					    <?php echo '<img width="150" height="150" src="' . get_stylesheet_directory_uri() . '/images/page3.png" alt="" >';?>	
						  <div class="service-content">
							  <h4><?php _e('Service Section #3','modulus');?></h4>
					 	      <p><?php _e('You haven\'t created any service page yet. Create Page. Go to Customizer and click Home => Service Section => #3 and select page from  dropdown page list.','modulus');?></p>
						  </div>
					</div>
				</div>

	<?php	} ?>
	</div><?php
        } 


		do_action('service_content_after');
	
	    do_action('recent_post_before'); 

		modulus_recent_posts(); 

	    do_action('recent_post_after');

	    if( get_theme_mod('enable_home_default_content',false ) ) {  ?>
			<div class="container default-home-page">
				<?php
					while ( have_posts() ) : the_post();       
						the_content();
					endwhile;
				?>
	         </div><?php
        } ?>
		</main><!-- #main -->
	</div><!-- #primary --> 

<?php    
}
if( get_theme_mod('home_sidebar',false ) ) { 
   get_sidebar();
}
get_footer();  
}
?>