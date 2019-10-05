<?php
if (!function_exists('photography_blog_banner_slider_args')):
    /**
     * Banner Slider Details
     *
     * @since Photography Blog 1.0.0
     *
     * @return array $qargs Slider details.
     */
    function photography_blog_banner_slider_args()
    {
        $photography_blog_banner_slider_number = absint(photography_blog_get_option('number_of_home_slider'));
        $photography_blog_banner_slider_from = esc_attr(photography_blog_get_option('select_slider_from'));
        switch ($photography_blog_banner_slider_from) {
            case 'from-page':
                $photography_blog_banner_slider_page_list_array = array();
                for ($i = 1; $i <= $photography_blog_banner_slider_number; $i++) {
                    $photography_blog_banner_slider_page_list = photography_blog_get_option('select_page_for_slider_' . $i);
                    if (!empty($photography_blog_banner_slider_page_list)) {
                        $photography_blog_banner_slider_page_list_array[] = absint($photography_blog_banner_slider_page_list);
                    }
                }
                // Bail if no valid pages are selected.
                if (empty($photography_blog_banner_slider_page_list_array)) {
                    return;
                }
                /*page query*/
                $qargs = array(
                    'posts_per_page' => esc_attr($photography_blog_banner_slider_number),
                    'orderby' => 'post__in',
                    'post_type' => 'page',
                    'post__in' => $photography_blog_banner_slider_page_list_array,
                );
                return $qargs;
                break;

            case 'from-category':
                $photography_blog_banner_slider_category = esc_attr(photography_blog_get_option('select_category_for_slider'));
                $qargs = array(
                    'posts_per_page' => esc_attr($photography_blog_banner_slider_number),
                    'post_type' => 'post',
                    'cat' => $photography_blog_banner_slider_category,
                );
                return $qargs;
                break;

            default:
                break;
        }
        ?>
        <?php
    }
endif;

