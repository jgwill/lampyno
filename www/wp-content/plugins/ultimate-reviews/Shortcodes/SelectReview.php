<?php
/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function Display_Select_Review($atts) {
	global $EWD_URP_Summary_Statistics_Array;
	$EWD_URP_Summary_Statistics_Array = array();

	$Custom_CSS = get_option("EWD_URP_Custom_CSS");

	$ReturnString = "";
	$Review_Params = array();

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
									'review_name' => "",
									'review_slug' => "",
									'review_id' => ""),
									$atts
		)
	);

	if ($review_name != "") {$name_array = explode(",", $review_name);}
	else {$name_array = array();}
	if ($review_slug != "") {$slug_array = explode(",", $review_slug);}
	else {$slug_array = array();}
	if ($review_id != "") {$id_array = explode(",", $review_id);}
	else {$name_array = array();}

	foreach ($name_array as $post_name) {
		$single_post = get_page_by_title($post_name, "OBJECT", "urp_review");
		$post_id_array[] = $single_post->ID;
	}

	foreach ($slug_array as $post_slug) {
		$single_post = get_page_by_path($post_slug, "OBJECT", "urp_review");
		$post_id_array[] = $single_post->ID;
	}

	foreach ($id_array as $post_id) {
		$post_id_array[] = $post_id;
	}

	$params = array(
					'posts_per_page' => -1,
					'post_type' => 'urp_review',
					'include' => $post_id_array
				);
	$Reviews = get_posts($params);

	$ReturnString .= EWD_URP_Add_Modified_Styles();
	$ReturnString .= "<div class='ewd-urp-review-list' id='ewd-urp-review-list'>";

	if ($Custom_CSS != "") {$ReturnString .= "<style>" . $Custom_CSS . "</style>";}

	foreach ($Reviews as $Review) {
		$ReturnString .= EWD_URP_Display_Review($Review, $Review_Params);
	}

	$ReturnString .= "<div class='ewd-urp-clear'></div>";

	$ReturnString .= "</div>";

	return $ReturnString;
}
add_shortcode("select-review", "Display_Select_Review");

