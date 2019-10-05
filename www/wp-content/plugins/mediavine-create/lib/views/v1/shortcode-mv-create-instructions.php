<?php if ( ! empty( $args['creation']['instructions'] ) ) {
	$instructions = $args['creation']['instructions'];
	$sanitized    = str_replace( '<p><br></p>', '', $instructions );
?>
	<div class="mv-create-instructions">
		<h2 class="mv-create-instructions-title mv-create-title-secondary"><?php esc_html_e( 'Instructions', 'mediavine' ); ?></h2>
		<?php echo wp_kses_post( do_shortcode( $sanitized ) ); ?>
	</div>
<?php
}
