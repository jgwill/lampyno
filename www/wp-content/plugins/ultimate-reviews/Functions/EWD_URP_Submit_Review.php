<?php
function EWD_URP_Submit_Review($success_message) {
	global $wpdb;

	if (!isset($_POST['Review_Video'])){	$_POST['Review_Video'] = '';}
	if (!isset($_POST['Current_URL'])){	$_POST['Current_URL'] = '';}
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Image = get_option("EWD_URP_Review_Image");
	$Review_Video = get_option("EWD_URP_Review_Video");
	$Review_Category = get_option("EWD_URP_Review_Category");
	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
	$Email_On_Submission = get_option("EWD_URP_Email_On_Submission");
	$Admin_Notification = get_option("EWD_URP_Admin_Notification");
	$Admin_Approval = get_option("EWD_URP_Admin_Approval");
	$Use_Captcha = get_option("EWD_URP_Use_Captcha");
	$Require_Email = get_option("EWD_URP_Require_Email");
	$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
	$One_Review_Per_Product_Person = get_option("EWD_URP_One_Review_Per_Product_Person");
	$Review_Blacklist = get_option("EWD_URP_Review_Blacklist");

	if ($Review_Blacklist != '') {$Blacklist_Array = preg_split('/\r\n|[\r\n]/', $Review_Blacklist);}
	else {$Blacklist_Array = array();}

	$Replace_WooCommerce_Reviews = get_option("EWD_URP_Replace_WooCommerce_Reviews");
	$Match_WooCommerce_Categories = get_option("EWD_URP_Match_WooCommerce_Categories");

	$Salt = get_option("EWD_URP_Hash_Salt");

	$Post_Title = sanitize_text_field($_POST['Post_Title']);
	$Product_Name = sanitize_text_field($_POST['Product_Name']);
	$Post_Author = sanitize_text_field($_POST['Post_Author']);
	$Post_Body = sanitize_text_field($_POST['Post_Body']);
	if(isset($_POST['Post_Email'])){$Post_Email = sanitize_text_field($_POST['Post_Email']);}
	else {$Post_Email = '';}
	if (isset($_POST['order_id'])) {$Order_ID = sanitize_text_field($_POST['order_id']);}
	else {$Order_ID = 0;}
	$Review_Video = esc_url($_POST['Review_Video']);
	$Review_Category_Value = (isset($_POST['Review_Category']) ? $_POST['Review_Category'] : 0);
	$Current_URL = $_POST['Current_URL'];

	if (isset($_POST['Item_Reviewed'])) {
		$Item_Reviewed = $_POST['Item_Reviewed'];
		$Item_ID = $_POST['Item_ID'];
	}
	else {
		$Item_Reviewed = "urp_product";
		$Item_ID = 0;
	}

	if ($_POST['Post_Author_Type'] == "AutoEntered") {
		if (sha1($Post_Author.$Salt) == $_POST['Post_Author_Check']) {
			$AuthorCheck = true;
		}
		else {
			$AuthorCheck = false;
		}
	}
	else {
		$AuthorCheck = true;
	}

	if ($Use_Captcha == "Yes") {$Validate_Captcha = EWD_URP_Validate_Captcha();}
	else {$Validate_Captcha = "Yes";}

	if ($Validate_Captcha != "Yes") {$user_message = __("The number entered in the captcha field was not correct.", 'ultimate-reviews'); return $user_message;}

	if (!empty($Blacklist_Array)) {
		$Blacklisted_Fields = array();
		foreach ($_POST as $key => $Submitted_Field) {
			if (in_array($Submitted_Field, $Blacklist_Array)) {
				$Blacklisted_Fields[] = EWD_URP_Get_Field_Name($key);
			}
		}

		if (in_array($_SERVER['REMOTE_ADDR'], $Blacklist_Array)) {
			$Blacklisted_Fields = "IP Address";
		}

		if (!empty($Blacklisted_Fields)) {
			if (!is_array($Blacklisted_Fields)) {$user_message = __("Your IP address has been blocked from submitting reviews by the site administrator.", 'ultimate-reviews');}
			else {
				$user_message = __("You have an invalid submission in one or more of your fields:", 'ultimate-reviews');
				$user_message .= "<br>";
				$user_message .= implode("<br>", $Blacklisted_Fields);
			}

			return $user_message;
		}
	}

	if ($One_Review_Per_Product_Person == "Yes") {
		$Reviewed_Products = (isset($_COOKIE['EWD_URP_Reviewed_Products']) ? unserialize(stripslashes($_COOKIE['EWD_URP_Reviewed_Products'])) : array());
		
		if (in_array($Product_Name, $Reviewed_Products)) {
			$user_message = __("You have already submitted a review for a product with that product name. Please select a different product to review.", 'ultimate-reviews');
			return $user_message;
		}

		$Reviewed_Products[] = $Product_Name;

		setcookie('EWD_URP_Reviewed_Products', serialize($Reviewed_Products), time() + 365*24*3600, '/');
	}

	$post = array(
		'post_content' => $Post_Body,
		'post_title' => $Post_Title,
		'post_type' => 'urp_review',
		'post_status' => 'publish'
	);
	if ($Admin_Approval == "Yes") {$post['post_status'] = 'draft';}
	$post_id = wp_insert_post($post);
	if ($post_id == 0 or !$AuthorCheck) {$user_message = __("Review was not created succesfully.", 'ultimate-reviews'); return $user_message;}

	if ($Review_Image == "Yes") {
		$File = EWD_URP_Upload_Review_Image();
		if ($File and !isset($File['error'])) {$Attachment_ID = EWD_URP_Create_Thumbnail_Image($File, $Post_Title);}
		if (isset($Attachment_ID) and $Attachment_ID != 0) {set_post_thumbnail($post_id, $Attachment_ID);}
	}

	if ($Review_Category == "Yes" and $Review_Category_Value != 0) {
		wp_set_post_terms($post_id, $Review_Category_Value, 'urp-review-category');
	}

	unset($_POST['Post_Title']);
	unset($_POST['Product_Name']);
	unset($_POST['Post_Author']);
	unset($_POST['Post_Body']);
	unset($_POST['Post_Email']);
	unset($_POST['Current_URL']);
	unset($_POST['Review_Video']);
	unset($_POST['Review_Category']);
	unset($_POST['order_id']);

	update_post_meta($post_id, "EWD_URP_Product_Name", $Product_Name);
	update_post_meta($post_id, "EWD_URP_Post_Author", $Post_Author);
	update_post_meta($post_id, "EWD_URP_Post_Email", $Post_Email);
	update_post_meta($post_id, "EWD_URP_Email_Confirmed", "No");
	update_post_meta($post_id, "EWD_URP_Item_Reviewed", $Item_Reviewed);
	update_post_meta($post_id, "EWD_URP_Item_ID", $Item_ID);
	update_post_meta($post_id, "EWD_URP_Review_Video", $Review_Video);
	update_post_meta($post_id, "EWD_URP_Order_ID", $Order_ID);
	if (isset($_POST['WC_Email'])) {update_post_meta($post_id, "EWD_URP_WC_Email", sanitize_text_field($_POST['WC_Email']));}

	if ($Match_WooCommerce_Categories == "Yes") {
		$WC_Product = get_page_by_title($Product_Name, "OBJECT", "product");
		if ($WC_Product) {
			$Product_WC_Categories = wp_get_post_terms($WC_Product->ID, 'product_cat');
			foreach ($Product_WC_Categories as $Product_WC_Cat) {
				$URP_Cat = get_terms(array('taxonomy' => 'urp-review-category', 'meta_key' => 'product_cat', 'meta_value' => $Product_WC_Cat->term_id, 'hide_empty' => false));
				foreach ($URP_Cat as $Cat) {wp_set_post_terms($post_id, $Cat->term_id, 'urp-review-category', true);}
			}
		}
	}

	if ($InDepth_Reviews == "No" or $Review_Categories_Array[0]['CategoryName'] == "") {
		$Overall_Score = min(round(sanitize_text_field($_POST['Overall_Score']), 2), $Maximum_Score);
		update_post_meta($post_id, "EWD_URP_Overall_Score", $Overall_Score);
		unset($_POST['Overall_Score']);
	}
	else {
		$ReviewItems = 0;
		$Overall_Score = '';
		foreach ($Review_Categories_Array as $Review_Category_Item) {

			if ($Review_Category_Item['CategoryName'] != "") {
				$CategoryName = str_replace(" ", "_", $Review_Category_Item['CategoryName']);
				if (($Review_Category_Item['CategoryType'] == "ReviewItem" or $Review_Category_Item['CategoryType'] == "")) {
					$Value = min($_POST[$CategoryName], $Maximum_Score);
					$Overall_Score += $Value;
					$ReviewItems++;
				}
				elseif ($Review_Category_Item['CategoryType'] == "Checkbox"){
					$Value = "";
					if (is_array($_POST[$CategoryName])) {foreach ($_POST[$CategoryName] as $Value_Option) {$Value .= $Value_Option . ",";}}
					$Value = sanitize_text_field(trim($Value, ","));
				}
				else {
					if (isset($_POST[$CategoryName])) {$Value = sanitize_text_field($_POST[$CategoryName]);}
				}
				if (isset($Value)){update_post_meta($post_id, "EWD_URP_" . $Review_Category_Item['CategoryName'], $Value);}
				unset($_POST[$CategoryName]);

				if ($Review_Category_Item['ExplanationAllowed'] == "Yes") {
					$Section_Description = sanitize_text_field($_POST[$CategoryName . "_Description"]);
					update_post_meta($post_id, "EWD_URP_" . $Review_Category_Item['CategoryName'] . "_Description", $Section_Description);
					unset($_POST[$CategoryName . "_Description"]);
				}
			}
		}

		if ($ReviewItems > 0) {$Overall_Score = min(round($Overall_Score / $ReviewItems, 2), $Maximum_Score);}
		else {$Overall_Score = 0;}
		update_post_meta($post_id, "EWD_URP_Overall_Score", $Overall_Score);
	}

	$Post_ID_Objects = $wpdb->get_results("
        SELECT $wpdb->posts.ID
        FROM $wpdb->posts
        INNER JOIN $wpdb->postmeta on $wpdb->posts.ID=$wpdb->postmeta.post_id
        WHERE $wpdb->postmeta.meta_key='EWD_URP_Product_Name'
        AND $wpdb->postmeta.meta_value='" . $Product_Name . "'
        AND $wpdb->posts.post_type = 'urp_review'
        ");

    foreach ($Post_ID_Objects as $Post_ID_Object) {$Post_IDs .= $Post_ID_Object->ID . ",";}
    if ($Post_IDs != "") {$Post_IDs = substr($Post_IDs, 0, -1);}

    if ($Post_IDs != "") {
    	$Average_Rating = $wpdb->get_var("
    		SELECT AVG(meta_value)
    		FROM $wpdb->postmeta
    		WHERE meta_key = 'EWD_URP_Overall_Score'
    		AND post_id IN (" . $Post_IDs . ")
    		");
    }
    else {
    	$Average_Rating = "";
    }

    if ($WC_Product) {update_post_meta($WC_Product->ID, "EWD_URP_Average_Score", $Average_Rating);}

	if ($Email_Confirmation == "Yes") {
		EWD_URP_Send_Confirmation_Email($post_id, $Post_Title, $Post_Email, $Current_URL);
	}

	if ($Admin_Notification == "Yes") {
		EWD_URP_Send_Admin_Notification_Email($post_id, $Post_Title, $Post_Body);
	}

	if ($Replace_WooCommerce_Reviews == "Yes") {
		EWD_URP_Create_WooCommerce_Review($post_id);
	}
	if ($Email_On_Submission != "") {
		EWD_URP_Send_Submission_Email($post_id, $Email_On_Submission);
	}

	do_action('ewd_urp_review_published_end', $post_id);

	return $success_message;
}

function EWD_URP_Send_Confirmation_Email($post_id, $Post_Title, $Post_Email, $Current_URL) {

	$Confirmation_Code = EWD_URP_RandomString();
	if (strpos($Current_URL, "?") !== false) {
		$ConfirmationLink = $Current_URL . "&ConfirmEmail=true&Post_ID=" . $post_id . "&Confirmation_Code=" . $Confirmation_Code;
	}
	else {
		$ConfirmationLink = $Current_URL . "?ConfirmEmail=true&Post_ID=" . $post_id . "&Confirmation_Code=" . $Confirmation_Code;
	}
	update_post_meta($post_id, "EWD_URP_Confirmation_Code", $Confirmation_Code);

	$Subject_Line = __("Email Confirmation for Product Review", 'ultimate-reviews');

	$Message_Body = __("Hello,", 'ultimate-reviews') . "<br/><br/>";
	$Message_Body .= __("Please confirm your email address for the product review you submitted titled ", 'ultimate-reviews') . $Post_Title . " ";
	$Message_Body .= __("by going to the following link:", 'ultimate-reviews') . "<br/><br/>";
	$Message_Body .= "<a href='" . $ConfirmationLink . "'>" . __("Confirm your email address", 'ultimate-reviews') . "</a><br/><br/>";
	$Message_Body .= __("Thank you for the review, and have a great day,", 'ultimate-reviews') . "<br/><br/>";
	$Message_Body .= get_bloginfo("name");

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$Mail_Success = wp_mail($Post_Email, $Subject_Line, $Message_Body, $headers);
}

function EWD_URP_Confirm_Email() {
	$Post_ID = $_GET['Post_ID'];
	$Entered_Confirmation_Code = $_GET['Confirmation_Code'];

	$Actual_Confirmation_Code = get_post_meta($Post_ID, 'EWD_URP_Confirmation_Code', true);

	if ($Actual_Confirmation_Code == $Entered_Confirmation_Code) {
		update_post_meta($Post_ID, "EWD_URP_Email_Confirmed", "Yes");
	}

	$user_update = __('Thank you for confirming your email address!', 'ultimate-reviews');

	return $user_update;
}

function EWD_URP_Send_Submission_Email($post_id, $Email_ID) {
	$Params = array(
		'Email_ID' => -1 * $Email_ID,
		'Email_Address' => get_post_meta($post_id, 'EWD_URP_Post_Email', true),
		'review_id' => $post_id
	);
	
	EWD_URP_Send_Email_To_Non_User($Params);
}

function EWD_URP_Send_Admin_Notification_Email($post_id, $Post_Title, $Post_Body) {
	$Admin_Email_Address = get_option("EWD_URP_Admin_Email_Address");
	$Admin_Email = ($Admin_Email_Address != '' ? $Admin_Email_Address : get_option( 'admin_email' ));

	$ReviewLink = site_url() . "/wp-admin/post.php?post=" . $post_id . "&action=edit";

	$Subject_Line = __("New Review Received", 'ultimate-reviews');

	$Message_Body = __("Hello Admin,", 'ultimate-reviews') . "<br/><br/>";
	$Message_Body .= __("You've received a new review for the product", 'ultimate-reviews') . " " . $Post_Title . ".<br/><br/>";
	$Message_Body .= __("The review reads:<br>", 'ultimate-reviews');
	$Message_Body .= $Post_Body . "<br><br><br>";
	$Message_Body .= __("You can view the entire review by going to the following link:<br>", 'ultimate-reviews');
	$Message_Body .= "<a href='" . $ReviewLink . "'>" . __("See the review", 'ultimate-reviews') . "</a><br/><br/>";
	$Message_Body .= __("Have a great day,", 'ultimate-reviews') . "<br/><br/>";
	$Message_Body .= __("Ultimate Reviews Team");

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$Mail_Success = wp_mail($Admin_Email, $Subject_Line, $Message_Body, $headers);
}

function EWD_URP_RandomString($CharLength = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $CharLength; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

/* Prepare the data to add multiple products from a spreadsheet */
function EWD_URP_Upload_Review_Image() {
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['Post_Image'];

	if(!preg_match("/\.(jpg.?)$/", strtolower($_FILES['Post_Image']['name'])) and !preg_match("/\.(png.?)$/", strtolower($_FILES['Post_Image']['name']))) {
        $error['error'] = __('File must be .jpg or .png', 'ultimate-reviews');
        return $error;
    }

	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	return $movefile;
}

function EWD_URP_Create_Thumbnail_Image($movefile, $Post_Title) {
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $movefile['file'] ), null );

	// Get the path to the upload directory.
	$wp_upload_dir = wp_upload_dir();

	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $wp_upload_dir['url'] . '/' . basename( $movefile['file'] ),
		'post_mime_type' => $filetype['type'],
		//'post_title'     => $Post_Title . " Image",
		'post_title' => basename($movefile['file']),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);


	// Insert the attachment.
	$parent_post_id = '';
	$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $parent_post_id );

	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}

