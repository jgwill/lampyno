<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the UPCP plugin */

// Returns the FAQs that are found for a specific search
function UFAQ_Search() {
    $response = do_shortcode("[ultimate-faqs search_string='" . strtolower(sanitize_text_field($_POST['Q'])) . "' include_category='" . sanitize_text_field($_POST['include_category']) . "' exclude_category='" . sanitize_text_field($_POST['exclude_category']) . "' orderby='" . sanitize_text_field($_POST['orderby']) . "' order='" . sanitize_text_field($_POST['order']) . "' post_count='" . sanitize_text_field($_POST['post_count']) . "' current_url='" . sanitize_text_field($_POST['current_url']) . "' faqs_only='" . sanitize_text_field($_POST['faqs_only']) . "' faq_page='" . sanitize_text_field($_POST['faq_page']) . "' ajax='Yes']");

    $ReturnArray['request_count'] =  sanitize_text_field($_POST['request_count']);
    $ReturnArray['message'] = $response;
    echo json_encode($ReturnArray);

    die();
}
add_action('wp_ajax_ufaq_search', 'UFAQ_Search');
add_action( 'wp_ajax_nopriv_ufaq_search', 'UFAQ_Search');

// Change the up and down votes for a particular FAQ
function EWD_UFAQ_Update_Rating() {
    $FAQ_ID = is_numeric($_POST['FAQ_ID']) ? sanitize_text_field($_POST['FAQ_ID']) : 0;
    $Vote_Type = $_POST['Vote_Type'];

    if ($Vote_Type == "Up") {
        $Up_Votes = get_post_meta($FAQ_ID, "FAQ_Up_Votes", true);
        update_post_meta($FAQ_ID, "FAQ_Up_Votes", $Up_Votes + 1);
        $Total_Score = get_post_meta($FAQ_ID, "FAQ_Total_Score", true);
        update_post_meta($FAQ_ID, "FAQ_Total_Score", $Total_Score + 1);
    }
    if ($Vote_Type == "Down") {
        $Down_Votes = get_post_meta($FAQ_ID, "FAQ_Down_Votes", true);
        update_post_meta($FAQ_ID, "FAQ_Down_Votes", $Down_Votes + 1);
        $Total_Score = get_post_meta($FAQ_ID, "FAQ_Total_Score", true);
        update_post_meta($FAQ_ID, "FAQ_Total_Score", $Total_Score - 1);
    }

    die();
}
add_action('wp_ajax_ufaq_update_rating', 'EWD_UFAQ_Update_Rating');
add_action( 'wp_ajax_nopriv_ufaq_update_rating', 'EWD_UFAQ_Update_Rating');

