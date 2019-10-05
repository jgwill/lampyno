<?php
add_action( 'init', 'EWD_URP_Create_Posttype' );
function EWD_URP_Create_Posttype() {
		$labels = array(
				'name' => __('Reviews', 'ultimate-reviews'),
				'singular_name' => __('Review', 'ultimate-reviews'),
				'menu_name' => __('Reviews', 'ultimate-reviews'),
				'add_new' => __('Add New', 'ultimate-reviews'),
				'add_new_item' => __('Add New Review', 'ultimate-reviews'),
				'edit_item' => __('Edit Review', 'ultimate-reviews'),
				'new_item' => __('New Review', 'ultimate-reviews'),
				'view_item' => __('View Review', 'ultimate-reviews'),
				'search_items' => __('Search Reviews', 'ultimate-reviews'),
				'not_found' =>  __('Nothing found', 'ultimate-reviews'),
				'not_found_in_trash' => __('Nothing found in Trash', 'ultimate-reviews'),
				'parent_item_colon' => ''
		);

		$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'query_var' => true,
				'has_archive' => true,
				'menu_icon' => null,
				'rewrite' => array('slug' => 'review'),
				'capability_type' => 'post',
				'menu_position' => null,
				'menu_icon' => 'dashicons-format-status',
				'supports' => array('title','editor','author','excerpt','comments', 'thumbnail'),
				'show_in_rest' => true
	  );

	register_post_type( 'urp_review' , $args );
}

add_action( 'init', 'EWD_URP_Create_Category_Taxonomy', 0 );
function EWD_URP_Create_Category_Taxonomy() {

	register_taxonomy('urp-review-category', 'urp_review', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => __('Review Categories', 'ultimate-reviews'),
			'singular_name' => __('Review Category', 'ultimate-reviews'),
			'search_items' =>  __('Search Review Categories', 'ultimate-reviews'),
			'all_items' => __('All Review Categories', 'ultimate-reviews'),
			'parent_item' => __('Parent Review Category', 'ultimate-reviews'),
			'parent_item_colon' => __('Parent Review Category:', 'ultimate-reviews'),
			'edit_item' => __('Edit Review Category', 'ultimate-reviews'),
			'update_item' => __('Update Review Category', 'ultimate-reviews'),
			'add_new_item' => __('Add New Review Category', 'ultimate-reviews'),
			'new_item_name' => __('New Review Category Name', 'ultimate-reviews'),
			'menu_name' => __('Review Categories', 'ultimate-reviews'),
		),
		'query_var' => true,
		'show_in_rest' => true
	));

}

add_filter("get_sample_permalink_html", "EWD_URP_Add_Review_Shortcode", 10, 5);
function EWD_URP_Add_Review_Shortcode($HTML, $post_id, $title, $slug, $post) {
	if ($post->post_type == "urp_review") {
		$HTML .= "<div class='ewd-urp-shortcode-help'>";
		$HTML .= __("Use the following shortcode to add this review to a page:", 'ultimate-reviews') . "<br>";
		$HTML .= "[select-review review_id='" . $post_id . "']";
		$HTML .= "</div>";
	}

	return $HTML;
}

add_action( 'add_meta_boxes', 'EWD_URP_Add_Meta_Boxes' );
function EWD_URP_Add_Meta_Boxes () {
	add_meta_box("review-meta", __("Review Details", 'ultimate-reviews'), "EWD_URP_Meta_Box", "urp_review", "normal", "high");
	add_meta_box("urp-meta-need-help", __("Need Help?", 'ultimate-reviews'), "EWD_URP_Need_Help_Meta_Box", "urp_review", "side", "high");
}

