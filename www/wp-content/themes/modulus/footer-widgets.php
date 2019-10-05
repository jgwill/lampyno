<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package modulus
 */
$footer_widget_count = get_theme_mod('footer_widgets_count', 4 );

switch ( $footer_widget_count ) {
	case 1:
		$footer_widget_class = 'sixteen columns';
		break;
	case 2:
		$footer_widget_class = 'eight columns';
		break;
	case 3:
		$footer_widget_class = 'one-third column';    
		break;
	
	default:
		$footer_widget_class = 'four columns';
		break;
}


for ($i = 1; $i <= $footer_widget_count; $i++ ) {

?>

		<div class="<?php echo $footer_widget_class; ?>">
			<?php 
			if( $i == 1 ) {
				if ( is_active_sidebar( 'footer' ) ) :
					dynamic_sidebar('footer');
				else: ?>
					<aside id="meta" class="widget">
						<h4 class="widget-title"><?php _e( 'Meta', 'modulus' ); ?></h4>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<?php wp_meta(); ?>
						</ul>
			       </aside>
				<?php endif; 
			}else {
				if ( is_active_sidebar( 'footer-'.$i ) ) :
				    dynamic_sidebar('footer-'.$i );
				else: ?>
			       <aside id="archives" class="widget">
						<h4 class="widget-title"><?php _e( 'Archives', 'modulus' ); ?></h4>
						<ul>
							<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
						</ul>
					</aside><?php
				endif;
			} ?>
					
		</div>

<?php } ?>
