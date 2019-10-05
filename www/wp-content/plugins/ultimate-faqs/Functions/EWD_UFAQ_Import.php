<?php
// This function is used to import FAQ from another plugin

function EWD_UFAQ_Import(){
    global $wpdb;

    $Posts_Table_Name = $wpdb->prefix . "posts";
    $Sql = "SELECT ID FROM $Posts_Table_Name WHERE post_type='qa_faqs'";
    //$Sql = "SELECT ID FROM $Posts_Table_Name WHERE post_type='ufaq'";
    $Results = $wpdb->get_results($Sql);
    if (is_array($Results)){

        foreach($Results as $Result){

            $data_array = array('post_type' => 'ufaq');
            //$data_array = array('post_type' => 'qa_faqs');
            $where = array('ID' => $Result->ID);
            $wpdb->update($Posts_Table_Name, $data_array, $where);
        }
    }

    $Terms_Table_Name = $wpdb->prefix . "term_taxonomy";
    $data_array = array('taxonomy' => 'ufaq-category');
    $where = array('taxonomy' => 'faq_category');
    //$data_array = array('taxonomy' => 'faq_category');
    //$where = array('taxonomy' => 'ufaq-category');
    $wpdb->update($Terms_Table_Name, $data_array, $where);

    $args = array('post_type' => 'ufaq');
    $FAQs_Query = new WP_Query($args);
    $FAQs = $FAQs_Query->get_posts();

    foreach ($FAQs as $FAQ) {
        if (get_post_meta($FAQ->ID, 'ufaq_view_count', true) == "") {update_post_meta($FAQ->ID, 'ufaq_view_count', 0);}
    }

    echo $wpdb->last_query;
}

if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once EWD_UFAQ_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
function Add_EWD_UFAQs_From_Spreadsheet($Excel_File_Name){
    global $wpdb;

    // check that the current user has the correct privileges to create posts
    if ( ! current_user_can( 'edit_posts' ) ) { return; }

    // make sure that the request is coming from the admin form
    if ( ! isset( $_POST['EWD_UFAQ_Import_Nonce'] ) ) { return; }
    if ( ! wp_verify_nonce( $_POST['EWD_UFAQ_Import_Nonce'], 'EWD_UFAQ_Import' ) ) { return; }

    $FAQ_Fields_Array = get_option("EWD_UFAQ_FAQ_Fields");
    if (!is_array($FAQ_Fields_Array)) {$FAQ_Fields_Array = array();}

    $Excel_URL = EWD_UFAQ_CD_PLUGIN_PATH . 'faq-sheets/' . $Excel_File_Name;

    // Build the workbook object out of the uploaded spreadsheet
    $objWorkBook = \PhpOffice\PhpSpreadsheet\IOFactory::load($Excel_URL);

    // Create a worksheet object out of the product sheet in the workbook
    $sheet = $objWorkBook->getActiveSheet();

    $Allowable_Custom_Fields = array();
    foreach ($FAQ_Fields_Array as $FAQ_Field_Item) {$Allowable_Custom_Fields[] = $FAQ_Field_Item['FieldName'];}
    //List of fields that can be accepted via upload
    $Allowed_Fields = array("Question", "Answer", "Categories", "Tags", "Post Date");


    // Get column names
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    for ($column = 1; $column <= $highestColumnIndex; $column++) {
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Question") {$Question_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Answer") {$Answer_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Categories") {$Categories_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Tags") {$Tags_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Post Date") {$Date_Column = $column;}

        foreach ($FAQ_Fields_Array as $key => $FAQ_Field_Item) {
            if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == $FAQ_Field_Item['FieldName']) {$FAQ_Fields_Array[$key]['FieldColumn'] = $column;}
        }
    }


    // Put the spreadsheet data into a multi-dimensional array to facilitate processing
    $highestRow = $sheet->getHighestRow();
    for ($row = 2; $row <= $highestRow; $row++) {
        for ($column = 1; $column <= $highestColumnIndex; $column++) {
            $Data[$row][$column] = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        }
    }

    // Create the query to insert the products one at a time into the database and then run it
    foreach ($Data as $FAQ) {

        // Create an array of the values that are being inserted for each order,
        // edit if it's a current order, otherwise add it
        foreach ($FAQ as $Col_Index => $Value) {
            if ($Col_Index == $Question_Column and $Question_Column !== null) {$Post['post_title'] = esc_sql($Value);}
            if ($Col_Index == $Answer_Column and $Answer_Column !== null) {$Post['post_content'] = esc_sql($Value);}
            if ($Col_Index == $Categories_Column and $Categories_Column !== null) {$Post_Categories = explode(",", esc_sql($Value));}
            if ($Col_Index == $Tags_Column and $Tags_Column !== null) {$Post_Tags = explode(",", esc_sql($Value));}
            if (isset($Date_Column) and $Col_Index == $Date_Column and $Date_Column !== null) {$Post['post_date'] = esc_sql($Value);}
        }

        if (!is_array($Post_Categories)) {$Post_Categories = array();}
        if (!is_array($Post_Tags)) {$Post_Tags = array();}

        if ($Post['post_title'] == '') {continue;}

        $Post['post_status'] = 'publish';
        $Post['post_type'] = 'ufaq';

        $Post_ID = wp_insert_post($Post);
        if ($Post_ID != 0) {
            foreach ($Post_Categories as $Category) {
                $Term = term_exists($Category, 'ufaq-category');
                if ($Term !== 0 && $Term !== null) {$Category_IDs[] = (int) $Term['term_id'];}
            }
            if (isset($Category_IDs) and is_array($Category_IDs)) {wp_set_object_terms($Post_ID, $Category_IDs, 'ufaq-category');}
            foreach ($Post_Tags as $Tag) {
                $Term = term_exists($Tag, 'ufaq-tag');
                if ($Term !== 0 && $Term !== null) {$Tag_IDs[] = (int) $Term['term_id'];}
            }
            if (isset($Tag_IDs) and is_array($Tag_IDs)) {wp_set_object_terms($Post_ID, $Tag_IDs, 'ufaq-tag');}

            foreach ($FAQ_Fields_Array as $FAQ_Field_Item) {
                if (isset($FAQ_Field_Item['FieldColumn']) and isset($FAQ[$FAQ_Field_Item['FieldColumn']])) {
                    $Value = esc_sql($FAQ[$FAQ_Field_Item['FieldColumn']]);
                    update_post_meta($Post_ID, "Custom_Field_" . $FAQ_Field_Item['FieldID'], $Value);
                }
            }
        }

        unset($Post);
        unset($Post_Categories);
        unset($Post_Tags);
        unset($Category_IDs);
        unset($Tag_IDs);
    }

    return __("FAQs added successfully.", 'ultimate-faqs');
}

