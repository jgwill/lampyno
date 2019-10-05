<?php
add_action('init', 'EWD_URP_WooCommerce_Review_Reminders', 12);
function EWD_URP_WooCommerce_Review_Reminders() {
	//if (get_option("EWD_URP_WooCommerce_Reminder_Cache_Time") > time() - (60*30)) {
		$Reminders_Array = get_option("EWD_URP_Reminders_Array");
		if (!is_array($Reminders_Array)) {$Reminders_Array = array();}
		$Statuses = get_post_stati();

		foreach ($Reminders_Array as $Reminder_Item) {
			$Reminder_Time_Lag = EWD_URP_Get_Reminder_Time_Lag($Reminder_Item);
			$Before_Modified_Date = date("Y-m-d H:i:s", time() - $Reminder_Time_Lag -(7*24*3600));
			$Before_Posted_Date = date("Y-m-d H:i:s", time()-$Reminder_Time_Lag);
			$args = array(
				'post_type' => 'shop_order',
				'post_status' => $Statuses,
				'date_query' => array(
					array(
						'column' => 'post_date',
						'before' => $Before_Posted_Date,
					),
					array(
						'column' => 'post_modified',
						'after' => $Before_Modified_Date,
					),
				),
			);

			$Orders_Query = new WP_Query($args);
			$Orders = $Orders_Query->get_posts();

			foreach ($Orders as $Order) {
				$Reminders_Sent = get_post_meta($Order->ID, "EWD_URP_Reminders_Sent", true);
				if (!is_array($Reminders_Sent)) {$Reminders_Sent = array();}
				$Order_Statuses = get_post_meta($Order->ID, "EWD_URP_WC_Order_Statuses", true);
				if (!is_array($Order_Statuses)) {$Order_Statuses = array();}

				if (!in_array($Reminder_Item['ID'], $Reminders_Sent)) {
					$Status_Time = time()+100;
					foreach ($Order_Statuses as $Order_Status) {
						if ($Order_Status['Status'] == $Reminder_Item['Status_Trigger']) {$Status_Time = $Order_Status['Updated'];}
					}
					if (($Status_Time + $Reminder_Time_Lag) < time()) {
						EWD_URP_Send_Review_Reminder_Email($Order, $Reminder_Item);
						$Reminders_Sent[] = $Reminder_Item['ID'];
						update_post_meta($Order->ID, "EWD_URP_Reminders_Sent", $Reminders_Sent);
					}
				}
			}
		}
	//}
}

//add_action('init', 'EWD_URP_WooCommerce_Review_Reminders_Test');
function EWD_URP_WooCommerce_Review_Reminders_Test() {
	$Reminders_Array = get_option("EWD_URP_Reminders_Array");
	if (!is_array($Reminders_Array)) {$Reminders_Array = array();}
	if ($_GET['URP_Testing'] != "Send") {return;}

	foreach ($Reminders_Array as $Reminder_Item) {
		if ($Reminder_Item['ID'] == 2) {
			$Order = get_post(10483);
			EWD_URP_Send_Review_Reminder_Email($Order, $Reminder_Item);
		}
	}
}

function EWD_URP_Send_Review_Reminder_Email($Order, $Reminder_Item) {
	$Email_Messages_Array = get_option("EWD_URP_Email_Messages_Array");
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}
	$Review_Code = get_post_meta($Order->ID, "EWD_URP_Review_Code", true);

	$Email_Address = get_post_meta($Order->ID, "_billing_email", true);

	if ($Reminder_Item['Email_To_Send'] < 0) {
		$User_ID = get_post_meta($Order->ID, "_customer_user", true);

		$Params = array(
			'Email_ID' => $Reminder_Item['Email_To_Send'] * -1,
			'post_id' => $Order->ID
		);

		if ($User_ID != 0 and $User_ID != '') {
			$Params['User_ID'] = $User_ID;
			EWD_UWPM_Email_User($Params);
		}
		else {
			$Params['Email_Address'] = $Email_Address;
			EWD_URP_Send_Email_To_Non_User($Params);
		}
	}
	else {
		foreach ($Email_Messages_Array as $Email_Message_Item) {
			if ($Email_Message_Item['ID'] == $Reminder_Item['Email_To_Send']) {
				$Template_Message = EWD_URP_Return_Email_Template($Email_Message_Item, $Order);
				$Message_Body = str_replace(array("[purchase-date]", "[review-code]"), array($Order->post_date, $Review_Code), $Template_Message);
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$Mail_Success = wp_mail($Email_Address, $Email_Message_Item['Name'], $Message_Body, $headers);
			}
		}
	}
}

