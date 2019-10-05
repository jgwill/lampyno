<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the URP plugin */

// Returns the FAQs that are found for a specific search
function EWD_URP_Search() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    if (isset($_POST['Shortcode_ID']) and $_POST['Shortcode_ID'] != "undefined") {$shortcode_id = $_POST['Shortcode_ID'];}
    else {$shortcode_id = "";}
    if (isset($_POST['Q']) and $_POST['Q'] != "undefined") {$search_string = strtolower($_POST['Q']);}
    else {$search_string = "";}
    if (isset($_POST['product_name']) and $_POST['product_name'] != "undefined" and $_POST['product_name'] != "") {$product_name = $_POST['product_name'];}
    else {$product_name = "";}
    if (isset($_POST['review_author']) and $_POST['review_author'] != "undefined" and $_POST['review_author'] != "") {$review_author = $_POST['review_author'];}
    else {$review_author = "";}
    if (isset($_POST['custom_filters']) and $_POST['custom_filters'] != "undefined" and $_POST['custom_filters'] != "[]") {$custom_filters = $_POST['custom_filters'];}
    else {$custom_filters = "";}
    if (isset($_POST['min_score']) and $_POST['min_score'] != "" and $_POST['min_score'] != "undefined") {$min_score = $_POST['min_score'];}
    else {$min_score = 0;}
    if (isset($_POST['max_score']) and $_POST['max_score'] != "" and $_POST['max_score'] != "undefined") {$max_score = $_POST['max_score'];}
    else {$max_score = 1000000;}
    if (isset($_POST['orderby']) and $_POST['orderby'] != "undefined") {$orderby = $_POST['orderby'];}
    else {$orderby = "";}
    if (isset($_POST['order']) and $_POST['order'] != "undefined") {$order = $_POST['order'];}
    else {$order = "";}
    if (isset($_POST['post_count']) and $_POST['post_count'] != "" and $_POST['post_count'] != "undefined") {$post_count = $_POST['post_count'];}
    else {$post_count = -1;}
    if (isset($_POST['current_page']) and $_POST['current_page'] != "" and $_POST['current_page'] != "undefined") {$current_page = $_POST['current_page'];}
    else {$current_page = 1;}
    if (isset($_POST['only_reviews']) and $_POST['only_reviews'] != "" and $_POST['only_reviews'] != "undefined") {$only_reviews = $_POST['only_reviews'];}
    else {$only_reviews = "No";}
    /* echo "Q: " . $search_string . "<br />"; 
    echo "Name: " . $product_name . "-" . $_POST['product_name'] . "<br />"; 
    echo "Min: " . $min_score . "<br />";
    echo "Max: " . $max_score . "<br />";
    echo "OrderBy: " . $orderby . "<br />";
    echo "Order: " . $order . "<br />";
    echo "Post Count: " . $post_count . "<br />";
    echo "Current: " . $current_page . "<br />";
    echo "Only: " . $only_reviews . "<br />"; */ 
    echo do_shortcode("[ultimate-reviews shortcode_id='" . $shortcode_id . "' search_string='" . $search_string . "' min_score='" . $min_score . "' max_score='" . $max_score . "' product_name='" . $product_name . "' review_author='" . $review_author . "' custom_filters='" . $custom_filters . "' orderby='" . $orderby . "' order='" . $order . "' post_count='" . $post_count . "' only_reviews='" . $only_reviews . "' current_page='" . $current_page . "']") ;
}
add_action('wp_ajax_urp_search', 'EWD_URP_Search');
add_action( 'wp_ajax_nopriv_urp_search', 'EWD_URP_Search');

