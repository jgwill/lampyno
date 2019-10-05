<?php
	global $wpdb;

	$table_name3  = $wpdb->prefix . "totalsoft_cal_events";
	$table_name10 = $wpdb->prefix . "totalsoft_cal_events_p3";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	$sql10 = 'CREATE TABLE IF NOT EXISTS ' .$table_name10 . '( id INTEGER(10) UNSIGNED AUTO_INCREMENT, TotalSoftCal_EvCal VARCHAR(255) NOT NULL, TotalSoftCal_EvRec VARCHAR(255) NOT NULL, TotalSoftCal_Ev_01 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_02 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_03 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_04 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_05 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_06 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_07 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_08 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_09 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_10 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_11 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_12 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_13 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_14 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_15 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_16 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_17 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_18 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_19 VARCHAR(255) NOT NULL, TotalSoftCal_Ev_20 VARCHAR(255) NOT NULL, PRIMARY KEY (id))';

	dbDelta($sql10);
	$sqla10 = 'ALTER TABLE ' . $table_name10 . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	$wpdb->query($sqla10);

	$TotalSoftEventRec = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name10 WHERE id>%d",0));
	$TotalSoftEventCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));
	if(count($TotalSoftEventRec) == 0 && count($TotalSoftEventCount) != 0)
	{
		for($i = 0; $i < count($TotalSoftEventCount); $i++)
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name10 (id, TotalSoftCal_EvCal, TotalSoftCal_EvRec) VALUES (%d, %s, %s)", '', $TotalSoftEventCount[$i]->id, 'none'));
		}
	}
?>