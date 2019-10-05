<!--Start Sidebar-->
<div class="sidebar">
    <?php
    /**
     * Sidebar widget for blog page
     * This file only includes widgets from
     * Blog widget area 
     */
    if (is_active_sidebar('blog-widget-area')):
        dynamic_sidebar('blog-widget-area');
    endif;
    ?>
</div>
<!--End Sidebar-->