<?php 
function EWD_URP_Version_Reversion() {
	if (get_option("EWD_URP_Trial_Happening") != "Yes" or time() < get_option("EWD_URP_Trial_Expiry_Time")) {return;}

	update_option("EWD_URP_Review_Format", "Standard");
	update_option("EWD_URP_Summary_Statistics", "None");
	update_option("EWD_URP_Display_Microdata", "No");
	update_option("EWD_URP_Thumbnail_Characters", "140");
	update_option("EWD_URP_Replace_WooCommerce_Reviews", "No");
	update_option("EWD_URP_Override_WooCommerce_Theme", "No");
	update_option("EWD_URP_Review_Weights", "No");
	update_option("EWD_URP_Review_Karma", "No");
	update_option("EWD_URP_Use_Captcha", "No");
	update_option("EWD_URP_Infinite_Scroll", "No");
	update_option("EWD_URP_Admin_Notification", "No");
	update_option("EWD_URP_Admin_Approval", "No");
	update_option("EWD_URP_Require_Email", "No");
	update_option("EWD_URP_Email_Confirmation", "No");
	update_option("EWD_URP_Display_On_Confirmation", "Yes");
	update_option("EWD_URP_Require_Login", "No");
	update_option("EWD_URP_Login_Options", array());

	update_option("EWD_URP_Posted_Label", "");
	update_option("EWD_URP_By_Label", "");
	update_option("EWD_URP_On_Label", "");
	update_option("EWD_URP_Score_Label", "");
	update_option("EWD_URP_Explanation_Label", "");
	update_option("EWD_URP_Submit_Product_Label", "");
	update_option("EWD_URP_Submit_Author_Label", "");
	update_option("EWD_URP_Submit_Author_Comment_Label", "");
	update_option("EWD_URP_Submit_Title_Label", "");
	update_option("EWD_URP_Submit_Title_Comment_Label", "");
	update_option("EWD_URP_Submit_Score_Label", "");
	update_option("EWD_URP_Submit_Review_Label", "");
	update_option("EWD_URP_Submit_Cat_Score_Label", "");
	update_option("EWD_URP_Submit_Explanation_Label", "");
	update_option("EWD_URP_Submit_Button_Label", "");
	update_option("EWD_URP_Submit_Success_Message", "");
	update_option("EWD_URP_Submit_Draft_Message", "");
	
	update_option("EWD_urp_Review_Title_Font", "");
	update_option("EWD_urp_Review_Title_Font_Size", "");
	update_option("EWD_urp_Review_Title_Font_Color", "");
	update_option("EWD_urp_Review_Title_Margin", "");
	update_option("EWD_urp_Review_Title_Padding", "");
	update_option("EWD_urp_Review_Content_Font", "");
	update_option("EWD_urp_Review_Content_Font_Size", "");
	update_option("EWD_urp_Review_Content_Font_Color", "");
	update_option("EWD_urp_Review_Content_Margin", "");
	update_option("EWD_urp_Review_Content_Padding", "");
	update_option("EWD_urp_Review_Postdate_Font", "");
	update_option("EWD_urp_Review_Postdate_Font_Size", "");
	update_option("EWD_urp_Review_Postdate_Font_Color", "");
	update_option("EWD_urp_Review_Postdate_Margin", "");
	update_option("EWD_urp_Review_Postdate_Padding", "");
	update_option("EWD_urp_Review_Score_Font", "");
	update_option("EWD_urp_Review_Score_Font_Size", "");
	update_option("EWD_urp_Review_Score_Font_Color", "");
	update_option("EWD_urp_Review_Score_Margin", "");
	update_option("EWD_urp_Review_Score_Padding", "");
	
	update_option("EWD_urp_Summary_Stats_Color", "");
	update_option("EWD_urp_Simple_Bar_Color", "");
	update_option("EWD_urp_Color_Bar_High", "");
	update_option("EWD_urp_Color_Bar_Medium", "");
	update_option("EWD_urp_Color_Bar_Low", "");
	update_option("EWD_urp_Review_Background_Color", "");
	update_option("EWD_urp_Review_Header_Background_Color", "");
	update_option("EWD_urp_Review_Content_Background_Color", "");

	update_option("EWD_URP_Full_Version", "No");
	update_option("EWD_URP_Trial_Happening", "No");
	delete_option("EWD_URP_Trial_Expiry_Time");
}
add_action('admin_init', 'EWD_URP_Version_Reversion');

?>