function EWD_UFAQ_Import_From_Spreadsheet() {

        /* Test if there is an error with the uploaded spreadsheet and return that error if there is */
        if (!empty($_FILES['FAQs_Spreadsheet']['error']))
        {
                switch($_FILES['FAQs_Spreadsheet']['error'])
                {

                case '1':
                        $error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'ultimate-faqs');
                        break;
                case '2':
                        $error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'ultimate-faqs');
                        break;
                case '3':
                        $error = __('The uploaded file was only partially uploaded', 'ultimate-faqs');
                        break;
                case '4':
                        $error = __('No file was uploaded.', 'ultimate-faqs');
                        break;

                case '6':
                        $error = __('Missing a temporary folder', 'ultimate-faqs');
                        break;
                case '7':
                        $error = __('Failed to write file to disk', 'ultimate-faqs');
                        break;
                case '8':
                        $error = __('File upload stopped by extension', 'ultimate-faqs');
                        break;
                case '999':
                        default:
                        $error = __('No error code avaiable', 'ultimate-faqs');
                }
        }
        /* Make sure that the file exists */
        elseif (empty($_FILES['FAQs_Spreadsheet']['tmp_name']) || $_FILES['FAQs_Spreadsheet']['tmp_name'] == 'none') {
                $error = __('No file was uploaded here..', 'ultimate-faqs');
        }
        /* Move the file and store the URL to pass it onwards*/
        /* Check that it is a .xls or .xlsx file */
        if(!isset($_FILES['FAQs_Spreadsheet']['name']) or (!preg_match("/\.(xls.?)$/", $_FILES['FAQs_Spreadsheet']['name']) and !preg_match("/\.(csv.?)$/", $_FILES['FAQs_Spreadsheet']['name']))) {
            $error = __('File must be .csv, .xls or .xlsx', 'ultimate-faqs');
        }
        else {
                        $filename = basename( $_FILES['FAQs_Spreadsheet']['name']);
                        $filename = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
                        $filename = mb_ereg_replace("([\.]{2,})", '', $filename);

                        //for security reason, we force to remove all uploaded file
                        $target_path = ABSPATH . "wp-content/plugins/ultimate-faqs/faq-sheets/";
                        //plugins_url("order-tracking/product-sheets/");

                        $target_path = $target_path . $filename;

                        if (!move_uploaded_file($_FILES['FAQs_Spreadsheet']['tmp_name'], $target_path)) {
                        //if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
                              $error .= "There was an error uploading the file, please try again!";
                        }
                        else {
                                $Excel_File_Name = $filename;
                        }
        }

        /* Pass the data to the appropriate function in Update_Admin_Databases.php to create the products */
        if (!isset($error)) {
                $user_update = Add_EWD_UFAQs_From_Spreadsheet($Excel_File_Name);
                return $user_update;
        }
        else {
                $output_error = array("Message_Type" => "Error", "Message" => $error);
                return $output_error;
        }
}
?>
