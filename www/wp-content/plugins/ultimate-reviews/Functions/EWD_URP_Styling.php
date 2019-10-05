<?php
function EWD_URP_Add_Modified_Styles() {
	$Reviews_Read_More_Style = get_option("EWD_URP_Read_More_Style");
	$Review_Format = get_option("EWD_URP_Review_Format");

	$StylesString = "<style>";
	$StylesString .=".ewd-urp-review-title { ";
		if (get_option("EWD_urp_Review_Title_Font") != "") {$StylesString .= "font-family:" .  get_option("EWD_urp_Review_Title_Font") . " !important;";}
		if (get_option("EWD_urp_Review_Title_Font_Size") != "") {$StylesString .= "font-size:" .  EWD_URP_Check_Font_Size(get_option("EWD_urp_Review_Title_Font_Size")) . " !important;";}
		if (get_option("EWD_urp_Review_Title_Font_Color") != "") {$StylesString .="color:" . get_option("EWD_urp_Review_Title_Font_Color") . " !important;";}
		if (get_option("EWD_urp_Review_Title_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_urp_Review_Title_Margin") . " !important;";}
		if (get_option("EWD_urp_Review_Title_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_urp_Review_Title_Padding") . " !important;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-review-body { ";
		if (get_option("EWD_urp_Review_Content_Font") != "") {$StylesString .= "font-family:" .  get_option("EWD_urp_Review_Content_Font") . " !important;";}
		if (get_option("EWD_urp_Review_Content_Font_Size") != "") {$StylesString .= "font-size:" .  EWD_URP_Check_Font_Size(get_option("EWD_urp_Review_Content_Font_Size")) . " !important;";}
		if (get_option("EWD_urp_Review_Content_Font_Color") != "") {$StylesString .="color:" . get_option("EWD_urp_Review_Content_Font_Color") . " !important;";}
		if (get_option("EWD_urp_Review_Content_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_urp_Review_Content_Margin") . " !important;";}
		if (get_option("EWD_urp_Review_Content_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_urp_Review_Content_Padding") . " !important;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-author-date { ";
		if (get_option("EWD_urp_Review_Postdate_Font") != "") {$StylesString .= "font-family:" .  get_option("EWD_urp_Review_Postdate_Font") . " !important;";}
		if (get_option("EWD_urp_Review_Postdate_Font_Size") != "") {$StylesString .= "font-size:" .  EWD_URP_Check_Font_Size(get_option("EWD_urp_Review_Postdate_Font_Size")) . " !important;";}
		if (get_option("EWD_urp_Review_Postdate_Font_Color") != "") {$StylesString .="color:" . get_option("EWD_urp_Review_Postdate_Font_Color") . " !important;";}
		if (get_option("EWD_urp_Review_Postdate_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_urp_Review_Postdate_Margin") . " !important;";}
		if (get_option("EWD_urp_Review_Postdate_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_urp_Review_Postdate_Padding") . " !important;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-review-score { ";
		if (get_option("EWD_urp_Review_Score_Font") != "") {$StylesString .= "font-family:" .  get_option("EWD_urp_Review_Score_Font") . " !important;";}
		if (get_option("EWD_urp_Review_Score_Font_Size") != "") {$StylesString .= "font-size:" .  EWD_URP_Check_Font_Size(get_option("EWD_urp_Review_Score_Font_Size")) . " !important;";}
		if (get_option("EWD_urp_Review_Score_Font_Color") != "") {$StylesString .="color:" . get_option("EWD_urp_Review_Score_Font_Color") . " !important;";}
		if (get_option("EWD_urp_Review_Score_Margin") != "") {$StylesString .= "margin:" . get_option("EWD_urp_Review_Score_Margin") . " !important;";}
		if (get_option("EWD_urp_Review_Score_Padding") != "") {$StylesString .= "padding:" . get_option("EWD_urp_Review_Score_Padding") . " !important;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-standard-summary-graphic-full-sub-group { ";
		if (get_option("EWD_urp_Summary_Stats_Color") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Summary_Stats_Color") . " !important;";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-blue-bar { ";
		if (get_option("EWD_urp_Simple_Bar_Color") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Simple_Bar_Color") . " !important;";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-green-bar { ";
		if (get_option("EWD_urp_Color_Bar_High") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Color_Bar_High") . " !important;";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-yellow-bar { ";
		if (get_option("EWD_urp_Color_Bar_Medium") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Color_Bar_Medium") . " !important;";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-red-bar { ";
		if (get_option("EWD_urp_Color_Bar_Low") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Color_Bar_Low") . " !important;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-summary-statistics-header { ";
		if (get_option("EWD_URP_Review_Group_Separating_Line") == "Yes") {$StylesString .= "border-top: 1px solid #ccc; padding-top: 18px;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-category-field { ";
		if (get_option("EWD_URP_InDepth_Layout") == "Alternating") {$StylesString .= "margin-bottom: 0; padding: 4px 8px;";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-category-field:nth-of-type(2n+1) { ";
		if (get_option("EWD_URP_InDepth_Layout") == "Alternating") {$StylesString .= "background: #f4f4f4;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-review-div { ";
		if (get_option("EWD_urp_Review_Background_Color") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Review_Background_Color") . "; padding:10px;";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-review-header { ";
		if (get_option("EWD_urp_Review_Header_Background_Color") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Review_Header_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-review-content { ";
		if (get_option("EWD_urp_Review_Content_Background_Color") != "") {$StylesString .= "background-color:" .  get_option("EWD_urp_Review_Content_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".ewd-urp-image-review .ewd-urp-review-score, .ewd-urp-image-review .ewd-urp-review-link { ";
		if (get_option("EWD_urp_Image_Style_Background_Color") != "") {$StylesString .= "background:" .  get_option("EWD_urp_Image_Style_Background_Color") . ";";}
	$StylesString .="}\n";
	//read more button
	if($Reviews_Read_More_Style == "Button") {
		$StylesString .=".ewd-urp-thumbnail-read-more { ";
				$StylesString .= "border: none; text-decoration: none; margin-top: 0px;";
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-thumbnail-read-more a { ";
				$StylesString .= "padding: 4px 7px; text-decoration: none; border: 1px solid #111; color: #111; box-shadow: none !important; border-radius: 2px;";
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-thumbnail-read-more a { ";
			if (get_option("EWD_urp_Read_More_Button_Background_Color") != "") {$StylesString .= "background:" .  get_option("EWD_urp_Read_More_Button_Background_Color") . ";";}
			if (get_option("EWD_urp_Read_More_Button_Text_Color") != "") {$StylesString .= "color:" .  get_option("EWD_urp_Read_More_Button_Text_Color") . ";";}
			if (get_option("EWD_urp_Read_More_Button_Hover_Background_Color") != "") {$StylesString .= "border-color:" .  get_option("EWD_urp_Read_More_Button_Hover_Background_Color") . ";";}
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-thumbnail-read-more a:hover { ";
				$StylesString .= "text-decoration: none; background: #111; color: #fff;";
		$StylesString .="}\n";
		$StylesString .=".ewd-urp-thumbnail-read-more a:hover { ";
			if (get_option("EWD_urp_Read_More_Button_Hover_Background_Color") != "") {$StylesString .= "background:" .  get_option("EWD_urp_Read_More_Button_Hover_Background_Color") . ";";}
			if (get_option("EWD_urp_Read_More_Button_Hover_Text_Color") != "") {$StylesString .= "color:" .  get_option("EWD_urp_Read_More_Button_Hover_Text_Color") . ";";}
		$StylesString .="}\n";
}
	//inappropriate flags
	$PluginsURL = plugins_url();
	$StylesString .=".ewd-urp-flag-inappropriate { ";
		$StylesString .= "background-color: transparent; background-image: url(" . $PluginsURL . "/ultimate-reviews/images/exclamation_mark_green.png); background-size: 18px 18px; background-repeat: no-repeat;";
	$StylesString .="}\n";
	$StylesString .=".ewd-urp-flag-inappropriate:hover { ";
		$StylesString .= "background-color: transparent; background-image: url(" . $PluginsURL . "/ultimate-reviews/images/exclamation_mark_red.png); background-size: 18px 18px; background-repeat: no-repeat;";
	$StylesString .="}\n";
	$StylesString .=".ewd-urp-flag-inappropriate.ewd-urp-content-flagged { ";
		$StylesString .= "background-color: transparent; background-image: url(" . $PluginsURL . "/ultimate-reviews/images/exclamation_mark_red.png); background-size: 18px 18px; background-repeat: no-repeat;";
	$StylesString .="}\n";
	if($Review_Format == "Image"){
		$StylesString .=".ewd-urp-review-product-name { ";
			$StylesString .= "width: 90%;";
		$StylesString .="}\n";
	}

	$StylesString .= "</style>";

	return $StylesString;
}


function EWD_URP_Check_Font_Size($Font_Size) {
	if (is_numeric($Font_Size)) {$Font_Size .= 'px';}

	return $Font_Size;
}