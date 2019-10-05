<?php // About Ashe

// Add About Ashe Page
function ashe_about_page() {
	add_theme_page( esc_html__( 'About Ashe', 'ashe' ), esc_html__( 'About Ashe', 'ashe' ), 'edit_theme_options', 'about-ashe', 'ashe_about_page_output' );
}
add_action( 'admin_menu', 'ashe_about_page' );

// Render About Ashe HTML
function ashe_about_page_output() {

	$theme_data	 = wp_get_theme();

?>

	<div class="wrap">

		<div class="welcome-text">
			<h1>
			<?php /* translators: %s theme name */
				printf( esc_html__( 'Welcome to %s', 'ashe' ), esc_html( $theme_data->Name ) );
			?>
			</h1>

			<p>
				<?php /* translators: %s theme name */
					printf( esc_html__( '%s theme is one of the most Popular Free WordPress theme of 2017-2019 years. To understand better what the theme can offer, please click the button below.', 'ashe' ), esc_html( $theme_data->Name ) );
				?>
				<br><br><a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-free/demo/?ref=ashe-free-backend-about-theme-prev-btn'); ?>" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Theme Demo Preview', 'ashe' ); ?></a>
			</p>
		</div>

		<!-- Tabs -->
		<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'ashe_tab_1'; ?>  

		<div class="nav-tab-wrapper">
			<a href="?page=about-ashe&tab=ashe_tab_1" class="nav-tab <?php echo $active_tab == 'ashe_tab_1' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Getting Started', 'ashe' ); ?>
			</a>
			<a href="?page=about-ashe&tab=ashe_tab_2" class="nav-tab <?php echo $active_tab == 'ashe_tab_2' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-video-alt3"></span> <?php esc_html_e( 'Video Tutorials', 'ashe' ); ?>
			</a>
			<a href="?page=about-ashe&tab=ashe_tab_3" class="nav-tab <?php echo $active_tab == 'ashe_tab_3' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Useful Plugins', 'ashe' ); ?>
			</a>
			<a href="?page=about-ashe&tab=ashe_tab_4" class="nav-tab <?php echo $active_tab == 'ashe_tab_4' ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Support', 'ashe' ); ?>
			</a>
			<a href="?page=about-ashe&tab=ashe_tab_5" class="nav-tab <?php echo $active_tab == 'ashe_tab_5' ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-star-filled"></span> <?php esc_html_e( 'Free vs Pro', 'ashe' ); ?>
			</a>
		</div>

		<!-- Tab Content -->
		<?php if ( $active_tab == 'ashe_tab_1' ):  ?>

			<div class="three-columns-wrap">

				<br>

				<div class="column-width-3">
					<h3><?php esc_html_e( 'Documentation', 'ashe' ); ?></h3>
					<p>
					<?php /* translators: %s theme name */
						printf( esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'ashe' ), esc_html( $theme_data->Name ) );
					?>
					</p>
					<a target="_blank" href="<?php echo esc_url('https://wp-royal.com/themes/ashe/docs/?ref=ashe-free-backend-about-docs/'); ?>" class="button button-primary docs"><?php esc_html_e( 'Read Full Documentation', 'ashe' ); ?></a>
					<a target="_blank" href="<?php echo esc_url('https://www.youtube.com/watch?v=NDDr_b-jacI'); ?>" class="button button-primary insta"><span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Setup Instagram', 'ashe' ); ?></a>
				</div>

				<div class="column-width-3">
					<h3><?php esc_html_e( 'Demo Content', 'ashe' ); ?></h3>
					<p>
						<?php esc_html_e( 'Install the Demo Content in 2 clicks. Just click the button below to install demo import plugin and wait a bit to be redirected to the demo import page.', 'ashe' ); ?>
					</p>

					<?php if ( is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) : ?>
						<a href="<?php echo admin_url( '/themes.php?page=pt-one-click-demo-import' ); ?>" class="button button-primary demo-import"><?php esc_html_e( 'Go to Import page', 'ashe' ); ?></a>
					<?php elseif ( ashe_check_installed_plugin( 'one-click-demo-import', 'one-click-demo-import' ) ) : ?>
						<button class="button button-primary demo-import" id="ashe-demo-content-act"><?php esc_html_e( 'Activate Demo Import Plugin', 'ashe' ); ?></button>
					<?php else: ?>
						<button class="button button-primary demo-import" id="ashe-demo-content-inst"><?php esc_html_e( 'Install Demo Import Plugin', 'ashe' ); ?></button>
					<?php endif; ?>
					<a href="<?php echo esc_url('https://www.youtube.com/watch?v=ZCrRuCuM6oA') ?>" target="_blank" class="button button-primary import-video"><span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Video Tutorial', 'ashe' ); ?></a>
				</div>

				<div class="column-width-3">
					<h3><?php esc_html_e( 'Theme Customizer', 'ashe' ); ?></h3>
					<p>
					<?php /* translators: %s theme name */
						printf( esc_html__( '%s supports the Theme Customizer for all theme settings. Click "Customize" to personalize your site.', 'ashe' ), esc_html( $theme_data->Name ) );
					?>
					</p>
					<a target="_blank" href="<?php echo esc_url( wp_customize_url() );?>" class="button button-primary"><?php esc_html_e( 'Start Customizing', 'ashe' ); ?></a>
				</div>

			</div>

			<div class="four-columns-wrap">

			<hr>
			
				<h2 id="ashe-predefined-styles"><?php esc_html_e( 'Ashe Pro - Predefined Styles', 'ashe' ); ?></h2>
				<p>
				<?php /* translators: %s link */
					printf( __( 'Ashe Pro\'s powerful setup allows you to easily create unique looking sites. Here are a few included examples that can be installed with one click in the Pro Version. More details in the <a href="%s" target="_blank" >Theme Documentation</a>', 'ashe' ), esc_url('https://wp-royal.com/themes/ashe/docs/?ref=ashe-free-backend-about-predefined-styles#predefined') );
				?>
				</p>

				<div class="column-width-4">
					<div class="active-style"><?php esc_html_e( 'Active', 'ashe' ); ?></div>
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img1.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Main', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/demo/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/food.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Food', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/food/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/lifestyle.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Lifestyle', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/lifestyle/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img2.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Dark', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/color-black/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img7.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 1', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/typography-v2/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img12.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 2', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/sample-v3/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img5.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 3', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/columns2-sidebar/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img3.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 4', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/sample-v5/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img4.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 5', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/color-colorful/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img6.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 6', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/columns4/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img8.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 7', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/columns3-sidebar/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img9.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 8', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/color-black-white/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img10.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 9', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/columns3-nsidebar/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>
				<div class="column-width-4">
					<img src="<?php echo get_template_directory_uri() . '/assets/images/img11.jpg'; ?>" alt="">
					<div>
						<h2><?php esc_html_e( 'Style 10', 'ashe' ); ?></h2>
						<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-pro/columns2-nsidebar/?ref=ashe-free-backend-about-predefined-styles'); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Live Preview', 'ashe' ); ?></a>
					</div>
				</div>

			</div>

		<?php elseif ( $active_tab == 'ashe_tab_2' ) : ?>

			<div class="four-columns-wrap video-tutorials">

				<div class="column-width-4">
					<h3><?php esc_html_e( 'Demo Content', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=ZCrRuCuM6oA"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" href="<?php echo esc_url(admin_url('themes.php?page=about-ashe&tab=ashe_tab_1')); ?>"></span><?php esc_html_e( 'Get Started', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Instagram Widget', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=NDDr_b-jacI"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Menu', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=wuggfN2nzDM"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Logo Image', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=W_IoRYj1pKY"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=title_tagline')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Social Media', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=yiQLoofNYYs"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_social_media')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Copyright', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=NoOQmxSm5rk"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_page_footer')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Colors', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=cW6qT8OocpE"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_colors')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Header Image', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=xH4Z-d_KlQk"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=header_image')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Random Header Images', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=sayr8QwpbrM"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=header_image')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Featured Slider', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=H9i-cKOey98"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_featured_slider')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Setup Featured Links', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=pCtjGwieCoo"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_featured_links')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Customize General Layouts', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=WhEWOo8PoB0"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_general')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Customize Blog Page', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=DgtVfFQo7H8"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
					<a class="button button-secondary" target="_blank" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=ashe_blog_page')); ?>"></span><?php esc_html_e( 'Customize', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Create Blog Post', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=gvW0FhT-cSQ"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
				</div>
				<div class="column-width-4">
					<h3><?php esc_html_e( 'Translate The Theme', 'ashe' ); ?></h3>
					<a class="button button-primary" target="_blank" href="https://www.youtube.com/watch?v=7LtyVjw46r8"><?php esc_html_e( 'Watch Video', 'ashe' ); ?></a>
				</div>

			</div>

		<?php elseif ( $active_tab == 'ashe_tab_3' ) : ?>
			
			<div class="three-columns-wrap">
				
				<br><br>

				<?php

				// WooCommerce
				ashe_recommended_plugin( 'woocommerce', 'woocommerce' );

				// MailPoet 2
				ashe_recommended_plugin( 'wysija-newsletters', 'index' );

				// Contact Form 7
				ashe_recommended_plugin( 'contact-form-7', 'wp-contact-form-7' );

				// Recent Posts Widget
				ashe_recommended_plugin( 'recent-posts-widget-with-thumbnails', 'recent-posts-widget-with-thumbnails' );

				// Ajax Thumbnail Rebuild
				ashe_recommended_plugin( 'ajax-thumbnail-rebuild', 'ajax-thumbnail-rebuild' );

				// Meks Easy Instagram Widget
				// ashe_recommended_plugin( 'meks-easy-instagram-widget', 'meks-easy-instagram-widget' );

				// Smash Balloon Social Photo Feed
				ashe_recommended_plugin( 'instagram-feed', 'instagram-feed' );

				// Facebook Widget
				ashe_recommended_plugin( 'facebook-pagelike-widget', 'facebook_widget' );

				?>


			</div>

		<?php elseif ( $active_tab == 'ashe_tab_4' ) : ?>

			<div class="three-columns-wrap">

				<br>

				<div class="column-width-3">
					<h3>
						<span class="dashicons dashicons-sos"></span>
						<?php esc_html_e( 'Forums', 'ashe' ); ?>
					</h3>
					<p>
						<?php esc_html_e( 'Before asking a questions it\'s highly recommended to search on forums, but if you can\'t find the solution feel free to create a new topic.', 'ashe' ); ?>
						<hr>
						<a target="_blank" href="<?php echo esc_url('https://wp-royal.com/support-ashe-free/?ref=ashe-free-backend-about-support-forum/'); ?>"><?php esc_html_e( 'Go to Support Forums', 'ashe' ); ?></a>
					</p>
				</div>

				<div class="column-width-3">
					<h3>
						<span class="dashicons dashicons-admin-tools"></span>
						<?php esc_html_e( 'Changelog', 'ashe' ); ?>
					</h3>
					<p>
						<?php esc_html_e( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'ashe' ); ?>
						<hr>
						<a target="_blank" href="<?php echo esc_url('https://wp-royal.com/ashe-free-changelog/?ref=ashe-free-backend-about-changelog/'); ?>"><?php esc_html_e( 'Changelog', 'ashe' ); ?></a>
					</p>
				</div>

			</div>

		<?php elseif ( $active_tab == 'ashe_tab_5' ) : ?>

			<br><br>

			<table class="free-vs-pro form-table">
				<thead>
					<tr>
						<th>
							<a href="<?php echo esc_url('https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-backend-about-section-getpro-btn'); ?>" target="_blank" class="button button-primary button-hero">
								<?php esc_html_e( 'Get Ashe Pro', 'ashe' ); ?>
							</a>
						</th>
						<th><?php esc_html_e( 'Ashe', 'ashe' ); ?></th>
						<th><?php esc_html_e( 'Ashe Pro', 'ashe' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<h3><?php esc_html_e( '800+ Google Fonts', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Header Background Image/Color/Video', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3>
								<a href="<?php echo admin_url('themes.php?page=about-ashe#ashe-predefined-styles'); ?>" target="_blank">
									<?php esc_html_e( 'Predefined Styles', 'ashe' ); ?>
									<span class="dashicons dashicons-external"></span>
								</a>
							</h3>							
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Unlimited Colors Options', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Classic, List, Grid Layouts', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Advanced Slider Options', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Advanced WooCommerce Support', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Sticky Navigation', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>
					<tr>
						<td>
							<h3><?php esc_html_e( 'Premium Support 24/7', 'ashe' ); ?></h3>
						</td>
						<td class="compare-icon"><span class="dashicons-before dashicons-no"></span></td>
						<td class="compare-icon"><span class="dashicons-before dashicons-yes"></span></td>
					</tr>


					<tr>
						<td colspan="3">
							<a href="<?php echo esc_url('https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-backend-about-section-feature-list-btn#features'); ?>" target="_blank" class="button button-primary button-hero">
								<strong><?php esc_html_e( 'View Full Feature List', 'ashe' ); ?></strong>
							</a>
						</td>
					</tr>
				</tbody>
			</table>

	    <?php endif; ?>

	</div>
<?php
} // end ashe_about_page_output


// Check if plugin is installed
function ashe_check_installed_plugin( $slug, $filename ) {
	return file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $filename . '.php' ) ? true : false;
}

// Generate Recommended Plugin HTML
function ashe_recommended_plugin( $slug, $filename ) {

	if ( $slug === 'facebook-pagelike-widget' ) {
		$size = '128x128';
	} else {
		$size = '256x256';
	}


	$plugin_info = ashe_call_plugin_api( $slug );
	$plugin_desc = $plugin_info->short_description;
	$plugin_img  = ( ! isset($plugin_info->icons['1x']) ) ? $plugin_info->icons['default'] : $plugin_info->icons['1x'];
?>

	<div class="plugin-card">
		<div class="name column-name">
			<h3>
				<?php echo esc_html( $plugin_info->name ); ?>
				<img src="<?php echo $plugin_img; ?>" class="plugin-icon" alt="">
			</h3>
		</div>
		<div class="action-links">
			<?php if ( ashe_check_installed_plugin( $slug, $filename ) ) : ?>
			<button type="button" class="button button-disabled" disabled="disabled"><?php esc_html_e( 'Installed', 'ashe' ); ?></button>
			<?php else : ?>
			<a class="install-now button-primary" href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='. $slug ), 'install-plugin_'. $slug ) ); ?>" >
				<?php esc_html_e( 'Install Now', 'ashe' ); ?>
			</a>							
			<?php endif; ?>
		</div>
		<div class="desc column-description">
			<p><?php echo $plugin_desc . esc_html__( '...', 'ashe' ); ?></p>
		</div>
	</div>

<?php
}

// Get Plugin Info
function ashe_call_plugin_api( $slug ) {

	$call_api = get_transient( 'ashe_about_plugin_info_' . $slug );

	if ( false === $call_api ) {

	    if ( ! function_exists( 'plugins_api' ) && file_exists( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' ) ) {
	        require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' );
	    }

	    if ( function_exists( 'plugins_api' ) ) {

			$call_api = plugins_api(
				'plugin_information', array(
					'slug'   => $slug,
					'fields' => array(
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'short_description' => true,
						'donate_link'       => false,
						'tags'              => false,
						'sections'          => true,
						'homepage'          => true,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
						'icons'             => true,
					),
				)
			);

			if ( ! is_wp_error( $call_api ) ) {
				set_transient( 'ashe_about_plugin_info_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
			}

		}
	}

	return $call_api;
}


// Install/Activate Demo Import Plugin 
function ashe_plugin_auto_activation() {

	// Get the list of currently active plugins (Most likely an empty array)
	$active_plugins = (array) get_option( 'active_plugins', array() );

	array_push( $active_plugins, 'one-click-demo-import/one-click-demo-import.php' );

	// Set the new plugin list in WordPress
	update_option( 'active_plugins', $active_plugins );

}
add_action( 'wp_ajax_ashe_plugin_auto_activation', 'ashe_plugin_auto_activation' );

// Import Plugin Data
function ashe_import_demo_files() {
	return array(
		array(
			'import_file_name'             => esc_html__( 'Import Demo Data', 'ashe' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/about/import/ashe-demo.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/about/import/ashe-widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/about/import/ashe-customizer.dat'
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'ashe_import_demo_files' );

function ashe_import_demo_files_filter( $default_text ) {

	// Activate CF7 Plugin After Import
	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		$cf7_plugin_link = '';
	} elseif ( ashe_check_installed_plugin( 'contact-form-7', 'wp-contact-form-7' ) ) {
		$cf7_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=contact-form-7/wp-contact-form-7.php' ), 'activate-plugin_contact-form-7/wp-contact-form-7.php' ) ) .'" target="_blank">'. esc_html__( 'Activate - Contact Form 7', 'ashe' ) .'</a></li>';
	} else {
		$cf7_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=contact-form-7' ), 'install-plugin_contact-form-7' ) ) .'" target="_blank">'. esc_html__( 'Install/Activate - Contact Form 7', 'ashe' ) .'</a></li>';
	}

	// Activate RPWWT Plugin After Import
	if ( is_plugin_active( 'recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' ) ) {
		$rpwwt_plugin_link = '';
	} elseif ( ashe_check_installed_plugin( 'recent-posts-widget-with-thumbnails', 'recent-posts-widget-with-thumbnails' ) ) {
		$rpwwt_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' ), 'activate-plugin_recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' ) ) .'" target="_blank">'. esc_html__( 'Activate - Recent Posts Widget with Thumbnails', 'ashe' ) .'</a></li>';
	} else {
		$rpwwt_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=recent-posts-widget-with-thumbnails' ), 'install-plugin_recent-posts-widget-with-thumbnails' ) ) .'" target="_blank">'. esc_html__( 'Install/Activate - Recent Posts Widget with Thumbnails', 'ashe' ) .'</a></li>';
	}

	// Activate WPIW Plugin After Import
	if ( is_plugin_active( 'instagram-feed/instagram-feed.php' ) ) {
		$wpiw_plugin_link = '';
	} elseif ( ashe_check_installed_plugin( 'instagram-feed', 'instagram-feed' ) ) {
		$wpiw_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=instagram-feed/instagram-feed.php' ), 'activate-plugin_instagram-feed/instagram-feed.php' ) ) .'" target="_blank">'. esc_html__( 'Activate - Smash Balloon Social Photo Feed', 'ashe' ) .'</a></li>';
	} else {
		$wpiw_plugin_link = '<li><a href="'. esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=instagram-feed' ), 'install-plugin_instagram-feed' ) ) .'" target="_blank">'. esc_html__( 'Install/Activate - Smash Balloon Social Photo Feed', 'ashe' ) .'</a></li>';
	}

	$activate_plugins_notice = '';
	if ( $rpwwt_plugin_link !== '' || $wpiw_plugin_link !== '' ) {
		/* translators: %s link */
		$activate_plugins_notice = sprintf( __( 'Recommended (optional): Before you Import Demo Data to get the same demo as shown on our <a href="%s" target="_blank" >Theme Preview Page</a> you need to: ', 'ashe' ), esc_url('https://wp-royal.com/themes/ashe-free/demo/?ref=ashe-free-backend-about-section-one-click-demo-import') );
	}

	$default_text = substr($default_text, 159);

	$default_text .= '<div class="ocdi__intro-text">';

		if ( $wpiw_plugin_link !== '' || $cf7_plugin_link !== '' || $rpwwt_plugin_link !== '' ) {

			$default_text .= '<h4>'. $activate_plugins_notice .'</h4>';

			$default_text .= '<ul>';
				$default_text .= $wpiw_plugin_link;
				$default_text .= $cf7_plugin_link;
				$default_text .= $rpwwt_plugin_link;
			$default_text .= '</ul>';

		}

	$default_text .= '</div><hr>';

	return $default_text; 
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ashe_import_demo_files_filter' );

// Actions after Import
function ashe_after_import_setup() {
	// Install Menus after Import
	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'main' => $main_menu->term_id,
			'top'  => $top_menu->term_id,
		)
	);

	// Get Instagram Options
	$instagram_options = get_option('sb_instagram_settings');
	// Set Instagram Options
	$instagram_options['sb_instagram_num'] = '9';
	$instagram_options['sb_instagram_cols'] = '3';
	$instagram_options['sb_instagram_image_padding'] = '0';
	$instagram_options['sb_instagram_show_header'] = false;
	$instagram_options['sb_instagram_show_btn'] = false;
	$instagram_options['sb_instagram_show_follow_btn'] = false;
	// Update Instagram Options
	update_option( 'sb_instagram_settings', $instagram_options );
}
add_action( 'pt-ocdi/after_import', 'ashe_after_import_setup' );

// Disable PT after Import Notice
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );


// enqueue ui CSS/JS
function ashe_enqueue_about_page_scripts($hook) {

	if ( 'appearance_page_about-ashe' != $hook ) {
		return;
	}

	// enqueue CSS
	wp_enqueue_style( 'ashe-about-page-css', get_theme_file_uri( '/inc/about/css/about-ashe-page.css' ), array(), '1.8.2' );

	// Demo Import
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	wp_enqueue_script( 'ashe-about-page-css', get_theme_file_uri( '/inc/about/js/about-ashe-page.js' ), array(), '1.8.2' );

}
add_action( 'admin_enqueue_scripts', 'ashe_enqueue_about_page_scripts' );