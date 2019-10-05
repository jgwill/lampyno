<?php
function URP_Display_Reviews_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-urp-blocks-js', plugins_url( '../blocks/ewd-urp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-urp-blocks-css', plugins_url( '../blocks/ewd-urp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-urp-blocks.css' ) );
		register_block_type( 'ultimate-reviews/ewd-urp-display-reviews-block', array(
			'attributes'      => array(
				'post_count' => array(
					'type' => 'string',
				),
				'include_category' => array(
					'type' => 'string',
				),
				'exclude_category' => array(
					'type' => 'string',
				),
				'product_name' => array(
					'type' => 'string',
				),
				'include_ids' => array(
					'type' => 'string',
				),
				'exclude_ids' => array(
					'type' => 'string',
				),
			),
			'editor_script'   => 'ewd-urp-blocks-js',
			'editor_style'  => 'ewd-urp-blocks-css',
			'render_callback' => 'EWD_URP_Display_Reviews',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("ultimate-reviews", "EWD_URP_Display_Reviews");
}
add_action( 'init', 'URP_Display_Reviews_Block' );

function EWD_URP_Display_Reviews($atts) {
	global $URP_Full_Version;
	global $EWD_URP_Summary_Statistics_Array, $EWD_URP_Custom_Filters;
	$EWD_URP_Summary_Statistics_Array = array();

	$Custom_CSS = get_option("EWD_URP_Custom_CSS");
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Filtering = get_option("EWD_URP_Review_Filtering");
	$Reviews_Per_Page = get_option("EWD_URP_Reviews_Per_Page");
	$Pagination_Location = get_option("EWD_URP_Pagination_Location");

	$Summary_Statistics = get_option("EWD_URP_Summary_Statistics");
	$Infinite_Scroll = get_option("EWD_URP_Infinite_Scroll");
	$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
	$Display_Microdata = get_option("EWD_URP_Display_Microdata");

	$Group_By_Product = get_option("EWD_URP_Group_By_Product");
	$Group_By_Product_Order = get_option("EWD_URP_Group_By_Product_Order");
	$Ordering_Type = get_option("EWD_URP_Ordering_Type");
	$Order_Direction = get_option("EWD_URP_Order_Direction");

	$Reviews_Pagination_Label= get_option("EWD_URP_Pagination_Label");
		if ($Reviews_Pagination_Label == "") {$Reviews_Pagination_Label = __(" reviews ", 'ultimate-reviews');}

	if ($Infinite_Scroll == "Yes") {$Infinite_Scroll_Class = "urp-infinite-scroll";}
	else {$Infinite_Scroll_Class = "";}

	$Pagination_Background = "";
	$Pagination_Border = "";
	$Pagination_Shadow = "";
	$Pagination_Gradient = "";

	$Order_By_Setting = 'date';
	$Order_Setting = "DESC";

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
			'shortcode_id' => "",
			'search_string' => "",
			'include_category' => "",
			'exclude_category' => "",
			'include_category_ids' => "",
			'exclude_category_ids' => "",
			'include_ids' => "",
			'exclude_ids' => "",
			'product_name' => "",
			'review_author' => "",
			'custom_filters' => "",
			'reviews_per_page' => 0,
			'only_reviews' => "No",
			'reviews_objects' => "No",
			'min_score' => 0,
			'max_score' => 1000000,
			'review_skin' => "",
			'review_format' => "",
			'review_filtering' => "",
			'orderby' => "",
			'order' => "",
			'group_by_product' => "",
			'current_page' => 1,
            'post_count'=>-1),
			$atts
		)
	);

	$product_name = htmlspecialchars_decode($product_name, ENT_QUOTES);
	$review_author = htmlspecialchars_decode($review_author, ENT_QUOTES);

	if (isset($_GET['current_page'])) {$current_page = $_GET['current_page'];}

	if (isset($_GET['review_score'])) {$min_score = $_GET['review_score']; $max_score = $_GET['review_score'];}

	if (isset($_GET['review_min_score'])) {$min_score = $_GET['review_min_score'];}

	if (isset($_GET['review_max_score'])) {$max_score = $_GET['review_max_score'];}

	if (isset($_GET['review_author'])) {$review_author = $_GET['review_author'];}

	if ($order == "") {$order = $Order_Direction;}

	if ($orderby == "") {$orderby = $Ordering_Type;}

	if ($group_by_product == "") {$group_by_product = $Group_By_Product;}

	if ($review_filtering != "") {$Review_Filtering = json_decode($review_filtering);}

	if ($reviews_per_page != 0) {$Reviews_Per_Page = $reviews_per_page;}

	if ($custom_filters != "") {$custom_filters = json_decode($custom_filters);}
	else {$custom_filters = array();}

	if ($include_ids != "") {$Post_Include_ID_Array = explode(",", $include_ids);}

	if ($exclude_ids != "") {$Post_Exclude_ID_Array = explode(",", $exclude_ids);}

	$orderby_selection = array();

	if ($group_by_product == "Yes" and $product_name == "") {$orderby_selection['meta_value'] = $Group_By_Product_Order;}

	if ($orderby == "Rating" or $orderby == "Karma") {$orderby_selection["meta_value_num"] = $order;}
	elseif ($orderby == "Date") {$orderby_selection['date'] = $order;}
	elseif ($orderby == "Title") {$orderby_selection['title'] = $order;}
	else {$orderby_selection[$orderby]= $order;}

	if ($shortcode_id != "") {$Shortcode_ID = $shortcode_id;}
	else {$Shortcode_ID = EWD_URP_RandomString(6);}

	$EWD_URP_Summary_Statistics_Array['Shortcode_ID'] = $Shortcode_ID;
	$EWD_URP_Summary_Statistics_Array['min_score'] = $min_score;
	$EWD_URP_Summary_Statistics_Array['max_score'] = $max_score;

	$HeaderString = '';
	$HeaderString .= EWD_URP_Add_Modified_Styles();
	$HeaderString .= "<div class='ewd-urp-review-list " . $Infinite_Scroll_Class . "' id='ewd-urp-review-list'>";

	$HeaderString .= "<input type='hidden' name='search_string' value='" . $search_string . "' id='urp-search-string' data-shortcodeid='" . $Shortcode_ID . "' />";
	$HeaderString .= "<input type='hidden' name='product_name' value='" . htmlspecialchars($product_name, ENT_QUOTES) . "' id='urp-product-name' data-shortcodeid='" . $Shortcode_ID . "' />";
	$HeaderString .= "<input type='hidden' name='review_author' value='" . htmlspecialchars($review_author, ENT_QUOTES) . "' id='urp-review-author' data-shortcodeid='" . $Shortcode_ID . "' />";
	$HeaderString .= "<input type='hidden' name='custom_filters' value='" . json_encode($custom_filters) . "' id='urp-custom-filters' data-shortcodeid='" . $Shortcode_ID . "' />";
	$HeaderString .= "<input type='hidden' name='min_score' value='" . $min_score . "' id='urp-min-score' data-shortcodeid='" . $Shortcode_ID . "' />";
	$HeaderString .= "<input type='hidden' name='max_score' value='" . $max_score . "' id='urp-max-score' data-shortcodeid='" . $Shortcode_ID . "' />";
    $HeaderString .= "<input type='hidden' name='orderby' value='" . $orderby . "' id='urp-orderby' data-shortcodeid='" . $Shortcode_ID . "' />";
    $HeaderString .= "<input type='hidden' name='order' value='" . $order . "' id='urp-order' data-shortcodeid='" . $Shortcode_ID . "' />";
    $HeaderString .= "<input type='hidden' name='post_count' value='" . $post_count . "' id='urp-post-count' data-shortcodeid='" . $Shortcode_ID . "' />";

    if (isset($_GET['include_category'])) {$include_category = $_GET['include_category'];}
	if (get_query_var('urp_review_category_slug') != "") {$include_category = get_query_var('urp_review_category_slug');}
	if ($include_category_ids != "" ) {$include_category_ids_array = explode(",", $include_category_ids);}
	if ($include_category_ids != "") {
		foreach ($include_category_ids_array as $Category_ID) {
			$Term = get_term_by('id', $Category_ID, 'urp-review-category');
			$include_category .= $Term->slug . ",";
		}
		$include_category = substr($include_category, 0, -1);
	}
	if ($include_category != "" ) {$include_category_array = explode(",", $include_category);}
	else {$include_category_array = array();}
	if (sizeOf($include_category_array) > 0) {
		$include_category_filter_array = array( 'taxonomy' => 'urp-review-category',
								'field' => 'slug',
								'terms' => $include_category_array
		);
	}
	if ($exclude_category_ids != "" ) {$exclude_category_ids_array = explode(",", $exclude_category_ids);}
	if ($exclude_category_ids != "") {
		foreach ($exclude_category_ids_array as $Category_ID) {
			$Term = get_term_by('id', $Category_ID, 'urp-review-category');
			$exclude_category .= $Term->slug . ",";
		}
		$exclude_category = substr($exclude_category, 0, -1);
	}
	if ($exclude_category != "" ) {$exclude_category_array = explode(",", $exclude_category);}
	else {$exclude_category_array = array();}
	if (sizeOf($exclude_category_array) > 0) {
		$exclude_category_filter_array = array( 'taxonomy' => 'urp-review-category',
								'field' => 'slug',
								'terms' => $exclude_category_array,
								'operator' => 'NOT IN'
		);
	}
	$tax_query_array = array('relation' => 'AND');
	if (isset($include_category_filter_array)) {$tax_query_array[] = $include_category_filter_array;}
	if (isset($exclude_category_filter_array)) {$tax_query_array[] = $exclude_category_filter_array;}

	if ($product_name != "") {
		$meta_query_array = array(
								array(
									'key' => 'EWD_URP_Product_Name',
									'value' => $product_name,
									'compare' => '=',
								)
							);
	}
	else {
		$meta_query_array = array(
								array(
									'key' => 'EWD_URP_Product_Name',
									'value' => array(''),
									'compare' => 'NOT IN',
								)
							);
	}
	if ($review_author != "") {
		$meta_query_array[] = array(
									'key' => 'EWD_URP_Post_Author',
									'value' => $review_author,
									'compare' => '=',
								);
	}
	foreach ($custom_filters as $Field_Name => $Value) {
		if ($Value == "") {continue;}
		$meta_query_array[] = array(
									'key' => 'EWD_URP_' . $Field_Name,
									'value' => $Value,
									'compare' => '=',
								);
	}
	$meta_query_array[] = array(
								'key' => 'EWD_URP_Overall_Score',
								'value' => array($min_score, $max_score),
								'compare' => 'BETWEEN',
								'type' => 'DECIMAL'
	);

	$params = array('posts_per_page' => $post_count,
					'post_type' => 'urp_review',
					'post_status' => 'publish',
					'orderby' => $orderby_selection,
					'order' => $order,
					'meta_query' => $meta_query_array,
					'tax_query' => $tax_query_array,
					'suppress_filters' => false
			);

	if ($group_by_product == "Yes") {$params['meta_key'] = "EWD_URP_Product_Name";}
	elseif ($orderby == "Rating") {$params['meta_key'] = 'EWD_URP_Overall_Score';}
	elseif ($orderby == "Karma") {$params['meta_key'] = 'EWD_URP_Review_Karma';}

	if ($search_string != "") {$params['s'] = $search_string;}

	if ($include_ids != "") {$params['post__in'] = $Post_Include_ID_Array;}
	if ($exclude_ids != "") {$params['post__not_in'] = $Post_Exclude_ID_Array;}

	$Review_Query = new WP_Query($params);
	$Reviews = $Review_Query->get_posts();
	//$ReviewsString .= $Review_Query->request . "<br>";
	//echo $Review_Query->request;

	$Review_Params['product_name'] = $product_name;
	$Review_Params['Page Permalink'] = get_permalink();
	if ($review_skin != "") {$Review_Params['review_skin'] = $review_skin;}
	if ($review_format != "") {$Review_Params['review_format'] = $review_format;}

	if ($Custom_CSS != "") {$HeaderString .= "<style>" . $Custom_CSS . "</style>";}

	if (($Summary_Statistics == "Full" or $Summary_Statistics == "Limited") and $product_name != "") {$HeaderString .= "%SUMMARY_STATISTICS_PLACEHOLDER%";}
	if ($Display_Microdata == "Yes" and $product_name != "") {$HeaderString .= "%MICRODATA_SUMMARY_PLACEHOLDER%";}

	$HeaderString .= "%FILTERING_PLACEHOLDER%";
	$ReviewsString = '';
	$ReviewsString .= "%PAGINATION_PLACEHOLDER_TOP%";

	$Counter = 1;
	$Current_Product_Group = "";

	if ($reviews_objects == "Yes") {
		$Reviews_Posts = $Review_Query->get_posts();
		return json_encode($Reviews_Posts);
	}

	if ($review_format == "slider") {$Review_IDs = array();}

	while ( $Review_Query->have_posts() ): $Review_Query->the_post(); global $post;
	    		$Review = get_post();
	    		$post->In_URP_Shortcode = "Yes";

		if ($Email_Confirmation == "Yes") {
			$Email_Confirmed = get_post_meta($Review->ID, 'EWD_URP_Email_Confirmed', true);

			if ($Email_Confirmed != "Yes") {
				continue;
			}
		}

		$Product_Name = get_post_meta($Review->ID, 'EWD_URP_Product_Name', true);
		$Product_Names[] = $Product_Name;
		$Review_Author = get_post_meta($Review->ID, 'EWD_URP_Post_Author', true);
		$Review_Authors[] = $Review_Author;

		if ($Counter <= ($current_page - 1) * $Reviews_Per_Page or $Counter > $current_page * $Reviews_Per_Page) {
			$Counter++;
			continue;
		}

		if ($review_format == "slider") {$Review_IDs[] = $Review->ID; continue;}

		if ($group_by_product == "Yes" and $product_name == "") {
			if ($Current_Product_Group != $Product_Name) {
				if ($Summary_Statistics == "Full" or $Summary_Statistics == "Limited") {$SummaryString = EWD_URP_Build_Summary_Statistics_String($Current_Product_Group, $Review_Params);}
				else {$SummaryString = "<div class='ewd-urp-product-group-heading'>" . __("Reviews for", 'ultimate-reviews') . " " . $Current_Product_Group . "</div>";}
				$ReviewsString = str_replace("%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $ReviewsString);
				$ReviewsString .= "%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%";

				$Current_Product_Group = $Product_Name;
			}
		}

		$ReviewsString .= EWD_URP_Display_Review($Review, $Review_Params);

		$Counter++;

	endwhile;

	wp_reset_postdata();

	if ($review_format == "slider") {
		$Review_ID_String = implode(",", $Review_IDs);
		$ReturnString = do_shortcode("[ultimate-slider slider_type='urp' post__in_string='" . $Review_ID_String . "']");
		return $ReturnString;
	}

	if ($group_by_product == "Yes" and $product_name == "") {
		if ($Summary_Statistics == "Full" or $Summary_Statistics == "Limited") {$SummaryString = EWD_URP_Build_Summary_Statistics_String($Current_Product_Group, $Review_Params);}
		else {$SummaryString = "<div class='ewd-urp-product-group-heading'>" . __("Reviews for", 'ultimate-reviews') . " " . $Current_Product_Group . "</div>";}
		$ReviewsString = str_replace("%PRODUCT_SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $ReviewsString);
	}

	$ReviewsString .= "%PAGINATION_PLACEHOLDER_BOTTOM%";
	$FooterString = '';
	$FooterString .= "<div class='ewd-urp-clear'></div>";

	$FooterString .= "</div>";

	$Total_Reviews = sizeOf($Reviews);
	if ($Total_Reviews > $Reviews_Per_Page) {
		$Num_Pages = ceil($Total_Reviews / $Reviews_Per_Page);

		if ($Infinite_Scroll == "Yes") {
			$Pagination_String .= "<div class='urp-infinite-scroll-content-area' data-shortcodeid='" . $Shortcode_ID . "'>";
			$Pagination_String .= "<input type='hidden' name'post_count' value='" . $current_page . "' id='urp-current-page' data-shortcodeid='" . $Shortcode_ID . "' />";
			$Pagination_String .= "<input type='hidden' name'post_count' value='" . $Num_Pages . "' id='urp-max-page' data-shortcodeid='" . $Shortcode_ID . "' />";
			$Pagination_String .= "</div>";
		}
		else {

			$PrevPage = max($current_page - 1, 1);
			$NextPage = min($current_page + 1, $Num_Pages);

			$Pagination_String = '';
			$Pagination_String .= "<div class='ewd-rup-reviews-nav ";
			$Pagination_String .= "ewd-urp-reviews-nav-bg-" . $Pagination_Background . " ";
			$Pagination_String .= "ewd-urp-reviews-border-" . $Pagination_Border . " ";
			$Pagination_String .= "ewd-urp-reviews-" . $Pagination_Shadow . " ";
			$Pagination_String .= "ewd-urp-reviews-" . $Pagination_Gradient . " ";
			$Pagination_String .= "'>";
			$Pagination_String .= "<input type='hidden' name'post_count' value='" . $current_page . "' id='urp-current-page' data-shortcodeid='" . $Shortcode_ID . "' />";
			$Pagination_String .= "<input type='hidden' name'post_count' value='" . $Num_Pages . "' id='urp-max-page' data-shortcodeid='" . $Shortcode_ID . "' />";
			$Pagination_String .= "<span class='displaying-num'>" . $Total_Reviews . $Reviews_Pagination_Label . "</span>";
			$Pagination_String .= "<span class='pagination-links'>";
			$Pagination_String .= "<a class='first-page ewd-urp-page-control' title='Go to the first page' data-controlvalue='first' data-shortcodeid='" . $Shortcode_ID . "'>&#171;</a>";
			$Pagination_String .= "<a class='prev-page ewd-urp-page-control' title='Go to the previous page' data-controlvalue='back' data-shortcodeid='" . $Shortcode_ID . "'>&#8249;</a>";
			$Pagination_String .= "<span class='paging-input'>" . $current_page . __(' of ', 'ultimate-reviews') . "<span class='total-pages'>" . $Num_Pages . "</span></span>";
			$Pagination_String .= "<a class='next-page ewd-urp-page-control' title='Go to the next page'  data-controlvalue='next' data-shortcodeid='" . $Shortcode_ID . "'>&#8250;</a>";
			$Pagination_String .= "<a class='last-page ewd-urp-page-control' title='Go to the last page'  data-controlvalue='last' data-shortcodeid='" . $Shortcode_ID . "'>&#187;</a>";
			$Pagination_String .= "</span>";
			$Pagination_String .= "</div>";

			if ($current_page == 1) {$Pagination_String = str_replace("first-page", "first-page disabled", $Pagination_String);}
			if ($current_page == 1) {$Pagination_String = str_replace("prev-page", "prev-page disabled", $Pagination_String);}
			if ($current_page == $Num_Pages) {$Pagination_String = str_replace("next-page", "next-page disabled", $Pagination_String);}
			if ($current_page == $Num_Pages) {$Pagination_String = str_replace("last-page", "last-page disabled", $Pagination_String);}
		}
	}
	else {
		$Pagination_String = "";
	}

	$Filter_Button_Label = get_option("EWD_URP_Filter_Button_Label");
	if($Filter_Button_Label == ''){$Filter_Button_Label = __("Filter", 'ultimate-reviews');}
	$Filter_Product_Name_Label = get_option("EWD_URP_Filter_Product_Name_Label");
	if($Filter_Product_Name_Label == ''){$Filter_Product_Name_Label = __("Product Name", 'ultimate-reviews');}
	$Filter_All_Label = get_option("EWD_URP_Filter_All_Label");
	if($Filter_All_Label == ''){$Filter_All_Label = __("All", 'ultimate-reviews');}
	$Filter_Review_Score_Label = get_option("EWD_URP_Filter_Review_Score_Label");
	if($Filter_Review_Score_Label == ''){$Filter_Review_Score_Label = __("Review Score", 'ultimate-reviews');}
	$Filter_Review_Author_Label = get_option("EWD_URP_Filter_Review_Author_Label");
	if($Filter_Review_Author_Label == ''){$Filter_Review_Author_Label = __("Review Author", 'ultimate-reviews');}

	if (!empty($Review_Filtering) or !empty($EWD_URP_Custom_Filters)) {
		$Filtering_String = "<div class='ewd-urp-filtering' data-shortcodeid='" . $Shortcode_ID . "'>";
		$Filtering_String .= "<div class='ewd-urp-filtering-toggle ewd-urp-filtering-toggle-downcaret'>";
		$Filtering_String .= $Filter_Button_Label;
		$Filtering_String .= "</div>";
		$Filtering_String .= "<div class='ewd-urp-filtering-controls ewd-urp-hidden'>";
		if (in_array("Name", $Review_Filtering)) {
			if (is_array($Product_Names)) {
				$Unique_Product_Names = array_unique($Product_Names);
				natcasesort($Unique_Product_Names);
				if (sizeOf($Unique_Product_Names) > 1) {
					$Filtering_String .= "<div class='ewd-urp-filtering-product-name-div'>";
					$Filtering_String .= "<label class='ewd-urp-filtering-label'>" . $Filter_Product_Name_Label . ":</label>";
					$Filtering_String .= "<select class='ewd-filtering-product-name ewd-urp-filtering-select' data-shortcodeid='" . $Shortcode_ID . "'>";
					$Filtering_String .= "<option value=''>" . $Filter_All_Label . "</option>";
					foreach ($Unique_Product_Names as $Product_Name) {$Filtering_String .= "<option value='" . $Product_Name . "'>" . $Product_Name . "</option>";}
					$Filtering_String .= "</select>";
					$Filtering_String .= "</div>";
				}
			}
		}
		if (in_array("Score", $Review_Filtering)) {
			$Filtering_String .= "<div class='ewd-urp-filtering-product-name-div'>";
			$Filtering_String .= "<label class='ewd-urp-filtering-label'>" . $Filter_Review_Score_Label . "</label>";
			$Filtering_String .= "<span class='ewd-urp-score-range'>1 - " . $Maximum_Score . "</span>";
			$Filtering_String .= "<div class='ewd-urp-review-score-filter' data-shortcodeid='" . $Shortcode_ID . "'></div>";
			$Filtering_String .= "</div>";
		}
		if (in_array("Author", $Review_Filtering)) {
			if (is_array($Review_Authors)) {
				$Unique_Review_Authors = array_unique($Review_Authors);
				natcasesort($Unique_Review_Authors);
				if (sizeOf($Unique_Review_Authors) > 1) {
					$Filtering_String .= "<div class='ewd-urp-filtering-review-author-div'>";
					$Filtering_String .= "<label class='ewd-urp-filtering-label'>" . $Filter_Review_Author_Label . "</label>";
					$Filtering_String .= "<select class='ewd-filtering-review-author ewd-urp-filtering-select' data-shortcodeid='" . $Shortcode_ID . "'>";
					$Filtering_String .= "<option value=''>" . $Filter_All_Label . "</option>";
					foreach ($Unique_Review_Authors as $Review_Author) {$Filtering_String .= "<option value='" . $Review_Author . "'>" . $Review_Author . "</option>";}
					$Filtering_String .= "</select>";
					$Filtering_String .= "</div>";
				}
			}
		}
		if (!empty($EWD_URP_Custom_Filters)) {
			foreach ($EWD_URP_Custom_Filters as $Field_Name => $Values) {
				if (is_array($Values)) {
					$Unique_Values = array_unique($Values);
					natcasesort($Unique_Values);
					if (sizeOf($Unique_Values) > 1) {
						$Filtering_String .= "<div class='ewd-urp-filtering-product-name-div'>";
						$Filtering_String .= "<label class='ewd-urp-filtering-label'>" . $Field_Name . "</label>";
						$Filtering_String .= "<select class='ewd-urp-filtering-select ewd-urp-custom-filter' data-fieldname='" . $Field_Name . "' data-shortcodeid='" . $Shortcode_ID . "'>";
						$Filtering_String .= "<option value=''>" . $Filter_All_Label . "</option>";
						foreach ($Unique_Values as $Unique_Value) {$Filtering_String .= "<option value='" . $Unique_Value . "'>" . $Unique_Value . "</option>";}
						$Filtering_String .= "</select>";
						$Filtering_String .= "</div>";
					}
				}
			}
		}
		$Filtering_String .= "</div>";
		$Filtering_String .= "</div>";
		$HeaderString = str_replace("%FILTERING_PLACEHOLDER%", $Filtering_String, $HeaderString);
	}
	else {$HeaderString = str_replace("%FILTERING_PLACEHOLDER%", '', $HeaderString);}

	if (($Summary_Statistics == "Full" or $Summary_Statistics == "Limited") and $product_name != "") {
		$SummaryString = EWD_URP_Build_Summary_Statistics_String($product_name, $Review_Params);
		$HeaderString = str_replace("%SUMMARY_STATISTICS_PLACEHOLDER%", $SummaryString, $HeaderString);
	}

	if ($Display_Microdata == "Yes" and $product_name != "") {
		$MicrodataString = EWD_URP_Build_Microdata_Summary($product_name, $Review_Params);
		$HeaderString = str_replace("%MICRODATA_SUMMARY_PLACEHOLDER%", $MicrodataString, $HeaderString);
	}

	if (($Pagination_Location == "Top" or $Pagination_Location == "Both") and $Infinite_Scroll != "Yes") {$ReviewsString = str_replace("%PAGINATION_PLACEHOLDER_TOP%", $Pagination_String, $ReviewsString);}
	else {$ReviewsString = str_replace("%PAGINATION_PLACEHOLDER_TOP%", "", $ReviewsString);}
	if (($Pagination_Location == "Bottom" or $Pagination_Location == "Both") or $Infinite_Scroll == "Yes") {$ReviewsString = str_replace("%PAGINATION_PLACEHOLDER_BOTTOM%", $Pagination_String, $ReviewsString);}
	else {$ReviewsString = str_replace("%PAGINATION_PLACEHOLDER_BOTTOM%", "", $ReviewsString);}

	if (sizeOf($Reviews) == 0) {$ReviewsString .= "<div class='ewd-urp-no-results'>" . __("No matching reviews found.", 'ultimate-reviews') . "</div>";}

	$Review_Format = get_option("EWD_URP_Review_Format");
	if ($only_reviews != "Yes") {
		$ReturnString = $HeaderString;
		$ReturnString .= "<div class='ewd-urp-reviews-container";
		if($Review_Format == "Thumbnail_Masonry"){
			$ReturnString .= " ewd-urp-thumbnail-masonry";
		}
		if($Review_Format == "Image_Masonry"){
			$ReturnString .= " ewd-urp-image-masonry";
		}
		$ReturnString .= "' data-shortcodeid='" . $Shortcode_ID . "'>";
		$ReturnString .= $ReviewsString;
		$ReturnString .= "</div>";
		$ReturnString .= $FooterString;
	}
	else {
		$ReturnString = $ReviewsString;
	}

	return $ReturnString;
}


add_filter('get_meta_sql','EWD_URP_Cast_Decimal_Precision');
function EWD_URP_Cast_Decimal_Precision( $array ) {
	if (strpos($array['where'], 'urp_review') !== false) {$array['where'] = str_replace('DECIMAL','DECIMAL(10,2)',$array['where']);}

    return $array;
}


function EWD_URP_Build_Summary_Statistics_String($Product_Name, $Review_Params, $Summary_Type = "", $Before_Text = "", $After_Text = "") {
	global $EWD_URP_Summary_Statistics_Array;

	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Style = get_option("EWD_URP_Review_Style");
	$Review_Weights = get_option("EWD_URP_Review_Weights");
	$Summary_Statistics = get_option("EWD_URP_Summary_Statistics");
	$Summary_Clickable = get_option("EWD_URP_Summary_Clickable");

	if ($Summary_Type != "") {$Summary_Statistics = $Summary_Type;}
	if ($Before_Text == "") {$Before_Text = __('Summary for', 'ultimate-reviews');}

	$min_score = $EWD_URP_Summary_Statistics_Array['min_score'];
	$max_score = $EWD_URP_Summary_Statistics_Array['max_score'];

	$SummaryString = "";

	$Total_Reviews = 0;
	$Integer_Count = 0;
	$Total_Score = 0;

	if (isset($EWD_URP_Summary_Statistics_Array[$Product_Name])) {
		foreach ($EWD_URP_Summary_Statistics_Array[$Product_Name] as $ReviewScore => $Count) {
			if ($ReviewScore == "Total Weights") {continue;}
			$Total_Reviews += $Count;
			if (is_int($ReviewScore)) {$Integer_Count += $Count;}
			$Total_Score += $ReviewScore * $Count;
		}

		if ($Total_Reviews != 0) {
			$Average_Score = round($Total_Score / $Total_Reviews, 2);
			if ($Review_Weights == "Yes") {
				if ($EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] == 0) {$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] = 1;}
				else {$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] = $EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] / $Total_Reviews;}
				$Average_Score = $Average_Score / $EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'];
			}
			$Score_Width = max(($Average_Score * (100 / $Maximum_Score)), 0);
		}
		else {
			$Average_Score = "N/A";
			$Score_Width = 0;
			$Total_Reviews = 1;
		}

		if ($Integer_Count == 0) {$Integer_Count = 1;}

		$SummaryString .= "<div class='ewd-urp-summary-statistics-div' data-shortcodeid='" . $EWD_URP_Summary_Statistics_Array['Shortcode_ID'] . "'>";

		$SummaryString .= "<div class='ewd-urp-summary-statistics-header'>";
		if ($Review_Params['product_name'] == "") {$SummaryString .= "<div class='ewd-urp-summary-product-name'>" . $Before_Text . " " . $Product_Name . " " . $After_Text . "</div>";}

		$Summary_Average_Score_Label = get_option("EWD_URP_Summary_Average_Score_Label");
		if($Summary_Average_Score_Label == ''){$Summary_Average_Score_Label = __("Average Score", 'ultimate-reviews');}
		$Ratings_Text = get_option("EWD_URP_Summary_Ratings_Label");
		if($Ratings_Text == ''){
			if($Total_Reviews == 1){$Ratings_Text = __("rating", 'ultimate-reviews');}
			else{$Ratings_Text = __("ratings", 'ultimate-reviews');}
		}

		$SummaryString .= "<div class='ewd-urp-summary-average-score'>" . $Summary_Average_Score_Label . ": " . $Average_Score . " (" . $Total_Reviews . " " . $Ratings_Text . ")" . "</div>";
		$SummaryString .= "</div>";

		if ($Summary_Statistics == "Full") {
			if ($Review_Style == "Percentage") {
				$SummaryString .= "<div class='ewd-urp-summary-percentage-graphic'>";
				$SummaryString .= "<div class='ewd-urp-summary-percentage-graphic-full' style='width:" . $Score_Width . "%'></div>";
				$SummaryString .= "</div>";
			}
			else {
				$SummaryString .= "<div class='ewd-urp-standard-summary-graphic'>";
				$SummaryString .= "<div class='ewd-urp-standard-summary-graphic-full' style='width:" . $Score_Width . "%'></div>";
				$SummaryString .= "</div>";
				for ($i=$Maximum_Score; $i>=1; $i--) {
					if(!isset($EWD_URP_Summary_Statistics_Array[$Product_Name][$i])) {
						$EWD_URP_Summary_Statistics_Array[$Product_Name][$i] = 0;
					}
					$Sub_Score_Width = max(($EWD_URP_Summary_Statistics_Array[$Product_Name][$i] / $Integer_Count), 0) * 100;
					$Summary_Score_Count = max($EWD_URP_Summary_Statistics_Array[$Product_Name][$i], 0);
					if ($Summary_Clickable == "Yes") {
						if($Summary_Score_Count == 0) {$SummaryString .= "<div class='ewd-urp-summary-non-clickable' data-reviewscore='" . $i . "' data-shortcodeid='" . $EWD_URP_Summary_Statistics_Array['Shortcode_ID'] . "'>";}
						else{$SummaryString .= "<div class='ewd-urp-summary-clickable' data-reviewscore='" . $i . "' data-shortcodeid='" . $EWD_URP_Summary_Statistics_Array['Shortcode_ID'] . "'>";}
					}
					$SummaryString .= "<div class='ewd-urp-summary-score-value'>" . $i . "</div>";
					$SummaryString .= "<div class='ewd-urp-standard-summary-graphic-sub-group'>";
					$SummaryString .= "<div class='ewd-urp-standard-summary-graphic-full-sub-group'  style='width:" . $Sub_Score_Width . "%'></div>";
					$SummaryString .= "</div>";
					$SummaryString .= "<div class='ewd-urp-summary-score-count'>" . max($EWD_URP_Summary_Statistics_Array[$Product_Name][$i], 0) . "</div>";
					if ($Summary_Clickable == "Yes") {$SummaryString .= "</div>";}
					$SummaryString .= "<div class='ewd-urp-clear'></div>";
				}
				if ($min_score == $max_score and $min_score != 0 and $max_score != 1000000) {$SummaryString .= "<div class='ewd-urp-remove-score-filter'>Show all reviews</div>";}
			}
		}

		$Display_Microdata = get_option("EWD_URP_Display_Microdata");

		if( $Display_Microdata == "Yes" && ($Summary_Statistics == "Full" || $Summary_Statistics == "Limited") ){
			$SummaryString .= "<div class='ewd-urp-microdata ewd-urp-hidden' itemprop='aggregateRating' itemscope itemtype='http://schema.org/AggregateRating'>";
				$SummaryString .= "<meta itemprop='itemReviewed' content='" . $Product_Name . "' />";
				$SummaryString .= "<meta itemprop='ratingValue' content='" . $Average_Score . "' />";
				$SummaryString .= "<meta itemprop='bestRating' content='" . $Maximum_Score . "' />";
				$SummaryString .= "<meta itemprop='reviewCount' content='" . $Total_Reviews . "' /'>";
			$SummaryString .= "</div>";
		}

		$SummaryString .= "</div>";
	}

	return $SummaryString;
}

