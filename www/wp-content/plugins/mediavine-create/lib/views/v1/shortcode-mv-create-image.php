<?php
$mv_create_enable_print_thumbnails = \Mediavine\Settings::get_setting( 'mv_create_enable_print_thumbnails' );
if ( ! $args['print'] || ! empty( $mv_create_enable_print_thumbnails ) ) {
	$img_size = \Mediavine\Create\Creations_Views::get_image_size();

	if ( isset( $args['creation']['images'][ $img_size ] ) ) {
		echo wp_kses_post( $args['creation']['images'][ $img_size ] );
	}
}
