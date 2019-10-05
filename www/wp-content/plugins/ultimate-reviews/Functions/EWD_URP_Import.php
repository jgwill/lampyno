<?php
// This function is used to import Reviews
if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once EWD_UFAQ_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
function Add_URP_Reviews_From_Spreadsheet($Excel_File_Name){
    global $wpdb;

    if ( ! isset( $_POST['URP_Admin_Action'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['URP_Admin_Action'], 'URP_Admin_Action' ) ) {return;}

    $InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
    $Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
    if (!is_array($Review_Categories_Array)) {$Review_Categories_Array = array();}

    foreach ($Review_Categories_Array as $Review_Categories_Item) {
        $Review_Cat_Types[$Review_Categories_Item['CategoryName']] = $Review_Categories_Item['CategoryType'];
    }

    $Excel_URL = '../wp-content/plugins/ultimate-reviews/review-sheets/' . $Excel_File_Name;

    // Build the workbook object out of the uploaded spredsheet
    $objWorkBook = \PhpOffice\PhpSpreadsheet\IOFactory::load($Excel_URL);

    // Create a worksheet object out of the product sheet in the workbook
    $sheet = $objWorkBook->getActiveSheet();

    $Allowable_Custom_Fields = array();
    //List of fields that can be accepted via upload
    $Allowed_Fields = array("Title", "Author", "Review", "Score", "Product Name", "Categories");

    // Get column names
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    for ($column = 1; $column <= $highestColumnIndex; $column++) {
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Title") {$Title_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Author") {$Author_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Review") {$Review_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Score") {$Score_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Email") {$Email_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Product Name") {$Name_Column = $column;}
        if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == "Categories") {$Categories_Column = $column;}
    }

    $Review_Cat_Columns = array();
    for ($column = 1; $column <= $highestColumnIndex; $column++) {
        //$Categories_Column = "";
        //$Score_Column = "";
        if ($Title_Column == $column or $Author_Column == $column or $Review_Column == $column or $Name_Column == $column or $Categories_Column == $column or $Score_Column == $column) {continue;}
        foreach ($Review_Categories_Array as $Review_Categories_Item) {
            if (trim($sheet->getCellByColumnAndRow($column, 1)->getValue()) == $Review_Categories_Item['CategoryName']) {$Review_Cat_Columns[$column] = $Review_Categories_Item['CategoryName'];}
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
    foreach ($Data as $Review) {

        // Create an array of the values that are being inserted for each order,
        // edit if it's a current order, otherwise add it
        $Field_Values = array();
        foreach ($Review as $Col_Index => $Value) {
            if ($Col_Index == $Title_Column) {$Post['post_title'] = esc_sql($Value);}
            elseif ($Col_Index == $Review_Column) {$Post['post_content'] = esc_sql($Value);}
            elseif ($Col_Index == $Name_Column) {$Product_Name = esc_sql($Value);}
            elseif ($Col_Index == $Author_Column) {$Author = esc_sql($Value);}
            elseif ($Col_Index == $Score_Column) {$Score = esc_sql($Value);}
            elseif ($Col_Index == $Email_Column) {$Email = esc_sql($Value);}
            elseif ($Col_Index == $Categories_Column) {$Post_Categories = explode(",", esc_sql($Value));}
            elseif (array_key_exists($Col_Index, $Review_Cat_Columns)) {$Field_Values[$Review_Cat_Columns[$Col_Index]] = esc_sql($Value);}
        }
        $Post['post_status'] = 'publish';
        $Post['post_type'] = 'urp_review';

        $post_id = wp_insert_post($Post);
        if ($post_id != 0) {
            update_post_meta($post_id, "EWD_URP_Product_Name", $Product_Name);
            update_post_meta($post_id, "EWD_URP_Post_Author", $Author);
            update_post_meta($post_id, "EWD_URP_Post_Email", $Email);
            update_post_meta($post_id, "EWD_URP_Email_Confirmed", "Yes");

            if (isset($Post_Categories) and is_array($Post_Categories)) {
                foreach ($Post_Categories as $Category) {
                    $Term = term_exists($Category, 'urp-review-category');
                    if ($Term !== 0 && $Term !== null) {$Category_IDs[] = (int) $Term['term_id'];}
                }
            }
            if (isset($Category_IDs) and is_array($Category_IDs)) {wp_set_object_terms($post_id, $Category_IDs, 'urp-review-category');}

            $Review_Item_Count = 0;
            $Total_Score = 0;
            foreach ($Review_Cat_Columns as $Column => $Category_Name) {
                if ($Review_Cat_Types[$Category_Name] == "ReviewItem") {$Total_Score += $Field_Values[$Category_Name]; $Review_Item_Count++;}
                update_post_meta($post_id, "EWD_URP_" . $Category_Name, $Field_Values[$Category_Name]);
            }

            if ($InDepth_Reviews == "Yes") {
                if ($Review_Item_Count != 0) {$Score = $Total_Score / $Review_Item_Count;}
                else {$Score = 0;}
            }
            update_post_meta($post_id, "EWD_URP_Overall_Score", $Score);
        }

        unset($Post);
        unset($Product_Name);
        unset($Author);
        unset($Score);
        unset($Post_Categories);
        unset($Category_IDs);
    }

    return __("Reviews added successfully.", 'ultimate-reviews');
}

function EWD_URP_Import_From_Spreadsheet() {

        /* Test if there is an error with the uploaded spreadsheet and return that error if there is */
        if (!empty($_FILES['Reviews_Spreadsheet']['error']))
        {
                switch($_FILES['Reviews_Spreadsheet']['error'])
                {

                case '1':
                        $error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'ultimate-reviews');
                        break;
                case '2':
                        $error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'ultimate-reviews');
                        break;
                case '3':
                        $error = __('The uploaded file was only partially uploaded', 'ultimate-reviews');
                        break;
                case '4':
                        $error = __('No file was uploaded.', 'ultimate-reviews');
                        break;

                case '6':
                        $error = __('Missing a temporary folder', 'ultimate-reviews');
                        break;
                case '7':
                        $error = __('Failed to write file to disk', 'ultimate-reviews');
                        break;
                case '8':
                        $error = __('File upload stopped by extension', 'ultimate-reviews');
                        break;
                case '999':
                        default:
                        $error = __('No error code avaiable', 'ultimate-reviews');
                }
        }
        /* Make sure that the file exists */
        elseif (empty($_FILES['Reviews_Spreadsheet']['tmp_name']) || $_FILES['Reviews_Spreadsheet']['tmp_name'] == 'none') {
                $error = __('No file was uploaded here..', 'ultimate-reviews');
        }
        /* Move the file and store the URL to pass it onwards*/
        /* Check that it is a .xls or .xlsx file */

        if(!isset($_FILES['Reviews_Spreadsheet']['name']) or (!preg_match("/\.(xls.?)$/", $_FILES['Reviews_Spreadsheet']['name']) and !preg_match("/\.(csv.?)$/", $_FILES['Reviews_Spreadsheet']['name']))) {
            $error = __('File must be .csv, .xls or .xlsx', 'ultimate-reviews');
        }
        else {
                      $msg = "";
                      $msg .= $_FILES['Reviews_Spreadsheet']['name'];
                        //for security reason, we force to remove all uploaded file
                        $target_path = ABSPATH . "wp-content/plugins/ultimate-reviews/review-sheets/";
                        //plugins_url("order-tracking/product-sheets/");

                        $target_path = $target_path . basename( $_FILES['Reviews_Spreadsheet']['name']);

                        if (!move_uploaded_file($_FILES['Reviews_Spreadsheet']['tmp_name'], $target_path)) {
                        //if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
                              $error .= "There was an error uploading the file, please try again!";
                        }
                        else {
                                $Excel_File_Name = basename( $_FILES['Reviews_Spreadsheet']['name']);
                        }
        }

        /* Pass the data to the appropriate function in Update_Admin_Databases.php to create the products */
        if (!isset($error)) {
                $user_update = Add_URP_Reviews_From_Spreadsheet($Excel_File_Name);
                return $user_update;
        }
        else {
                $output_error = array("Message_Type" => "Error", "Message" => $error);
                return $output_error;
        }
}
?>
