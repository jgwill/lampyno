<?php
/**
 * Helper functions for the recipe import.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Helper functions for the recipe import.
 *
 * @since      5.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Import_Helper {

	/**
	 * Get image attachment ID from a given URL or sideload the image if not on the website.
	 *
	 * @since	5.2.0
	 * @param	int   $post_id Post to associate the image with.
	 * @param	mixed $url Image URL.
	 */
	public static function get_or_upload_attachment( $post_id, $url ) {
		$url = str_replace( array( "\n", "\t", "\r" ), '', $url );
		$image_id = self::get_attachment_id_from_url( $url );

		if ( $image_id ) {
			return intval( $image_id );
		} else {
			$media = media_sideload_image( $url, $post_id );

			$attachments = get_posts( array(
					'numberposts' => '1',
					'post_parent' => $post_id,
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'orderby' => 'post_date',
					'order' => 'DESC',
				)
			);

			if ( count( $attachments ) > 0 ) {
				return intval( $attachments[0]->ID );
			}
		}

		return false;
	}

	/**
	 * Get image attachment ID from a given URL.
	 * Source: https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
	 *
	 * @since	5.2.0
	 * @param	mixed $attachment_url Image URL.
	 */
	public static function get_attachment_id_from_url( $attachment_url = '' ) {
		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' === $attachment_url ) {
			return;
		}

		// Get the upload directory paths.
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL.
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL.
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) ); // @codingStandardsIgnoreLine
		}

		return $attachment_id;
	}
}
