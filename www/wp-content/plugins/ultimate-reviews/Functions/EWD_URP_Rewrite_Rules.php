<?php
function EWD_URP_Rewrite_Rules() { 
	global $wp_rewrite;

	$frontpage_id = get_option('page_on_front');
		
    add_rewrite_tag('%urp_review_category_slug%','([^+]+)');
	
	add_rewrite_rule("review-category/([^+]*)/?$", "index.php?page_id=". $frontpage_id . "&urp_review_category_slug=\$matches[1]", 'top');
	add_rewrite_rule("(.?.+?)/review-category/([^+]*)/?$", "index.php?pagename=\$matches[1]&urp_review_category_slug=\$matches[2]", 'top');

	flush_rewrite_rules();
}

function EWD_URP_add_query_vars_filter( $vars ){
	$vars[] = "urp_review_category_slug";
	return $vars;
}


?>