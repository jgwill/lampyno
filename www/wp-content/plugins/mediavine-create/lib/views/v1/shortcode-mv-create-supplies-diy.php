<?php if ( ! empty( $args['creation']['materials'] ) ) { ?>
	<div class="mv-create-ingredients">
		<h2 class="mv-create-ingredients-title mv-create-title-secondary"><?php esc_html_e( 'Materials', 'mediavine' ); ?></h2>

		<?php foreach ( $args['creation']['materials'] as $group => $materials ) { ?>
			<?php
				if ( ! count( $materials ) ) {
					continue;
				}
			?>
			<?php if ( ! in_array( $group, array( 'mv-has-no-group', '_empty_' ), true ) ) { ?>
				<h3><?php echo esc_html( $group ); ?></h3>
			<?php } ?>
			<ul>
				<?php
				foreach ( $materials as $material ) {
					// Force object to array
					$material = (array) $material;
					?>
					<li>
						<?php
						if ( ! empty( $material['original_text'] ) ) {
							if ( ! empty( $material['link'] ) ) {
								preg_match( '/([^[]*?)\[(.*)\](.*)/', $material['original_text'], $matches );
								if ( empty( $matches ) ) {
									$before    = '';
									$after     = '';
									$link_text = $material['original_text'];
								} else {
									$before    = $matches[1];
									$link_text = $matches[2];
									$after     = $matches[3];
								}

								echo wp_kses_post( $before );
								echo '<a href="' . esc_url( $material['link'] ) . '"';
								if ( $material['nofollow'] ) {
									echo ' rel="nofollow"';
								}
								// Check for internal links
								if ( strpos( $material['link'], get_site_url() ) !== 0 ) {
									echo ' target="_blank"';
								}
								echo '>';
								echo wp_kses_post( $link_text );
								echo '</a>';
								echo wp_kses_post( $after );
							} else {
								echo wp_kses_post( $material['original_text'] );
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

if ( ! empty( $args['creation']['tools'] ) ) {
?>
	<div class="mv-create-ingredients">
		<h2 class="mv-create-ingredients-title mv-create-title-secondary"><?php esc_html_e( 'Tools', 'mediavine' ); ?></h2>

		<?php foreach ( $args['creation']['tools'] as $group => $tools ) { ?>
			<?php
				if ( ! count( $tools ) ) {
					continue;
				}
			?>
			<?php if ( ! in_array( $group, array( 'mv-has-no-group', '_empty_' ), true ) ) { ?>
				<h3><?php echo esc_html( $group ); ?></h3>
			<?php } ?>
			<ul>
				<?php
				foreach ( $tools as $tool ) {
					// Force object to array
					$tool = (array) $tool;
					?>
					<li>
						<?php
						if ( ! empty( $tool['original_text'] ) ) {
							if ( ! empty( $tool['link'] ) ) {
								preg_match( '/([^[]*?)\[(.*)\](.*)/', $tool['original_text'], $matches );
								if ( empty( $matches ) ) {
									$before    = '';
									$after     = '';
									$link_text = $tool['original_text'];
								} else {
									$before    = $matches[1];
									$link_text = $matches[2];
									$after     = $matches[3];
								}

								echo wp_kses_post( $before );
								echo '<a href="' . esc_url( $tool['link'] ) . '"';
								if ( $tool['nofollow'] ) {
									echo ' rel="nofollow"';
								}
								// Check for internal links
								if ( strpos( $tool['link'], get_site_url() ) !== 0 ) {
									echo ' target="_blank"';
								}
								echo '>';
								echo wp_kses_post( $link_text );
								echo '</a>';
								echo wp_kses_post( $after );
							} else {
								echo wp_kses_post( $tool['original_text'] );
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
