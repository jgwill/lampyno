<?php
add_filter( 'block_categories', 'ewd_urp_add_block_category' );
function ewd_urp_add_block_category( $categories ) {
	$categories[] = array(
		'slug'  => 'ewd-urp-blocks',
		'title' => __( 'Ultimate Reviews', 'ultimate-reviews' ),
	);
	return $categories;
}

