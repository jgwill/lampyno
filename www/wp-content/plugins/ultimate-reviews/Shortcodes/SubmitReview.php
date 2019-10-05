<?php
function URP_Submit_Review_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-urp-blocks-js', plugins_url( '../blocks/ewd-urp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-urp-blocks-css', plugins_url( '../blocks/ewd-urp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-urp-blocks.css' ) );
		register_block_type( 'ultimate-reviews/ewd-urp-submit-review-block', array(
			'attributes'      => array(
				'product_name' => array(
					'type' => 'string',
				),
				'redirect_page' => array(
					'type' => 'string',
				),
			),
			'editor_script'   => 'ewd-urp-blocks-js',
			'editor_style'  => 'ewd-urp-blocks-css',
			'render_callback' => 'Insert_Review_Form',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("submit-review", "Insert_Review_Form");
}
add_action( 'init', 'URP_Submit_Review_Block' );

function Insert_Review_Form($atts) {
	global $user_message;
	global $Textarea_Counter;

	$Custom_CSS = get_option('EWD_URP_Custom_CSS');
	$Submit_Review_Toggle = get_option("EWD_URP_Submit_Review_Toggle");

	$Use_Captcha = get_option("EWD_URP_Use_Captcha");
	$Admin_Approval = get_option("EWD_URP_Admin_Approval");
	$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
	$Display_On_Confirmation = get_option("EWD_URP_Display_On_Confirmation");
	$Require_Login = get_option("EWD_URP_Require_Login");
	$Login_Options = get_option("EWD_URP_Login_Options");
	$Salt = get_option("EWD_URP_Hash_Salt");

	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
	if ($InDepth_Reviews == "No") {
		$Default_Fields = array(
			array("CategoryName" => "Product Name (if applicable)", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Review Author", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Reviewer Email (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Review Title", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Review Image (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Review Video (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Review", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
			array("CategoryName" => "Overall Score", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => "")
		);
		$Review_Categories_Array = $Default_Fields;
	}

	$Submit_Button_Label = get_option("EWD_URP_Submit_Button_Label");
	if ($Submit_Button_Label == "") {$Submit_Button_Label = __("Send Review", 'ultimate-reviews');}


	$ReturnString = "";

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
		 		'product_name' => '',
		 		'submit_review_toggle' => '',
		 		'redirect_page' => '',
		 		'success_message' => __('Thank you for submitting a review.', 'ultimate-reviews'),
		 		'draft_message' => __("Your review will be visible once it's approved by an administrator.", 'ultimate-reviews'),
		 		'review_form_title' => __('Submit a Review', 'ultimate-reviews'),
				'review_instructions' => __('Please fill out the form below to submit a review.', 'ultimate-reviews'),
				'submit_text' => __('Send Review', 'ultimate-reviews')),
		$atts
		)
	);

	if ($submit_review_toggle != "") {$Submit_Review_Toggle = $submit_review_toggle;}

	if (get_option("EWD_URP_Submit_Success_Message") != "") {$success_message = get_option("EWD_URP_Submit_Success_Message");}
	if (get_option("EWD_URP_Submit_Draft_Message") != "") {$draft_message = get_option("EWD_URP_Submit_Draft_Message");}

	if ($Admin_Approval == "Yes") {$success_message .= " " . $draft_message;}

	if (isset($_POST['Submit_Review'])) {$user_update = EWD_URP_Submit_Review($success_message);}
	if (isset($_GET['ConfirmEmail'])) {$user_update = EWD_URP_Confirm_Email();}

	if (isset($_REQUEST['product_name'])) {$product_name = $_REQUEST['product_name'];}

	if (isset($user_update) and $user_update == $success_message and $redirect_page != '') {header('location:'. $redirect_page); exit();}

	if ($Submit_Review_Toggle == "Yes" and !isset($_POST['Submit_Review'])) {$Toggle_Class = "ewd-urp-content-hidden";}
	else {$Toggle_Class = "";}

	$ReturnString .= "<style type='text/css'>";
	$ReturnString .= ".ui-autocomplete {background:#FFF; border: #000 solid 1px; max-width:400px; max-height:200px; overflow:auto;}";
	$ReturnString .= $Custom_CSS;
	$ReturnString .= "</style>";

	if ($Require_Login == "Yes" or in_array("WooCommerce", $Login_Options)) {
		if (in_array("WooCommerce", $Login_Options)) {
			$WooCommerce_Return = EWD_URP_WooCommerce_Customer_Login();

			if ($WooCommerce_Return['DisplayForm'] != "Yes") {return $WooCommerce_Return['Response_HTML'];}
		}
		else {
			$Logged_In_User = EWD_URP_Get_Login_Information();
			if ($Logged_In_User['Login_Status'] == "None") {
				$ReturnString .= "<div class='ewd-urp-login-message'>";
				$ReturnString .= __("Please log in to leave a review", 'ultimate-reviews');
				$ReturnString .= "<br />";
				$ReturnString .= __("Login Options:", 'ultimate-reviews');
				$ReturnString .= "</div>";
				$ReturnString .= "<div class='ewd-urp-login-options'>";
				$ReturnString .= $Logged_In_User['ManageLogin'];
				$ReturnString .= "</div>";
				return $ReturnString;
			}
		}
	}
	else {
		$Logged_In_User['Author_Name'] = "";
	}

	if (isset($WooCommerce_Return)) {
		$product_name = $WooCommerce_Return['SelectedProduct'];
		$Logged_In_User = array("Author_Name" => $WooCommerce_Return['Customer']);
	}

	$ReturnString .= "<div class='ewd-urp-review-form " . $Toggle_Class . "'>";

	if (isset($_GET['ConfirmEmail']) and $Display_On_Confirmation == "No") {$ReturnString .= $user_update . "</div>"; return $ReturnString;}

	if (isset($_POST['Submit_Review'])) {
		$ReturnString .= "<div class='ewd-urp-review-update'>";
		$ReturnString .= $user_update;
		$ReturnString .= "</div>";
	}

	$ReturnString .= "<form id='review_order' method='post' action='#' enctype='multipart/form-data'>";
	$ReturnString .= wp_nonce_field();
	$ReturnString .= wp_referer_field();
	if (isset($_REQUEST['order_id'])) {$ReturnString .= '<input type="hidden" name="order_id" value="' . sanitize_text_field($_REQUEST['order_id']) . '" />';}

	if ($Email_Confirmation == "Yes") {
		$ReturnString .= "<input type='hidden' name='Current_URL' value='" . get_permalink() . "' />";
	}

	if (isset($WooCommerce_Return)) {
		$ReturnString .= "<input type='hidden' name='WC_Email' value='" . $WooCommerce_Return['WC_Email'] . "' />";
	}

	$Textarea_Counter = 0;

	foreach ($Review_Categories_Array as $Review_Category_Item) {
		if ($Review_Category_Item['CategoryName'] != "") {
			if ($Review_Category_Item['CategoryType'] == "Default") {$ReturnString .= EWD_URP_Add_Default_Field($Review_Category_Item, $product_name, $Logged_In_User);}
			elseif ($Review_Category_Item['CategoryType'] == "" or $Review_Category_Item['CategoryType'] == "ReviewItem") {$ReturnString .= EWD_URP_Add_Review_Item_Field($Review_Category_Item);}
			else {$ReturnString .= EWD_URP_Add_Custom_Field($Review_Category_Item);}

			if ($Review_Category_Item['ExplanationAllowed'] == "Yes") {$ReturnString .= EWD_URP_Add_Explanation_Field($Review_Category_Item);}
		}
	}

	if ($Use_Captcha == "Yes") {$ReturnString .= EWD_URP_Add_Captcha();}

	$ReturnString .= "<div class='ewd-urp-submit'><label for='submit'></label><span class='submit'><input type='submit' name='Submit_Review' id='ewd-urp-review-submit' class='button-primary' value='" . $Submit_Button_Label . "'  /></span></div></form>";
	$ReturnString .= "</div>";

	if ($Submit_Review_Toggle == "Yes" and !isset($_POST['Submit_Review'])) {
		$ReturnString .= "<div class='ewd-urp-submit-review-toggle'>";
		$ReturnString .= "<div class='ewd-urp-toggle-button'>" . __("Click to add your own review!", 'ultimate-reviews') . "</div>";
		$ReturnString .= "</div>";
	}

	$ReturnString .= '<div class="ewd-urp-clear"></div>';

	return $ReturnString;
}


function EWD_URP_Add_Default_Field($Review_Category_Item, $product_name, $Logged_In_User) {
	$Review_Image = get_option("EWD_URP_Review_Image");
	$Review_Video = get_option("EWD_URP_Review_Video");
	$Require_Email = get_option("EWD_URP_Require_Email");

	$ReturnString = '';

	if ($Review_Category_Item['CategoryName'] == "Product Name (if applicable)") {$ReturnString .= EWD_URP_Add_Product_Name_Field($product_name, $Review_Category_Item['CategoryRequired']);}
	elseif ($Review_Category_Item['CategoryName'] == "Review Author") {$ReturnString .= EWD_URP_Add_Author_Field($Logged_In_User, $Review_Category_Item['CategoryRequired']);}
	elseif ($Review_Category_Item['CategoryName'] == "Review Title") {$ReturnString .= EWD_URP_Add_Review_Title_Field($Review_Category_Item['CategoryRequired']);}
	elseif ($Review_Category_Item['CategoryName'] == "Overall Score") {$ReturnString .= EWD_URP_Add_Review_Item_Field($Review_Category_Item);}
	elseif ($Review_Category_Item['CategoryName'] == "Reviewer Email (if applicable)" and $Require_Email == "Yes") {$ReturnString .= EWD_URP_Add_Author_Email_Field();}
	elseif ($Review_Category_Item['CategoryName'] == "Review") {$ReturnString .= EWD_URP_Add_Review_Body_Field();}
	elseif ($Review_Category_Item['CategoryName'] == "Review Image (if applicable)" and $Review_Image == "Yes") {$ReturnString .= EWD_URP_Add_Review_Image_Field($Review_Category_Item['CategoryRequired']);}
	elseif ($Review_Category_Item['CategoryName'] == "Review Video (if applicable)" and $Review_Video == "Yes") {$ReturnString .= EWD_URP_Add_Review_Video_Field($Review_Category_Item['CategoryRequired']);}
	elseif ($Review_Category_Item['CategoryName'] == "Review Category (if applicable)" and $Review_Video == "Yes") {$ReturnString .= EWD_URP_Add_Review_Category_Field($Review_Category_Item['CategoryRequired']);}

	return $ReturnString;
}

function EWD_URP_Add_Product_Name_Field($product_name, $Required) {
	global $wpdb;
	
	$UPCP_Integration = get_option("EWD_URP_UPCP_Integration");
	$Product_Name_Input_Type = get_option("EWD_URP_Product_Name_Input_Type");
	$Product_Names_Array = get_option("EWD_URP_Product_Names_Array");
	$Autocomplete_Product_Names = get_option("EWD_URP_Autocomplete_Product_Names");
	$Restrict_Product_Names = get_option("EWD_URP_Restrict_Product_Names");

	$Only_WooCommerce_Products = get_option("EWD_URP_Only_WooCommerce_Products");

	$Submit_Product_Label = get_option("EWD_URP_Submit_Product_Label");
	if ($Submit_Product_Label == "") {$Submit_Product_Label = __("Product Name", 'ultimate-reviews');}

	if ($Only_WooCommerce_Products == "Yes") {
		$Restrict_Product_Names = "Yes";
		$Product_Names_Array = array();

		$Products = get_posts(array('post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));
		foreach ($Products as $Product) {$Product_Names_Array[] = array('ProductName' => $Product->post_title);}
	}

	if ($Required == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	if ($product_name != "") {
		$ReturnString .= "<div class='ewd-urp-form-header'>";
		$ReturnString .= __("Review of ", 'ultimate-reviews') . " " . $product_name;
		$ReturnString .= "</div>";
		$ReturnString .= "<input type='hidden' name='Product_Name' value='" . $product_name ."' />";
	}
	elseif ($Product_Name_Input_Type == "Dropdown") {
		$ReturnString .= "<div class='form-field'>";
		$ReturnString .= "<label id='ewd-urp-review-product-name-label' class='ewd-urp-review-label'>";
		$ReturnString .= $Submit_Product_Label . ": ";
		$ReturnString .= "</label>";
		$ReturnString .= "<select name='Product_Name' id='Product_Name'>";
		if ($UPCP_Integration == "Yes") {
			$items_table_name = $wpdb->prefix . "UPCP_Items";
			$Products = $wpdb->get_results("SELECT Item_Name FROM $items_table_name");
			foreach ($Products as $Product) {
				$ReturnString .= "<option value='" . $Product->Item_Name . "'>" . $Product->Item_Name . "</option>";
			}
		}
		else {
			if (!is_array($Product_Names_Array)) {$Product_Names_Array = array();}
			foreach ($Product_Names_Array as $Product_Name_Item) {
				$ReturnString .= "<option value='" . $Product_Name_Item['ProductName'] . "'>" . $Product_Name_Item['ProductName'] . "</option>";
			}
		}
		$ReturnString .= "</select>";
		$ReturnString .= "</div>";
	}
	else {
		$ReturnString .= "<div class='form-field'>";
		$ReturnString .= "<label id='ewd-urp-review-product-name-label' class='ewd-urp-review-label'>";
		$ReturnString .=  $Submit_Product_Label . ": </label>";
		$ReturnString .= "<input name='Product_Name' id='Product_Name' type='text' class='ewd-urp-product-name-text-input' value='" . (isset($_POST['Product_Name']) ? $_POST['Product_Name'] : '') . "' size='60' " . $Required_Text . "/>";
		if ($Restrict_Product_Names == "Yes") {$ReturnString .= "<div id='ewd-urp-restrict-product-names-message'></div>";}
		$ReturnString .= "</div>";
	}

	//Pass the possible product names to javascript for autocomplete and name restricting
	if ($Product_Name_Input_Type == "Text") {
		$ReturnString .= "<script>";
		if ($Autocomplete_Product_Names == "Yes") {$ReturnString .= "var autocompleteProductNames = 'Yes';\n";}
		if ($Restrict_Product_Names == "Yes") {$ReturnString .= "var restrictProductNames = 'Yes';\n";}
		if ($UPCP_Integration == "Yes") {
			$items_table_name = $wpdb->prefix . "UPCP_Items";
			$Products = $wpdb->get_results("SELECT Item_Name FROM $items_table_name");
			$ReturnString .= "var productNames = [";
			foreach ($Products as $Product) {
				$ReturnString .= "'" . $Product->Item_Name . "',";
			}
			if (sizeof($Products) > 0) {$ReturnString = substr($ReturnString, 0, -1);}
			$ReturnString .= "];\n";
		}
		else {
			$ReturnString .= "var productNames = [";
			if (!is_array($Product_Names_Array)) {$Product_Names_Array = array();}
			foreach ($Product_Names_Array as $Product_Name_Item) {
				$ReturnString .= "'" . $Product_Name_Item['ProductName'] . "',";
			}
			if (sizeof($Product_Names_Array) > 0) {$ReturnString = substr($ReturnString, 0, -1);}
			$ReturnString .= "];\n";
		}
		$ReturnString .= "</script>";
	}

	return $ReturnString;
}

function EWD_URP_Add_Author_Field($Logged_In_User, $Required) {
	$Submit_Author_Label = get_option("EWD_URP_Submit_Author_Label");
	if ($Submit_Author_Label == "") {$Submit_Author_Label = __("Review Author", 'ultimate-reviews');}
	$Submit_Author_Comment_Label = get_option("EWD_URP_Submit_Author_Comment_Label");
	if ($Submit_Author_Comment_Label == "") {$Submit_Author_Comment_Label = __("What name should be displayed with your review?", 'ultimate-reviews');}

	if ($Required == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-review-author' class='ewd-urp-review-label'>";
	$ReturnString .= $Submit_Author_Label . ": </label>";
	if (!isset($Logged_In_User['Author_Name']) or $Logged_In_User['Author_Name'] == "") {
		$ReturnString .= "<input type='hidden' name='Post_Author_Type' id='Post_Author_Type' value='Manual' />";
		$ReturnString .= "<input type='text' name='Post_Author' id='Post_Author' value='" . (isset($_POST['Post_Author']) ? $_POST['Post_Author'] : '') . "' " . $Required_Text . "/>";
		$ReturnString .= "<div id='ewd-urp-author-explanation' class='ewd-urp-review-explanation'>";
		$ReturnString .= "<label for='explanation'></label><span>" . $Submit_Author_Comment_Label  . "</span>";
		$ReturnString .= "</div>";
	}
	else {
		$ReturnString .= "<input type='hidden' name='Post_Author_Type' id='Post_Author_Type' value='AutoEntered' />";
		$ReturnString .= "<input type='hidden' name='Post_Author_Check' id='Post_Author_Check' value='" . sha1($Logged_In_User['Author_Name'].$Salt) . "' />";
		$ReturnString .= "<input type='hidden' name='Post_Author' id='Post_Author' value='" . $Logged_In_User['Author_Name'] . "' />" . $Logged_In_User['Author_Name'];
		if ($Logged_In_User['Login_Status'] == "Twitter" or $Logged_In_User['Login_Status'] == "Facebook") {
			$ReturnString .= "<div id='ewd-urp-author-explanation' class='ewd-urp-review-explanation'>";
			$ReturnString .= "<label for='explanation'></label><span>" . $Logged_In_User['ManageLogin']  . "</span>";
			$ReturnString .= "</div>";
		}
	}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Author_Email_Field() {
	$Submit_Reviewer_Email_Address_Label = get_option("EWD_URP_Submit_Reviewer_Email_Address_Label");
	if($Submit_Reviewer_Email_Address_Label == ''){$Submit_Reviewer_Email_Address_Label = __("Reviewer's Email Address", 'ultimate-reviews');}
	$Submit_Reviewer_Email_Address_Instructions_Label = get_option("EWD_URP_Submit_Reviewer_Email_Address_Instructions_Label");
	if($Submit_Reviewer_Email_Address_Instructions_Label == ''){$Submit_Reviewer_Email_Address_Instructions_Label = __("Please confirm your email to verify your identity. It will not be displayed.", 'ultimate-reviews');}

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-email-author' class='ewd-urp-review-label'>";
	$ReturnString .= $Submit_Reviewer_Email_Address_Label . ": </label>";
	$ReturnString .= "<input type='email' name='Post_Email' id='Post_Email' value='" . $_REQUEST['Post_Email'] . "' required/>";
	$ReturnString .= "<div id='ewd-urp-author-explanation' class='ewd-urp-review-explanation'>";
	$ReturnString .= "<label for='explanation'></label><span>" . $Submit_Reviewer_Email_Address_Instructions_Label  . "</span>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Review_Title_Field($Required) {
	if ($Required == "No") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$Submit_Title_Label = get_option("EWD_URP_Submit_Title_Label");
	if ($Submit_Title_Label == "") {$Submit_Title_Label = __("Review Title", 'ultimate-reviews');}
	$Submit_Title_Comment_Label = get_option("EWD_URP_Submit_Title_Comment_Label");
	if ($Submit_Title_Comment_Label == "") {$Submit_Title_Comment_Label = __("What title should be displayed with your review?", 'ultimate-reviews');}

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-review-title' class='ewd-urp-review-label'>";
	$ReturnString .= $Submit_Title_Label . ": </label>";
	$ReturnString .= "<input type='text' name='Post_Title' id='Post_Title' value='" . (isset($_POST['Post_Title']) ? $_POST['Post_Title'] : '') . "' " . $Required_Text . "/>";
	$ReturnString .= "<div id='ewd-urp-title-explanation' class='ewd-urp-review-explanation'>";
	$ReturnString .= "<label for='explanation'></label><span>" . $Submit_Title_Comment_Label  . "</span>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Review_Image_Field($Required) {
	if ($Required == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-review-title' class='ewd-urp-review-label'>";
	$ReturnString .= __('Review Image', 'ultimate-reviews') . ": </label>";
	$ReturnString .= "<input type='file' name='Post_Image' id='Post_Image' accept='.jpg,.png' " . $Required_Text . " />";
	$ReturnString .= "<div id='ewd-urp-image-explanation' class='ewd-urp-review-explanation'>";
	$ReturnString .= "<label for='explanation'></label><span>" . __('The image that should be associated with your review', 'ultimate-reviews') . "</span>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	return $ReturnString;
}


function EWD_URP_Add_Review_Video_Field($Required) {
	if ($Required == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-review-video' class='ewd-urp-review-label'>";
	$ReturnString .= __("Review Video", 'ultimate-reviews') . ": </label>";
	$ReturnString .= "<input type='URL' name='Review_Video' id='Review_Video' value='" . (isset($_POST['Review_Video']) ? $_POST['Review_Video'] : '') . "' " . $Required_Text . "/>";
	$ReturnString .= "<div id='ewd-urp-video-explanation' class='ewd-urp-review-explanation'>";
	$ReturnString .= "<label for='explanation'></label><span>" . __('A link to a video for this review from an external site (YouTube, Vimeo, etc.).', 'ultimate-reviews')  . "</span>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Review_Category_Field($Required) {
	if ($Required == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$Review_Categories = get_terms(array('taxonomy' => 'urp-review-category'));

	$ReturnString = "";

	$ReturnString .= "<div class='form-field'>";
	$ReturnString .= "<label id='ewd-urp-review-category' class='ewd-urp-review-label'>";
	$ReturnString .= __("Review Category", 'ultimate-reviews') . ": </label>";
	$ReturnString .= "<select name='Review_Category' id='Review_Category' " . $Required_Text . ">";
	$ReturnString .= "<option></option>";
	foreach ($Review_Categories as $Review_Category) {
		$ReturnString .= "<option value='" . $Review_Category->term_id . "' " . (isset($_POST['Review_Category']) and $_POST['Review_Category'] == $Review_Category->term_id ? 'selected' : '') . ">" . $Review_Category->name . "</option>";
	}
	$ReturnString .= "</select>";
	$ReturnString .= "<div id='ewd-urp-category-explanation' class='ewd-urp-category-explanation'>";
	$ReturnString .= "<label for='explanation'></label><span>" . __('The category that the review will be listed under.', 'ultimate-reviews')  . "</span>";
	$ReturnString .= "</div>";
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Review_Item_Field($Review_Category_Item) {
	global $Textarea_Counter;
	$Textarea_Counter++;

	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Score_Input = get_option("EWD_URP_Review_Score_Input");
	$Review_Style = get_option("EWD_URP_Review_Style");

	$Submit_Score_Label = get_option("EWD_URP_Submit_Score_Label");
	if ($Submit_Score_Label == "") {$Submit_Score_Label = __("Overall Score", 'ultimate-reviews');}
	$Submit_Cat_Score_Label = get_option("EWD_URP_Submit_Cat_Score_Label");
	if ($Submit_Cat_Score_Label == "") {$Submit_Cat_Score_Label = __("Score", 'ultimate-reviews');}

	if ($Review_Category_Item['CategoryName'] == "Overall Score") {$Score_Label = $Submit_Score_Label;}
	else {$Score_Label = $Review_Category_Item['CategoryName'] . " " . $Submit_Cat_Score_Label;}

	if ($Review_Category_Item['CategoryRequired'] == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='ewd-urp-meta-field'>";
	$ReturnString .= "<label for='Overall_Score' class='submitReviewLabels'>";
	$ReturnString .=  $Score_Label . ": ";
	$ReturnString .= "</label>";
	if ($Review_Score_Input == "Text") {$ReturnString .= "<input type='text' id='ewd-urp-" . $Review_Category_Item['CategoryName'] . "' name='" . $Review_Category_Item['CategoryName'] . "' value='" . $_POST[$Review_Category_Item['CategoryName']] . "' " . $Required_Text . " />";}
	elseif ($Review_Score_Input == "Stars") {
		$ReturnString .= "<div class='ewd-urp-stars-input'>";
		for ($i=1; $i<=$Maximum_Score; $i++) {$ReturnString .= "<div class='ewd-urp-star-input' id='ewd-urp-star-input-" . $Textarea_Counter . "-" . $i . "' data-reviewscore='" . $i . "' data-cssidadd='" . $Textarea_Counter . "' data-inputname='" . $Review_Category_Item['CategoryName'] . "'></div>";}
		$ReturnString .= "</div>";
		$ReturnString .= "<input type='text' id='ewd-urp-" . $Review_Category_Item['CategoryName'] . "' class='ewd-urp-hidden " . $Required_Text . "' name='" . $Review_Category_Item['CategoryName'] . "' value='" . (isset($_POST['Overall_Score']) ? $_POST['Overall_Score'] : '') . "' />";
	}
	else {
		$ReturnString .= "<select class='ewd-urp-dropdown-score-input' id='ewd-urp-" . $Review_Category_Item['CategoryName'] . "' name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . " />";
		for ($i=$Maximum_Score; $i>=1; $i--) {$ReturnString .= "<option value='" . $i . "'>" . $i . "</option>";}
		$ReturnString .= "</select>";
	}
	if ($Review_Style == "Percentage") {$ReturnString .= "%";}
	elseif ($Review_Score_Input != "Stars") {$ReturnString .= " " . __("out of", 'ultimate-reviews') . " " . $Maximum_Score;}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Review_Body_Field() {
	global $Textarea_Counter;

	$Review_Character_Limit = get_option("EWD_URP_Review_Character_Limit");

	$Submit_Review_Label = get_option("EWD_URP_Submit_Review_Label");
	if ($Submit_Review_Label == "") {$Submit_Review_Label = __("Review", 'ultimate-reviews');}

	$ReturnString = "";

	$ReturnString .= "<div class='ewd-urp-meta-field'>";
	$ReturnString .= "<label for='Post_Body'>";
	$ReturnString .= $Submit_Review_Label . ": ";
	$ReturnString .= "</label>";
	$ReturnString .= "<textarea name='Post_Body' class='ewd-urp-review-textarea' data-textareacount='" . $Textarea_Counter ."' required>" . (isset($_POST['Post_Body']) ? $_POST['Post_Body'] : '') . "</textarea>";
	if ($Review_Character_Limit != "") {$ReturnString .= "<div class='ewd-urp-review-character-count'  id='ewd-urp-review-character-count-" . $Textarea_Counter ."'><label></label>" . __('Characters remaining:', 'ultimate-reviews') . " " . $Review_Character_Limit . "</div>";}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Custom_Field($Review_Category_Item) {
	if ($Review_Category_Item['CategoryRequired'] == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='ewd-urp-meta-field'>";
	$ReturnString .= "<label for='" . $Review_Category_Item['CategoryName'] . "' class='submitReviewLabels'>";
	$ReturnString .= $Review_Category_Item['CategoryName'];
	$ReturnString .= "</label>";
	
	if ($Review_Category_Item['CategoryType'] == "text") {
		$ReturnString .= "<input type='text' name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . " class='ewd-urp-text-input'/>";
	}
	elseif ($Review_Category_Item['CategoryType'] == "textarea") {
		$ReturnString .= "<textarea name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . " class='ewd-urp-review-textarea'></textarea>";
	}
	elseif ($Review_Category_Item['CategoryType'] == "Dropdown") {
		$Options = explode(",", $Review_Category_Item['Options']);
		if (!empty($Options)) {
			$ReturnString .= "<select name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . ">";
			foreach ($Options as $Option) {$ReturnString .= "<option value='" . $Option . "'>" . $Option . "</option>";}
			$ReturnString .= "</select>";
		}
	}
	elseif ($Review_Category_Item['CategoryType'] == "Checkbox") {
		$Options = explode(",", $Review_Category_Item['Options']);
		if (!empty($Options)) {
			$ReturnString .= "<div class='ewd-urp-submit-review-radio-checkbox-container'>";
				$Values = explode(",", $Value);
				foreach ($Options as $Option) {
					$ReturnString .= "<div class='ewd-urp-submit-review-radio-checkbox-each'>";
						$ReturnString .= "<input type='checkbox' name='" . $Review_Category_Item['CategoryName'] . "[]' value='" . $Option . "' data-required='" . $Required_Text . "'/>" . $Option;
					$ReturnString .= "</div>"; //ewd-urp-submit-review-radio-checkbox-each
				}
			$ReturnString .= "</div>"; //ewd-urp-submit-review-radio-checkbox-container
		}
	}
	elseif ($Review_Category_Item['CategoryType'] == "Radio") {
		$Options = explode(",", $Review_Category_Item['Options']);
		if (!empty($Options)) {
			$ReturnString .= "<div class='ewd-urp-submit-review-radio-checkbox-container'>";
				foreach ($Options as $Option) {
					$ReturnString .= "<div class='ewd-urp-submit-review-radio-checkbox-each'>";
						$ReturnString .= "<input type='radio' name='" . $Review_Category_Item['CategoryName'] . "' value='" . $Option . "' " . $Required_Text . "/>" . $Option;
					$ReturnString .= "</div>"; //ewd-urp-submit-review-radio-checkbox-each
				}
			$ReturnString .= "</div>"; //ewd-urp-submit-review-radio-checkbox-container
		}
	}
	elseif ($Review_Category_Item['CategoryType'] == "Date") {$ReturnString .= "<input type='text' class='ewd-urp-jquery-datepicker' id='ewd-urp-" . $Review_Category_Item['CategoryName'] . "' name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . "/>";}
	elseif ($Review_Category_Item['CategoryType'] == "DateTime") {$ReturnString .= "<input type='datetime-local' id='ewd-urp-" . $Review_Category_Item['CategoryName'] . "' name='" . $Review_Category_Item['CategoryName'] . "' " . $Required_Text . "/>";}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Add_Explanation_Field($Review_Category_Item) {
	global $Textarea_Counter;

	$Review_Character_Limit = get_option("EWD_URP_Review_Character_Limit");

	$Submit_Explanation_Label = get_option("EWD_URP_Submit_Explanation_Label");
	if ($Submit_Explanation_Label == "") {$Submit_Explanation_Label = __("Explanation", 'ultimate-reviews');}

	if ($Review_Category_Item['CategoryRequired'] == "Yes") {$Required_Text = "required";}
	else {$Required_Text = "";}

	$ReturnString = "";

	$ReturnString .= "<div class='ewd-urp-meta-field'>";
	$ReturnString .= "<label for'" . $Review_Category_Item['CategoryName'] . " Description'>";
	$ReturnString .= $Review_Category_Item['CategoryName'] . " " . $Submit_Explanation_Label . ": ";
	$ReturnString .= "</label>";
	$ReturnString .= "<textarea name='" . $Review_Category_Item['CategoryName'] . " Description' class='ewd-urp-review-textarea'  data-textareacount='" . $Textarea_Counter ."' " . $Required_Text . ">" . $_POST[$Review_Category_Item['CategoryName'] . " Description"] . "</textarea>";
	if ($Review_Character_Limit != "") {$ReturnString .= "<div class='ewd-urp-review-character-count'  id='ewd-urp-review-character-count-" . $Textarea_Counter ."'><label></label>" . __('Characters remaining:', 'ultimate-reviews') . " " . $Review_Character_Limit . "</div>";}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_WooCommerce_Customer_Login() {
	global $wpdb;

	$WordPress_Login_URL = get_option("EWD_URP_WordPress_Login_URL");
	$WooCommerce_Minimum_Days = get_option("EWD_URP_WooCommerce_Minimum_Days");
	$WooCommerce_Maximum_Days = get_option("EWD_URP_WooCommerce_Maximum_Days");

	$ReturnArray = array();

	$Current_User = wp_get_current_user();

	if ($Current_User->ID == 0 and !isset($_POST['Customer_Email']) and !isset($_GET['wc_product_name'])) {
		$ReturnArray['DisplayForm'] = "No";

		$ReturnArray['Response_HTML'] = "<div class='ewd-urp-woocommerce ewd-urp-woocommerce-validation-form'>";
		$ReturnArray['Response_HTML'] .= "Either log in to your account, or enter the email address you used to purchase a product to leave a review.";
		$ReturnArray['Response_HTML'] .= "<div class='ewd-urp-login-option' id='ewd-urp-WordPress-login'>";
		$ReturnArray['Response_HTML'] .= "<a href='" . $WordPress_Login_URL . "'>" . __("WordPress Login", 'ultimate-reviews') . "</a>";
		$ReturnArray['Response_HTML'] .= "</div>";
		$ReturnArray['Response_HTML'] .= "<div class='ewd-urp-woocommerce-form-divider'></div>";
		$ReturnArray['Response_HTML'] .= "<div class='ewd-urp-woocommerce-email-form'>";
		$ReturnArray['Response_HTML'] .= "<form method='post' action='#'>";
		$ReturnArray['Response_HTML'] .= "<label>Email Address: </label>";
		$ReturnArray['Response_HTML'] .= "<input type='text' name='Customer_Email' />"; 
		$ReturnArray['Response_HTML'] .= "<input type='submit' name='Email_Submit' value='Find Purchases' />";
		$ReturnArray['Response_HTML'] .= "</form>";
		$ReturnArray['Response_HTML'] .= "</div>";
		$ReturnArray['Response_HTML'] .= "</div>";

		return $ReturnArray;
	}

	if ($Current_User->ID != 0) {
		$Orders = $wpdb->get_results($wpdb->prepare("SELECT post_id from $wpdb->postmeta WHERE meta_key=%s AND meta_value=%d", "_customer_user", $Current_User->ID));
	}
	elseif (isset($_POST['Customer_Email'])) {
		$Orders = $wpdb->get_results($wpdb->prepare("SELECT post_id from $wpdb->postmeta WHERE meta_key=%s AND meta_value=%s", "_billing_email", $_POST['Customer_Email']));
	}
	elseif (isset($_GET['wc_customer_email'])) {
		$Orders = $wpdb->get_results($wpdb->prepare("SELECT post_id from $wpdb->postmeta WHERE meta_key=%s AND meta_value=%s", "_billing_email", $_GET['wc_customer_email']));
	}
	else {
		$Orders = array();
	}

	$Products = array();
	foreach ($Orders as $Order) {
		$WC_Order = new WC_Order($Order->post_id);
		$Order_Time = strtotime($WC_Order->order_date);
		
		if ($Order_Time < (time() - $WooCommerce_Minimum_Days * 24 * 3600) and ($Order_Time + $WooCommerce_Maximum_Days * 24 * 3600) > time()) {
			$items = $WC_Order->get_items();
			$Products = $Products + $items;
		}
	}

	if (empty($Products)) {
		$ReturnArray['DisplayForm'] = "No";

		$ReturnArray['Response_HTML'] = "<div class='ewd-urp-woocommerce ewd-urp-woocommerce-no-products'>";
		$ReturnArray['Response_HTML'] .= "No purchases were found for your WooCommerce account or order email address between " . $WooCommerce_Minimum_Days . " and " . $WooCommerce_Maximum_Days . " days ago.";
		$ReturnArray['Response_HTML'] .= "</div>";
	}
	elseif (isset($_GET['wc_product_name'])) {
		foreach ($Products as $Product) {
			if ($Product['name'] == urldecode($_GET['wc_product_name'])) {
				$ReturnArray['DisplayForm'] = "Yes";
				$ReturnArray['SelectedProduct'] = $Product['name'];
				if ($Current_User->ID != 0) {
					$User_Meta = array_map("EWD_URP_WP_User_Array_Map", get_user_meta($Current_User->ID));
					$ReturnArray['Customer'] = trim($User_Meta['first_name'] . " " . $User_Meta['last_name']);
					$ReturnArray['WC_Email'] = $Current_User->user_email;
				}
				elseif (isset($_GET['wc_customer_email'])) {
					$post_id = $wpdb->get_results($wpdb->prepare("SELECT post_id from $wpdb->post_meta WHERE meta_key=%s AND meta_value=%s", "_billing_email", $_POST['Customer_Email']));
					$first_name = get_post_meta($post_id, "_billing_first_name", true);
					$last_name = get_post_meta($post_id, "_billing_last_name", true);
					$ReturnArray['Customer'] = trim($first_name . " " . $last_name);
					$ReturnArray['WC_Email'] = $_GET['wc_customer_email'];
				}
			}
		}
	}
	else {
		$ReturnArray['DisplayForm'] = "No";

		$ReturnArray['Response_HTML'] = "<div class='ewd-urp-woocommerce ewd-urp-woocommerce-no-products'>";
		foreach ($Products as $Product) {
			$ReturnArray['Response_HTML'] .= "<div class='ewd-urp-woocommerce-product-option'>";
			$ReturnArray['Response_HTML'] .= "<a href='" . add_query_arg(array('wc_product_name' => $Product['name'], 'wc_customer_email' => $_POST['Customer_Email'])) ."'>" . $Product['name'] . "</a>";
			$ReturnArray['Response_HTML'] .= "</div>";
		}
		$ReturnArray['Response_HTML'] .= "</div>";
	}

	return $ReturnArray;
}

function EWD_URP_Get_Login_Information() {
	$Login_Options = get_option("EWD_URP_Login_Options");

	$WordPress_Login_URL = get_option("EWD_URP_WordPress_Login_URL");
	$FEUP_Login_URL = get_option("EWD_URP_FEUP_Login_URL");

	$Permalink = get_the_permalink();
	if (strpos($Permalink, "?") !== false) {$PageLink = $Permalink . "&";}
	else {$PageLink = $Permalink . "?";}

	$facebook = EWD_URP_Facebook_Config();
	$fbuser = $facebook->getUser();
	$fbPermissions = 'public_profile';  //Required facebook permissions

	if (isset($_GET['Run_Login']) and $_GET['Run_Login'] == "Twitter" or isset($_GET['oauth_token'])) {EWD_URP_Twitter_Login($PageLink);}

	$Facebook_Output = "";
	if (!$fbuser and in_array("Facebook", $Login_Options)) {
		$fbuser = null;
		$LoginURL = $facebook->getLoginUrl(array('redirect_uri'=>$Permalink,'scope'=>$fbPermissions));
		$Facebook_Output = "<div class='ewd-urp-login-option' id='ewd-urp-facebook-login'>";
		$Facebook_Output .= "<a href='".$LoginURL."'><img src='" . EWD_URP_CD_PLUGIN_URL . "images/fb_login.png'></a>";
		$Facebook_Output .= "</div>";
	}
	else {
		$Facebook_Output = "<a href='" . $PageLink . "Logout=Facebook' >" . __("Logout", 'ultimate-reviews') . "</a>";
	}

	$Twitter_Output = "";
	if ((!isset($_COOKIE['EWD_URP_status']) && $_COOKIE['EWD_URP_status'] != 'verified') and in_array("Twitter", $Login_Options)) {
		$Twitter_Output = "<div class='ewd-urp-login-option' id='ewd-urp-Twitter-login'>";
		$Twitter_Output .= "<a href='" . $PageLink . "Run_Login=Twitter'><img src='" . EWD_URP_CD_PLUGIN_URL . "images/sign-in-with-twitter.png' width='151' height='24' border='0' /></a>";
		$Twitter_Output .= "</div>";
	}
	else {
		$Twitter_Output = "<a href='" . $PageLink . "Logout=Twitter' >" . __("Logout", 'ultimate-reviews') . "</a>";
	}

	if (array_key_exists('Logout',$_GET)) {
		if ($_GET['Logout'] == "Facebook") {
			$facebook->destroySession();
			$Facebook_Output = __("You have been successfully logged out via Facebook. ", 'ultimate-reviews');
			$Facebook_Output .= "<a href='" . $Permalink . "'>";
			$Facebook_Output .= __("Please reload the page", 'ultimate-reviews');
			$Facebook_Output .= "</a>";
			$Facebook_Output .= " " . __("if you'd like to log in again", 'ultimate-reviews');
		}
		if ($_GET['Logout'] == "Twitter") {
			EWD_URP_Erase_Twitter_Data();
			$Twitter_Output = __("You have been successfully logged out via Twitter. ", 'ultimate-reviews');
			$Twitter_Output .= "<a href='" . $Permalink . "'>";
			$Twitter_Output .= __("Please reload the page", 'ultimate-reviews');
			$Twitter_Output .= "</a>";
			$Twitter_Output .= " " . __("if you'd like to log in again", 'ultimate-reviews');
		}
	}

	if (class_exists("FEUP_User")) {
		$FEUP_User = new FEUP_User;
		$FEUP_Logged_In = $FEUP_User->Is_Logged_In();
	}
	else {
		$FEUP_Logged_In = false;
	}

	if ($fbuser and (!array_key_exists('Logout',$_GET) or $_GET['Logout'] != "Facebook")) {
		$Facebook_Logged_In = true;
	}

	if (isset($_COOKIE['EWD_URP_status']) and $_COOKIE['EWD_URP_status'] == 'verified'  and (!array_key_exists('Logout',$_GET) or $_GET['Logout'] != "Twitter")) {
		$Twitter_Logged_In = true;
	}

	if (in_array("WordPress", $Login_Options) and is_user_logged_in()) {
		$Logged_In_User['Login_Status'] = "WordPress";
		$User_Meta = array_map("EWD_URP_WP_User_Array_Map", get_user_meta(get_current_user_id()));
		$Logged_In_User['Author_Name'] = trim($User_Meta['first_name'] . " " . $User_Meta['last_name']);
	}
	elseif (in_array("FEUP", $Login_Options) and $FEUP_Logged_In) {
		$Logged_In_User['Login_Status'] = "FEUP";
		$Logged_In_User['Author_Name'] = "";
	}
	elseif (in_array("Twitter", $Login_Options) and $Twitter_Logged_In) {
		$Logged_In_User['Login_Status'] = "Twitter";
		$Logged_In_User['Author_Name'] = $_COOKIE['EWD_URP_Twitter_Full_Name'];
	}
	elseif (in_array("Facebook", $Login_Options) and $Facebook_Logged_In) {
		$Logged_In_User['Login_Status'] = "Facebook";
		$user_profile = $facebook->api('/me?fields=name');
		if (!empty($user_profile)) {
			$Logged_In_User['Author_Name'] = $user_profile['name'];
		}
	}
	else {
		$Logged_In_User['Login_Status'] = "None";
	}

	$Logged_In_User['ManageLogin'] = "";
	if (in_array("WordPress", $Login_Options) and $Logged_In_User['Login_Status'] == "None") {
		$Logged_In_User['ManageLogin'] .= "<div class='ewd-urp-login-option' id='ewd-urp-WordPress-login'>";
		$Logged_In_User['ManageLogin'] .= "<a href='" . $WordPress_Login_URL . "'>" . __("WordPress Login", 'ultimate-reviews') . "</a>";
		$Logged_In_User['ManageLogin'] .= "</div>";
	}
	if (in_array("FEUP", $Login_Options) and $Logged_In_User['Login_Status'] == "None") {
		$Logged_In_User['ManageLogin'] .= "<div class='ewd-urp-login-option' id='ewd-urp-FEUP-login'>";
		$Logged_In_User['ManageLogin'] .= "<a href='" . $FEUP_Login_URL . "'>" . __("Login", 'ultimate-reviews') . "</a>";
		$Logged_In_User['ManageLogin'] .= "</div>";
	}
	if (in_array("Facebook", $Login_Options) and ($Logged_In_User['Login_Status'] == "None" or $Logged_In_User['Login_Status'] == "Facebook")) {$Logged_In_User['ManageLogin'] .= $Facebook_Output;}
	if (in_array("Twitter", $Login_Options) and ($Logged_In_User['Login_Status'] == "None" or $Logged_In_User['Login_Status'] == "Twitter")) {$Logged_In_User['ManageLogin'] .= $Twitter_Output;}

	return $Logged_In_User;
}

function EWD_URP_WP_User_Array_Map($a) {
	return $a[0];
}

?>
