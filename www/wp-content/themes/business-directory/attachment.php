<?php
/**
 * The template for displaying attachments.
 *
 * @package WordPress
 * 
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="content_wrapper">
    <div class="fullwidth attachment">
        <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <p><a href="<?php echo get_permalink($post->post_parent); ?>" title="<?php esc_attr(printf(__('Return to %s', 'business-directory'), get_the_title($post->post_parent))); ?>" rel="gallery">
                        <?php
                        /* translators: %s - title of parent post */
                        printf(__('<span>&larr;</span> %s', 'business-directory'), get_the_title($post->post_parent));
                        ?>
                    </a></p>
                <h2>
                    <?php the_title(); ?>
                </h2>
                <?php
                printf(__('By %2$s', 'business-directory'), 'meta-prep meta-prep-author', sprintf('<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'business-directory'), get_the_author()), get_the_author()
                        )
                );
                ?>
                <span>|</span>
                <?php
                printf(__('Published %2$s', 'business-directory'), 'meta-prep meta-prep-entry-date', sprintf('<abbr title="%1$s">%2$s</abbr>', esc_attr(get_the_time()), get_the_date()
                        )
                );
                if (wp_attachment_is_image()) {
                    echo ' | ';
                    $metadata = wp_get_attachment_metadata();
                    printf(__('Full Size', 'business-directory'), sprintf('<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>', wp_get_attachment_url(), __('Link to full-size image', 'business-directory'), $metadata['width'], $metadata['height']
                            )
                    );
                }
                edit_post_link('edit', '', '');
                ?>
                <!-- .entry-meta -->
                <?php
                if (wp_attachment_is_image()) :
                    $attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));
                    foreach ($attachments as $k => $attachment) {
                        if ($attachment->ID == $post->ID)
                            break;
                    }
                    $k++;
                    // If there is more than 1 image attachment in a gallery
                    if (count($attachments) > 1) {
                        if (isset($attachments[$k]))
                        // get the URL of the next image attachment
                            $next_attachment_url = get_attachment_link($attachments[$k]->ID);
                        else
                        // or get the URL of the first image attachment
                            $next_attachment_url = get_attachment_link($attachments[0]->ID);
                    } else {
                        // or, if there's only 1 image attachment, get the URL of the image
                        $next_attachment_url = wp_get_attachment_url();
                    }
                    ?>
                    <p><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment">
                            <?php
                            $attachment_size = apply_filters('business_directory_attachment_size', 1140);
                            echo wp_get_attachment_image($post->ID, array($attachment_size, 9999)); // filterable image width with, essentially, no limit for image height.
                            ?>
                        </a></p>
                    <?php
                    previous_image_link(false);
                    next_image_link(false);
                else :
                    ?>
                    <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php echo basename(get_permalink()); ?></a>
                <?php
                endif;
                if (!empty($post->post_excerpt))
                    the_excerpt();
                the_content(__('Continue reading &rarr;', 'business-directory'));
                wp_link_pages(array('before' => '' . __('Pages:', 'business-directory'), 'after' => ''));
                business_directory_posted_in();
                edit_post_link('edit', ' ', '');
                ?>
                <div class="post-comments">
                    <!--Start Comment box-->
                    <?php comments_template(); ?>
                    <!--End Comment box-->
                </div>
            <?php endwhile; ?>
    </div>
</div>
<!--End Content Wrapper-->
<?php get_footer(); 