function EWD_URP_Display_Review($Review, $Review_Params = array()) {
	global $EWD_URP_Summary_Statistics_Array, $EWD_URP_Custom_Filters;

	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Style = get_option("EWD_URP_Review_Style");
	$Review_Image = get_option("EWD_URP_Review_Image");
	$Review_Video = get_option("EWD_URP_Review_Video");
	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
	$Link_To_Post = get_option("EWD_URP_Link_To_Post");
	$Display_Author = get_option("EWD_URP_Display_Author");
	$Display_Date = get_option("EWD_URP_Display_Date");
	$Display_Time = get_option("EWD_URP_Display_Time");
	$Display_Categories = get_option("EWD_URP_Display_Categories");
	$Author_Click_Filter = get_option("EWD_URP_Author_Click_Filter");
	$Flag_Inappropriate = get_option("EWD_URP_Flag_Inappropriate");
	$Review_Comments = get_option("EWD_URP_Review_Comments");

	$Review_Format = get_option("EWD_URP_Review_Format");
	$Review_Weights = get_option("EWD_URP_Review_Weights");
	$Review_Karma = get_option("EWD_URP_Review_Karma");
	$Thumbnail_Characters = get_option("EWD_URP_Thumbnail_Characters");
	$Display_Numerical_Score = get_option("EWD_URP_Display_Numerical_Score");
	$Reviews_Skin = get_option("EWD_URP_Reviews_Skin");
	$Read_More_AJAX = get_option("EWD_URP_Read_More_AJAX");

	$Display_WooCommerce_Verified = get_option("EWD_URP_Display_WooCommerce_Verified");

	$Group_By_Product = get_option("EWD_URP_Group_By_Product");

	$Posted_Label = get_option("EWD_URP_Posted_Label");
		if ($Posted_Label == "") {$Posted_Label = __("Posted ", 'ultimate-reviews');}
	$By_Label = get_option("EWD_URP_By_Label");
		if ($By_Label == "") {$By_Label = __("by ", 'ultimate-reviews');}
	$On_Label = get_option("EWD_URP_On_Label");
		if ($On_Label == "") {$On_Label = __("on ", 'ultimate-reviews');}
	$Score_Label = get_option("EWD_URP_Score_Label");
		if ($Score_Label == "") {$Score_Label = __("Score", 'ultimate-reviews');}
	$Explanation_Label = get_option("EWD_URP_Explanation_Label");
		if ($Explanation_Label == "") {$Explanation_Label = __("Explanation", 'ultimate-reviews');}

	$Unique_ID = EWD_URP_Rand_Chars(3);

	if (array_key_exists("review_format", $Review_Params)) {$Review_Format = $Review_Params['review_format'];}

	$Weight = get_post_meta( $Review->ID, 'EWD_URP_Review_Weight', true );
	$Karma = get_post_meta( $Review->ID, 'EWD_URP_Review_Karma', true );
	$Product_Name = get_post_meta($Review->ID, 'EWD_URP_Product_Name', true);
	$Overall_Score = get_post_meta($Review->ID, 'EWD_URP_Overall_Score', true);
	$Post_Author = get_post_meta($Review->ID, 'EWD_URP_Post_Author', true);
	$Permalink = get_the_permalink($Review->ID);

	if ($Karma == "") {$Karma = 0;}
	if(isset($_COOKIE['EWD_URP_Karma_IDs'])) {$EWD_URP_Karma_IDs = unserialize(stripslashes($_COOKIE['EWD_URP_Karma_IDs']));}
	else {$EWD_URP_Karma_IDs = array();}
	if (!is_array($EWD_URP_Karma_IDs)) {$EWD_URP_Karma_IDs = array();}
	if (in_array($Review->ID, $EWD_URP_Karma_IDs)) {$Karma_ID = "0";}
	else {$Karma_ID = $Review->ID;}

	$Review_Weight = "";
	if(!isset($EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'])) {
		$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] = 0;
	}
	if(!isset($EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score])) {
		$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score] = 0;
	}
	if ($Review_Weights == "Yes") {
		if ($Review_Weight == "") {$Review_Weight = 0;}
		$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] += $Weight;
		$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score] += $Weight;
	}
	else {
		$EWD_URP_Summary_Statistics_Array[$Product_Name][$Overall_Score]++;
	}

	if ($Review_Format == "Thumbnail" || $Review_Format == "Thumbnail_Masonry") {$Body_Class = 'ewd-urp-review-div ewd-urp-thumbnail-review';}
	elseif ($Review_Format == "Image" || $Review_Format == "Image_Masonry") {$Body_Class = 'ewd-urp-review-div ewd-urp-image-review';}
	else {$Body_Class = 'ewd-urp-review-div';}

	$ReturnString = '';
	$ReturnString .= "<div class='" . $Body_Class . "' itemprop='review' itemscope itemtype='http://schema.org/Review'>";
	$ReturnString .= "<meta itemprop='itemReviewed' content='" . $Product_Name . "'/>";

	$post_thumbnail_id = get_post_thumbnail_id($Review->ID);
	$featuredImageURL = wp_get_attachment_url( $post_thumbnail_id );
	if ($featuredImageURL == '') {$featuredImageURL = EWD_URP_CD_PLUGIN_URL . '/images/No-Photo-Available.png';}

	if($Review_Format == "Image" || $Review_Format == "Image_Masonry"){
		if($featuredImageURL != ''){
			$ReturnString .= '<img src="' . $featuredImageURL . '" class="imageReviewImage" />';
		}
	}

	$Review_For_Label = get_option("EWD_URP_Review_For_Label");
	if($Review_For_Label == ''){$Review_For_Label = __("Review for", 'ultimate-reviews');}

	if ($Group_By_Product == "No" and isset($Review_Params['product_name']) and $Review_Params['product_name'] == "") {
		$ReturnString .= "<div class='ewd-urp-review-product-name'>";
		$ReturnString .= $Review_For_Label . " " . $Product_Name;
		$ReturnString .= "</div>";
	}

	if ($Flag_Inappropriate == "Yes" && $Review_Format == "Image") {
		$ReturnString .= "<div class='ewd-urp-flag-inappropriate' title='Flag review as inappropriate' data-reviewid='" . $Review->ID . "'></div>";
	}

	if ($Review_Format == "Expandable") {$Header_Class = "ewd-urp-review-header ewd-urp-expandable-title";}
	else {$Header_Class = "ewd-urp-review-header";}

	$ReturnString .= "<div class='" . $Header_Class . "' data-postid='" . $Unique_ID . "-" . $Review->ID . "'>";
	$ReturnString .= "<div class='ewd-urp-review-score" . ($Review_Format == "Image" && $featuredImageURL == "" ? " imageStyleScoreBelow" : "") . "'>";

	$ReturnString .= EWD_URP_Get_Score_Graphic($Review, $Review_Params);

	if($Review_Format == 'Image' && $Reviews_Skin != 'Basic'){
	}
	else{
		if ($Display_Numerical_Score == "Yes" and $Reviews_Skin != "TextCircle") {
			if ($Review_Style == "Percentage") {$ReturnString .= "<div class='ewd-urp-review-score-number'>" . round($Overall_Score,1) . "%</div>";}
			else {$ReturnString .= "<div class='ewd-urp-review-score-number'>" . round($Overall_Score,1) . "/" . $Maximum_Score . "</div>";}
		}
	}

	$ReturnString .= "<div class='ewd-urp-microdata ewd-urp-hidden' itemprop='reviewRating' itemscope itemtype='http://schema.org/Rating'>";
	$ReturnString .= "<meta itemprop='worstRating' content='1'/>";
	$ReturnString .= "<meta itemprop='ratingValue' content='" . $Overall_Score . "'/>";
	$ReturnString .= "<meta itemprop='bestRating' content='" . $Maximum_Score . "'/>";
	$ReturnString .= "</div>";

	if ($Flag_Inappropriate == "Yes" && $Review_Format != "Image") {
		$ReturnString .= "<div class='ewd-urp-flag-inappropriate' title='Flag review as inappropriate' data-reviewid='" . $Review->ID . "'></div>";
	}

	$ReturnString .= "</div>";

	if ($Review_Karma == "Yes") {
		$ReturnString .= "<div class='ewd-urp-clear'></div>";
		$ReturnString .= "<div class='ewd-urp-review-karma'>";
		$ReturnString .= "<div class='ewd-urp-karma-control ewd-urp-karma-up' data-reviewid='" . $Karma_ID . "'></div>";
		$ReturnString .= "<div class='ewd-urp-karma-score' id='ewd-urp-karma-score-" . $Review->ID . "'>" . $Karma . "</div>";
		$ReturnString .= "<div class='ewd-urp-karma-control ewd-urp-karma-down' data-reviewid='" . $Karma_ID . "'></div>";
		$ReturnString .= "</div>";
	}

	if ($Link_To_Post == "Yes") {$ReturnString .= "<a href='" . $Permalink . "' class='ewd-urp-review-link'>";}
	$ReturnString .= "<div class='ewd-urp-review-title' id='ewd-urp-title-" . $Unique_ID . "-" . $Review->ID . "' data-postid='" . $Unique_ID . "-" . $Review->ID . "' itemprop='name'>" .($Display_WooCommerce_Verified == "Yes" ? "<span class='ewd-urp-verified'></span>" : "") . $Review->post_title . "</div>";
	if ($Link_To_Post == "Yes") {$ReturnString .= "</a>";}

	$ReturnString .= "</div>";

	$ReturnString .= "<div class='ewd-urp-clear'></div>";

	if ($Review_Format == "Expandable") {$Content_Class = "ewd-urp-review-content ewd-urp-content-hidden";}
	else {$Content_Class = "ewd-urp-review-content";}

	$ReturnString .= "<div class='" . $Content_Class . "' id='ewd-urp-review-content-" . $Unique_ID . "-" . $Review->ID . "' data-postid='" . $Unique_ID . "-" . $Review->ID . "'>";

	$Categories_Label_Label = get_option("EWD_URP_Categories_Label_Label");
	if($Categories_Label_Label == ''){$Categories_Label_Label = __("Categories", 'ultimate-reviews');}

	if ($Display_Author == "Yes"  or $Display_Date == "Yes" or $Display_Categories == "Yes") {
		$Review_Time = strtotime($Review->post_date);
		$Review_Date_Time = '';
		if ($Display_Date == "Yes") {$Review_Date_Time .= date(get_option('date_format'), $Review_Time);}
		if ($Display_Time == "Yes") {$Review_Date_Time .= " " . date(get_option('time_format'), $Review_Time);}
		$Post_Author = get_post_meta($Review->ID, 'EWD_URP_Post_Author', true);
		if ($Author_Click_Filter == "Yes" and isset($Review_Params['Page Permalink'])) {$Post_Author = "<a href='" . add_query_arg('review_author', $Post_Author, $Review_Params['Page Permalink']) . "'>" . $Post_Author . "</a>";}
		$ReturnString .= "<div class='ewd-urp-author-date'>";
		$ReturnString .= $Posted_Label . " " ;
		if ($Display_Author == "Yes" and $Post_Author != "") {$ReturnString .= $By_Label . " <span class='ewd-urp-author' itemprop='author'>" . $Post_Author . "</span> ";}
		if ($Display_Date == "Yes" or $Display_Time == "Yes") {$ReturnString .= $On_Label . " <span class='ewd-urp-date' itemprop='datePublished' content='" . $Review->post_date . "'>" . $Review_Date_Time . "</span> ";}
		if ($Display_Categories == "Yes") {$ReturnString .= "<div class='ewd-urp-categories'>" . $Categories_Label_Label . ": " . implode(", ", wp_get_post_terms($Review->ID, 'urp-review-category', array('fields' => 'names'))) . "</div> ";}
		$ReturnString .= "</div>";
	}

	$ReturnString .= "<div class='ewd-urp-clear'></div>";

	if ($Review_Image == "Yes" && $Review_Format != "Image") {
		if (has_post_thumbnail($Review->ID)) {
			$ReturnString .= "<div class='ewd-urp-review-image ewd-urp-image-" . $Review_Format ."'>";
			$ReturnString .= get_the_post_thumbnail($Review->ID);
			$ReturnString .= "</div>";
		}
	}

	if ($Review_Video == "Yes") {
		$Video_URL = get_post_meta( $Review->ID, 'EWD_URP_Review_Video', true );
		$embed_code = wp_oembed_get($Video_URL, array('width' => 400, 'height' => 300));
		if ($embed_code) {
			$ReturnString .= "<div class='ewd-urp-review-image ewd-urp-image-" . $Review_Format ."'>";
			$ReturnString .= $embed_code;
			$ReturnString .= "</div>";
		}
	}

	$ReturnString .= "<div class='ewd-urp-clear'></div>";

	if ($Review_Format == "Thumbnail") {$Content = substr($Review->post_content, 0, $Thumbnail_Characters);}
	else {$Content = $Review->post_content;}

	$ReturnString .= "<div class='ewd-urp-review-body' id='ewd-urp-body-" . $Unique_ID . "-" . $Review->ID . "'>";
	$ReturnString .= "<div class='ewd-urp-review-margin ewd-urp-review-post' id='ewd-urp-review-" . $Unique_ID . "-" . $Review->ID . "' itemprop='reviewBody'>" . apply_filters('the_content', html_entity_decode($Content)) . "</div>";
	if ($Review_Format == "Thumbnail") {$ReturnString .= "<div class='ewd-urp-thumbnail-read-more " . $Read_More_AJAX . "' data-postid='" . $Unique_ID . "-" . $Review->ID . "'><a href='" . $Permalink . "'>" . __('Read More', 'ultimate-reviews') . "</a></div>";}
	$ReturnString .= "</div>";

	$Review_Category_Item['Filterable'] = "";
	if ($InDepth_Reviews == "Yes" and isset($Review_Categories_Array[0]['CategoryName']) and $Review_Categories_Array[0]['CategoryName'] != "") {
		if ($Review_Category_Item['Filterable'] == "Yes") {$EWD_URP_Custom_Filters[$Review_Category_Item['CategoryName']] = array();}
		foreach ($Review_Categories_Array as $Review_Category_Item) {
			if ($Review_Category_Item['CategoryName'] != "" and $Review_Category_Item['CategoryType'] != "Default") {
				$Review_Category_Score = get_post_meta($Review->ID, "EWD_URP_" . $Review_Category_Item['CategoryName'], true);
				$Review_Category_Description = get_post_meta($Review->ID, "EWD_URP_" . $Review_Category_Item['CategoryName'] . "_Description", true);

				$ReturnString .= "<div class='ewd-urp-category-field'>";
				$ReturnString .= "<div class='ewd-urp-category-score'>";
				$ReturnString .= "<div class='ewd-urp-category-score-label'>";
				if ($Review_Category_Item['CategoryType'] == "ReviewItem" or $Review_Category_Item['CategoryType'] == "") {$ReturnString .= $Review_Category_Item['CategoryName'] . "<span> " . $Score_Label . "</span>: ";}
				else {$ReturnString .= $Review_Category_Item['CategoryName'];}
				$ReturnString .= "</div>";
				$ReturnString .= "<div class='ewd-urp-category-score-number'>";
				$ReturnString .= $Review_Category_Score;
				$ReturnString .= "</div>";
				$ReturnString .= "</div>";

				if ($Review_Category_Item['ExplanationAllowed'] == "Yes") {
					$ReturnString .= "<div class='ewd-urp-category-explanation'>";
					$ReturnString .= "<div class='ewd-urp-category-explanation-label'>";
					$ReturnString .= $Review_Category_Item['CategoryName'] . " " . $Explanation_Label . ": ";
					$ReturnString .= "</div>";
					$ReturnString .= "<div class='ewd-urp-category-explanation-text'>";
					$ReturnString .= $Review_Category_Description;
					$ReturnString .= "</div>";
					$ReturnString .= "</div>";
				}
				$ReturnString .= "</div>";

				if ((isset($Review_Category_Item['Filterable'])) and $Review_Category_Item['Filterable'] == "Yes") {$EWD_URP_Custom_Filters[$Review_Category_Item['CategoryName']][] = $Review_Category_Score;}
			}
			//$ReturnString .= "<div class='ewd-urp-clear'></div>";
		}
	}

	if (comments_open($Review->ID) and ($Review_Format == "Standard" or $Review_Format == "Expandable") and $Review_Comments == "Yes") {
		ob_start();
		$Comments = get_comments(array('post_id' => $Review->ID));
		wp_list_comments(array(), $Comments);
		comment_form(array(), $Review->ID);
		$ReturnString .= ob_get_contents();
		ob_end_clean();
	}

	$ReturnString .= "</div>";

	$ReturnString .= "<div class='ewd-urp-clear'></div>";

	$ReturnString .= "</div>";

	return $ReturnString;
}


