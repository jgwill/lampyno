<?php
/**
 * Our Team Member
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage idyllic
 * @since idyllic 1.0
 */
add_action('idyllic_display_team_member','idyllic_team_member');
function idyllic_team_member(){
	$idyllic_settings = idyllic_get_theme_options();
	if($idyllic_settings['idyllic_disable_team_member'] == 0){
		$idyllic_team_member_total_page_no = 0;
		$idyllic_team_member_list_page	= array();
		for( $i = 1; $i <= $idyllic_settings['idyllic_total_team_member']; $i++ ){
			if( isset ( $idyllic_settings['idyllic_display_team_member_' . $i] ) && $idyllic_settings['idyllic_display_team_member_' . $i] > 0 ){
				$idyllic_team_member_total_page_no++;

				$idyllic_team_member_list_page	=	array_merge( $idyllic_team_member_list_page, array( $idyllic_settings['idyllic_display_team_member_' . $i] ) );
			}
		}
		if (( !empty( $idyllic_team_member_list_page ) || !empty($idyllic_settings['idyllic_team_member_title']) || !empty($idyllic_settings['idyllic_team_member_description']))  && $idyllic_team_member_total_page_no > 0 ) {
			echo '<!-- Our Team Box ============================================= -->'; ?>
				<div class="team-member-box <?php if($idyllic_settings['idyllic_team_member_design_layout'] !=''){echo esc_attr($idyllic_settings['idyllic_team_member_design_layout']);}?>">
					<div class="wrap">
						<div class="team-wrap">
							<div class="box-header">
								<?php	 if($idyllic_settings['idyllic_team_member_title'] != ''){ ?>
									<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_team_member_title']);?> </h2>
								<?php } ?>
								<?php
								if($idyllic_settings['idyllic_team_member_description'] != ''){ ?>
								<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_team_member_description']);?></p>
								<?php } ?>
							</div><!-- end .box-header -->
							<div class="team-slider">
								<ul class="slides">
									<?php	$idyllic_team_member_get_featured_posts 		= new WP_Query(array(
										'posts_per_page'      	=> intval($idyllic_settings['idyllic_total_team_member']),
										'post_type'           	=> array('page'),
										'post__in'            	=> array_values($idyllic_team_member_list_page),
										'orderby'             	=> 'post__in',
									));
									$i=1;
									while ($idyllic_team_member_get_featured_posts->have_posts()):$idyllic_team_member_get_featured_posts->the_post(); ?>
										<li>
											<div class="team-content-wrap">
											<?php if (has_post_thumbnail()) { 
												if($idyllic_settings['idyllic_our_team_remove_link']==0){ ?>
												<a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>" alt="<?php echo the_title_attribute('echo=0'); ?>"><?php the_post_thumbnail(); ?></a>
												<?php } else {
													the_post_thumbnail();
												}
											}
											if(get_the_content()): ?>
												<div class="team-info">
													<div class="team-info-text">
													<?php if($idyllic_settings['idyllic_our_team_remove_link']==0){ ?>
															<h3><a title="title" href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
														<?php } else { ?>
															<?php the_title();?></h3>
														<?php	}
														the_content(esc_attr($idyllic_settings['idyllic_tag_text'])); ?>
													</div>
												</div> <!-- end .team-info -->
											<?php endif; ?>
											</div> <!-- end .team-content-wrap -->
										</li>
									<?php $i++;
									 endwhile; ?>
								</ul>
							</div><!-- end .team-slider -->
						</div><!-- end .team-wrap -->
					</div><!-- end .wrap -->
				</div><!-- end .team-member-box -->
			<?php }
		wp_reset_postdata();
	}
}
