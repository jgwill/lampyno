<div class="mv-create-title-wrap">

	<?php if ( ! empty( $args['creation']['yield'] ) ) { ?>
		<span class="mv-create-yield mv-create-uppercase"><?php esc_html_e( 'Yield', 'mediavine' ); ?>: <?php echo esc_html( $args['creation']['yield'] ); ?></span>
	<?php } ?>

	<?php if ( empty( $args['creation']['title_hide'] ) ) { ?>
		<h1 class="mv-create-title mv-create-title-primary"><?php echo esc_html( $args['creation']['title'] ); ?></h1>
	<?php } ?>
</div>
