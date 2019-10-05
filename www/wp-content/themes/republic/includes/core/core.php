<?php

// Add stylesheet and JS for core page.
function republic_core_style() {
	wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri() . '/inc/core/bootstrap/css/bootstrap-responsive.css', 'bootstrap' );
	wp_enqueue_style( 'republic-responsive', get_template_directory_uri() . '/inc/core/bootstrap/css/responsive.css', array( 'bootstrap', 'bootstrap-responsive' ) );
	wp_enqueue_style( 'core_style', get_template_directory_uri() . '/inc/core/css/core.css' );
}

// Add core page to the menu.
function republic_add_core() {
	$page = add_theme_page(
		__('MORE Themes','republic'),
		__('MORE Themes','republic'),
		__('administrator','republic'),
		__('republic-themes','republic'),
		__('republic_display_core','republic')
	);

	add_action( 'admin_print_styles-' . $page, 'republic_core_style' );
}

add_action( 'admin_menu', 'republic_add_core' );

// Define markup for the core page.
function republic_display_core() {

	// Set template directory uri
	$directory_uri = get_template_directory_uri();
	?>
	<div class="wrap">
		<div class="container-fluid">
			<div id="core_container">
				<div class="row-fluid">
					<div id="core_header" class="span12">
						<h2>
							<a href="http://www.insertcart.com" target="_blank">
								<img src="<?php echo esc_url($directory_uri); ?>/inc/core/images/Insertcart-logo.png"/>
							</a>
						</h2>

						<h3><?php esc_attr( 'You Should Try Our Other Themes Also', 'republic' ); ?></h3>
					</div>
				</div>

				<div id="core_themes" class="row-fluid">
					<?php
					// Set the argument array with author name.
					$args = array(
						'author' => 'sandy786',
					);

					// Set the $request array.
					$request = array(
						'body' => array(
							'action'  => 'query_themes',
							'request' => serialize( (object)$args )
						)
					);
					$themes = republic_get_themes( $request );
					$active_theme = wp_get_theme()->get( 'Name' );
					$counter = 1;

					// For currently active theme.
					foreach ( $themes->themes as $theme ) {
						if( $active_theme == $theme->name ) {?>

							<div id="<?php echo esc_attr($theme->slug); ?>" class="theme-container span4">
								<div class="image-container">
									<img class="theme-screenshot" src="<?php echo esc_url($theme->screenshot_url); ?>"/>

									<div class="theme-description">
										<p><?php echo esc_attr($theme->description); ?></p>
									</div>
								</div>
								<div class="theme-details active">
									<span class="theme-name"><?php echo esc_attr($theme->name); ?><?php esc_attr(': Current','republic'); ?></span>
									<a class="button button-secondary customize right" target="_blank" href="<?php echo esc_url(get_site_url()). '/wp-admin/customize.php' ?>"><?php esc_attr('Customize','republic'); ?></a>
								</div>
							</div>

						<?php
						$counter++;
						break;
						}
					}

					// For all other themes.
					foreach ( $themes->themes as $theme ) {
						if( $active_theme != $theme->name ) {

							// Set the argument array with author name.
							$args = array(
								'slug' => $theme->slug,
							);

							// Set the $request array.
							$request = array(
								'body' => array(
									'action'  => 'theme_information',
									'request' => serialize( (object)$args )
								)
							);

							$theme_details = republic_get_themes( $request );
							?>

							<div id="<?php echo esc_attr($theme->slug); ?>" class="theme-container span4 <?php echo $counter % 3 == 1 ? 'no-left-megin' : ""; ?>">
								<div class="image-container">
									<img class="theme-screenshot" src="<?php echo esc_url($theme->screenshot_url); ?>"/>

									<div class="theme-description">
										<p><?php echo esc_attr($theme->description); ?></p>
									</div>
								</div>
								<div class="theme-details">
									<span class="theme-name"><?php echo esc_attr($theme->name); ?></span>

									<!-- Check if the theme is installed -->
									<?php if( wp_get_theme( $theme->slug )->exists() ) { ?>

										<!-- Show the tick image notifying the theme is already installed. -->
										<img data-toggle="tooltip" title="Already installed" data-placement="bottom" class="theme-exists" src="<?php echo esc_url($directory_uri); ?>/inc/core/images/tick.png"/>

										<!-- Activate Button -->
										<a  class="button button-primary activate right"
											href="<?php echo wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $theme->slug ) ), 'switch-theme_' . $theme->slug );?>" ><?php esc_attr_e('Activate','republic'); ?></a>
									<?php }
									else {

										// Set the install url for the theme.
										$install_url = add_query_arg( array(
												'action' => 'install-theme',
												'theme'  => $theme->slug,
											), self_admin_url( 'update.php' ) );
									?>
										<!-- Install Button -->
										<a data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Downloaded ' . number_format( $theme_details->downloaded ) . ' times'; ?>" class="button button-primary install right" href="<?php echo esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ); ?>" ><?php esc_attr('Install Now','republic'); ?></a>
									<?php } ?>

									<!-- Preview button -->
									<a class="button button-secondary preview right" target="_blank" href="<?php echo esc_url($theme->preview_url); ?>"><?php esc_attr_e('Live Preview','republic'); ?></a>
								</div>
							</div>
							<?php
							$counter++;
						}
					}?>
				</div>
			</div>
		</div>
	</div>

	
<?php
}

// Get all republic themes by using API.
function republic_get_themes( $request ) {

	// Generate a cache key that would hold the response for this request:
	$key = 'republic_' . md5( serialize( $request ) );

	// Check transient. If it's there - use that, if not re fetch the theme
	if ( false === ( $themes = get_transient( $key ) ) ) {

		// Transient expired/does not exist. Send request to the API.
		$response = wp_remote_post( 'http://api.wordpress.org/themes/info/1.0/', $request );

		// Check for the error.
		if ( !is_wp_error( $response ) ) {

			$themes = unserialize( wp_remote_retrieve_body( $response ) );

			if ( !is_object( $themes ) && !is_array( $themes ) ) {

				// Response body does not contain an object/array
				return new WP_Error( 'theme_api_error', 'An unexpected error has occurred' );
			}

			// Set transient for next time... keep it for 24 hours should be good
			set_transient( $key, $themes, 60 * 60 * 24 );
		}
		else {
			// Error object returned
			return $response;
		}
	}

	return $themes;
}