if (!function_exists('photography_blog_banner_slider')):
    /**
     * Banner Slider
     *
     * @since Photography Blog 1.0.0
     *
     */
    function photography_blog_banner_slider()
    {
        $photography_blog_slider_excerpt_number = absint(photography_blog_get_option('number_of_content_home_slider'));
        if (1 != photography_blog_get_option('show_slider_section')) {
            return null;
        }
        $photography_blog_banner_slider_args = photography_blog_banner_slider_args();
        $photography_blog_banner_slider_query = new WP_Query($photography_blog_banner_slider_args);
        $i = 0;
        ?>
        <div class="slider">
            <?php $rtl_class = 'false';
            if(is_rtl()){ 
                $rtl_class = 'true';
            }?>
            <div id="mainslider" data-slick='{"rtl": <?php echo($rtl_class); ?>}'>
                <?php
                if ($photography_blog_banner_slider_query->have_posts()) :
                    while ($photography_blog_banner_slider_query->have_posts()) : $photography_blog_banner_slider_query->the_post();
                        if (has_excerpt()) {
                            $photography_blog_slider_content = get_the_excerpt();
                        } else {
                            $photography_blog_slider_content = photography_blog_words_count($photography_blog_slider_excerpt_number, get_the_content());
                        }
                        ?>
                        <div class="item">
                            <?php if (has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                $url = $thumb['0']; ?>
                                <img src="<?php echo esc_url($url); ?>" class="img-responsive">
                            <?php } ?>
                            <div class="slide-caption">
                                <div class="wrapper">
                                    <div class="row">
                                        <div class="col col-full">
                                            <h2 class="entry-title slides-title">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>
                                            <div class="divider hidden-mobile"></div>
                                            <div class="excerpt slides-excerpt hidden-mobile">
                                                <?php if ($photography_blog_slider_excerpt_number != 0) { ?>
                                                    <span class="smalltext"><?php echo wp_kses_post($photography_blog_slider_content); ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overlay overlay-enable"></div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
            <?php if ($i > 1) { ?>
                <div class="slidernav">
                    <div class="slidernav-inner">
                        <div class="prev">
                            <svg class="svg-icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32.635 32.635"
                                 style="enable-background:new 0 0 32.635 32.635;" xml:space="preserve">
							<g>
                                <path d="M32.135,16.817H0.5c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h31.635c0.276,0,0.5,0.224,0.5,0.5S32.411,16.817,32.135,16.817z"/>
                                <path d="M13.037,29.353c-0.128,0-0.256-0.049-0.354-0.146L0.146,16.669C0.053,16.575,0,16.448,0,16.315s0.053-0.26,0.146-0.354L12.684,3.429c0.195-0.195,0.512-0.195,0.707,0s0.195,0.512,0,0.707L1.207,16.315l12.184,12.184c0.195,0.195,0.195,0.512,0,0.707C13.293,29.304,13.165,29.353,13.037,29.353z"/>
                            </g>
						</svg>
                        </div>
                        <div class="next">
                            <svg class="svg-icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32.635 32.635"
                                 style="enable-background:new 0 0 32.635 32.635;" xml:space="preserve">
							<g>
                                <path d="M32.135,16.817H0.5c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h31.635c0.276,0,0.5,0.224,0.5,0.5S32.411,16.817,32.135,16.817z"/>
                                <path d="M19.598,29.353c-0.128,0-0.256-0.049-0.354-0.146c-0.195-0.195-0.195-0.512,0-0.707l12.184-12.184L19.244,4.136c-0.195-0.195-0.195-0.512,0-0.707s0.512-0.195,0.707,0l12.537,12.533c0.094,0.094,0.146,0.221,0.146,0.354s-0.053,0.26-0.146,0.354L19.951,29.206C19.854,29.304,19.726,29.353,19.598,29.353z"/>
                            </g>
						</svg>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <!-- end slider-section -->
        <?php
    }
endif;
add_action('photography_blog_action_slider_post', 'photography_blog_banner_slider', 10);

// end of slider
// start for single page/post header
if (!function_exists('photography_blog_single_title')):
    /**
     * Single Header
     *
     * @since Photography Blog 1.0.0
     *
     */
    function photography_blog_single_title()
    { ?>
        <div class="inner-banner">
            <div class="banner-media">
                <?php $global_banner_image = get_header_image(); ?>
                <img src="<?php echo esc_url($global_banner_image); ?>">
                <div class="overlay overlay-enable"></div>
            </div>
        </div>
    <?php }
endif;
add_action('photography_blog_action_single', 'photography_blog_single_title', 10);

if (!function_exists('photography_blog_featured_page')):
    /**
     * Featured Page
     *
     * @since Photography Blog 1.0.0
     *
     */
    function photography_blog_featured_page()
    {
        $photography_blog_featured_page = 30;
        if (1 != photography_blog_get_option('enable_featured_page_section')) {
            return null;
        }
        $photography_blog_featured_page_array[] = absint(photography_blog_get_option('select_featured_page'));

        $photography_blog_featured_page_args = array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'post__in' => $photography_blog_featured_page_array,
        );
        $photography_blog_featured_page_query = new WP_Query($photography_blog_featured_page_args);
        if ($photography_blog_featured_page_query->have_posts()) :
            while ($photography_blog_featured_page_query->have_posts()) : $photography_blog_featured_page_query->the_post();
                ?>
                <section class="united-block intro-section">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col col-full text-center">
                                <h2 class="title-header alt-font">
                                    <?php the_title(); ?>
                                </h2>
                                <div class="title-seperator"></div>
                                <div class="section-excerpt">
                                    <div class="excerpt">
                                        <?php if (has_excerpt()) {
                                            $photography_blog_featured_content = get_the_excerpt();
                                        } else {
                                            $photography_blog_featured_content = photography_blog_words_count($photography_blog_featured_page, get_the_content());
                                        }
                                        echo wp_kses_post($photography_blog_featured_content);
                                        ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>"
                                       class="btn btn-link"><?php echo esc_html(photography_blog_get_option('featured_page_button_text')); ?></a>
                                    <?php
                                    $pb_button_text = esc_html(photography_blog_get_option('featured_page_additional_button_text'));
                                    if(!empty($pb_button_text)){ ?>
                                    <a href="<?php echo esc_url(photography_blog_get_option('featured_page_additional_button_link')) ?>"
                                       class="btn btn-link"><?php echo esc_html(photography_blog_get_option('featured_page_additional_button_text')); ?></a>
                                   <?php }?>
                                </div>
                            </div>
                        </div>
                </section>
                <?php
                wp_reset_postdata();
            endwhile;
        endif;
    }
endif;
add_action('photography_blog_action_featured_page', 'photography_blog_featured_page', 10);


if (!function_exists('photography_blog_featured_blog')):
    /**
     * Featured Blog
     *
     * @since Photography Blog 1.0.0
     *
     */
    function photography_blog_featured_blog()
    {
        if (1 != photography_blog_get_option('enable_featured_blog')) {
            return null;
        }

        $photography_blog_featured_blog_args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'cat' => absint(photography_blog_get_option('select_category_for_featured_blog')),
        ); ?>
        <section class="united-block photo-gallery-section">
            <div class="wrapper">
            <div class="row">
            <?php $photography_blog_featured_blog_query = new WP_Query($photography_blog_featured_blog_args);
            if ($photography_blog_featured_blog_query->have_posts()) :
                while ($photography_blog_featured_blog_query->have_posts()) : $photography_blog_featured_blog_query->the_post();
                    if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $large_image = $thumb['0'];
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'photography-blog-720-480');
                        $small_image = $thumb['0'];
                    }else {
                        $large_image = '';
                        $small_image = '';
                    }
                    ?>
                    <div class="col col-three-1">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="photo-grid">
                                <div class="photo-wrapper zoom-gallery">
                                    <a href="<?php echo esc_url($large_image); ?>" class="zoom-image">
                                        <?php
                                        echo '<img src="' . esc_url($small_image) . '">';
                                        ?>
                                    </a>
                                </div>
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="entry-meta">
                                        <?php
                                        photography_blog_posted_on();
                                        ?>
                                    </div><!-- .entry-meta -->
                                </header>
                            </div>
                        </article>
                    </div>
                    <?php
                    wp_reset_postdata();
                endwhile; ?>
                </div>
                </div>
            </section>
        <?php endif;
    }
