<?php
function EWD_URP_Version_Update() {
	global $EWD_URP_Version;

	$Review_Categories_Array_Before = get_option("EWD_URP_Review_Categories_Array");
	if (!is_array($Review_Categories_Array_Before)) {$Review_Categories_Array_Before = array();}

	$Default_Fields = array(
		array("CategoryName" => "Product Name (if applicable)", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Author", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Reviewer Email (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Title", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Image (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Video (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => "")
	);

	if (!in_array($Default_Fields[6], $Review_Categories_Array_Before)) {$Review_Categories_Array = array_merge($Default_Fields, $Review_Categories_Array_Before);}
	else {$Review_Categories_Array = $Review_Categories_Array_Before;}

	$Unique_Categories = EWD_URP_unique_multidim_array($Review_Categories_Array, 'CategoryName');

	update_option("EWD_URP_Review_Categories_Array", $Unique_Categories);

	$Posts = get_posts('post_type=urp_review');

	foreach ($Posts as $Post) {
		if (get_post_meta($Post->ID, 'EWD_URP_Item_Reviewed', true) == "") {
			update_post_meta($Post->ID, 'EWD_URP_Item_Reviewed', 'urp_product');
			update_post_meta($Post->ID, 'EWD_URP_Item_ID', 0);
		}
	}

	if (get_option("EWD_URP_Review_Video") == "") {update_option("EWD_URP_Review_Video", "No");}
	if (get_option("EWD_URP_Submit_Review_Toggle") == "") {update_option("EWD_URP_Submit_Review_Toggle", "No");}
	if (get_option("EWD_URP_Display_Categories") == "") {update_option("EWD_URP_Display_Categories", "No");}
	if (get_option("EWD_URP_Flag_Inappropriate") == "") {update_option("EWD_URP_Flag_Inappropriate", "Yes");}
	if (get_option("EWD_URP_Review_Comments") == "") {update_option("EWD_URP_Review_Comments", "No");}
	if (get_option("EWD_URP_Summary_Clickable") == "") {update_option("EWD_URP_Summary_Clickable", "No");}
	if (get_option("EWD_URP_WooCommerce_Review_Types") == "") {update_option("EWD_URP_WooCommerce_Review_Types", array("Default"));}
	if (get_option("EWD_URP_WooCommerce_Minimum_Days") == "") {update_option("EWD_URP_WooCommerce_Minimum_Days", 0);}
	if (get_option("EWD_URP_WooCommerce_Maximum_Days") == "") {update_option("EWD_URP_WooCommerce_Maximum_Days", 1000);}
	if (get_option("EWD_URP_Match_WooCommerce_Categories") == "") {update_option("EWD_URP_Match_WooCommerce_Categories", "No");}
	if (get_option("EWD_URP_WooCommerce_Category_Product_Reviews") == "") {update_option("EWD_URP_WooCommerce_Category_Product_Reviews", 0);}
	if (get_option("EWD_URP_Install_Version") == "") {update_option("EWD_URP_Install_Version", 2.0);}

	if (get_option("EWD_URP_Install_Time") == "") {update_option("EWD_URP_Install_Time", time() - 3600*24*4);}

	update_option('EWD_URP_Version', $EWD_URP_Version);
}

add_filter('upgrader_pre_install', 'EWD_URP_SetUpdateOption');
function EWD_URP_SetUpdateOption() {
	update_option('EWD_URP_Update_Flag', "Yes");
}
?>