<?php
/**
 * The template for displaying Category pages.
 *
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="featured_content">
            <h1 class="featured_title"><?php printf(__('Category Archives: %s', 'business-directory'), '' . single_cat_title('', false) . ''); ?></h1>
            <?php
            if (have_posts()) :
                $category_description = category_description();
                if (!empty($category_description))
                    echo '' . $category_description . '';
                /* Run the loop for the category page to output the posts.
                 * If you want to overload this in a child theme then include a file
                 * called loop-category.php and that will be used instead.
                 */
                get_template_part('loop', 'category');
                ?>
                <div class="clear"></div>
                <?php
                business_directory_pagination();
            endif;
            ?>
        </div>
    </div>
    <div class="grid_8 omega">
        <?php
        get_sidebar();
        ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); ?>