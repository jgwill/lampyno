<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKT Consulting
 */
?>
<div id="footer-wrapper">
		<div class="footer-wave-bg"></div>
		<div class="footerarea">
    	<div class="container footer">
        	<div id="footer-info-area">
            	<div class="footercenter">
                <div class="logo">
                        <?php skt_consulting_the_custom_logo(); ?>
                        <div class="clear"></div>
                        <?php	
                        $description = get_bloginfo( 'description', 'display' );
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <h2 class="site-title"><?php bloginfo('name'); ?></h2>
                        <?php if ( $description || is_customize_preview() ) :?>
                        <p class="site-description"><?php echo esc_html($description); ?></p>                          
                        <?php endif; ?>
                        </a>
                    </div>    
                    <div class="clear"></div>
                    <div class="footermenu"><?php wp_nav_menu( array('theme_location' => 'footermenu') ); ?></div>            
                </div>
                <div class="footercenter">
      <?php
        $fb_link = get_theme_mod('fb_link'); 
        $twitt_link = get_theme_mod('twitt_link');
        $gplus_link = get_theme_mod('gplus_link');
        $youtube_link = get_theme_mod('youtube_link');
        $instagram_link = get_theme_mod('instagram_link');
        $linkedin_link = get_theme_mod('linkedin_link'); 
    ?> 
    <div class="footersocial">
    	<div class="social-icons">
    	<?php 
            if (!empty($fb_link)) { ?>
            <a title="<?php echo esc_attr__('Facebook','skt-consulting'); ?>" class="fb" target="_blank" href="<?php echo esc_url($fb_link); ?>"></a> 
            <?php }  
            if (!empty($twitt_link)) { ?>
            <a title="<?php echo esc_attr__('Twitter','skt-consulting'); ?>" class="tw" target="_blank" href="<?php echo esc_url($twitt_link); ?>"></a> 
            <?php }  
            if (!empty($gplus_link)) { ?>
            <a title="<?php echo esc_attr__('Google Plus','skt-consulting'); ?>" class="gp" target="_blank" href="<?php echo esc_url($gplus_link); ?>"></a> 
            <?php }   
            if (!empty($youtube_link)) { ?>
            <a title="<?php echo esc_attr__('Youtube','skt-consulting'); ?>" class="tube" target="_blank" href="<?php echo esc_url($youtube_link); ?>"></a> 
            <?php }   
            if (!empty($instagram_link)) { ?>
            <a title="<?php echo esc_attr__('Instagram','skt-consulting'); ?>" class="insta" target="_blank" href="<?php echo esc_url($instagram_link); ?>"></a> 
            <?php }   
            if (!empty($linkedin_link)) { ?>
            <a title="<?php echo esc_attr__('Linkedin','skt-consulting'); ?>" class="in" target="_blank" href="<?php echo esc_url($linkedin_link); ?>"></a> 
            <?php } ?>   
            </div>
    </div>
    			
                </div>
                <div class="clear"></div>
            </div>
            <div id="copyright-area">
<div class="copyright-wrapper">
<div class="container">
     <div class="copyright-txt"><?php echo esc_html('SKT Consulting');?></div>
     <div class="clear"></div>
</div>           
</div>
</div>
        </div><!--end .container--> 
        </div><!--end .footer-wrapper-->
<!--end .footer-wrapper-->
<?php wp_footer(); ?>
</body>
</html>