<?php
/**
 * Upcoming Idyllic
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
add_action('idyllic_display_about_us','idyllic_about_us');
function idyllic_about_us(){
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_aboutus_bg_image = $idyllic_settings['idyllic-img-upload-aboutus-bg-image'];
	$idyllic_flip_content = $idyllic_settings['idyllic-about-flip-content'];
	if($idyllic_settings['idyllic_disable_about_us'] ==0){
		$i =1;
		$idyllic_about_us	= array();
		$idyllic_about_us	=	array_merge( $idyllic_about_us, array( $idyllic_settings['idyllic_about_us'] ) );
		$idyllic_get_about_us_section 		= new WP_Query(array(
								'posts_per_page'      	=> intval($idyllic_settings['idyllic_about_us']),
								'post_type'           	=> array('page'),
								'post__in'            	=> array_values($idyllic_about_us),
								'orderby'             	=> 'post__in',
							)); ?>

		<!-- About Box ============================================= -->
		<div class="about-box <?php if($idyllic_flip_content==1): echo esc_attr('flip-content'); endif; ?>">
			<div class="about-box-bg"<?php if(!empty($idyllic_aboutus_bg_image)): ?> style="background-image:url('<?php echo esc_url($idyllic_aboutus_bg_image); endif; ?>');">
				<div class="wrap">
					<?php
					if($idyllic_settings['idyllic_about_title'] !='' || $idyllic_settings['idyllic_about_description'] !='') { ?>
						<div class="box-header">
							<?php if($idyllic_settings['idyllic_about_title'] !='') { ?>
								<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_html($idyllic_settings['idyllic_about_title']);?></h2>
							<?php }
							if($idyllic_settings['idyllic_about_description'] !=''){ ?>
								<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_about_description']); ?></p>
							<?php } ?>
						</div><!-- end .box-header -->
					<?php }
					if($idyllic_get_about_us_section->have_posts()):$idyllic_get_about_us_section->the_post(); ?>
						<div class="column clearfix">
							<div class="two-column">
								<div class="about-content-wrap freesia-animation fadeInRight" data-wow-delay="0.5s">
									<article>
										<h2 class="about-title">
											<?php if($idyllic_settings['idyllic_about_us_remove_link']==0){ ?>
												<a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a>
												<?php }else{
													the_title();
											} ?>
										</h2>
										<?php the_content(); ?>
									</article>
								</div><!-- end .about-content-wrap -->
							</div><!-- end .two-column -->

							<?php
							if(has_post_thumbnail()): ?>
								<div class="two-column">
									<div class="about-image freesia-animation fadeInLeft" data-wow-delay="0.5s">
										<?php if($idyllic_settings['idyllic_about_us_remove_link']==0){ ?>
										<a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
										<?php }else{
											the_post_thumbnail();
										} ?>
									</div><!-- end .about-image -->
								</div><!-- end .two-column -->
							<?php endif; ?>
						</div><!-- end .column -->
					<?php endif; ?>
				</div><!-- end .wrap -->
			</div><!-- end .about-box-bg -->
		</div><!-- end .about-box -->
		<?php wp_reset_postdata();
	}
}