function EWD_URP_Need_Help_Meta_Box( $post ) {
	echo "<div class='ewd-urp-need-help-box'>";
		echo "<div class='ewd-urp-need-help-text'>Visit our Support Center for documentation and tutorials</div>";
		echo "<a class='ewd-urp-need-help-button' href='https://www.etoilewebdesign.com/support-center/?Plugin=URP' target='_blank'>GET SUPPORT</a>";
	echo "</div>";
}

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function EWD_URP_Meta_Box( $post ) {
	$Review_Weights = get_option("EWD_URP_Review_Weights");
	$Review_Karma = get_option("EWD_URP_Review_Karma");
	$Require_Email = get_option("EWD_URP_Require_Email");
	$Review_Video = get_option("EWD_URP_Review_Video");
	$Email_Confirmation = get_option("EWD_URP_Email_Confirmation");
	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
	if (!is_array($Review_Categories_Array)) {$Review_Categories_Array = array();}

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'EWD_URP_Save_Meta_Box_Data', 'EWD_URP_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */

	if ($Review_Weights == "Yes") {
		$Value = get_post_meta( $post->ID, 'EWD_URP_Review_Weight', true );
	?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label" for="Review_Weight">
		<?php _e( "Review Weight:", 'ultimate-reviews' ); ?>
		</label>
		<input type='text' id='ewd-urp-review-weight' name='Review_Weight' value="<?php echo esc_attr($Value); ?>" size='25' />
		</div>
	<?php }

	$Order_ID = get_post_meta( $post->ID, 'EWD_URP_Order_ID', true );
	if ($Order_ID) { ?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label">
		<?php _e( "WooCommerce Order ID:", 'ultimate-reviews' ); ?>
		</label>
		<span><?php echo esc_html($Order_ID); ?></span>
		</div>
	<?php }

	if ($Review_Karma == "Yes") {
		$Value = get_post_meta( $post->ID, 'EWD_URP_Review_Karma', true );
	?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label" for="Review_Karma">
		<?php _e( "Review Karma:", 'ultimate-reviews' ); ?>
		</label>
		<input type='text' id='ewd-urp-review-karma' name='Review_Karma' value="<?php echo esc_attr($Value); ?>" size='25' />
		</div>
	<?php }

	if ($Require_Email == "Yes") {
		$Value = get_post_meta( $post->ID, 'EWD_URP_Post_Email', true );
	?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label" for="Post_Email">
		<?php _e( "Reviewer's Email:", 'ultimate-reviews' ); ?>
		</label>
		<input type='text' id='ewd-urp-post-email' name='Post_Email' value="<?php echo esc_attr( $Value ); ?>" size='25' />
		</div>
	<?php }

	if ($Email_Confirmation == "Yes") {
		$Value = get_post_meta( $post->ID, 'EWD_URP_Email_Confirmed', true );
	?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label" for="Email_Confirmed">
		<?php _e( "Email Confirmed:", 'ultimate-reviews' ); ?>
		</label>
		<input type="radio" id="ewd-urp-email-confirmed" name="Email_Confirmed" value='Yes' <?php if ($Value != "No") {echo "checked=checked";} ?> />Yes &nbsp;&nbsp;&nbsp;
		<input type="radio" id="ewd-urp-email-confirmed" name="Email_Confirmed" value='No' <?php if ($Value == "No") {echo "checked=checked";} ?> />No
		</div>
	<?php }

	if ($Review_Video == "Yes") {
		$Value = get_post_meta( $post->ID, 'EWD_URP_Review_Video', true );
	?>
		<div class="ewd-urp-meta-field">
		<label class="ewd-urp-meta-label" for="Review_Video">
		<?php _e( "Review Video:", 'ultimate-reviews' ); ?>
		</label>
		<input type='text' id='ewd-urp-review-video' name='Review_Video' value="<?php echo esc_attr( $Value ); ?>" size='25' />
		</div>
	<?php }

	if ($Review_Weights == "Yes" or $Review_Karma == "Yes" or $Email_Confirmation == "Yes" or $Review_Video == "Yes") {echo "<div class='ewd-urp-meta-separator'></div>";}

	$Value = get_post_meta( $post->ID, 'EWD_URP_Product_Name', true );

	echo "<div class='ewd-urp-meta-field'>";
	echo "<label class='ewd-urp-meta-label' for='Product_Name'>";
	echo __( "Product Name:", 'ultimate-reviews' );
	echo " </label>";
	echo "<input type='text' id='ewd-urp-product-name' name='Product_Name' value='" . esc_attr( $Value ) . "' size='25' />";
	echo "</div>";

	$Value = get_post_meta( $post->ID, 'EWD_URP_Post_Author', true );

	echo "<div class='ewd-urp-meta-field'>";
	echo "<label class='ewd-urp-meta-label' for='Post_Author'>";
	echo __( "Post Author:", 'ultimate-reviews' );
	echo " </label>";
	echo "<input type='text' id='ewd-urp-post-author' name='Post_Author' value='" . esc_attr( $Value ) . "' size='25' />";
	echo "</div>";

	if ($InDepth_Reviews == "No" or sizeOf($Review_Categories_Array) == 0) {
		$Value = get_post_meta($post->ID, "EWD_URP_Overall_Score", true);

		echo "<div class='ewd-urp-meta-field'>";
		echo "<label class='ewd-urp-meta-label' for='Overall Score'>";
		echo  __("Overall Score", 'ultimate-reviews') . ": ";
		echo "</label>";
		echo "<input type='text' id='ewd-urp-overall-score' name='EWD_URP_Overall_Score' value='" . esc_attr( $Value ) . "' size='25' />";
		echo "</div>";
	}
	else {
		foreach ($Review_Categories_Array as $Review_Categories_Item) {
			$Default_Names = array("Product Name (if applicable)","Review Author","Reviewer Email (if applicable)","Review Title","Review Image (if applicable)","Review Video (if applicable)","Review","Overall Score");
			if (in_array($Review_Categories_Item['CategoryName'], $Default_Names)) {continue;}

			$Value = get_post_meta($post->ID, "EWD_URP_" . $Review_Categories_Item['CategoryName'], true);
			if ($Review_Categories_Item['ExplanationAllowed'] == "Yes") {$Description = get_post_meta($post->ID, "EWD_URP_" . $Review_Categories_Item['CategoryName'] . "_Description", true);}

			echo "<div class='ewd-urp-meta-field'>";
			echo "<label class='ewd-urp-score-label' for='" . $Review_Categories_Item['CategoryName'] . "'>";
			if ($Review_Categories_Item['CategoryType'] == "" or $Review_Categories_Item['CategoryType'] == "ReviewItem") {echo $Review_Categories_Item['CategoryName'] . " " . __("Score", 'ultimate-reviews') . ": ";}
			else {echo $Review_Categories_Item['CategoryName'];}
			echo "</label>";
			if ($Review_Categories_Item['CategoryType'] == "Dropdown") {
				$Options = explode(",", $Review_Categories_Item['Options']);
				if (!empty($Options)) {
					echo "<select name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "'>";
					foreach ($Options as $Option) {
						echo "<option value='" . $Option . "' ";
						if ($Option == $Value) {echo "selected";}
						echo ">" . $Option . "</option>";
					}
					echo "</select>";
				}
			}
			elseif ($Review_Categories_Item['CategoryType'] == "Checkbox") {
				$Options = explode(",", $Review_Categories_Item['Options']);
				if (!empty($Options)) {
					echo "<div class='ewd-urp-fields-page-radio-checkbox-container'>";
						$Values = explode(",", $Value);
						foreach ($Options as $Option) {
							echo "<div class='ewd-urp-fields-page-radio-checkbox-each'>";
								echo "<input type='checkbox' name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "[]' value='" . $Option . "' ";
								if (in_array($Option, $Values)) {echo "checked";}
								echo " />" . $Option;
							echo "</div>"; //	ewd-urp-fields-page-radio-checkbox-each
						}
					echo "</div>"; //	ewd-urp-fields-page-radio-checkbox-container
				}
			}
			elseif ($Review_Categories_Item['CategoryType'] == "Radio") {
				$Options = explode(",", $Review_Categories_Item['Options']);
				if (!empty($Options)) {
					echo "<div class='ewd-urp-fields-page-radio-checkbox-container'>";
						foreach ($Options as $Option) {
							echo "<div class='ewd-urp-fields-page-radio-checkbox-each'>";
								echo "<input type='radio' name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "' value='" . $Option . "' ";
								if ($Option == $Value) {echo "checked";}
								echo " />" . $Option;
							echo "</div>"; //	ewd-urp-fields-page-radio-checkbox-each
						}
					echo "</div>"; //	ewd-urp-fields-page-radio-checkbox-container
				}
			}
			elseif ($Review_Categories_Item['CategoryType'] == "Date") {echo "<input type='text' class='ewd-urp-jquery-datepicker' id='ewd-urp-" . $Review_Categories_Item['CategoryName'] . "' name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "' value='" . esc_attr( $Value ) . "' />";}
			elseif ($Review_Categories_Item['CategoryType'] == "DateTime") {echo "<input type='datetime-local' id='ewd-urp-" . $Review_Categories_Item['CategoryName'] . "' name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "' value='" . esc_attr( $Value ) . "' />";}
			else {echo "<input type='text' id='ewd-urp-" . $Review_Categories_Item['CategoryName'] . "' name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . "' value='" . esc_attr( $Value ) . "' size='25' />";}
			echo "</div>";

			if ($Review_Categories_Item['ExplanationAllowed'] == "Yes") {
				echo "<div class='ewd-urp-meta-field'>";
				echo "<label class='ewd-urp-explanation-label' for='" . $Review_Categories_Item['CategoryName'] . " Description'>";
				echo $Review_Categories_Item['CategoryName'] . " " . __("Explanation", 'ultimate-reviews') . ": ";
				echo "</label>";
				echo "<textarea name='EWD_URP_" . $Review_Categories_Item['CategoryName'] . " Description'>";
				echo esc_attr($Description);
				echo "</textarea>";
				echo "</div>";
			}
		}
	}
}

add_action( 'save_post', 'EWD_URP_Save_Meta_Box_Data' );
function EWD_URP_Save_Meta_Box_Data($post_id) {
	global $wpdb;

	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
	$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
	if (!is_array($Review_Categories_Array)) {$Review_Categories_Array = array();}

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['EWD_URP_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['EWD_URP_meta_box_nonce'], 'EWD_URP_Save_Meta_Box_Data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. If there's no product name, don't save any other information.*/
	if ( ! isset( $_POST['Product_Name'] ) ) {
		return;
	}

	// Sanitize user input.
	$Review_Weight = sanitize_text_field( $_POST['Review_Weight'] );
	$Review_Karma = sanitize_text_field( $_POST['Review_Karma'] );
	$Post_Email = sanitize_text_field( $_POST['Post_Email'] );
	$Email_Confirmed = sanitize_text_field( $_POST['Email_Confirmed'] );
	$Review_Video = sanitize_text_field( $_POST['Review_Video'] );
	$Product_Name = sanitize_text_field( $_POST['Product_Name'] );
	$Post_Author = sanitize_text_field( $_POST['Post_Author'] );

	// Update the meta field in the database.
	if (isset($_POST['Review_Weight'])) {update_post_meta( $post_id, 'EWD_URP_Review_Weight', $Review_Weight );}
	if (isset($_POST['Review_Karma'])) {update_post_meta( $post_id, 'EWD_URP_Review_Karma', $Review_Karma );}
	if (isset($_POST['Post_Email'])) {update_post_meta( $post_id, 'EWD_URP_Post_Email', $Post_Email );}
	if (isset($_POST['Email_Confirmed'])) {update_post_meta( $post_id, 'EWD_URP_Email_Confirmed', $Email_Confirmed );}
	if (isset($_POST['Review_Video'])) {update_post_meta( $post_id, 'EWD_URP_Review_Video', $Review_Video );}
	if (isset($_POST['Product_Name'])) {update_post_meta( $post_id, 'EWD_URP_Product_Name', $Product_Name );}
	if (isset($_POST['Post_Author'])) {update_post_meta( $post_id, 'EWD_URP_Post_Author', $Post_Author );}

	if ($InDepth_Reviews == "No" or sizeOf($Review_Categories_Array) == 0) {
		$Overall_Score = min(round(sanitize_text_field($_POST['EWD_URP_Overall_Score']), 2), $Maximum_Score);
		update_post_meta($post_id, "EWD_URP_Overall_Score", $Overall_Score);
	}
	else {
		$ReviewItems = 0;
		foreach ($Review_Categories_Array as $Review_Categories_Item) {
			$Field_Value = $_POST['EWD_URP_' . str_replace(" ", "_", $Review_Categories_Item['CategoryName'])];
			if ($Review_Categories_Item['CategoryType'] == "ReviewItem" or $Review_Categories_Item['CategoryType'] == "") {
				$Category_Score = min($Field_Value, $Maximum_Score);
				update_post_meta($post_id, "EWD_URP_" . $Review_Categories_Item['CategoryName'], $Category_Score);
				$Overall_Score += $Category_Score;
				$ReviewItems++;
			}
			elseif ($Review_Categories_Item['CategoryType'] == "Checkbox") {
				$Field_Value = "";
				foreach ($_POST['EWD_URP_' . str_replace(" ", "_", $Review_Categories_Item['CategoryName'])] as $Value) {
					$Field_Value .= $Value . ",";
				}
				$Field_Value = trim($Field_Value, ",");
				update_post_meta($post_id, "EWD_URP_" . $Review_Categories_Item['CategoryName'], sanitize_text_field($Field_Value));
			}
			else {
				update_post_meta($post_id, "EWD_URP_" . $Review_Categories_Item['CategoryName'], sanitize_text_field($Field_Value));
			}

			if ($Review_Categories_Item['ExplanationAllowed'] == "Yes") {
				$Category_Description = $_POST['EWD_URP_' . str_replace(" ", "_", $Review_Categories_Item['CategoryName']) . "_Description"];
				update_post_meta($post_id, "EWD_URP_" . $Review_Categories_Item['CategoryName'] . "_Description", $Category_Description);
			}
		}
		$Overall_Score = round(($Overall_Score / $ReviewItems), 2);
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

    $Product_ID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title=%s AND post_type='product'", $Product_Name));
    if ($Product_ID != '') {update_post_meta($Product_ID, "EWD_URP_Average_Score", $Average_Rating);}
}

function EWD_URP_Add_Review_Information($content) {
	global $post;

    if ($post->post_type == 'urp_review' and !isset($post->In_URP_Shortcode)) {
   		$Custom_CSS = get_option("EWD_URP_Custom_CSS");
		$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
		$Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
		$Display_Author = get_option("EWD_URP_Display_Author");
		$Display_Date = get_option("EWD_URP_Display_Date");

		$Posted_Label = get_option("EWD_URP_Posted_Label");
			if ($Posted_Label == "") {$Posted_Label = __("Posted ", 'ultimate-reviews');}
		$By_Label = get_option("EWD_URP_By_Label");
			if ($By_Label == "") {$By_Label = __("by ", 'ultimate-reviews');}
		$On_Label = get_option("EWD_URP_On_Label");
			if ($On_Label == "") {$On_Label = __("on ", 'ultimate-reviews');}
		$Score_Label = get_option("EWD_URP_Score_Label");
			if ($Score_Label == "") {$Score_Label = __("Score ", 'ultimate-reviews');}
		$Explanation_Label = get_option("EWD_URP_Explanation_Label");
			if ($Explanation_Label == "") {$Explanation_Label = __("Explanation ", 'ultimate-reviews');}

		$Display_Numerical_Score = get_option("EWD_URP_Display_Numerical_Score");
		$Reviews_Skin = get_option("EWD_URP_Reviews_Skin");

		$Updated_View_Count = get_post_meta($post->ID, 'urp_view_count', true) + 1;
		update_post_meta($post->ID, 'urp_view_count', $Updated_View_Count);

    	$HeaderString = "";
    	$ReturnString = "";

   		$Product_Name = get_post_meta($post->ID, 'EWD_URP_Product_Name', true);
		$Post_Author = get_post_meta($post->ID, 'EWD_URP_Post_Author', true);

		$HeaderString .= EWD_URP_Add_Modified_Styles();
		if ($Custom_CSS != "") {$HeaderString .= "<style>" . $Custom_CSS . "</style>";}

		$HeaderString .= "<div class='ewd-urp-review-product-name'>";
		$HeaderString .= __("Review for ", 'ultimate-reviews') . $Product_Name;
		$HeaderString .= "</div>";

   		if ($Display_Author == "Yes"  or $Display_Date == "Yes") {
			$Post_Author = get_post_meta($post->ID, 'EWD_URP_Post_Author', true);
			$ReturnString .= "<div class='ewd-urp-author-date'>";
			$ReturnString .= $Posted_Label . " " ;
			if ($Display_Author == "Yes" and $Post_Author != "") {$ReturnString .= $By_Label . " <span class='ewd-urp-author'>" . $Post_Author . "</span> ";}
			if ($Display_Date == "Yes") {$ReturnString .= $On_Label . " <span class='ewd-urp-date'>" . $post->post_date . "</span> ";}
			$ReturnString .= "</div>";
		}

		if ($InDepth_Reviews == "Yes" and $Review_Categories_Array[0]['CategoryName'] != "") {
			foreach ($Review_Categories_Array as $Review_Category_Item) {
				if ($Review_Category_Item['CategoryName'] != "") {
					$Review_Category_Score = get_post_meta($post->ID, "EWD_URP_" . $Review_Category_Item['CategoryName'], true);
					$Review_Category_Description = get_post_meta($post->ID, "EWD_URP_" . $Review_Category_Item['CategoryName'] . "_Description", true);

					$ReturnString .= "<div class='ewd-urp-category-field'>";

					$ReturnString .= "<div class='ewd-urp-category-score'>";
					$ReturnString .= "<div class='ewd-urp-category-score-label'>";
					$ReturnString .= $Review_Category_Item['CategoryName'] . " " . $Score_Label . ": ";
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
				}
			}
		}
		$content = $HeaderString . $content . $ReturnString;
    }

    return $content;
}
add_filter('the_content', 'EWD_URP_Add_Review_Information');

function EWD_URP_Filter_The_Author($author) {
	global $post;

    if ($post->post_type == 'urp_review') {
    	$author = get_post_meta($post->ID, 'EWD_URP_Post_Author', true);
    }

    return $author;
}
add_filter('the_author', 'EWD_URP_Filter_The_Author');

function EWD_URP_Add_Score_To_Title($title, $id = null) {
	global $post;

    if ($post->post_type == 'urp_review') {
    	$Overall_Score = get_post_meta($post->ID, 'EWD_URP_Overall_Score', true);

    	$title = "<div class='ewd-urp-review-score-number'>" . round($Overall_Score,1) . "/5</div>" . $title;
    }

    return $title;
}
//add_filter('the_title', 'EWD_URP_Add_Score_To_Title');
?>
