<?php
if ( ! $args['print'] ) {
	$has_products = false;
	// Default the affiliate message to the text stored in the global settings. Then check for the existence of a
	// custom field overriding the affiliate message. If it exists, use the custom field for this card.
	$global_affiliate_message = null;
	if ( ! empty( $args['creation']['create_settings']['mv_create_affiliate_message'] ) ) {
		$global_affiliate_message = $args['creation']['create_settings']['mv_create_affiliate_message'];
	}

	$affiliate_message = \Mediavine\Create\Creations_Views::get_custom_field(
		$args['creation'],
		'mv_create_affiliate_message',
		$global_affiliate_message
	);

	if ( ! empty( $args['creation']['products'] ) ) {

		// Build clean HTML for products
		ob_start();

		foreach ( $args['creation']['products'] as $product ) {

			$product = (array) $product;

			if (
				! empty( $product['link'] )
				&& ! empty( $product['title'] )
			) {

				$has_products = true;
				?>

				<li class="mv-create-products-listitem">
					<a class="mv-create-products-link" href="<?php echo esc_html( $product['link'] ); ?>" rel="nofollow noopener" target="_blank">
						<?php if ( ! $args['print'] ) { ?>
							<div class="mv-create-products-imgwrap" id="img-wrap-<?php echo esc_html( $product['id'] ); ?>">
								<img
									class="mv-create-products-img obj-fit no_pin"
									src="
									<?php
										$img_src = wp_get_attachment_image_src( $product['thumbnail_id'], 'mv_create_1x1' );
										echo esc_html( $img_src[0] );
										?>
										"
									alt="<?php echo esc_html( $product['title'] ); ?>"
									nopin="nopin"
								/>
							</div>
						<?php } ?>
						<div class="mv-create-products-product-name">
							<?php echo esc_html( $product['title'] ); ?>
						</div>
					</a>
				</li>

				<?php
			}
		}
		$products_list = ob_get_clean();

	}

	if ( $has_products ) {
		?>
		<div class="mv-create-products">
			<h2 class="mv-create-products-title mv-create-title-secondary"><?php esc_html_e( 'Recommended Products', 'mediavine' ); ?></h2>

			<?php if ( $affiliate_message ) { ?>
				<p class="mv-create-affiliate-disclaimer"><?php echo esc_html( $affiliate_message ); ?></p>
			<?php } ?>

			<ul class="mv-create-products-list">
				<?php echo wp_kses_post( $products_list ); ?>
			</ul>
		</div>
		<?php
	}
}
