<?php
// Default the author to the text stored in the global settings. Then check for the existence of a
// custom field overriding the affiliate message. If it exists, use the custom field for this card.
$copyright = null;
if ( ! empty( $args['creation']['create_settings'] ) ) {
	$copyright = $args['creation']['create_settings'][ \Mediavine\Create\Plugin::$settings_group . '_copyright_attribution' ];
	if ( ! empty( $args['creation']['author'] ) ) {
		$copyright = $args['creation']['author'];
	}
}
?>

<div class="mv-create-footer-flexbox">

	<?php if ( $copyright ) { ?>
		<div class="mv-create-copy">&copy; <?php echo wp_kses_post( $copyright ); ?></div>
	<?php } ?>

	<div class="mv-create-categories">

		<?php
		if ( ! empty( $args['creation']['secondary_term_name'] ) ) {
		?>
			<span class="mv-create-cuisine">
				<strong class="mv-create-uppercase mv-create-strong">
					<?php echo esc_html( $args['creation']['secondary_term_label'] ); ?>:
				</strong>
				<?php echo esc_html( $args['creation']['secondary_term_name'] ); ?>
			</span>
			<?php if ( ! empty( $args['creation']['category_name'] ) ) { ?>
				<span class="mv-create-spacer">/</span>
			<?php } ?>
		<?php } ?>

		<?php if ( ! empty( $args['creation']['category_name'] ) ) { ?>
			<span class="mv-create-category"><strong class="mv-create-uppercase mv-create-strong"><?php esc_html_e( 'Category', 'mediavine' ); ?>:</strong> <?php echo esc_html( $args['creation']['category_name'] ); ?></span>
		<?php } ?>

	</div>

	<?php
	if ( isset( $args['creation']['images']['mv_create_vert'] ) ) {
		echo wp_kses_post( $args['creation']['images']['mv_create_vert'] );
	}
	?>

</div>
