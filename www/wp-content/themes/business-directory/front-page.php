<?php
/**
 * The main front page file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package business_directory
 *
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <!--Start Info bar-->
    <div class="info_bar top"><span class="info_desc"><span class="info_detail">&nbsp;&nbsp;<?php
                if (business_directory_get_option('home_feature_txt') != '') {
                    echo business_directory_get_option('home_feature_txt');
                } else {
                    _e('BUSINESS DIRECTORY LISTING THEME', 'business-directory');
                }
                ?>&nbsp;&nbsp;</span></span><hr class="top_line"></div>
    <!--End Info bar-->
    <div class="clear"></div>
    <div class="grid_16 alpha">
        <div class="featured_content"> 
            <?php get_template_part('loop', 'home'); ?>                 
        </div>
        <div class="clear"></div>
    </div>
    <div class="grid_8 omega">
        <?php get_sidebar(); ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); ?>