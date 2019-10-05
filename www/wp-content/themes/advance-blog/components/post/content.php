<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Advance_Blog
 */
global $advance_blog_post_counter;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($advance_blog_post_counter % 2 == 0) {
        $content_class = '';
        $content_class = 'style-bordered-right';
        } else {
        $content_class = 'style-bordered-left';
        }
    if(!has_post_thumbnail()){
        $content_class = 'style-bordered-no-image';
    }
    $background_color_single_post = get_post_meta($post->ID, 'advance_blog_background_color', true);
    $text_color_single_post = get_post_meta($post->ID, 'advance_blog_text_color', true);

    ?>
    <div class="style-archive style-bordered <?php echo esc_attr($content_class); ?>">
        <?php if ( '' != get_the_post_thumbnail() ) : ?>
            <div class="post-thumbnail" data-mh="equal-height">
                <a href="<?php the_permalink(); ?>" class="background">
                    <?php the_post_thumbnail( 'advance-blog-featured-image' ); ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="post-content" data-mh="equal-height" style="background-color: <?php echo esc_attr($background_color_single_post); ?>; color: <?php  echo esc_attr($text_color_single_post); ?>;">
            <header class="entry-header">
                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" >', '</a></h2>' );

                if ( 'post' === get_post_type() ) : ?>
                <?php get_template_part( 'components/post/content', 'meta' ); ?>
                <?php
                endif; ?>
            </header>
            <div class="entry-content">
                <?php
                the_excerpt();
                ?>

                <a href="<?php the_permalink(); ?>" class="btn-main"><?php _e('Continue Reading','advance-blog'); ?></a>
            </div>
        </div>
    </div>
    <?php $advance_blog_post_counter++; ?>
</article><!-- #post-## -->