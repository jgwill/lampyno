<?php
function EWD_URP_WooCommerce_Category_Sync() {
	$WC_Categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
    if ($WC_Categories) {
        usort($WC_Categories, "EWD_URP_Sort_Categories");
        foreach ($WC_Categories as $WC_Category) {
            EWD_URP_Match_WC_Cat($WC_Category);
        }
    }
}

add_action("edited_product_cat", "EWD_URP_Edit_WC_Imported_Category", 10, 1);
function EWD_URP_Edit_WC_Imported_Category($term_id) {
	$WC_Category = get_term_by("id", $term_id, "product_cat");
	$URP_Cat = get_terms(array('taxonomy' => 'urp-review-category', 'meta_key' => 'product_cat', 'meta_value' => $WC_Category->term_id, 'hide_empty' => false));
	if (empty($URP_Cat)) {EWD_URP_Match_WC_Cat($WC_Category);}
	else {EWD_URP_Update_WC_Cat($WC_Category, $URP_Cat[0]);}
}

function EWD_URP_Match_WC_Cat($WC_Category) {
	$URP_Cat = get_terms(array('taxonomy' => 'urp-review-category', 'meta_key' => 'product_cat', 'meta_value' => $WC_Category->term_id, 'hide_empty' => false));
    if (!empty($URP_Cat)) {return;}

    if ($WC_Category->parent != 0) {
    	$URP_Cat = get_terms(array('taxonomy' => 'urp-review-category', 'meta_key' => 'product_cat', 'meta_value' => $WC_Category->parent, 'hide_empty' => false));
    	if (!empty($URP_Cat)) {$Parent_ID = $URP_Cat[0]->term_id;}
    }
    if (!isset($Parent_ID)) {$Parent_ID = 0;}

    $New_URP_Cat = wp_insert_term($WC_Category->name, 'urp-review-category', array('parent' => $Parent_ID));
    $Response = update_term_meta($New_URP_Cat['term_id'], 'product_cat', $WC_Category->term_id);
}

function EWD_URP_Update_WC_Cat($WC_Category, $URP_Cat) {
	if ($Category->parent != 0) {
    	$URP_Cat = get_terms(array('taxonomy' => 'urp-review-category', 'meta_key' => 'product_cat', 'meta_value' => $Category->parent, 'hide_empty' => false));
    	$Parent_ID = $URP_Cat[0]->term_id;
    }
    else {$Parent_ID = 0;}
	wp_update_term($URP_Cat->term_id, 'urp-review-category', array('name' => $WC_Category->name, 'parent' => $Parent_ID, 'hide_empty' => false));
}

function EWD_URP_Sort_Categories($a, $b) {
    return $a->parent - $b->parent;
}

?>