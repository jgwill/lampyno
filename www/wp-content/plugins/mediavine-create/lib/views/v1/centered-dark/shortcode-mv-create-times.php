<?php
$times = \Mediavine\Create\Creations_Views::prep_creation_times( $args['creation'] );

if ( ! empty( $times ) || ! empty( $args['creation']['yield'] ) ) {
?>

<div class="mv-create-times mv-create-times-<?php echo esc_attr( count( $times ) ); ?>">

	<?php if ( ! empty( $args['creation']['yield'] ) ) { ?>
			<div class="mv-create-time mv-create-time-yield">
				<em class="mv-create-time-label mv-create-lowercase mv-create-strong"><?php esc_html_e( 'Yield', 'mediavine' ); ?>: </em>
				<span class="mv-create-time-format mv-create-uppercase"><?php echo esc_html( $args['creation']['yield'] ); ?></span>
			</div>
	<?php } ?>

	<?php if ( ! empty( $times ) ) { ?>
		<?php foreach ( $times as $time ) { ?>
			<div class="mv-create-time mv-create-time-<?php echo esc_attr( $time['class'] ); ?>">
				<em class="mv-create-time-label mv-create-lowercase mv-create-strong"><?php echo esc_html( $time['label'] ); ?>: </em>
				<span class="mv-create-time-format mv-create-uppercase"><?php echo wp_kses_post( $time['time'] ); ?></span>
			</div>
		<?php } ?>
	<?php } ?>

</div>
<?php
}
