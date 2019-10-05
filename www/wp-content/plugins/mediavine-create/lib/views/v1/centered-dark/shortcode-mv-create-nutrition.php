<?php
$nutrition = \Mediavine\Create\Creations_Views::get_nutrition_data( (array) $args['creation']['nutrition'] );

if ( $nutrition && $args['enable_nutrition'] ) {
// Check for the existence of a custom field overriding the nutrition message.
$nutrition_disclaimer = \Mediavine\Create\Creations_Views::get_custom_field(
	$args['creation'],
	'mv_create_nutrition_disclaimer'
);

?>
<div class="mv-create-nutrition">

	<div class="mv-create-nutrition-inner">

		<h6 class="mv-create-nutrition-title mv-create-strong"><span><?php esc_html_e( 'Nutrition Information', 'mediavine' ); ?><?php echo ( $args['use_realistic_nutrition_display'] ) ? null : ':'; ?></span></h6>

		<?php if ( ! empty( $nutrition['number_of_servings'] ) ) { ?>
			<span class="mv-create-nutrition-item mv-create-nutrition-yield"><span class="mv-create-nutrition-label mv-create-uppercase"><?php esc_html_e( 'Yield', 'mediavine' ); ?><?php echo ( $args['use_realistic_nutrition_display'] ) ? null : ':'; ?></span> <?php echo esc_html( $nutrition['number_of_servings'] ); ?></span>
		<?php } ?>

		<?php if ( ! empty( $nutrition['serving_size'] ) ) { ?>
			<span class="mv-create-nutrition-item mv-create-nutrition-serving-size"><span class="mv-create-nutrition-label mv-create-uppercase"><?php esc_html_e( 'Serving Size', 'mediavine' ); ?><?php echo ( $args['use_realistic_nutrition_display'] ) ? null : ':'; ?></span> <?php echo esc_html( $nutrition['serving_size'] ); ?></span>
		<?php } ?>

		<br><span class="mv-create-nutrition-amount"><em><?php esc_html_e( 'Amount Per Serving', 'mediavine' ); ?><?php echo ( $args['use_realistic_nutrition_display'] ) ? null : ':'; ?></em></span>

		<?php foreach ( $nutrition['items'] as $item ) { ?>
			<?php echo '<span class="mv-create-nutrition-item mv-create-nutrition-' . esc_html( $item['class'] ) . '"><span class="mv-create-nutrition-label mv-create-uppercase">' . esc_html( $item['label'] ) . '</span> ' . esc_html( $item['value'] ) . esc_html( $item['unit'] ) . '</span>'; ?>
		<?php } ?>

	</div>

	<?php if ( ! empty( $nutrition_disclaimer ) ) { ?>
		<div class="mv-create-nutrition-disclaimer">
			<small><em><?php echo esc_html( $nutrition_disclaimer ); ?></em></small>
		</div>
	<?php } ?>

</div>

<?php if ( $args['ad_density'] ) { ?>
	<div class="mv-create-target-nutrition"><div class="mv-create-target-selector"></div></div>
<?php } ?>

<?php
}
