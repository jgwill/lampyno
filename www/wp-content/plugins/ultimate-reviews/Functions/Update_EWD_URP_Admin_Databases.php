<?php
/* The file contains all of the functions which make changes to the WordPress tables */


function EWD_URP_UpdateOptions() {
	global $URP_Full_Version;

	if ( ! isset( $_POST['URP_Admin_Action'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['URP_Admin_Action'], 'URP_Admin_Action' ) ) {return;}

	$Current_Maximum_Score = get_option("EWD_URP_Maximum_Score");

	if (isset($_POST['maximum_score']) and $_POST['maximum_score'] != $Current_Maximum_Score) {
		$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
		$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");

		$Adjustment_Factor = $_POST['maximum_score'] / $Current_Maximum_Score;

		$params = array('post_type' => 'urp_review', 'post_count' => -1);
		$Reviews_Object = new WP_Query($params);
		$Reviews = $Reviews_Object->get_posts();

		foreach ($Reviews as $Review) {
			$Overall_Score = get_post_meta($Review->ID, 'EWD_URP_Overall_Score', true);
			update_post_meta($Review->ID, 'EWD_URP_Overall_Score', round($Overall_Score * $Adjustment_Factor, 1));

			if ($InDepth_Reviews == "Yes" and $Review_Categories_Array[0]['CategoryName'] != "") {
				foreach ($Review_Categories_Array as $Review_Category_Item) {
					if ($Review_Category_Item['CategoryName'] != "") {
						$Review_Category_Score = get_post_meta($Review->ID, "EWD_URP_" . $Review_Category_Item['CategoryName'], true);
						update_post_meta($Review->ID, 'EWD_URP_' . $Review_Category_Item['CategoryName'], round($Review_Category_Score * $Adjustment_Factor, 1));
					}
				}
			}
		}
	}

	if (isset($_POST['match_woocommerce_categories']) and $_POST['match_woocommerce_categories'] == "Yes" and get_option("EWD_URP_Match_WooCommerce_Categories") == "No") {add_action("init", "EWD_URP_WooCommerce_Category_Sync");}

	if (isset($_POST['verified_buyers']) and $_POST['verified_buyers'] == "Yes") {$_POST['login_options'][] = "WooCommerce";}

	if (isset($_POST['custom_css'])) {update_option('EWD_URP_Custom_CSS', stripslashes_deep($_POST['custom_css']));}
	if (isset($_POST['maximum_score'])) {update_option('EWD_URP_Maximum_Score', stripslashes_deep($_POST['maximum_score']));}
	if (isset($_POST['review_style'])) {update_option('EWD_URP_Review_Style', stripslashes_deep($_POST['review_style']));}
	if (isset($_POST['review_score_input'])) {update_option('EWD_URP_Review_Score_Input', stripslashes_deep($_POST['review_score_input']));}
	if (isset($_POST['review_image'])) {update_option('EWD_URP_Review_Image', stripslashes_deep($_POST['review_image']));}
	if (isset($_POST['review_video'])) {update_option('EWD_URP_Review_Video', stripslashes_deep($_POST['review_video']));}
	if (isset($_POST['review_category'])) {update_option('EWD_URP_Review_Category', stripslashes_deep($_POST['review_category']));}
	if (isset($_POST['Options_Submit'])) {update_option('EWD_URP_Review_Filtering', stripslashes_deep($_POST['review_filtering']));}
	if (isset($_POST['submit_review_toggle'])) {update_option('EWD_URP_Submit_Review_Toggle', stripslashes_deep($_POST['submit_review_toggle']));}
	if (isset($_POST['autocomplete_product_names'])) {update_option('EWD_URP_Autocomplete_Product_Names', stripslashes_deep($_POST['autocomplete_product_names']));}
	if (isset($_POST['restrict_product_names'])) {update_option('EWD_URP_Restrict_Product_Names', stripslashes_deep($_POST['restrict_product_names']));}
	if (isset($_POST['product_name_input_type'])) {update_option('EWD_URP_Product_Name_Input_Type', stripslashes_deep($_POST['product_name_input_type']));}
	if (isset($_POST['upcp_integration'])) {update_option('EWD_URP_UPCP_Integration', stripslashes_deep($_POST['upcp_integration']));}
	if (isset($_POST['link_to_post'])) {update_option('EWD_URP_Link_To_Post', stripslashes_deep($_POST['link_to_post']));}
	if (isset($_POST['display_author'])) {update_option('EWD_URP_Display_Author', stripslashes_deep($_POST['display_author']));}
	if (isset($_POST['display_categories'])) {update_option('EWD_URP_Display_Categories', stripslashes_deep($_POST['display_categories']));}
	if (isset($_POST['display_date'])) {update_option('EWD_URP_Display_Date', stripslashes_deep($_POST['display_date']));}
	if (isset($_POST['display_time'])) {update_option('EWD_URP_Display_Time', stripslashes_deep($_POST['display_time']));}
	if (isset($_POST['author_click_filter'])) {update_option('EWD_URP_Author_Click_Filter', stripslashes_deep($_POST['author_click_filter']));}
	if (isset($_POST['flag_inappropriate'])) {update_option('EWD_URP_Flag_Inappropriate', stripslashes_deep($_POST['flag_inappropriate']));}
	if (isset($_POST['review_comments'])) {update_option('EWD_URP_Review_Comments', stripslashes_deep($_POST['review_comments']));}
	if (isset($_POST['review_character_limit'])) {update_option('EWD_URP_Review_Character_Limit', stripslashes_deep($_POST['review_character_limit']));}
	if (isset($_POST['email_on_submission'])) {update_option('EWD_URP_Email_On_Submission', stripslashes_deep($_POST['email_on_submission']));}
	if (isset($_POST['reviews_per_page'])) {update_option('EWD_URP_Reviews_Per_Page', stripslashes_deep($_POST['reviews_per_page']));}
	if (isset($_POST['pagination_location'])) {update_option('EWD_URP_Pagination_Location', stripslashes_deep($_POST['pagination_location']));}
	if (isset($_POST['show_tinymce'])) {update_option('EWD_URP_Show_TinyMCE', stripslashes_deep($_POST['show_tinymce']));}

	if (isset($_POST['allow_reviews'])) {update_option('EWD_URP_Allow_Reviews', stripslashes_deep($_POST['allow_reviews']));}

	if (isset($_POST['review_format']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Review_Format', stripslashes_deep($_POST['review_format']));}
	if (isset($_POST['summary_statistics']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Summary_Statistics', stripslashes_deep($_POST['summary_statistics']));}
	if (isset($_POST['summary_clickable']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Summary_Clickable', stripslashes_deep($_POST['summary_clickable']));}
	if (isset($_POST['display_microdata']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Display_Microdata', stripslashes_deep($_POST['display_microdata']));}
	if (isset($_POST['pretty_permalinks']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Pretty_Permalinks', stripslashes_deep($_POST['pretty_permalinks']));}
	if (isset($_POST['review_weights']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Review_Weights', stripslashes_deep($_POST['review_weights']));}
	if (isset($_POST['review_karma']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Review_Karma', stripslashes_deep($_POST['review_karma']));}
	if (isset($_POST['use_captcha']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Use_Captcha', stripslashes_deep($_POST['use_captcha']));}
	if (isset($_POST['infinite_scroll']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Infinite_Scroll', stripslashes_deep($_POST['infinite_scroll']));}
	if (isset($_POST['thumbnail_characters']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Thumbnail_Characters', stripslashes_deep($_POST['thumbnail_characters']));}
	if (isset($_POST['read_more_ajax']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Read_More_AJAX', stripslashes_deep($_POST['read_more_ajax']));}
	if (isset($_POST['admin_notification']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Admin_Notification', stripslashes_deep($_POST['admin_notification']));}
	if (isset($_POST['admin_email_address']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Admin_Email_Address', stripslashes_deep($_POST['admin_email_address']));}
	if (isset($_POST['admin_approval']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Admin_Approval', stripslashes_deep($_POST['admin_approval']));}
	if (isset($_POST['require_email']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Require_Email', stripslashes_deep($_POST['require_email']));}
	if (isset($_POST['email_confirmation']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Email_Confirmation', stripslashes_deep($_POST['email_confirmation']));}
	if (isset($_POST['display_on_confirmation']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Display_On_Confirmation', stripslashes_deep($_POST['display_on_confirmation']));}
	if (isset($_POST['one_review_per_product_person']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_One_Review_Per_Product_Person', stripslashes_deep($_POST['one_review_per_product_person']));}
	if (isset($_POST['review_blacklist']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Review_Blacklist', stripslashes_deep($_POST['review_blacklist']));}
	if (isset($_POST['require_login']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Require_Login', stripslashes_deep($_POST['require_login']));}
	if(!isset($_POST['login_options'])) {$_POST['login_options'] = array();}
	if (isset($_POST['require_login']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Login_Options', stripslashes_deep($_POST['login_options']));}

	if ((isset($_POST['pretty_permalinks'])) and $_POST['pretty_permalinks'] == "Yes") {update_option("EWD_URP_Rewrite_Rules", "Yes");}

	if (isset($_POST['replace_woocommerce_reviews']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Replace_WooCommerce_Reviews', stripslashes_deep($_POST['replace_woocommerce_reviews']));}
	if (isset($_POST['woocommerce_review_submit_first']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WooCommerce_Review_Submit_First', stripslashes_deep($_POST['woocommerce_review_submit_first']));}
	if (isset($_POST['only_woocommerce_products']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Only_WooCommerce_Products', stripslashes_deep($_POST['only_woocommerce_products']));}
	if (isset($_POST['woocommerce_review_types']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WooCommerce_Review_Types', stripslashes_deep($_POST['woocommerce_review_types']));}
	if (isset($_POST['override_woocommerce_theme']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Override_WooCommerce_Theme', stripslashes_deep($_POST['override_woocommerce_theme']));}
	if (isset($_POST['display_woocommerce_verified']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Display_WooCommerce_Verified', stripslashes_deep($_POST['display_woocommerce_verified']));}
	if (isset($_POST['woocommerce_minimum_days']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WooCommerce_Minimum_Days', stripslashes_deep($_POST['woocommerce_minimum_days']));}
	if (isset($_POST['woocommerce_maximum_days']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WooCommerce_Maximum_Days', stripslashes_deep($_POST['woocommerce_maximum_days']));}
	if (isset($_POST['match_woocommerce_categories']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Match_WooCommerce_Categories', stripslashes_deep($_POST['match_woocommerce_categories']));}
	if (isset($_POST['woocommerce_category_product_reviews']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WooCommerce_Category_Product_Reviews', stripslashes_deep($_POST['woocommerce_category_product_reviews']));}

	$Reminders = array();
	$Counter = 0;
	while ($Counter < 30) {
		if (isset($_POST['Reminder_' . $Counter . '_Reminder_Interval'])) {
			$Prefix = 'Reminder_' . $Counter;

			$Reminder['ID'] = sanitize_text_field($_POST[$Prefix . '_ID']);
			$Reminder['Email_To_Send'] = sanitize_text_field($_POST[$Prefix . '_Email_To_Send']);
			$Reminder['Reminder_Interval'] = sanitize_text_field($_POST[$Prefix . '_Reminder_Interval']);
			$Reminder['Reminder_Unit'] = sanitize_text_field($_POST[$Prefix . '_Reminder_Unit']);
			$Reminder['Status_Trigger'] = isset($_POST[$Prefix . '_Status_Trigger']) ? sanitize_text_field($_POST[$Prefix . '_Status_Trigger']) : '';

			$Reminders[] = $Reminder;
			unset($Reminder);
		}
		$Counter++;
	}
	if (isset($_POST['Options_Submit'])) {update_option('EWD_URP_Reminders_Array', $Reminders);}
	
	$Emails = array();
	$Counter = 0;
	while ($Counter < 30) {
		if (isset($_POST['Email_Message_' . $Counter . '_Name'])) {
			$Prefix = 'Email_Message_' . $Counter;

			$Email['ID'] = sanitize_text_field($_POST[$Prefix . '_ID']);
			$Email['Name'] = sanitize_text_field($_POST[$Prefix . '_Name']);
			$Email['Message'] = sanitize_text_field($_POST[$Prefix . '_Body']);

			$Emails[] = $Email;
			unset($Email);
		}
		$Counter++;
	}
	if (isset($_POST['Options_Submit'])) {update_option('EWD_URP_Email_Messages_Array', $Emails);}

	if (isset($_POST['wordpress_login_url']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_WordPress_Login_URL', stripslashes_deep($_POST['wordpress_login_url']));}
	if (isset($_POST['feup_login_url']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_FEUP_Login_URL', stripslashes_deep($_POST['feup_login_url']));}
	if (isset($_POST['facebook_app_id']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Facebook_App_ID', stripslashes_deep($_POST['facebook_app_id']));}
	if (isset($_POST['facebook_secret']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Facebook_Secret', stripslashes_deep($_POST['facebook_secret']));}
	if (isset($_POST['twitter_key']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Twitter_Key', stripslashes_deep($_POST['twitter_key']));}
	if (isset($_POST['twitter_secret']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Twitter_Secret', stripslashes_deep($_POST['twitter_secret']));}

	if (isset($_POST['group_by_product'])) {update_option('EWD_URP_Group_By_Product', stripslashes_deep($_POST['group_by_product']));}
	if (isset($_POST['group_by_product_order'])) {update_option('EWD_URP_Group_By_Product_Order', stripslashes_deep($_POST['group_by_product_order']));}
	if (isset($_POST['ordering_type'])) {update_option('EWD_URP_Ordering_Type', stripslashes_deep($_POST['ordering_type']));}
	if (isset($_POST['order_direction'])) {update_option('EWD_URP_Order_Direction', stripslashes_deep($_POST['order_direction']));}

	if (isset($_POST['display_numerical_score'])) {update_option('EWD_URP_Display_Numerical_Score', stripslashes_deep($_POST['display_numerical_score']));}
	if (isset($_POST['reviews_skin'])) {update_option('EWD_URP_Reviews_Skin', stripslashes_deep($_POST['reviews_skin']));}
	if (isset($_POST['review_group_separating_line'])) {update_option('EWD_URP_Review_Group_Separating_Line', stripslashes_deep($_POST['review_group_separating_line']));}
	if (isset($_POST['indepth_layout'])) {update_option('EWD_URP_InDepth_Layout', stripslashes_deep($_POST['indepth_layout']));}
	if (isset($_POST['read_more_style'])) {update_option('EWD_URP_Read_More_Style', stripslashes_deep($_POST['read_more_style']));}

	if (isset($_POST['indepth_reviews'])) {update_option('EWD_URP_InDepth_Reviews', stripslashes_deep($_POST['indepth_reviews']));}
	//Saving in-depth categories
	$Counter = 0;
	while ($Counter < 40) {
		if (isset($_POST['Review_Category_' . $Counter . '_Name'])) {
			$Prefix = 'Review_Category_' . $Counter;

			$Order = $_POST['Review_Category_Order_' . $Counter];

			$Category['CategoryName'] = $_POST[$Prefix . '_Name'];
			$Category['CategoryRequired'] = $_POST[$Prefix . '_Required'];
			$Category['ExplanationAllowed'] = $_POST[$Prefix . '_Explanation'];
			$Category['CategoryType'] = $_POST[$Prefix . '_Type'];
			if ($Category['CategoryType'] != "ReviewItem" and $Category['CategoryType'] != "Default") {$Category['Filterable'] = $_POST[$Prefix . '_Filterable'];}
			if(isset($_POST[$Prefix . '_Options'])){$Category['Options'] = $_POST[$Prefix . '_Options'];}

			$Categories[$Order] = $Category;
			unset($Category);
		}
		$Counter++;
	}

	if (isset($_POST['indepth_reviews'])) {ksort($Categories); update_option("EWD_URP_Review_Categories_Array", $Categories);}

	//Saving the product list
	$Products = array();
	$Counter = 0;
	while ($Counter < 500) {
		if (isset($_POST['Product_List_' . $Counter . '_Name'])) {
			$Prefix = 'Product_List_' . $Counter;

			$Product['ProductName'] = $_POST[$Prefix . '_Name'];

			$Products[] = $Product;
			unset($Product);
		}
		$Counter++;
	}
	if (isset($_POST['restrict_product_names'])) {update_option("EWD_URP_Product_Names_Array", $Products);}

    if (isset($_POST['posted_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Posted_Label',  stripslashes_deep($_POST['posted_label']));}
    if (isset($_POST['by_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_By_Label',  stripslashes_deep($_POST['by_label']));}
    if (isset($_POST['on_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_On_Label',  stripslashes_deep($_POST['on_label']));}
    if (isset($_POST['score_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Score_Label',  stripslashes_deep($_POST['score_label']));}
    if (isset($_POST['explanation_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Explanation_Label',  stripslashes_deep($_POST['explanation_label']));}
    if (isset($_POST['submit_product_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Product_Label',  stripslashes_deep($_POST['submit_product_label']));}
    if (isset($_POST['submit_author_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Author_Label',  stripslashes_deep($_POST['submit_author_label']));}
    if (isset($_POST['submit_author_comment_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Author_Comment_Label',  stripslashes_deep($_POST['submit_author_comment_label']));}
    if (isset($_POST['submit_title_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Title_Label',  stripslashes_deep($_POST['submit_title_label']));}
    if (isset($_POST['submit_title_comment_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Title_Comment_Label',  stripslashes_deep($_POST['submit_title_comment_label']));}
    if (isset($_POST['submit_score_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Score_Label',  stripslashes_deep($_POST['submit_score_label']));}
    if (isset($_POST['submit_review_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Review_Label',  stripslashes_deep($_POST['submit_review_label']));}
    if (isset($_POST['submit_cat_score_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Cat_Score_Label',  stripslashes_deep($_POST['submit_cat_score_label']));}
    if (isset($_POST['submit_explanation_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Explanation_Label',  stripslashes_deep($_POST['submit_explanation_label']));}
    if (isset($_POST['submit_button_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Button_Label',  stripslashes_deep($_POST['submit_button_label']));}
    if (isset($_POST['submit_success_message']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Success_Message',  stripslashes_deep($_POST['submit_success_message']));}
	if (isset($_POST['submit_draft_message']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Draft_Message',  stripslashes_deep($_POST['submit_draft_message']));}
	if (isset($_POST['review_for_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Review_For_Label',  stripslashes_deep($_POST['review_for_label']));}
	if (isset($_POST['categories_label_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Categories_Label_Label',  stripslashes_deep($_POST['categories_label_label']));}
	if (isset($_POST['filter_button_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Filter_Button_Label',  stripslashes_deep($_POST['filter_button_label']));}
	if (isset($_POST['filter_product_name_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Filter_Product_Name_Label',  stripslashes_deep($_POST['filter_product_name_label']));}
	if (isset($_POST['filter_all_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Filter_All_Label',  stripslashes_deep($_POST['filter_all_label']));}
	if (isset($_POST['filter_review_score_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Filter_Review_Score_Label',  stripslashes_deep($_POST['filter_review_score_label']));}
	if (isset($_POST['filter_review_author_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Filter_Review_Author_Label',  stripslashes_deep($_POST['filter_review_author_label']));}
	if (isset($_POST['submit_reviewer_email_address_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Reviewer_Email_Address_Label',  stripslashes_deep($_POST['submit_reviewer_email_address_label']));}
	if (isset($_POST['submit_reviewer_email_address_instructions_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Reviewer_Email_Address_Instructions_Label',  stripslashes_deep($_POST['submit_reviewer_email_address_instructions_label']));}
	if (isset($_POST['submit_image_number_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Submit_Image_Number_Label',  stripslashes_deep($_POST['submit_image_number_label']));}
	if (isset($_POST['summary_average_score_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Summary_Average_Score_Label',  stripslashes_deep($_POST['summary_average_score_label']));}
	if (isset($_POST['summary_ratings_label']) and $URP_Full_Version == "Yes") {update_option('EWD_URP_Summary_Ratings_Label',  stripslashes_deep($_POST['summary_ratings_label']));}

	if (isset($_POST['urp_review_title_font']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Title_Font', stripslashes_deep($_POST['urp_review_title_font']));}
	if (isset($_POST['urp_review_title_font_size']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Title_Font_Size', stripslashes_deep($_POST['urp_review_title_font_size']));}
	if (isset($_POST['urp_review_title_font_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Title_Font_Color', stripslashes_deep($_POST['urp_review_title_font_color']));}
	if (isset($_POST['urp_review_title_margin']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Title_Margin', stripslashes_deep($_POST['urp_review_title_margin']));}
	if (isset($_POST['urp_review_title_padding']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Title_Padding', stripslashes_deep($_POST['urp_review_title_padding']));}
	if (isset($_POST['urp_review_content_font']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Font', stripslashes_deep($_POST['urp_review_content_font']));}
	if (isset($_POST['urp_review_content_font_size']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Font_Size', stripslashes_deep($_POST['urp_review_content_font_size']));}
	if (isset($_POST['urp_review_content_font_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Font_Color', stripslashes_deep($_POST['urp_review_content_font_color']));}
	if (isset($_POST['urp_review_content_margin']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Margin', stripslashes_deep($_POST['urp_review_content_margin']));}
	if (isset($_POST['urp_review_content_padding']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Padding', stripslashes_deep($_POST['urp_review_content_padding']));}
	if (isset($_POST['urp_review_postdate_font']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Postdate_Font', stripslashes_deep($_POST['urp_review_postdate_font']));}
	if (isset($_POST['urp_review_postdate_font_size']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Postdate_Font_Size', stripslashes_deep($_POST['urp_review_postdate_font_size']));}
	if (isset($_POST['urp_review_postdate_font_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Postdate_Font_Color', stripslashes_deep($_POST['urp_review_postdate_font_color']));}
	if (isset($_POST['urp_review_postdate_margin']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Postdate_Margin', stripslashes_deep($_POST['urp_review_postdate_margin']));}
	if (isset($_POST['urp_review_postdate_padding']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Postdate_Padding', stripslashes_deep($_POST['urp_review_postdate_padding']));}
	if (isset($_POST['urp_review_score_font']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Score_Font', stripslashes_deep($_POST['urp_review_score_font']));}
	if (isset($_POST['urp_review_score_font_size']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Score_Font_Size', stripslashes_deep($_POST['urp_review_score_font_size']));}
	if (isset($_POST['urp_review_score_font_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Score_Font_Color', stripslashes_deep($_POST['urp_review_score_font_color']));}
	if (isset($_POST['urp_review_score_margin']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Score_Margin', stripslashes_deep($_POST['urp_review_score_margin']));}
	if (isset($_POST['urp_review_score_padding']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Score_Padding', stripslashes_deep($_POST['urp_review_score_padding']));}

	if (isset($_POST['urp_summary_stats_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Summary_Stats_Color', stripslashes_deep($_POST['urp_summary_stats_color']));}
	if (isset($_POST['urp_simple_bar_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Simple_Bar_Color', stripslashes_deep($_POST['urp_simple_bar_color']));}
	if (isset($_POST['urp_color_bar_high']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Color_Bar_High', stripslashes_deep($_POST['urp_color_bar_high']));}
	if (isset($_POST['urp_color_bar_medium']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Color_Bar_Medium', stripslashes_deep($_POST['urp_color_bar_medium']));}
	if (isset($_POST['urp_color_bar_low']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Color_Bar_Low', stripslashes_deep($_POST['urp_color_bar_low']));}
	if (isset($_POST['urp_review_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Background_Color', stripslashes_deep($_POST['urp_review_background_color']));}
	if (isset($_POST['urp_review_header_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Header_Background_Color', stripslashes_deep($_POST['urp_review_header_background_color']));}
	if (isset($_POST['urp_review_content_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Review_Content_Background_Color', stripslashes_deep($_POST['urp_review_content_background_color']));}

	if (isset($_POST['urp_read_more_button_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Read_More_Button_Background_Color', stripslashes_deep($_POST['urp_read_more_button_background_color']));}
	if (isset($_POST['urp_read_more_button_text_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Read_More_Button_Text_Color', stripslashes_deep($_POST['urp_read_more_button_text_color']));}
	if (isset($_POST['urp_read_more_button_hover_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Read_More_Button_Hover_Background_Color', stripslashes_deep($_POST['urp_read_more_button_hover_background_color']));}
	if (isset($_POST['urp_read_more_button_hover_text_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Read_More_Button_Hover_Text_Color', stripslashes_deep($_POST['urp_read_more_button_hover_text_color']));}

	if (isset($_POST['urp_image_style_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Image_Style_Background_Color', stripslashes_deep($_POST['urp_image_style_background_color']));}
	if (isset($_POST['urp_circle_graph_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Circle_Graph_Background_Color', stripslashes_deep($_POST['urp_circle_graph_background_color']));}
	if (isset($_POST['urp_circle_graph_fill_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Circle_Graph_Fill_Color', stripslashes_deep($_POST['urp_circle_graph_fill_color']));}

	if (isset($_POST['urp_email_reminder_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Background_Color', stripslashes_deep($_POST['urp_email_reminder_background_color']));}
	if (isset($_POST['urp_email_reminder_inner_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Inner_Color', stripslashes_deep($_POST['urp_email_reminder_inner_color']));}
	if (isset($_POST['urp_email_reminder_text_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Text_Color', stripslashes_deep($_POST['urp_email_reminder_text_color']));}
	if (isset($_POST['urp_email_reminder_button_background_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Button_Background_Color', stripslashes_deep($_POST['urp_email_reminder_button_background_color']));}
	if (isset($_POST['urp_email_reminder_button_background_hover_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Button_Background_Hover_Color', stripslashes_deep($_POST['urp_email_reminder_button_background_hover_color']));}
	if (isset($_POST['urp_email_reminder_button_text_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Button_Text_Color', stripslashes_deep($_POST['urp_email_reminder_button_text_color']));}
	if (isset($_POST['urp_email_reminder_button_text_hover_color']) and $URP_Full_Version == "Yes") {update_option('EWD_urp_Email_Reminder_Button_Text_Hover_Color', stripslashes_deep($_POST['urp_email_reminder_button_text_hover_color']));}

	$update_message = __("Options have been successfully updated.", 'ultimate-reviews');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

?>
