<?php
//about theme info
add_action( 'admin_menu', 'it_solutions_abouttheme' );
function it_solutions_abouttheme() {    	
	add_theme_page( esc_html__('About Theme', 'it-solutions'), esc_html__('About Theme', 'it-solutions'), 'edit_theme_options', 'it_solutions_guide', 'it_solutions_mostrar_guide');   
} 
//guidline for about theme
function it_solutions_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>
<div class="wrapper-info">
	<div class="col-left">
   		   <div class="col-left-area">
			  <?php esc_attr_e('Theme Information', 'it-solutions'); ?>
		   </div>
          <p><?php esc_attr_e('SKT IT Solutions is a simple, intuitive, flexible, easy to use multipurpose WordPress theme which can be used for various industries like computer, maintenance, services, consulting, corporate, business, local IT companies, software, digital online medium, training, HR, advisors, mutual funds, portfolio asset management, elearning, school, coaching, eCommerce, shop and any other portfolio websites. It is compatible with multilingual plugins, SEO plugins, WooCommerce for shopping, contact forms, pricing table, events calendar and gallery and slider plugins as well. Tested with Gutenberg and WordPress 5.0 beta as well.','it-solutions'); ?></p>
		  <a href="<?php echo esc_url(IT_SOLUTIONS_SKTTHEMES_PRO_THEME_URL); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/free-vs-pro.png" alt="" /></a>
	</div><!-- .col-left -->
	<div class="col-right">			
			<div class="centerbold">
				<hr />
				<a href="<?php echo esc_url(IT_SOLUTIONS_SKTTHEMES_LIVE_DEMO); ?>" target="_blank"><?php esc_attr_e('Live Demo', 'it-solutions'); ?></a> | 
				<a href="<?php echo esc_url(IT_SOLUTIONS_SKTTHEMES_PRO_THEME_URL); ?>"><?php esc_attr_e('Buy Pro', 'it-solutions'); ?></a> | 
				<a href="<?php echo esc_url(IT_SOLUTIONS_SKTTHEMES_THEME_DOC); ?>" target="_blank"><?php esc_attr_e('Documentation', 'it-solutions'); ?></a>
                <div class="space5"></div>
				<hr />                
                <a href="<?php echo esc_url(IT_SOLUTIONS_SKTTHEMES_THEMES); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sktskill.jpg" alt="" /></a>
			</div>		
	</div><!-- .col-right -->
</div><!-- .wrapper-info -->
<?php } ?>