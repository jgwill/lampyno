<?php
if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once EWD_URP_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
function EWD_URP_Export_To_Excel() {
	$InDepth_Reviews = get_option("EWD_URP_InDepth_Reviews");
    $Review_Categories_Array = get_option("EWD_URP_Review_Categories_Array");
    if (!is_array($Review_Categories_Array)) {$Review_Categories_Array = array();}

    $Default_Fields = array("Product Name (if applicable)", "Review Author", "Reviewer Email (if applicable)", "Review Title", "Review", "Review Image (if applicable)", "Review Video (if applicable)");

    foreach ($Review_Categories_Array as $Review_Categories_Item) {
        $Review_Cat_Types[$Review_Categories_Item['CategoryName']] = $Review_Categories_Item['CategoryType'];
    }

	
	// Instantiate a new PHPExcel object 
	$Spreadsheet = new Spreadsheet();  
	// Set the active Excel worksheet to sheet 0 
	$Spreadsheet->setActiveSheetIndex(0);  

	// Print out the regular order field labels
	$Spreadsheet->getActiveSheet()->setCellValue("A1", "Title");
	$Spreadsheet->getActiveSheet()->setCellValue("B1", "Author");
	$Spreadsheet->getActiveSheet()->setCellValue("C1", "Review");
	$Spreadsheet->getActiveSheet()->setCellValue("D1", "Score");
	$Spreadsheet->getActiveSheet()->setCellValue("E1", "Email");
	$Spreadsheet->getActiveSheet()->setCellValue("F1", "Product Name");
	$Spreadsheet->getActiveSheet()->setCellValue("G1", "Categories");

	$column = 'H';
	if ($InDepth_Reviews == "Yes") {
		foreach ($Review_Categories_Array as $Review_Categories_Item) {
			if (!in_array($Review_Categories_Item['CategoryName'], $Default_Fields)) {
    			$Spreadsheet->getActiveSheet()->setCellValue($column."1", $Review_Categories_Item['CategoryName']);
   				$column++;
   			}
		}
	}

	//start while loop to get data  
	$rowCount = 2;
	$params = array(
		'posts_per_page' => -1,
		'post_type' => 'urp_review'
	);
	$Posts = get_posts($params);
	foreach ($Posts as $Post)  
	{  
     	$Author = get_post_meta($Post->ID, "EWD_URP_Post_Author", true );
     	$Score = get_post_meta($Post->ID, "EWD_URP_Overall_Score", true );
     	$Email = get_post_meta($Post->ID, "EWD_URP_Post_Email", true );
     	$Product_Name = get_post_meta($Post->ID, "EWD_URP_Product_Name", true );

     	$Categories = get_the_terms($Post->ID, "urp-review-category");
     	$Category_String = '';
     	if (is_array($Categories)) {
     		foreach ($Categories  as $Category) {
     			$Category_String .= $Category->name . ",";
     		}
     		$Category_String = substr($Category_String, 0, -1);
     	}
     	else {$Category_String = "";}

     	$Spreadsheet->getActiveSheet()->setCellValue("A" . $rowCount, $Post->post_title);
		$Spreadsheet->getActiveSheet()->setCellValue("B" . $rowCount, $Author);
		$Spreadsheet->getActiveSheet()->setCellValue("C" . $rowCount, $Post->post_content);
		$Spreadsheet->getActiveSheet()->setCellValue("D" . $rowCount, $Score);
		$Spreadsheet->getActiveSheet()->setCellValue("E" . $rowCount, $Email);
		$Spreadsheet->getActiveSheet()->setCellValue("F" . $rowCount, $Product_Name);
		$Spreadsheet->getActiveSheet()->setCellValue("G" . $rowCount, $Category_String);

		$column = 'H';
		if ($InDepth_Reviews == "Yes") {
			foreach ($Review_Categories_Array as $Review_Categories_Item) {
				if (!in_array($Review_Categories_Item['CategoryName'], $Default_Fields)) {
    				$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, get_post_meta($Post->ID, "EWD_URP_" . $Review_Categories_Item['CategoryName'], true));
   					$column++;
   				}
			}
		}
			
    	$rowCount++;

    	unset($Category_String);
    	unset($Tag_String);
	} 

	$Format_Type = $_POST['Format_Type'];
	// Redirect output to a client’s web browser (Excel5) 
	if ($Format_Type == "CSV") {
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Review_Export.csv"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = new Csv($Spreadsheet);
		$objWriter->save('php://output');
	}
	else {
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Review_Export.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = new Xls($Spreadsheet);
		$objWriter->save('php://output');
	}

	die();

}
?>