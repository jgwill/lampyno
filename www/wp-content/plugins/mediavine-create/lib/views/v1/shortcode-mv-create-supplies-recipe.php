<?php
if ( ! empty( $args['creation']['ingredients'] ) ) { ?>
	<div class="mv-create-ingredients">
		<h2 class="mv-create-ingredients-title mv-create-title-secondary"><?php esc_html_e( 'Ingredients', 'mediavine' ); ?></h2>

		<?php foreach ( $args['creation']['ingredients'] as $group => $ingredients ) { ?>
			<?php
				if ( ! count( $ingredients ) ) {
					continue;
				}
			?>
			<?php if ( ! in_array( $group, array( 'mv-has-no-group', '_empty_' ), true ) ) { ?>
				<h3><?php echo esc_html( $group ); ?></h3>
			<?php } ?>
			<ul>
				<?php
				foreach ( $ingredients as $ingredient ) {
					// Force object to array
					$ingredient = (array) $ingredient;
					?>
					<li>
						<?php
						if ( ! empty( $ingredient['original_text'] ) ) {
							if ( ! empty( $ingredient['link'] ) ) {
								preg_match( '/([^[]*?)\[(.*)\](.*)/', $ingredient['original_text'], $matches );
								if ( empty( $matches ) ) {
									$before    = '';
									$after     = '';
									$link_text = $ingredient['original_text'];
								} else {
									$before    = $matches[1];
									$link_text = $matches[2];
									$after     = $matches[3];
								}

								echo wp_kses_post( $before );
								echo '<a href="' . esc_url( $ingredient['link'] ) . '"';
								if ( $ingredient['nofollow'] ) {
									echo ' rel="nofollow"';
								}
								// Check for internal links
								if ( strpos( $ingredient['link'], get_site_url() ) !== 0 ) {
									echo ' target="_blank"';
								}
								echo '>';
								echo wp_kses_post( $link_text );
								echo '</a>';
								echo wp_kses_post( $after );
							} else {
								echo wp_kses_post( $ingredient['original_text'] );
							}
						}
						?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
<?php
}
