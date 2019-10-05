<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * 
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="featured_content">
            <h1><?php printf(__('Tag Archives: %s', 'business-directory'), '' . single_cat_title('', false) . ''); ?></h1>
            <?php get_template_part('loop', 'index'); ?>
        </div>
    </div>
    <div class="grid_8 omega">
        <?php get_sidebar(); ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); ?>