<?php
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	require_once(dirname(__FILE__) . '/Total-Soft-Pricing.php');
	require_once(dirname(__FILE__) . '/Total-Soft-Calendar-Preview.php');
	require_once(dirname(__FILE__) . '/Total-Soft-Calendar-Data.php');
	global $wpdb;

	$table_name1  = $wpdb->prefix . "totalsoft_cal_1";
	$table_name2  = $wpdb->prefix . "totalsoft_cal_ids";
	$table_name3  = $wpdb->prefix . "totalsoft_cal_events";
	$table_name4  = $wpdb->prefix . "totalsoft_cal_types";
	$table_name5  = $wpdb->prefix . "totalsoft_cal_2";
	$table_name7  = $wpdb->prefix . "totalsoft_cal_3";
	$table_name8  = $wpdb->prefix . "totalsoft_cal_part";
	$table_name9  = $wpdb->prefix . "totalsoft_cal_4";
	
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(check_admin_referer( 'edit-menu_', 'TS_CalEv_Nonce' ))
		{
			$TotalSoftCal_Name = sanitize_text_field($_POST['TotalSoftCal_Name']);
			$TotalSoftCal_Type = sanitize_text_field($_POST['TotalSoftCal_Type']);
			//Event Calendar
			$TotalSoftCal_BackIconType = sanitize_text_field($_POST['TotalSoftCal_BackIconType']);
			$TotalSoftCal_BgCol = sanitize_text_field($_POST['TotalSoftCal_BgCol']); $TotalSoftCal_GrCol = sanitize_text_field($_POST['TotalSoftCal_GrCol']); $TotalSoftCal_GW = sanitize_text_field($_POST['TotalSoftCal_GW']); $TotalSoftCal_BW = sanitize_text_field($_POST['TotalSoftCal_BW']); $TotalSoftCal_BStyle = sanitize_text_field($_POST['TotalSoftCal_BStyle']); $TotalSoftCal_BCol = sanitize_text_field($_POST['TotalSoftCal_BCol']); $TotalSoftCal_BSCol = sanitize_text_field($_POST['TotalSoftCal_BSCol']); $TotalSoftCal_MW = sanitize_text_field($_POST['TotalSoftCal_MW']); $TotalSoftCal_HBgCol = sanitize_text_field($_POST['TotalSoftCal_HBgCol']); $TotalSoftCal_HCol = sanitize_text_field($_POST['TotalSoftCal_HCol']); $TotalSoftCal_HFS = sanitize_text_field($_POST['TotalSoftCal_HFS']); $TotalSoftCal_HFF = sanitize_text_field($_POST['TotalSoftCal_HFF']); $TotalSoftCal_WBgCol = sanitize_text_field($_POST['TotalSoftCal_WBgCol']); $TotalSoftCal_WCol = sanitize_text_field($_POST['TotalSoftCal_WCol']); $TotalSoftCal_WFS = sanitize_text_field($_POST['TotalSoftCal_WFS']); $TotalSoftCal_WFF = sanitize_text_field($_POST['TotalSoftCal_WFF']); $TotalSoftCal_LAW = sanitize_text_field($_POST['TotalSoftCal_LAW']); $TotalSoftCal_LAWS = sanitize_text_field($_POST['TotalSoftCal_LAWS']); $TotalSoftCal_LAWC = sanitize_text_field($_POST['TotalSoftCal_LAWC']); $TotalSoftCal_DBgCol = sanitize_text_field($_POST['TotalSoftCal_DBgCol']); $TotalSoftCal_DCol = sanitize_text_field($_POST['TotalSoftCal_DCol']); $TotalSoftCal_DFS = sanitize_text_field($_POST['TotalSoftCal_DFS']); $TotalSoftCal_TBgCol = sanitize_text_field($_POST['TotalSoftCal_TBgCol']); $TotalSoftCal_TCol = sanitize_text_field($_POST['TotalSoftCal_TCol']); $TotalSoftCal_TFS = sanitize_text_field($_POST['TotalSoftCal_TFS']); $TotalSoftCal_TNBgCol = sanitize_text_field($_POST['TotalSoftCal_TNBgCol']); $TotalSoftCal_HovBgCol = sanitize_text_field($_POST['TotalSoftCal_HovBgCol']); $TotalSoftCal_HovCol = sanitize_text_field($_POST['TotalSoftCal_HovCol']); $TotalSoftCal_NumPos = sanitize_text_field($_POST['TotalSoftCal_NumPos']); $TotalSoftCal_WDStart = sanitize_text_field($_POST['TotalSoftCal_WDStart']); $TotalSoftCal_RefIcCol = sanitize_text_field($_POST['TotalSoftCal_RefIcCol']); $TotalSoftCal_RefIcSize = sanitize_text_field($_POST['TotalSoftCal_RefIcSize']); $TotalSoftCal_ArrowType = sanitize_text_field($_POST['TotalSoftCal_ArrowType']); $TotalSoftCal_BSType = sanitize_text_field($_POST['TotalSoftCal_BSType']);
			if($TotalSoftCal_ArrowType=='1'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-angle-double-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-angle-double-right'; }
			else if($TotalSoftCal_ArrowType=='2'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-angle-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-angle-right'; }
			else if($TotalSoftCal_ArrowType=='3'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-circle-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-circle-right'; }
			else if($TotalSoftCal_ArrowType=='4'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-circle-o-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-circle-o-right'; }
			else if($TotalSoftCal_ArrowType=='5'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-right'; }
			else if($TotalSoftCal_ArrowType=='6'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-caret-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-caret-right'; }
			else if($TotalSoftCal_ArrowType=='7'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-caret-square-o-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-caret-square-o-right'; }
			else if($TotalSoftCal_ArrowType=='8'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-chevron-circle-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-chevron-circle-right'; }
			else if($TotalSoftCal_ArrowType=='9'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-chevron-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-chevron-right'; }
			else if($TotalSoftCal_ArrowType=='10'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-hand-o-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-hand-o-right'; }
			else if($TotalSoftCal_ArrowType=='11'){ $TotalSoftCal_ArrowLeft='totalsoft totalsoft-long-arrow-left'; $TotalSoftCal_ArrowRight='totalsoft totalsoft-long-arrow-right'; }
			$TotalSoftCal_ArrowCol = sanitize_text_field($_POST['TotalSoftCal_ArrowCol']); $TotalSoftCal_ArrowSize = sanitize_text_field($_POST['TotalSoftCal_ArrowSize']); $TotalSoftCal1_Ev_T_FS = sanitize_text_field($_POST['TotalSoftCal1_Ev_T_FS']); $TotalSoftCal1_Ev_T_FF = sanitize_text_field($_POST['TotalSoftCal1_Ev_T_FF']); $TotalSoftCal1_Ev_T_C = sanitize_text_field($_POST['TotalSoftCal1_Ev_T_C']); $TotalSoftCal1_Ev_T_TA = sanitize_text_field($_POST['TotalSoftCal1_Ev_T_TA']); $TotalSoftCal1_Ev_TiF = sanitize_text_field($_POST['TotalSoftCal1_Ev_TiF']); $TotalSoftCal1_Ev_I_W = sanitize_text_field($_POST['TotalSoftCal1_Ev_I_W']); $TotalSoftCal1_Ev_I_Pos = sanitize_text_field($_POST['TotalSoftCal1_Ev_I_Pos']);

			//Simple Calendar
			$TotalSoftCal2_WDStart = sanitize_text_field($_POST['TotalSoftCal2_WDStart']); $TotalSoftCal2_BW = sanitize_text_field($_POST['TotalSoftCal2_BW']); $TotalSoftCal2_BS = sanitize_text_field($_POST['TotalSoftCal2_BS']); $TotalSoftCal2_BC = sanitize_text_field($_POST['TotalSoftCal2_BC']); $TotalSoftCal2_W = sanitize_text_field($_POST['TotalSoftCal2_W']); $TotalSoftCal2_H = sanitize_text_field($_POST['TotalSoftCal2_H']); $TotalSoftCal2_BxShShow = sanitize_text_field($_POST['TotalSoftCal2_BxShShow']); $TotalSoftCal2_BxShType = sanitize_text_field($_POST['TotalSoftCal2_BxShType']); $TotalSoftCal2_BxSh = ''; $TotalSoftCal2_BxShC = sanitize_text_field($_POST['TotalSoftCal2_BxShC']); $TotalSoftCal2_MBgC = sanitize_text_field($_POST['TotalSoftCal2_MBgC']); $TotalSoftCal2_MC = sanitize_text_field($_POST['TotalSoftCal2_MC']); $TotalSoftCal2_MFS = sanitize_text_field($_POST['TotalSoftCal2_MFS']); $TotalSoftCal2_MFF = sanitize_text_field($_POST['TotalSoftCal2_MFF']); $TotalSoftCal2_WBgC = sanitize_text_field($_POST['TotalSoftCal2_WBgC']); $TotalSoftCal2_WC = sanitize_text_field($_POST['TotalSoftCal2_WC']); $TotalSoftCal2_WFS = sanitize_text_field($_POST['TotalSoftCal2_WFS']); $TotalSoftCal2_WFF = sanitize_text_field($_POST['TotalSoftCal2_WFF']); $TotalSoftCal2_LAW_W = sanitize_text_field($_POST['TotalSoftCal2_LAW_W']); $TotalSoftCal2_LAW_S = sanitize_text_field($_POST['TotalSoftCal2_LAW_S']); $TotalSoftCal2_LAW_C = sanitize_text_field($_POST['TotalSoftCal2_LAW_C']); $TotalSoftCal2_DBgC = sanitize_text_field($_POST['TotalSoftCal2_DBgC']); $TotalSoftCal2_DC = sanitize_text_field($_POST['TotalSoftCal2_DC']); $TotalSoftCal2_DFS = sanitize_text_field($_POST['TotalSoftCal2_DFS']); $TotalSoftCal2_TdBgC = sanitize_text_field($_POST['TotalSoftCal2_TdBgC']); $TotalSoftCal2_TdC = sanitize_text_field($_POST['TotalSoftCal2_TdC']); $TotalSoftCal2_TdFS = sanitize_text_field($_POST['TotalSoftCal2_TdFS']); $TotalSoftCal2_EdBgC = sanitize_text_field($_POST['TotalSoftCal2_EdBgC']); $TotalSoftCal2_EdC = sanitize_text_field($_POST['TotalSoftCal2_EdC']); $TotalSoftCal2_EdFS = sanitize_text_field($_POST['TotalSoftCal2_EdFS']); $TotalSoftCal2_HBgC = sanitize_text_field($_POST['TotalSoftCal2_HBgC']); $TotalSoftCal2_HC = sanitize_text_field($_POST['TotalSoftCal2_HC']); $TotalSoftCal2_ArrType = sanitize_text_field($_POST['TotalSoftCal2_ArrType']); $TotalSoftCal2_ArrFS = sanitize_text_field($_POST['TotalSoftCal2_ArrFS']); $TotalSoftCal2_ArrC = sanitize_text_field($_POST['TotalSoftCal2_ArrC']); $TotalSoftCal2_OmBgC = sanitize_text_field($_POST['TotalSoftCal2_OmBgC']); $TotalSoftCal2_OmC = sanitize_text_field($_POST['TotalSoftCal2_OmC']); $TotalSoftCal2_OmFS = sanitize_text_field($_POST['TotalSoftCal2_OmFS']); $TotalSoftCal2_Ev_HBgC = sanitize_text_field($_POST['TotalSoftCal2_Ev_HBgC']); $TotalSoftCal2_Ev_HC = sanitize_text_field($_POST['TotalSoftCal2_Ev_HC']); $TotalSoftCal2_Ev_HFS = sanitize_text_field($_POST['TotalSoftCal2_Ev_HFS']); $TotalSoftCal2_Ev_HFF = sanitize_text_field($_POST['TotalSoftCal2_Ev_HFF']); $TotalSoftCal2_Ev_HText = sanitize_text_field($_POST['TotalSoftCal2_Ev_HText']); $TotalSoftCal2_Ev_BBgC = sanitize_text_field($_POST['TotalSoftCal2_Ev_BBgC']); $TotalSoftCal2_Ev_TC = sanitize_text_field($_POST['TotalSoftCal2_Ev_TC']); $TotalSoftCal2_Ev_TFF = sanitize_text_field($_POST['TotalSoftCal2_Ev_TFF']); $TotalSoftCal2_Ev_TFS = sanitize_text_field($_POST['TotalSoftCal2_Ev_TFS']); $TotalSoftCal2_Ev_T_TA = sanitize_text_field($_POST['TotalSoftCal2_Ev_T_TA']); $TotalSoftCal2_Ev_I_W = sanitize_text_field($_POST['TotalSoftCal2_Ev_I_W']); $TotalSoftCal2_Ev_I_Pos = sanitize_text_field($_POST['TotalSoftCal2_Ev_I_Pos']); $TotalSoftCal2_Ev_TiF = sanitize_text_field($_POST['TotalSoftCal2_Ev_TiF']); $TotalSoftCal2_Ev_DaF = sanitize_text_field($_POST['TotalSoftCal2_Ev_DaF']); $TotalSoftCal2_Ev_ShDate = sanitize_text_field($_POST['TotalSoftCal2_Ev_ShDate']);

			//Flexible Calendar
			$TotalSoftCal3_MW = sanitize_text_field($_POST['TotalSoftCal3_MW']); $TotalSoftCal3_WDStart = sanitize_text_field($_POST['TotalSoftCal3_WDStart']); $TotalSoftCal3_BoxShShow = sanitize_text_field($_POST['TotalSoftCal3_BoxShShow']); $TotalSoftCal3_H_FF = sanitize_text_field($_POST['TotalSoftCal3_H_FF']); $TotalSoftCal3_H_MFS = sanitize_text_field($_POST['TotalSoftCal3_H_MFS']); $TotalSoftCal3_H_YFS = sanitize_text_field($_POST['TotalSoftCal3_H_YFS']); $TotalSoftCal3_Arr_S = sanitize_text_field($_POST['TotalSoftCal3_Arr_S']); $TotalSoftCal3_WD_FS = sanitize_text_field($_POST['TotalSoftCal3_WD_FS']); $TotalSoftCal3_WD_FF = sanitize_text_field($_POST['TotalSoftCal3_WD_FF']); $TotalSoftCal3_Ev_FS = sanitize_text_field($_POST['TotalSoftCal3_Ev_FS']); $TotalSoftCal3_Ev_FF = sanitize_text_field($_POST['TotalSoftCal3_Ev_FF']); $TotalSoftCal3_Ev_C_FS = sanitize_text_field($_POST['TotalSoftCal3_Ev_C_FS']); $TotalSoftCal3_Ev_T_FS = sanitize_text_field($_POST['TotalSoftCal3_Ev_T_FS']); $TotalSoftCal3_Ev_T_FF = sanitize_text_field($_POST['TotalSoftCal3_Ev_T_FF']); $TotalSoftCal3_Ev_T_TA = sanitize_text_field($_POST['TotalSoftCal3_Ev_T_TA']); $TotalSoftCal3_Ev_I_W = sanitize_text_field($_POST['TotalSoftCal3_Ev_I_W']); $TotalSoftCal3_Ev_L_Text = sanitize_text_field($_POST['TotalSoftCal3_Ev_L_Text']); $TotalSoftCal3_Ev_LAE_W = sanitize_text_field($_POST['TotalSoftCal3_Ev_LAE_W']); $TotalSoftCal3_Ev_L_FS = sanitize_text_field($_POST['TotalSoftCal3_Ev_L_FS']); $TotalSoftCal3_Ev_L_FF = sanitize_text_field($_POST['TotalSoftCal3_Ev_L_FF']); $TotalSoftCal3_Ev_L_BW = sanitize_text_field($_POST['TotalSoftCal3_Ev_L_BW']); $TotalSoftCal3_Ev_L_BR = sanitize_text_field($_POST['TotalSoftCal3_Ev_L_BR']);

			//TimeLine Calendar
			$TotalSoftCal4_01 = sanitize_text_field($_POST['TotalSoftCal4_01']); $TotalSoftCal4_04 = sanitize_text_field($_POST['TotalSoftCal4_04']); $TotalSoftCal4_05 = sanitize_text_field($_POST['TotalSoftCal4_05']); $TotalSoftCal4_10 = sanitize_text_field($_POST['TotalSoftCal4_10']); $TotalSoftCal4_11 = sanitize_text_field($_POST['TotalSoftCal4_11']); $TotalSoftCal4_15 = sanitize_text_field($_POST['TotalSoftCal4_15']); $TotalSoftCal4_20 = sanitize_text_field($_POST['TotalSoftCal4_20']); $TotalSoftCal4_21 = sanitize_text_field($_POST['TotalSoftCal4_21']); $TotalSoftCal4_26 = sanitize_text_field($_POST['TotalSoftCal4_26']); $TotalSoftCal4_28 = sanitize_text_field($_POST['TotalSoftCal4_28']); $TotalSoftCal4_33 = sanitize_text_field($_POST['TotalSoftCal4_33']); $TotalSoftCal4_37 = sanitize_text_field($_POST['TotalSoftCal4_37']); $TotalSoftCal4_38 = sanitize_text_field($_POST['TotalSoftCal4_38']);
			$TotalSoftCal_4_05 = sanitize_text_field($_POST['TotalSoftCal_4_05']); $TotalSoftCal_4_06 = sanitize_text_field($_POST['TotalSoftCal_4_06']); $TotalSoftCal_4_09 = sanitize_text_field($_POST['TotalSoftCal_4_09']); $TotalSoftCal_4_10 = sanitize_text_field($_POST['TotalSoftCal_4_10']); $TotalSoftCal_4_15 = sanitize_text_field($_POST['TotalSoftCal_4_15']); $TotalSoftCal_4_16 = sanitize_text_field($_POST['TotalSoftCal_4_16']); $TotalSoftCal_4_17 = sanitize_text_field($_POST['TotalSoftCal_4_17']); $TotalSoftCal_4_19 = sanitize_text_field($_POST['TotalSoftCal_4_19']); $TotalSoftCal_4_20 = sanitize_text_field($_POST['TotalSoftCal_4_20']); $TotalSoftCal_4_22 = sanitize_text_field($_POST['TotalSoftCal_4_22']); $TotalSoftCal_4_23 = sanitize_text_field($_POST['TotalSoftCal_4_23']); $TotalSoftCal_4_25 = sanitize_text_field($_POST['TotalSoftCal_4_25']); $TotalSoftCal_4_26 = sanitize_text_field($_POST['TotalSoftCal_4_26']); $TotalSoftCal_4_28 = sanitize_text_field($_POST['TotalSoftCal_4_28']);

			if(isset($_POST['Total_Soft_Cal_Update']))
			{
				$Total_SoftCal_Update = sanitize_text_field($_POST['Total_SoftCal_Update']);

				$wpdb->query($wpdb->prepare("UPDATE $table_name4 set TotalSoftCal_Name=%s, TotalSoftCal_Type=%s WHERE id=%d", $TotalSoftCal_Name, $TotalSoftCal_Type, $Total_SoftCal_Update));
				if($TotalSoftCal_Type=='Event Calendar')
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name1 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_BgCol = %s, TotalSoftCal_GrCol = %s, TotalSoftCal_GW = %s, TotalSoftCal_BW = %s, TotalSoftCal_BStyle = %s, TotalSoftCal_BCol = %s, TotalSoftCal_BSCol = %s, TotalSoftCal_MW = %s, TotalSoftCal_HBgCol = %s, TotalSoftCal_HCol = %s, TotalSoftCal_HFS = %s, TotalSoftCal_HFF = %s, TotalSoftCal_WBgCol = %s, TotalSoftCal_WCol = %s, TotalSoftCal_WFS = %s, TotalSoftCal_WFF = %s, TotalSoftCal_LAW = %s, TotalSoftCal_LAWS = %s, TotalSoftCal_LAWC = %s, TotalSoftCal_DBgCol = %s, TotalSoftCal_DCol = %s, TotalSoftCal_DFS = %s, TotalSoftCal_TBgCol = %s, TotalSoftCal_TCol = %s, TotalSoftCal_TFS = %s, TotalSoftCal_TNBgCol = %s, TotalSoftCal_HovBgCol = %s, TotalSoftCal_HovCol = %s, TotalSoftCal_NumPos = %s, TotalSoftCal_WDStart = %s, TotalSoftCal_RefIcCol = %s, TotalSoftCal_RefIcSize = %s, TotalSoftCal_ArrowType = %s, TotalSoftCal_ArrowLeft = %s, TotalSoftCal_ArrowRight = %s, TotalSoftCal_ArrowCol = %s, TotalSoftCal_ArrowSize = %s, TotalSoftCal_BackIconType = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal_BgCol, $TotalSoftCal_GrCol, $TotalSoftCal_GW, $TotalSoftCal_BW, $TotalSoftCal_BStyle, $TotalSoftCal_BCol, $TotalSoftCal_BSCol, $TotalSoftCal_MW, $TotalSoftCal_HBgCol, $TotalSoftCal_HCol, $TotalSoftCal_HFS, $TotalSoftCal_HFF, $TotalSoftCal_WBgCol, $TotalSoftCal_WCol, $TotalSoftCal_WFS, $TotalSoftCal_WFF, $TotalSoftCal_LAW, $TotalSoftCal_LAWS, $TotalSoftCal_LAWC, $TotalSoftCal_DBgCol, $TotalSoftCal_DCol, $TotalSoftCal_DFS, $TotalSoftCal_TBgCol, $TotalSoftCal_TCol, $TotalSoftCal_TFS, $TotalSoftCal_TNBgCol, $TotalSoftCal_HovBgCol, $TotalSoftCal_HovCol, $TotalSoftCal_NumPos, $TotalSoftCal_WDStart, $TotalSoftCal_RefIcCol, $TotalSoftCal_RefIcSize, $TotalSoftCal_ArrowType, $TotalSoftCal_ArrowLeft, $TotalSoftCal_ArrowRight, $TotalSoftCal_ArrowCol, $TotalSoftCal_ArrowSize, $TotalSoftCal_BackIconType, $Total_SoftCal_Update));
					$wpdb->query($wpdb->prepare("UPDATE $table_name8 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal1_Ev_T_FS, $TotalSoftCal1_Ev_T_FF, $TotalSoftCal1_Ev_T_C, $TotalSoftCal1_Ev_T_TA, $TotalSoftCal1_Ev_TiF, $TotalSoftCal_BSType, '', '', $TotalSoftCal1_Ev_I_W, $TotalSoftCal1_Ev_I_Pos, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $Total_SoftCal_Update));
				}
				else if($TotalSoftCal_Type=='Simple Calendar')
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name5 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal2_WDStart = %s, TotalSoftCal2_BW = %s, TotalSoftCal2_BS = %s, TotalSoftCal2_BC = %s, TotalSoftCal2_W = %s, TotalSoftCal2_H = %s, TotalSoftCal2_BxShShow = %s, TotalSoftCal2_BxShType = %s, TotalSoftCal2_BxSh = %s, TotalSoftCal2_BxShC = %s, TotalSoftCal2_MBgC = %s, TotalSoftCal2_MC = %s, TotalSoftCal2_MFS = %s, TotalSoftCal2_MFF = %s, TotalSoftCal2_WBgC = %s, TotalSoftCal2_WC = %s, TotalSoftCal2_WFS = %s, TotalSoftCal2_WFF = %s, TotalSoftCal2_LAW_W = %s, TotalSoftCal2_LAW_S = %s, TotalSoftCal2_LAW_C = %s, TotalSoftCal2_DBgC = %s, TotalSoftCal2_DC = %s, TotalSoftCal2_DFS = %s, TotalSoftCal2_TdBgC = %s, TotalSoftCal2_TdC = %s, TotalSoftCal2_TdFS = %s, TotalSoftCal2_EdBgC = %s, TotalSoftCal2_EdC = %s, TotalSoftCal2_EdFS = %s, TotalSoftCal2_HBgC = %s, TotalSoftCal2_HC = %s, TotalSoftCal2_ArrType = %s, TotalSoftCal2_ArrFS = %s, TotalSoftCal2_ArrC = %s, TotalSoftCal2_OmBgC = %s, TotalSoftCal2_OmC = %s, TotalSoftCal2_OmFS = %s, TotalSoftCal2_Ev_HBgC = %s, TotalSoftCal2_Ev_HC = %s, TotalSoftCal2_Ev_HFS = %s, TotalSoftCal2_Ev_HFF = %s, TotalSoftCal2_Ev_HText = %s, TotalSoftCal2_Ev_BBgC = %s, TotalSoftCal2_Ev_TC = %s, TotalSoftCal2_Ev_TFF = %s, TotalSoftCal2_Ev_TFS = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal2_WDStart, $TotalSoftCal2_BW, $TotalSoftCal2_BS, $TotalSoftCal2_BC, $TotalSoftCal2_W, $TotalSoftCal2_H, $TotalSoftCal2_BxShShow, $TotalSoftCal2_BxShType, $TotalSoftCal2_BxSh, $TotalSoftCal2_BxShC, $TotalSoftCal2_MBgC, $TotalSoftCal2_MC, $TotalSoftCal2_MFS, $TotalSoftCal2_MFF, $TotalSoftCal2_WBgC, $TotalSoftCal2_WC, $TotalSoftCal2_WFS, $TotalSoftCal2_WFF, $TotalSoftCal2_LAW_W, $TotalSoftCal2_LAW_S, $TotalSoftCal2_LAW_C, $TotalSoftCal2_DBgC, $TotalSoftCal2_DC, $TotalSoftCal2_DFS, $TotalSoftCal2_TdBgC, $TotalSoftCal2_TdC, $TotalSoftCal2_TdFS, $TotalSoftCal2_EdBgC, $TotalSoftCal2_EdC, $TotalSoftCal2_EdFS, $TotalSoftCal2_HBgC, $TotalSoftCal2_HC, $TotalSoftCal2_ArrType, $TotalSoftCal2_ArrFS, $TotalSoftCal2_ArrC, $TotalSoftCal2_OmBgC, $TotalSoftCal2_OmC, $TotalSoftCal2_OmFS, $TotalSoftCal2_Ev_HBgC, $TotalSoftCal2_Ev_HC, $TotalSoftCal2_Ev_HFS, $TotalSoftCal2_Ev_HFF, $TotalSoftCal2_Ev_HText, $TotalSoftCal2_Ev_BBgC, $TotalSoftCal2_Ev_TC, $TotalSoftCal2_Ev_TFF, $TotalSoftCal2_Ev_TFS, $Total_SoftCal_Update));
					$wpdb->query($wpdb->prepare("UPDATE $table_name8 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_01 = %s, TotalSoftCal_02 = %s, TotalSoftCal_03 = %s, TotalSoftCal_04 = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_07 = %s, TotalSoftCal_08 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_12 = %s, TotalSoftCal_13 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_18 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_27 = %s, TotalSoftCal_28 = %s, TotalSoftCal_29 = %s, TotalSoftCal_30 = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal2_Ev_T_TA, $TotalSoftCal2_Ev_I_W, $TotalSoftCal2_Ev_I_Pos, $TotalSoftCal2_Ev_TiF, $TotalSoftCal2_Ev_DaF, $TotalSoftCal2_Ev_ShDate, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $Total_SoftCal_Update));
				}
				else if($TotalSoftCal_Type=='Flexible Calendar')
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name7 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal3_MW = %s, TotalSoftCal3_WDStart = %s, TotalSoftCal3_BoxShShow = %s, TotalSoftCal3_H_FF = %s, TotalSoftCal3_H_MFS = %s, TotalSoftCal3_H_YFS = %s, TotalSoftCal3_Arr_S = %s, TotalSoftCal3_WD_FS = %s, TotalSoftCal3_WD_FF = %s, TotalSoftCal3_Ev_FS = %s, TotalSoftCal3_Ev_FF = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal3_MW, $TotalSoftCal3_WDStart, $TotalSoftCal3_BoxShShow, $TotalSoftCal3_H_FF, $TotalSoftCal3_H_MFS, $TotalSoftCal3_H_YFS, $TotalSoftCal3_Arr_S, $TotalSoftCal3_WD_FS, $TotalSoftCal3_WD_FF, $TotalSoftCal3_Ev_FS, $TotalSoftCal3_Ev_FF, $Total_SoftCal_Update));
					$wpdb->query($wpdb->prepare("UPDATE $table_name8 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_05 = %s, TotalSoftCal_10 = %s, TotalSoftCal_11 = %s, TotalSoftCal_14 = %s, TotalSoftCal_15 = %s, TotalSoftCal_20 = %s, TotalSoftCal_21 = %s, TotalSoftCal_23 = %s, TotalSoftCal_24 = %s, TotalSoftCal_25 = %s, TotalSoftCal_27 = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal3_Ev_C_FS, $TotalSoftCal3_Ev_T_FS, $TotalSoftCal3_Ev_T_FF, $TotalSoftCal3_Ev_T_TA, $TotalSoftCal3_Ev_I_W, $TotalSoftCal3_Ev_L_Text, $TotalSoftCal3_Ev_LAE_W, $TotalSoftCal3_Ev_L_FS, $TotalSoftCal3_Ev_L_FF, $TotalSoftCal3_Ev_L_BW, $TotalSoftCal3_Ev_L_BR, $Total_SoftCal_Update));
				}
				else if($TotalSoftCal_Type=='TimeLine Calendar')
				{
					$wpdb->query($wpdb->prepare("UPDATE $table_name9 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal4_01 = %s, TotalSoftCal4_04 = %s, TotalSoftCal4_05 = %s, TotalSoftCal4_10 = %s, TotalSoftCal4_11 = %s, TotalSoftCal4_15 = %s, TotalSoftCal4_20 = %s, TotalSoftCal4_21 = %s, TotalSoftCal4_26 = %s, TotalSoftCal4_28 = %s, TotalSoftCal4_33 = %s, TotalSoftCal4_37 = %s, TotalSoftCal4_38 = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal4_01, $TotalSoftCal4_04, $TotalSoftCal4_05, $TotalSoftCal4_10, $TotalSoftCal4_11, $TotalSoftCal4_15, $TotalSoftCal4_20, $TotalSoftCal4_21, $TotalSoftCal4_26, $TotalSoftCal4_28, $TotalSoftCal4_33, $TotalSoftCal4_37, $TotalSoftCal4_38, $Total_SoftCal_Update));
					$wpdb->query($wpdb->prepare("UPDATE $table_name8 set TotalSoftCal_Name = %s, TotalSoftCal_Type = %s, TotalSoftCal_05 = %s, TotalSoftCal_06 = %s, TotalSoftCal_09 = %s, TotalSoftCal_10 = %s, TotalSoftCal_15 = %s, TotalSoftCal_16 = %s, TotalSoftCal_17 = %s, TotalSoftCal_19 = %s, TotalSoftCal_20 = %s, TotalSoftCal_22 = %s, TotalSoftCal_23 = %s, TotalSoftCal_25 = %s, TotalSoftCal_26 = %s, TotalSoftCal_28 = %s WHERE TotalSoftCal_ID = %s", $TotalSoftCal_Name, $TotalSoftCal_Type, $TotalSoftCal_4_05, $TotalSoftCal_4_06, $TotalSoftCal_4_09, $TotalSoftCal_4_10, $TotalSoftCal_4_15, $TotalSoftCal_4_16, $TotalSoftCal_4_17, $TotalSoftCal_4_19, $TotalSoftCal_4_20, $TotalSoftCal_4_22, $TotalSoftCal_4_23, $TotalSoftCal_4_25, $TotalSoftCal_4_26, $TotalSoftCal_4_28, $Total_SoftCal_Update));
				}
			}
		}
		else
		{
			wp_die('Security check fail'); 
		}
	}

	$TotalSoftFontCount = array("Abadi MT Condensed Light", "ABeeZee", "Abel", "Abhaya Libre", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Aharoni", "Akronim", "Aladin", "Aldhabi", "Aldrich", "Alef", "Alegreya", "Alegreya Sans", "Alegreya Sans SC", "Alegreya SC", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Amiko", "Amiri", "Amita", "Anaheim", "Andada", "Andalus", "Andika", "Angkor", "Angsana New", "AngsanaUPC", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Aparajita", "Arabic Typesetting", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo", "Archivo Black", "Archivo Narrow", "Aref Ruqaa", "Arial", "Arial Black", "Arimo", "Arima Madurai", "Arizonia", "Armata", "Arsenal", "Artifika", "Arvo", "Arya", "Asap", "Asap Condensed", "Asar", "Asset", "Assistant", "Astloch", "Asul", "Athiti", "Atma", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Bahiana", "Baloo", "Balthazar", "Bangers", "Barlow", "Barlow Condensed", "Barlow Semi Condensed", "Barrio", "Basic", "Batang", "BatangChe", "Battambang", "Baumans", "Bayon", "Belgrano", "Bellefair", "Belleza", "BenchNine", "Bentham", "Berkshire Swash", "Bevan", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "BioRhyme", "BioRhyme Expanded", "Biryani", "Bitter", "Black And White Picture", "Black Han Sans", "Black Ops One", "Bokor", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Browallia New", "BrowalliaUPC", "Bubbler One", "Bubblegum Sans", "Buda", "Buenard", "Bungee", "Bungee Hairline", "Bungee Inline", "Bungee Outline", "Bungee Shade", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Cairo", "Calibri", "Calibri Light", "Calisto MT", "Calligraffitti", "Cambay", "Cambo", "Cambria", "Candal", "Candara", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Catamaran", "Caudex", "Caveat", "Caveat Brush", "Cedarville Cursive", "Century Gothic", "Ceviche One", "Changa", "Changa One", "Chango", "Chathura", "Chau Philomene One", "Chela One", "Chelsea Market", "Chenla", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chivo", "Chonburi", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Coiny", "Combo", "Comic Sans MS", "Coming Soon", "Comfortaa", "Concert One", "Condiment", "Consolas", "Constantia", "Content", "Contrail One", "Convergence", "Cookie", "Copperplate Gothic", "Copperplate Gothic Light", "Copse", "Corbel", "Corben", "Cordia New", "CordiaUPC", "Cormorant", "Cormorant Garamond", "Cormorant Infant", "Cormorant SC", "Cormorant Unicase", "Cormorant Upright", "Courgette", "Courier New", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cute Font", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dangrek", "DaunPenh", "David", "David Libre", "Dawning of a New Day", "Days One", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "DFKai-SB", "Dhurjati", "Didact Gothic", "DilleniaUPC", "Diplomata", "Diplomata SC", "Do Hyeon", "DokChampa", "Dokdo", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dotum", "DotumChe", "Dr Sugiyama", "Duru Sans", "Dynalight", "Eagle Lake", "East Sea Dokdo", "Eater", "EB Garamond", "Ebrima", "Economica", "Eczar", "El Messiri", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Encode Sans", "Encode Sans Condensed", "Encode Sans Expanded", "Encode Sans Semi Condensed", "Encode Sans Semi Expanded", "Engagement", "Englebert", "Enriqueta", "Erica One", "Esteban", "Estrangelo Edessa", "EucrosiaUPC", "Euphemia", "Euphoria Script", "Ewert", "Exo", "Expletus Sans", "FangSong", "Fanwood Text", "Farsan", "Fascinate", "Fascinate Inline", "Faster One", "Fasthand", "Fauna One", "Faustina", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fira Mono", "Fira Sans", "Fira Sans Condensed", "Fira Sans Extra Condensed", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Frank Ruhl Libre", "Franklin Gothic Medium", "FrankRuehl", "Freckle Face", "Fredericka the Great", "Fredoka One", "Freehand", "FreesiaUPC", "Fresca", "Frijole", "Fruktur", "Fugaz One", "Gabriela", "Gabriola", "Gadugi", "Gaegu", "Gafata", "Galada", "Galdeano", "Galindo", "Gamja Flower", "Gautami", "Gentium Basic", "Gentium Book Basic", "Geo", "Georgia", "Geostar", "Geostar Fill", "Germania One", "GFS Didot", "GFS Neohellenic", "Gidugu", "Gilda Display", "Gisha", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas", "Gothic A1", "Graduate", "Grand Hotel", "Gravitas One", "Great Vibes", "Griffy", "Gruppo", "Gudea", "Gugi", "Gulim", "GulimChe", "Gungsuh", "GungsuhChe", "Gurajada", "Habibi", "Halant", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Hanuman", "Happy Monkey", "Harmattan", "Headland One", "Heebo", "Henny Penny", "Herr Von Muellerhoff", "Hi Melody", "Hind", "Holtwood One SC", "Homemade Apple", "Homenaje", "IBM Plex Mono", "IBM Plex Sans", "IBM Plex Sans Condensed", "IBM Plex Serif", "Iceberg", "Iceland", "IM Fell Double Pica", "IM Fell Double Pica SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Impact", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Irish Grover", "IrisUPC", "Istok Web", "Iskoola Pota", "Italiana", "Italianno", "Itim", "Jacques Francois", "Jacques Francois Shadow", "Jaldi", "JasmineUPC", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Jomhuria", "Josefin Sans", "Josefin Slab", "Joti One", "Jua", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kadwa", "KaiTi", "Kalam", "Kalinga", "Kameron", "Kanit", "Kantumruy", "Karla", "Karma", "Kartika", "Katibeh", "Kaushan Script", "Kavivanar", "Kavoon", "Kdam Thmor", "Keania One", "Kelly Slab", "Kenia", "Khand", "Khmer", "Khmer UI", "Khula", "Kirang Haerang", "Kite One", "Knewave", "KodchiangUPC", "Kokila", "Kotta One", "Koulen", "Kranky", "Kreon", "Kristi", "Krona One", "Kurale", "La Belle Aurore", "Laila", "Lakki Reddy", "Lalezar", "Lancelot", "Lao UI", "Lateef", "Latha", "Lato", "League Script", "Leckerli One", "Ledger", "Leelawadee", "Lekton", "Lemon", "Lemonada", "Levenim MT", "Libre Baskerville", "Libre Franklin", "Life Savers", "Lilita One", "Lily Script One", "LilyUPC", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Lucida Console", "Lucida Handwriting Italic", "Lucida Sans Unicode", "Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Mada", "Magra", "Maiden Orange", "Maitree", "Mako", "Malgun Gothic", "Mallanna", "Mandali", "Mangal", "Manny ITC", "Manuale", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Marko One", "Marlett", "Marmelad", "Martel", "Martel Sans", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Meera Inimai", "Megrim", "Meie Script", "Meiryo", "Meiryo UI", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Microsoft Himalaya", "Microsoft JhengHei", "Microsoft JhengHei UI", "Microsoft New Tai Lue", "Microsoft PhagsPa", "Microsoft Sans Serif", "Microsoft Tai Le", "Microsoft Uighur", "Microsoft YaHei", "Microsoft YaHei UI", "Microsoft Yi Baiti", "Milonga", "Miltonian", "Miltonian Tattoo", "Mina", "MingLiU_HKSCS", "MingLiU_HKSCS-ExtB", "Miniver", "Miriam", "Miriam Libre", "Mirza", "Miss Fajardose", "Mitr", "Modak", "Modern Antiqua", "Mogra", "Molengo", "Molle", "Monda", "Mongolian Baiti", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "MoolBoran", "Moul", "Moulpali", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "MS UI Gothic", "Mukta", "Muli", "MV Boli", "Myanmar Text", "Mystery Quest", "Nanum Brush Script", "Nanum Gothic", "Nanum Gothic Coding", "Nanum Myeongjo", "Nanum Pen Script", "Narkisim", "Neucha", "Neuton", "New Rocker", "News Cycle", "News Gothic MT", "Niconne", "Nirmala UI", "Nixie One", "Nobile", "Nokora", "Norican", "Nosifer", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Serif", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "NSimSun", "NTR", "Numans", "Nunito", "Nunito Sans", "Nyala", "Odor Mean Chey", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Overpass", "Overpass Mono", "Ovo", "Oxygen", "Oxygen Mono", "Pacifico", "Padauk", "Palanquin", "Palanquin Dark", "Palatino Linotype", "Pangolin", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Pattaya", "Patua One", "Pavanam", "Paytone One", "Peddana", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Pirata One", "Plantagenet Cherokee", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Poor Story", "Poppins", "Port Lligat Sans", "Port Lligat Slab", "Pragati Narrow", "Prata", "Preahvihear", "Pridi", "Princess Sofia", "Prociono", "Prompt", "Prosto One", "Proza Libre", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Raavi", "Racing Sans One", "Radley", "Rajdhani", "Rakkas", "Raleway", "Raleway Dots", "Ramabhadra", "Ramaraja", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Ranga", "Rasa", "Rationale", "Ravi Prakash", "Redressed", "Reem Kufi", "Reenie Beanie", "Revalia", "Rhodium Libre", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Mono", "Roboto Slab", "Rochester", "Rock Salt", "Rod", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Rozha One", "Rubik", "Rubik Mono One", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sahitya", "Sail", "Saira", "Saira Condensed", "Saira Extra Condensed", "Saira Semi Condensed", "Sakkal Majalla", "Salsa", "Sanchez", "Sancreek", "Sansita", "Sarala", "Sarina", "Sarpanch", "Satisfy", "Scada", "Scheherazade", "Schoolbell", "Scope One", "Seaweed Script", "Secular One", "Sedgwick Ave", "Sedgwick Ave Display", "Segoe Print", "Segoe Script", "Segoe UI Symbol", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Shonar Bangla", "Short Stack", "Shrikhand", "Shruti", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "SimHei", "SimKai", "Simonetta", "Simplified Arabic", "SimSun", "SimSun-ExtB", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Song Myung", "Sonsie One", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Source Serif Pro", "Space Mono", "Special Elite", "Spectral", "Spectral SC", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Sree Krushnadevaraya", "Sriracha", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Stylish", "Sue Ellen Francisco", "Suez One", "Sumana", "Sunflower", "Sunshiney", "Supermercado One", "Sura", "Suranna", "Suravaram", "Suwannaphum", "Swanky and Moo Moo", "Sylfaen", "Syncopate", "Tahoma", "Tajawal", "Tangerine", "Taprom", "Tauri", "Taviraj", "Teko", "Telex", "Tenali Ramakrishna", "Tenor Sans", "Text Me One", "The Girl Next Door", "Tienne", "Tillana", "Times New Roman", "Timmana", "Tinos", "Titan One", "Titillium Web", "Trade Winds", "Traditional Arabic", "Trebuchet MS", "Trirong", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Tunga", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "Utsaah", "Vampiro One", "Vani", "Varela", "Varela Round", "Vast Shadow", "Vesper Libre", "Vibur", "Vidaloka", "Viga", "Vijaya", "Voces", "Volkhov", "Vollkorn", "Vollkorn SC", "Voltaire", "VT323", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Work Sans", "Yanone Kaffeesatz", "Yantramanav", "Yatra One", "Yellowtail", "Yeon Sung", "Yeseva One", "Yesteryear", "Yrsa", "Zeyada", "Zilla Slab", "Zilla Slab Highlight");
	$TotalSoftFontGCount = array("Abadi MT Condensed Light", "ABeeZee, sans-serif", "Abel, sans-serif", "Abhaya Libre, serif", "Abril Fatface, cursive", "Aclonica, sans-serif", "Acme, sans-serif", "Actor, sans-serif", "Adamina, serif", "Advent Pro, sans-serif", "Aguafina Script, cursive", "Aharoni", "Akronim, cursive", "Aladin, cursive", "Aldhabi", "Aldrich, sans-serif", "Alef, sans-serif", "Alegreya, serif", "Alegreya Sans, sans-serif", "Alegreya Sans SC, sans-serif", "Alegreya SC, serif", "Alex Brush, cursive", "Alfa Slab One, cursive", "Alice, serif", "Alike, serif", "Alike Angular, serif", "Allan, cursive", "Allerta, sans-serif", "Allerta Stencil, sans-serif", "Allura, cursive", "Almendra, serif", "Almendra Display, cursive", "Almendra SC, serif", "Amarante, cursive", "Amaranth, sans-serif", "Amatic SC, cursive", "Amethysta, serif", "Amiko, sans-serif", "Amiri, serif", "Amita, cursive", "Anaheim, sans-serif", "Andada, serif", "Andalus", "Andika, sans-serif", "Angkor, cursive", "Angsana New", "AngsanaUPC", "Annie Use Your Telescope, cursive", "Anonymous Pro, monospace", "Antic, sans-serif", "Antic Didone, serif", "Antic Slab, serif", "Anton, sans-serif", "Aparajita", "Arabic Typesetting", "Arapey, serif", "Arbutus, cursive", "Arbutus Slab, serif", "Architects Daughter, cursive", "Archivo, sans-serif", "Archivo Black, sans-serif", "Archivo Narrow, sans-serif", "Aref Ruqaa, serif", "Arial", "Arial Black", "Arimo, sans-serif", "Arima Madurai, cursive", "Arizonia, cursive", "Armata, sans-serif", "Arsenal, sans-serif", "Artifika, serif", "Arvo, serif", "Arya, sans-serif", "Asap, sans-serif", "Asap Condensed, sans-serif", "Asar, serif", "Asset, cursive", "Assistant, sans-serif", "Astloch, cursive", "Asul, sans-serif", "Athiti, sans-serif", "Atma, cursive", "Atomic Age, cursive", "Aubrey, cursive", "Audiowide, cursive", "Autour One, cursive", "Average, serif", "Average Sans, sans-serif", "Averia Gruesa Libre, cursive", "Averia Libre, cursive", "Averia Sans Libre, cursive", "Averia Serif Libre, cursive", "Bad Script, cursive", "Bahiana, cursive", "Baloo, cursive", "Balthazar, serif", "Bangers, cursive", "Barlow, sans-serif", "Barlow Condensed, sans-serif", "Barlow Semi Condensed, sans-serif", "Barrio, cursive", "Basic, sans-serif", "Batang", "BatangChe", "Battambang, cursive", "Baumans, cursive", "Bayon, cursive", "Belgrano, serif", "Bellefair, serif", "Belleza, sans-serif", "BenchNine, sans-serif", "Bentham, serif", "Berkshire Swash, cursive", "Bevan, cursive", "Bigelow Rules, cursive", "Bigshot One, cursive", "Bilbo, cursive", "Bilbo Swash Caps, cursive", "BioRhyme, serif", "BioRhyme Expanded, serif", "Biryani, sans-serif", "Bitter, serif", "Black And White Picture, sans-serif", "Black Han Sans, sans-serif", "Black Ops One, cursive", "Bokor, cursive", "Bonbon, cursive", "Boogaloo, cursive", "Bowlby One, cursive", "Bowlby One SC, cursive", "Brawler, serif", "Bree Serif, serif", "Browallia New", "BrowalliaUPC", "Bubbler One, sans-serif", "Bubblegum Sans, cursive", "Buda, cursive", "Buenard, serif", "Bungee, cursive", "Bungee Hairline, cursive", "Bungee Inline, cursive", "Bungee Outline, cursive", "Bungee Shade, cursive", "Butcherman, cursive", "Butterfly Kids, cursive", "Cabin, sans-serif", "Cabin Condensed, sans-serif", "Cabin Sketch, cursive", "Caesar Dressing, cursive", "Cagliostro, sans-serif", "Cairo, sans-serif", "Calibri", "Calibri Light", "Calisto MT", "Calligraffitti, cursive", "Cambay, sans-serif", "Cambo, serif", "Cambria", "Candal, sans-serif", "Candara", "Cantarell, sans-serif", "Cantata One, serif", "Cantora One, sans-serif", "Capriola, sans-serif", "Cardo, serif", "Carme, sans-serif", "Carrois Gothic, sans-serif", "Carrois Gothic SC, sans-serif", "Carter One, cursive", "Catamaran, sans-serif", "Caudex, serif", "Caveat, cursive", "Caveat Brush, cursive", "Cedarville Cursive, cursive", "Century Gothic", "Ceviche One, cursive", "Changa, sans-serif", "Changa One, cursive", "Chango, cursive", "Chathura, sans-serif", "Chau Philomene One, sans-serif", "Chela One, cursive", "Chelsea Market, cursive", "Chenla, cursive", "Cherry Cream Soda, cursive", "Cherry Swash, cursive", "Chewy, cursive", "Chicle, cursive", "Chivo, sans-serif", "Chonburi, cursive", "Cinzel, serif", "Cinzel Decorative, cursive", "Clicker Script, cursive", "Coda, cursive", "Coda Caption, sans-serif", "Codystar, cursive", "Coiny, cursive", "Combo, cursive", "Comic Sans MS", "Coming Soon, cursive", "Comfortaa, cursive", "Concert One, cursive", "Condiment, cursive", "Consolas", "Constantia", "Content, cursive", "Contrail One, cursive", "Convergence, sans-serif", "Cookie, cursive", "Copperplate Gothic", "Copperplate Gothic Light", "Copse, serif", "Corbel", "Corben, cursive", "Cordia New", "CordiaUPC", "Cormorant, serif", "Cormorant Garamond, serif", "Cormorant Infant, serif", "Cormorant SC, serif", "Cormorant Unicase, serif", "Cormorant Upright, serif", "Courgette, cursive", "Courier New", "Cousine, monospace", "Coustard, serif", "Covered By Your Grace, cursive", "Crafty Girls, cursive", "Creepster, cursive", "Crete Round, serif", "Crimson Text, serif", "Croissant One, cursive", "Crushed, cursive", "Cuprum, sans-serif", "Cute Font, cursive", "Cutive, serif", "Cutive Mono, monospace", "Damion, cursive", "Dancing Script, cursive", "Dangrek, cursive", "DaunPenh", "David", "David Libre, serif", "Dawning of a New Day, cursive", "Days One, sans-serif", "Delius, cursive", "Delius Swash Caps, cursive", "Delius Unicase, cursive", "Della Respira, serif", "Denk One, sans-serif", "Devonshire, cursive", "DFKai-SB", "Dhurjati, sans-serif", "Didact Gothic, sans-serif", "DilleniaUPC", "Diplomata, cursive", "Diplomata SC, cursive", "Do Hyeon, sans-serif", "DokChampa", "Dokdo, cursive", "Domine, serif", "Donegal One, serif", "Doppio One, sans-serif", "Dorsa, sans-serif", "Dosis, sans-serif", "Dotum", "DotumChe", "Dr Sugiyama, cursive", "Duru Sans, sans-serif", "Dynalight, cursive", "Eagle Lake, cursive", "East Sea Dokdo, cursive", "Eater, cursive", "EB Garamond, serif", "Ebrima", "Economica, sans-serif", "Eczar, serif", "El Messiri, sans-serif", "Electrolize, sans-serif", "Elsie, cursive", "Elsie Swash Caps, cursive", "Emblema One, cursive", "Emilys Candy, cursive", "Encode Sans, sans-serif", "Encode Sans Condensed, sans-serif", "Encode Sans Expanded, sans-serif", "Encode Sans Semi Condensed, sans-serif", "Encode Sans Semi Expanded, sans-serif", "Engagement, cursive", "Englebert, sans-serif", "Enriqueta, serif", "Erica One, cursive", "Esteban, serif", "Estrangelo Edessa", "EucrosiaUPC", "Euphemia", "Euphoria Script, cursive", "Ewert, cursive", "Exo, sans-serif", "Expletus Sans, cursive", "FangSong", "Fanwood Text, serif", "Farsan, cursive", "Fascinate, cursive", "Fascinate Inline, cursive", "Faster One, cursive", "Fasthand, serif", "Fauna One, serif", "Faustina, serif", "Federant, cursive", "Federo, sans-serif", "Felipa, cursive", "Fenix, serif", "Finger Paint, cursive", "Fira Mono, monospace", "Fira Sans, sans-serif", "Fira Sans Condensed, sans-serif", "Fira Sans Extra Condensed, sans-serif", "Fjalla One, sans-serif", "Fjord One, serif", "Flamenco, cursive", "Flavors, cursive", "Fondamento, cursive", "Fontdiner Swanky, cursive", "Forum, cursive", "Francois One, sans-serif", "Frank Ruhl Libre, serif", "Franklin Gothic Medium", "FrankRuehl", "Freckle Face, cursive", "Fredericka the Great, cursive", "Fredoka One, cursive", "Freehand, cursive", "FreesiaUPC", "Fresca, sans-serif", "Frijole, cursive", "Fruktur, cursive", "Fugaz One, cursive", "Gabriela, serif", "Gabriola", "Gadugi", "Gaegu, cursive", "Gafata, sans-serif", "Galada, cursive", "Galdeano, sans-serif", "Galindo, cursive", "Gamja Flower, cursive", "Gautami", "Gentium Basic, serif", "Gentium Book Basic, serif", "Geo, sans-serif", "Georgia", "Geostar, cursive", "Geostar Fill, cursive", "Germania One, cursive", "GFS Didot, serif", "GFS Neohellenic, sans-serif", "Gidugu, sans-serif", "Gilda Display, serif", "Gisha", "Give You Glory, cursive", "Glass Antiqua, cursive", "Glegoo, serif", "Gloria Hallelujah, cursive", "Goblin One, cursive", "Gochi Hand, cursive", "Gorditas, cursive", "Gothic A1, sans-serif", "Graduate, cursive", "Grand Hotel, cursive", "Gravitas One, cursive", "Great Vibes, cursive", "Griffy, cursive", "Gruppo, cursive", "Gudea, sans-serif", "Gugi, cursive", "Gulim", "GulimChe", "Gungsuh", "GungsuhChe", "Gurajada, serif", "Habibi, serif", "Halant, serif", "Hammersmith One, sans-serif", "Hanalei, cursive", "Hanalei Fill, cursive", "Handlee, cursive", "Hanuman, serif", "Happy Monkey, cursive", "Harmattan, sans-serif", "Headland One, serif", "Heebo, sans-serif", "Henny Penny, cursive", "Herr Von Muellerhoff, cursive", "Hi Melody, cursive", "Hind, sans-serif", "Holtwood One SC, serif", "Homemade Apple, cursive", "Homenaje, sans-serif", "IBM Plex Mono, monospace", "IBM Plex Sans, sans-serif", "IBM Plex Sans Condensed, sans-serif", "IBM Plex Serif, serif", "Iceberg, cursive", "Iceland, cursive", "IM Fell Double Pica, serif", "IM Fell Double Pica SC, serif", "IM Fell DW Pica, serif", "IM Fell DW Pica SC, serif", "IM Fell English, serif", "IM Fell English SC, serif", "IM Fell French Canon, serif", "IM Fell French Canon SC, serif", "IM Fell Great Primer, serif", "IM Fell Great Primer SC, serif", "Impact", "Imprima, sans-serif", "Inconsolata, monospace", "Inder, sans-serif", "Indie Flower, cursive", "Inika, serif", "Irish Grover, cursive", "IrisUPC", "Istok Web, sans-serif", "Iskoola Pota", "Italiana, serif", "Italianno, cursive", "Itim, cursive", "Jacques Francois, serif", "Jacques Francois Shadow, cursive", "Jaldi, sans-serif", "JasmineUPC", "Jim Nightshade, cursive", "Jockey One, sans-serif", "Jolly Lodger, cursive", "Jomhuria, cursive", "Josefin Sans, sans-serif", "Josefin Slab, serif", "Joti One, cursive", "Jua, sans-serif", "Judson, serif", "Julee, cursive", "Julius Sans One, sans-serif", "Junge, serif", "Jura, sans-serif", "Just Another Hand, cursive", "Just Me Again Down Here, cursive", "Kadwa, serif", "KaiTi", "Kalam, cursive", "Kalinga", "Kameron, serif", "Kanit, sans-serif", "Kantumruy, sans-serif", "Karla, sans-serif", "Karma, serif", "Kartika", "Katibeh, cursive", "Kaushan Script, cursive", "Kavivanar, cursive", "Kavoon, cursive", "Kdam Thmor, cursive", "Keania One, cursive", "Kelly Slab, cursive", "Kenia, cursive", "Khand, sans-serif", "Khmer, cursive", "Khmer UI", "Khula, sans-serif", "Kirang Haerang, cursive", "Kite One, sans-serif", "Knewave, cursive", "KodchiangUPC", "Kokila", "Kotta One, serif", "Koulen, cursive", "Kranky, cursive", "Kreon, serif", "Kristi, cursive", "Krona One, sans-serif", "Kurale, serif", "La Belle Aurore, cursive", "Laila, serif", "Lakki Reddy, cursive", "Lalezar, cursive", "Lancelot, cursive", "Lao UI", "Lateef, cursive", "Latha", "Lato, sans-serif", "League Script, cursive", "Leckerli One, cursive", "Ledger, serif", "Leelawadee", "Lekton, sans-serif", "Lemon, cursive", "Lemonada, cursive", "Levenim MT", "Libre Baskerville, serif", "Libre Franklin, sans-serif", "Life Savers, cursive", "Lilita One, cursive", "Lily Script One, cursive", "LilyUPC", "Limelight, cursive", "Linden Hill, serif", "Lobster, cursive", "Lobster Two, cursive", "Londrina Outline, cursive", "Londrina Shadow, cursive", "Londrina Sketch, cursive", "Londrina Solid, cursive", "Lora, serif", "Love Ya Like A Sister, cursive", "Loved by the King, cursive", "Lovers Quarrel, cursive", "Lucida Console", "Lucida Handwriting Italic", "Lucida Sans Unicode", "Luckiest Guy, cursive", "Lusitana, serif", "Lustria, serif", "Macondo, cursive", "Macondo Swash Caps, cursive", "Mada, sans-serif", "Magra, sans-serif", "Maiden Orange, cursive", "Maitree, serif", "Mako, sans-serif", "Malgun Gothic", "Mallanna, sans-serif", "Mandali, sans-serif", "Mangal", "Manny ITC", "Manuale, serif", "Marcellus, serif", "Marcellus SC, serif", "Marck Script, cursive", "Margarine, cursive", "Marko One, serif", "Marlett", "Marmelad, sans-serif", "Martel, serif", "Martel Sans, sans-serif", "Marvel, sans-serif", "Mate, serif", "Mate SC, serif", "Maven Pro, sans-serif", "McLaren, cursive", "Meddon, cursive", "MedievalSharp, cursive", "Medula One, cursive", "Meera Inimai, sans-serif", "Megrim, cursive", "Meie Script, cursive", "Meiryo", "Meiryo UI", "Merienda, cursive", "Merienda One, cursive", "Merriweather, serif", "Merriweather Sans, sans-serif", "Metal, cursive", "Metal Mania, cursive", "Metamorphous, cursive", "Metrophobic, sans-serif", "Michroma, sans-serif", "Microsoft Himalaya", "Microsoft JhengHei", "Microsoft JhengHei UI", "Microsoft New Tai Lue", "Microsoft PhagsPa", "Microsoft Sans Serif", "Microsoft Tai Le", "Microsoft Uighur", "Microsoft YaHei", "Microsoft YaHei UI", "Microsoft Yi Baiti", "Milonga, cursive", "Miltonian, cursive", "Miltonian Tattoo, cursive", "Mina, sans-serif", "MingLiU_HKSCS", "MingLiU_HKSCS-ExtB", "Miniver, cursive", "Miriam", "Miriam Libre, sans-serif", "Mirza, cursive", "Miss Fajardose, cursive", "Mitr, sans-serif", "Modak, cursive", "Modern Antiqua, cursive", "Mogra, cursive", "Molengo, sans-serif", "Molle, cursive", "Monda, sans-serif", "Mongolian Baiti", "Monofett, cursive", "Monoton, cursive", "Monsieur La Doulaise, cursive", "Montaga, serif", "Montez, cursive", "Montserrat, sans-serif", "Montserrat Alternates, sans-serif", "Montserrat Subrayada, sans-serif", "MoolBoran", "Moul, cursive", "Moulpali, cursive", "Mountains of Christmas, cursive", "Mouse Memoirs, sans-serif", "Mr Bedfort, cursive", "Mr Dafoe, cursive", "Mr De Haviland, cursive", "Mrs Saint Delafield, cursive", "Mrs Sheppards, cursive", "MS UI Gothic", "Mukta, sans-serif", "Muli, sans-serif", "MV Boli", "Myanmar Text", "Mystery Quest, cursive", "Nanum Brush Script, cursive", "Nanum Gothic, sans-serif", "Nanum Gothic Coding, monospace", "Nanum Myeongjo, serif", "Nanum Pen Script, cursive", "Narkisim", "Neucha, cursive", "Neuton, serif", "New Rocker, cursive", "News Cycle, sans-serif", "News Gothic MT", "Niconne, cursive", "Nirmala UI", "Nixie One, cursive", "Nobile, sans-serif", "Nokora, serif", "Norican, cursive", "Nosifer, cursive", "Nothing You Could Do, cursive", "Noticia Text, serif", "Noto Sans, sans-serif", "Noto Serif, serif", "Nova Cut, cursive", "Nova Flat, cursive", "Nova Mono, monospace", "Nova Oval, cursive", "Nova Round, cursive", "Nova Script, cursive", "Nova Slim, cursive", "Nova Square, cursive", "NSimSun", "NTR, sans-serif", "Numans, sans-serif", "Nunito, sans-serif", "Nunito Sans, sans-serif", "Nyala", "Odor Mean Chey, cursive", "Offside, cursive", "Old Standard TT, serif", "Oldenburg, cursive", "Oleo Script, cursive", "Oleo Script Swash Caps, cursive", "Open Sans, sans-serif", "Open Sans Condensed, sans-serif", "Oranienbaum, serif", "Orbitron, sans-serif", "Oregano, cursive", "Orienta, sans-serif", "Original Surfer, cursive", "Oswald, sans-serif", "Over the Rainbow, cursive", "Overlock, cursive", "Overlock SC, cursive", "Overpass, sans-serif", "Overpass Mono, monospace", "Ovo, serif", "Oxygen, sans-serif", "Oxygen Mono, monospace", "Pacifico, cursive", "Padauk, sans-serif", "Palanquin, sans-serif", "Palanquin Dark, sans-serif", "Palatino Linotype", "Pangolin, cursive", "Paprika, cursive", "Parisienne, cursive", "Passero One, cursive", "Passion One, cursive", "Pathway Gothic One, sans-serif", "Patrick Hand, cursive", "Patrick Hand SC, cursive", "Pattaya, sans-serif", "Patua One, cursive", "Pavanam, sans-serif", "Paytone One, sans-serif", "Peddana, serif", "Peralta, cursive", "Permanent Marker, cursive", "Petit Formal Script, cursive", "Petrona, serif", "Philosopher, sans-serif", "Piedra, cursive", "Pinyon Script, cursive", "Pirata One, cursive", "Plantagenet Cherokee", "Plaster, cursive", "Play, sans-serif", "Playball, cursive", "Playfair Display, serif", "Playfair Display SC, serif", "Podkova, serif", "Poiret One, cursive", "Poller One, cursive", "Poly, serif", "Pompiere, cursive", "Pontano Sans, sans-serif", "Poor Story, cursive", "Poppins, sans-serif", "Port Lligat Sans, sans-serif", "Port Lligat Slab, serif", "Pragati Narrow, sans-serif", "Prata, serif", "Preahvihear, cursive", "Pridi, serif", "Princess Sofia, cursive", "Prociono, serif", "Prompt, sans-serif", "Prosto One, cursive", "Proza Libre, sans-serif", "PT Mono, monospace", "PT Sans, sans-serif", "PT Sans Caption, sans-serif", "PT Sans Narrow, sans-serif", "PT Serif, serif", "PT Serif Caption, serif", "Puritan, sans-serif", "Purple Purse, cursive", "Quando, serif", "Quantico, sans-serif", "Quattrocento, serif", "Quattrocento Sans, sans-serif", "Questrial, sans-serif", "Quicksand, sans-serif", "Quintessential, cursive", "Qwigley, cursive", "Raavi", "Racing Sans One, cursive", "Radley, serif", "Rajdhani, sans-serif", "Rakkas, cursive", "Raleway, sans-serif", "Raleway Dots, cursive", "Ramabhadra, sans-serif", "Ramaraja, serif", "Rambla, sans-serif", "Rammetto One, cursive", "Ranchers, cursive", "Rancho, cursive", "Ranga, cursive", "Rasa, serif", "Rationale, sans-serif", "Ravi Prakash, cursive", "Redressed, cursive", "Reem Kufi, sans-serif", "Reenie Beanie, cursive", "Revalia, cursive", "Rhodium Libre, serif", "Ribeye, cursive", "Ribeye Marrow, cursive", "Righteous, cursive", "Risque, cursive", "Roboto, sans-serif", "Roboto Condensed, sans-serif", "Roboto Mono, monospace", "Roboto Slab, serif", "Rochester, cursive", "Rock Salt, cursive", "Rod", "Rokkitt, serif", "Romanesco, cursive", "Ropa Sans, sans-serif", "Rosario, sans-serif", "Rosarivo, serif", "Rouge Script, cursive", "Rozha One, serif", "Rubik, sans-serif", "Rubik Mono One, sans-serif", "Ruda, sans-serif", "Rufina, serif", "Ruge Boogie, cursive", "Ruluko, sans-serif", "Rum Raisin, sans-serif", "Ruslan Display, cursive", "Russo One, sans-serif", "Ruthie, cursive", "Rye, cursive", "Sacramento, cursive", "Sahitya, serif", "Sail, cursive", "Saira, sans-serif", "Saira Condensed, sans-serif", "Saira Extra Condensed, sans-serif", "Saira Semi Condensed, sans-serif", "Sakkal Majalla", "Salsa, cursive", "Sanchez, serif", "Sancreek, cursive", "Sansita, sans-serif", "Sarala, sans-serif", "Sarina, cursive", "Sarpanch, sans-serif", "Satisfy, cursive", "Scada, sans-serif", "Scheherazade, serif", "Schoolbell, cursive", "Scope One, serif", "Seaweed Script, cursive", "Secular One, sans-serif", "Sedgwick Ave, cursive", "Sedgwick Ave Display, cursive", "Segoe Print", "Segoe Script", "Segoe UI Symbol", "Sevillana, cursive", "Seymour One, sans-serif", "Shadows Into Light, cursive", "Shadows Into Light Two, cursive", "Shanti, sans-serif", "Share, cursive", "Share Tech, sans-serif", "Share Tech Mono, monospace", "Shojumaru, cursive", "Shonar Bangla", "Short Stack, cursive", "Shrikhand, cursive", "Shruti", "Siemreap, cursive", "Sigmar One, cursive", "Signika, sans-serif", "Signika Negative, sans-serif", "SimHei", "SimKai", "Simonetta, cursive", "Simplified Arabic", "SimSun", "SimSun-ExtB", "Sintony, sans-serif", "Sirin Stencil, cursive", "Six Caps, sans-serif", "Skranji, cursive", "Slackey, cursive", "Smokum, cursive", "Smythe, cursive", "Sniglet, cursive", "Snippet, sans-serif", "Snowburst One, cursive", "Sofadi One, cursive", "Sofia, cursive", "Song Myung, serif", "Sonsie One, cursive", "Sorts Mill Goudy, serif", "Source Code Pro, monospace", "Source Sans Pro, sans-serif", "Source Serif Pro, serif", "Space Mono, monospace", "Special Elite, cursive", "Spectral, serif", "Spectral SC, serif", "Spicy Rice, cursive", "Spinnaker, sans-serif", "Spirax, cursive", "Squada One, cursive", "Sree Krushnadevaraya, serif", "Sriracha, cursive", "Stalemate, cursive", "Stalinist One, cursive", "Stardos Stencil, cursive", "Stint Ultra Condensed, cursive", "Stint Ultra Expanded, cursive", "Stoke, serif", "Strait, sans-serif", "Stylish, sans-serif", "Sue Ellen Francisco, cursive", "Suez One, serif", "Sumana, serif", "Sunflower, sans-serif", "Sunshiney, cursive", "Supermercado One, cursive", "Sura, serif", "Suranna, serif", "Suravaram, serif", "Suwannaphum, cursive", "Swanky and Moo Moo, cursive", "Sylfaen", "Syncopate, sans-serif", "Tahoma", "Tajawal, sans-serif", "Tangerine, cursive", "Taprom, cursive", "Tauri, sans-serif", "Taviraj, serif", "Teko, sans-serif", "Telex, sans-serif", "Tenali Ramakrishna, sans-serif", "Tenor Sans, sans-serif", "Text Me One, sans-serif", "The Girl Next Door, cursive", "Tienne, serif", "Tillana, cursive", "Times New Roman", "Timmana, sans-serif", "Tinos, serif", "Titan One, cursive", "Titillium Web, sans-serif", "Trade Winds, cursive", "Traditional Arabic", "Trebuchet MS", "Trirong, serif", "Trocchi, serif", "Trochut, cursive", "Trykker, serif", "Tulpen One, cursive", "Tunga", "Ubuntu, sans-serif", "Ubuntu Condensed, sans-serif", "Ubuntu Mono, monospace", "Ultra, serif", "Uncial Antiqua, cursive", "Underdog, cursive", "Unica One, cursive", "UnifrakturCook, cursive", "UnifrakturMaguntia, cursive", "Unkempt, cursive", "Unlock, cursive", "Unna, serif", "Utsaah", "Vampiro One, cursive", "Vani", "Varela, sans-serif", "Varela Round, sans-serif", "Vast Shadow, cursive", "Vesper Libre, serif", "Vibur, cursive", "Vidaloka, serif", "Viga, sans-serif", "Vijaya", "Voces, cursive", "Volkhov, serif", "Vollkorn, serif", "Vollkorn SC, serif", "Voltaire, sans-serif", "VT323, monospace", "Waiting for the Sunrise, cursive", "Wallpoet, cursive", "Walter Turncoat, cursive", "Warnes, cursive", "Wellfleet, cursive", "Wendy One, sans-serif", "Wire One, sans-serif", "Work Sans, sans-serif", "Yanone Kaffeesatz, sans-serif", "Yantramanav, sans-serif", "Yatra One, cursive", "Yellowtail, cursive", "Yeon Sung, cursive", "Yeseva One, cursive", "Yesteryear, cursive", "Yrsa, serif", "Zeyada, cursive", "Zilla Slab, serif", "Zilla Slab Highlight, cursive");

	$TotalSoftCalCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name4 WHERE id>%d", 0));
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../CSS/totalsoft.css',__FILE__);?>">
<link href="https://fonts.googleapis.com/css?family=ABeeZee|Abel|Abhaya+Libre|Abril+Fatface|Aclonica|Acme|Actor|Adamina|Advent+Pro|Aguafina+Script|Akronim|Aladin|Aldrich|Alef|Alegreya|Alegreya+SC|Alegreya+Sans|Alegreya+Sans+SC|Alex+Brush|Alfa+Slab+One|Alice|Alike|Alike+Angular|Allan|Allerta|Allerta+Stencil|Allura|Almendra|Almendra+Display|Almendra+SC|Amarante|Amaranth|Amatic+SC|Amethysta|Amiko|Amiri|Amita|Anaheim|Andada|Andika|Angkor|Annie+Use+Your+Telescope|Anonymous+Pro|Antic|Antic+Didone|Antic+Slab|Anton|Arapey|Arbutus|Arbutus+Slab|Architects+Daughter|Archivo|Archivo+Black|Archivo+Narrow|Aref+Ruqaa|Arima+Madurai|Arimo|Arizonia|Armata|Arsenal|Artifika|Arvo|Arya|Asap|Asap+Condensed|Asar|Asset|Assistant|Astloch|Asul|Athiti|Atma|Atomic+Age|Aubrey|Audiowide|Autour+One|Average|Average+Sans|Averia+Gruesa+Libre|Averia+Libre|Averia+Sans+Libre|Averia+Serif+Libre|Bad+Script|Bahiana|Baloo|Baloo+Bhai|Baloo+Bhaijaan|Baloo+Bhaina|Baloo+Chettan|Baloo+Da|Baloo+Paaji|Baloo+Tamma|Baloo+Tammudu|Baloo+Thambi|Balthazar|Bangers|Barlow|Barlow+Condensed|Barlow+Semi+Condensed|Barrio|Basic|Battambang|Baumans|Bayon|Belgrano|Bellefair|Belleza|BenchNine|Bentham|Berkshire+Swash|Bevan|Bigelow+Rules|Bigshot+One|Bilbo|Bilbo+Swash+Caps|BioRhyme|BioRhyme+Expanded|Biryani|Bitter|Black+And+White+Picture|Black+Han+Sans|Black+Ops+One|Bokor|Bonbon|Boogaloo|Bowlby+One|Bowlby+One+SC|Brawler|Bree+Serif|Bubblegum+Sans|Bubbler+One|Buda:300|Buenard|Bungee|Bungee+Hairline|Bungee+Inline|Bungee+Outline|Bungee+Shade|Butcherman|Butterfly+Kids|Cabin|Cabin+Condensed|Cabin+Sketch|Caesar+Dressing|Cagliostro|Cairo|Calligraffitti|Cambay|Cambo|Candal|Cantarell|Cantata+One|Cantora+One|Capriola|Cardo|Carme|Carrois+Gothic|Carrois+Gothic+SC|Carter+One|Catamaran|Caudex|Caveat|Caveat+Brush|Cedarville+Cursive|Ceviche+One|Changa|Changa+One|Chango|Chathura|Chau+Philomene+One|Chela+One|Chelsea+Market|Chenla|Cherry+Cream+Soda|Cherry+Swash|Chewy|Chicle|Chivo|Chonburi|Cinzel|Cinzel+Decorative|Clicker+Script|Coda|Coda+Caption:800|Codystar|Coiny|Combo|Comfortaa|Coming+Soon|Concert+One|Condiment|Content|Contrail+One|Convergence|Cookie|Copse|Corben|Cormorant|Cormorant+Garamond|Cormorant+Infant|Cormorant+SC|Cormorant+Unicase|Cormorant+Upright|Courgette|Cousine|Coustard|Covered+By+Your+Grace|Crafty+Girls|Creepster|Crete+Round|Crimson+Text|Croissant+One|Crushed|Cuprum|Cute+Font|Cutive|Cutive+Mono|Damion|Dancing+Script|Dangrek|David+Libre|Dawning+of+a+New+Day|Days+One|Dekko|Delius|Delius+Swash+Caps|Delius+Unicase|Della+Respira|Denk+One|Devonshire|Dhurjati|Didact+Gothic|Diplomata|Diplomata+SC|Do+Hyeon|Dokdo|Domine|Donegal+One|Doppio+One|Dorsa|Dosis|Dr+Sugiyama|Duru+Sans|Dynalight|EB+Garamond|Eagle+Lake|East+Sea+Dokdo|Eater|Economica|Eczar|El+Messiri|Electrolize|Elsie|Elsie+Swash+Caps|Emblema+One|Emilys+Candy|Encode+Sans|Encode+Sans+Condensed|Encode+Sans+Expanded|Encode+Sans+Semi+Condensed|Encode+Sans+Semi+Expanded|Engagement|Englebert|Enriqueta|Erica+One|Esteban|Euphoria+Script|Ewert|Exo|Exo+2|Expletus+Sans|Fanwood+Text|Farsan|Fascinate|Fascinate+Inline|Faster+One|Fasthand|Fauna+One|Faustina|Federant|Federo|Felipa|Fenix|Finger+Paint|Fira+Mono|Fira+Sans|Fira+Sans+Condensed|Fira+Sans+Extra+Condensed|Fjalla+One|Fjord+One|Flamenco|Flavors|Fondamento|Fontdiner+Swanky|Forum|Francois+One|Frank+Ruhl+Libre|Freckle+Face|Fredericka+the+Great|Fredoka+One|Freehand|Fresca|Frijole|Fruktur|Fugaz+One|GFS+Didot|GFS+Neohellenic|Gabriela|Gaegu|Gafata|Galada|Galdeano|Galindo|Gamja+Flower|Gentium+Basic|Gentium+Book+Basic|Geo|Geostar|Geostar+Fill|Germania+One|Gidugu|Gilda+Display|Give+You+Glory|Glass+Antiqua|Glegoo|Gloria+Hallelujah|Goblin+One|Gochi+Hand|Gorditas|Gothic+A1|Goudy+Bookletter+1911|Graduate|Grand+Hotel|Gravitas+One|Great+Vibes|Griffy|Gruppo|Gudea|Gugi|Gurajada|Habibi|Halant|Hammersmith+One|Hanalei|Hanalei+Fill|Handlee|Hanuman|Happy+Monkey|Harmattan|Headland+One|Heebo|Henny+Penny|Herr+Von+Muellerhoff|Hi+Melody|Hind|Hind+Guntur|Hind+Madurai|Hind+Siliguri|Hind+Vadodara|Holtwood+One+SC|Homemade+Apple|Homenaje|IBM+Plex+Mono|IBM+Plex+Sans|IBM+Plex+Sans+Condensed|IBM+Plex+Serif|IM+Fell+DW+Pica|IM+Fell+DW+Pica+SC|IM+Fell+Double+Pica|IM+Fell+Double+Pica+SC|IM+Fell+English|IM+Fell+English+SC|IM+Fell+French+Canon|IM+Fell+French+Canon+SC|IM+Fell+Great+Primer|IM+Fell+Great+Primer+SC|Iceberg|Iceland|Imprima|Inconsolata|Inder|Indie+Flower|Inika|Inknut+Antiqua|Irish+Grover|Istok+Web|Italiana|Italianno|Itim|Jacques+Francois|Jacques+Francois+Shadow|Jaldi|Jim+Nightshade|Jockey+One|Jolly+Lodger|Jomhuria|Josefin+Sans|Josefin+Slab|Joti+One|Jua|Judson|Julee|Julius+Sans+One|Junge|Jura|Just+Another+Hand|Just+Me+Again+Down+Here|Kadwa|Kalam|Kameron|Kanit|Kantumruy|Karla|Karma|Katibeh|Kaushan+Script|Kavivanar|Kavoon|Kdam+Thmor|Keania+One|Kelly+Slab|Kenia|Khand|Khmer|Khula|Kirang+Haerang|Kite+One|Knewave|Kotta+One|Koulen|Kranky|Kreon|Kristi|Krona+One|Kurale|La+Belle+Aurore|Laila|Lakki+Reddy|Lalezar|Lancelot|Lateef|Lato|League+Script|Leckerli+One|Ledger|Lekton|Lemon|Lemonada|Libre+Barcode+128|Libre+Barcode+128+Text|Libre+Barcode+39|Libre+Barcode+39+Extended|Libre+Barcode+39+Extended+Text|Libre+Barcode+39+Text|Libre+Baskerville|Libre+Franklin|Life+Savers|Lilita+One|Lily+Script+One|Limelight|Linden+Hill|Lobster|Lobster+Two|Londrina+Outline|Londrina+Shadow|Londrina+Sketch|Londrina+Solid|Lora|Love+Ya+Like+A+Sister|Loved+by+the+King|Lovers+Quarrel|Luckiest+Guy|Lusitana|Lustria|Macondo|Macondo+Swash+Caps|Mada|Magra|Maiden+Orange|Maitree|Mako|Mallanna|Mandali|Manuale|Marcellus|Marcellus+SC|Marck+Script|Margarine|Marko+One|Marmelad|Martel|Martel+Sans|Marvel|Mate|Mate+SC|Maven+Pro|McLaren|Meddon|MedievalSharp|Medula+One|Meera+Inimai|Megrim|Meie+Script|Merienda|Merienda+One|Merriweather|Merriweather+Sans|Metal|Metal+Mania|Metamorphous|Metrophobic|Michroma|Milonga|Miltonian|Miltonian+Tattoo|Mina|Miniver|Miriam+Libre|Mirza|Miss+Fajardose|Mitr|Modak|Modern+Antiqua|Mogra|Molengo|Molle:400i|Monda|Monofett|Monoton|Monsieur+La+Doulaise|Montaga|Montez|Montserrat|Montserrat+Alternates|Montserrat+Subrayada|Moul|Moulpali|Mountains+of+Christmas|Mouse+Memoirs|Mr+Bedfort|Mr+Dafoe|Mr+De+Haviland|Mrs+Saint+Delafield|Mrs+Sheppards|Mukta|Mukta+Mahee|Mukta+Malar|Mukta+Vaani|Muli|Mystery+Quest|NTR|Nanum+Brush+Script|Nanum+Gothic|Nanum+Gothic+Coding|Nanum+Myeongjo|Nanum+Pen+Script|Neucha|Neuton|New+Rocker|News+Cycle|Niconne|Nixie+One|Nobile|Nokora|Norican|Nosifer|Nothing+You+Could+Do|Noticia+Text|Noto+Sans|Noto+Serif|Nova+Cut|Nova+Flat|Nova+Mono|Nova+Oval|Nova+Round|Nova+Script|Nova+Slim|Nova+Square|Numans|Nunito|Nunito+Sans|Odor+Mean+Chey|Offside|Old+Standard+TT|Oldenburg|Oleo+Script|Oleo+Script+Swash+Caps|Open+Sans|Open+Sans+Condensed:300|Oranienbaum|Orbitron|Oregano|Orienta|Original+Surfer|Oswald|Over+the+Rainbow|Overlock|Overlock+SC|Overpass|Overpass+Mono|Ovo|Oxygen|Oxygen+Mono|PT+Mono|PT+Sans|PT+Sans+Caption|PT+Sans+Narrow|PT+Serif|PT+Serif+Caption|Pacifico|Padauk|Palanquin|Palanquin+Dark|Pangolin|Paprika|Parisienne|Passero+One|Passion+One|Pathway+Gothic+One|Patrick+Hand|Patrick+Hand+SC|Pattaya|Patua+One|Pavanam|Paytone+One|Peddana|Peralta|Permanent+Marker|Petit+Formal+Script|Petrona|Philosopher|Piedra|Pinyon+Script|Pirata+One|Plaster|Play|Playball|Playfair+Display|Playfair+Display+SC|Podkova|Poiret+One|Poller+One|Poly|Pompiere|Pontano+Sans|Poor+Story|Poppins|Port+Lligat+Sans|Port+Lligat+Slab|Pragati+Narrow|Prata|Preahvihear|Press+Start+2P|Pridi|Princess+Sofia|Prociono|Prompt|Prosto+One|Proza+Libre|Puritan|Purple+Purse|Quando|Quantico|Quattrocento|Quattrocento+Sans|Questrial|Quicksand|Quintessential|Qwigley|Racing+Sans+One|Radley|Rajdhani|Rakkas|Raleway|Raleway+Dots|Ramabhadra|Ramaraja|Rambla|Rammetto+One|Ranchers|Rancho|Ranga|Rasa|Rationale|Ravi+Prakash|Redressed|Reem+Kufi|Reenie+Beanie|Revalia|Rhodium+Libre|Ribeye|Ribeye+Marrow|Righteous|Risque|Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab|Rochester|Rock+Salt|Rokkitt|Romanesco|Ropa+Sans|Rosario|Rosarivo|Rouge+Script|Rozha+One|Rubik|Rubik+Mono+One|Ruda|Rufina|Ruge+Boogie|Ruluko|Rum+Raisin|Ruslan+Display|Russo+One|Ruthie|Rye|Sacramento|Sahitya|Sail|Saira|Saira+Condensed|Saira+Extra+Condensed|Saira+Semi+Condensed|Salsa|Sanchez|Sancreek|Sansita|Sarala|Sarina|Sarpanch|Satisfy|Scada|Scheherazade|Schoolbell|Scope+One|Seaweed+Script|Secular+One|Sedgwick+Ave|Sedgwick+Ave+Display|Sevillana|Seymour+One|Shadows+Into+Light|Shadows+Into+Light+Two|Shanti|Share|Share+Tech|Share+Tech+Mono|Shojumaru|Short+Stack|Shrikhand|Siemreap|Sigmar+One|Signika|Signika+Negative|Simonetta|Sintony|Sirin+Stencil|Six+Caps|Skranji|Slabo+13px|Slabo+27px|Slackey|Smokum|Smythe|Sniglet|Snippet|Snowburst+One|Sofadi+One|Sofia|Song+Myung|Sonsie+One|Sorts+Mill+Goudy|Source+Code+Pro|Source+Sans+Pro|Source+Serif+Pro|Space+Mono|Special+Elite|Spectral|Spectral+SC|Spicy+Rice|Spinnaker|Spirax|Squada+One|Sree+Krushnadevaraya|Sriracha|Stalemate|Stalinist+One|Stardos+Stencil|Stint+Ultra+Condensed|Stint+Ultra+Expanded|Stoke|Strait|Stylish|Sue+Ellen+Francisco|Suez+One|Sumana|Sunflower:300|Sunshiney|Supermercado+One|Sura|Suranna|Suravaram|Suwannaphum|Swanky+and+Moo+Moo|Syncopate|Tajawal|Tangerine|Taprom|Tauri|Taviraj|Teko|Telex|Tenali+Ramakrishna|Tenor+Sans|Text+Me+One|The+Girl+Next+Door|Tienne|Tillana|Timmana|Tinos|Titan+One|Titillium+Web|Trade+Winds|Trirong|Trocchi|Trochut|Trykker|Tulpen+One|Ubuntu|Ubuntu+Condensed|Ubuntu+Mono|Ultra|Uncial+Antiqua|Underdog|Unica+One|UnifrakturCook:700|UnifrakturMaguntia|Unkempt|Unlock|Unna|VT323|Vampiro+One|Varela|Varela+Round|Vast+Shadow|Vesper+Libre|Vibur|Vidaloka|Viga|Voces|Volkhov|Vollkorn|Vollkorn+SC|Voltaire|Waiting+for+the+Sunrise|Wallpoet|Walter+Turncoat|Warnes|Wellfleet|Wendy+One|Wire+One|Work+Sans|Yanone+Kaffeesatz|Yantramanav|Yatra+One|Yellowtail|Yeon+Sung|Yeseva+One|Yesteryear|Yrsa|Zeyada|Zilla+Slab|Zilla+Slab+Highlight" rel="stylesheet">
<form method="POST" oninput="TotalSoft_Cal_Out()">
	<?php wp_nonce_field( 'edit-menu_', 'TS_CalEv_Nonce' );?>
	<div class="Total_Soft_Cal_AMD">
		<a href="https://total-soft.com/wp-event-calendar/" target="_blank" title="Click to Buy">
			<div class="Full_Version"><i class="totalsoft totalsoft-cart-arrow-down"></i><span style="margin-left:5px;">Get The Full Version</span></div>
		</a>
		<div class="Full_Version_Span">
			This is the free version of the plugin.
		</div>
		<div class="Support_Span">
			<a href="https://wordpress.org/support/plugin/calendar-event/" target="_blank" title="Click Here to Ask">
				<i class="totalsoft totalsoft-comments-o"></i><span style="margin-left:5px;">If you have any questions click here to ask it to our support.</span>
			</a>
		</div>
		<div class="Total_Soft_Cal_AMD1"></div>
		<div class="Total_Soft_Cal_AMD2">
			<i class="Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Creating New Calendar', 'Total-Soft-Calendar' );?>"></i>
			<span class="Total_Soft_Cal_AMD2_But" onclick="Total_Soft_Cal_AMD2_But1(1)">
				<?php echo __( 'New Calendar (Pro)', 'Total-Soft-Calendar' );?>
			</span>
		</div>
		<div class="Total_Soft_Cal_AMD3">
			<i class="Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Canceling', 'Total-Soft-Calendar' );?>"></i>
			<span class="Total_Soft_Cal_AMD2_But" onclick="TotalSoft_Reload()">
				<?php echo __( 'Cancel', 'Total-Soft-Calendar' );?>
			</span>
			<i class="Total_Soft_Cal_Update Total_Soft_Help totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Click for Updating Settings', 'Total-Soft-Calendar' );?>"></i>
			<button type="submit" class="Total_Soft_Cal_Update Total_Soft_Cal_AMD2_But" name="Total_Soft_Cal_Update">
				<?php echo __( 'Update', 'Total-Soft-Calendar' );?>
			</button>
			<i class="Total_Soft_Help totalsoft totalsoft-question-circle-o" title="Click for Live Preview."></i>
			<span class="Total_Soft_Cal_AMD2_But" onclick="TS_CalEv_Theme_Preview()">
				<?php echo __( 'Live Preview', 'Total-Soft-Calendar' );?>
			</span>
			<input type="text" style="display:none" name="Total_SoftCal_Update" id="Total_SoftCal_Update">
			<input type="text" style="display:none" id="Total_Soft_CE_Theme_Prev" value="<?php echo home_url(); ?>?ts_cal_preview=true">
		</div>
	</div>
	<table class="Total_Soft_AMMTable">
		<tr class="Total_Soft_AMMTableFR">
			<td><?php echo __( 'No', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Calendar Name', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Events Quantity', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Live Preview', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Copy', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Edit', 'Total-Soft-Calendar' );?></td>
			<td><?php echo __( 'Delete', 'Total-Soft-Calendar' );?></td>
		</tr>
	</table>
	<table class="Total_Soft_AMOTable">
		<?php for($i=0;$i<count($TotalSoftCalCount);$i++){
			$TotalSoft_Cal_Ev=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE TotalSoftCal_EvCal=%d", $TotalSoftCalCount[$i]->id));
			?> 
			<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
				<td><?php echo $i+1;?></td>
				<td><?php echo $TotalSoftCalCount[$i]->TotalSoftCal_Name;?></td>
				<td><?php echo count($TotalSoft_Cal_Ev);?></td>
				<td>
					<a href="<?php echo home_url(); ?>?ts_cal_preview=<?php echo $TotalSoftCalCount[$i]->id;?>" class="Total_Soft_Cal_AMD2_But_LP" target="_blank">
						<i class="Total_Soft_icon totalsoft totalsoft-eye"></i>
					</a>
				</td>
				<td><i class="Total_Soft_icon totalsoft totalsoft-file-text" onclick="TotalSoftCal_Clone(<?php echo $TotalSoftCalCount[$i]->id;?>)"></i></td>
				<td><i class="Total_Soft_icon totalsoft totalsoft-pencil" onclick="TotalSoftCal_Edit(<?php echo $TotalSoftCalCount[$i]->id;?>)"></i></td>
				<td>
					<i class="Total_Soft_icon totalsoft totalsoft-trash" onclick="TotalSoftCal_Del(<?php echo $TotalSoftCalCount[$i]->id;?>)"></i>
					<span class="Total_Soft_Calendar_Del_Span">
						<i class="Total_Soft_Calendar_Del_Span_Yes totalsoft totalsoft-check" onclick="Total_Soft_Cal_AMD2_But1(<?php echo $TotalSoftCalCount[$i]->id;?>)"></i>
						<i class="Total_Soft_Calendar_Del_Span_No totalsoft totalsoft-times" onclick="TotalSoftCalendar_Del_No(<?php echo $TotalSoftCalCount[$i]->id;?>)"></i>
					</span>
				</td>
			</tr>
		<?php }?>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+1;?></td>
			<td style="position: relative; height: 27px;">Crazy Calendar 1<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-crazy-1/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+2;?></td>
			<td style="position: relative; height: 27px;">Crazy Calendar 2<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-crazy-2/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+3;?></td>
			<td style="position: relative; height: 27px;">Crazy Calendar 3<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="http://total-soft.pe.hu/wordpress-crazy-calendar-3/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+4;?></td>
			<td style="position: relative; height: 27px;">Schedule 1<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-schedule-1/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+5;?></td>
			<td style="position: relative; height: 27px;">Schedule 2<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-schedule-2/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+6;?></td>
			<td style="position: relative; height: 27px;">Schedule 3<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="http://total-soft.pe.hu/wordpress-schedule-calendar-3/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+7;?></td>
			<td style="position: relative; height: 27px;">Full Year Calendar 1<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-full-year-1/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+8;?></td>
			<td style="position: relative; height: 27px;">Full Year Calendar 2<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="https://total-soft.com/event-calendar-full-year-2/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
		<tr id="Total_Soft_AMOTable_Calendar_tr_<?php echo $TotalSoftCalCount[$i]->id;?>">
			<td><?php echo $i+9;?></td>
			<td style="position: relative; height: 27px;">Full Year Calendar 3<img src="<?php echo plugins_url('../Images/SUG-Pro.png',__FILE__);?>" style="position: absolute; top: 4px; right: 10px; width: 37px; height: 20px;"></td>
			<td>0</td>
			<td><a href="http://total-soft.pe.hu/wordpress-full-year-calendar-3/" target="_blank" class="TS_Cal_Free_Link"><i class="Total_Soft_icon totalsoft totalsoft-eye"></i></a></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-file-text"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-pencil"></i></td>
			<td onclick="Total_Soft_Cal_AMD2_But1(1)"><i class="Total_Soft_icon totalsoft totalsoft-trash"></i></td>
		</tr>
	</table>
	<div style="width: 99%;">
		<table class="Total_Soft_AMShortTable">
			<tr style="text-align:center">
				<td><?php echo __( 'Shortcode', 'Total-Soft-Calendar' );?></td>
				<td><?php echo __( 'Template Include', 'Total-Soft-Calendar' );?></td>
			</tr>
			<tr>
				<td><?php echo __( 'Copy &amp; paste the shortcode directly into any WordPress post or page.', 'Total-Soft-Calendar' );?></td>
				<td><?php echo __( 'Copy &amp; paste this code into a template file to include the calendar within your theme.', 'Total-Soft-Calendar' );?></td>
			</tr>
			<tr style="text-align:center">
				<td>
					<span id="Total_Soft_Cal_ID"></span>
					<i class="Total_Soft_Help3 totalsoft totalsoft-files-o" title="Click to Copy." onclick="Copy_Shortcode_Cal('Total_Soft_Cal_ID')"></i>
				</td>
				<td>
					<span id="Total_Soft_Cal_TID"></span>
					<i class="Total_Soft_Help3 totalsoft totalsoft-files-o" title="Click to Copy." onclick="Copy_Shortcode_Cal('Total_Soft_Cal_TID')"></i>
				</td>
			</tr>
		</table>
	</div>
	<div class="Total_Soft_Cal_Loading">
		<img src="<?php echo plugins_url('../Images/loading.gif',__FILE__);?>">
	</div>
	<div class="TS_Cal_Option_Div_Set TS_Cal_Option_Divv" id="Total_Soft_AMSetTable_Main">
		<div class="TS_Cal_Option_Divv1">
			<div class="TS_Cal_Option_Div1">
				<div class="TS_Cal_Option_Name"><?php echo __( 'Calendar Name', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar name, in which, the events should be placed.', 'Total-Soft-Calendar' );?>"></i></div>
				<div class="TS_Cal_Option_Field">
					<input type="text" name="TotalSoftCal_Name" id="TotalSoftCal_Name" class="Total_Soft_Select" required placeholder=" * <?php echo __( 'Required', 'Total-Soft-Calendar' );?>">
				</div>
			</div>
		</div>
		<div class="TS_Cal_Option_Divv2">
			<div class="TS_Cal_Option_Div1">
				<div class="TS_Cal_Option_Name"><?php echo __( 'Calendar Type', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar type, in which, the events should be placed.', 'Total-Soft-Calendar' );?>"></i></div>
				<div class="TS_Cal_Option_Field">
					<select class="Total_Soft_Select" name="TotalSoftCal_Type" id="TotalSoftCal_Type">
						<option value="Event Calendar">     <?php echo __( 'Event Calendar', 'Total-Soft-Calendar' );?>     </option>
						<option value="Simple Calendar">    <?php echo __( 'Simple Calendar', 'Total-Soft-Calendar' );?>    </option>
						<option value="Flexible Calendar">  <?php echo __( 'Flexible Calendar', 'Total-Soft-Calendar' );?>  </option>
						<option value="TimeLine Calendar">  <?php echo __( 'TimeLine Calendar', 'Total-Soft-Calendar' );?>  </option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="Total_Soft_Cal_AMSetDiv" id="Total_Soft_Cal_AMSetDiv_1">
		<div class="Total_Soft_Cal_AMSetDiv_Buttons">
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_GO" onclick="TS_Cal_TM_But('1', 'GO')">General Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_HO" onclick="TS_Cal_TM_But('1', 'HO')">Header Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_DO" onclick="TS_Cal_TM_But('1', 'DO')">Days Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_IO" onclick="TS_Cal_TM_But('1', 'IO')">Icon Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_IO" onclick="TS_Cal_TM_But('1', 'ET')">Event Title</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_1_IO" onclick="TS_Cal_TM_But('1', 'IV')">Image/Video</div>
		</div>
		<div class="Total_Soft_Cal_AMSetDiv_Content">
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_1_GO">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'General Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'WeekDay Start', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select that day in the calendar, which must be the first in the week.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal_WDStart" id="TotalSoftCal_WDStart">
							<option value="Sun"><?php echo __( 'Sunday', 'Total-Soft-Calendar' );?></option>
							<option value="Mon"><?php echo __( 'Monday', 'Total-Soft-Calendar' );?></option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose main background color in calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal_BgCol" id="TotalSoftCal_BgCol" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Grid Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select grid color which divides the days in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal_GrCol" id="TotalSoftCal_GrCol" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Grid Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the grid width, you can choose it corresponding  to your calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_GW" id="TotalSoftCal_GW" min="0" max="5" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_GW_Output" for="TotalSoftCal_GW"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the main border width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_BW" id="TotalSoftCal_BW" min="0" max="10" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_BW_Output" for="TotalSoftCal_BW"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Style', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the border style: None, Solid, Dashed and Dotted.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal_BStyle" id="TotalSoftCal_BStyle">
							<option value="none">   <?php echo __( 'None', 'Total-Soft-Calendar' );?>   </option>
							<option value="solid">  <?php echo __( 'Solid', 'Total-Soft-Calendar' );?>  </option>
							<option value="dashed"> <?php echo __( 'Dashed', 'Total-Soft-Calendar' );?> </option>
							<option value="dotted"> <?php echo __( 'Dotted', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main border color.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal_BCol" id="TotalSoftCal_BCol" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Max Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_MW" id="TotalSoftCal_MW" min="150" max="1000" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_MW_Output" for="TotalSoftCal_MW"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Numbers Position', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Mention, the days in calendar must be from right or from left.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal_NumPos" id="TotalSoftCal_NumPos">
							<option value="left">  <?php echo __( 'Left', 'Total-Soft-Calendar' );?>  </option>
							<option value="right"> <?php echo __( 'Right', 'Total-Soft-Calendar' );?> </option>
							<option value="center"> <?php echo __( 'Center', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Type', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the shadow type.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal_BSType" id="TotalSoftCal_BSType">
							<option value='none'>   <?php echo __( 'None', 'Total-Soft-Calendar' );?>    </option>
							<option value=''>       <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1  </option>
							<option value='type2'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2  </option>
							<option value='type3'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3  </option>
							<option value='type4'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 4  </option>
							<option value='type5'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 5  </option>
							<option value='type6'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 6  </option>
							<option value='type7'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 7  </option>
							<option value='type8'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 8  </option>
							<option value='type9'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 9  </option>
							<option value='type10'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 10 </option>
							<option value='type11'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 11 </option>
							<option value='type12'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 12 </option>
							<option value='type13'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 13 </option>
							<option value='type14'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 14 </option>
							<option value='type15'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 15 </option>
							<option value='type16'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 16 </option>
							<option value='type17'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 17 </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color, which allows to show the shadow color of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal_BSCol" id="TotalSoftCal_BSCol" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_1_HO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color, where can be seen the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_HBgCol" id="TotalSoftCal_HBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a text color, where can be seen the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_HCol" id="TotalSoftCal_HCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the text size by pixel.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_HFS" id="TotalSoftCal_HFS" min="8" max="36" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_HFS_Output" for="TotalSoftCal_HFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the calendar font family of the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_HFF" id="TotalSoftCal_HFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Weekday Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_WBgCol" id="TotalSoftCal_WBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the calendar text color for the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_WCol" id="TotalSoftCal_WCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for the weekdays.', 'Total-Soft-Calendar' );?> "></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_WFS" id="TotalSoftCal_WFS" min="8" max="36" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_WFS_Output" for="TotalSoftCal_WFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family of the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_WFF" id="TotalSoftCal_WFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Line After Weekday', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the weeks and days dividing line width.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_LAW" id="TotalSoftCal_LAW" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_LAW_Output" for="TotalSoftCal_LAW"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Style', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Indicate the dividing line style: None, Solid, Dashed and Dotted.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_LAWS" id="TotalSoftCal_LAWS">
								<option value="none">   <?php echo __( 'None', 'Total-Soft-Calendar' );?>   </option>
								<option value="solid">  <?php echo __( 'Solid', 'Total-Soft-Calendar' );?>  </option>
								<option value="dashed"> <?php echo __( 'Dashed', 'Total-Soft-Calendar' );?> </option>
								<option value="dotted"> <?php echo __( 'Dotted', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_LAWC" id="TotalSoftCal_LAWC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_1_DO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background for days of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_DBgCol" id="TotalSoftCal_DBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color of the numbers.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_DCol" id="TotalSoftCal_DCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the size of the numbers, it is fully responsive.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_DFS" id="TotalSoftCal_DFS" min="8" max="25" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_DFS_Output" for="TotalSoftCal_DFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Hover Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the background color of the hover option, without clicking you can change the background color of the day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_HovBgCol" id="TotalSoftCal_HovBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( "Determine the color of the hover's letters.", 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_HovCol" id="TotalSoftCal_HovCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Todays Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the background color of the day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_TBgCol" id="TotalSoftCal_TBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the date color, that will be displayed.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_TCol" id="TotalSoftCal_TCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size of the numbers by pixels.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_TFS" id="TotalSoftCal_TFS" min="8" max="25" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_TFS_Output" for="TotalSoftCal_TFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( "Number's Background Color", 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background color of the day, it is designed for the frame.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_TNBgCol" id="TotalSoftCal_TNBgCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_1_IO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Arrows Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Choose Icon', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons, which are for change the months by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_ArrowType" id="TotalSoftCal_ArrowType" style="font-family: 'FontAwesome', Arial;">
								<option value='1'>  <?php echo '&#xf100' . '&nbsp; &nbsp; &nbsp;' . __( 'Angle Double', 'Total-Soft-Calendar' );?>  </option>
								<option value='2'>  <?php echo '&#xf104' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Angle', 'Total-Soft-Calendar' );?>   </option>
								<option value='3'>  <?php echo '&#xf0a8' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?>   </option>
								<option value='4'>  <?php echo '&#xf190' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle O', 'Total-Soft-Calendar' );?> </option>
								<option value='5'>  <?php echo '&#xf060' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow', 'Total-Soft-Calendar' );?>          </option>
								<option value='6'>  <?php echo '&#xf0d9' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Caret', 'Total-Soft-Calendar' );?>   </option>
								<option value='7'>  <?php echo '&#xf191' . '&nbsp; &nbsp;&nbsp;' . __( 'Caret Square O', 'Total-Soft-Calendar' );?> </option>
								<option value='8'>  <?php echo '&#xf137' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
								<option value='9'>  <?php echo '&#xf053' . '&nbsp; &nbsp; ' . __( 'Chevron', 'Total-Soft-Calendar' );?>             </option>
								<option value='10'> <?php echo '&#xf0a5' . '&nbsp; &nbsp;' . __( 'Hand O', 'Total-Soft-Calendar' );?>               </option>
								<option value='11'> <?php echo '&#xf177' . '&nbsp; &nbsp;' . __( 'Long Arrow', 'Total-Soft-Calendar' );?>           </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_ArrowCol" id="TotalSoftCal_ArrowCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_ArrowSize" id="TotalSoftCal_ArrowSize" min="8" max="25" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_ArrowSize_Output" for="TotalSoftCal_ArrowSize"></output>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Refresh Icon Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a color for updating icon, which has intended to return to the calendar from the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_RefIcCol" id="TotalSoftCal_RefIcCol" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a size for updating icon, which has intended to return to the calendar from the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_RefIcSize" id="TotalSoftCal_RefIcSize" min="8" max="25" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_RefIcSize_Output" for="TotalSoftCal_RefIcSize"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Back To Main Calendar', 'Total-Soft-Calendar' );?></div>
					
					
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Choose Icon', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons, which are for change the months by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_BackIconType" id="TotalSoftCal_BackIconType" style="font-family: 'FontAwesome', Arial;">
								<option value='1'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='1'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp; &nbsp;' . __( 'Calendar', 'Total-Soft-Calendar' );?>  </option>
								<option value='2'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='2'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Calendar O', 'Total-Soft-Calendar' );?>   </option>
								<option value='3'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='3'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp;&nbsp;' . __( 'Calendar X', 'Total-Soft-Calendar' );?>   </option>
								<option value='4'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='4'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp;&nbsp;' . __( 'Times', 'Total-Soft-Calendar' );?> </option>
								<option value='5'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='5'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp;&nbsp;' . __( 'Times Circle', 'Total-Soft-Calendar' );?>          </option>
								<option value='6'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='6'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Home', 'Total-Soft-Calendar' );?>   </option>
								<option value='7'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='7'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
								<option value='8'  <?php if($TotalSoftCal_1[0]->TotalSoftCal_ArrowType=='8'){echo 'selected';}?>>  <?php echo '' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?> </option>								
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_1_ET">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Title Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font size of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal1_Ev_T_FS" id="TotalSoftCal1_Ev_T_FS" min="8" max="48" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal1_Ev_T_FS_Output" for="TotalSoftCal1_Ev_T_FS"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal1_Ev_T_FF" id="TotalSoftCal1_Ev_T_FF">
							<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
								<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event title in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal1_Ev_T_C" id="TotalSoftCal1_Ev_T_C" class="Total_Soft_Cal_Color1" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Text Align', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Left, Right & Center - Determine the alignment of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal1_Ev_T_TA" id="TotalSoftCal1_Ev_T_TA">
							<option value='left'>   <?php echo __( 'Left', 'Total-Soft-Calendar' );?>   </option>
							<option value='right'>  <?php echo __( 'Right', 'Total-Soft-Calendar' );?>  </option>
							<option value='center'> <?php echo __( 'Center', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Time Format', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose time format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal1_Ev_TiF" id="TotalSoftCal1_Ev_TiF">
							<option value='24'> <?php echo __( '24 hours', 'Total-Soft-Calendar' );?> </option>
							<option value='12'> <?php echo __( '12 hours', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_1_IV">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Image/Video Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the width for Video (YouTube and Vimeo) or Image, you can choose it corresponding to your calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal1_Ev_I_W" id="TotalSoftCal1_Ev_I_W" min="30" max="98" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal1_Ev_I_W_Output" for="TotalSoftCal1_Ev_I_W"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the Video and Image in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal1_Ev_I_Pos" id="TotalSoftCal1_Ev_I_Pos">
							<option value='before'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>       </option>
							<option value='after'>  <?php echo __( 'After Description', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="Total_Soft_Cal_AMSetDiv" id="Total_Soft_Cal_AMSetDiv_2">
		<div class="Total_Soft_Cal_AMSetDiv_Buttons">
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_GO" onclick="TS_Cal_TM_But('2', 'GO')">General Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_HO" onclick="TS_Cal_TM_But('2', 'HO')">Calendar Part Header</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_DO" onclick="TS_Cal_TM_But('2', 'DO')">Days Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_IO" onclick="TS_Cal_TM_But('2', 'IO')">Icon Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_EP" onclick="TS_Cal_TM_But('2', 'EP')">Event Part</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_2_IV" onclick="TS_Cal_TM_But('2', 'IV')">Image/Video</div>
		</div>
		<div class="Total_Soft_Cal_AMSetDiv_Content">
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_2_GO">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'General Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'WeekDay Start', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select that day in the calendar, which must be the first in the week.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_WDStart" id="TotalSoftCal2_WDStart">
							<option value="0"><?php echo __( 'Sunday', 'Total-Soft-Calendar' );?></option>
							<option value="1"><?php echo __( 'Monday', 'Total-Soft-Calendar' );?></option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the main border width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_BW" id="TotalSoftCal2_BW" min="0" max="5" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal2_BW_Output" for="TotalSoftCal2_BW"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Style', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the border style: None, Solid, Dashed and Dotted.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_BS" id="TotalSoftCal2_BS">
							<option value="none">   <?php echo __( 'None', 'Total-Soft-Calendar' );?>   </option>
							<option value="solid">  <?php echo __( 'Solid', 'Total-Soft-Calendar' );?>  </option>
							<option value="dashed"> <?php echo __( 'Dashed', 'Total-Soft-Calendar' );?> </option>
							<option value="dotted"> <?php echo __( 'Dotted', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main border color.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal2_BC" id="TotalSoftCal2_BC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Max-Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_W" id="TotalSoftCal2_W" min="150" max="1200" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal2_W_Output" for="TotalSoftCal2_W"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Height', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar height.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_H" id="TotalSoftCal2_H" min="300" max="1200" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal2_H_Output" for="TotalSoftCal2_H"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose to show the shadow or no.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_BxShShow" id="TotalSoftCal2_BxShShow">
							<option value="Yes"> <?php echo __( 'Yes', 'Total-Soft-Calendar' );?> </option>
							<option value="No">  <?php echo __( 'No', 'Total-Soft-Calendar' );?>  </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Type', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the shadow type.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_BxShType" id="TotalSoftCal2_BxShType">
							<option value="1">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1  </option>
							<option value="2">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2  </option>
							<option value="3">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3  </option>
							<option value="4">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 4  </option>
							<option value="5">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 5  </option>
							<option value="6">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 6  </option>
							<option value="7">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 7  </option>
							<option value="8">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 8  </option>
							<option value="9">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 9  </option>
							<option value="10"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 10 </option>
							<option value="11"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 11 </option>
							<option value="12"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 12 </option>
							<option value="13"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 13 </option>
							<option value="14"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 14 </option>
							<option value="15"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 15 </option>
							<option value="16"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 16 </option>
							<option value="17"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 17 </option>
							<option value="18"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 18 </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color, which allows to show the shadow color of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal2_BxShC" id="TotalSoftCal2_BxShC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_2_HO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a background color, where can be seen the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_MBgC" id="TotalSoftCal2_MBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a text color, where can be seen the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_MC" id="TotalSoftCal2_MC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the text size by pixel.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_MFS" id="TotalSoftCal2_MFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_MFS_Output" for="TotalSoftCal2_MFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the calendar font family of the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_MFF" id="TotalSoftCal2_MFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'WeekDay Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_WBgC" id="TotalSoftCal2_WBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the calendar text color for the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_WC" id="TotalSoftCal2_WC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_WFS" id="TotalSoftCal2_WFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_WFS_Output" for="TotalSoftCal2_WFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family of the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_WFF" id="TotalSoftCal2_WFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Line After WeekDay', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the weeks and days dividing line width.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_LAW_W" id="TotalSoftCal2_LAW_W" min="0" max="3" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_LAW_W_Output" for="TotalSoftCal2_LAW_W"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Style', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Indicate the dividing line style: None, Solid, Dashed and Dotted.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_LAW_S" id="TotalSoftCal2_LAW_S">
								<option value="none">   <?php echo __( 'None', 'Total-Soft-Calendar' );?>   </option>
								<option value="solid">  <?php echo __( 'Solid', 'Total-Soft-Calendar' );?>  </option>
								<option value="dashed"> <?php echo __( 'Dashed', 'Total-Soft-Calendar' );?> </option>
								<option value="dotted"> <?php echo __( 'Dotted', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_LAW_C" id="TotalSoftCal2_LAW_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_2_DO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background for days of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_DBgC" id="TotalSoftCal2_DBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color of the numbers.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_DC" id="TotalSoftCal2_DC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the size of the numbers, it is fully responsive.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_DFS" id="TotalSoftCal2_DFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_DFS_Output" for="TotalSoftCal2_DFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Todays Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the background color of the current day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_TdBgC" id="TotalSoftCal2_TdBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the current date color, that will be displayed.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_TdC" id="TotalSoftCal2_TdC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size of the numbers by pixels.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_TdFS" id="TotalSoftCal2_TdFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_TdFS_Output" for="TotalSoftCal2_TdFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Event Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background for event days.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_EdBgC" id="TotalSoftCal2_EdBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color of the numbers.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_EdC" id="TotalSoftCal2_EdC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the size of the numbers, it is fully responsive.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_EdFS" id="TotalSoftCal2_EdFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_EdFS_Output" for="TotalSoftCal2_EdFS"></output>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Hover Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the background color of the hover option, without clicking you can change the background color of the day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_HBgC" id="TotalSoftCal2_HBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( "Determine the color of the hover's letters.", 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_HC" id="TotalSoftCal2_HC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Other Months Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background color for the other months days on the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_OmBgC" id="TotalSoftCal2_OmBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the text color of the other months days.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_OmC" id="TotalSoftCal2_OmC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the size for the other months days on the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_OmFS" id="TotalSoftCal2_OmFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_OmFS_Output" for="TotalSoftCal2_OmFS"></output>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_2_IO">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Arrows Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Type', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons for calendar, which are for change the months by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_ArrType" id="TotalSoftCal2_ArrType" style="font-family: 'FontAwesome', Arial;">
							<option value='angle-double'>   <?php echo '&#xf100' . '&nbsp; &nbsp; &nbsp;' . __( 'Angle Double', 'Total-Soft-Calendar' );?>  </option>
							<option value='angle'>          <?php echo '&#xf104' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Angle', 'Total-Soft-Calendar' );?>   </option>
							<option value='arrow-circle'>   <?php echo '&#xf0a8' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?>   </option>
							<option value='arrow-circle-o'> <?php echo '&#xf190' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle O', 'Total-Soft-Calendar' );?> </option>
							<option value='arrow'>          <?php echo '&#xf060' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow', 'Total-Soft-Calendar' );?>          </option>
							<option value='caret'>          <?php echo '&#xf0d9' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Caret', 'Total-Soft-Calendar' );?>   </option>
							<option value='caret-square-o'> <?php echo '&#xf191' . '&nbsp; &nbsp;&nbsp;' . __( 'Caret Square O', 'Total-Soft-Calendar' );?> </option>
							<option value='chevron-circle'> <?php echo '&#xf137' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
							<option value='chevron'>        <?php echo '&#xf053' . '&nbsp; &nbsp; ' . __( 'Chevron', 'Total-Soft-Calendar' );?>             </option>
							<option value='hand-o'>         <?php echo '&#xf0a5' . '&nbsp; &nbsp;' . __( 'Hand O', 'Total-Soft-Calendar' );?>               </option>
							<option value='long-arrow'>     <?php echo '&#xf177' . '&nbsp; &nbsp;' . __( 'Long Arrow', 'Total-Soft-Calendar' );?>           </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_ArrFS" id="TotalSoftCal2_ArrFS" min="8" max="48" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal2_ArrFS_Output" for="TotalSoftCal2_ArrFS"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="TotalSoftCal2_ArrC" id="TotalSoftCal2_ArrC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_2_EP">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the background color of event part header, where can be seen the events main title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_Ev_HBgC" id="TotalSoftCal2_Ev_HBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the text color of event part header, where can be seen the events main title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_Ev_HC" id="TotalSoftCal2_Ev_HC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the text size by pixel.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_Ev_HFS" id="TotalSoftCal2_Ev_HFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_Ev_HFS_Output" for="TotalSoftCal2_Ev_HFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_HFF" id="TotalSoftCal2_Ev_HFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Text', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can write events main title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" class="Total_Soft_Select" name="TotalSoftCal2_Ev_HText" id="TotalSoftCal2_Ev_HText" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Body Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_Ev_BBgC" id="TotalSoftCal2_Ev_BBgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Title Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event title in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal2_Ev_TC" id="TotalSoftCal2_Ev_TC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_TFF" id="TotalSoftCal2_Ev_TFF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font size of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal2_Ev_TFS" id="TotalSoftCal2_Ev_TFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal2_Ev_TFS_Output" for="TotalSoftCal2_Ev_TFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Text Align', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Left, Right & Center - Determine the alignment of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_T_TA" id="TotalSoftCal2_Ev_T_TA">
								<option value='left'>   <?php echo __( 'Left', 'Total-Soft-Calendar' );?>   </option>
								<option value='right'>  <?php echo __( 'Right', 'Total-Soft-Calendar' );?>  </option>
								<option value='center'> <?php echo __( 'Center', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Time Format', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose time format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_TiF" id="TotalSoftCal2_Ev_TiF">
								<option value='24'> <?php echo __( '24 hours', 'Total-Soft-Calendar' );?> </option>
								<option value='12'> <?php echo __( '12 hours', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Date Format', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose Date format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_DaF" id="TotalSoftCal2_Ev_DaF">
								<option value="">          dd.mm.yy  </option>
								<option value="yy-mm-dd">  yy-mm-dd  </option>
								<option value="yy MM dd">  yy MM dd  </option>
								<option value="dd-mm-yy">  dd-mm-yy  </option>
								<option value="dd MM yy">  dd MM yy  </option>
								<option value="mm-dd-yy">  mm-dd-yy  </option>
								<option value="MM dd, yy"> MM dd, yy </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Show Date', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose to Show Date in event part or not.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_ShDate" id="TotalSoftCal2_Ev_ShDate">
								<option value="">   Yes </option>
								<option value="no"> No  </option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_2_IV">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Image/Video Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the width for Video (YouTube and Vimeo) or Image, you can choose it corresponding to your calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal2_Ev_I_W" id="TotalSoftCal2_Ev_I_W" min="30" max="98" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal2_Ev_I_W_Output" for="TotalSoftCal2_Ev_I_W"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the Video and Image in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal2_Ev_I_Pos" id="TotalSoftCal2_Ev_I_Pos">
							<option value='before'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>       </option>
							<option value='after'>  <?php echo __( 'After Description', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="Total_Soft_Cal_AMSetDiv" id="Total_Soft_Cal_AMSetDiv_3">
		<div class="Total_Soft_Cal_AMSetDiv_Buttons">
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_GO" onclick="TS_Cal_TM_But('3', 'GO')">General Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_HO" onclick="TS_Cal_TM_But('3', 'HO')">Header Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_DO" onclick="TS_Cal_TM_But('3', 'DO')">Days Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_EH" onclick="TS_Cal_TM_But('3', 'EH')">Event Part Header</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_ET" onclick="TS_Cal_TM_But('3', 'ET')">Event Title</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_IV" onclick="TS_Cal_TM_But('3', 'IV')">Image/Video</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_3_LL" onclick="TS_Cal_TM_But('3', 'LL')">Link & Line</div>
		</div>
		<div class="Total_Soft_Cal_AMSetDiv_Content">
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_3_GO">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'General Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Max-Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Possibility define the calendar width', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_MW" id="TotalSoftCal3_MW" min="150" max="1200" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal3_MW_Output" for="TotalSoftCal3_MW"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'WeekDay Start', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select that day in the calendar, which must be the first in the week.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal3_WDStart" id="TotalSoftCal3_WDStart">
							<option value="0"><?php echo __( 'Sunday', 'Total-Soft-Calendar' );?></option>
							<option value="1"><?php echo __( 'Monday', 'Total-Soft-Calendar' );?></option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Can choose main background color.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_BgC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Grid Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select grid color which divide the days in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_GrC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Body Border Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the body border color.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_BBC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose to show the shadow or no.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal3_BoxShShow" id="TotalSoftCal3_BoxShShow">
							<option value="Yes"> <?php echo __( 'Yes', 'Total-Soft-Calendar' );?> </option>
							<option value="No">  <?php echo __( 'No', 'Total-Soft-Calendar' );?>  </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the shadow type.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal3_BoxShType">
							<option value="1">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1  </option>
							<option value="2">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2  </option>
							<option value="3">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3  </option>
							<option value="4">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 4  </option>
							<option value="5">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 5  </option>
							<option value="6">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 6  </option>
							<option value="7">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 7  </option>
							<option value="8">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 8  </option>
							<option value="9">  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 9  </option>
							<option value="10"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 10 </option>
							<option value="11"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 11 </option>
							<option value="12"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 12 </option>
							<option value="13"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 13 </option>
							<option value="14"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 14 </option>
							<option value="15"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 15 </option>
							<option value="16"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 16 </option>
							<option value="17"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 17 </option>
							<option value="18"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 18 </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color, which allows to show the shadow color of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_BoxShC" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_3_HO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a background color, where can be seen the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_H_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border-Top Width', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main top border width.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="" id="TotalSoftCal3_H_BTW" min="0" max="10" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_H_BTW_Output" for="TotalSoftCal3_H_BTW"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border-Top Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main top border color.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_H_BTC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the calendar font family of the year and month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal3_H_FF" id="TotalSoftCal3_H_FF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Month Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the calendar font size of the month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_H_MFS" id="TotalSoftCal3_H_MFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_H_MFS_Output" for="TotalSoftCal3_H_MFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Month Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the calendar text color for the month.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_H_MC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Year Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the calendar font size of the year.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_H_YFS" id="TotalSoftCal3_H_YFS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_H_YFS_Output" for="TotalSoftCal3_H_YFS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Year Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the calendar text color for the year.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_H_YC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the month and year.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal3_H_Format">
								<option value="1"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1 </option>
								<option value="2"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2 </option>
								<option value="3"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3 </option>
								<option value="4"> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 4 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Line After Header', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the header line width.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="" id="TotalSoftCal3_LAH_W" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_LAH_W_Output" for="TotalSoftCal3_LAH_W"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_LAH_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Arrows Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons for calendar, which are for change the months by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Arr_Type" style="font-family: 'FontAwesome', Arial;">
								<option value='angle-double'>   <?php echo '&#xf100' . '&nbsp; &nbsp; &nbsp;' . __( 'Angle Double', 'Total-Soft-Calendar' );?>  </option>
								<option value='angle'>          <?php echo '&#xf104' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Angle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle'>   <?php echo '&#xf0a8' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle-o'> <?php echo '&#xf190' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle O', 'Total-Soft-Calendar' );?> </option>
								<option value='arrow'>          <?php echo '&#xf060' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow', 'Total-Soft-Calendar' );?>          </option>
								<option value='caret'>          <?php echo '&#xf0d9' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Caret', 'Total-Soft-Calendar' );?>   </option>
								<option value='caret-square-o'> <?php echo '&#xf191' . '&nbsp; &nbsp;&nbsp;' . __( 'Caret Square O', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron-circle'> <?php echo '&#xf137' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron'>        <?php echo '&#xf053' . '&nbsp; &nbsp; ' . __( 'Chevron', 'Total-Soft-Calendar' );?>             </option>
								<option value='hand-o'>         <?php echo '&#xf0a5' . '&nbsp; &nbsp;' . __( 'Hand O', 'Total-Soft-Calendar' );?>               </option>
								<option value='long-arrow'>     <?php echo '&#xf177' . '&nbsp; &nbsp;' . __( 'Long Arrow', 'Total-Soft-Calendar' );?>           </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Arr_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Arr_S" id="TotalSoftCal3_Arr_S" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Arr_S_Output" for="TotalSoftCal3_Arr_S"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a hover color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Arr_HC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'WeekDay Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_WD_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the calendar text color for the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_WD_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_WD_FS" id="TotalSoftCal3_WD_FS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_WD_FS_Output" for="TotalSoftCal3_WD_FS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family of the weekdays.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal3_WD_FF" id="TotalSoftCal3_WD_FF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_3_DO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the background color for days of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_D_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color of the numbers.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_D_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Todays Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Note the background color of the current day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_TD_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the current date color, that will be displayed.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_TD_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Hover Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the background color of the hover option, without clicking you can change the background color of the day.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_HD_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( "Determine the color of the hover's letters.", 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_HD_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Event Days Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the event color for days.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_ED_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the event hover color for days.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_ED_HC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_3_EH">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose date format.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_Format">
								<option value='1'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1 </option>
								<option value='2'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2 </option>
								<option value='3'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border-Top Width', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main top border width for the event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="" id="TotalSoftCal3_Ev_BTW" min="0" max="10" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_BTW_Output" for="TotalSoftCal3_Ev_BTW"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border-Top Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main top border color for the event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_BTC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the background color of event part header, where can be seen the events main title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_BgC" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the text color of event part header, where can be seen the events main title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_C" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font size for event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_FS" id="TotalSoftCal3_Ev_FS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_FS_Output" for="TotalSoftCal3_Ev_FS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal3_Ev_FF" id="TotalSoftCal3_Ev_FF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Line After Header', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the line width for the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="" id="TotalSoftCal3_Ev_LAH_W" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_LAH_W_Output" for="TotalSoftCal3_Ev_LAH_W"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_LAH_C" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Close Icon Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the close icons for calendar, which has intended to return to the calendar from the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_C_Type" style="font-family: 'FontAwesome', Arial;">
								<option value='times-circle-o'> <?php echo '&#xf05c' . '&nbsp; &nbsp;' . __( 'Times Circle O', 'Total-Soft-Calendar' );?> </option>
								<option value='times-circle'>   <?php echo '&#xf057' . '&nbsp; &nbsp;' . __( 'Times Circle', 'Total-Soft-Calendar' );?>   </option>
								<option value='times'>          <?php echo '&#xf00d' . '&nbsp; &nbsp;' . __( 'Times', 'Total-Soft-Calendar' );?>          </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a color for close icon, which has intended to return to the calendar from the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_C_C" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a hover color for close icon, which has intended to return to the calendar from the events.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_C_HC" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_C_FS" id="TotalSoftCal3_Ev_C_FS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_C_FS_Output" for="TotalSoftCal3_Ev_C_FS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Body Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Can choose main background color.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_B_BgC" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the body border color in the event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_B_BC" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_3_ET">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Title Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font size of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_T_FS" id="TotalSoftCal3_Ev_T_FS" min="8" max="48" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_T_FS_Output" for="TotalSoftCal3_Ev_T_FS"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal3_Ev_T_FF" id="TotalSoftCal3_Ev_T_FF">
							<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
								<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for events title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_Ev_T_BgC" class="Total_Soft_Cal_Color1" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event title in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal3_Ev_T_C" class="Total_Soft_Cal_Color1" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Text Align', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Left, Right & Center - Determine the alignment of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal3_Ev_T_TA" id="TotalSoftCal3_Ev_T_TA">
							<option value='left'>   <?php echo __( 'Left', 'Total-Soft-Calendar' );?>   </option>
							<option value='right'>  <?php echo __( 'Right', 'Total-Soft-Calendar' );?>  </option>
							<option value='center'> <?php echo __( 'Center', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Time Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose time format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_TiF">
							<option value='24'> <?php echo __( '24 hours', 'Total-Soft-Calendar' );?> </option>
							<option value='12'> <?php echo __( '12 hours', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Date Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose Date format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_DaF">
							<option value="">          yy-mm-dd  </option>
							<option value="dd.mm.yy">  dd.mm.yy  </option>
							<option value="yy MM dd">  yy MM dd  </option>
							<option value="dd-mm-yy">  dd-mm-yy  </option>
							<option value="dd MM yy">  dd MM yy  </option>
							<option value="mm-dd-yy">  mm-dd-yy  </option>
							<option value="MM dd, yy"> MM dd, yy </option>
						</select>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_3_IV">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Image/Video Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the width for Video (YouTube and Vimeo) or Image, you can choose it corresponding to your calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal3_Ev_I_W" id="TotalSoftCal3_Ev_I_W" min="30" max="98" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_I_W_Output" for="TotalSoftCal3_Ev_I_W"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the Video and Image in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_I_Pos">
							<option value='1'> <?php echo __( 'Before Title', 'Total-Soft-Calendar' );?>      </option>
							<option value='2'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>       </option>
							<option value='3'> <?php echo __( 'After Description', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_3_LL">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Link Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event link in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_L_C" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the hover color for the event link in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_L_HC" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the link in event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal3_Ev_L_Pos">
								<option value='1'> <?php echo __( 'Before Title', 'Total-Soft-Calendar' );?>      </option>
								<option value='2'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>       </option>
								<option value='3'> <?php echo __( 'After Title Text', 'Total-Soft-Calendar' );?>  </option>
								<option value='4'> <?php echo __( 'After Description', 'Total-Soft-Calendar' );?> </option>
								<option value='5'> <?php echo __( 'After Description Text', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Text', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can write link text.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal3_Ev_L_Text" id="TotalSoftCal3_Ev_L_Text" class="Total_Soft_Select" placeholder="<?php echo __( 'Link Text', 'Total-Soft-Calendar' );?>">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the text font size for the link button of the event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_L_FS" id="TotalSoftCal3_Ev_L_FS" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_L_FS_Output" for="TotalSoftCal3_Ev_L_FS"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the link button.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal3_Ev_L_FF" id="TotalSoftCal3_Ev_L_FF">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the border color, which is designed for Link button.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_L_BC" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the border width for the link buttons.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_L_BW" id="TotalSoftCal3_Ev_L_BW" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_L_BW_Output" for="TotalSoftCal3_Ev_L_BW"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Radius', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Install the border radius for event link.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_L_BR" id="TotalSoftCal3_Ev_L_BR" min="0" max="50" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_L_BR_Output" for="TotalSoftCal3_Ev_L_BR"></output>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Line After Each Event', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the line width.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal3_Ev_LAE_W" id="TotalSoftCal3_Ev_LAE_W" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal3_Ev_LAE_W_Output" for="TotalSoftCal3_Ev_LAE_W"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal3_Ev_LAE_C" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="Total_Soft_Cal_AMSetDiv" id="Total_Soft_Cal_AMSetDiv_4">
		<div class="Total_Soft_Cal_AMSetDiv_Buttons">
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_GO" onclick="TS_Cal_TM_But('4', 'GO')">General Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_HO" onclick="TS_Cal_TM_But('4', 'HO')">Header Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_BO" onclick="TS_Cal_TM_But('4', 'BO')">Bar Option</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_EP" onclick="TS_Cal_TM_But('4', 'EP')">Event Part</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_IV" onclick="TS_Cal_TM_But('4', 'IV')">Image/Video</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_LL" onclick="TS_Cal_TM_But('4', 'LL')">Link & Line</div>
			<div class="Total_Soft_Cal_AMSetDiv_Button" id="TS_Cal_TM_TBut_4_DT" onclick="TS_Cal_TM_But('4', 'DT')">Date & Time</div>
		</div>
		<div class="Total_Soft_Cal_AMSetDiv_Content">
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_4_GO">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'General Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Max-Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the calendar width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_01" id="TotalSoftCal4_01" min="0" max="2000" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal4_01_Output" for="TotalSoftCal4_01"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the shadow type.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal4_02">
							<option value='none'>   <?php echo __( 'None', 'Total-Soft-Calendar' );?>    </option>
							<option value='type1'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 1  </option>
							<option value='type2'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 2  </option>
							<option value='type3'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 3  </option>
							<option value='type4'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 4  </option>
							<option value='type5'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 5  </option>
							<option value='type6'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 6  </option>
							<option value='type7'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 7  </option>
							<option value='type8'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 8  </option>
							<option value='type9'>  <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 9  </option>
							<option value='type10'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 10 </option>
							<option value='type11'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 11 </option>
							<option value='type12'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 12 </option>
							<option value='type13'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 13 </option>
							<option value='type14'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 14 </option>
							<option value='type15'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 15 </option>
							<option value='type16'> <?php echo __( 'Type', 'Total-Soft-Calendar' );?> 16 </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Shadow Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the color, which allows to show the shadow color of the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal4_03" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Type', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the border style: None, Solid, Dashed and Dotted.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal4_04" id="TotalSoftCal4_04">
							<option value='none'>   <?php echo __( 'None', 'Total-Soft-Calendar' );?>   </option>
							<option value='solid'>  <?php echo __( 'Solid', 'Total-Soft-Calendar' );?>  </option>
							<option value='dotted'> <?php echo __( 'Dotted', 'Total-Soft-Calendar' );?> </option>
							<option value='dashed'> <?php echo __( 'Dashed', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Define the main border width.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_05" id="TotalSoftCal4_05" min="0" max="10" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal4_05_Output" for="TotalSoftCal4_05"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the main border color.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal4_06" class="Total_Soft_Cal_Color" value="">
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_4_HO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Header Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the background type: transparent, color or gradient types.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_07">
								<option value='transparent'> <?php echo __( 'Transparent', 'Total-Soft-Calendar' );?> </option>
								<option value='color'>       <?php echo __( 'Color', 'Total-Soft-Calendar' );?>       </option>
								<option value='gradient1'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 1  </option>
								<option value='gradient2'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 2  </option>
								<option value='gradient3'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 3  </option>
								<option value='gradient4'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 4  </option>
								<option value='gradient5'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 5  </option>
								<option value='gradient6'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 6  </option>
								<option value='gradient7'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 7  </option>
								<option value='gradient8'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 8  </option>
								<option value='gradient9'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 9  </option>
								<option value='gradient10'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 10 </option>
								<option value='gradient11'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 11 </option>
								<option value='gradient12'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 12 </option>
								<option value='gradient13'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 13 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 1', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the background color of header, where can be seen the year and month name.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_08" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 2', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose second background color for gradient effects.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_09" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for the year and month name in header.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_10" id="TotalSoftCal4_10" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_10_Output" for="TotalSoftCal4_10"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family of the year and month name in header.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal4_11" id="TotalSoftCal4_11">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select format to show years and months in header.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_12">
								<option value='format1'> <?php echo __( 'Format', 'Total-Soft-Calendar' );?> 1 </option>
								<option value='format2'> <?php echo __( 'Format', 'Total-Soft-Calendar' );?> 2 </option>
								<option value='format3'> <?php echo __( 'Format', 'Total-Soft-Calendar' );?> 3 </option>
								<option value='format4'> <?php echo __( 'Format', 'Total-Soft-Calendar' );?> 4 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Month Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for month name according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_18" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Year Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for year according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_13" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons for calendar, which are for changing the years by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_14" style="font-family: 'FontAwesome', Arial;">
								<option value='angle-double'>   <?php echo '&#xf100' . '&nbsp; &nbsp; &nbsp;' . __( 'Angle Double', 'Total-Soft-Calendar' );?>  </option>
								<option value='angle'>          <?php echo '&#xf104' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Angle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle'>   <?php echo '&#xf0a8' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle-o'> <?php echo '&#xf190' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle O', 'Total-Soft-Calendar' );?> </option>
								<option value='arrow'>          <?php echo '&#xf060' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow', 'Total-Soft-Calendar' );?>          </option>
								<option value='caret'>          <?php echo '&#xf0d9' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Caret', 'Total-Soft-Calendar' );?>   </option>
								<option value='caret-square-o'> <?php echo '&#xf191' . '&nbsp; &nbsp;&nbsp;' . __( 'Caret Square O', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron-circle'> <?php echo '&#xf137' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron'>        <?php echo '&#xf053' . '&nbsp; &nbsp; ' . __( 'Chevron', 'Total-Soft-Calendar' );?>             </option>
								<option value='hand-o'>         <?php echo '&#xf0a5' . '&nbsp; &nbsp;' . __( 'Hand O', 'Total-Soft-Calendar' );?>               </option>
								<option value='long-arrow'>     <?php echo '&#xf177' . '&nbsp; &nbsp;' . __( 'Long Arrow', 'Total-Soft-Calendar' );?>           </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_15" id="TotalSoftCal4_15" min="8" max="72" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_15_Output" for="TotalSoftCal4_15"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_16" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a hover color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_17" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles Total_Soft_Titles1"><?php echo __( 'Line After Header', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_19" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the header line width by percentage.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal4_20" id="TotalSoftCal4_20" min="0" max="100" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_20_Output" for="TotalSoftCal4_20"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Height', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the header line height by pixels.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_21" id="TotalSoftCal4_21" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_21_Output" for="TotalSoftCal4_21"></output>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_4_BO">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Bar Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the background type: transparent, color or gradient types.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_22">
								<option value='transparent'> <?php echo __( 'Transparent', 'Total-Soft-Calendar' );?> </option>
								<option value='color'>       <?php echo __( 'Color', 'Total-Soft-Calendar' );?>       </option>
								<option value='gradient1'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 1  </option>
								<option value='gradient2'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 2  </option>
								<option value='gradient3'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 3  </option>
								<option value='gradient4'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 4  </option>
								<option value='gradient5'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 5  </option>
								<option value='gradient6'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 6  </option>
								<option value='gradient7'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 7  </option>
								<option value='gradient8'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 8  </option>
								<option value='gradient9'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 9  </option>
								<option value='gradient10'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 10 </option>
								<option value='gradient11'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 11 </option>
								<option value='gradient12'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 12 </option>
								<option value='gradient13'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 13 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 1', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the background color of events bar, where can be seen the events dates.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_23" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 2', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose second background color for gradient effects.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_24" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Grid Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select grid color which divide the dates in the events bar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_25" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Number Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for dates in events bar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_26" id="TotalSoftCal4_26" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_26_Output" for="TotalSoftCal4_26"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Number Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference for dates in events bar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_27" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Month Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for month names in events bar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_28" id="TotalSoftCal4_28" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_28_Output" for="TotalSoftCal4_28"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Month Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference for month names in events bar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_29" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Selected Number Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference for dates for selected dates.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_30" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Selected Month Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference for month names for selected dates.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_31" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the right and the left icons for calendar, which are for changing the events by sequence.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_32" style="font-family: 'FontAwesome', Arial;">
								<option value='angle-double'>   <?php echo '&#xf100' . '&nbsp; &nbsp; &nbsp;' . __( 'Angle Double', 'Total-Soft-Calendar' );?>  </option>
								<option value='angle'>          <?php echo '&#xf104' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Angle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle'>   <?php echo '&#xf0a8' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle', 'Total-Soft-Calendar' );?>   </option>
								<option value='arrow-circle-o'> <?php echo '&#xf190' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow Circle O', 'Total-Soft-Calendar' );?> </option>
								<option value='arrow'>          <?php echo '&#xf060' . '&nbsp; &nbsp;&nbsp;' . __( 'Arrow', 'Total-Soft-Calendar' );?>          </option>
								<option value='caret'>          <?php echo '&#xf0d9' . '&nbsp; &nbsp; &nbsp;&nbsp;' . __( 'Caret', 'Total-Soft-Calendar' );?>   </option>
								<option value='caret-square-o'> <?php echo '&#xf191' . '&nbsp; &nbsp;&nbsp;' . __( 'Caret Square O', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron-circle'> <?php echo '&#xf137' . '&nbsp; &nbsp;&nbsp;' . __( 'Chevron Circle', 'Total-Soft-Calendar' );?> </option>
								<option value='chevron'>        <?php echo '&#xf053' . '&nbsp; &nbsp; ' . __( 'Chevron', 'Total-Soft-Calendar' );?>             </option>
								<option value='hand-o'>         <?php echo '&#xf0a5' . '&nbsp; &nbsp;' . __( 'Hand O', 'Total-Soft-Calendar' );?>               </option>
								<option value='long-arrow'>     <?php echo '&#xf177' . '&nbsp; &nbsp;' . __( 'Long Arrow', 'Total-Soft-Calendar' );?>           </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_33" id="TotalSoftCal4_33" min="8" max="72" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_33_Output" for="TotalSoftCal4_33"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_34" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Arrow Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a hover color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_35" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Line After Bar', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal4_36" class="Total_Soft_Cal_Color" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the bar line width by percentage.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal4_37" id="TotalSoftCal4_37" min="0" max="100" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_37_Output" for="TotalSoftCal4_37"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Height', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the bar line height by pixels.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal4_38" id="TotalSoftCal4_38" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal4_38_Output" for="TotalSoftCal4_38"></output>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_4_EP">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'General Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Specify the background type: transparent, color or gradient types.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal4_39">
								<option value='transparent'> <?php echo __( 'Transparent', 'Total-Soft-Calendar' );?> </option>
								<option value='color'>       <?php echo __( 'Color', 'Total-Soft-Calendar' );?>       </option>
								<option value='gradient1'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 1  </option>
								<option value='gradient2'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 2  </option>
								<option value='gradient3'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 3  </option>
								<option value='gradient4'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 4  </option>
								<option value='gradient5'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 5  </option>
								<option value='gradient6'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 6  </option>
								<option value='gradient7'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 7  </option>
								<option value='gradient8'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 8  </option>
								<option value='gradient9'>   <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 9  </option>
								<option value='gradient10'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 10 </option>
								<option value='gradient11'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 11 </option>
								<option value='gradient12'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 12 </option>
								<option value='gradient13'>  <?php echo __( 'Gradient', 'Total-Soft-Calendar' );?> 13 </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 1', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the background color of event part, where can be seen the events with description and media.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_01" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color 2', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose second background color for gradient effects.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_02" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Data Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose data format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal_4_03">
								<option value="yy-mm-dd">  yy-mm-dd  </option>
								<option value="yy MM dd">  yy MM dd  </option>
								<option value="dd-mm-yy">  dd-mm-yy  </option>
								<option value="dd MM yy">  dd MM yy  </option>
								<option value="mm-dd-yy">  mm-dd-yy  </option>
								<option value="MM dd, yy"> MM dd, yy </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Time Format', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose time format for the event in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal_4_04">
								<option value='24'> 24 <?php echo __( 'Hours', 'Total-Soft-Calendar' );?> </option>
								<option value='12'> 12 <?php echo __( 'Hours', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Event Title', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font size of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_05" id="TotalSoftCal_4_05" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_05_Output" for="TotalSoftCal_4_05"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_4_06" id="TotalSoftCal_4_06">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Background Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose a background color for events title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_07" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event title in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_08" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Text Align', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Left, Right & Center - Determine the alignment of the event title.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_4_09" id="TotalSoftCal_4_09">
								<option value='left'>   <?php echo __( 'Left', 'Total-Soft-Calendar' );?>   </option>
								<option value='right'>  <?php echo __( 'Right', 'Total-Soft-Calendar' );?>  </option>
								<option value='center'> <?php echo __( 'Center', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_4_IV">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Image/Video Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the width for Video (YouTube and Vimeo) or Image, you can choose it corresponding to your calendar.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal_4_10" id="TotalSoftCal_4_10" min="0" max="100" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_10_Output" for="TotalSoftCal_4_10"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the Video and Image in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal_4_11">
							<option value='1'> <?php echo __( 'Before Title', 'Total-Soft-Calendar' );?>      </option>
							<option value='2'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>       </option>
							<option value='3'> <?php echo __( 'After Description', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div TS_Cal_Option_Divv" id="Total_Soft_Cal_AMSetTable_4_LL">
				<div class="TS_Cal_Option_Divv1">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Link Options', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color for the event link in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_12" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Hover Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the hover color for the event link in the calendar.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_13" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Position', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose position for the link in event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="" id="TotalSoftCal_4_14">
								<option value='1'> <?php echo __( 'Before Title', 'Total-Soft-Calendar' );?>           </option>
								<option value='2'> <?php echo __( 'After Title', 'Total-Soft-Calendar' );?>            </option>
								<option value='3'> <?php echo __( 'After Title Text', 'Total-Soft-Calendar' );?>       </option>
								<option value='4'> <?php echo __( 'After Description', 'Total-Soft-Calendar' );?>      </option>
								<option value='5'> <?php echo __( 'After Description Text', 'Total-Soft-Calendar' );?> </option>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Text', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'You can write link text.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="TotalSoftCal_4_15" id="TotalSoftCal_4_15" class="Total_Soft_Select" placeholder="<?php echo __( 'Link Text', 'Total-Soft-Calendar' );?>">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the text font size for the link button of the event.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_16" id="TotalSoftCal_4_16" min="8" max="48" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_16_Output" for="TotalSoftCal_4_16"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family for the link button.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<select class="Total_Soft_Select" name="TotalSoftCal_4_17" id="TotalSoftCal_4_17">
								<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the border color, which is designed for Link button.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_18" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the border width for the link buttons.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_19" id="TotalSoftCal_4_19" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_19_Output" for="TotalSoftCal_4_19"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Border Radius', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Install the border radius for event link.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_20" id="TotalSoftCal_4_20" min="0" max="30" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_20_Output" for="TotalSoftCal_4_20"></output>
						</div>
					</div>
				</div>
				<div class="TS_Cal_Option_Divv2">
					<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Line After Each Event', 'Total-Soft-Calendar' );?></div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the color according to your preference.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="text" name="" id="TotalSoftCal_4_21" class="Total_Soft_Cal_Color1" value="">
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Width', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the line width by percentage.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangeper" name="TotalSoftCal_4_22" id="TotalSoftCal_4_22" min="0" max="100" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_22_Output" for="TotalSoftCal_4_22"></output>
						</div>
					</div>
					<div class="TS_Cal_Option_Div1">
						<div class="TS_Cal_Option_Name"><?php echo __( 'Height', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Determine the line height by pixels.', 'Total-Soft-Calendar' );?>"></i></div>
						<div class="TS_Cal_Option_Field">
							<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_23" id="TotalSoftCal_4_23" min="0" max="5" value="">
							<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_23_Output" for="TotalSoftCal_4_23"></output>
						</div>
					</div>
				</div>
			</div>
			<div class="TS_Cal_Option_Div" id="Total_Soft_Cal_AMSetTable_4_DT">
				<div class="TS_Cal_Option_Div1 Total_Soft_Titles"><?php echo __( 'Date & Time Options', 'Total-Soft-Calendar' );?></div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the color for the date and time in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal_4_24" class="Total_Soft_Cal_Color1" value="">
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the calendar text size for the date & time in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_25" id="TotalSoftCal_4_25" min="8" max="48" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_25_Output" for="TotalSoftCal_4_25"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Font Family', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Choose the font family of the date & time in event.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="TotalSoftCal_4_26" id="TotalSoftCal_4_26">
							<?php for($i = 0; $i < count($TotalSoftFontGCount); $i++) { ?>
									<option value='<?php echo $TotalSoftFontGCount[$i];?>' style="font-family: <?php echo $TotalSoftFontGCount[$i];?>;"><?php echo $TotalSoftFontCount[$i];?></option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Icon Type', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select the icon for calendar for event part.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<select class="Total_Soft_Select" name="" id="TotalSoftCal_4_27" style="font-family: 'FontAwesome', Arial;">
							<option value="calendar">         <?php echo '&#xf073' . '&nbsp; &nbsp;' . __( 'Calendar', 'Total-Soft-Calendar' );?>         </option>
							<option value="calendar-o">       <?php echo '&#xf133' . '&nbsp; &nbsp;' . __( 'Calendar O', 'Total-Soft-Calendar' );?>       </option>
							<option value="calendar-plus-o">  <?php echo '&#xf271' . '&nbsp; &nbsp;' . __( 'Calendar Plus O', 'Total-Soft-Calendar' );?>  </option>
							<option value="calendar-check-o"> <?php echo '&#xf274' . '&nbsp; &nbsp;' . __( 'Calendar Check O', 'Total-Soft-Calendar' );?> </option>
							<option value="calendar-minus-o"> <?php echo '&#xf272' . '&nbsp; &nbsp;' . __( 'Calendar Minus O', 'Total-Soft-Calendar' );?> </option>
							<option value="calendar-times-o"> <?php echo '&#xf273' . '&nbsp; &nbsp;' . __( 'Calendar Times O', 'Total-Soft-Calendar' );?> </option>
						</select>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Icon Size', 'Total-Soft-Calendar' );?> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Set the size for icon.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="range" class="TotalSoft_Cal_Range TotalSoft_Cal_Rangepx" name="TotalSoftCal_4_28" id="TotalSoftCal_4_28" min="8" max="72" value="">
						<output class="TotalSoft_Out" name="" id="TotalSoftCal_4_28_Output" for="TotalSoftCal_4_28"></output>
					</div>
				</div>
				<div class="TS_Cal_Option_Div1">
					<div class="TS_Cal_Option_Name"><?php echo __( 'Icon Color', 'Total-Soft-Calendar' );?> <span class="TS_Free_version_Span"> (Pro)</span> <i class="Total_Soft_Help1 totalsoft totalsoft-question-circle-o" title="<?php echo __( 'Select a color of the icon.', 'Total-Soft-Calendar' );?>"></i></div>
					<div class="TS_Cal_Option_Field">
						<input type="text" name="" id="TotalSoftCal_4_29" class="Total_Soft_Cal_Color1" value="">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>