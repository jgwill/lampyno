<?php if ( ! empty( $args['creation']['description'] ) ) { ?>
	<?php if ( empty( $args['creation']['description_hide'] ) ) { ?>
	<div class="mv-create-description">
		<?php echo wp_kses( wpautop( $args['creation']['description'] ), $args['allowed_html'] ); ?>
	</div>
	<?php } ?>
<?php
}
