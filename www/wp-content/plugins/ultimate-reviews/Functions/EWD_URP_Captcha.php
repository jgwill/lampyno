<?php

function EWD_URP_Add_Captcha() {
	$Code = rand(1000,9999);
	$ModifiedCode = EWD_URP_Encrypt_Captcha_Code($Code);

	$Submit_Image_Number_Label = get_option("EWD_URP_Submit_Image_Number_Label");
	if($Submit_Image_Number_Label == ''){$Submit_Image_Number_Label = __("Image Number", 'ultimate-reviews');}

	$ReturnString = "";
	
	$ReturnString .= "<div class='ewd-urp-captcha-div'><label for='captcha_image'></label>";
	$ReturnString .= "<img src=" . EWD_URP_CD_PLUGIN_URL . "Functions/EWD_URP_Create_Captcha_Image.php?Code=" . $ModifiedCode . " />";
	$ReturnString .= "<input type='hidden' name='ewd_urp_modified_captcha' value='" . $ModifiedCode . "' />";
	$ReturnString .= "</div>";
	$ReturnString .= "<div class='ewd-urp-captcha-response'><label for='captcha_text'>" . $Submit_Image_Number_Label . ": </label>";
	$ReturnString .= "<input type='text' name='ewd_urp_captcha' value='' />";
	$ReturnString .= "</div>";

	return $ReturnString;
}

function EWD_URP_Validate_Captcha() {
	$ModifiedCode = $_POST['ewd_urp_modified_captcha'];
	$UserCode = $_POST['ewd_urp_captcha'];

	$Code = EWD_URP_Decrypt_Catpcha_Code($ModifiedCode);

	if ($Code == $UserCode) {$Validate_Captcha = "Yes";}
	else {$Validate_Captcha = "No";}

	return $Validate_Captcha;
}

function EWD_URP_Encrypt_Captcha_Code($Code) {
	$ModifiedCode = ($Code + 5) * 3;

	return $ModifiedCode;
}

function EWD_URP_Decrypt_Catpcha_Code($ModifiedCode) {
	$Code = ($ModifiedCode / 3) - 5;

	return $Code;
}
?>
