<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Advance_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $single_post_featured_image = get_post_meta($post->ID, 'advance-blog-meta-checkbox', true);
     if ($single_post_featured_image == '') { ?>
        <?php if ( '' != get_the_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'full' ); ?>
                </a>
            </div>
        <?php endif; ?>
    <?php } ?>

    <header class="entry-header">
        <?php
        the_title( '<h1 class="entry-title">', '</h1>' );
        ?>
    </header>
    <div class="entry-content">
        <?php
        the_content( sprintf(
        /* translators: %s: Name of current post. */
            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'advance-blog' ), array( 'span' => array( 'class' => array() ) ) ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ) );

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'advance-blog' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>
    <?php get_template_part( 'components/post/content', 'footer' ); ?>
</article><!-- #post-## -->