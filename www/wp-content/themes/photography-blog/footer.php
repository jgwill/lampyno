<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Photography_Blog
 */

?>

	</div><!-- #content -->


<footer id="colophon" class="site-footer">
	   <div class="site-widget-area clear">
		   <div class="wrapper">
			   <div class="row">
				   <?php if (is_active_sidebar('footer-col-1') || is_active_sidebar('footer-col-2') || is_active_sidebar('footer-col-3')) { ?>
					   <?php if (is_active_sidebar('footer-col-1')) : ?>
						   <div class="col col-three-1">
							   <?php dynamic_sidebar('footer-col-1'); ?>
						   </div>
					   <?php endif; ?>
					   <?php if (is_active_sidebar('footer-col-2')) : ?>
						   <div class="col col-three-1">
							   <?php dynamic_sidebar('footer-col-2'); ?>
						   </div>
					   <?php endif; ?>
					   <?php if (is_active_sidebar('footer-col-3')) : ?>
						   <div class="col col-three-1">
							   <?php dynamic_sidebar('footer-col-3'); ?>
						   </div>
					   <?php endif; ?>
				   <?php } ?>
			   </div>
		   </div>
	   </div>
		<div class="site-info clear <?php if ( !has_nav_menu( 'social' ) ){ echo "social-nav-disabled";} ?>">
			<div class="wrapper">
				<div class="row">
					<div class="col col-five">
						<?php
						if ( has_nav_menu( 'social' ) ) : ?>
							<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'photography-blog' ); ?>">
								<?php
								wp_nav_menu( array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . photography_blog_get_svg( array( 'icon' => 'chain' ) ),
								) );
								?>
							</nav>
						<?php endif; ?>
					</div>
					<div class="col col-five">
						<div class="copyright-info">
                            <?php
                            $pb_copyright_text = photography_blog_get_option('copyright_text');
                            if (!empty ($pb_copyright_text)) {
                                echo wp_kses_post(photography_blog_get_option('copyright_text'));
                            }
                            ?>
							<span class="sep"> | </span>
							<?php printf(esc_html__('Theme: %1$s by %2$s.', 'photography-blog'), 'Photography Blog', '<a href="http://unitedtheme.com/">Unitedtheme</a>');
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
<button class="scroll-up">
    <span> <?php echo esc_html('Scroll up','photography-blog'); ?></span>
</button>
</div>

<?php wp_footer(); ?>

</body>
</html>