function EWD_URP_Create_WooCommerce_Review($post_id) {
	$Product_Name = get_post_meta($post_id, "EWD_URP_Product_Name", true);
	$Rating = get_post_meta($post_id, "EWD_URP_Overall_Score", true);
	$Author = get_post_meta($post_id, "EWD_URP_Post_Author", true);
	$Author_Email = get_post_meta($post_id, "EWD_URP_Post_Email", true);

	$Title = get_the_title($post_id);
	$Post = get_post($post_id);
	$Comment = $Post->post_content;

	$time = current_time('mysql');

	$user_id = get_current_user_id();

	$WC_Product = get_page_by_title($Product_Name, "OBJECT", "product");
	if (is_object($WC_Product)) {$WC_Product_ID = $WC_Product->ID;}
	else {$WC_Product_ID = 0;}

	$commentdata = array(
	    'comment_post_ID' => $WC_Product_ID,
	    'comment_author' => $Author,
	    'comment_author_email' => $Author_Email,
	    'comment_content' => "<h2>" . $Title . "</h2>" . $Comment,
	    'comment_date' => $time,
	    'comment_approved' => 1,
	    'user_id' => $user_id
	);

	$comment_id = wp_new_comment( $commentdata, true );
	if (!is_wp_error($comment_id)) {
		add_comment_meta( $comment_id, 'rating', $Rating, true );

		$request['product_id'] = $WC_Product_ID;
		$product_review = get_comment( $comment_id );
		do_action( "woocommerce_rest_insert_product_review", $product_review, $request, true );
	}
}

