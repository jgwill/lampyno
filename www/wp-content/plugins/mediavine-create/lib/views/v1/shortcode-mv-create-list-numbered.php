<div class="mv-list-list mv-list-list-<?php echo esc_attr( $args['creation']['layout'] ); ?>">
	<?php
		$i                        = 0;
		$open_external_in_new_tab = \Mediavine\Settings::get_setting( 'mv_create_external_link_tab' );
		$open_internal_in_new_tab = \Mediavine\Settings::get_setting( 'mv_create_internal_link_tab' );

	foreach ( $args['creation']['list_items'] as $item ) {
		do_action( 'mv_create_list_before_single', $args );

		if ( 'text' === $item['content_type'] ) {
	?>
			<div class="mv-list-text">
				<h2 class="mv-list-single-title"><?php echo esc_html( $item['title'] ); ?></h2>
				<div class="mv-list-single-description"><?php echo wp_kses( wpautop( $item['description'] ), $args['allowed_html'] ); ?></div>
			</div>
			<?php
			} else {
				$target_blank = '';
				if ( $open_external_in_new_tab && isset( $item['content_type'] ) && ( 'external' === $item['content_type'] ) ) {
					$target_blank = 'target="_blank"';
				}
				if ( $open_internal_in_new_tab && isset( $item['content_type'] ) && ( 'external' !== $item['content_type'] ) ) {
					$target_blank = 'target="_blank"';
				}
		?>
		<div class="mv-list-single mv-list-single-<?php echo esc_attr( $item['relation_id'] ); ?>" data-link-href="<?php echo esc_attr( $item['url'] ); ?>" data-list-content-type="<?php echo esc_attr( $item['content_type'] ); ?>">
			<div class="mv-list-item-number">
				<div class="mv-list-item-number-inner" data-derive-font-from="h1">
					<?php echo esc_html( $i + 1 ); ?>
				</div>
			</div>
			<?php
			// Build Pinterest specific args
			$args['pinterest'] = [
				'img'         => $item['pinterest_url'],
				'url'         => $item['url'],
				'description' => strip_tags( $item['description'] ),
			];

			self::the_view( 'shortcode-mv-create-pin-button', $args );
			?>
			<div class="mv-list-img-container">
				<a href="<?php echo esc_attr( $item['url'] ); ?>"
					<?php echo wp_kses( $target_blank, array() ); ?>
					<?php echo ! empty( $item['nofollow'] ) ? 'rel="nofollow"' : ''; ?>
				>
				<?php echo wp_kses_post( $item['thumbnail_url'] ); ?>
				</a>
			</div>
			<div class="mv-list-item-container">
				<h2 class="mv-list-single-title"><?php echo esc_html( $item['title'] ); ?></h2>
				<?php if ( ! empty( $item['extra'] ) ) { ?>
					<?php echo wp_kses_post( $item['extra'] ); ?>
				<?php } ?>
				<?php if ( ! empty( $item['thumbnail_credit'] ) ) { ?>
					<div class="mv-list-photocred">
						<strong><?php esc_html_e( 'Photo Credit:', 'mediavine' ); ?></strong>
						<?php echo esc_html( $item['thumbnail_credit'] ); ?>
					</div>
				<?php } ?>
				<div class="mv-list-single-description"><?php echo wp_kses( wpautop( $item['description'] ), $args['allowed_html'] ); ?></div>
				<a
					class="mv-list-link mv-to-btn"
					href="<?php echo esc_attr( $item['url'] ); ?>"
					<?php echo wp_kses( $target_blank, array() ); ?>
					<?php echo ! empty( $item['nofollow'] ) ? 'rel="nofollow"' : ''; ?>
				>
					<?php echo esc_html( $item['btn_text'] ); ?>
				</a>
			</div>
		</div>
		<?php
			do_action( 'mv_create_list_after_single', $args, $i++, count( $args['creation']['list_items'] ) );
		}
	}
	?>
</div>