function TEST_UWPM_Integration(){
	$Reminder_Item = array('Email_To_Send' => -11155);
	$Order = (object) array('ID' => 11146);

	update_post_meta(11146, 'EWD_URP_Review_Code', 'Test_Code');

	EWD_URP_Send_Review_Reminder_Email($Order, $Reminder_Item);
}
//add_action('admin_head', 'TEST_UWPM_Integration');

add_action('woocommerce_checkout_order_processed', 'EWD_URP_Reminders_Set_Post_Meta');
function EWD_URP_Reminders_Set_Post_Meta($post_id) {
	$Review_Code = EWD_URP_Create_Review_Code();
	update_post_meta($post_id, "EWD_URP_Review_Code", $Review_Code);
	update_post_meta($post_id, "EWD_URP_Reminders_Sent", array());
	$Order_Statuses = array(array('Status' => get_post_status($post_id), 'Updated' => time()));
	update_post_meta($post_id, "EWD_URP_WC_Order_Statuses", $Order_Statuses);
}

add_action('woocommerce_order_status_changed', 'EWD_URP_Reminders_Status_Update');
function EWD_URP_Reminders_Status_Update($post_id, $old_status = "", $new_status = "") {
	$Order_Statuses = get_post_meta($post_id, "EWD_URP_WC_Order_Statuses", true);
	if (!is_array($Order_Statuses)) {$Order_Statuses = array();}
	$Status = get_post_status($post_id);
	$Order_Statuses[] = array('Status' => $Status, 'Updated' => time());
	update_post_meta($post_id, "EWD_URP_WC_Order_Statuses", $Order_Statuses);
}

function EWD_URP_Create_Review_Code($Length = 6) {
	$Letters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$Review_Code = '';
	for ($i = 0; $i < $Length; $i++) {
		$Review_Code .= $Letters[rand(0, strlen($Letters) - 1)];
	}

	return $Review_Code;
}

function EWD_URP_Get_Reminder_Time_Lag($Reminder) {
	if ($Reminder['Reminder_Unit'] == "Hours") {$Multiplier = 3600;}
	elseif ($Reminder['Reminder_Unit'] == "Days") {$Multiplier = 3600*24;}
	else {$Multiplier = 3600*24*7;}

	$Reminder_Time_Lag = $Multiplier * $Reminder['Reminder_Interval'];

	return $Reminder_Time_Lag;
}

