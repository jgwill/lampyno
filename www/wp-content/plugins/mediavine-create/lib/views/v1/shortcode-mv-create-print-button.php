<?php if ( ! $args['print'] ) { ?>
	<form
		class="mv-create-print-form"
		method="get"
		target="_blank"
		action="<?php echo esc_html( get_rest_url( null, '/mv-create/v1/creations/' . $args['creation']['id'] . '/print' ) ); ?>"
		>
		<button
			class="mv-create-print-button"
			data-mv-print="<?php echo esc_html( get_rest_url( null, '/mv-create/v1/creations/' . $args['creation']['id'] . '/print' ) ); ?>"
		>
			<?php esc_html_e( 'Print', 'mediavine' ); ?>
		</button>
	</form>
<?php
}
