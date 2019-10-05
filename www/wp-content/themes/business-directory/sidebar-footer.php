<?php
/**
 * The Footer widget areas.
 *
 * @package business-directory
 * @since 1.0
 */
?>
<div class="grid_6 alpha">
    <div class="footer_widget">
        <?php
        if (is_active_sidebar('first-footer-widget-area')) :
            dynamic_sidebar('first-footer-widget-area');
        else :
            ?>
            <h5><?php _e('About This Site', 'business-directory'); ?></h5>
            <p><?php _e('A cras tincidunt, ut  tellus et. Gravida scel ipsum sed iaculis, nunc non nam. Placerat sed phase llus, purus purus elit.', 'business-directory'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="grid_6">
    <div class="footer_widget">
        <?php
        if (is_active_sidebar('second-footer-widget-area')) :
            dynamic_sidebar('second-footer-widget-area');
        else:
            ?>
            <h5><?php _e('Archives Widget', 'business-directory'); ?></h5>
            <ul>
                <li><a href="#"><?php _e('January 2010', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('December 2009', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('November 2009', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('October 2009', 'business-directory'); ?></a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<div class="grid_6">
    <div class="footer_widget">
        <?php
        if (is_active_sidebar('third-footer-widget-area')) :
            dynamic_sidebar('third-footer-widget-area');
        else:
            ?>
            <h5><?php _e('Categories', 'business-directory'); ?></h5>
            <ul>
                <li><a href="#"><?php _e('Entertainment', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('Technology', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('Sports & Recreation', 'business-directory'); ?></a></li>
                <li><a href="#"><?php _e('Jobs & Lifestyle', 'business-directory'); ?></a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<div class="grid_6 omega">
    <div class="footer_widget last">
        <?php
        if (is_active_sidebar('fourth-footer-widget-area')) :
            dynamic_sidebar('fourth-footer-widget-area');
        else:
            ?>
            <h5><?php _e('Search', 'business-directory') ?></h5>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</div>