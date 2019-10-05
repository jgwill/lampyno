<?php
/**
 * Fact Figure Box Idyllic
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
add_action('idyllic_display_fact_figure_box','idyllic_fact_figure_box');
function idyllic_fact_figure_box(){
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_fact_fig_box_bg_image = $idyllic_settings['idyllic-img-fact-fig-box-bg-image'];
	$idyllic_flip_content = $idyllic_settings['idyllic-about-flip-content'];
	if($idyllic_settings['idyllic_disable_fact_figure_box'] ==0){
		$i =1;
		$idyllic_total_page_no	= 0;
		$idyllic_fact_figure_box	= array();
		for( $i = 1; $i <= 4; $i++ ){
			if( isset ( $idyllic_settings['idyllic_fact_figure_box_' . $i] ) && $idyllic_settings['idyllic_fact_figure_box_' . $i] > 0 ){
				$idyllic_total_page_no++;

				$idyllic_fact_figure_box	=	array_merge( $idyllic_fact_figure_box, array( $idyllic_settings['idyllic_fact_figure_box_' . $i] ) );
			}
		}
		$idyllic_get_about_us_section 		= new WP_Query(array(
								'posts_per_page'      	=> intval($idyllic_settings['idyllic_fact_figure_box']),
								'post_type'           	=> array('page'),
								'post__in'            	=> array_values($idyllic_fact_figure_box),
								'orderby'             	=> 'post__in',
							));
		if (( !empty( $idyllic_fact_figure_box ) || !empty($idyllic_settings['idyllic_fact_figure_box_title']) || !empty($idyllic_settings['idyllic_fact_figure_box_description']) )  && $idyllic_total_page_no > 0 ) { ?>

		<!--  Fact Figure Box ============================================= -->
		<div class="fact-figure-box">
			<div class="fact-figure-bg"<?php if(!empty($idyllic_fact_fig_box_bg_image)): ?> style="background-image:url('<?php echo esc_url($idyllic_fact_fig_box_bg_image); endif; ?>');">
				<div class="wrap">
					<?php
					if($idyllic_settings['idyllic_fact_figure_box_title'] !='' || $idyllic_settings['idyllic_fact_figure_box_description'] !='') { ?>
						<div class="box-header">
							<?php if($idyllic_settings['idyllic_fact_figure_box_title'] !='') { ?>
								<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_html($idyllic_settings['idyllic_fact_figure_box_title']);?></h2>
							<?php }
							if($idyllic_settings['idyllic_fact_figure_box_description'] !=''){ ?>
								<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_fact_figure_box_description']); ?></p>
							<?php } ?>
						</div><!-- end .box-header -->
					<?php } ?>
					<div class="column clearfix">
					<?php while($idyllic_get_about_us_section->have_posts()):$idyllic_get_about_us_section->the_post(); 
						$excerpt_text = $idyllic_settings['idyllic_tag_text']; ?>
						<div class="four-column">
							<div class="facts-content-wrap">
								<span class="counter">
									<?php the_title(); ?> 
								</span>
								<?php the_excerpt(); ?>
							</div>
						</div><!-- end .four-column -->
					<?php endwhile; ?>
					</div><!-- end .column -->
					<?php
					$excerpt_text = $idyllic_settings['idyllic_tag_text'];
					if($excerpt_text == '' || $excerpt_text == 'Continue Reading') : ?>
						<a class="btn-default dark" href="<?php echo esc_url($idyllic_settings['idyllic_img_fact_fig_boxlink']);?>" title="<?php esc_attr_e('Continue Reading','idyllic');?>"><?php esc_html_e('Continue Reading','idyllic');?></a>
					<?php else: ?>
						<a class="btn-default dark" href="<?php echo esc_url($idyllic_settings['idyllic_img_fact_fig_boxlink']);?>" title="<?php echo esc_attr($idyllic_settings[ 'idyllic_tag_text' ]);?>"><?php echo esc_attr($idyllic_settings[ 'idyllic_tag_text' ]);?></a>
					<?php endif; ?>
				</div><!-- end .wrap -->
			</div><!-- end .fact-figure-bg -->
		</div><!-- end .fact-figure-box -->
		<?php }
		wp_reset_postdata();
	}
}