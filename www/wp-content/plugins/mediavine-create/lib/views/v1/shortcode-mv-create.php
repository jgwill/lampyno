<?php
if ( $args['creation'] ) {
	$custom_class = \Mediavine\Create\Creations_Views::get_custom_field( $args['creation'], 'class' );
	/**
	 * mv_create_card_before hook.
	 *
	 * @hooked mv_creation_json_ld - 10
	 */
	do_action( 'mv_create_card_before', $args );
	?>

	<section id="mv-creation-<?php echo esc_attr( $args['creation']['id'] ); ?>" class="<?php echo esc_attr( $args['creation']['classes'] ); ?> <?php echo esc_attr( $custom_class ); ?>" style="position: relative;">
		<?php
		/**
		 * mv_create_card_before_wrapper hook.
		 */
		do_action( 'mv_create_card_before_wrapper', $args );
		?>

		<div class="mv-create-wrapper">

			<?php
			/**
			 * mv_create_card_before_header hook.
			 */
			do_action( 'mv_create_card_before_header', $args );
			?>

			<header class="mv-create-header">
				<?php
				/**
				 * mv_create_card_header hook.
				 *
				 * @hooked mv_creation_title - 10
				 * @hooked mv_create_pin_button - 20
				 * @hooked mv_creation_image_container - 30
				 * @hooked mv_creation_description - 40
				 */
				do_action( 'mv_create_card_header', $args );
				?>
			</header>

			<?php
			/**
			 * mv_create_card_content hook.
			 *
			 * @hooked mv_creation_times - 10
			 * @hooked mv_creation_ad_div - 20
			 * @hooked mv_creation_ingredients - 30
			 * @hooked mv_creation_instructions - 40
			 * @hooked mv_creation_notes - 50
			 * @hooked mv_creation_video - 60
			 * @hooked mv_creation_products - 70
			 * @hooked mv_creation_nutrition - 80
			 */
			do_action( 'mv_create_card_content', $args );
			?>

		</div>

		<footer class="mv-create-footer">
			<?php
			/**
			 * mv_create_card_footer hook.
			 *
			 * @hooked mv_creation_footer - 10
			 */
			do_action( 'mv_create_card_footer', $args );
			?>
		</footer>

		<?php
		/**
		 * mv_create_card_after_footer hook.
		 */
		do_action( 'mv_create_card_after_footer', $args );
		?>

	</section>

	<?php
	/**
	 * mv_create_card_after hook.
	 */
	do_action( 'mv_create_card_after', $args );

}
