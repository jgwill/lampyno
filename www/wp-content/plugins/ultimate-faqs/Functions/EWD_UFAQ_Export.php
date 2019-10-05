<?php
function EWD_UFAQ_Export_To_PDF() {

	// make sure that the request is coming from the admin form
    if ( ! isset( $_POST['EWD_UFAQ_Export_PDF_Nonce'] ) ) { return; }
    if ( ! wp_verify_nonce( $_POST['EWD_UFAQ_Export_PDF_Nonce'], 'EWD_UFAQ_Export_PDF' ) ) { return; }

		require_once(EWD_UFAQ_CD_PLUGIN_PATH . '/FPDF/fpdf.php');
		global $Category; /*Undefined Category variable at line 5 and 7*/
		// if ($Category != "EWD_UFAQ_ALL_CATEGORIES") {$category_array = array( 'taxonomy' => 'ufaq-category',
		// 																																			'field' => 'slug',
		// 																																			'terms' => $Category->slug
		// 																																		  );
		//
		// }

		$params = array(
			'posts_per_page' => -1,
			'post_type' => 'ufaq'
		);
		$faqs = get_posts($params);

		$PDFPasses = array("FirstPageRun", "SecondPageRun", "Final");
		foreach ($PDFPasses as $PDFRun) {
				$pdf = new FPDF();
				$pdf->AddPage();

				if ($PDFRun == "SecondPageRun" or $PDFRun == "Final") {
					  $pdf->SetFont('Arial','B',14);
						$pdf->Cell(20, 10, "Page #");
						$pdf->Cell(20, 10, "Article Title");
						$pdf->Ln();
						$pdf->SetFont('Arial','',12);

						foreach ($ToC as $entry) {
								$pdf->Cell(20, 5, "  " . $entry['page']);
								$pdf->MultiCell(0, 5, $entry['title']);
								$pdf->Ln();
						}

						unset($ToC);
				}

				foreach ($faqs as $faq) {
						$PostTitle = strip_tags(html_entity_decode($faq->post_title));

						$PostText = strip_tags(html_entity_decode($faq->post_content));
						$PostText = str_replace("&#91;", "[", $PostText);
						$PostText = str_replace("&#93;", "]", $PostText);

						$pdf->AddPage();

						$Entry['page'] = $pdf->page;
						$Entry['title'] = $PostTitle;

						$pdf->SetFont('Arial','B',15);
						$pdf->MultiCell(0, 10, $PostTitle);
						$pdf->Ln();
						$pdf->SetFont('Arial','',12);
						$pdf->MultiCell(0, 10, $PostText);

						$ToC[] = $Entry;
						unset($Entry);
				}

				if ($PDFRun == "FirstPageRun" or $PDFRun == "SecondPageRun") {
					  $pdf->Close();
				}

				if ($PDFRun == "Final") {
		 			  $pdf->Output('Ultimate-FAQ-Manual.pdf', 'D');
				}
		}
}

if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once EWD_UFAQ_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
function EWD_UFAQ_Export_To_Excel() {
	
	// make sure that the request is coming from the admin form
    if ( ! isset( $_POST['EWD_UFAQ_Export_Nonce'] ) ) { return; } 
    if ( ! wp_verify_nonce( $_POST['EWD_UFAQ_Export_Nonce'], 'EWD_UFAQ_Export' ) ) { return; }

	$FAQ_Fields_Array = get_option("EWD_UFAQ_FAQ_Fields");
	if (!is_array($FAQ_Fields_Array)) {$FAQ_Fields_Array = array();}

		// Instantiate a new PHPExcel object
		$Spreadsheet = new Spreadsheet();
		// Set the active Excel worksheet to sheet 0
		$Spreadsheet->setActiveSheetIndex(0);

		// Print out the regular order field labels
		$Spreadsheet->getActiveSheet()->setCellValue("A1", "Question");
		$Spreadsheet->getActiveSheet()->setCellValue("B1", "Answer");
		$Spreadsheet->getActiveSheet()->setCellValue("C1", "Categories");
		$Spreadsheet->getActiveSheet()->setCellValue("D1", "Tags");
		$Spreadsheet->getActiveSheet()->setCellValue("E1", "Post Date");

		$column = 'F';
		foreach ($FAQ_Fields_Array as $FAQ_Field_Item) {
     		$Spreadsheet->getActiveSheet()->setCellValue($column."1", $FAQ_Field_Item['FieldName']);
    		$column++;
		}  

		//start while loop to get data
		$rowCount = 2;
		$params = array(
			'posts_per_page' => -1,
			'post_type' => 'ufaq'
		);
		$Posts = get_posts($params);
		foreach ($Posts as $Post)
		{
    	 	$Categories = get_the_terms($Post->ID, "ufaq-category");
			$Category_String = '';
				if (is_array($Categories)) {
    	 		foreach ($Categories  as $Category) {
    	 			$Category_String .= $Category->name . ",";
    	 		}
    	 		$Category_String = substr($Category_String, 0, -1);
    	 	}
    	 	else {$Category_String = "";}

    	 	$Tags = get_the_terms($Post->ID, "ufaq-tag");
    	 	$Tag_String = ''; 
    	 	if (is_array($Tags)) {
    	 		foreach ($Tags  as $Tag) {
    	 			$Tag_String .= $Tag->name . ",";
    	 		}
    	 		$Tag_String = substr($Tag_String, 0, -1);
    	 	}
    	 	else {$Tag_String = "";}

    	 	$Spreadsheet->getActiveSheet()->setCellValue("A" . $rowCount, $Post->post_title);
			$Spreadsheet->getActiveSheet()->setCellValue("B" . $rowCount, $Post->post_content);
			$Spreadsheet->getActiveSheet()->setCellValue("C" . $rowCount, $Category_String);
			$Spreadsheet->getActiveSheet()->setCellValue("D" . $rowCount, $Tag_String);
			$Spreadsheet->getActiveSheet()->setCellValue("E" . $rowCount, $Post->post_date);

			$column = 'F';
			foreach ($FAQ_Fields_Array as $FAQ_Field_Item) {
     			$Value = get_post_meta($Post->ID, "Custom_Field_" . $FAQ_Field_Item['FieldID'], true);
     			$Spreadsheet->getActiveSheet()->setCellValue($column . $rowCount, $Value);
    			$column++;
			}  

    		$rowCount++;

    		unset($Category_String);
    		unset($Tag_String);
		}

		// Redirect output to a client’s web browser (Excel5)
		if (!isset($Format_Type) == "CSV") {
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="FAQ_Export.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = new Csv($Spreadsheet);
			$objWriter->save('php://output');
			die();
		}
		else {echo 'Printing spreadsheet<br><br><br><br>';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="FAQ_Export.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = new Xls($Spreadsheet);
			$objWriter->save('php://output');
			die();
		}

}
?>