endif;
add_action('photography_blog_action_featured_page', 'photography_blog_featured_blog', 20);

/**
 * Metabox.
 *
 * @package Photography-Blog
 */

if ( ! function_exists( 'photography_blog_add_meta_box' ) ) :

    /**
     * Add the Meta Box
     *
     * @since 1.0.0
     */
    function photography_blog_add_meta_box() {

        $meta_box_on = array( 'post', 'page' );

        foreach ( $meta_box_on as $meta_box_as ) {
            add_meta_box(
                'photography-blog-theme-settings',
                esc_html__( 'Layout Options', 'photography-blog' ),
                'photography_blog_render_layout_option_metabox',
                $meta_box_as,
                'side',
                'low'
            );
        }

    }

endif;

add_action( 'add_meta_boxes', 'photography_blog_add_meta_box' );

if ( ! function_exists( 'photography_blog_render_layout_option_metabox' ) ) :

    /**
     * Render theme settings meta box.
     *
     * @since 1.0.0
     */
    function photography_blog_render_layout_option_metabox( $post, $metabox ) {

        $post_id = $post->ID;
        $photography_blog_post_meta_value = get_post_meta($post_id);

        // Meta box nonce for verification.
        wp_nonce_field( basename( __FILE__ ), 'photography_blog_meta_box_nonce' );
        ?>
        <div id="pb_metabox-container" class="pb-metabox-container">
            <div id="pb-metabox-layout">
                <div class="row-content">
                    <p>
                        <div class="pb-row-content">
                            <label for="photography-blog-meta-checkbox">
                                <input type="checkbox" name="photography-blog-meta-checkbox" id="photography-blog-meta-checkbox"
                                       value="yes" <?php if (isset ($photography_blog_post_meta_value['photography-blog-meta-checkbox'])) checked($photography_blog_post_meta_value['photography-blog-meta-checkbox'][0], 'yes'); ?> />
                                <?php _e('Disable Featured Image on single page', 'photography-blog') ?>
                            </label>
                        </div>
                    </p>
                </div>
            </div>
        </div>

        <?php
    }

endif;



if ( ! function_exists( 'photography_blog_save_settings_meta' ) ) :

    /**
     * Save meta box value.
     *
     * @since 1.0.0
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post object.
     */
    function photography_blog_save_settings_meta( $post_id, $post ) {

        // Verify nonce.
        if ( ! isset( $_POST['photography_blog_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['photography_blog_meta_box_nonce'], basename( __FILE__ ) ) ) {
            return; }

        // Bail if auto save or revision.
        if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
            return;
        }

        // Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
        if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
            return;
        }

        // Check permission.
        if ( 'page' === $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return; }
        } else if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $photography_blog_meta_checkbox = isset($_POST['photography-blog-meta-checkbox']) ? esc_attr($_POST['photography-blog-meta-checkbox']) : '';
        update_post_meta($post_id, 'photography-blog-meta-checkbox', sanitize_text_field($photography_blog_meta_checkbox));

    }

endif;

add_action( 'save_post', 'photography_blog_save_settings_meta', 10, 2 );