function EWD_URP_Return_Email_Template($Email_Message_Item, $Order) {
  $Message_Title = $Email_Message_Item['Name'];
  $Message_Content = EWD_URP_Replace_Email_Content(stripslashes($Email_Message_Item['Message']), $Order);

	$urp_Email_Reminder_Background_Color = get_option("EWD_urp_Email_Reminder_Background_Color");
	$urp_Email_Reminder_Inner_Color = get_option("EWD_urp_Email_Reminder_Inner_Color");
	$urp_Email_Reminder_Text_Color = get_option("EWD_urp_Email_Reminder_Text_Color");
	$urp_Email_Reminder_Button_Background_Color = get_option("EWD_urp_Email_Reminder_Button_Background_Color");
	$urp_Email_Reminder_Button_Text_Color = get_option("EWD_urp_Email_Reminder_Button_Text_Color");
	$urp_Email_Reminder_Button_Background_Hover_Color = get_option("EWD_urp_Email_Reminder_Button_Background_Hover_Color");
	$urp_Email_Reminder_Button_Text_Hover_Color = get_option("EWD_urp_Email_Reminder_Button_Text_Hover_Color");

  $Message =   <<< EOT
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
  <head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>$Message_Title</title>


  <style type="text/css">

	.body-wrap {
		background-color: {$urp_Email_Reminder_Background_Color} !important;
	}
	.btn-primary {
		background-color: {$urp_Email_Reminder_Button_Background_Color} !important;
		border-color: $urp_Email_Reminder_Button_Background_Color !important;
		color: {$urp_Email_Reminder_Button_Text_Color} !important;
	}
	.btn-primary:hover {
		background-color: {$urp_Email_Reminder_Button_Background_Hover_Color} !important;
		border-color: $urp_Email_Reminder_Button_Background_Hover_Color !important;
		color: {$urp_Email_Reminder_Button_Text_Hover_Color} !important;
	}
	.main {
		background: $urp_Email_Reminder_Inner_Color !important;
		color: $urp_Email_Reminder_Text_Color;
	}

  img {
  max-width: 100%;
  }
  body {
  -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
  }
  body {
  background-color: #f6f6f6;
  }
  @media only screen and (max-width: 640px) {
    body {
      padding: 0 !important;
    }
    h1 {
      font-weight: 800 !important; margin: 20px 0 5px !important;
    }
    h2 {
      font-weight: 800 !important; margin: 20px 0 5px !important;
    }
    h3 {
      font-weight: 800 !important; margin: 20px 0 5px !important;
    }
    h4 {
      font-weight: 800 !important; margin: 20px 0 5px !important;
    }
    h1 {
      font-size: 22px !important;
    }
    h2 {
      font-size: 18px !important;
    }
    h3 {
      font-size: 16px !important;
    }
    .container {
      padding: 0 !important; width: 100% !important;
    }
    .content {
      padding: 0 !important;
    }
    .content-wrap {
      padding: 10px !important;
    }
    .invoice {
      width: 100% !important;
    }
  }
  </style>
  </head>

  <body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

  <table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
  		<td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
  			<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
  				<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
  					<meta itemprop="name" content="Please Review" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
              $Message_Content
        </div>
  		</td>
  		<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
  	</tr></table></body>
  </html>

EOT;

  return $Message;
}

function EWD_URP_Replace_Email_Content($Message_Start, $Order) {
  if (strpos($Message_Start, '[footer]') === false) {$Message_Start .= '</table></td></tr></table>';}

  $Replace = array('[section]', '[/section]', '[footer]', '[/footer]', '[/button]');
  $ReplaceWith = array(
    '<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">',
    '</td></tr>',
    '</table></td></tr></table><div class="footer" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;"><table width="100%" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">',
    '</td></tr></table></div>',
    '</a></td></tr>'
  );
  $Message = str_replace($Replace, $ReplaceWith, $Message_Start);
  $Message = EWD_URP_Replace_Email_Links($Message);
  $Message = EWD_URP_Add_Product_Review_Links($Message, $Order);

  return $Message;
}


function EWD_URP_Replace_Email_Links($Message) {
	$Pattern = "/\[button link=\'(.*?)\'\]/";

	preg_match_all($Pattern, $Message, $Matches);

	$Replace = '<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top"><a href="INSERTED_LINK" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">';
	$Result = preg_replace($Pattern, $Replace, $Message);

	if (is_array($Matches[1])) {
		foreach ($Matches[1] as $Link) {
			$Pos = strpos($Result, "INSERTED_LINK");
			if ($Pos !== false) {
			    $NewString = substr_replace($Result, $Link, $Pos, 13);
			    $Result = $NewString;
			}
		}
	}

	return $Result;
}

