<?php
if (have_posts()) :
    while (have_posts()): the_post();
        ?>
        <!--Start Featured Post-->
        <div <?php post_class('featured_post post'); ?> id="post-<?php the_ID(); ?>">
            <!--Start Featured thumb-->
            <!--End Featured thumb-->
            <div class="f_post_content">
                <h1 class="f_post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'business-directory'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
                <div class="post_meta">
                    <ul class="meta-nav">
                        <li class="author"><?php echo _e('By ', 'business-directory'); ?><?php printf('%s', the_author_posts_link()); ?></li>
                        <li class="date"><?php the_time('M-j-Y') ?></li>
                        <li class="category"><?php the_category(', '); ?></li>
                        <li class="comment"><?php comments_popup_link(__('0 Comments.', 'business-directory'), __('1 Comment.', 'business-directory'), __('% Comments.', 'business-directory')); ?></li>
                    </ul>
                </div>
                <div class="featured_thumb blog">
                    <?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('post_thumbnail', array('class' => 'postimg')); ?>
                        </a>
                        <?php
                    } else {
                        echo business_directory_main_image();
                    }
                    ?>
                </div><?php the_excerpt(); ?>
            </div>
        </div>
        <!--End Featured Post-->
        <?php
    endwhile;
    business_directory_pagination();
    wp_reset_query();
else:
    ?>
    <div class="featured_post featured">
        <p class="place"><?php _e('No post found.', 'business-directory'); ?></p>
    </div>
<?php
endif;
?>