// Records the number of time a review post is opened
function EWD_URP_Record_View() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    global $wpdb;
    $wpdb->show_errors();
    $post_id = $_POST['post_id'];
    $Meta_ID = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='urp_view_count'", $post_id));
    if ($Meta_ID != "" and $Meta_ID != 0) {$wpdb->query($wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value=meta_value+1 WHERE post_id=%d AND meta_key='urp_view_count'", $post_id));}
    else {$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->postmeta (post_id,meta_key,meta_value) VALUES (%d,'urp_view_count','1')", $post_id));}

}
add_action('wp_ajax_urp_record_view', 'EWD_URP_Record_View');
add_action('wp_ajax_nopriv_urp_record_view', 'EWD_URP_Record_View');

function EWD_URP_Update_Karama() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    $Review_ID = $_POST['ReviewID'];
    $Direction = $_POST['Direction'];

    $Karma = get_post_meta( $Review_ID, 'EWD_URP_Review_Karma', true );

    if ($Direction == 'down') {update_post_meta( $Review_ID, 'EWD_URP_Review_Karma', $Karma - 1 );}
    else {update_post_meta( $Review_ID, 'EWD_URP_Review_Karma', $Karma + 1 );}

    $EWD_URP_Karma_IDs = unserialize(stripslashes($_COOKIE['EWD_URP_Karma_IDs']));
    $EWD_URP_Karma_IDs[] = $Review_ID;
    setcookie('EWD_URP_Karma_IDs', serialize($EWD_URP_Karma_IDs), time()+3600*24*365, '/');

}
add_action('wp_ajax_urp_update_karma', 'EWD_URP_Update_Karama');
add_action('wp_ajax_nopriv_urp_update_karma', 'EWD_URP_Update_Karama');

function EWD_URP_Get_Review_Body() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    $Thumbnail_Characters = get_option("EWD_URP_Thumbnail_Characters");

    $Review_ID = $_POST['ID'];
    echo "<span class='ewd-urp-ajax-read-more-content'>" . apply_filters('the_content', get_post_field('post_content', $Review_ID)) . "<span class='ewd-urp-ajax-read-less' data-thumbnailchars='" . $Thumbnail_Characters . "'>Read Less</span></span>";

    die();
}
add_action('wp_ajax_urp_thumbnail_ajax', 'EWD_URP_Get_Review_Body');
add_action('wp_ajax_nopriv_urp_thumbnail_ajax', 'EWD_URP_Get_Review_Body');

function EWD_URP_Flag_Inappropriate() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    $Review_ID = $_POST['ReviewID'];

    $Flags = get_post_meta( $Review_ID, 'EWD_URP_Flag_Inappropriate', true );

    update_post_meta( $Review_ID, 'EWD_URP_Flag_Inappropriate', $Flags + 1 );

    die();
}
add_action('wp_ajax_urp_flag_inappropriate', 'EWD_URP_Flag_Inappropriate');
add_action('wp_ajax_nopriv_urp_flag_inappropriate', 'EWD_URP_Flag_Inappropriate');

function EWD_URP_Send_Test_Email() {
    $Path = ABSPATH . 'wp-load.php';
    include_once($Path);

    $Email_Address = $_POST['Email_Address'];
    $Email_To_Send = $_POST['Email_To_Send'];

    $Email_Messages_Array = get_option("EWD_URP_Email_Messages_Array");
    if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}

    foreach ($Email_Messages_Array as $Email_Message_Item) {
        if ($Email_Message_Item['ID'] == $Email_To_Send) {
            $Message_Body = EWD_URP_Return_Email_Template($Email_Message_Item);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $Mail_Success = wp_mail($Email_Address, $Email_Message_Item['Name'], $Message_Body, $headers);
        }
    }

    if ($Mail_Success) {echo '<div class="ewd-urp-test-email-response">Success: Email has been sent successfully.</div>';}
    else {echo '<div class="ewd-urp-test-email-response">Error: Please check your email settings, or try using an SMTP email plugin to change email settings.</div>';}

    die();
}
add_action('wp_ajax_urp_send_test_email', 'EWD_URP_Send_Test_Email');

