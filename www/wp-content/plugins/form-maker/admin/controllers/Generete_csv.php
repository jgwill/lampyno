<?php

/**
 * Class FMControllerGenerete_csv
 */
class FMControllerGenerete_csv extends FMAdminController {

  /**
   * Execute.
   */
  public function execute() {
	  $this->display();
	  die();
  }

  /**
   * Display.
   */
  public function display() {
    // Get form maker settings
    $fm_settings = WDFMInstance(self::PLUGIN)->fm_settings;
    // Update export per_page.
    $page_num_update = WDW_FM_Library(self::PLUGIN)->get('page_num_update');
    if ( $page_num_update ) {
      $fm_settings['ajax_export_per_page'] = WDW_FM_Library(self::PLUGIN)->get('page_num');
      update_option( $option_key, $fm_settings );
    }
    $csv_delimiter = isset($fm_settings['csv_delimiter']) ? $fm_settings['csv_delimiter'] : ',';
    $form_id = (int) $_REQUEST['form_id'];
    $limitstart = (int) $_REQUEST['limitstart'];
    $send_header = (int) $_REQUEST['send_header'];
    $params = WDW_FM_Library(self::PLUGIN)->get_submissions_to_export();
	  if ( !empty($params) ) {
		$data = $params[0];
		$title = $params[1];
		if ( !empty( $data ) ) {
			$labels_parameters = WDW_FM_Library(self::PLUGIN)->get_labels_parameters( $form_id );

			$sorted_label_names_original = $labels_parameters[4];
			$sorted_label_names_original = array_merge(array(
														  'ID',
														  "Submit date",
														  "Submitter's IP",
														  "Submitter's Username",
														  "Submitter's Email Address",
														), $sorted_label_names_original);

			if (($key = array_search('stripe', $sorted_label_names_original)) !== false) {
				unset($sorted_label_names_original[$key]);
			}

			$sorted_label_names = array();
			function unique_label($sorted_label_names, $label) {
				if ( in_array($label, $sorted_label_names) ) {
				return unique_label($sorted_label_names, $label . '(1)');
				}
				else {
					return $label;
				}
			}
			foreach ( $sorted_label_names_original as $key => $label ) {
				$sorted_label_names[] = unique_label($sorted_label_names, $label);
			}

			foreach ( $data as $key => $row ) {
				$sorted_data = array();
				foreach ( $sorted_label_names as $label ) {
					if ( !array_key_exists($label, $row) ) {
						$sorted_data[$label] = '';
					}
					else {
						$sorted_data[$label] = $row[$label];
					}
				}
				$data[$key] = $sorted_data;
			}
			$upload_dir = wp_upload_dir();
			$file_path = $upload_dir['basedir'] . '/form-maker';
			if ( !is_dir($file_path) ) {
				mkdir($file_path, 0777);
			}
			$tempfile = $file_path . '/export' . $form_id . '.txt';
			if ( $limitstart == 0 && file_exists($tempfile) ) {
				unlink($tempfile);
			}
			$output = fopen($tempfile, "a");
			if ( $limitstart == 0 ) {
				foreach ($sorted_label_names_original as $i => $rec) {
					$sorted_label_names_original[$i] = ltrim($rec, '=+-@');
				}
				fputcsv($output, $sorted_label_names_original, $csv_delimiter);
			}
			foreach ( $data as $index => $record ) {
				foreach ( $record as $i => $rec ) {
					$record[$i] = ltrim($rec, '=+-@');
				}
				if ( !empty($index) ) {
					fputcsv($output, $record, $csv_delimiter);
				}
			}
			fclose($output);
			if ( $send_header == 1 ) {
				$txtfile = fopen($tempfile, "r");
				$txtfilecontent = fread($txtfile, filesize($tempfile));
				fclose($txtfile);
				$filename = $title . "_" . date('Ymd') . ".csv";
				header('Content-Encoding: UTF-8');
				header('content-type: application/csv; charset=UTF-8');
				header("Content-Disposition: attachment; filename=\"$filename\"");
				// Set UTF-8 BOM
				echo "\xEF\xBB\xBF";
				echo $txtfilecontent;
				unlink($tempfile);
			}
		}
  	}
  }
}
