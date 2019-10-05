<?php
/**
 * Front Page Features
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
add_action('idyllic_display_front_page_features','idyllic_front_page_features');
function idyllic_front_page_features(){
	$idyllic_settings = idyllic_get_theme_options();
	if($idyllic_settings['idyllic_disable_features'] != 1){
		$idyllic_total_page_no = 0;
		$idyllic_list_page	= array();
		for( $i = 1; $i <= $idyllic_settings['idyllic_total_features']; $i++ ){
			if( isset ( $idyllic_settings['idyllic_frontpage_features_' . $i] ) && $idyllic_settings['idyllic_frontpage_features_' . $i] > 0 ){
				$idyllic_total_page_no++;

				$idyllic_list_page	=	array_merge( $idyllic_list_page, array( $idyllic_settings['idyllic_frontpage_features_' . $i] ) );
			}
		}
		if (( !empty( $idyllic_list_page ) || !empty($idyllic_settings['idyllic_features_title']) || !empty($idyllic_settings['idyllic_features_description']) )  && $idyllic_total_page_no > 0 ) {
		echo '<!-- Our Feature Box ============================================= -->';
		if($idyllic_settings['idyllic_frontpage_feature_design'] == 'our-feature-one'){
			$feature_box_class ='our-feature-one';
		}elseif($idyllic_settings['idyllic_frontpage_feature_design'] == 'our-feature-two'){
			$feature_box_class ='our-feature-two';
		}else{
			$feature_box_class ='';
		}
		?>
			<div class="our-feature-box <?php echo esc_attr($feature_box_class); ?>">
				<div class="wrap">
					<div class="inner-wrap">
					<?php	$idyllic_feature_box_get_featured_posts 		= new WP_Query(array(
						'posts_per_page'      	=> intval($idyllic_settings['idyllic_total_features']),
						'post_type'           	=> array('page'),
						'post__in'            	=> array_values($idyllic_list_page),
						'orderby'             	=> 'post__in',
					));
					if($idyllic_settings['idyllic_features_title'] != '' || $idyllic_settings['idyllic_features_description'] != ''){
						echo '<div class="box-header">';
						if($idyllic_settings['idyllic_features_title'] != ''){ ?>
							<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_features_title']);?> </h2>
						<?php }
						if($idyllic_settings['idyllic_features_description'] != ''){ ?>
							<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_features_description']); ?></p>
						<?php }
						echo '</div><!-- end .box-header -->';
					} ?>
					<div class="column clearfix">
					<?php
					$i=1;
					while ($idyllic_feature_box_get_featured_posts->have_posts()):$idyllic_feature_box_get_featured_posts->the_post();
						if($i % 3 ==1 && $i >=0){
								$blog_class = '0.5s';
						}elseif($i % 3 ==2 && $i >=0){
								$blog_class = '0.6s';
						}else{
								$blog_class = '0.7s';
						}  ?>
						<div class="four-column freesia-animation fadeInUp" data-wow-delay="<?php echo esc_attr($blog_class); ?>">
							<div class="feature-content-wrap feature-wrap-color-<?php echo absint($i);?>">
								<?php if (has_post_thumbnail() && $idyllic_settings['idyllic_disable_features_image']==0) { ?>
									<a class="feature-icon icon-color-<?php echo absint($i);?>" href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>" alt="<?php echo the_title_attribute('echo=0'); ?>"><?php the_post_thumbnail(); ?></a>
								<?php } ?>
								<div class="feature-content">
									<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<h2 class="feature-title"><a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>" rel="bookmark"><?php the_title();?></a></h2>
										<?php the_content(esc_attr($idyllic_settings['idyllic_tag_text'])); ?>
									</article>
								</div><!-- end .feature-content -->
							</div> <!-- end .feature-content-wrap -->
						</div><!-- end .four-column -->
						<?php 
						$i++;
						endwhile; ?>
						</div><!-- .end column-->
					</div><!-- end .inner-wrap -->
				</div><!-- end .wrap -->
			</div><!-- end .our-feature-box -->
		<?php }
	wp_reset_postdata();
	}
}
