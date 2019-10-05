<?php
if (!function_exists('advance_blog_front_page_banner_slider')) :
    /**
     * Front Page Banner Slider
     */
    function advance_blog_front_page_banner_slider()
    {
        if (1 == advance_blog_get_option('enable_banner_slider')) {
            $banner_slider_args = array(
                'post_type' => 'post',
                'cat' => absint(advance_blog_get_option('category_for_banner_slider')),
                'ignore_sticky_posts' => true,
                'posts_per_page' => 4,
            ); ?>
            <?php $rtl_class = 'false';
            if(is_rtl()){ 
                $rtl_class = 'true';
            }?>
            <div class="slick main-slider" data-slick='{"rtl": <?php echo($rtl_class); ?>}'>
            <?php $banner_slider_post_query = new WP_Query($banner_slider_args);
            if ($banner_slider_post_query->have_posts()) :
                while ($banner_slider_post_query->have_posts()) : $banner_slider_post_query->the_post();
                    if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $url = $thumb['0'];
                    } else {
                        $url = '';
                    }
                    ?>
                    <div class="slide-item">
                        <div class="background-src slider-background">
                            <img src="<?php echo esc_url($url); ?>">
                        </div>
                        <div class="slide-content">
                            <div class="slide-text-wrapper">
                                <div class="entry-header">
                                    <div class="entry-header-wrapper">
                                        <div class="entry-meta post-category">
                                            <?php advance_blog_category(); ?>
                                        </div>
                                        <h3 class="entry-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        <div class="entry-meta">
                                            <div class="meta">
                                                <?php advance_blog_posted_on(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            echo '</div>';
        }
    }
endif;
advance_blog_front_page_banner_slider();