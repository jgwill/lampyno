<?php
function EWD_URP_Output_Welcome_Screen() {
	include EWD_URP_CD_PLUGIN_PATH . 'html/WelcomeScreen.php';
}

function EWD_URP_Initial_Install_Screen() {
	add_dashboard_page(
			esc_html__( 'Ultimate Reviews - Welcome!', 'ultimate-reviews' ),
			esc_html__( 'Ultimate Reviews - Welcome!', 'ultimate-reviews' ),
			'manage_options',
			'ewd-urp-getting-started',
			'EWD_URP_Output_Welcome_Screen'
		);
}

function EWD_URP_Remove_Install_Screen_Admin_Menu() {
	remove_submenu_page( 'index.php', 'ewd-urp-getting-started' );
}

function EWD_URP_Welcome_Screen_Redirect() {
	global $wpdb;
	global $EWD_URP_orders_table_name;

	if ( ! get_transient( 'ewd-urp-getting-started' ) ) {
		return;
	}
	
	delete_transient( 'ewd-urp-getting-started' );

	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	$Reviews = get_posts(array('post_type' => 'urp_review'));
	if (!empty($Reviews)) {
		set_transient('ewd-urp-admin-install-notice', true, 5);
		return;
	}

	wp_safe_redirect( admin_url( 'index.php?page=ewd-urp-getting-started' ) );
	exit;
}

add_action( 'admin_menu', 'EWD_URP_Initial_Install_Screen' );
add_action( 'admin_head', 'EWD_URP_Remove_Install_Screen_Admin_Menu' );
add_action( 'admin_init', 'EWD_URP_Welcome_Screen_Redirect', 9999 );
?>