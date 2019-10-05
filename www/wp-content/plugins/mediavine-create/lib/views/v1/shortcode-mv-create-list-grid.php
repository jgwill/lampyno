<div class="mv-list-list mv-list-list-<?php echo esc_attr( $args['creation']['layout'] ); ?>">
	<div class="mv-list-list-grid-inner">
		<?php
		$i                        = 0;
		$r                        = 1;
		$total_items              = count( $args['creation']['list_items'] );
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
				<div class="mv-list-img-container">
					<?php
					// Build Pinterest specific args
					$args['pinterest'] = [
						'img'         => $item['pinterest_url'],
						'url'         => $item['url'],
						'description' => strip_tags( $item['description'] ),
					];
					?>
						<div
							class="mv-pinterest-btn <?php echo esc_attr( rawurlencode( $args['creation']['pinterest_class'] ) ); ?>"
							data-mv-pinterest-desc="<?php echo esc_attr( rawurlencode( $item['description'] ) ); ?>"
							data-mv-pinterest-img-src="<?php echo esc_attr( $item['pinterest_url'] ); ?>"
							data-mv-pinterest-url="<?php echo esc_attr( rawurlencode( $item['url'] ) ); ?>"
						></div>
						<a href="<?php echo esc_attr( $item['url'] ); ?>"
							<?php echo wp_kses( $target_blank, array() ); ?>
							<?php echo ! empty( $item['nofollow'] ) ? 'rel="nofollow"' : ''; ?>
						>
						<?php echo wp_kses_post( $item['thumbnail_url'] ); ?>
						</a>
					</div>
					<h2 class="mv-list-single-title"><?php echo esc_html( $item['title'] ); ?></h2>
					<?php echo wp_kses_post( $item['extra'] ); ?>
					<?php if ( ! empty( $item['thumbnail_credit'] ) ) { ?>
						<div class="mv-list-photocred">
							<strong><?php esc_html_e( 'Photo Credit:', 'mediavine' ); ?></strong>
							<?php echo esc_html( $item['thumbnail_credit'] ); ?>
						</div>
					<?php } ?>
					<div class="mv-list-single-description"><?php echo wp_kses( wpautop( $item['description'] ), $args['allowed_html'] ); ?></div>
					<div>
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
				// if there is a remainder, we know the index is odd. Because the counter is 0-indexed,
				// this actually means that the item is the 2nd of a pair of items, completing a row.
				if ( 1 === $i % 2 ) {
					// send the row `$r` count and the total items to the ad-inserter
					do_action( 'mv_create_list_after_row', $args, $r, $total_items );
					// increment the row
					$r++;
				}
				// increment the index counter outside of any logic, for readability
				$i++;
				?>
			<?php
			}
		}
		?>
	</div>
</div>
