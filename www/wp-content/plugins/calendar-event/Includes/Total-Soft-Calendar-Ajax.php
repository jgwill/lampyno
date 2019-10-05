<?php
	add_action( 'wp_ajax_TotalSoftCal_Edit', 'TotalSoftCal_Edit_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_Edit', 'TotalSoftCal_Edit_Callback' );

	function TotalSoftCal_Edit_Callback()
	{
		$Total_Soft_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name1 = $wpdb->prefix . "totalsoft_cal_1";
		$table_name4 = $wpdb->prefix . "totalsoft_cal_types";
		$table_name5 = $wpdb->prefix . "totalsoft_cal_2";
		$table_name7 = $wpdb->prefix . "totalsoft_cal_3";
		$table_name9 = $wpdb->prefix . "totalsoft_cal_4";

		$Total_Soft_Cal_Types = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id = %d", $Total_Soft_Cal_ID));

		if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Event Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Simple Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Flexible Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name7 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'TimeLine Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name9 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		print json_encode($Total_Soft_Cal);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_Edit1', 'TotalSoftCal_Edit1_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_Edit1', 'TotalSoftCal_Edit1_Callback' );

	function TotalSoftCal_Edit1_Callback()
	{
		$Total_Soft_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name8 = $wpdb->prefix . "totalsoft_cal_part";

		$Total_Soft_Cal_Part = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name8 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		print json_encode($Total_Soft_Cal_Part);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_Clone', 'TotalSoftCal_Clone_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_Clone', 'TotalSoftCal_Clone_Callback' );

	function TotalSoftCal_Clone_Callback()
	{
		$Total_Soft_Cal_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name  = $wpdb->prefix . "totalsoft_fonts";
		$table_name1 = $wpdb->prefix . "totalsoft_cal_1";
		$table_name2 = $wpdb->prefix . "totalsoft_cal_ids";
		$table_name3 = $wpdb->prefix . "totalsoft_cal_events";
		$table_name4 = $wpdb->prefix . "totalsoft_cal_types";
		$table_name5 = $wpdb->prefix . "totalsoft_cal_2";
		$table_name7 = $wpdb->prefix . "totalsoft_cal_3";
		$table_name8 = $wpdb->prefix . "totalsoft_cal_part";
		$table_name9 = $wpdb->prefix . "totalsoft_cal_4";

		$Total_Soft_Cal_Types = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id = %d", $Total_Soft_Cal_ID));

		if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Event Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Simple Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Flexible Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name7 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'TimeLine Calendar')
		{
			$Total_Soft_Cal = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name9 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));
		}

		$Total_Soft_Cal_Part = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name8 WHERE TotalSoftCal_ID = %s", $Total_Soft_Cal_ID));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, TotalSoftCal_Name, TotalSoftCal_Type) VALUES (%d, %s, %s)", '', $Total_Soft_Cal_Types[0]->TotalSoftCal_Name, $Total_Soft_Cal_Types[0]->TotalSoftCal_Type));

		$New_Cal_ID = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d order by id desc limit 1",0));
		$New_Total_SoftID = $New_Cal_ID[0]->id;
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name2 (id, Cal_ID) VALUES (%d, %s)", '', $New_Total_SoftID));

		if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Event Calendar')
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name1 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_BgCol, TotalSoftCal_GrCol, TotalSoftCal_GW, TotalSoftCal_BW, TotalSoftCal_BStyle, TotalSoftCal_BCol, TotalSoftCal_BSCol, TotalSoftCal_MW, TotalSoftCal_HBgCol, TotalSoftCal_HCol, TotalSoftCal_HFS, TotalSoftCal_HFF, TotalSoftCal_WBgCol, TotalSoftCal_WCol, TotalSoftCal_WFS, TotalSoftCal_WFF, TotalSoftCal_LAW, TotalSoftCal_LAWS, TotalSoftCal_LAWC, TotalSoftCal_DBgCol, TotalSoftCal_DCol, TotalSoftCal_DFS, TotalSoftCal_TBgCol, TotalSoftCal_TCol, TotalSoftCal_TFS, TotalSoftCal_TNBgCol, TotalSoftCal_HovBgCol, TotalSoftCal_HovCol, TotalSoftCal_NumPos, TotalSoftCal_WDStart, TotalSoftCal_RefIcCol, TotalSoftCal_RefIcSize, TotalSoftCal_ArrowType, TotalSoftCal_ArrowLeft, TotalSoftCal_ArrowRight, TotalSoftCal_ArrowCol, TotalSoftCal_ArrowSize, TotalSoftCal_BackIconType) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '' , $New_Total_SoftID, $Total_Soft_Cal[0]->TotalSoftCal_Name, $Total_Soft_Cal[0]->TotalSoftCal_Type, $Total_Soft_Cal[0]->TotalSoftCal_BgCol, $Total_Soft_Cal[0]->TotalSoftCal_GrCol, $Total_Soft_Cal[0]->TotalSoftCal_GW, $Total_Soft_Cal[0]->TotalSoftCal_BW, $Total_Soft_Cal[0]->TotalSoftCal_BStyle, $Total_Soft_Cal[0]->TotalSoftCal_BCol, $Total_Soft_Cal[0]->TotalSoftCal_BSCol, $Total_Soft_Cal[0]->TotalSoftCal_MW, $Total_Soft_Cal[0]->TotalSoftCal_HBgCol, $Total_Soft_Cal[0]->TotalSoftCal_HCol, $Total_Soft_Cal[0]->TotalSoftCal_HFS, $Total_Soft_Cal[0]->TotalSoftCal_HFF, $Total_Soft_Cal[0]->TotalSoftCal_WBgCol, $Total_Soft_Cal[0]->TotalSoftCal_WCol, $Total_Soft_Cal[0]->TotalSoftCal_WFS, $Total_Soft_Cal[0]->TotalSoftCal_WFF, $Total_Soft_Cal[0]->TotalSoftCal_LAW, $Total_Soft_Cal[0]->TotalSoftCal_LAWS, $Total_Soft_Cal[0]->TotalSoftCal_LAWC, $Total_Soft_Cal[0]->TotalSoftCal_DBgCol, $Total_Soft_Cal[0]->TotalSoftCal_DCol, $Total_Soft_Cal[0]->TotalSoftCal_DFS, $Total_Soft_Cal[0]->TotalSoftCal_TBgCol, $Total_Soft_Cal[0]->TotalSoftCal_TCol, $Total_Soft_Cal[0]->TotalSoftCal_TFS, $Total_Soft_Cal[0]->TotalSoftCal_TNBgCol, $Total_Soft_Cal[0]->TotalSoftCal_HovBgCol, $Total_Soft_Cal[0]->TotalSoftCal_HovCol, $Total_Soft_Cal[0]->TotalSoftCal_NumPos, $Total_Soft_Cal[0]->TotalSoftCal_WDStart, $Total_Soft_Cal[0]->TotalSoftCal_RefIcCol, $Total_Soft_Cal[0]->TotalSoftCal_RefIcSize, $Total_Soft_Cal[0]->TotalSoftCal_ArrowType, $Total_Soft_Cal[0]->TotalSoftCal_ArrowLeft, $Total_Soft_Cal[0]->TotalSoftCal_ArrowRight, $Total_Soft_Cal[0]->TotalSoftCal_ArrowCol, $Total_Soft_Cal[0]->TotalSoftCal_ArrowSize, $Total_Soft_Cal[0]->TotalSoftCal_BackIconType));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Simple Calendar')
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name5 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal2_WDStart, TotalSoftCal2_BW, TotalSoftCal2_BS, TotalSoftCal2_BC, TotalSoftCal2_W, TotalSoftCal2_H, TotalSoftCal2_BxShShow, TotalSoftCal2_BxShType, TotalSoftCal2_BxSh, TotalSoftCal2_BxShC, TotalSoftCal2_MBgC, TotalSoftCal2_MC, TotalSoftCal2_MFS, TotalSoftCal2_MFF, TotalSoftCal2_WBgC, TotalSoftCal2_WC, TotalSoftCal2_WFS, TotalSoftCal2_WFF, TotalSoftCal2_LAW_W, TotalSoftCal2_LAW_S, TotalSoftCal2_LAW_C, TotalSoftCal2_DBgC, TotalSoftCal2_DC, TotalSoftCal2_DFS, TotalSoftCal2_TdBgC, TotalSoftCal2_TdC, TotalSoftCal2_TdFS, TotalSoftCal2_EdBgC, TotalSoftCal2_EdC, TotalSoftCal2_EdFS, TotalSoftCal2_HBgC, TotalSoftCal2_HC, TotalSoftCal2_ArrType, TotalSoftCal2_ArrFS, TotalSoftCal2_ArrC, TotalSoftCal2_OmBgC, TotalSoftCal2_OmC, TotalSoftCal2_OmFS, TotalSoftCal2_Ev_HBgC, TotalSoftCal2_Ev_HC, TotalSoftCal2_Ev_HFS, TotalSoftCal2_Ev_HFF, TotalSoftCal2_Ev_HText, TotalSoftCal2_Ev_BBgC, TotalSoftCal2_Ev_TC, TotalSoftCal2_Ev_TFF, TotalSoftCal2_Ev_TFS) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $New_Total_SoftID, $Total_Soft_Cal[0]->TotalSoftCal_Name, $Total_Soft_Cal[0]->TotalSoftCal_Type, $Total_Soft_Cal[0]->TotalSoftCal2_WDStart, $Total_Soft_Cal[0]->TotalSoftCal2_BW, $Total_Soft_Cal[0]->TotalSoftCal2_BS, $Total_Soft_Cal[0]->TotalSoftCal2_BC, $Total_Soft_Cal[0]->TotalSoftCal2_W, $Total_Soft_Cal[0]->TotalSoftCal2_H, $Total_Soft_Cal[0]->TotalSoftCal2_BxShShow, $Total_Soft_Cal[0]->TotalSoftCal2_BxShType, $Total_Soft_Cal[0]->TotalSoftCal2_BxSh, $Total_Soft_Cal[0]->TotalSoftCal2_BxShC, $Total_Soft_Cal[0]->TotalSoftCal2_MBgC, $Total_Soft_Cal[0]->TotalSoftCal2_MC, $Total_Soft_Cal[0]->TotalSoftCal2_MFS, $Total_Soft_Cal[0]->TotalSoftCal2_MFF, $Total_Soft_Cal[0]->TotalSoftCal2_WBgC, $Total_Soft_Cal[0]->TotalSoftCal2_WC, $Total_Soft_Cal[0]->TotalSoftCal2_WFS, $Total_Soft_Cal[0]->TotalSoftCal2_WFF, $Total_Soft_Cal[0]->TotalSoftCal2_LAW_W, $Total_Soft_Cal[0]->TotalSoftCal2_LAW_S, $Total_Soft_Cal[0]->TotalSoftCal2_LAW_C, $Total_Soft_Cal[0]->TotalSoftCal2_DBgC, $Total_Soft_Cal[0]->TotalSoftCal2_DC, $Total_Soft_Cal[0]->TotalSoftCal2_DFS, $Total_Soft_Cal[0]->TotalSoftCal2_TdBgC, $Total_Soft_Cal[0]->TotalSoftCal2_TdC, $Total_Soft_Cal[0]->TotalSoftCal2_TdFS, $Total_Soft_Cal[0]->TotalSoftCal2_EdBgC, $Total_Soft_Cal[0]->TotalSoftCal2_EdC, $Total_Soft_Cal[0]->TotalSoftCal2_EdFS, $Total_Soft_Cal[0]->TotalSoftCal2_HBgC, $Total_Soft_Cal[0]->TotalSoftCal2_HC, $Total_Soft_Cal[0]->TotalSoftCal2_ArrType, $Total_Soft_Cal[0]->TotalSoftCal2_ArrFS, $Total_Soft_Cal[0]->TotalSoftCal2_ArrC, $Total_Soft_Cal[0]->TotalSoftCal2_OmBgC, $Total_Soft_Cal[0]->TotalSoftCal2_OmC, $Total_Soft_Cal[0]->TotalSoftCal2_OmFS, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_HBgC, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_HC, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_HFS, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_HFF, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_HText, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_BBgC, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_TC, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_TFF, $Total_Soft_Cal[0]->TotalSoftCal2_Ev_TFS));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'Flexible Calendar')
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name7 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal3_MW, TotalSoftCal3_WDStart, TotalSoftCal3_BgC, TotalSoftCal3_GrC, TotalSoftCal3_BBC, TotalSoftCal3_BoxShShow, TotalSoftCal3_BoxShType, TotalSoftCal3_BoxSh, TotalSoftCal3_BoxShC, TotalSoftCal3_H_BgC, TotalSoftCal3_H_BTW, TotalSoftCal3_H_BTC, TotalSoftCal3_H_FF, TotalSoftCal3_H_MFS, TotalSoftCal3_H_MC, TotalSoftCal3_H_YFS, TotalSoftCal3_H_YC, TotalSoftCal3_H_Format, TotalSoftCal3_Arr_Type, TotalSoftCal3_Arr_C, TotalSoftCal3_Arr_S, TotalSoftCal3_Arr_HC, TotalSoftCal3_LAH_W, TotalSoftCal3_LAH_C, TotalSoftCal3_WD_BgC, TotalSoftCal3_WD_C, TotalSoftCal3_WD_FS, TotalSoftCal3_WD_FF, TotalSoftCal3_D_BgC, TotalSoftCal3_D_C, TotalSoftCal3_TD_BgC, TotalSoftCal3_TD_C, TotalSoftCal3_HD_BgC, TotalSoftCal3_HD_C, TotalSoftCal3_ED_C, TotalSoftCal3_ED_HC, TotalSoftCal3_Ev_Format, TotalSoftCal3_Ev_BTW, TotalSoftCal3_Ev_BTC, TotalSoftCal3_Ev_BgC, TotalSoftCal3_Ev_C, TotalSoftCal3_Ev_FS, TotalSoftCal3_Ev_FF) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $New_Total_SoftID, $Total_Soft_Cal[0]->TotalSoftCal_Name, $Total_Soft_Cal[0]->TotalSoftCal_Type, $Total_Soft_Cal[0]->TotalSoftCal3_MW, $Total_Soft_Cal[0]->TotalSoftCal3_WDStart, $Total_Soft_Cal[0]->TotalSoftCal3_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_GrC, $Total_Soft_Cal[0]->TotalSoftCal3_BBC, $Total_Soft_Cal[0]->TotalSoftCal3_BoxShShow, $Total_Soft_Cal[0]->TotalSoftCal3_BoxShType, $Total_Soft_Cal[0]->TotalSoftCal3_BoxSh, $Total_Soft_Cal[0]->TotalSoftCal3_BoxShC, $Total_Soft_Cal[0]->TotalSoftCal3_H_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_H_BTW, $Total_Soft_Cal[0]->TotalSoftCal3_H_BTC, $Total_Soft_Cal[0]->TotalSoftCal3_H_FF, $Total_Soft_Cal[0]->TotalSoftCal3_H_MFS, $Total_Soft_Cal[0]->TotalSoftCal3_H_MC, $Total_Soft_Cal[0]->TotalSoftCal3_H_YFS, $Total_Soft_Cal[0]->TotalSoftCal3_H_YC, $Total_Soft_Cal[0]->TotalSoftCal3_H_Format, $Total_Soft_Cal[0]->TotalSoftCal3_Arr_Type, $Total_Soft_Cal[0]->TotalSoftCal3_Arr_C, $Total_Soft_Cal[0]->TotalSoftCal3_Arr_S, $Total_Soft_Cal[0]->TotalSoftCal3_Arr_HC, $Total_Soft_Cal[0]->TotalSoftCal3_LAH_W, $Total_Soft_Cal[0]->TotalSoftCal3_LAH_C, $Total_Soft_Cal[0]->TotalSoftCal3_WD_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_WD_C, $Total_Soft_Cal[0]->TotalSoftCal3_WD_FS, $Total_Soft_Cal[0]->TotalSoftCal3_WD_FF, $Total_Soft_Cal[0]->TotalSoftCal3_D_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_D_C, $Total_Soft_Cal[0]->TotalSoftCal3_TD_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_TD_C, $Total_Soft_Cal[0]->TotalSoftCal3_HD_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_HD_C, $Total_Soft_Cal[0]->TotalSoftCal3_ED_C, $Total_Soft_Cal[0]->TotalSoftCal3_ED_HC, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_Format, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_BTW, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_BTC, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_BgC, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_C, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_FS, $Total_Soft_Cal[0]->TotalSoftCal3_Ev_FF));
		}
		else if($Total_Soft_Cal_Types[0]->TotalSoftCal_Type == 'TimeLine Calendar')
		{
			$wpdb->query($wpdb->prepare("INSERT INTO $table_name9 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal4_01, TotalSoftCal4_02, TotalSoftCal4_03, TotalSoftCal4_04, TotalSoftCal4_05, TotalSoftCal4_06, TotalSoftCal4_07, TotalSoftCal4_08, TotalSoftCal4_09, TotalSoftCal4_10, TotalSoftCal4_11, TotalSoftCal4_12, TotalSoftCal4_13, TotalSoftCal4_14, TotalSoftCal4_15, TotalSoftCal4_16, TotalSoftCal4_17, TotalSoftCal4_18, TotalSoftCal4_19, TotalSoftCal4_20, TotalSoftCal4_21, TotalSoftCal4_22, TotalSoftCal4_23, TotalSoftCal4_24, TotalSoftCal4_25, TotalSoftCal4_26, TotalSoftCal4_27, TotalSoftCal4_28, TotalSoftCal4_29, TotalSoftCal4_30, TotalSoftCal4_31, TotalSoftCal4_32, TotalSoftCal4_33, TotalSoftCal4_34, TotalSoftCal4_35, TotalSoftCal4_36, TotalSoftCal4_37, TotalSoftCal4_38, TotalSoftCal4_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $New_Total_SoftID, $Total_Soft_Cal[0]->TotalSoftCal_Name, $Total_Soft_Cal[0]->TotalSoftCal_Type, $Total_Soft_Cal[0]->TotalSoftCal4_01, $Total_Soft_Cal[0]->TotalSoftCal4_02, $Total_Soft_Cal[0]->TotalSoftCal4_03, $Total_Soft_Cal[0]->TotalSoftCal4_04, $Total_Soft_Cal[0]->TotalSoftCal4_05, $Total_Soft_Cal[0]->TotalSoftCal4_06, $Total_Soft_Cal[0]->TotalSoftCal4_07, $Total_Soft_Cal[0]->TotalSoftCal4_08, $Total_Soft_Cal[0]->TotalSoftCal4_09, $Total_Soft_Cal[0]->TotalSoftCal4_10, $Total_Soft_Cal[0]->TotalSoftCal4_11, $Total_Soft_Cal[0]->TotalSoftCal4_12, $Total_Soft_Cal[0]->TotalSoftCal4_13, $Total_Soft_Cal[0]->TotalSoftCal4_14, $Total_Soft_Cal[0]->TotalSoftCal4_15, $Total_Soft_Cal[0]->TotalSoftCal4_16, $Total_Soft_Cal[0]->TotalSoftCal4_17, $Total_Soft_Cal[0]->TotalSoftCal4_18, $Total_Soft_Cal[0]->TotalSoftCal4_19, $Total_Soft_Cal[0]->TotalSoftCal4_20, $Total_Soft_Cal[0]->TotalSoftCal4_21, $Total_Soft_Cal[0]->TotalSoftCal4_22, $Total_Soft_Cal[0]->TotalSoftCal4_23, $Total_Soft_Cal[0]->TotalSoftCal4_24, $Total_Soft_Cal[0]->TotalSoftCal4_25, $Total_Soft_Cal[0]->TotalSoftCal4_26, $Total_Soft_Cal[0]->TotalSoftCal4_27, $Total_Soft_Cal[0]->TotalSoftCal4_28, $Total_Soft_Cal[0]->TotalSoftCal4_29, $Total_Soft_Cal[0]->TotalSoftCal4_30, $Total_Soft_Cal[0]->TotalSoftCal4_31, $Total_Soft_Cal[0]->TotalSoftCal4_32, $Total_Soft_Cal[0]->TotalSoftCal4_33, $Total_Soft_Cal[0]->TotalSoftCal4_34, $Total_Soft_Cal[0]->TotalSoftCal4_35, $Total_Soft_Cal[0]->TotalSoftCal4_36, $Total_Soft_Cal[0]->TotalSoftCal4_37, $Total_Soft_Cal[0]->TotalSoftCal4_38, $Total_Soft_Cal[0]->TotalSoftCal4_39));
		}

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name8 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_01, TotalSoftCal_02, TotalSoftCal_03, TotalSoftCal_04, TotalSoftCal_05, TotalSoftCal_06, TotalSoftCal_07, TotalSoftCal_08, TotalSoftCal_09, TotalSoftCal_10, TotalSoftCal_11, TotalSoftCal_12, TotalSoftCal_13, TotalSoftCal_14, TotalSoftCal_15, TotalSoftCal_16, TotalSoftCal_17, TotalSoftCal_18, TotalSoftCal_19, TotalSoftCal_20, TotalSoftCal_21, TotalSoftCal_22, TotalSoftCal_23, TotalSoftCal_24, TotalSoftCal_25, TotalSoftCal_26, TotalSoftCal_27, TotalSoftCal_28, TotalSoftCal_29, TotalSoftCal_30) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $New_Total_SoftID, $Total_Soft_Cal_Part[0]->TotalSoftCal_Name, $Total_Soft_Cal_Part[0]->TotalSoftCal_Type, $Total_Soft_Cal_Part[0]->TotalSoftCal_01, $Total_Soft_Cal_Part[0]->TotalSoftCal_02, $Total_Soft_Cal_Part[0]->TotalSoftCal_03, $Total_Soft_Cal_Part[0]->TotalSoftCal_04, $Total_Soft_Cal_Part[0]->TotalSoftCal_05, $Total_Soft_Cal_Part[0]->TotalSoftCal_06, $Total_Soft_Cal_Part[0]->TotalSoftCal_07, $Total_Soft_Cal_Part[0]->TotalSoftCal_08, $Total_Soft_Cal_Part[0]->TotalSoftCal_09, $Total_Soft_Cal_Part[0]->TotalSoftCal_10, $Total_Soft_Cal_Part[0]->TotalSoftCal_11, $Total_Soft_Cal_Part[0]->TotalSoftCal_12, $Total_Soft_Cal_Part[0]->TotalSoftCal_13, $Total_Soft_Cal_Part[0]->TotalSoftCal_14, $Total_Soft_Cal_Part[0]->TotalSoftCal_15, $Total_Soft_Cal_Part[0]->TotalSoftCal_16, $Total_Soft_Cal_Part[0]->TotalSoftCal_17, $Total_Soft_Cal_Part[0]->TotalSoftCal_18, $Total_Soft_Cal_Part[0]->TotalSoftCal_19, $Total_Soft_Cal_Part[0]->TotalSoftCal_20, $Total_Soft_Cal_Part[0]->TotalSoftCal_21, $Total_Soft_Cal_Part[0]->TotalSoftCal_22, $Total_Soft_Cal_Part[0]->TotalSoftCal_23, $Total_Soft_Cal_Part[0]->TotalSoftCal_24, $Total_Soft_Cal_Part[0]->TotalSoftCal_25, $Total_Soft_Cal_Part[0]->TotalSoftCal_26, $Total_Soft_Cal_Part[0]->TotalSoftCal_27, $Total_Soft_Cal_Part[0]->TotalSoftCal_28, $Total_Soft_Cal_Part[0]->TotalSoftCal_29, $Total_Soft_Cal_Part[0]->TotalSoftCal_30));
		die();
	}

	add_action( 'wp_ajax_Total_Soft_Cal_Prev', 'Total_Soft_Cal_Prev_Callback' );
	add_action( 'wp_ajax_nopriv_Total_Soft_Cal_Prev', 'Total_Soft_Cal_Prev_Callback' );

	function Total_Soft_Cal_Prev_Callback()
	{
		$CalEvent_TSet = json_decode(stripcslashes(sanitize_text_field($_POST['foobar'])));
		global $wpdb;
		$table_name01 = $wpdb->prefix . "totalsoft_cal_p1";
		$table_name02 = $wpdb->prefix . "totalsoft_cal_p2";
		$table_name03 = $wpdb->prefix . "totalsoft_cal_p3";
		$table_name04 = $wpdb->prefix . "totalsoft_cal_p4";
		$table_name08 = $wpdb->prefix . "totalsoft_cal_part1";

		$TS_Cal_Set01 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name01 WHERE id > %d order by id", 0));
		$TS_Cal_Set02 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name02 WHERE id > %d order by id", 0));
		$TS_Cal_Set03 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name03 WHERE id > %d order by id", 0));
		$TS_Cal_Set04 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name04 WHERE id > %d order by id", 0));
		$TS_Cal_Setp1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name08 WHERE id > %d order by id", 0));

		if($CalEvent_TSet[1] == 'Event Calendar')
		{
			if($TS_Cal_Set01 && !empty($TS_Cal_Set01))
			{
				$wpdb->query($wpdb->prepare("UPDATE $table_name01 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_BgCol = %s, TotalSoftCal_GrCol = %s, TotalSoftCal_GW = %s, TotalSoftCal_BW = %s, TotalSoftCal_BStyle = %s, TotalSoftCal_BCol = %s, TotalSoftCal_BSCol = %s, TotalSoftCal_MW = %s, TotalSoftCal_HBgCol = %s, TotalSoftCal_HCol = %s, TotalSoftCal_HFS = %s, TotalSoftCal_HFF = %s, TotalSoftCal_WBgCol = %s, TotalSoftCal_WCol = %s, TotalSoftCal_WFS = %s, TotalSoftCal_WFF = %s, TotalSoftCal_LAW = %s, TotalSoftCal_LAWS = %s, TotalSoftCal_LAWC = %s, TotalSoftCal_DBgCol = %s, TotalSoftCal_DCol = %s, TotalSoftCal_DFS = %s, TotalSoftCal_TBgCol = %s, TotalSoftCal_TCol = %s, TotalSoftCal_TFS = %s, TotalSoftCal_TNBgCol = %s, TotalSoftCal_HovBgCol = %s, TotalSoftCal_HovCol = %s, TotalSoftCal_NumPos = %s, TotalSoftCal_WDStart = %s, TotalSoftCal_RefIcCol = %s, TotalSoftCal_RefIcSize = %s, TotalSoftCal_ArrowType = %s, TotalSoftCal_ArrowLeft = %s, TotalSoftCal_ArrowRight = %s, TotalSoftCal_ArrowCol = %s, TotalSoftCal_ArrowSize = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], 0));

				$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], '', '', $CalEvent_TSet[45], $CalEvent_TSet[46], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0));
			}
			else
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name01 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_BgCol, TotalSoftCal_GrCol, TotalSoftCal_GW, TotalSoftCal_BW, TotalSoftCal_BStyle, TotalSoftCal_BCol, TotalSoftCal_BSCol, TotalSoftCal_MW, TotalSoftCal_HBgCol, TotalSoftCal_HCol, TotalSoftCal_HFS, TotalSoftCal_HFF, TotalSoftCal_WBgCol, TotalSoftCal_WCol, TotalSoftCal_WFS, TotalSoftCal_WFF, TotalSoftCal_LAW, TotalSoftCal_LAWS, TotalSoftCal_LAWC, TotalSoftCal_DBgCol, TotalSoftCal_DCol, TotalSoftCal_DFS, TotalSoftCal_TBgCol, TotalSoftCal_TCol, TotalSoftCal_TFS, TotalSoftCal_TNBgCol, TotalSoftCal_HovBgCol, TotalSoftCal_HovCol, TotalSoftCal_NumPos, TotalSoftCal_WDStart, TotalSoftCal_RefIcCol, TotalSoftCal_RefIcSize, TotalSoftCal_ArrowType, TotalSoftCal_ArrowLeft, TotalSoftCal_ArrowRight, TotalSoftCal_ArrowCol, TotalSoftCal_ArrowSize) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '' , '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38]));

				if($TS_Cal_Setp1 && !empty($TS_Cal_Setp1))
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], '', '', $CalEvent_TSet[45], $CalEvent_TSet[46], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0));
				}
				else
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name08 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_01, TotalSoftCal_02, TotalSoftCal_03, TotalSoftCal_04, TotalSoftCal_05, TotalSoftCal_06, TotalSoftCal_07, TotalSoftCal_08, TotalSoftCal_09, TotalSoftCal_10, TotalSoftCal_11, TotalSoftCal_12, TotalSoftCal_13, TotalSoftCal_14, TotalSoftCal_15, TotalSoftCal_16, TotalSoftCal_17, TotalSoftCal_18, TotalSoftCal_19, TotalSoftCal_20, TotalSoftCal_21, TotalSoftCal_22, TotalSoftCal_23, TotalSoftCal_24, TotalSoftCal_25, TotalSoftCal_26, TotalSoftCal_27, TotalSoftCal_28, TotalSoftCal_29, TotalSoftCal_30) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], '', '', $CalEvent_TSet[45], $CalEvent_TSet[46], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''));
				}
			}
		}
		else if($CalEvent_TSet[1] == 'Simple Calendar')
		{
			if($TS_Cal_Set02 && !empty($TS_Cal_Set02))
			{
				$wpdb->query($wpdb->prepare("UPDATE $table_name02 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal2_WDStart = %s, TotalSoftCal2_BW = %s, TotalSoftCal2_BS = %s, TotalSoftCal2_BC = %s, TotalSoftCal2_W = %s, TotalSoftCal2_H = %s, TotalSoftCal2_BxShShow = %s, TotalSoftCal2_BxShType = %s, TotalSoftCal2_BxSh = %s, TotalSoftCal2_BxShC = %s, TotalSoftCal2_MBgC = %s, TotalSoftCal2_MC = %s, TotalSoftCal2_MFS = %s, TotalSoftCal2_MFF = %s, TotalSoftCal2_WBgC = %s, TotalSoftCal2_WC = %s, TotalSoftCal2_WFS = %s, TotalSoftCal2_WFF = %s, TotalSoftCal2_LAW_W = %s, TotalSoftCal2_LAW_S = %s, TotalSoftCal2_LAW_C = %s, TotalSoftCal2_DBgC = %s, TotalSoftCal2_DC = %s, TotalSoftCal2_DFS = %s, TotalSoftCal2_TdBgC = %s, TotalSoftCal2_TdC = %s, TotalSoftCal2_TdFS = %s, TotalSoftCal2_EdBgC = %s, TotalSoftCal2_EdC = %s, TotalSoftCal2_EdFS = %s, TotalSoftCal2_HBgC = %s, TotalSoftCal2_HC = %s, TotalSoftCal2_ArrType = %s, TotalSoftCal2_ArrFS = %s, TotalSoftCal2_ArrC = %s, TotalSoftCal2_OmBgC = %s, TotalSoftCal2_OmC = %s, TotalSoftCal2_OmFS = %s, TotalSoftCal2_Ev_HBgC = %s, TotalSoftCal2_Ev_HC = %s, TotalSoftCal2_Ev_HFS = %s, TotalSoftCal2_Ev_HFF = %s, TotalSoftCal2_Ev_HText = %s, TotalSoftCal2_Ev_BBgC = %s, TotalSoftCal2_Ev_TC = %s, TotalSoftCal2_Ev_TFF = %s, TotalSoftCal2_Ev_TFS = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], 0));

				$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0));
			}
			else
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name02 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal2_WDStart, TotalSoftCal2_BW, TotalSoftCal2_BS, TotalSoftCal2_BC, TotalSoftCal2_W, TotalSoftCal2_H, TotalSoftCal2_BxShShow, TotalSoftCal2_BxShType, TotalSoftCal2_BxSh, TotalSoftCal2_BxShC, TotalSoftCal2_MBgC, TotalSoftCal2_MC, TotalSoftCal2_MFS, TotalSoftCal2_MFF, TotalSoftCal2_WBgC, TotalSoftCal2_WC, TotalSoftCal2_WFS, TotalSoftCal2_WFF, TotalSoftCal2_LAW_W, TotalSoftCal2_LAW_S, TotalSoftCal2_LAW_C, TotalSoftCal2_DBgC, TotalSoftCal2_DC, TotalSoftCal2_DFS, TotalSoftCal2_TdBgC, TotalSoftCal2_TdC, TotalSoftCal2_TdFS, TotalSoftCal2_EdBgC, TotalSoftCal2_EdC, TotalSoftCal2_EdFS, TotalSoftCal2_HBgC, TotalSoftCal2_HC, TotalSoftCal2_ArrType, TotalSoftCal2_ArrFS, TotalSoftCal2_ArrC, TotalSoftCal2_OmBgC, TotalSoftCal2_OmC, TotalSoftCal2_OmFS, TotalSoftCal2_Ev_HBgC, TotalSoftCal2_Ev_HC, TotalSoftCal2_Ev_HFS, TotalSoftCal2_Ev_HFF, TotalSoftCal2_Ev_HText, TotalSoftCal2_Ev_BBgC, TotalSoftCal2_Ev_TC, TotalSoftCal2_Ev_TFF, TotalSoftCal2_Ev_TFS) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48]));

				if($TS_Cal_Setp1 && !empty($TS_Cal_Setp1))
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0));
				}
				else
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name08 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_01, TotalSoftCal_02, TotalSoftCal_03, TotalSoftCal_04, TotalSoftCal_05, TotalSoftCal_06, TotalSoftCal_07, TotalSoftCal_08, TotalSoftCal_09, TotalSoftCal_10, TotalSoftCal_11, TotalSoftCal_12, TotalSoftCal_13, TotalSoftCal_14, TotalSoftCal_15, TotalSoftCal_16, TotalSoftCal_17, TotalSoftCal_18, TotalSoftCal_19, TotalSoftCal_20, TotalSoftCal_21, TotalSoftCal_22, TotalSoftCal_23, TotalSoftCal_24, TotalSoftCal_25, TotalSoftCal_26, TotalSoftCal_27, TotalSoftCal_28, TotalSoftCal_29, TotalSoftCal_30) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''));
				}
			}
		}
		else if($CalEvent_TSet[1] == 'Flexible Calendar')
		{
			if($TS_Cal_Set03 && !empty($TS_Cal_Set03))
			{
				$wpdb->query($wpdb->prepare("UPDATE $table_name03 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal3_MW = %s, TotalSoftCal3_WDStart = %s, TotalSoftCal3_BgC = %s, TotalSoftCal3_GrC = %s, TotalSoftCal3_BBC = %s, TotalSoftCal3_BoxShShow = %s, TotalSoftCal3_BoxShType = %s, TotalSoftCal3_BoxSh = %s, TotalSoftCal3_BoxShC = %s, TotalSoftCal3_H_BgC = %s, TotalSoftCal3_H_BTW = %s, TotalSoftCal3_H_BTC = %s, TotalSoftCal3_H_FF = %s, TotalSoftCal3_H_MFS = %s, TotalSoftCal3_H_MC = %s, TotalSoftCal3_H_YFS = %s, TotalSoftCal3_H_YC = %s, TotalSoftCal3_H_Format = %s, TotalSoftCal3_Arr_Type = %s, TotalSoftCal3_Arr_C = %s, TotalSoftCal3_Arr_S = %s, TotalSoftCal3_Arr_HC = %s, TotalSoftCal3_LAH_W = %s, TotalSoftCal3_LAH_C = %s, TotalSoftCal3_WD_BgC = %s, TotalSoftCal3_WD_C = %s, TotalSoftCal3_WD_FS = %s, TotalSoftCal3_WD_FF = %s, TotalSoftCal3_D_BgC = %s, TotalSoftCal3_D_C = %s, TotalSoftCal3_TD_BgC = %s, TotalSoftCal3_TD_C = %s, TotalSoftCal3_HD_BgC = %s, TotalSoftCal3_HD_C = %s, TotalSoftCal3_ED_C = %s, TotalSoftCal3_ED_HC = %s, TotalSoftCal3_Ev_Format = %s, TotalSoftCal3_Ev_BTW = %s, TotalSoftCal3_Ev_BTC = %s, TotalSoftCal3_Ev_BgC = %s, TotalSoftCal3_Ev_C = %s, TotalSoftCal3_Ev_FS = %s, TotalSoftCal3_Ev_FF = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], 0));

				$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], $CalEvent_TSet[70], $CalEvent_TSet[71], $CalEvent_TSet[72], '', '', 0));
			}
			else
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name03 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal3_MW, TotalSoftCal3_WDStart, TotalSoftCal3_BgC, TotalSoftCal3_GrC, TotalSoftCal3_BBC, TotalSoftCal3_BoxShShow, TotalSoftCal3_BoxShType, TotalSoftCal3_BoxSh, TotalSoftCal3_BoxShC, TotalSoftCal3_H_BgC, TotalSoftCal3_H_BTW, TotalSoftCal3_H_BTC, TotalSoftCal3_H_FF, TotalSoftCal3_H_MFS, TotalSoftCal3_H_MC, TotalSoftCal3_H_YFS, TotalSoftCal3_H_YC, TotalSoftCal3_H_Format, TotalSoftCal3_Arr_Type, TotalSoftCal3_Arr_C, TotalSoftCal3_Arr_S, TotalSoftCal3_Arr_HC, TotalSoftCal3_LAH_W, TotalSoftCal3_LAH_C, TotalSoftCal3_WD_BgC, TotalSoftCal3_WD_C, TotalSoftCal3_WD_FS, TotalSoftCal3_WD_FF, TotalSoftCal3_D_BgC, TotalSoftCal3_D_C, TotalSoftCal3_TD_BgC, TotalSoftCal3_TD_C, TotalSoftCal3_HD_BgC, TotalSoftCal3_HD_C, TotalSoftCal3_ED_C, TotalSoftCal3_ED_HC, TotalSoftCal3_Ev_Format, TotalSoftCal3_Ev_BTW, TotalSoftCal3_Ev_BTC, TotalSoftCal3_Ev_BgC, TotalSoftCal3_Ev_C, TotalSoftCal3_Ev_FS, TotalSoftCal3_Ev_FF) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44]));

				if($TS_Cal_Setp1 && !empty($TS_Cal_Setp1))
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], $CalEvent_TSet[70], $CalEvent_TSet[71], $CalEvent_TSet[72], '', '', 0));
				}
				else
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name08 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_01, TotalSoftCal_02, TotalSoftCal_03, TotalSoftCal_04, TotalSoftCal_05, TotalSoftCal_06, TotalSoftCal_07, TotalSoftCal_08, TotalSoftCal_09, TotalSoftCal_10, TotalSoftCal_11, TotalSoftCal_12, TotalSoftCal_13, TotalSoftCal_14, TotalSoftCal_15, TotalSoftCal_16, TotalSoftCal_17, TotalSoftCal_18, TotalSoftCal_19, TotalSoftCal_20, TotalSoftCal_21, TotalSoftCal_22, TotalSoftCal_23, TotalSoftCal_24, TotalSoftCal_25, TotalSoftCal_26, TotalSoftCal_27, TotalSoftCal_28, TotalSoftCal_29, TotalSoftCal_30) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], $CalEvent_TSet[70], $CalEvent_TSet[71], $CalEvent_TSet[72], '', ''));
				}
			}
		}
		else if($CalEvent_TSet[1] == 'TimeLine Calendar')
		{
			if($TS_Cal_Set04 && !empty($TS_Cal_Set04))
			{
				$wpdb->query($wpdb->prepare("UPDATE $table_name04 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal4_01 = %s, TotalSoftCal4_02 = %s, TotalSoftCal4_03 = %s, TotalSoftCal4_04 = %s, TotalSoftCal4_05 = %s, TotalSoftCal4_06 = %s, TotalSoftCal4_07 = %s, TotalSoftCal4_08 = %s, TotalSoftCal4_09 = %s, TotalSoftCal4_10 = %s, TotalSoftCal4_11 = %s, TotalSoftCal4_12 = %s, TotalSoftCal4_13 = %s, TotalSoftCal4_14 = %s, TotalSoftCal4_15 = %s, TotalSoftCal4_16 = %s, TotalSoftCal4_17 = %s, TotalSoftCal4_18 = %s, TotalSoftCal4_19 = %s, TotalSoftCal4_20 = %s, TotalSoftCal4_21 = %s, TotalSoftCal4_22 = %s, TotalSoftCal4_23 = %s, TotalSoftCal4_24 = %s, TotalSoftCal4_25 = %s, TotalSoftCal4_26 = %s, TotalSoftCal4_27 = %s, TotalSoftCal4_28 = %s, TotalSoftCal4_29 = %s, TotalSoftCal4_30 = %s, TotalSoftCal4_31 = %s, TotalSoftCal4_32 = %s, TotalSoftCal4_33 = %s, TotalSoftCal4_34 = %s, TotalSoftCal4_35 = %s, TotalSoftCal4_36 = %s, TotalSoftCal4_37 = %s, TotalSoftCal4_38 = %s, TotalSoftCal4_39 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40], 0));

				$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], '', 0));
			}
			else
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name04 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal4_01, TotalSoftCal4_02, TotalSoftCal4_03, TotalSoftCal4_04, TotalSoftCal4_05, TotalSoftCal4_06, TotalSoftCal4_07, TotalSoftCal4_08, TotalSoftCal4_09, TotalSoftCal4_10, TotalSoftCal4_11, TotalSoftCal4_12, TotalSoftCal4_13, TotalSoftCal4_14, TotalSoftCal4_15, TotalSoftCal4_16, TotalSoftCal4_17, TotalSoftCal4_18, TotalSoftCal4_19, TotalSoftCal4_20, TotalSoftCal4_21, TotalSoftCal4_22, TotalSoftCal4_23, TotalSoftCal4_24, TotalSoftCal4_25, TotalSoftCal4_26, TotalSoftCal4_27, TotalSoftCal4_28, TotalSoftCal4_29, TotalSoftCal4_30, TotalSoftCal4_31, TotalSoftCal4_32, TotalSoftCal4_33, TotalSoftCal4_34, TotalSoftCal4_35, TotalSoftCal4_36, TotalSoftCal4_37, TotalSoftCal4_38, TotalSoftCal4_39) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[2], $CalEvent_TSet[3], $CalEvent_TSet[4], $CalEvent_TSet[5], $CalEvent_TSet[6], $CalEvent_TSet[7], $CalEvent_TSet[8], $CalEvent_TSet[9], $CalEvent_TSet[10], $CalEvent_TSet[11], $CalEvent_TSet[12], $CalEvent_TSet[13], $CalEvent_TSet[14], $CalEvent_TSet[15], $CalEvent_TSet[16], $CalEvent_TSet[17], $CalEvent_TSet[18], $CalEvent_TSet[19], $CalEvent_TSet[20], $CalEvent_TSet[21], $CalEvent_TSet[22], $CalEvent_TSet[23], $CalEvent_TSet[24], $CalEvent_TSet[25], $CalEvent_TSet[26], $CalEvent_TSet[27], $CalEvent_TSet[28], $CalEvent_TSet[29], $CalEvent_TSet[30], $CalEvent_TSet[31], $CalEvent_TSet[32], $CalEvent_TSet[33], $CalEvent_TSet[34], $CalEvent_TSet[35], $CalEvent_TSet[36], $CalEvent_TSet[37], $CalEvent_TSet[38], $CalEvent_TSet[39], $CalEvent_TSet[40]));

				if($TS_Cal_Setp1 && !empty($TS_Cal_Setp1))
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name08 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE id > %d", $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], '', 0));
				}
				else
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name08 (id, TotalSoftCal_ID, TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_01, TotalSoftCal_02, TotalSoftCal_03, TotalSoftCal_04, TotalSoftCal_05, TotalSoftCal_06, TotalSoftCal_07, TotalSoftCal_08, TotalSoftCal_09, TotalSoftCal_10, TotalSoftCal_11, TotalSoftCal_12, TotalSoftCal_13, TotalSoftCal_14, TotalSoftCal_15, TotalSoftCal_16, TotalSoftCal_17, TotalSoftCal_18, TotalSoftCal_19, TotalSoftCal_20, TotalSoftCal_21, TotalSoftCal_22, TotalSoftCal_23, TotalSoftCal_24, TotalSoftCal_25, TotalSoftCal_26, TotalSoftCal_27, TotalSoftCal_28, TotalSoftCal_29, TotalSoftCal_30) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', '', $CalEvent_TSet[0], $CalEvent_TSet[1], $CalEvent_TSet[41], $CalEvent_TSet[42], $CalEvent_TSet[43], $CalEvent_TSet[44], $CalEvent_TSet[45], $CalEvent_TSet[46], $CalEvent_TSet[47], $CalEvent_TSet[48], $CalEvent_TSet[49], $CalEvent_TSet[50], $CalEvent_TSet[51], $CalEvent_TSet[52], $CalEvent_TSet[53], $CalEvent_TSet[54], $CalEvent_TSet[55], $CalEvent_TSet[56], $CalEvent_TSet[57], $CalEvent_TSet[58], $CalEvent_TSet[59], $CalEvent_TSet[60], $CalEvent_TSet[61], $CalEvent_TSet[62], $CalEvent_TSet[63], $CalEvent_TSet[64], $CalEvent_TSet[65], $CalEvent_TSet[66], $CalEvent_TSet[67], $CalEvent_TSet[68], $CalEvent_TSet[69], ''));
				}
			}
		}

		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_DelEv', 'TotalSoftCal_DelEv_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_DelEv', 'TotalSoftCal_DelEv_Callback' );

	function TotalSoftCal_DelEv_Callback()
	{
		$Total_Soft_CalEv_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name3  = $wpdb->prefix . "totalsoft_cal_events";
		$table_name6  = $wpdb->prefix . "totalsoft_cal_events_p2";
		$table_name10 = $wpdb->prefix . "totalsoft_cal_events_p3";
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name3 WHERE id = %d", $Total_Soft_CalEv_ID));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name6 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name10 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));
		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_EditEv', 'TotalSoftCal_EditEv_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_EditEv', 'TotalSoftCal_EditEv_Callback' );

	function TotalSoftCal_EditEv_Callback()
	{
		$Total_Soft_CalEv_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name3 = $wpdb->prefix . "totalsoft_cal_events";
		$Total_Soft_Cal_Ev = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id = %d", $Total_Soft_CalEv_ID));
		print json_encode($Total_Soft_Cal_Ev);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_EditEv_Desc', 'TotalSoftCal_EditEv_Desc_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_EditEv_Desc', 'TotalSoftCal_EditEv_Desc_Callback' );

	function TotalSoftCal_EditEv_Desc_Callback()
	{
		$Total_Soft_CalEv_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name6 = $wpdb->prefix . "totalsoft_cal_events_p2";
		$Total_Soft_Cal_Ev = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));
		
		for($i = 0; $i < count($Total_Soft_Cal_Ev); $i++)
		{
			$Total_Soft_Cal_Ev[$i]->TotalSoftCal_EvDesc = html_entity_decode($Total_Soft_Cal_Ev[$i]->TotalSoftCal_EvDesc);
		}
		print json_encode($Total_Soft_Cal_Ev);
		die();
	}

	add_action( 'wp_ajax_TotalSoftCal_EditEv_Rec', 'TotalSoftCal_EditEv_Rec_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCal_EditEv_Rec', 'TotalSoftCal_EditEv_Rec_Callback' );

	function TotalSoftCal_EditEv_Rec_Callback()
	{
		$Total_Soft_CalEv_ID = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_name10 = $wpdb->prefix . "totalsoft_cal_events_p3";
		$Total_Soft_Cal_Ev = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name10 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));
		
		print json_encode($Total_Soft_Cal_Ev);
		die();
	}

	add_action( 'wp_ajax_TSoftCal_Vimeo_Video_Image', 'TSoftCal_Vimeo_Video_Image_Callback' );
	add_action( 'wp_ajax_nopriv_TSoftCal_Vimeo_Video_Image', 'TSoftCal_Vimeo_Video_Image_Callback' );

	function TSoftCal_Vimeo_Video_Image_Callback()
	{
		$GET_Cal_Video_Video_Src = sanitize_text_field($_POST['foobar']);

		$TSoft_Cal_Image_Src = explode('video/',$GET_Cal_Video_Video_Src);
		$TSoft_Cal_Image_Src_Real = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$TSoft_Cal_Image_Src[1].php"));
		$TSoft_Cal_Image_Src_Real = $TSoft_Cal_Image_Src_Real[0]['thumbnail_large'];

		echo $TSoft_Cal_Image_Src_Real;

		die();
	}

	add_action( 'wp_ajax_TotalSoftCalEv_Clon', 'TotalSoftCalEv_Clon_Callback' );
	add_action( 'wp_ajax_nopriv_TotalSoftCalEv_Clon', 'TotalSoftCalEv_Clon_Callback' );

	function TotalSoftCalEv_Clon_Callback()
	{
		$Total_Soft_CalEv_ID = sanitize_text_field($_POST['foobar']);

		global $wpdb;
		$table_name3  = $wpdb->prefix . "totalsoft_cal_events";
		$table_name6  = $wpdb->prefix . "totalsoft_cal_events_p2";
		$table_name10 = $wpdb->prefix . "totalsoft_cal_events_p3";

		$Total_Soft_Cal_Ev_1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id = %d", $Total_Soft_CalEv_ID));
		$Total_Soft_Cal_Ev_2 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name6 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));
		$Total_Soft_Cal_Ev_3 = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name10 WHERE TotalSoftCal_EvCal = %s", $Total_Soft_CalEv_ID));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, TotalSoftCal_EvName, TotalSoftCal_EvCal, TotalSoftCal_EvStartDate, TotalSoftCal_EvEndDate, TotalSoftCal_EvURL, TotalSoftCal_EvURLNewTab, TotalSoftCal_EvStartTime, TotalSoftCal_EvEndTime, TotalSoftCal_EvColor) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s)", '', $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvName, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvCal, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvStartDate, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvEndDate, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvURL, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvURLNewTab, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvStartTime, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvEndTime, $Total_Soft_Cal_Ev_1[0]->TotalSoftCal_EvColor));
		
		$TotalSoftCalEvent = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d order by id desc limit 1",0));

		$wpdb->query($wpdb->prepare("INSERT INTO $table_name6 (id, TotalSoftCal_EvDesc, TotalSoftCal_EvImg, TotalSoftCal_EvVid_Src, TotalSoftCal_EvVid_Iframe, TotalSoftCal_EvCal) VALUES (%d, %s, %s, %s, %s, %s)", '', $Total_Soft_Cal_Ev_2[0]->TotalSoftCal_EvDesc, $Total_Soft_Cal_Ev_2[0]->TotalSoftCal_EvImg, $Total_Soft_Cal_Ev_2[0]->TotalSoftCal_EvVid_Src, $Total_Soft_Cal_Ev_2[0]->TotalSoftCal_EvVid_Iframe, $TotalSoftCalEvent[0]->id));
		$wpdb->query($wpdb->prepare("INSERT INTO $table_name10 (id, TotalSoftCal_EvCal, TotalSoftCal_EvRec) VALUES (%d, %s, %s)", '', $TotalSoftCalEvent[0]->id, $Total_Soft_Cal_Ev_3[0]->TotalSoftCal_EvRec));

		die();
	}

	add_action( 'wp_ajax_TS_PTable_New_MTable_DisMiss_Cal', 'TS_PTable_New_MTable_DisMiss_Callback_Cal' );
	add_action( 'wp_ajax_nopriv_TS_PTable_New_MTable_DisMiss_Cal', 'TS_PTable_New_MTable_DisMiss_Callback_Cal' );

	function TS_PTable_New_MTable_DisMiss_Callback_Cal()
	{
		$val = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_namenp  = $wpdb->prefix . "totalsoft_new_plugin";

		$wpdb->query($wpdb->prepare("UPDATE $table_namenp set Dismiss = %s WHERE New_Plugin_Name = %s AND Our_Plugin_Name = %s", '1', 'Pricing Table', 'Calendar Event'));
		die();
	}

	add_action( 'wp_ajax_TS_Cal_Question_DisMiss', 'TS_Cal_Question_DisMiss_Callback' );
	add_action( 'wp_ajax_nopriv_TS_Cal_Question_DisMiss', 'TS_Cal_Question_DisMiss_Callback' );

	function TS_Cal_Question_DisMiss_Callback()
	{
		$val = sanitize_text_field($_POST['foobar']);
		global $wpdb;
		$table_namenp  = $wpdb->prefix . "totalsoft_new_plugin";

		$wpdb->query($wpdb->prepare("UPDATE $table_namenp set Dismiss = %s WHERE New_Plugin_Name = %s AND Our_Plugin_Name = %s", '1', 'Calendar Question', 'Calendar Event'));
		die();
	}
?>