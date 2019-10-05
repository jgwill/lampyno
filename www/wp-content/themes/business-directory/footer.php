<!--End Content Wrapper-->
<div class="clear"></div>
<div class="page_line"></div>
<div class="clear"></div>
</div>
</div>
<!--End Container-->
</div>
<div class="clear"></div>
<!--Start Footer Wrapper-->
<div class="footer_wrapper">
    <div class="container_24">
        <div class="grid_24">
            <?php
            /**
             * Footer widgets 
             */
            get_sidebar('footer');
            ?>
        </div>
    </div>
</div>
<!--End Footer Wrapper-->
<div class="clear"></div>
<!--Start Footer Bottom-->
<div class="footer_bottom">
    <div class="container_24">
        <div class="grid_24">
            <div class="grid_7 alpha">
                <ul class="social_icon">                               
                    <?php if (business_directory_get_option('facebook') != '') { ?>
                        <li class="facebook"><a target="new" href="<?php echo esc_url(business_directory_get_option('facebook')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/fb1.png'); ?>" alt="facebook" title="Facebook"/>
                            </a></li>
                        <?php
                    }
                    if (business_directory_get_option('twitter') != '') {
                        ?>
                        <li class="twitter"><a target="new" href="<?php echo esc_url(business_directory_get_option('twitter')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/tw1.png'); ?>" alt="twitter" title="Twitter"/>
                            </a></li>
                        <?php
                    }
                    if (business_directory_get_option('rss') != '') {
                        ?>
                        <li class="rss"><a target="new" href="<?php echo esc_url(business_directory_get_option('rss')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/rss1.png'); ?>" alt="rss" title="Rss"/>
                            </a></li>
                    <?php } 

                    if (business_directory_get_option('googleplus') != '') {
                        ?>
                        <li class="gplus"><a target="new" href="<?php echo esc_url(business_directory_get_option('googleplus')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/g+.png'); ?>" alt="googleplus" title="googleplus"/>
                            </a></li>
                    <?php } 

                    
                    if (business_directory_get_option('youtube') != '') {
                        ?>
                        <li class="youtube"><a target="new" href="<?php echo esc_url(business_directory_get_option('youtube')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/youtube1.png'); ?>" alt="youtube" title="youtube"/>
                            </a></li>
                    <?php } 

                    if (business_directory_get_option('pinterest') != '') {
                        ?>
                        <li class="pinterest"><a target="new" href="<?php echo esc_url(business_directory_get_option('pinterest')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/p1.png'); ?>" alt="pinterest" title="pinterest"/>
                            </a></li>
                    <?php } 

                    if (business_directory_get_option('instagram') != '') {
                        ?>
                        <li class="instagram"><a target="new" href="<?php echo esc_url(business_directory_get_option('instagram')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/insta1.png'); ?>" alt="instagram" title="instagram"/>
                            </a></li>
                    <?php } 

                    if (business_directory_get_option('tumblr') != '') {
                        ?>
                        <li class="tumblr"><a target="new" href="<?php echo esc_url(business_directory_get_option('tumblr')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/tm1.png'); ?>" alt="tumblr" title="tumblr"/>
                            </a></li>
                    <?php } 

                    if (business_directory_get_option('flickr') != '') {
                        ?>
                        <li class="flickr"><a target="new" href="<?php echo esc_url(business_directory_get_option('flickr')); ?>">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/flickr1.png'); ?>" alt="flickr" title="flickr"/>
                            </a></li>
                    <?php }
                                                                                
                    ?>

                </ul>             
            </div>
            <div class="grid_17 omega">
                <p class="copy_right"><a rel="nofollow" href="<?php echo esc_url('http://wordpress.org/'); ?>" rel="generator"><?php _e('Powered by WordPress', 'business-directory');
                    ?></a>
                    <span class="sep">&nbsp;|&nbsp;</span>
                    <?php
                    $inkthemes_site_url = 'https://www.inkthemes.com/market/geocraft-directory-listing-wordpress-theme/';
                    printf(__('%1$s by %2$s.', 'business-directory'), 'Business Directory', '<a rel="nofollow" href="' . esc_url($inkthemes_site_url) . '" rel="nofollow">InkThemes</a>');
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!--End Footer Bottom-->
<?php wp_footer(); ?>
</body>
</html>
