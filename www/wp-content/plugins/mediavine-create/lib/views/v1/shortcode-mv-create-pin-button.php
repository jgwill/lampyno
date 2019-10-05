<?php if (
	! $args['print'] &&
	isset( $args['creation']['pinterest_display'] ) &&
	$args['creation']['pinterest_display'] &&
	! empty( $args['pinterest']['url'] ) &&
	! empty( $args['pinterest']['img'] )
) { ?>
	<div
		class="mv-pinterest-btn <?php echo esc_attr( $args['creation']['pinterest_class'] ); ?>"
		data-mv-pinterest-desc="<?php echo esc_attr( rawurlencode( $args['pinterest']['description'] ) ); ?>"
		data-mv-pinterest-img-src="<?php echo esc_attr( rawurlencode( $args['pinterest']['img'] ) ); ?>"
		data-mv-pinterest-url="<?php echo esc_attr( rawurlencode( $args['pinterest']['url'] ) ); ?>"
	></div>
<?php
}