// Records the number of time an FAQ post is opened
function UFAQ_Record_View() {
    global $wpdb;
    $wpdb->show_errors();
    $post_id = substr($_POST['post_id'], 4, strrpos(sanitize_text_field($_POST['post_id']), "-") - 4);

    if (!is_numeric($post_id)) {return;}

    $Meta_ID = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='ufaq_view_count'", $post_id));
    if ($Meta_ID != "" and $Meta_ID != 0) {$wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value=meta_value+1 WHERE post_id=%d AND meta_key='ufaq_view_count'", $post_id));}
    else {$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->postmeta (post_id,meta_key,meta_value) VALUES (%d,'ufaq_view_count','1')", $post_id));}

    die();
}
add_action('wp_ajax_ufaq_record_view', 'UFAQ_Record_View');
add_action( 'wp_ajax_nopriv_ufaq_record_view', 'UFAQ_Record_View');

function EWD_UFAQ_Save_Order(){
    global $UFAQ_Full_Version;

    if (!is_array($_POST['ewd-ufaq-item']) or $UFAQ_Full_Version != "Yes") {return;}

    foreach ($_POST['ewd-ufaq-item'] as $Key=>$ID) {
        update_post_meta($ID, 'ufaq_order', $Key);
    }

    die();
}
add_action('wp_ajax_UFAQ_update_order','EWD_UFAQ_Save_Order');

function EWD_UFAQ_Add_WC_FAQs(){   
    $Post_ID = sanitize_text_field($_POST['Post_ID']);

    if (!is_numeric($Post_ID)) {return;}

    $Current_FAQs = get_post_meta($Post_ID, 'EWD_UFAQ_WC_Selected_FAQs', true );
    if (!is_array($Current_FAQs)) {$Current_FAQs = array();}

    $FAQs = json_decode(stripslashes_deep($_POST['FAQs']));
    if (!is_array($FAQs)) {$FAQs = array();}

    $Added_FAQs = array();
    foreach ($FAQs as $FAQ) {
        if (!in_array($FAQ, $Current_FAQs)) {
            $Current_FAQs[] = $FAQ;

            $FAQ_Post = get_post($FAQ);
            $Added_FAQs[] = array("ID" => $FAQ, "Name" => $FAQ_Post->post_title);
        }
    }

    update_post_meta($Post_ID, 'EWD_UFAQ_WC_Selected_FAQs', $Current_FAQs);

    echo json_encode($Added_FAQs);

    die();
}
add_action('wp_ajax_ewd_ufaq_add_wc_faqs','EWD_UFAQ_Add_WC_FAQs');

function EWD_UFAQ_Delete_WC_FAQs(){   
    $Post_ID = $_POST['Post_ID'];

    $Current_FAQs = get_post_meta($Post_ID, 'EWD_UFAQ_WC_Selected_FAQs', true );
    if (!is_array($Current_FAQs)) {$Current_FAQs = array();}

    $FAQs = json_decode(stripslashes_deep($_POST['FAQs']));
    if (!is_array($FAQs)) {$FAQs = array();}

    $Remaining_FAQs = array_diff($Current_FAQs, $FAQs);

    update_post_meta($Post_ID, 'EWD_UFAQ_WC_Selected_FAQs', $Remaining_FAQs);

    die();
}
add_action('wp_ajax_ewd_ufaq_delete_wc_faqs','EWD_UFAQ_Delete_WC_FAQs');

function EWD_UFAQ_WC_FAQ_Category() {   
    $Cat_ID = sanitize_text_field($_POST['Cat_ID']);
    
    $args = array("numberposts" => -1, "post_type" => 'ufaq');
    if ($Cat_ID != "") {
        $args['tax_query'] = array(array(
            'taxonomy' => 'ufaq-category',
            'terms' => $Cat_ID
            ));
    }
    $All_FAQs = get_posts($args);

    $ReturnString .= "<table class='form-table ewd-ufaq-faq-add-table'>";
    $ReturnString .= "<tr>";
    $ReturnString .= "<th>" . __("Add?", 'ultimate-faqs') . "</th>";
    $ReturnString .= "<th>" . __("FAQ", 'ultimate-faqs') . "</th>";
    $ReturnString .= "</tr>";
    foreach ($All_FAQs as $FAQ) {
        $ReturnString .= "<tr class='ewd-ufaq-faq-row' data-faqid='" . $FAQ->ID . "'>";
        $ReturnString .= "<td><input type='checkbox' class='ewd-ufaq-add-faq' name='Add_FAQs[]' value='" . $FAQ->ID . "'/></td>";
        $ReturnString .= "<td>" . $FAQ->post_title . "</td>";
        $ReturnString .= "</tr>";
    }
    $ReturnString .= "</table>";
    
    echo $ReturnString;

    die();
}
add_action('wp_ajax_ewd_ufaq_wc_faq_category','EWD_UFAQ_WC_FAQ_Category');

function EWD_UFAQ_Hide_Review_Ask() {   
    $Ask_Review_Date = sanitize_text_field($_POST['Ask_Review_Date']);

    if (get_option('EWD_UFAQ_Ask_Review_Date') < time()+3600*24*$Ask_Review_Date) {
        update_option('EWD_UFAQ_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);
    }

    die();
}
add_action('wp_ajax_ewd_ufaq_hide_review_ask','EWD_UFAQ_Hide_Review_Ask');

function EWD_UFAQ_Send_Feedback() {   
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";  
    $Feedback = sanitize_text_field($_POST['Feedback']);
    $Feedback .= '<br /><br />Email Address: ';
    $Feedback .= sanitize_text_field($_POST['EmailAddress']);

    wp_mail('contact@etoilewebdesign.com', 'UFAQ Feedback - Dashboard Form', $Feedback, $headers);

    die();
}
add_action('wp_ajax_ewd_ufaq_send_feedback','EWD_UFAQ_Send_Feedback');

function EWD_UFAQ_Dismiss_Pointers() {   
    $uid = get_current_user_id();
    $pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );

    $pointers[] = 'ufaq_admin_pointers_tutorial-one';
    $pointers[] = 'ufaq_admin_pointers_tutorial-two';
    $pointers[] = 'ufaq_admin_pointers_tutorial-three';
    $pointers[] = 'ufaq_admin_pointers_tutorial-four';
    $pointers[] = 'ufaq_admin_pointers_tutorial-five';
    $pointers[] = 'ufaq_admin_pointers_tutorial-six';
    
    $unique_pointers = array_unique($pointers);
    update_usermeta($uid, 'dismissed_wp_pointers', implode(",", $unique_pointers));
    
    die();
}
add_action('wp_ajax_ufaq-dismiss-wp-pointers','EWD_UFAQ_Dismiss_Pointers');

/* WELCOME SCREEN AJAX INSTALL FUNCTIONS */
function EWD_UFAQ_AJAX_Add_Category() {
    global $wpdb;

    $Category_Name = (isset($_POST['category_name']) ? stripslashes_deep($_POST['category_name']) : '');
    $Category_Description = (isset($_POST['category_description']) ? stripslashes_deep($_POST['category_description']) : '');

    $Category_Term_IDs = wp_insert_term( $Category_Name, 'ufaq-category', array('description' => $Category_Description) );

    echo json_encode(array('category_name' => $Category_Name, 'category_id' => $Category_Term_IDs['term_id']));

    exit();
}
add_action('wp_ajax_ewd_ufaq_welcome_add_category', 'EWD_UFAQ_AJAX_Add_Category');

function EWD_UFAQ_AJAX_Add_FAQ_Page() {
    wp_insert_post(array(
        'post_title' => (isset($_POST['faq_page_title']) ? stripslashes_deep($_POST['faq_page_title']) : ''),
        'post_content' => '<!-- wp:paragraph --><p> [ultimate-faqs] </p><!-- /wp:paragraph -->',
        'post_status' => 'publish',
        'post_type' => 'page'
    ));

    exit();
}
add_action('wp_ajax_ewd_ufaq_welcome_add_faq_page', 'EWD_UFAQ_AJAX_Add_FAQ_Page');

function EWD_UFAQ_AJAX_Set_Options() {
    update_option("EWD_UFAQ_FAQ_Accordion", $_POST['faq_accordion']);
    update_option("EWD_UFAQ_Toggle", $_POST['faq_toggle']);
    update_option("EWD_UFAQ_Group_By_Category", $_POST['group_by_category']);
    update_option("EWD_UFAQ_Order_By", $_POST['order_by_setting']);

    exit();
}
add_action('wp_ajax_ewd_ufaq_welcome_set_options', 'EWD_UFAQ_AJAX_Set_Options');

function EWD_UFAQ_AJAX_Add_FAQ() {
    $FAQ_Post_ID = wp_insert_post(array(
        'post_title' => (isset($_POST['faq_question']) ? stripslashes_deep($_POST['faq_question']) : ''),
        'post_content' => (isset($_POST['faq_answer']) ? stripslashes_deep($_POST['faq_answer']) : ''),
        'post_status' => 'publish',
        'post_type' => 'ufaq'
    ));


    if (isset($_POST['faq_category']) and $_POST['faq_category']) {
        wp_set_post_terms($FAQ_Post_ID, $_POST['faq_category'], 'ufaq-category');
    }

    exit();
}
add_action('wp_ajax_ewd_ufaq_welcome_add_faq', 'EWD_UFAQ_AJAX_Add_FAQ');