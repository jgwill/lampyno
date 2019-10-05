<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package business_directory
 * 
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="featured_content">         
            <?php
            /* Queue the first post, that way we know
             * what date we're dealing with (if that is the case).
             *
             * We reset this later so we can run the loop
             * properly with a call to rewind_posts().
             */
            if (have_posts())
                the_post();
            ?>
            <h1>
                <?php
                if (is_day()) :
                    printf(__('Daily Archives: %s', 'business-directory'), get_the_date());
                elseif (is_month()) :
                    printf(__('Monthly Archives: %s', 'business-directory'), get_the_date('F Y'));
                elseif (is_year()) :
                    printf(__('Yearly Archives: %s', 'business-directory'), get_the_date('Y'));
                else :
                    printf(__('You searched for: %s', 'business-directory'), '' . get_search_query() . '');
                endif;
                ?>
            </h1>
            <?php
            /* Since we called the_post() above, we need to
             * rewind the loop back to the beginning that way
             * we can run the loop properly, in full.
             */
            rewind_posts();
            /* Run the loop for the archives page to output the posts.
             * If you want to overload this in a child theme then include a file
             * called loop-archives.php and that will be used instead.
             */
            get_template_part('loop', 'archive');
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