<?php
/**
 * Portfolio
 *
 * Displays in Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
add_action('idyllic_display_portfolio_box','idyllic_portfolio_box');
function idyllic_portfolio_box(){
	$idyllic_settings = idyllic_get_theme_options();
	if($idyllic_settings['idyllic_disable_portfolio_box'] != 1){
		$get_portfolio_box_posts = new WP_Query(array(
			'posts_per_page' =>  intval($idyllic_settings['idyllic_total_portfolio_box']),
			'post_type'					=> 'post',
			'category__in' => intval($idyllic_settings['idyllic_portfolio_category_list']),
		));
		if ( !empty($idyllic_settings['idyllic_portfolio_title']) || $get_portfolio_box_posts !='') { 
		echo '<!-- Portfolio Box ============================================= -->';
		$idyllic_portfolio_fullwidth_layout='';
		$idyllic_portfolio_noborder_layout='';
		$idyllic_portfolio_show_title_layout='';
		if($idyllic_settings['idyllic_portfolio_fullwidth_layout'] ==1){
			$idyllic_portfolio_fullwidth_layout ='portfolio-full-img';
		}
		if($idyllic_settings['idyllic_portfolio_noborder_layout'] ==1){
			$idyllic_portfolio_noborder_layout ='portfolio-no-border';
		}
		if($idyllic_settings['idyllic_portfolio_show_title_layout'] ==1){
			$idyllic_portfolio_show_title_layout ='portfolio-show-title';
		}
		?>
		<div class="portfolio-box <?php echo esc_attr($idyllic_portfolio_fullwidth_layout. ' ' .$idyllic_portfolio_noborder_layout. ' ' .$idyllic_portfolio_show_title_layout); ?>">
			<div class="wrap">
				<div class="box-header">
					<?php	 if($idyllic_settings['idyllic_portfolio_title'] != ''){ ?>
						<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.4s"><a title="<?php echo esc_attr($idyllic_settings['idyllic_portfolio_title']);?>" href="<?php echo esc_url(get_category_link($idyllic_settings['idyllic_portfolio_category_list'])); ?>"><?php echo esc_attr($idyllic_settings['idyllic_portfolio_title']);?> </a></h2>
					<?php } ?>
					<span class="portfolio-title-bg freesia-animation zoomIn"  data-wow-delay="0.8s"><?php echo esc_html(get_cat_name($idyllic_settings['idyllic_portfolio_category_list'])); ?></span>
					<?php
					if($idyllic_settings['idyllic_portfolio_description'] != ''){ ?>
					<p><?php echo esc_attr($idyllic_settings['idyllic_portfolio_description']);?></p>
					<?php } ?>
				</div><!-- end .box-header -->
			</div><!-- end .wrap -->
			<div class="portfolio-wrap-bg clearfix">
			<?php
				while ($get_portfolio_box_posts->have_posts()):$get_portfolio_box_posts->the_post(); ?>
					<div class="four-column">
						<div class="portfolio-content freesia-animation fadeInUp">
							<?php if (has_post_thumbnail()) { ?>
							<div class="portfolio-img">
								<a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>	
							</div>
							<?php } ?>
							<header class="entry-header">
								<h2 class="portfolio-title"><a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
								<div class="entry-meta">
									<?php $tag_list = get_the_tag_list( '', __( ', ', 'idyllic' ) );
									if(!empty($tag_list)){ ?>
										<span class="tag-links">
											<?php   echo get_the_tag_list( '', __( ', ', 'idyllic' ) ); ?>
										</span> <!-- end .tag-links -->
									<?php } ?>
								</div>
							</header><!-- end .entry-header -->
						</div><!-- end .portfolio-content -->
					</div><!-- end .four-column -->
					<?php
				endwhile; ?>
			</div><!-- end .portfolio-wrap-bg -->
		</div><!-- end .portfolio-box -->
		<?php wp_reset_postdata();
		}
	}
}