function EWD_URP_Hide_Review_Ask(){   
    $Ask_Review_Date = $_POST['Ask_Review_Date'];

    if (get_option('EWD_URP_Ask_Review_Date') < time()+3600*24*$Ask_Review_Date) {
        update_option('EWD_URP_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);
    }

    die();
}
add_action('wp_ajax_ewd_urp_hide_review_ask','EWD_URP_Hide_Review_Ask');

function EWD_URP_Send_Feedback() {   
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";  
    $Feedback = sanitize_text_field($_POST['Feedback']);
    $Feedback .= '<br /><br />Email Address: ';
    $Feedback .= sanitize_text_field($_POST['EmailAddress']);

    wp_mail('contact@etoilewebdesign.com', 'URP Feedback - Dashboard Form', $Feedback, $headers);

    die();
}
add_action('wp_ajax_ewd_urp_send_feedback','EWD_URP_Send_Feedback');

function EWD_URP_Hide_UWPM_Banner() {   
    $Time = time() + $_POST['hide_length'] * 24*3600;
    update_option("EWD_URP_UWPM_Ask_Time", $Time);

    die();
}
add_action('wp_ajax_ewd_urp_hide_uwpm_banner','EWD_URP_Hide_UWPM_Banner');

function EWD_URP_Dismiss_Pointers() {   
    $uid = get_current_user_id();
    $pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );

    $pointers[] = 'urp_admin_pointers_tutorial-one';
    $pointers[] = 'urp_admin_pointers_tutorial-two';
    $pointers[] = 'urp_admin_pointers_tutorial-three';
    $pointers[] = 'urp_admin_pointers_tutorial-four';
    $pointers[] = 'urp_admin_pointers_tutorial-five';
    $pointers[] = 'urp_admin_pointers_tutorial-six';
    
    $unique_pointers = array_unique($pointers);
    update_usermeta($uid, 'dismissed_wp_pointers', implode(",", $unique_pointers));
    
    die();
}
add_action('wp_ajax_urp-dismiss-wp-pointers','EWD_URP_Dismiss_Pointers');


/* WELCOME SCREEN AJAX INSTALL FUNCTIONS */
function EWD_URP_AJAX_Add_Submit_Review_Page() {
    wp_insert_post(array(
        'post_title' => (isset($_POST['submit_review_page_title']) ? stripslashes_deep($_POST['submit_review_page_title']) : ''),
        'post_content' => "<!-- wp:paragraph --><p> [submit-review] </p><!-- /wp:paragraph -->",
        'post_status' => 'publish',
        'post_type' => 'page'
    ));

    exit();
}
add_action('wp_ajax_ewd_urp_welcome_add_submit_review_page', 'EWD_URP_AJAX_Add_Submit_Review_Page');

function EWD_URP_AJAX_Add_Display_Review_Page() {
    wp_insert_post(array(
        'post_title' => (isset($_POST['display_review_page_title']) ? stripslashes_deep($_POST['display_review_page_title']) : ''),
        'post_content' => "<!-- wp:paragraph --><p> [ultimate-reviews] </p><!-- /wp:paragraph -->",
        'post_status' => 'publish',
        'post_type' => 'page'
    ));

    exit();
}
add_action('wp_ajax_ewd_urp_welcome_add_display_review_page', 'EWD_URP_AJAX_Add_Display_Review_Page');

function EWD_URP_AJAX_Set_Options() {
    update_option("EWD_URP_Maximum_Score", $_POST['maximum_score']);
    update_option("EWD_URP_Review_Score_Input", $_POST['review_score_input']);
    update_option("EWD_URP_Review_Category", $_POST['review_category']);
    update_option("EWD_URP_Review_Filtering", json_decode(stripslashes($_POST['review_filtering'])));

    exit();
}
add_action('wp_ajax_ewd_urp_welcome_set_options', 'EWD_URP_AJAX_Set_Options');

function EWD_URP_AJAX_Add_Category() {
    $Category_Name = (isset($_POST['category_name']) ? stripslashes_deep($_POST['category_name']) : '');
    $Category_Description = (isset($_POST['category_description']) ? stripslashes_deep($_POST['category_description']) : '');

    $Category_Term_IDs = wp_insert_term( $Category_Name, 'urp-review-category', array('description' => $Category_Description) );

    echo json_encode(array('category_name' => $Category_Name, 'category_id' => $Category_Term_IDs['term_id']));

    exit();
}
add_action('wp_ajax_ewd_urp_welcome_add_category', 'EWD_URP_AJAX_Add_Category');