function EWD_URP_Build_Microdata_Summary($Product_Name, $Review_Params) {
	global $EWD_URP_Summary_Statistics_Array;

	$Review_Weights = get_option("EWD_URP_Review_Weights");
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");

	if (isset($EWD_URP_Summary_Statistics_Array[$Product_Name])) {
		foreach ($EWD_URP_Summary_Statistics_Array[$Product_Name] as $ReviewScore => $Count) {
			if ($ReviewScore == "Total Weights") {continue;}
			$Total_Reviews += $Count;
			$Total_Score += $ReviewScore * $Count;
		}

		if ($Total_Reviews != 0) {
			$Average_Score = round($Total_Score / $Total_Reviews, 2);
			if ($Review_Weights == "Yes") {
				if ($EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] == 0) {$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] = 1;}
				else {$EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] = $EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'] / $Total_Reviews;}
				$Average_Score = $Average_Score / $EWD_URP_Summary_Statistics_Array[$Product_Name]['Total Weights'];
			}
		}
		else {
			$Average_Score = "N/A";
			$Total_Reviews = 1;
		}
	}

	$MicrodataString = "<div class='ewd-urp-microdata ewd-urp-hidden' itemprop='aggregateRating' itemscope itemtype='http://schema.org/AggregateRating'>";
	$MicrodataString .= "<meta itemprop='itemReviewed' content='" . $Product_Name . "' />";
	$MicrodataString .= "<meta itemprop='ratingValue' content='" . $Average_Score . "' />";
	$MicrodataString .= "<meta itemprop='bestRating' content='" . $Maximum_Score . "' />";
  	$MicrodataString .= "<meta itemprop='reviewCount' content='" . $Total_Reviews . "' /'>";
	$MicrodataString .= "</div>";

	return $MicrodataString;
}

function EWD_URP_Rand_Chars($CharLength = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $CharLength; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) -1)];
    }
    return $randstring;
}
