<?php
/**
 * Implement metabox.
 */

if (!function_exists('advance_blog_add_theme_meta_box')) :

    /**
     * Add the Meta Box
     *
     * @since 1.0.0
     */
    function advance_blog_add_theme_meta_box()
    {

        $apply_metabox_post_types = array('post', 'page');

        foreach ($apply_metabox_post_types as $key => $type) {
            add_meta_box(
                'advance-blog-theme-settings',
                esc_html__('Single Page/Post Settings', 'advance-blog'),
                'advance_blog_render_theme_settings_metabox',
                $type
            );
        }

    }

endif;

add_action('add_meta_boxes', 'advance_blog_add_theme_meta_box');

add_action( 'admin_enqueue_scripts', 'advance_blog_backend_scripts');
if ( ! function_exists( 'advance_blog_backend_scripts' ) ){
    function advance_blog_backend_scripts( $hook ) {
        if(('post.php' === $hook) ||('page.php' === $hook) || ('page-new.php' === $hook)||('post-new.php' === $hook)){
            wp_enqueue_style( 'wp-color-picker');
            wp_enqueue_script( 'wp-color-picker');
        }
    }
}

if (!function_exists('advance_blog_render_theme_settings_metabox')) :

    /**
     * Render theme settings meta box.
     *
     * @since 1.0.0
     */
    function advance_blog_render_theme_settings_metabox($post, $metabox)
    {

        $post_id = $post->ID;
        $advance_blog_post_meta_value = get_post_meta($post_id);

        // Meta box nonce for verification.
        wp_nonce_field(basename(__FILE__), 'advance_blog_meta_box_nonce');
        // Fetch Options list.

        $advance_blog_meta = get_post_custom( $post->ID );
        $bg_color = ( isset( $advance_blog_meta['advance_blog_background_color'][0] ) ) ? $advance_blog_meta['advance_blog_background_color'][0] : '';
        $text_color = ( isset( $advance_blog_meta['advance_blog_text_color'][0] ) ) ? $advance_blog_meta['advance_blog_text_color'][0] : '';
        ?>
        <script>
            jQuery(document).ready(function($){
                $('.color_field').each(function(){
                    $(this).wpColorPicker();
                });
            });
        </script>
        <div class="pagebox">
            <label for="meta-checkbox">
                <input type="checkbox" name="advance-blog-meta-checkbox" id="advance-blog-meta-checkbox"
                       value="yes" <?php if (isset ($advance_blog_post_meta_value['advance-blog-meta-checkbox'])) checked($advance_blog_post_meta_value['advance-blog-meta-checkbox'][0], 'yes'); ?> />
                <?php _e('Check To dissable Featured Image from single page', 'advance-blog') ?>
            </label>
        </div>
        <div class="pagebox">
            <p><?php esc_attr_e('Choose a color for your Post Backgorund.', 'advance-blog' ); ?></p>
            <input class="color_field" type="text" name="advance_blog_background_color" value="<?php echo esc_html( $bg_color ); ?>"/>
        </div>

        <div class="pagebox">
            <p><?php esc_attr_e('Choose a color for your Post Text.', 'advance-blog' ); ?></p>
            <input class="color_field" type="text" name="advance_blog_text_color" value="<?php echo esc_html( $text_color ); ?>"/>
        </div>
        <?php
    }

endif;


if (!function_exists('advance_blog_save_theme_settings_meta')) :

    /**
     * Save theme settings meta box value.
     *
     * @since 1.0.0
     *
     * @param int $post_id Post ID.
     * @param WP_Post $post Post object.
     */
    function advance_blog_save_theme_settings_meta($post_id, $post)
    {

        // Verify nonce.
        if (!isset($_POST['advance_blog_meta_box_nonce']) || !wp_verify_nonce($_POST['advance_blog_meta_box_nonce'], basename(__FILE__))) {
            return;
        }

        // Bail if auto save or revision.
        if (defined('DOING_AUTOSAVE') || is_int(wp_is_post_revision($post)) || is_int(wp_is_post_autosave($post))) {
            return;
        }

        // Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
        if (empty($_POST['post_ID']) || $_POST['post_ID'] != $post_id) {
            return;
        }

        // Check permission.
        if ('page' === $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else if (!current_user_can('edit_post', $post_id)) {
            return;
        }
         $advance_blog_meta_checkbox = isset($_POST['advance-blog-meta-checkbox']) ? esc_attr($_POST['advance-blog-meta-checkbox']) : '';
        update_post_meta($post_id, 'advance-blog-meta-checkbox', sanitize_text_field($advance_blog_meta_checkbox));


        $advance_blog_background_color = (isset($_POST['advance_blog_background_color']) && $_POST['advance_blog_background_color']!='') ? esc_attr($_POST['advance_blog_background_color']) : '';
        update_post_meta($post_id, 'advance_blog_background_color', sanitize_hex_color($advance_blog_background_color));

        $advance_blog_text_color = (isset($_POST['advance_blog_text_color']) && $_POST['advance_blog_text_color']!='') ? esc_attr($_POST['advance_blog_text_color']) : '';
        update_post_meta($post_id, 'advance_blog_text_color', sanitize_hex_color($advance_blog_text_color));

    }

endif;

add_action('save_post', 'advance_blog_save_theme_settings_meta', 10, 3);