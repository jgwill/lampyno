<?php
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function EWD_URP_Display_Summary_Statistics($atts) {
	global $EWD_URP_Summary_Statistics_Array;
	$EWD_URP_Summary_Statistics_Array = array();

	$Custom_CSS = get_option("EWD_URP_Custom_CSS");
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");

	$Summary_Statistics = get_option("EWD_URP_Summary_Statistics");
	$Review_Weights = get_option("EWD_URP_Review_Weights");
	$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
	
	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
			'product_name' => "",
			'include_category' => "",
			'exclude_category' => "",
			'all_products' => "No",
			'summary_type' => ""),
			$atts
		)
	);

	$Review_Params = array();
	$Current_Product_Group = "";

	if ($Summary_Statistics == "None") {$Summary_Statistics = "Limited";}

	if ($summary_type != "") {$Summary_Statistics = $summary_type;}

	if (isset($_GET['Product_Reviews'])) {return do_shortcode("[ultimate-reviews product_name='" . $_GET['Product_Reviews'] . "']") ."<div class='ewd-urp-return'><a href='" . get_permalink() . "'>" . __("Back to Summary", 'ultimate-reviews') . "</a></div>";}

	$Reviews = json_decode(do_shortcode("[ultimate-reviews product_name='" . $product_name . "' include_category='" . $include_category . "' exclude_category='" . $exclude_category . "' reviews_objects='Yes' group_by_product='Yes']"));

	$HeaderString = EWD_URP_Add_Modified_Styles();
	$HeaderString .= "<div class='ewd-urp-review-list ewd-urp-review-summaries' id='ewd-urp-review-list'>";
	
	$Counter = 0;
	foreach ($Reviews as $Review) {
		if ($Email_Confirmation == "Yes") {
			$Email_Confirmed = get_post_meta($Review->ID, 'EWD_URP_Email_Confirmed', true);

			if ($Email_Confirmed != "Yes") {
				continue;
			}
		}

		if ($all_products != "Yes") {
			$Product_Name = get_post_meta($Review->ID, 'EWD_URP_Product_Name', true);
		}
		else {
			$Product_Name = "All Products";
		}
		$Product_Names[] = $Product_Name;

		$Weight = get_post_meta( $Review->ID, 'EWD_URP_Review_Weight', true );		
		$Overall_Score = get_post_meta($Review->ID, 'EWD_URP_Overall_Score', true);
	
		if (!isset($EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score])) {$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score] = 0;}
		if ($Review_Weights == "Yes") {
			if ($Review_Weight == "") {$Review_Weight = 0;}
			$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] += $Weight;
			$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score] += $Weight;
		}
		else {
			$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score]++;
		}

		if ($Current_Product_Group != $Product_Name) {
			$SummaryString = EWD_URP_Build_Summary_Statistics_String($Current_Product_Group, $Review_Params, $Summary_Statistics, "<a href='" . get_permalink() . "?Product_Reviews=" . $Current_Product_Group . "'>", "</a>");
			$ReviewsString = str_replace("%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $ReviewsString);
			$ReviewsString .= "%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%";
			$Current_Product_Group = $Product_Name;
		}

		$Counter++;

	}

	$SummaryString = EWD_URP_Build_Summary_Statistics_String($Current_Product_Group, $Review_Params, $Summary_Statistics, "<a href='#" . "?Product_Reviews=" . $Current_Product_Group . "'>", "</a>");
	$ReviewsString = str_replace("%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $ReviewsString);

	$FooterString = "<div class='ewd-urp-clear'></div>";

	$FooterString .= "</div>";

	if (($Summary_Statistics == "Full" or $Summary_Statistics == "Limited") and $product_name != "") {
		$SummaryString = EWD_URP_Build_Summary_Statistics_String($product_name, $Review_Params, $Summary_Statistics, "<a href='#" . "?Product_Reviews=" . $Current_Product_Group . "'>", "</a>");
		$HeaderString = str_replace("%SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $HeaderString);
	}

	$ReturnString = $HeaderString . $ReviewsString . $FooterString;

	return $ReturnString;
}
if ($URP_Full_Version == "Yes") {add_shortcode("reviews-summary", "EWD_URP_Display_Summary_Statistics");}
