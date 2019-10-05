<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */
		
function Update_EWD_URP_Content() {
global $ewd_urp_message;
if (isset($_GET['Action'])) {
		switch ($_GET['Action']) {
			case "EWD_URP_UpdateOptions":
       			$ewd_urp_message = EWD_URP_UpdateOptions();
				break;
			case "EWD_URP_Export_To_Excel":
				$ewd_urp_message = EWD_URP_Export_To_Excel();
				break;
			case "EWD_URP_WooCommerceImport":
       			$ewd_urp_message = EWD_URP_WooCommerce_Review_Import();
				break;
			case "EWD_URP_ImportReviewsFromSpreadsheet":
       			$ewd_urp_message = EWD_URP_Import_From_Spreadsheet();
				break;
			default:
				$ewd_urp_message = __("The form has not worked correctly. Please contact the plugin developer.", 'ultimate-reviews');
				break;
		}
	}
}

?>