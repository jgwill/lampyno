<div class="sidebar">
    <?php if (!dynamic_sidebar('pages-widget-area')) : ?>        
        <h3>
            <?php _e('Categories', 'business-directory'); ?>
        </h3>
        <ul>
            <?php wp_list_categories('title_li'); ?>
        </ul>
        <h3><?php _e('Search:', 'business-directory'); ?></h3>
        <?php get_search_form(); ?>
        <h3>
            <?php _e('Archives', 'business-directory'); ?>
        </h3>
        <ul>
            <?php wp_get_archives('type=monthly'); ?>
        </ul> 		
    <?php endif; // end primary widget area ?>
</div>