<?php if ( ! empty( $args['creation']['notes'] ) ) { ?>
	<div class="mv-create-notes">
		<h2 class="mv-create-notes-title mv-create-title-secondary"><?php esc_html_e( 'Notes', 'mediavine' ); ?></h2>
		<div class="mv-create-notes-content">
			<p><?php echo wp_kses_post( do_shortcode( $args['creation']['notes'] ) ); ?></p>
		</div>
	</div>
<?php
}
