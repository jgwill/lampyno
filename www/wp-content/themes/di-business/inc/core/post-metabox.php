<?php
/**
 * Class to add meta box for post.
 *
 */

// Do if is admin only.
if( is_admin() ) {
    add_action( 'load-post.php', 'di_business_post_meta_box_first_func' );
    add_action( 'load-post-new.php', 'di_business_post_meta_box_first_func' );
}

/**
 * Calls the class on the post edit screen.
 */
function di_business_post_meta_box_first_func() {
    new Di_Business_Post_Meta_Box_Main_Class();
}
 
/**
 * The Class.
 */
class Di_Business_Post_Meta_Box_Main_Class {
 
    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post',      array( $this, 'save' ) );
    }
 
    /**
     * Adds the meta box container.
     */
    public function add_meta_box( $post_type ) {
        if ( $post_type == 'post' ) {
            add_meta_box(
                'di_business_post_meta_box_cntnr',
                __( 'Di Business Theme Options for this Post', 'di-business' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'normal',
                'default'
            );
        }
    }

     /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'di_business_post_meta_bx_key', 'di_business_post_meta_bx_key_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $hide_footer_widgets 	= get_post_meta( $post->ID, '_di_business_hide_footer_widgets', true );
        $hide_hdrimg            = get_post_meta( $post->ID, '_di_business_hide_hdrimg', true );
        ?>

        <p>
        <label style="padding-right: 7px;" for="hide_footer_widgets">
            <?php _e( 'Want to hide Footer Widgets? ', 'di-business' ); ?>
        </label>
        <input type="checkbox" id="hide_footer_widgets" name="hide_footer_widgets_val" <?php checked( $hide_footer_widgets, '1' ); ?> /> <?php _e( 'Info: This will hide footer widget section, if you are using footer widget.', 'di-business' ); ?>
        </p>

        <p>
        <label style="padding-right: 16px;" for="hide_hdrimg">
            <?php _e( 'Want to hide header image? ', 'di-business' ); ?>
        </label>
        <input type="checkbox" id="hide_hdrimg" name="hide_hdrimg_val" <?php checked( $hide_hdrimg, '1' ); ?> /> <?php _e( 'Info: This will hide header image. if you are using header image.', 'di-business' ); ?>
        </p>

        <?php
        do_action( 'di_business_post_metabox_render', $post );
    }
 
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ) {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if( ! isset( $_POST['di_business_post_meta_bx_key_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = wp_unslash( $_POST['di_business_post_meta_bx_key_nonce'] );
 
        // Verify that the nonce is valid.
        if( ! wp_verify_nonce( $nonce, 'di_business_post_meta_bx_key' ) ) {
            return $post_id;
        }
 
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the post type.
        if( $_POST['post_type'] != 'post' ) {
        	return $post_id;
        }

        // Check current user permission.
        if( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
 
        /* OK, it's safe for us to save the data now. */

        // Store 0 or 1 for footer_widgets.
        $saveit = ( isset( $_POST['hide_footer_widgets_val'] ) && 'on' === $_POST['hide_footer_widgets_val'] ) ? '1' : '0';
        update_post_meta( $post_id, '_di_business_hide_footer_widgets', $saveit );

        // Store 0 or 1 for hide_hdrimg.
        $saveit = ( isset( $_POST['hide_hdrimg_val'] ) && 'on' === $_POST['hide_hdrimg_val'] ) ? '1' : '0';
        update_post_meta( $post_id, '_di_business_hide_hdrimg', $saveit );

        do_action( 'di_business_post_metabox_save', $post_id );
        
    }

}
