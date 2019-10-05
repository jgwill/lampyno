<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="grid_16 alpha">
        <div class="content">
            <h1 class="featured_title"><?php the_title(); ?></h1>
            <?php
            while (have_posts()) : the_post();
                the_content();
            endwhile; // end of the loop.  
            ?>
            <div class="comment_section">
                <!--Start Comment list-->
                <?php comments_template('', true); ?>
                <!--End Comment Form-->
            </div>
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
