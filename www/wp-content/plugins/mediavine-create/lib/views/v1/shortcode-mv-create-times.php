<?php
$times = \Mediavine\Create\Creations_Views::prep_creation_times( $args['creation'] );

if ( ! empty( $times ) ) {
?>

<div class="mv-create-times mv-create-times-<?php echo esc_attr( count( $times ) ); ?>">

	<?php foreach ( $times as $time ) { ?>
		<div class="mv-create-time mv-create-time-<?php echo esc_attr( $time['class'] ); ?>">
			<strong class="mv-create-time-label mv-create-uppercase mv-create-strong"><?php echo esc_html( $time['label'] ); ?></strong>
			<span class="mv-create-time-format"><?php echo wp_kses_post( $time['time'] ); ?></span>
		</div>
	<?php } ?>

</div>
<?php
}
