<?php
if( get_theme_mod( 'display_top_bar', '1' ) == 1 ) {
?>
<div class="container-fluid bgtoph">
	<div class="container">
		<div class="row pdt10">
		
			<div class="col-md-6">
				<div class="spsl-topbar-left-cntr">
					<?php
					if( get_theme_mod( 'tpbr_left_view', '1' ) != 3 ) {
						if( get_theme_mod( 'tpbr_left_view', '1' ) == 1 ) {
						?>
							<p class="tpbr_lft_phne_ctmzr">
							
							<?php
							if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ) {
							?>
								<span class="fa fa-phone"></span><?php _e( ' Call: ', 'di-business' ) ?><a href="tel:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?></a>
							<?php
							}
							?>
							
							<?php
							if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) && get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
								_e( ' | ', 'di-business' );
							}
							?>
							
							<?php
							if( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
							?>
								<span class="fa fa-envelope-o"></span><?php _e( ' Email: ', 'di-business' ) ?><a href="mailto:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?></a>
							<?php
							}
							?>
							
							</p>
						<?php
						} else {
						?>
							<div class="topbar_ctmzr">
							<?php
							echo wp_kses_post( get_theme_mod( 'top_bar_left_content', '<p><span class="fa fa-phone"></span> ' . __( 'Call:', 'di-business' ) . ' <a href="tel:0123456789">0123456789</a> | <span class="fa fa-envelope-o"></span> ' . __( 'Email:', 'di-business' ) . ' <a href="mailto:info@example.com">info@example.com</a></p>' ) );
							?>
							</div>
						<?php
						}
					}
					?>
				</div>
			</div>
			
			<div class="col-md-6">
				<p class="spsl-fr-topbar-icons iconouter">
				
					<?php
					if( class_exists( 'WooCommerce' ) ) {
					?>
					<span class="woo_icons_top_bar_ctmzr">
						<?php get_template_part( 'template-parts/partial/content', 'woo-icons-topbar' ); ?>
					</span>
					<?php
					}
					?>
					
					<?php
					// Social link open in new tab or same.
					if( get_theme_mod( 's_link_open', '1' ) == 1 ) {
						$s_link_tab = 'target="_blank"';
					} else {
						$s_link_tab = '';
					}

					if( get_theme_mod( 'display_sicons_top_bar', '1' ) == 1 ) {
						echo "<span class='sicons_ctmzr'>";
						if( get_theme_mod( 'sprofile_link_facebook', 'http://facebook.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Facebook', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_facebook', 'http://facebook.com' ) ); ?>"><span class="fa fa-facebook bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_twitter', 'http://twitter.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Twitter', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_twitter', 'http://twitter.com' ) ); ?>"><span class="fa fa-twitter bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_youtube', 'http://youtube.com' ) ) {
						?>
							<a title="<?php esc_attr_e( 'YouTube', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_youtube', 'http://youtube.com' ) ); ?>"><span class="fa fa-youtube bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_vk' ) ) {
						?>
							<a title="<?php esc_attr_e( 'VK', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_vk' ) ); ?>"><span class="fa fa-vk bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_okru' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Ok.ru', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_okru' ) ); ?>"><span class="fa fa-odnoklassniki bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_linkedin' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Linkedin', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_linkedin' ) ); ?>"><span class="fa fa-linkedin bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_pinterest' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Pinterest', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_pinterest' ) ); ?>"><span class="fa fa-pinterest-p bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_instagram' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Instagram', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_instagram' ) ); ?>"><span class="fa fa-instagram bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_telegram' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Telegram', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_telegram' ) ); ?>"><span class="fa fa-telegram bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_snapchat' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Snapchat', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_snapchat' ) ); ?>"><span class="fa fa-snapchat bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_flickr' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Flickr', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_flickr' ) ); ?>"><span class="fa fa-flickr bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_reddit' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Reddit', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_reddit' ) ); ?>"><span class="fa fa-reddit bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_tumblr' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Tumblr', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_tumblr' ) ); ?>"><span class="fa fa-tumblr bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_yelp' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Yelp', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="<?php echo esc_url( get_theme_mod( 'sprofile_link_yelp' ) ); ?>"><span class="fa fa-yelp bgtoph-icon-clr"></span></a>
						<?php
						}
						?>

						<?php
						if( get_theme_mod( 'sprofile_link_whatsappno' ) ) {
						?>
							<a class="whatsapp-large" rel="nofollow" title="<?php esc_attr_e( 'WhatsApp', 'di-business' ); ?>" <?php echo $s_link_tab; ?> href="https://web.whatsapp.com/send?text=&phone=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>&abid=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>"><span class="fa fa-whatsapp bgtoph-icon-clr"></span></a>

							<a class="whatsapp-small" rel="nofollow" title="<?php esc_attr_e( 'WhatsApp', 'di-business' ); ?>" <?php echo $s_link_tab; ?> href="whatsapp://send?text=&phone=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>&abid=<?php echo esc_attr( get_theme_mod( 'sprofile_link_whatsappno' ) ); ?>"><span class="fa fa-whatsapp bgtoph-icon-clr"></span></a>
						<?php
						}
						?>
						
						<?php
						if( get_theme_mod( 'sprofile_link_skype' ) ) {
						?>
							<a title="<?php esc_attr_e( 'Skype', 'di-business' ); ?>" rel="nofollow" <?php echo $s_link_tab; ?> href="skype:<?php echo esc_attr( get_theme_mod( 'sprofile_link_skype' ) ); ?>?add"><span class="fa fa-skype bgtoph-icon-clr"></span></a>
						<?php
						}
						echo "</span>";
					}
					?>

					<?php
					if( get_theme_mod( 'top_bar_seach_icon', '1' ) == 1 ) {
					?>
						<a id="scp-btn-search" title="<?php esc_attr_e( 'Search', 'di-business' ); ?>" href="javascript:void(0)"><span class="fa fa-search bgtoph-icon-clr"></span></a>
					<?php
					}
					?>
					
				</p>

				<?php
				// Top bar search form container.
				if( get_theme_mod( 'top_bar_seach_icon', '1' ) == 1 ) {
				?>
					<div class="scp-search">
						<button id="scp-btn-search-close" class="scp-btn scp-btn--search-close" aria-label="<?php esc_attr_e( 'Close search form', 'di-business' ); ?>"><i class="fa fa-close"></i></button>
						<?php get_search_form(); ?>
					</div>
				<?php
				}
				?>

			</div>
			
		</div>
	</div>
</div>
<?php
}
?>
