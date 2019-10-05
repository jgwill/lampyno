<?php
// Add in a new column option for the URP post type
function EWD_URP_Columns_Head($defaults) {
	$Flag_Inappropriate = get_option("EWD_URP_Flag_Inappropriate");

    $defaults['urp_views'] = __('# of Views', 'ultimate-reviews');
	$defaults['urp_product'] = __('Product', 'ultimate-reviews');
	$defaults['urp_score'] = __('Score', 'ultimate-reviews');
	$defaults['urp_ID'] = __('Post ID', 'ultimate-reviews');
    if ($Flag_Inappropriate == "Yes") {$defaults['urp_flagged'] = __('Inappropriate Flag', 'ultimate-reviews');}

	return $defaults;
}
 
// Show the number of times the FAQ post has been clicked
function EWD_URP_Columns_Content($column_name, $post_ID) {
	if ($column_name == 'urp_views') {
		$num_views = EWD_URP_Get_Views($post_ID);
		echo $num_views;
	}

	if ($column_name == 'urp_product') {
		$product = EWD_URP_Get_Product_Name($post_ID);
		echo $product;
	}

	if ($column_name == 'urp_score') {
		$score = EWD_URP_Get_Overall_Score($post_ID);
		echo $score;
	}

	if ($column_name == 'urp_ID') {
		echo $post_ID;
	}

    if ($column_name == 'urp_flagged') {
        $score = EWD_URP_Get_Inappropriate_Flag($post_ID);
        echo $score;
    }
}

function EWD_URP_Register_Post_Column_Sortables( $column ) {
    $Flag_Inappropriate = get_option("EWD_URP_Flag_Inappropriate");

    $column['urp_views'] = 'urp_views';
    $column['urp_product'] = 'urp_product';
    $column['urp_score'] = 'urp_score';
    if ($Flag_Inappropriate == "Yes") {$column['urp_flagged'] = 'urp_flags';}

    return $column;
}

function EWD_URP_Sort_Views_Column( $vars ) 
{
    if ( isset( $vars['orderby'] ) && 'urp_views' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'urp_view_count', //Custom field key
            'orderby' => 'meta_value_num') //Custom field value (number)
        );
    }

    return $vars;
}

function EWD_URP_Sort_Product_Name_Column( $vars ) 
{
    if ( isset( $vars['orderby'] ) && 'urp_product' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'EWD_URP_Product_Name', //Custom field key
            'orderby' => 'meta_value') //Custom field value
        );
    }

    return $vars;
}

function EWD_URP_Sort_Overall_Score_Column( $vars ) 
{
    if ( isset( $vars['orderby'] ) && 'urp_score' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'EWD_URP_Overall_Score', //Custom field key
            'orderby' => 'meta_value_num') //Custom field value
        );
    }

    return $vars;
}

function EWD_URP_Sort_Flag_Inappropriate_Column( $vars ) 
{
    if ( isset( $vars['orderby'] ) && 'urp_flags' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'EWD_URP_Flag_Inappropriate', //Custom field key
            'orderby' => 'meta_value_num') //Custom field value
        );
    }

    return $vars;
}

// Get the number of times the FAQ post has been clicked
function EWD_URP_Get_Views($post_ID) {
	$URP_View_Count = get_post_meta($post_ID, 'urp_view_count', true);

	if ($URP_View_Count != "") {
		return $URP_View_Count;
	}
	else {
		return 0;
	}
}

function EWD_URP_Get_Product_Name($post_ID) {
	$URP_Product_Name = get_post_meta($post_ID, 'EWD_URP_Product_Name', true);

	if ($URP_Product_Name != "") {
		return $URP_Product_Name;
	}
	else {
		return "No Product Name";
	}
}

function EWD_URP_Get_Overall_Score($post_ID) {
	$URP_Overall_Score = get_post_meta($post_ID, 'EWD_URP_Overall_Score', true);

	if ($URP_Overall_Score != "") {
		return $URP_Overall_Score;
	}
	else {
		return "N/A";
	}
}

function EWD_URP_Get_Inappropriate_Flag($post_ID) {
    $URP_Flag_Inappropriate = get_post_meta($post_ID, 'EWD_URP_Flag_Inappropriate', true);

    if ($URP_Flag_Inappropriate != "") {
        return $URP_Flag_Inappropriate;
    }
    else {
        return "N/A";
    }
}

add_filter( 'parse_query', 'EWD_URP_Product_Name_Post_Filter' );
function EWD_URP_Product_Name_Post_Filter( $query )
{
    global $typenow;
    global $pagenow;

    if (!isset($typenow) or $typenow != 'urp_review') {return;}

    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['EWD_URP_Product_Name']) && $_GET['EWD_URP_Product_Name'] != '') {
        $query->query_vars['meta_value'] = $_GET['EWD_URP_Product_Name'];
        $query->query_vars['meta_key'] = "EWD_URP_Product_Name";
    }
}

add_action( 'restrict_manage_posts', 'EWD_URP_Product_Name_Post_Filter_Restrict_Manage_Posts' );
function EWD_URP_Product_Name_Post_Filter_Restrict_Manage_Posts()
{
    global $wpdb;
    global $typenow;

    if (!isset($typenow) or $typenow != 'urp_review') {return;}

    $sql = "SELECT DISTINCT " . $wpdb->postmeta . ".meta_value FROM " . $wpdb->postmeta . " INNER JOIN " . $wpdb->posts . " ON " . $wpdb->postmeta . ".post_id=" . $wpdb->posts . ".ID ";
    $sql .= "WHERE post_type='urp_review' AND " . $wpdb->postmeta . ".meta_key='EWD_URP_Product_Name' ORDER BY 1";
    $fields = $wpdb->get_results($sql, ARRAY_N);
?>
<select name="EWD_URP_Product_Name">
<option value=""><?php _e('Show All Products', 'ultimate-reviews'); ?></option>
<?php
    $current = isset($_GET['EWD_URP_Product_Name'])? $_GET['EWD_URP_Product_Name']:'';
    foreach ($fields as $field) {
        if (substr($field[0],0,1) != "_"){
        printf
            (
                '<option value="%s"%s>%s</option>',
                $field[0],
                selected($field[0] == $current, true, false),
                $field[0]
            );
        }
    }
?>
</select>
<?php
}

add_filter('manage_urp_review_posts_columns', 'EWD_URP_Columns_Head');
add_action('manage_urp_review_posts_custom_column', 'EWD_URP_Columns_Content', 10, 2);

add_filter( 'manage_edit-urp_review_sortable_columns', 'EWD_URP_Register_Post_Column_Sortables' );
add_filter( 'request', 'EWD_URP_Sort_Product_Name_Column' );
add_filter( 'request', 'EWD_URP_Sort_Flag_Inappropriate_Column' );
add_filter( 'request', 'EWD_URP_Sort_Views_Column' );
add_filter( 'request', 'EWD_URP_Sort_Views_Column' );

?>