function EWD_URP_Get_Score_Graphic($Review, $Review_Params = array()) {
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Reviews_Skin = get_option("EWD_URP_Reviews_Skin");

	$Overall_Score = get_post_meta($Review->ID, 'EWD_URP_Overall_Score', true);

	if (array_key_exists("review_skin", $Review_Params)) {
		if ($Reviews_Skin != "Basic" and $Reviews_Skin = $Review_Params['review_skin']) {
    		$ReturnString .= "<link rel='stylesheet' href='" . EWD_URP_CD_PLUGIN_URL . "css/addtl/" . $Reviews_Skin . ".css' type='text/css' media='all' />";
    	}
		$Reviews_Skin = $Review_Params['review_skin'];
	}

	$ReturnString = "";
	if ($Reviews_Skin == "SimpleStars" or $Reviews_Skin == "Thumbs" or $Reviews_Skin == "Hearts") {
		if ($Reviews_Skin == "SimpleStars") {
			$Filled_Class_Name = "dashicons dashicons-star-filled";
			$Half_Class_Name = "dashicons dashicons-star-half";
			$Empty_Class_Name = "dashicons dashicons-star-empty";
		}
		elseif ($Reviews_Skin == "Thumbs") {
			$Filled_Class_Name = "ewd-urp-thumb ewd-urp-full";
			$Half_Class_Name = "ewd-urp-thumb ewd-urp-half";
			$Empty_Class_Name = "ewd-urp-thumb ewd-urp-empty";
		}
		elseif ($Reviews_Skin == "Hearts") {
			$Filled_Class_Name = "ewd-urp-heart ewd-urp-full";
			$Half_Class_Name = "ewd-urp-heart ewd-urp-half";
			$Empty_Class_Name = "ewd-urp-heart ewd-urp-empty";
		}

		$ReturnString .= "<div id='ewd-urp-review-graphic-" . $Review->ID . "' class='ewd-urp-review-graphic'>";
		for ($i = 1; $i <= $Maximum_Score; $i++) {
			if ($i <= ($Overall_Score + .25)) {$ReturnString .= "<div class='" . $Filled_Class_Name . "'></div>";}
			elseif ($i <= ($Overall_Score + .75)) {$ReturnString .= "<div class='" . $Half_Class_Name . "'></div>";}
			else {$ReturnString .= "<div class='" . $Empty_Class_Name . "'></div>";}
		}
		$ReturnString .= "</div>";
	}
	elseif ($Reviews_Skin == "ColorBar" or $Reviews_Skin == "SimpleBar") {
		if ($Reviews_Skin == "SimpleBar") {$ColorBar_Class = "ewd-urp-blue-bar";}
		elseif ($Overall_Score < 1.67 and $Reviews_Skin == "ColorBar") {$ColorBar_Class = "ewd-urp-red-bar";}
		elseif ($Overall_Score < 3.34 and $Reviews_Skin == "ColorBar") {$ColorBar_Class = "ewd-urp-yellow-bar";}
		else {$ColorBar_Class = "ewd-urp-green-bar";}
		$ColorBar_Width = round(($Overall_Score * (100 / $Maximum_Score)) * 0.95,2);
		$ColorBar_Margin = round((100 - $Overall_Score * (100 / $Maximum_Score)) * 0.95, 2);
		$ReturnString .= "<div class='ewd-urp-review-graphic'>";
		$ReturnString .= "<div class='ewd-urp-color-bar " . $ColorBar_Class . "' style='width:" . $ColorBar_Width . "%;margin-right:" . $ColorBar_Margin . "%;'></div>";
		$ReturnString .= "</div>";
	}
	elseif ($Reviews_Skin == "Circle") {
		$ReturnString .= "<canvas width='50' height='50' id='ewd-urp-review-graphic-" . $Review->ID . "' class='ewd-urp-review-graphic ewd-urp-pie-graphic ewd-urp-small-pie' data-reviewscore='" . $Overall_Score . "'></canvas>";
	}
	elseif ($Reviews_Skin == "TextCircle") {
		$ReturnString .= "<canvas width='125' height='125' id='ewd-urp-review-graphic-" . $Review->ID . "' class='ewd-urp-review-graphic ewd-urp-pie-graphic ewd-urp-large-pie' data-reviewscore='" . $Overall_Score . "'></canvas>";
	}

	return $ReturnString;
}
