<?php

function EWD_URP_AJAX_Search($atts) {
    $ReturnString = "";

    // Get the attributes passed by the shortcode, and store them in new variables for processing
    extract( shortcode_atts( array(
            'product_name' => "",
            'show_on_load' => "Yes",
            'orderby' => "",
            'order' => "",
            'post_count' => -1),
            $atts
        )
    );

    $Search_Reviews_Label = get_option("EWD_URP_Search_Reviews_Label");
    if ($Search_Reviews_Label == "") {$Search_Reviews_Label =  __('Search Reviews', 'ultimate-reviews');}
    $Custom_CSS = '';
    $ReturnString .= "<style type='text/css'>";
    $ReturnString .= $Custom_CSS;
    $ReturnString .= "</style>";

    $ReturnString .= "<form action='#' method='post' id='urp-ajax-form' class='pure-form pure-form-aligned'>";
    $ReturnString .= "<input type='hidden' name='urp-input' value='Search'>";
    $ReturnString .= "<div id='ewd-urp-jquery-ajax-search' class='pure-control-group ui-front' style='position:relative;'>";
    $ReturnString .= "<label  id='urp-ajax-search-lbl' class='ewd-urp-field-label ewd-urp-bold'>" . $Search_Reviews_Label . ":</label>";
    $ReturnString .= "<input type='hidden' name'product_name' value='" . $product_name . "' id='urp-saerch-product-name' />";
    $ReturnString .= "<input type='hidden' name'orderby' value='" . $orderby . "' id='urp-search-orderby' />";
    $ReturnString .= "<input type='hidden' name'order' value='" . $order . "' id='urp-search-order' />";
    $ReturnString .= "<input type='hidden' name'post_count' value='" . $post_count . "' id='urp-search-post-count' />";
    $ReturnString .= "<input type='text' id='urp-ajax-text-input' class='urp-text-input' name='Question ' placeholder='" . $Search_Reviews_Label . "...'>";
    $ReturnString .= "</div>";
    $ReturnString .= "</form>";

    $ReturnString .= "<div id='urp-ajax-results'>";
    if ($show_on_load == "Yes") {$ReturnString .= do_shortcode("[ultimate-reviews product_name='" . $product_name . "' orderby='" . $orderby . "' order='" . $order . "' post_count='" . $post_count . "']");}
    $ReturnString .= "</div>";

    return $ReturnString;
}
if ($URP_Full_Version == "Yes") {add_shortcode("ultimate-review-search", "EWD_URP_AJAX_Search");}
?>
