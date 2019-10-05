<?php
/**
 * The Search Page.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="featured_content">
            <h1>
                <?php
                if (isset($_GET)) {
                    $search_for = $_GET['s'];
                    printf(__('You searched for: %s', 'business-directory'), $search_for);
                }
                ?>
            </h1>     
            <?php if (have_posts()) : ?>  
                <!--Start Post-->               
                <?php
                get_template_part('loop');
                ?>
                <!--End Post-->
                <?php
                business_directory_pagination();
            else:
                ?>
                <article id="post-0" class="post no-results not-found">
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <?php _e('Nothing Found', 'business-directory'); ?>
                        </h1>
                    </header>
                    <!-- .entry-header -->
                    <div class="entry-content">
                        <p>
                            <?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'business-directory'); ?>
                        </p>
                        <?php get_search_form(); ?>                        
                    </div>
                    <!-- .entry-content -->
                </article>
            <?php endif; ?>
        </div>
    </div>
    <div class="grid_8 omega">
        <?php get_sidebar(); ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); ?>