function EWD_URP_Get_Field_Name($Post_Field) {
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");

	switch ($Post_Field) {
		case 'Post_Title':
			$Field_Name = __('Post Title', 'ultimate-reviews');
			break;
		case 'Product_Name':
			$Field_Name = __('Product Name', 'ultimate-reviews');
			break;
		case 'Post_Author':
			$Field_Name = __('Author', 'ultimate-reviews');
			break;
		case 'Post_Body':
			$Field_Name = __('Review', 'ultimate-reviews');
			break;
		case 'Post_Email':
			$Field_Name = __('Review Author Email', 'ultimate-reviews');
			break;
		case 'Review_Video':
			$Field_Name = __('Review Video URL', 'ultimate-reviews');
			break;
		case 'Review_Category':
			$Field_Name = __('Review Category', 'ultimate-reviews');
			break;
		
		default:
			foreach ($Review_Categories_Array as $Review_Category_Item) {
				$CategoryName = str_replace(" ", "_", $Review_Category_Item['CategoryName']);
				if ($Post_Field == $CategoryName) {$Field_Name = $Review_Category_Item['CategoryName'];} 
				if ($Post_Field == $CategoryName . '_Description') {$Field_Name = $Review_Category_Item['CategoryName'] . " Explanation";}
			}
			break;
	}

	return $Field_Name;
}
?>
