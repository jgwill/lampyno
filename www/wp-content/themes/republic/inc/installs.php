<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function republic_notice() {
	if ( isset( $_GET['activated'] ) ) {
		$return = '<div class="updated activation">';					
		$return .= ' <a class="button button-primary theme-options" href="' . esc_url(admin_url( 'customize.php' )) . '">' . __( 'Theme Options', 'republic' ) . '</a>';
		$return .= ' <a class="button button-primary help" href="http://www.insertcart.com/republic-wordpress-theme-setup-and-documentation/">' . __( 'Documentation', 'republic' ) . '</a>';
		$return .= ' <a class="button button-primary help" href="http://www.insertcart.com/contact-us">' . __( 'Need Help?', 'republic' ) . '</a>';
		$return .= '</p></div>';
		echo $return;
	}
}
add_action( 'admin_notices', 'republic_notice' );

/*
 * Hide core theme activation message.
 */
function republic_admincss() { ?>
	<style>
	.themes-php #message2 {
		display: none;
	}
	.themes-php div.activation a {
		text-decoration: none;
	}
	</style>
<?php }
add_action( 'admin_head-themes.php', 'republic_admincss' );