function EWD_URP_Add_UWPM_Element_Sections() {
	if (function_exists('uwpm_register_custom_element_section')) {
		uwpm_register_custom_element_section('ewd_urp_uwpm_elements', array('label' => 'Review Tags'));
	}
}
add_action('uwpm_register_custom_element_section', 'EWD_URP_Add_UWPM_Element_Sections');

function EWD_URP_Add_UWPM_Elements() {
	if (function_exists('uwpm_register_custom_element')) {
		uwpm_register_custom_element('ewd_urp_product_review_links', 
			array(
				'label' => 'Product Review Links',
				'callback_function' => 'EWD_URP_UWPM_Product_Review_Links',
				'section' => 'ewd_urp_uwpm_elements',
				'attributes' => array(
					array(
						'attribute_name' => 'ewd_urp_submit_review_url',
						'attribute_label' => 'Submit Review URL',
						'attribute_type' => 'TextBox'
					)
				)
			)
		);
		/*uwpm_register_custom_element('ewd_urp_review_code', 
			array(
				'label' => 'Review Code',
				'callback_function' => 'EWD_URP_UWPM_Product_Review_Code',
				'section' => 'ewd_urp_uwpm_elements'
			)
		);*/
	}
}
add_action('uwpm_register_custom_element', 'EWD_URP_Add_UWPM_Elements');

function EWD_URP_UWPM_Product_Review_Links($Params, $User) {
	if (!isset($Params['post_id'])) {return;}

	$order = new WC_Order($Params['post_id']);
	$items = $order->get_items();

	if (is_array($Params['attributes'])) {
		foreach ($Params['attributes'] as $Attribute_Name => $Attribute_Value) {
			if ($Attribute_Name != 'ewd_urp_submit_review_url') {continue;}

			$Link = $Attribute_Value;
			if (strpos($Link, '?') === false) {$Link .= '?src=urp_email';}
			else {$Link .= '&src=urp_email';}
			$Link .= '&order_id=' . $Order_Post->ID;
			if (isset($Params['Email_Address'])) {$Link .= '&Post_Email=' . $Params['Email_Address'];}
			$Product_Links = '<table>';
			foreach ($items as $product) {
				$Product_Link = $Link . '&product_name=' . $product['name'];
				$Product_Links .= '<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top"><a href="' . $Product_Link . '" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">' . $product['name'] . '</a></td></tr>';
			}
			$Product_Links .= '</table>';
		}
	}

	return $Product_Links;
}

function EWD_URP_UWPM_Product_Review_Code($Params, $User) {
	if (!isset($Params['post_id'])) {return;}

	$Review_Code = get_post_meta($Params['post_id'], "EWD_URP_Review_Code", true);

	return $Review_Code;
}

function EWD_URP_Add_Product_Review_Links($Message, $Order_Post) {
	$Pattern = "/\[review-items link=\'(.*?)\'\]/";

	preg_match($Pattern, $Message, $Matches);

	$order = new WC_Order($Order_Post->ID);
	$items = $order->get_items();

	$Email_Address = get_post_meta($Order_Post->ID, "_billing_email", true);

	$Replace = '';
	if (isset($Matches[1])) {
		$Link = $Matches[1];
		if (strpos($Link, '?') === false) {$Link .= '?src=urp_email';}
		else {$Link .= '&src=urp_email';}
		$Link .= '&order_id=' . $Order_Post->ID;
		$Link .= '&Post_Email=' . $Email_Address;
		foreach ($items as $product) {
			$Product_Link = $Link . '&product_name=' . $product['name'];
			$Replace .= '<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top"><a href="' . $Product_Link . '" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">' . $product['name'] . '</a></td></tr>';
		}
	}

	$Result = preg_replace($Pattern, $Replace, $Message);

	return $Result;
}
?>
