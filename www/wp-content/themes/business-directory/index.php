<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="featured_content">
            <h1 class="featured_title"></h1>    
            <?php get_template_part('loop', 'index'); ?>
        </div>
        <div class="clear"></div>
        <nav id="nav-single"> 
            <span class="nav-next">
                <?php previous_posts_link(__('Newer posts &rarr;', 'business-directory')); ?>
            </span> 
            <span class="nav-previous">
                <?php next_posts_link(__('&larr; Older posts', 'business-directory')); ?>
            </span> 
        </nav>
    </div>
    <div class="grid_8 omega">
        <?php get_sidebar(); ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); ?>