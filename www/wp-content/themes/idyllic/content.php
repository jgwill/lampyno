<?php
/**
 * The template for displaying content.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
$idyllic_settings = idyllic_get_theme_options(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
		<?php $idyllic_blog_post_image = $idyllic_settings['idyllic_blog_post_image'];
		$entry_format_meta_blog = $idyllic_settings['idyllic_entry_meta_blog'];
		if( has_post_thumbnail() && $idyllic_blog_post_image == 'on') { ?>
			<div class="post-image-content">
				<figure class="post-featured-image">
					<a href="<?php the_permalink();?>" title="<?php echo the_title_attribute('echo=0'); ?>">
					<?php the_post_thumbnail(); ?>
					</a>
				</figure><!-- end.post-featured-image  -->
				<div class="entry-meta">
					<?php 
					printf( '<span class="posted-on"><a href="%1$s" title="%2$s">%3$s</a></span>',
							esc_url(get_the_permalink()),
							esc_attr( get_the_time() ),
							esc_attr(get_the_time( get_option( 'date_format' ) ))
						);
					$format = get_post_format();
					if ( current_theme_supports( 'post-formats', $format ) ) {
						printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
							sprintf( ''),
							esc_url( get_post_format_link( $format ) ),
							get_post_format_string( $format )
						);
					} ?>
				</div>
			</div> <!-- end.post-image-content -->
		<?php } ?>
		<header class="entry-header">
		<?php
			if($entry_format_meta_blog == 'show-meta' ){?>
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
				</span>
				<!-- end .cat-links -->
				<?php $tag_list = get_the_tag_list( '', __( ', ', 'idyllic' ) );
				if(!empty($tag_list)){ ?>
					<span class="tag-links">
					<?php   echo get_the_tag_list( '', __( ', ', 'idyllic' ) ); ?>
					</span> <!-- end .tag-links -->
				<?php }  ?>
			</div>
			<?php } ?>
			<h2 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute('echo=0'); ?>"> <?php the_title();?> </a> </h2> <!-- end.entry-title -->
			<?php if($entry_format_meta_blog == 'show-meta' ){ ?> 
				<div class="entry-meta">
					<span class="author vcard"><?php esc_html_e('Post By','idyllic');?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author(); ?>">
					<?php the_author(); ?> </a></span>
					<span class="posted-on"><a title="<?php echo esc_attr( get_the_time() ); ?>" href="<?php the_permalink(); ?>"><i class="fa fa-calendar-check-o"></i>
					<?php the_time( get_option( 'date_format' ) ); ?> </a></span>
					<?php if ( comments_open() ) { ?>
					<span class="comments"><i class="fa fa-comments-o"></i>
					<?php comments_popup_link( __( 'No Comments', 'idyllic' ), __( '1 Comment', 'idyllic' ), __( '% Comments', 'idyllic' ), '', __( 'Comments Off', 'idyllic' ) ); ?> </span>
					<?php } ?>
				</div><!-- end .entry-meta -->
			<?php } ?>
			</header><!-- end .entry-header -->
			<div class="entry-content">
			<?php
			$idyllic_tag_text = $idyllic_settings['idyllic_tag_text'];
			$content_display = $idyllic_settings['idyllic_blog_content_layout'];
			if($content_display == 'excerptblog_display'):
					the_excerpt(); ?>
				<a href="<?php echo esc_url(get_permalink());?>" class="more-link"><?php echo esc_attr($idyllic_tag_text);?></a>
				<?php else:
					the_content( esc_attr($idyllic_tag_text));
				endif; ?>
			</div> <!-- end .entry-content -->
			<?php wp_link_pages( array( 
					'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'idyllic' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1
				) ); ?>
		</article><!-- end .post -->