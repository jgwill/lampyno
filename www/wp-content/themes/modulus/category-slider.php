<?php
/**
 * The template for displaying category-slider 
 *
 * display slider
 *
 * @package modulus
 */

$modulus_slider_cat = get_theme_mod( 'slider_cat', '' );
$modulus_slider_count = get_theme_mod( 'slider_count', 5 );
$modulus_slider_posts = array(
	'cat' => absint($modulus_slider_cat),
	'posts_per_page' => absint($modulus_slider_count)
);

	if ($modulus_slider_cat) {

		$modulus_query = new WP_Query($modulus_slider_posts);
			if( $modulus_query->have_posts()) : ?>
				<div class="flexslider">
					<ul class="slides">
						<?php while($modulus_query->have_posts()) :
								$modulus_query->the_post();
								if( has_post_thumbnail() ) : ?>
								    <li>
								    	<div class="flex-image">
								    		<?php the_post_thumbnail('full'); ?>
								    	</div>
								    	<?php $content = get_the_content();
								    	if( !empty($content) ) : ?>
									    	<div class="flex-caption">
									    		<?php the_content(); ?>
									    	</div>
									    <?php endif; ?>
								    </li>
								<?php endif; ?>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
			<?php  
				$modulus_query = null;
				wp_reset_postdata();	
	}elseif( current_user_can('manage_options') ) {	?>	
		<div class="flexslider">  
			<ul class="slides">	          
				<li>   	
					<div class="flex-image">
						<?php echo '<img src="' . get_template_directory_uri() . '/images/slider.png" alt="" >';?>	
					</div>
					<?php	
					$slide_description = sprintf('<h1> %1$s </h1><p>%2$s</p><p><a href="%3$s" target="_blank"> %4$s</a></p>',__('Slider Setting','modulus'), __('You haven\'t created any slider yet. Create a post, set your slider image as Post\'s featured image ( Recommended image size 1280*450 ). Go to Customizer and click Home => Slider Section and select Slider Post Category and No.of Sliders.','modulus'), esc_url(admin_url('customize.php')) , __('Customizer','modulus'));?>
					<div class="flex-caption"> <?php echo $slide_description;?></div>
				</li>
			</ul>
		</div><!-- flex-slider end -->	<?php
	}