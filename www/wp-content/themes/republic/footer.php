<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package republic
 */
?>

	</div><!-- #content -->
<?php get_template_part('template-parts/footer-widget'); ?>

	<footer id="colophon" class="large-12 columns" role="contentinfo">
            <div class="site-footer">
		<div class="large-6 columns site-info">
                    <?php do_action( 'republic_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'republic' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'republic' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<a href="<?php echo esc_url( __( 'http://www.insertcart.com/product/republic-wordpress-theme/', 'republic' ) ); ?>"><?php printf( __( 'Republic %s', 'republic' ), 'Theme' ); ?></a>
		<?php wp_nav_menu( array( 'theme_location' => 'footer-menu','container_class' => 'menu-centered','menu_id' => 'footerhorizontal', 'menu_class' => 'menu',    'echo' => true,'depth' =>'1','fallback_cb' => false ) ); ?>
		</div><!-- .site-info -->
                <div class="large-6 columns footer-social">
			<?php  if (get_theme_mod('republic_hidefotshare')!='1') { get_template_part('template-parts/footer-social'); }?>
                </div><!-- .site-info -->
				
            </div>
	</footer><!-- #colophon -->
</div><!-- #page -->


<?php wp_footer(); ?>
</body>
</html>
