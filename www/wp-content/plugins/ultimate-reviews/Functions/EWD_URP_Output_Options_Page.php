<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_URP_Output_Options_Page() {
		global $URP_Full_Version;
		
		if (!isset($_GET['page'])) {$_GET['page'] = "";}

		include( plugin_dir_path( __FILE__ ) . '../html/AdminHeader.php');
		if ($_GET['page'] == 'urp-options') {include( plugin_dir_path( __FILE__ ) . '../html/OptionsPage.php');}
		if ($_GET['page'] == 'urp-woocommerce-import') {include( plugin_dir_path( __FILE__ ) . '../html/WooCommerceImportPage.php');}
		include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>