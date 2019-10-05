<?php
add_filter( 'block_categories', 'ewd_ufaq_add_block_category' );
function ewd_ufaq_add_block_category( $categories ) {
	$categories[] = array(
		'slug'  => 'ewd-ufaq-blocks',
		'title' => __( 'Ultimate FAQs', 'ultimate-faqs' ),
	);
	return $categories;
}

