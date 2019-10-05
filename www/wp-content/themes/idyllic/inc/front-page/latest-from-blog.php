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
add_action('idyllic_display_latest_from_blog_box','idyllic_latest_from_blog_box');
function idyllic_latest_from_blog_box(){
	$idyllic_settings = idyllic_get_theme_options();
	$latest_from_blog = $idyllic_settings['idyllic_display_blog_category'];
	if($idyllic_settings['idyllic_disable_latest_blog'] != 1){
		if($latest_from_blog == 'blog')
			{
				$get_latest_from_blog_posts = new WP_Query(array(
					'posts_per_page' =>  intval($idyllic_settings['idyllic_total_latest_from_blog']),
					'post_type'					=> array('post'),
					'ignore_sticky_posts' 	=> true
				));
			}	else {
				$get_latest_from_blog_posts = new WP_Query(array(
					'posts_per_page' =>  intval($idyllic_settings['idyllic_total_latest_from_blog']),
					'post_type'					=> array('post'),
					'category__in' => intval($idyllic_settings['idyllic_latest_from_blog_category_list']),
				));
			}
		if ( !empty($idyllic_settings['idyllic_latest_blog_title']) || $get_latest_from_blog_posts !='') { 
		echo '<!-- Latest Blog ============================================= -->';?>
		<div class="latest-blog-box <?php if($idyllic_settings['idyllic_display_blog_design_layout'] !=''){echo esc_attr($idyllic_settings['idyllic_display_blog_design_layout']);}?>">
			<div class="wrap">
				<div class="inner-wrap">
				<?php	
				if($idyllic_settings['idyllic_latest_blog_title'] != '' || $idyllic_settings['idyllic_latest_blog_description'] != ''){ ?>
					<div class="box-header">
					<?php if($idyllic_settings['idyllic_latest_blog_title'] != '') { ?>
						<h2 class="box-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_latest_blog_title']);?> </h2>
					<?php }
					if($idyllic_settings['idyllic_latest_blog_description'] != ''){ ?>
						<p class="box-sub-title freesia-animation zoomIn" data-wow-delay="0.3s"><?php echo esc_attr($idyllic_settings['idyllic_latest_blog_description']);?></p>
					<?php } ?>
					</div><!-- end .box-header -->
				<?php } ?>
				<div class="column clearfix">
					<?php
					$i=1;
					while ($get_latest_from_blog_posts->have_posts()):$get_latest_from_blog_posts->the_post(); ?>
						<div class="two-column">
						<div class="latest-blog-content">
						<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
							<?php if (has_post_thumbnail()) { ?>
							<div class="latest-blog-image freesia-animation fadeInUp">
								<figure class="post-featured-image">
									<a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink();?>"><?php the_post_thumbnail(); ?></a>
								</figure><!-- end.post-featured-image -->
							</div><!-- end .latest-blog-image -->
							<?php } ?>
							<div class="latest-blog-text">
								<header class="entry-header">
									<div class="entry-meta">
										<?php $format = get_post_format();
										if ( current_theme_supports( 'post-formats', $format ) ) {
											printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
												sprintf( ''),
												esc_url( get_post_format_link( $format ) ),
												get_post_format_string( $format )
											);
										} ?>
										<span class="cat-links">
											<?php the_category(', '); ?>
										</span><!-- end .cat-links -->
										<?php $tag_list = get_the_tag_list( '', __( ', ', 'idyllic' ) );
											if(!empty($tag_list)){ ?>
											<span class="tag-links">
											<?php   echo get_the_tag_list( '', __( ', ', 'idyllic' ) ); ?>
											</span> <!-- end .tag-links -->
											<?php } ?>
									</div>
									<h2 class="entry-title">
										<a title="<?php echo the_title_attribute('echo=0'); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2><!-- end.entry-title -->
									<div class="entry-meta">
										<span class="author vcard"><?php esc_html_e('Post By','idyllic');?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="author"><?php the_author(); ?></a></span>
										<span class="posted-on"><a title="<?php echo esc_attr( get_the_time() ); ?>" href="<?php the_permalink(); ?>">
											<?php the_time( get_option( 'date_format' ) ); ?> </a></span>
										<?php if ( comments_open() ) { ?>
										<span class="comments"><i class="fa fa-comments-o"></i>
										<?php comments_popup_link( __( 'No Comments', 'idyllic' ), __( '1 Comment', 'idyllic' ), __( '% Comments', 'idyllic' ), '', __( 'Comments Off', 'idyllic' ) ); ?> </span>
										<?php } ?>
									</div><!-- end .entry-meta -->
								</header><!-- end .entry-header -->
								<div class="entry-content">
									<?php the_content(esc_attr($idyllic_settings['idyllic_tag_text'])); ?>
								</div><!-- end .entry-content -->
							</div><!-- end .latest-blog-text -->
						</article><!-- end .post -->
				</div><!-- end .latest-blog-content -->
			</div><!-- end .two-column -->
			<?php $i++;
			endwhile; ?>
		</div><!-- end .column -->
	</div><!-- end .inner-wrap -->
</div><!-- end .wrap -->
</div><!-- end .latest-blog-box -->
		<?php }
	wp_reset_postdata();
	}
}
