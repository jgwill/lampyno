<?php
/* Adds a small amount of sample data to the UPCP database for demonstration purposes */
function EWD_UFAQ_Output_Welcome_Screen() {
	include EWD_UFAQ_CD_PLUGIN_PATH . 'html/WelcomeScreen.php';
}

function EWD_UFAQ_Initial_Install_Screen() {
	add_dashboard_page(
			esc_html__( 'Ultimate FAQs - Welcome!', 'ultimate-faqs' ),
			esc_html__( 'Ultimate FAQs - Welcome!', 'ultimate-faqs' ),
			'manage_options',
			'ewd-ufaq-getting-started',
			'EWD_UFAQ_Output_Welcome_Screen'
		);
}

function EWD_UFAQ_Remove_Install_Screen_Admin_Menu() {
	remove_submenu_page( 'index.php', 'ewd-ufaq-getting-started' );
}

function EWD_UFAQ_Welcome_Screen_Redirect() {
	if ( ! get_transient( 'ewd-ufaq-getting-started' ) ) {
		return;
	}
	
	delete_transient( 'ewd-ufaq-getting-started' );

	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	$FAQs = get_posts(array('post_type' => 'ufaq'));
	if (!empty($FAQs)) {
		set_transient('ewd-ufaq-admin-install-notice', true, 5);
		return;
	}

	wp_safe_redirect( admin_url( 'index.php?page=ewd-ufaq-getting-started' ) );
	exit;
}

add_action( 'admin_menu', 'EWD_UFAQ_Initial_Install_Screen' );
add_action( 'admin_head', 'EWD_UFAQ_Remove_Install_Screen_Admin_Menu' );
add_action( 'admin_init', 'EWD_UFAQ_Welcome_Screen_Redirect', 9999 );
?>