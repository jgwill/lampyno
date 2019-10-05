 <?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package modulus
 */
?>
<?php if( ! is_front_page() ) { ?>
		</div> <!-- .container -->
<?php } ?>
	</div><!-- #content -->
	<?php do_action('modulus_before_footer'); ?>
    <footer id="colophon" class="site-footer footer-image overlay-footer" role="contentinfo">
		<?php if ( get_theme_mod ('footer_overlay',false ) ) { 
					   echo '<div class="overlay overlay-footer"></div>';     
					} 
			$footer_widgets = get_theme_mod( 'footer_widgets',true );
			if( $footer_widgets ) : ?>
			<div class="footer-widgets">
				<div class="container">
					<?php get_template_part('footer','widgets'); ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="site-info footer-bottom">
			<div class="container">
				<div class="copyright eight columns">  
				<?php if( get_theme_mod('copyright') ) : ?>
					<p><?php echo do_shortcode(get_theme_mod('copyright')); ?></p>
				<?php else : 
					do_action('modulus_credits'); 
				endif;  ?>
			</div>
				<div class="left-sidebar eight columns footer-nav">
					<?php dynamic_sidebar( 'footer-nav' ); ?>
				</div>
			</div>
		</div>
		<?php if( get_theme_mod('scroll_to_top_button',true) ) : ?>
			<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
		<?php endif;  ?>
	</footer><!-- #colophon -->
	<?php do_action('modulus_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
