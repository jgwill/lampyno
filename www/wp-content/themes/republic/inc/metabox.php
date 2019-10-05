<?php
/**
 * Add meta box
 *
 */
function republicsingle_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Post Layout Select [Pro Only]', 'republic' ), 'republicsingle_build_meta_box', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'republicsingle_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function republicsingle_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'republicsinglemeta_meta_box_nonce' );
	// retrieve the _republic_republicsinglemeta current value
	$current_republicsinglemeta = get_post_meta( $post->ID, '_republic_republicsinglemeta', true );


	?>
	<div class='inside'>

		<h4><?php echo sprintf(
		/* translators: %s: post date */
		__( 'Layout Select for current Page only - for website layout please choose from theme options %s', 'republic' ),
		'<a href="' . esc_url( 'http://www.insertcart.com/product/republic-wordpress-theme/' ) . '" rel="bookmark">' . esc_attr__( 'Get Republic Pro', 'republic' ) . '</a>'
	); ?></h4>
		<p>
			<input type="radio" name="republicsinglemeta" value="rsd" <?php checked( $current_republicsinglemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','republic'); ?><br />
			<input type="radio" name="republicsinglemeta" value="ls" <?php checked( $current_republicsinglemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','republic'); ?><br/>
			<input type="radio" name="republicsinglemeta" value="lr" <?php checked( $current_republicsinglemeta, 'lr' ); ?> /> <?php _e('Left - Right Sidebars','republic'); ?> <br/>
			<input type="radio" name="republicsinglemeta" value="fc" <?php checked( $current_republicsinglemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','republic'); ?>
		</p>

		

	</div>
	<?php
}
/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function food_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['republicsinglemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['republicsinglemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// republicsinglemeta string
	if ( isset( $_REQUEST['republicsinglemeta'] ) ) {
		update_post_meta( $post_id, '_republic_republicsinglemeta', sanitize_text_field( $_POST['republicsinglemeta'] ) );
	}

}
add_action( 'save_post', 'food_save_meta_box_data' );