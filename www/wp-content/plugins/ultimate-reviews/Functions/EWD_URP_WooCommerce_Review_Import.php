<?php

function EWD_URP_WooCommerce_Review_Import() {
	$Maximum_Score = get_option("EWD_URP_Maximum_Score");

	$WC_Products_Query = new WP_Query(array('post_type' => 'product', 'posts_per_page' => -1));
	$WC_Products = $WC_Products_Query->posts;

	foreach ($WC_Products as $WC_Product) {
		$Comments = get_comments(array('post_id' => $WC_Product->ID, 'orderby' => 'comment_ID', 'order' => 'ASC'));

		foreach ($Comments as $Comment) {
			if ($Comment->comment_parent == 0) {
				$Product_Name = $WC_Product->post_title;

				if ($Comment->comment_approved) {
					$status = "publish";
					$Email_Confirmed = "Yes";
				}
				else {
					$status = "draft";
					$Email_Confirmed = "No";
				}

				$Overall_Score = get_comment_meta( $Comment->comment_ID, "rating", true );
				$Overall_Score = round(($Maximum_Score / 5) * $Overall_Score, 2);

				$post = array(
					'post_type' => 'urp_review',
					'post_status' => $status,
					'post_content' => $Comment->comment_content,
					'post_title' => "Review of " . $Product_Name,
					'post_date' => $Comment->comment_date
				);
				$Review_ID = wp_insert_post($post);
				$Conversion_IDs[$Comment->comment_ID] = $Review_ID;

				update_post_meta( $Review_ID, 'EWD_URP_Review_Weight', 1 );
				update_post_meta( $Review_ID, 'EWD_URP_Review_Karma', 0 );
				update_post_meta( $Review_ID, 'EWD_URP_Email_Confirmed', $Email_Confirmed );
				update_post_meta( $Review_ID, 'EWD_URP_Product_Name', $Product_Name );
				update_post_meta( $Review_ID, 'EWD_URP_Post_Author', $Comment->comment_author );

				update_post_meta( $Review_ID, "EWD_URP_Overall_Score", $Overall_Score );
			}
			else {
				if (isset($Conversion_IDs[$Comment->comment_parent])) {
					$comment_post_ID = $Conversion_IDs[$Comment->comment_parent];
					$Parent_ID = 0;
				}
				else {
					$comment_post_ID = $Comment_Data[$Comment->comment_parent]['Post_ID'];
					$Parent_ID = $Comment_Data[$Comment->comment_parent]['Comment_ID'];
				}

				$comment_args = array(
					'comment_post_ID' => $comment_post_ID,
					'comment_author' => $Comment->comment_author,
					'comment_author_email' => $Comment->comment_author_email,
					'comment_author_url' => $Comment->comment_author_url,
					'comment_content' => $Comment->comment_content,
					'comment_type' => $Comment->comment_type,
					'comment_parent' => $Parent_ID,
					'user_id' => $Comment->user_id,
					'comment_author_IP' => $Comment->comment_author_IP,
					'comment_agent' => $Comment->comment_agent,
					'comment_date' => $Comment->comment_date,
					'comment_approved' => $Comment->comment_approved
				);

				$New_Comment_ID = wp_insert_comment($comment_args);

				$Comment_Data[$Comment->comment_ID]['Post_ID'] = $comment_post_ID;
				$Comment_Data[$Comment->comment_ID]['Comment_ID'] = $New_Comment_ID;
			}
		}
	}

	$update_message = __("WooCommerce reviews have been succesfully imported.", 'ultimate-reviews');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}