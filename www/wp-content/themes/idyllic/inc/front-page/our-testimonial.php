<?php
/**
 * Gallery
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
add_action('idyllic_display_our_testimonial','idyllic_our_testimonial');
function idyllic_our_testimonial(){
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_testimonial_bg_iamge = $idyllic_settings['idyllic-testimonial-bg-image'];
	if($idyllic_settings['idyllic_disable_our_testimonial'] != 1){
		$idyllic_our_testimonial_total_page_no = 0;
		$idyllic_our_testimonial_list_page	= array();
		for( $i = 1; $i <= $idyllic_settings['idyllic_total_our_testimonial']; $i++ ){
			if( isset ( $idyllic_settings['idyllic_our_testimonial_features_' . $i] ) && $idyllic_settings['idyllic_our_testimonial_features_' . $i] > 0 ){
				$idyllic_our_testimonial_total_page_no++;

				$idyllic_our_testimonial_list_page	=	array_merge( $idyllic_our_testimonial_list_page, array( $idyllic_settings['idyllic_our_testimonial_features_' . $i] ) );
			}
		}
		if ( !empty( $idyllic_our_testimonial_list_page )  && $idyllic_our_testimonial_total_page_no > 0 ) {
			echo '<!-- Testimonial Box============================================= -->';?>
			<div class="testimonial-box">
				<div class="testimonial-bg color-overlay" <?php if($idyllic_testimonial_bg_iamge!=''){ ?>style="background-image:url('<?php echo esc_url($idyllic_testimonial_bg_iamge); } ?>');">
					<div class="wrap">
						<div class="inner-wrap">
							<?php	 if($idyllic_settings['idyllic_testimonial_title'] != ''){ ?>
								<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_testimonial_title']);?></h2>
							<?php }
							if($idyllic_settings['idyllic_testimonial_description'] != ''){ ?>
								<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_testimonial_description']); ?></p>
							<?php }
							$idyllic_our_testimonial_get_featured_posts 		= new WP_Query(array(
								'posts_per_page'      	=> intval($idyllic_settings['idyllic_total_our_testimonial']),
								'post_type'           	=> array('page'),
								'post__in'            	=> array_values($idyllic_our_testimonial_list_page),
								'orderby'             	=> 'post__in',
							)); ?>
								<div class="testimonials">
									<div class="testimonial-slider">
										<ul class="slides">
											<?php $i=1;
											while ($idyllic_our_testimonial_get_featured_posts->have_posts()):$idyllic_our_testimonial_get_featured_posts->the_post();
											$idyllic_attachment_id = get_post_thumbnail_id();
											$idyllic_image_attributes = wp_get_attachment_image_src($idyllic_attachment_id); ?>
												<li>
													<div class="testimonial-wrap">
														<?php if(has_post_thumbnail()):
															the_post_thumbnail();
														endif; ?>
														<div class="testimonial-quote">
															<h2><?php the_title(); ?></h2>
															<?php if(get_the_content()):
																the_content();
															endif;
															if (!empty($idyllic_settings[ 'idyllic_our_testimonial_name_'. $i ])):?>
																<cite><?php echo esc_html($idyllic_settings[ 'idyllic_our_testimonial_name_'. absint($i) ]); ?></cite>
															<?php endif; ?>
														</div><!-- end .testimonial-quote -->
													</div> <!-- end .testimonial-wrap -->
												</li>
											<?php $i++;
											endwhile; ?>
										</ul><!-- end .slides -->
									</div><!-- end .testimonial-slider -->
								</div><!-- end .testimonials -->
						</div> <!-- end .inner-wrap -->
					</div><!-- end .wrap -->
				</div><!-- end .testimonial_bg -->
			</div><!-- end .testimonial-box -->
	<?php }
		wp_reset_postdata();
	}
}
