<?php 
function EWD_URP_Get_Review_Count($product_name) {
	$meta_query_array = array(
								array(
									'key' => 'EWD_URP_Product_Name',
									'value' => $product_name,
									'compare' => '=',
								)
							);

	$params = array('posts_per_page' => -1,
					'post_type' => 'urp_review',
					'meta_query' => $meta_query_array
					);
	
	$Posts = get_posts($params);

	return count($Posts);
}

function EWD_URP_Get_Aggregate_Score($product_name) {
	$meta_query_array = array(
								array(
									'key' => 'EWD_URP_Product_Name',
									'value' => $product_name,
									'compare' => '=',
								)
							);

	$params = array('posts_per_page' => -1,
					'post_type' => 'urp_review',
					'meta_query' => $meta_query_array
					);
	
	$Posts = get_posts($params);

	$Post_Count = 0;
	$Total_Score = 0;

	foreach ($Posts as $Post) {
		$Overall_Score = get_post_meta($Post->ID, 'EWD_URP_Overall_Score', true);

		$Post_Count++;
		$Total_Score += $Overall_Score;
	}

	if ($Post_Count > 0) {
		$Average_Score = $Total_Score / $Post_Count;
	}
	else {
		$Average_Score = "N/A";
	}

	return $Average_Score;
}

?>