function TotalSoft_Cal_Out()
{
	jQuery('.TotalSoft_Cal_Range').each(function(){
		if(jQuery(this).hasClass('TotalSoft_Cal_Rangeper'))
		{
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'%');
		}
		else if(jQuery(this).hasClass('TotalSoft_Cal_Rangepx'))
		{
			
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'px');
		}
		else if(jQuery(this).hasClass('TotalSoft_Cal_RangeSec'))
		{
			
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val()+'s');
		}
		else
		{
			jQuery('#'+jQuery(this).attr('id')+'_Output').html(jQuery(this).val());
		}
	})
}
function Copy_Shortcode_Cal(IDSHORT)
{
	var aux = document.createElement("input");
	var code = document.getElementById(IDSHORT).innerHTML;
	code = code.replace("&lt;", "<");
	code = code.replace("&gt;", ">");
	code = code.replace("&#039;", "'");
	code = code.replace("&#039;", "'");
	aux.setAttribute("value", code);
	document.body.appendChild(aux);
	aux.select();
	document.execCommand("copy");
	document.body.removeChild(aux);
}
function TS_Cal_TM_But(type, col_id)
{
	jQuery('.TS_Cal_Option_Div').css('display','none');
	jQuery('.Total_Soft_Cal_AMSetDiv_Button').removeClass('Total_Soft_Cal_AMSetDiv_Button_C');
	jQuery('#TS_Cal_TM_TBut_' + type + '_' + col_id).addClass('Total_Soft_Cal_AMSetDiv_Button_C');
	jQuery('#Total_Soft_Cal_AMSetTable_' + type + '_' + col_id).css('display','block');
}
function Total_Soft_Cal_AMD2_But1(Short_ID)
{
	alert('This is Our Free Version. For more adventures Click to buy Personal version.');
}
function TotalSoftCal_Edit(Total_Soft_Cal_ID)
{

	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_Edit', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_Cal_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			var data = JSON.parse(response);
			jQuery('#TotalSoftCal_Name').val(data[0]['TotalSoftCal_Name']);
			jQuery('#TotalSoftCal_Type').val(data[0]['TotalSoftCal_Type']);
			jQuery('#TotalSoftCal_Type').hide();
			setTimeout(function(){
				jQuery('#Total_SoftCal_Update').val(Total_Soft_Cal_ID);
				if(data[0]['TotalSoftCal_Type']=='Event Calendar')
				{
					jQuery('#TotalSoftCal_BackIconType').val(data[0]['TotalSoftCal_BackIconType']);jQuery('#TotalSoftCal_BgCol').val(data[0]['TotalSoftCal_BgCol']); jQuery('#TotalSoftCal_GrCol').val(data[0]['TotalSoftCal_GrCol']); jQuery('#TotalSoftCal_GW').val(data[0]['TotalSoftCal_GW']); jQuery('#TotalSoftCal_BW').val(data[0]['TotalSoftCal_BW']); jQuery('#TotalSoftCal_BStyle').val(data[0]['TotalSoftCal_BStyle']); jQuery('#TotalSoftCal_BCol').val(data[0]['TotalSoftCal_BCol']); jQuery('#TotalSoftCal_BSCol').val(data[0]['TotalSoftCal_BSCol']); jQuery('#TotalSoftCal_MW').val(data[0]['TotalSoftCal_MW']); jQuery('#TotalSoftCal_HBgCol').val(data[0]['TotalSoftCal_HBgCol']); jQuery('#TotalSoftCal_HCol').val(data[0]['TotalSoftCal_HCol']); jQuery('#TotalSoftCal_HFS').val(data[0]['TotalSoftCal_HFS']); jQuery('#TotalSoftCal_HFF').val(data[0]['TotalSoftCal_HFF']); jQuery('#TotalSoftCal_WBgCol').val(data[0]['TotalSoftCal_WBgCol']); jQuery('#TotalSoftCal_WCol').val(data[0]['TotalSoftCal_WCol']); jQuery('#TotalSoftCal_WFS').val(data[0]['TotalSoftCal_WFS']); jQuery('#TotalSoftCal_WFF').val(data[0]['TotalSoftCal_WFF']); jQuery('#TotalSoftCal_LAW').val(data[0]['TotalSoftCal_LAW']); jQuery('#TotalSoftCal_LAWS').val(data[0]['TotalSoftCal_LAWS']); jQuery('#TotalSoftCal_LAWC').val(data[0]['TotalSoftCal_LAWC']); jQuery('#TotalSoftCal_DBgCol').val(data[0]['TotalSoftCal_DBgCol']); jQuery('#TotalSoftCal_DCol').val(data[0]['TotalSoftCal_DCol']); jQuery('#TotalSoftCal_DFS').val(data[0]['TotalSoftCal_DFS']); jQuery('#TotalSoftCal_TBgCol').val(data[0]['TotalSoftCal_TBgCol']); jQuery('#TotalSoftCal_TCol').val(data[0]['TotalSoftCal_TCol']); jQuery('#TotalSoftCal_TFS').val(data[0]['TotalSoftCal_TFS']); jQuery('#TotalSoftCal_TNBgCol').val(data[0]['TotalSoftCal_TNBgCol']); jQuery('#TotalSoftCal_HovBgCol').val(data[0]['TotalSoftCal_HovBgCol']); jQuery('#TotalSoftCal_HovCol').val(data[0]['TotalSoftCal_HovCol']); jQuery('#TotalSoftCal_NumPos').val(data[0]['TotalSoftCal_NumPos']); jQuery('#TotalSoftCal_WDStart').val(data[0]['TotalSoftCal_WDStart']); jQuery('#TotalSoftCal_RefIcCol').val(data[0]['TotalSoftCal_RefIcCol']); jQuery('#TotalSoftCal_RefIcSize').val(data[0]['TotalSoftCal_RefIcSize']); jQuery('#TotalSoftCal_ArrowType').val(data[0]['TotalSoftCal_ArrowType']); jQuery('#TotalSoftCal_ArrowCol').val(data[0]['TotalSoftCal_ArrowCol']); jQuery('#TotalSoftCal_ArrowSize').val(data[0]['TotalSoftCal_ArrowSize']);
				}
				else if(data[0]['TotalSoftCal_Type']=='Simple Calendar')
				{
					jQuery('#TotalSoftCal2_WDStart').val(data[0]['TotalSoftCal2_WDStart']); jQuery('#TotalSoftCal2_BW').val(data[0]['TotalSoftCal2_BW']); jQuery('#TotalSoftCal2_BS').val(data[0]['TotalSoftCal2_BS']); jQuery('#TotalSoftCal2_BC').val(data[0]['TotalSoftCal2_BC']); jQuery('#TotalSoftCal2_W').val(data[0]['TotalSoftCal2_W']); jQuery('#TotalSoftCal2_H').val(data[0]['TotalSoftCal2_H']); jQuery('#TotalSoftCal2_BxShShow').val(data[0]['TotalSoftCal2_BxShShow']); jQuery('#TotalSoftCal2_BxShType').val(data[0]['TotalSoftCal2_BxShType']); jQuery('#TotalSoftCal2_BxShC').val(data[0]['TotalSoftCal2_BxShC']); jQuery('#TotalSoftCal2_MBgC').val(data[0]['TotalSoftCal2_MBgC']); jQuery('#TotalSoftCal2_MC').val(data[0]['TotalSoftCal2_MC']); jQuery('#TotalSoftCal2_MFS').val(data[0]['TotalSoftCal2_MFS']); jQuery('#TotalSoftCal2_MFF').val(data[0]['TotalSoftCal2_MFF']); jQuery('#TotalSoftCal2_WBgC').val(data[0]['TotalSoftCal2_WBgC']); jQuery('#TotalSoftCal2_WC').val(data[0]['TotalSoftCal2_WC']); jQuery('#TotalSoftCal2_WFS').val(data[0]['TotalSoftCal2_WFS']); jQuery('#TotalSoftCal2_WFF').val(data[0]['TotalSoftCal2_WFF']); jQuery('#TotalSoftCal2_LAW_W').val(data[0]['TotalSoftCal2_LAW_W']); jQuery('#TotalSoftCal2_LAW_S').val(data[0]['TotalSoftCal2_LAW_S']); jQuery('#TotalSoftCal2_LAW_C').val(data[0]['TotalSoftCal2_LAW_C']); jQuery('#TotalSoftCal2_DBgC').val(data[0]['TotalSoftCal2_DBgC']); jQuery('#TotalSoftCal2_DC').val(data[0]['TotalSoftCal2_DC']); jQuery('#TotalSoftCal2_DFS').val(data[0]['TotalSoftCal2_DFS']); jQuery('#TotalSoftCal2_TdBgC').val(data[0]['TotalSoftCal2_TdBgC']); jQuery('#TotalSoftCal2_TdC').val(data[0]['TotalSoftCal2_TdC']); jQuery('#TotalSoftCal2_TdFS').val(data[0]['TotalSoftCal2_TdFS']); jQuery('#TotalSoftCal2_EdBgC').val(data[0]['TotalSoftCal2_EdBgC']); jQuery('#TotalSoftCal2_EdC').val(data[0]['TotalSoftCal2_EdC']); jQuery('#TotalSoftCal2_EdFS').val(data[0]['TotalSoftCal2_EdFS']); jQuery('#TotalSoftCal2_HBgC').val(data[0]['TotalSoftCal2_HBgC']); jQuery('#TotalSoftCal2_HC').val(data[0]['TotalSoftCal2_HC']); jQuery('#TotalSoftCal2_ArrType').val(data[0]['TotalSoftCal2_ArrType']); jQuery('#TotalSoftCal2_ArrFS').val(data[0]['TotalSoftCal2_ArrFS']); jQuery('#TotalSoftCal2_ArrC').val(data[0]['TotalSoftCal2_ArrC']); jQuery('#TotalSoftCal2_OmBgC').val(data[0]['TotalSoftCal2_OmBgC']); jQuery('#TotalSoftCal2_OmC').val(data[0]['TotalSoftCal2_OmC']); jQuery('#TotalSoftCal2_OmFS').val(data[0]['TotalSoftCal2_OmFS']); jQuery('#TotalSoftCal2_Ev_HBgC').val(data[0]['TotalSoftCal2_Ev_HBgC']); jQuery('#TotalSoftCal2_Ev_HC').val(data[0]['TotalSoftCal2_Ev_HC']); jQuery('#TotalSoftCal2_Ev_HFS').val(data[0]['TotalSoftCal2_Ev_HFS']); jQuery('#TotalSoftCal2_Ev_HFF').val(data[0]['TotalSoftCal2_Ev_HFF']); jQuery('#TotalSoftCal2_Ev_HText').val(data[0]['TotalSoftCal2_Ev_HText']); jQuery('#TotalSoftCal2_Ev_BBgC').val(data[0]['TotalSoftCal2_Ev_BBgC']); jQuery('#TotalSoftCal2_Ev_TC').val(data[0]['TotalSoftCal2_Ev_TC']); jQuery('#TotalSoftCal2_Ev_TFF').val(data[0]['TotalSoftCal2_Ev_TFF']); jQuery('#TotalSoftCal2_Ev_TFS').val(data[0]['TotalSoftCal2_Ev_TFS']);
				}
				else if(data[0]['TotalSoftCal_Type']=='Flexible Calendar')
				{
					jQuery('#TotalSoftCal3_MW').val(data[0]['TotalSoftCal3_MW']); jQuery('#TotalSoftCal3_WDStart').val(data[0]['TotalSoftCal3_WDStart']); jQuery('#TotalSoftCal3_BgC').val(data[0]['TotalSoftCal3_BgC']); jQuery('#TotalSoftCal3_GrC').val(data[0]['TotalSoftCal3_GrC']); jQuery('#TotalSoftCal3_BBC').val(data[0]['TotalSoftCal3_BBC']); jQuery('#TotalSoftCal3_BoxShShow').val(data[0]['TotalSoftCal3_BoxShShow']); jQuery('#TotalSoftCal3_BoxShType').val(data[0]['TotalSoftCal3_BoxShType']); jQuery('#TotalSoftCal3_BoxShC').val(data[0]['TotalSoftCal3_BoxShC']); jQuery('#TotalSoftCal3_H_BgC').val(data[0]['TotalSoftCal3_H_BgC']); jQuery('#TotalSoftCal3_H_BTW').val(data[0]['TotalSoftCal3_H_BTW']); jQuery('#TotalSoftCal3_H_BTC').val(data[0]['TotalSoftCal3_H_BTC']); jQuery('#TotalSoftCal3_H_FF').val(data[0]['TotalSoftCal3_H_FF']); jQuery('#TotalSoftCal3_H_MFS').val(data[0]['TotalSoftCal3_H_MFS']); jQuery('#TotalSoftCal3_H_MC').val(data[0]['TotalSoftCal3_H_MC']); jQuery('#TotalSoftCal3_H_YFS').val(data[0]['TotalSoftCal3_H_YFS']); jQuery('#TotalSoftCal3_H_YC').val(data[0]['TotalSoftCal3_H_YC']); jQuery('#TotalSoftCal3_H_Format').val(data[0]['TotalSoftCal3_H_Format']); jQuery('#TotalSoftCal3_Arr_Type').val(data[0]['TotalSoftCal3_Arr_Type']); jQuery('#TotalSoftCal3_Arr_C').val(data[0]['TotalSoftCal3_Arr_C']); jQuery('#TotalSoftCal3_Arr_S').val(data[0]['TotalSoftCal3_Arr_S']); jQuery('#TotalSoftCal3_Arr_HC').val(data[0]['TotalSoftCal3_Arr_HC']); jQuery('#TotalSoftCal3_LAH_W').val(data[0]['TotalSoftCal3_LAH_W']); jQuery('#TotalSoftCal3_LAH_C').val(data[0]['TotalSoftCal3_LAH_C']); jQuery('#TotalSoftCal3_WD_BgC').val(data[0]['TotalSoftCal3_WD_BgC']); jQuery('#TotalSoftCal3_WD_C').val(data[0]['TotalSoftCal3_WD_C']); jQuery('#TotalSoftCal3_WD_FS').val(data[0]['TotalSoftCal3_WD_FS']); jQuery('#TotalSoftCal3_WD_FF').val(data[0]['TotalSoftCal3_WD_FF']); jQuery('#TotalSoftCal3_D_BgC').val(data[0]['TotalSoftCal3_D_BgC']); jQuery('#TotalSoftCal3_D_C').val(data[0]['TotalSoftCal3_D_C']); jQuery('#TotalSoftCal3_TD_BgC').val(data[0]['TotalSoftCal3_TD_BgC']); jQuery('#TotalSoftCal3_TD_C').val(data[0]['TotalSoftCal3_TD_C']); jQuery('#TotalSoftCal3_HD_BgC').val(data[0]['TotalSoftCal3_HD_BgC']); jQuery('#TotalSoftCal3_HD_C').val(data[0]['TotalSoftCal3_HD_C']); jQuery('#TotalSoftCal3_ED_C').val(data[0]['TotalSoftCal3_ED_C']); jQuery('#TotalSoftCal3_ED_HC').val(data[0]['TotalSoftCal3_ED_HC']); jQuery('#TotalSoftCal3_Ev_Format').val(data[0]['TotalSoftCal3_Ev_Format']); jQuery('#TotalSoftCal3_Ev_BTW').val(data[0]['TotalSoftCal3_Ev_BTW']); jQuery('#TotalSoftCal3_Ev_BTC').val(data[0]['TotalSoftCal3_Ev_BTC']); jQuery('#TotalSoftCal3_Ev_BgC').val(data[0]['TotalSoftCal3_Ev_BgC']); jQuery('#TotalSoftCal3_Ev_C').val(data[0]['TotalSoftCal3_Ev_C']); jQuery('#TotalSoftCal3_Ev_FS').val(data[0]['TotalSoftCal3_Ev_FS']); jQuery('#TotalSoftCal3_Ev_FF').val(data[0]['TotalSoftCal3_Ev_FF']);
				}
				else if(data[0]['TotalSoftCal_Type']=='TimeLine Calendar')
				{
					jQuery('#TotalSoftCal4_01').val(data[0]['TotalSoftCal4_01']); jQuery('#TotalSoftCal4_02').val(data[0]['TotalSoftCal4_02']); jQuery('#TotalSoftCal4_03').val(data[0]['TotalSoftCal4_03']); jQuery('#TotalSoftCal4_04').val(data[0]['TotalSoftCal4_04']); jQuery('#TotalSoftCal4_05').val(data[0]['TotalSoftCal4_05']); jQuery('#TotalSoftCal4_06').val(data[0]['TotalSoftCal4_06']); jQuery('#TotalSoftCal4_07').val(data[0]['TotalSoftCal4_07']); jQuery('#TotalSoftCal4_08').val(data[0]['TotalSoftCal4_08']); jQuery('#TotalSoftCal4_09').val(data[0]['TotalSoftCal4_09']); jQuery('#TotalSoftCal4_10').val(data[0]['TotalSoftCal4_10']); jQuery('#TotalSoftCal4_11').val(data[0]['TotalSoftCal4_11']); jQuery('#TotalSoftCal4_12').val(data[0]['TotalSoftCal4_12']); jQuery('#TotalSoftCal4_13').val(data[0]['TotalSoftCal4_13']); jQuery('#TotalSoftCal4_14').val(data[0]['TotalSoftCal4_14']); jQuery('#TotalSoftCal4_15').val(data[0]['TotalSoftCal4_15']); jQuery('#TotalSoftCal4_16').val(data[0]['TotalSoftCal4_16']); jQuery('#TotalSoftCal4_17').val(data[0]['TotalSoftCal4_17']); jQuery('#TotalSoftCal4_18').val(data[0]['TotalSoftCal4_18']); jQuery('#TotalSoftCal4_19').val(data[0]['TotalSoftCal4_19']); jQuery('#TotalSoftCal4_20').val(data[0]['TotalSoftCal4_20']); jQuery('#TotalSoftCal4_21').val(data[0]['TotalSoftCal4_21']); jQuery('#TotalSoftCal4_22').val(data[0]['TotalSoftCal4_22']); jQuery('#TotalSoftCal4_23').val(data[0]['TotalSoftCal4_23']); jQuery('#TotalSoftCal4_24').val(data[0]['TotalSoftCal4_24']); jQuery('#TotalSoftCal4_25').val(data[0]['TotalSoftCal4_25']); jQuery('#TotalSoftCal4_26').val(data[0]['TotalSoftCal4_26']); jQuery('#TotalSoftCal4_27').val(data[0]['TotalSoftCal4_27']); jQuery('#TotalSoftCal4_28').val(data[0]['TotalSoftCal4_28']); jQuery('#TotalSoftCal4_29').val(data[0]['TotalSoftCal4_29']); jQuery('#TotalSoftCal4_30').val(data[0]['TotalSoftCal4_30']); jQuery('#TotalSoftCal4_31').val(data[0]['TotalSoftCal4_31']); jQuery('#TotalSoftCal4_32').val(data[0]['TotalSoftCal4_32']); jQuery('#TotalSoftCal4_33').val(data[0]['TotalSoftCal4_33']); jQuery('#TotalSoftCal4_34').val(data[0]['TotalSoftCal4_34']); jQuery('#TotalSoftCal4_35').val(data[0]['TotalSoftCal4_35']); jQuery('#TotalSoftCal4_36').val(data[0]['TotalSoftCal4_36']); jQuery('#TotalSoftCal4_37').val(data[0]['TotalSoftCal4_37']); jQuery('#TotalSoftCal4_38').val(data[0]['TotalSoftCal4_38']); jQuery('#TotalSoftCal4_39').val(data[0]['TotalSoftCal4_39']);
				}
				jQuery('.Total_Soft_Cal_Color').alphaColorPicker();
				jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
				TotalSoft_Cal_Out();
			},500)
		}
	});

	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_Edit1', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_Cal_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){},
		success: function(response){
			var data = JSON.parse(response);
			jQuery('.Total_Soft_Cal_AMD2').animate({'opacity':0},500);
			jQuery('.Total_Soft_AMMTable').animate({'opacity':0},500);
			jQuery('.Total_Soft_AMOTable').animate({'opacity':0},500);
			jQuery('.Total_Soft_Cal_Update').animate({'opacity':1},500);
			jQuery('#Total_Soft_Cal_ID').html('[Total_Soft_Cal id="'+Total_Soft_Cal_ID+'"]');
			jQuery('#Total_Soft_Cal_TID').html('&lt;?php echo do_shortcode(&#039;[Total_Soft_Cal id="'+Total_Soft_Cal_ID+'"]&#039;);?&gt');

			if(data[0]['TotalSoftCal_Type']=='Event Calendar')
			{
				jQuery('#TotalSoftCal1_Ev_T_FS').val(data[0]['TotalSoftCal_01']); jQuery('#TotalSoftCal1_Ev_T_FF').val(data[0]['TotalSoftCal_02']); jQuery('#TotalSoftCal1_Ev_T_C').val(data[0]['TotalSoftCal_03']); jQuery('#TotalSoftCal1_Ev_T_TA').val(data[0]['TotalSoftCal_04']); jQuery('#TotalSoftCal1_Ev_TiF').val(data[0]['TotalSoftCal_05']); jQuery('#TotalSoftCal_BSType').val(data[0]['TotalSoftCal_06']); jQuery('#TotalSoftCal1_Ev_I_W').val(data[0]['TotalSoftCal_09']); jQuery('#TotalSoftCal1_Ev_I_Pos').val(data[0]['TotalSoftCal_10']);
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_1').css('display','block');
				},500)
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_1').animate({'opacity':1},500);
				},600)
				TS_Cal_TM_But('1', 'GO');
			}
			else if(data[0]['TotalSoftCal_Type']=='Simple Calendar')
			{
				jQuery('#TotalSoftCal2_Ev_T_TA').val(data[0]['TotalSoftCal_01']); jQuery('#TotalSoftCal2_Ev_I_W').val(data[0]['TotalSoftCal_02']); jQuery('#TotalSoftCal2_Ev_I_Pos').val(data[0]['TotalSoftCal_03']); jQuery('#TotalSoftCal2_Ev_TiF').val(data[0]['TotalSoftCal_04']); jQuery('#TotalSoftCal2_Ev_DaF').val(data[0]['TotalSoftCal_05']); jQuery('#TotalSoftCal2_Ev_ShDate').val(data[0]['TotalSoftCal_06']);
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_2').css('display','block');
				},500)
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_2').animate({'opacity':1},500);
				},600)
				TS_Cal_TM_But('2', 'GO');
			}
			else if(data[0]['TotalSoftCal_Type']=='Flexible Calendar')
			{
				jQuery('#TotalSoftCal3_Ev_TiF').val(data[0]['TotalSoftCal_01']); jQuery('#TotalSoftCal3_Ev_C_Type').val(data[0]['TotalSoftCal_02']); jQuery('#TotalSoftCal3_Ev_C_C').val(data[0]['TotalSoftCal_03']); jQuery('#TotalSoftCal3_Ev_C_HC').val(data[0]['TotalSoftCal_04']); jQuery('#TotalSoftCal3_Ev_C_FS').val(data[0]['TotalSoftCal_05']); jQuery('#TotalSoftCal3_Ev_LAH_W').val(data[0]['TotalSoftCal_06']); jQuery('#TotalSoftCal3_Ev_LAH_C').val(data[0]['TotalSoftCal_07']); jQuery('#TotalSoftCal3_Ev_B_BgC').val(data[0]['TotalSoftCal_08']); jQuery('#TotalSoftCal3_Ev_B_BC').val(data[0]['TotalSoftCal_09']); jQuery('#TotalSoftCal3_Ev_T_FS').val(data[0]['TotalSoftCal_10']); jQuery('#TotalSoftCal3_Ev_T_FF').val(data[0]['TotalSoftCal_11']); jQuery('#TotalSoftCal3_Ev_T_BgC').val(data[0]['TotalSoftCal_12']); jQuery('#TotalSoftCal3_Ev_T_C').val(data[0]['TotalSoftCal_13']); jQuery('#TotalSoftCal3_Ev_T_TA').val(data[0]['TotalSoftCal_14']); jQuery('#TotalSoftCal3_Ev_I_W').val(data[0]['TotalSoftCal_15']); jQuery('#TotalSoftCal3_Ev_I_Pos').val(data[0]['TotalSoftCal_16']); jQuery('#TotalSoftCal3_Ev_L_C').val(data[0]['TotalSoftCal_17']); jQuery('#TotalSoftCal3_Ev_L_HC').val(data[0]['TotalSoftCal_18']); jQuery('#TotalSoftCal3_Ev_L_Pos').val(data[0]['TotalSoftCal_19']); jQuery('#TotalSoftCal3_Ev_L_Text').val(data[0]['TotalSoftCal_20']); jQuery('#TotalSoftCal3_Ev_LAE_W').val(data[0]['TotalSoftCal_21']); jQuery('#TotalSoftCal3_Ev_LAE_C').val(data[0]['TotalSoftCal_22']); jQuery('#TotalSoftCal3_Ev_L_FS').val(data[0]['TotalSoftCal_23']); jQuery('#TotalSoftCal3_Ev_L_FF').val(data[0]['TotalSoftCal_24']); jQuery('#TotalSoftCal3_Ev_L_BW').val(data[0]['TotalSoftCal_25']); jQuery('#TotalSoftCal3_Ev_L_BC').val(data[0]['TotalSoftCal_26']); jQuery('#TotalSoftCal3_Ev_L_BR').val(data[0]['TotalSoftCal_27']); jQuery('#TotalSoftCal3_Ev_DaF').val(data[0]['TotalSoftCal_28']);
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_3').css('display','block');
				},500)
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_3').animate({'opacity':1},500);
				},600)
				TS_Cal_TM_But('3', 'GO');
			}
			else if(data[0]['TotalSoftCal_Type']=='TimeLine Calendar')
			{
				jQuery('#TotalSoftCal_4_01').val(data[0]['TotalSoftCal_01']); jQuery('#TotalSoftCal_4_02').val(data[0]['TotalSoftCal_02']); jQuery('#TotalSoftCal_4_03').val(data[0]['TotalSoftCal_03']); jQuery('#TotalSoftCal_4_04').val(data[0]['TotalSoftCal_04']); jQuery('#TotalSoftCal_4_05').val(data[0]['TotalSoftCal_05']); jQuery('#TotalSoftCal_4_06').val(data[0]['TotalSoftCal_06']); jQuery('#TotalSoftCal_4_07').val(data[0]['TotalSoftCal_07']); jQuery('#TotalSoftCal_4_08').val(data[0]['TotalSoftCal_08']); jQuery('#TotalSoftCal_4_09').val(data[0]['TotalSoftCal_09']); jQuery('#TotalSoftCal_4_10').val(data[0]['TotalSoftCal_10']); jQuery('#TotalSoftCal_4_11').val(data[0]['TotalSoftCal_11']); jQuery('#TotalSoftCal_4_12').val(data[0]['TotalSoftCal_12']); jQuery('#TotalSoftCal_4_13').val(data[0]['TotalSoftCal_13']); jQuery('#TotalSoftCal_4_14').val(data[0]['TotalSoftCal_14']); jQuery('#TotalSoftCal_4_15').val(data[0]['TotalSoftCal_15']); jQuery('#TotalSoftCal_4_16').val(data[0]['TotalSoftCal_16']); jQuery('#TotalSoftCal_4_17').val(data[0]['TotalSoftCal_17']); jQuery('#TotalSoftCal_4_18').val(data[0]['TotalSoftCal_18']); jQuery('#TotalSoftCal_4_19').val(data[0]['TotalSoftCal_19']); jQuery('#TotalSoftCal_4_20').val(data[0]['TotalSoftCal_20']); jQuery('#TotalSoftCal_4_21').val(data[0]['TotalSoftCal_21']); jQuery('#TotalSoftCal_4_22').val(data[0]['TotalSoftCal_22']); jQuery('#TotalSoftCal_4_23').val(data[0]['TotalSoftCal_23']); jQuery('#TotalSoftCal_4_24').val(data[0]['TotalSoftCal_24']); jQuery('#TotalSoftCal_4_25').val(data[0]['TotalSoftCal_25']); jQuery('#TotalSoftCal_4_26').val(data[0]['TotalSoftCal_26']); jQuery('#TotalSoftCal_4_27').val(data[0]['TotalSoftCal_27']); jQuery('#TotalSoftCal_4_28').val(data[0]['TotalSoftCal_28']); jQuery('#TotalSoftCal_4_29').val(data[0]['TotalSoftCal_29']);
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_4').css('display','block');
				},500)
				setTimeout(function(){
					jQuery('#Total_Soft_Cal_AMSetDiv_4').animate({'opacity':1},500);
				},600)
				TS_Cal_TM_But('4', 'GO');
			}
			jQuery('.Total_Soft_Cal_Color1').alphaColorPicker();
			jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
			TotalSoft_Cal_Out();

			setTimeout(function(){
				jQuery('.Total_Soft_Cal_AMD2').css('display','none');
				jQuery('.Total_Soft_AMMTable').css('display','none');
				jQuery('.Total_Soft_AMOTable').css('display','none');
				jQuery('.Total_Soft_Cal_Update').css('display','block');
				jQuery('.Total_Soft_Cal_AMD3').css('display','block');
				jQuery('#Total_Soft_AMSetTable_Main').css('display','block');
				jQuery('.Total_Soft_AMShortTable').css('display','table');
			},500)
			setTimeout(function(){
				jQuery('.Total_Soft_Cal_AMD3').animate({'opacity':1},500);
				jQuery('#Total_Soft_AMSetTable_Main').animate({'opacity':1},500);
				jQuery('.Total_Soft_AMShortTable').animate({'opacity':1},500);
				jQuery('.Total_Soft_Cal_Loading').css('display','none');
			},500)
		}
	});
}
function TotalSoftCal_Del(Total_Soft_Cal_ID)
{
	jQuery('#Total_Soft_AMOTable_Calendar_tr_'+Total_Soft_Cal_ID).find('.Total_Soft_Calendar_Del_Span').addClass('Total_Soft_Calendar_Del_Span1');
}
function TotalSoftCalendar_Del_No(Total_Soft_Cal_ID)
{
	jQuery('#Total_Soft_AMOTable_Calendar_tr_'+Total_Soft_Cal_ID).find('.Total_Soft_Calendar_Del_Span').removeClass('Total_Soft_Calendar_Del_Span1');
}
function TotalSoftCalendar_Del_Yes(Total_Soft_Cal_ID)
{
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_Del', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_Cal_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			location.reload();
		}
	});
}
function TotalSoftCal_Clone(Total_Soft_Cal_ID)
{
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_Clone', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_Cal_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			location.reload();
		}
	});
}
function TotalSoft_Reload()
{
	location.reload();
}
function TS_CalEv_Theme_Preview()
{
	var Total_Soft_CE_Theme_Prev = jQuery('#Total_Soft_CE_Theme_Prev').val();
	var TotalSoftCal_Name = jQuery('#TotalSoftCal_Name').val();
	var TotalSoftCal_Type = jQuery('#TotalSoftCal_Type').val();

	if(TotalSoftCal_Type == 'Event Calendar')
	{
		var TotalSoftCal_BgCol = jQuery('#TotalSoftCal_BgCol').val(); var TotalSoftCal_GrCol = jQuery('#TotalSoftCal_GrCol').val(); var TotalSoftCal_GW = jQuery('#TotalSoftCal_GW').val(); var TotalSoftCal_BW = jQuery('#TotalSoftCal_BW').val(); var TotalSoftCal_BStyle = jQuery('#TotalSoftCal_BStyle').val(); var TotalSoftCal_BCol = jQuery('#TotalSoftCal_BCol').val(); var TotalSoftCal_BSCol = jQuery('#TotalSoftCal_BSCol').val(); var TotalSoftCal_MW = jQuery('#TotalSoftCal_MW').val(); var TotalSoftCal_HBgCol = jQuery('#TotalSoftCal_HBgCol').val(); var TotalSoftCal_HCol = jQuery('#TotalSoftCal_HCol').val(); var TotalSoftCal_HFS = jQuery('#TotalSoftCal_HFS').val(); var TotalSoftCal_HFF = jQuery('#TotalSoftCal_HFF').val(); var TotalSoftCal_WBgCol = jQuery('#TotalSoftCal_WBgCol').val(); var TotalSoftCal_WCol = jQuery('#TotalSoftCal_WCol').val(); var TotalSoftCal_WFS = jQuery('#TotalSoftCal_WFS').val(); var TotalSoftCal_WFF = jQuery('#TotalSoftCal_WFF').val(); var TotalSoftCal_LAW = jQuery('#TotalSoftCal_LAW').val(); var TotalSoftCal_LAWS = jQuery('#TotalSoftCal_LAWS').val(); var TotalSoftCal_LAWC = jQuery('#TotalSoftCal_LAWC').val(); var TotalSoftCal_DBgCol = jQuery('#TotalSoftCal_DBgCol').val(); var TotalSoftCal_DCol = jQuery('#TotalSoftCal_DCol').val(); var TotalSoftCal_DFS = jQuery('#TotalSoftCal_DFS').val(); var TotalSoftCal_TBgCol = jQuery('#TotalSoftCal_TBgCol').val(); var TotalSoftCal_TCol = jQuery('#TotalSoftCal_TCol').val(); var TotalSoftCal_TFS = jQuery('#TotalSoftCal_TFS').val(); var TotalSoftCal_TNBgCol = jQuery('#TotalSoftCal_TNBgCol').val(); var TotalSoftCal_HovBgCol = jQuery('#TotalSoftCal_HovBgCol').val(); var TotalSoftCal_HovCol = jQuery('#TotalSoftCal_HovCol').val(); var TotalSoftCal_NumPos = jQuery('#TotalSoftCal_NumPos').val(); var TotalSoftCal_WDStart = jQuery('#TotalSoftCal_WDStart').val(); var TotalSoftCal_RefIcCol = jQuery('#TotalSoftCal_RefIcCol').val(); var TotalSoftCal_RefIcSize = jQuery('#TotalSoftCal_RefIcSize').val(); var TotalSoftCal_ArrowType = jQuery('#TotalSoftCal_ArrowType').val(); var TotalSoftCal_BSType = jQuery('#TotalSoftCal_BSType').val(); var TotalSoftCal_ArrowCol = jQuery('#TotalSoftCal_ArrowCol').val(); var TotalSoftCal_ArrowSize = jQuery('#TotalSoftCal_ArrowSize').val(); var TotalSoftCal1_Ev_T_FS = jQuery('#TotalSoftCal1_Ev_T_FS').val(); var TotalSoftCal1_Ev_T_FF = jQuery('#TotalSoftCal1_Ev_T_FF').val(); var TotalSoftCal1_Ev_T_C = jQuery('#TotalSoftCal1_Ev_T_C').val(); var TotalSoftCal1_Ev_T_TA = jQuery('#TotalSoftCal1_Ev_T_TA').val(); var TotalSoftCal1_Ev_TiF = jQuery('#TotalSoftCal1_Ev_TiF').val(); var TotalSoftCal1_Ev_I_W = jQuery('#TotalSoftCal1_Ev_I_W').val(); var TotalSoftCal1_Ev_I_Pos = jQuery('#TotalSoftCal1_Ev_I_Pos').val();

		if(TotalSoftCal_ArrowType=='1'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-angle-double-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-angle-double-right'; }
		else if(TotalSoftCal_ArrowType=='2'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-angle-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-angle-right'; }
		else if(TotalSoftCal_ArrowType=='3'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-circle-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-circle-right'; }
		else if(TotalSoftCal_ArrowType=='4'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-circle-o-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-circle-o-right'; }
		else if(TotalSoftCal_ArrowType=='5'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-arrow-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-arrow-right'; }
		else if(TotalSoftCal_ArrowType=='6'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-caret-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-caret-right'; }
		else if(TotalSoftCal_ArrowType=='7'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-caret-square-o-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-caret-square-o-right'; }
		else if(TotalSoftCal_ArrowType=='8'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-chevron-circle-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-chevron-circle-right'; }
		else if(TotalSoftCal_ArrowType=='9'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-chevron-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-chevron-right'; }
		else if(TotalSoftCal_ArrowType=='10'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-hand-o-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-hand-o-right'; }
		else if(TotalSoftCal_ArrowType=='11'){ var TotalSoftCal_ArrowLeft='totalsoft totalsoft-long-arrow-left'; var TotalSoftCal_ArrowRight='totalsoft totalsoft-long-arrow-right'; }

		var obj = new Array( TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal_BgCol, TotalSoftCal_GrCol, TotalSoftCal_GW, TotalSoftCal_BW, TotalSoftCal_BStyle, TotalSoftCal_BCol, TotalSoftCal_BSCol, TotalSoftCal_MW, TotalSoftCal_HBgCol, TotalSoftCal_HCol, TotalSoftCal_HFS, TotalSoftCal_HFF, TotalSoftCal_WBgCol, TotalSoftCal_WCol, TotalSoftCal_WFS, TotalSoftCal_WFF, TotalSoftCal_LAW, TotalSoftCal_LAWS, TotalSoftCal_LAWC, TotalSoftCal_DBgCol, TotalSoftCal_DCol, TotalSoftCal_DFS, TotalSoftCal_TBgCol, TotalSoftCal_TCol, TotalSoftCal_TFS, TotalSoftCal_TNBgCol, TotalSoftCal_HovBgCol, TotalSoftCal_HovCol, TotalSoftCal_NumPos, TotalSoftCal_WDStart, TotalSoftCal_RefIcCol, TotalSoftCal_RefIcSize, TotalSoftCal_ArrowType, TotalSoftCal_ArrowLeft, TotalSoftCal_ArrowRight, TotalSoftCal_ArrowCol, TotalSoftCal_ArrowSize, TotalSoftCal1_Ev_T_FS, TotalSoftCal1_Ev_T_FF, TotalSoftCal1_Ev_T_C, TotalSoftCal1_Ev_T_TA, TotalSoftCal1_Ev_TiF, TotalSoftCal_BSType, TotalSoftCal1_Ev_I_W, TotalSoftCal1_Ev_I_Pos );
	}
	else if(TotalSoftCal_Type == 'Simple Calendar')
	{
		var TotalSoftCal2_WDStart = jQuery('#TotalSoftCal2_WDStart').val(); var TotalSoftCal2_BW = jQuery('#TotalSoftCal2_BW').val(); var TotalSoftCal2_BS = jQuery('#TotalSoftCal2_BS').val(); var TotalSoftCal2_BC = jQuery('#TotalSoftCal2_BC').val(); var TotalSoftCal2_W = jQuery('#TotalSoftCal2_W').val(); var TotalSoftCal2_H = jQuery('#TotalSoftCal2_H').val(); var TotalSoftCal2_BxShShow = jQuery('#TotalSoftCal2_BxShShow').val(); var TotalSoftCal2_BxShType = jQuery('#TotalSoftCal2_BxShType').val(); var TotalSoftCal2_BxSh = ''; var TotalSoftCal2_BxShC = jQuery('#TotalSoftCal2_BxShC').val(); var TotalSoftCal2_MBgC = jQuery('#TotalSoftCal2_MBgC').val(); var TotalSoftCal2_MC = jQuery('#TotalSoftCal2_MC').val(); var TotalSoftCal2_MFS = jQuery('#TotalSoftCal2_MFS').val(); var TotalSoftCal2_MFF = jQuery('#TotalSoftCal2_MFF').val(); var TotalSoftCal2_WBgC = jQuery('#TotalSoftCal2_WBgC').val(); var TotalSoftCal2_WC = jQuery('#TotalSoftCal2_WC').val(); var TotalSoftCal2_WFS = jQuery('#TotalSoftCal2_WFS').val(); var TotalSoftCal2_WFF = jQuery('#TotalSoftCal2_WFF').val(); var TotalSoftCal2_LAW_W = jQuery('#TotalSoftCal2_LAW_W').val(); var TotalSoftCal2_LAW_S = jQuery('#TotalSoftCal2_LAW_S').val(); var TotalSoftCal2_LAW_C = jQuery('#TotalSoftCal2_LAW_C').val(); var TotalSoftCal2_DBgC = jQuery('#TotalSoftCal2_DBgC').val(); var TotalSoftCal2_DC = jQuery('#TotalSoftCal2_DC').val(); var TotalSoftCal2_DFS = jQuery('#TotalSoftCal2_DFS').val(); var TotalSoftCal2_TdBgC = jQuery('#TotalSoftCal2_TdBgC').val(); var TotalSoftCal2_TdC = jQuery('#TotalSoftCal2_TdC').val(); var TotalSoftCal2_TdFS = jQuery('#TotalSoftCal2_TdFS').val(); var TotalSoftCal2_EdBgC = jQuery('#TotalSoftCal2_EdBgC').val(); var TotalSoftCal2_EdC = jQuery('#TotalSoftCal2_EdC').val(); var TotalSoftCal2_EdFS = jQuery('#TotalSoftCal2_EdFS').val(); var TotalSoftCal2_HBgC = jQuery('#TotalSoftCal2_HBgC').val(); var TotalSoftCal2_HC = jQuery('#TotalSoftCal2_HC').val(); var TotalSoftCal2_ArrType = jQuery('#TotalSoftCal2_ArrType').val(); var TotalSoftCal2_ArrFS = jQuery('#TotalSoftCal2_ArrFS').val(); var TotalSoftCal2_ArrC = jQuery('#TotalSoftCal2_ArrC').val(); var TotalSoftCal2_OmBgC = jQuery('#TotalSoftCal2_OmBgC').val(); var TotalSoftCal2_OmC = jQuery('#TotalSoftCal2_OmC').val(); var TotalSoftCal2_OmFS = jQuery('#TotalSoftCal2_OmFS').val(); var TotalSoftCal2_Ev_HBgC = jQuery('#TotalSoftCal2_Ev_HBgC').val(); var TotalSoftCal2_Ev_HC = jQuery('#TotalSoftCal2_Ev_HC').val(); var TotalSoftCal2_Ev_HFS = jQuery('#TotalSoftCal2_Ev_HFS').val(); var TotalSoftCal2_Ev_HFF = jQuery('#TotalSoftCal2_Ev_HFF').val(); var TotalSoftCal2_Ev_HText = jQuery('#TotalSoftCal2_Ev_HText').val(); var TotalSoftCal2_Ev_BBgC = jQuery('#TotalSoftCal2_Ev_BBgC').val(); var TotalSoftCal2_Ev_TC = jQuery('#TotalSoftCal2_Ev_TC').val(); var TotalSoftCal2_Ev_TFF = jQuery('#TotalSoftCal2_Ev_TFF').val(); var TotalSoftCal2_Ev_TFS = jQuery('#TotalSoftCal2_Ev_TFS').val(); var TotalSoftCal2_Ev_T_TA = jQuery('#TotalSoftCal2_Ev_T_TA').val(); var TotalSoftCal2_Ev_I_W = jQuery('#TotalSoftCal2_Ev_I_W').val(); var TotalSoftCal2_Ev_I_Pos = jQuery('#TotalSoftCal2_Ev_I_Pos').val(); var TotalSoftCal2_Ev_TiF = jQuery('#TotalSoftCal2_Ev_TiF').val(); var TotalSoftCal2_Ev_DaF = jQuery('#TotalSoftCal2_Ev_DaF').val(); var TotalSoftCal2_Ev_ShDate = jQuery('#TotalSoftCal2_Ev_ShDate').val();

		var obj = new Array( TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal2_WDStart, TotalSoftCal2_BW, TotalSoftCal2_BS, TotalSoftCal2_BC, TotalSoftCal2_W, TotalSoftCal2_H, TotalSoftCal2_BxShShow, TotalSoftCal2_BxShType, TotalSoftCal2_BxSh, TotalSoftCal2_BxShC, TotalSoftCal2_MBgC, TotalSoftCal2_MC, TotalSoftCal2_MFS, TotalSoftCal2_MFF, TotalSoftCal2_WBgC, TotalSoftCal2_WC, TotalSoftCal2_WFS, TotalSoftCal2_WFF, TotalSoftCal2_LAW_W, TotalSoftCal2_LAW_S, TotalSoftCal2_LAW_C, TotalSoftCal2_DBgC, TotalSoftCal2_DC, TotalSoftCal2_DFS, TotalSoftCal2_TdBgC, TotalSoftCal2_TdC, TotalSoftCal2_TdFS, TotalSoftCal2_EdBgC, TotalSoftCal2_EdC, TotalSoftCal2_EdFS, TotalSoftCal2_HBgC, TotalSoftCal2_HC, TotalSoftCal2_ArrType, TotalSoftCal2_ArrFS, TotalSoftCal2_ArrC, TotalSoftCal2_OmBgC, TotalSoftCal2_OmC, TotalSoftCal2_OmFS, TotalSoftCal2_Ev_HBgC, TotalSoftCal2_Ev_HC, TotalSoftCal2_Ev_HFS, TotalSoftCal2_Ev_HFF, TotalSoftCal2_Ev_HText, TotalSoftCal2_Ev_BBgC, TotalSoftCal2_Ev_TC, TotalSoftCal2_Ev_TFF, TotalSoftCal2_Ev_TFS, TotalSoftCal2_Ev_T_TA, TotalSoftCal2_Ev_I_W, TotalSoftCal2_Ev_I_Pos, TotalSoftCal2_Ev_TiF, TotalSoftCal2_Ev_DaF, TotalSoftCal2_Ev_ShDate );
	}
	else if(TotalSoftCal_Type == 'Flexible Calendar')
	{
		var TotalSoftCal3_MW = jQuery('#TotalSoftCal3_MW').val(); var TotalSoftCal3_WDStart = jQuery('#TotalSoftCal3_WDStart').val(); var TotalSoftCal3_BgC = jQuery('#TotalSoftCal3_BgC').val(); var TotalSoftCal3_GrC = jQuery('#TotalSoftCal3_GrC').val(); var TotalSoftCal3_BBC = jQuery('#TotalSoftCal3_BBC').val(); var TotalSoftCal3_BoxShShow = jQuery('#TotalSoftCal3_BoxShShow').val(); var TotalSoftCal3_BoxShType = jQuery('#TotalSoftCal3_BoxShType').val(); var TotalSoftCal3_BoxSh = ''; var TotalSoftCal3_BoxShC = jQuery('#TotalSoftCal3_BoxShC').val(); var TotalSoftCal3_H_BgC = jQuery('#TotalSoftCal3_H_BgC').val(); var TotalSoftCal3_H_BTW = jQuery('#TotalSoftCal3_H_BTW').val(); var TotalSoftCal3_H_BTC = jQuery('#TotalSoftCal3_H_BTC').val(); var TotalSoftCal3_H_FF = jQuery('#TotalSoftCal3_H_FF').val(); var TotalSoftCal3_H_MFS = jQuery('#TotalSoftCal3_H_MFS').val(); var TotalSoftCal3_H_MC = jQuery('#TotalSoftCal3_H_MC').val(); var TotalSoftCal3_H_YFS = jQuery('#TotalSoftCal3_H_YFS').val(); var TotalSoftCal3_H_YC = jQuery('#TotalSoftCal3_H_YC').val(); var TotalSoftCal3_H_Format = jQuery('#TotalSoftCal3_H_Format').val(); var TotalSoftCal3_Arr_Type = jQuery('#TotalSoftCal3_Arr_Type').val(); var TotalSoftCal3_Arr_C = jQuery('#TotalSoftCal3_Arr_C').val(); var TotalSoftCal3_Arr_S = jQuery('#TotalSoftCal3_Arr_S').val(); var TotalSoftCal3_Arr_HC = jQuery('#TotalSoftCal3_Arr_HC').val(); var TotalSoftCal3_LAH_W = jQuery('#TotalSoftCal3_LAH_W').val(); var TotalSoftCal3_LAH_C = jQuery('#TotalSoftCal3_LAH_C').val(); var TotalSoftCal3_WD_BgC = jQuery('#TotalSoftCal3_WD_BgC').val(); var TotalSoftCal3_WD_C = jQuery('#TotalSoftCal3_WD_C').val(); var TotalSoftCal3_WD_FS = jQuery('#TotalSoftCal3_WD_FS').val(); var TotalSoftCal3_WD_FF = jQuery('#TotalSoftCal3_WD_FF').val(); var TotalSoftCal3_D_BgC = jQuery('#TotalSoftCal3_D_BgC').val(); var TotalSoftCal3_D_C = jQuery('#TotalSoftCal3_D_C').val(); var TotalSoftCal3_TD_BgC = jQuery('#TotalSoftCal3_TD_BgC').val(); var TotalSoftCal3_TD_C = jQuery('#TotalSoftCal3_TD_C').val(); var TotalSoftCal3_HD_BgC = jQuery('#TotalSoftCal3_HD_BgC').val(); var TotalSoftCal3_HD_C = jQuery('#TotalSoftCal3_HD_C').val(); var TotalSoftCal3_ED_C = jQuery('#TotalSoftCal3_ED_C').val(); var TotalSoftCal3_ED_HC = jQuery('#TotalSoftCal3_ED_HC').val(); var TotalSoftCal3_Ev_Format = jQuery('#TotalSoftCal3_Ev_Format').val(); var TotalSoftCal3_Ev_BTW = jQuery('#TotalSoftCal3_Ev_BTW').val(); var TotalSoftCal3_Ev_BTC = jQuery('#TotalSoftCal3_Ev_BTC').val(); var TotalSoftCal3_Ev_BgC = jQuery('#TotalSoftCal3_Ev_BgC').val(); var TotalSoftCal3_Ev_C = jQuery('#TotalSoftCal3_Ev_C').val(); var TotalSoftCal3_Ev_FS = jQuery('#TotalSoftCal3_Ev_FS').val(); var TotalSoftCal3_Ev_FF = jQuery('#TotalSoftCal3_Ev_FF').val(); var TotalSoftCal3_Ev_C_Type = jQuery('#TotalSoftCal3_Ev_C_Type').val(); var TotalSoftCal3_Ev_C_C = jQuery('#TotalSoftCal3_Ev_C_C').val(); var TotalSoftCal3_Ev_C_HC = jQuery('#TotalSoftCal3_Ev_C_HC').val(); var TotalSoftCal3_Ev_C_FS = jQuery('#TotalSoftCal3_Ev_C_FS').val(); var TotalSoftCal3_Ev_LAH_W = jQuery('#TotalSoftCal3_Ev_LAH_W').val(); var TotalSoftCal3_Ev_LAH_C = jQuery('#TotalSoftCal3_Ev_LAH_C').val(); var TotalSoftCal3_Ev_B_BgC = jQuery('#TotalSoftCal3_Ev_B_BgC').val(); var TotalSoftCal3_Ev_B_BC = jQuery('#TotalSoftCal3_Ev_B_BC').val(); var TotalSoftCal3_Ev_T_FS = jQuery('#TotalSoftCal3_Ev_T_FS').val(); var TotalSoftCal3_Ev_T_FF = jQuery('#TotalSoftCal3_Ev_T_FF').val(); var TotalSoftCal3_Ev_T_BgC = jQuery('#TotalSoftCal3_Ev_T_BgC').val(); var TotalSoftCal3_Ev_T_C = jQuery('#TotalSoftCal3_Ev_T_C').val(); var TotalSoftCal3_Ev_T_TA = jQuery('#TotalSoftCal3_Ev_T_TA').val(); var TotalSoftCal3_Ev_I_W = jQuery('#TotalSoftCal3_Ev_I_W').val(); var TotalSoftCal3_Ev_I_Pos = jQuery('#TotalSoftCal3_Ev_I_Pos').val(); var TotalSoftCal3_Ev_L_C = jQuery('#TotalSoftCal3_Ev_L_C').val(); var TotalSoftCal3_Ev_L_HC = jQuery('#TotalSoftCal3_Ev_L_HC').val(); var TotalSoftCal3_Ev_L_Pos = jQuery('#TotalSoftCal3_Ev_L_Pos').val(); var TotalSoftCal3_Ev_L_Text = jQuery('#TotalSoftCal3_Ev_L_Text').val(); var TotalSoftCal3_Ev_LAE_W = jQuery('#TotalSoftCal3_Ev_LAE_W').val(); var TotalSoftCal3_Ev_LAE_C = jQuery('#TotalSoftCal3_Ev_LAE_C').val(); var TotalSoftCal3_Ev_L_FS = jQuery('#TotalSoftCal3_Ev_L_FS').val(); var TotalSoftCal3_Ev_L_FF = jQuery('#TotalSoftCal3_Ev_L_FF').val(); var TotalSoftCal3_Ev_L_BW = jQuery('#TotalSoftCal3_Ev_L_BW').val(); var TotalSoftCal3_Ev_L_BC = jQuery('#TotalSoftCal3_Ev_L_BC').val(); var TotalSoftCal3_Ev_L_BR = jQuery('#TotalSoftCal3_Ev_L_BR').val(); var TotalSoftCal3_Ev_TiF = jQuery('#TotalSoftCal3_Ev_TiF').val(); var TotalSoftCal3_Ev_DaF = jQuery('#TotalSoftCal3_Ev_DaF').val();

		var obj = new Array( TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal3_MW, TotalSoftCal3_WDStart, TotalSoftCal3_BgC, TotalSoftCal3_GrC, TotalSoftCal3_BBC, TotalSoftCal3_BoxShShow, TotalSoftCal3_BoxShType, TotalSoftCal3_BoxSh, TotalSoftCal3_BoxShC, TotalSoftCal3_H_BgC, TotalSoftCal3_H_BTW, TotalSoftCal3_H_BTC, TotalSoftCal3_H_FF, TotalSoftCal3_H_MFS, TotalSoftCal3_H_MC, TotalSoftCal3_H_YFS, TotalSoftCal3_H_YC, TotalSoftCal3_H_Format, TotalSoftCal3_Arr_Type, TotalSoftCal3_Arr_C, TotalSoftCal3_Arr_S, TotalSoftCal3_Arr_HC, TotalSoftCal3_LAH_W, TotalSoftCal3_LAH_C, TotalSoftCal3_WD_BgC, TotalSoftCal3_WD_C, TotalSoftCal3_WD_FS, TotalSoftCal3_WD_FF, TotalSoftCal3_D_BgC, TotalSoftCal3_D_C, TotalSoftCal3_TD_BgC, TotalSoftCal3_TD_C, TotalSoftCal3_HD_BgC, TotalSoftCal3_HD_C, TotalSoftCal3_ED_C, TotalSoftCal3_ED_HC, TotalSoftCal3_Ev_Format, TotalSoftCal3_Ev_BTW, TotalSoftCal3_Ev_BTC, TotalSoftCal3_Ev_BgC, TotalSoftCal3_Ev_C, TotalSoftCal3_Ev_FS, TotalSoftCal3_Ev_FF, TotalSoftCal3_Ev_TiF, TotalSoftCal3_Ev_C_Type, TotalSoftCal3_Ev_C_C, TotalSoftCal3_Ev_C_HC, TotalSoftCal3_Ev_C_FS, TotalSoftCal3_Ev_LAH_W, TotalSoftCal3_Ev_LAH_C, TotalSoftCal3_Ev_B_BgC, TotalSoftCal3_Ev_B_BC, TotalSoftCal3_Ev_T_FS, TotalSoftCal3_Ev_T_FF, TotalSoftCal3_Ev_T_BgC, TotalSoftCal3_Ev_T_C, TotalSoftCal3_Ev_T_TA, TotalSoftCal3_Ev_I_W, TotalSoftCal3_Ev_I_Pos, TotalSoftCal3_Ev_L_C, TotalSoftCal3_Ev_L_HC, TotalSoftCal3_Ev_L_Pos, TotalSoftCal3_Ev_L_Text, TotalSoftCal3_Ev_LAE_W, TotalSoftCal3_Ev_LAE_C, TotalSoftCal3_Ev_L_FS, TotalSoftCal3_Ev_L_FF, TotalSoftCal3_Ev_L_BW, TotalSoftCal3_Ev_L_BC, TotalSoftCal3_Ev_L_BR, TotalSoftCal3_Ev_DaF );
	}
	else if(TotalSoftCal_Type == 'TimeLine Calendar')
	{
		var TotalSoftCal4_01 = jQuery('#TotalSoftCal4_01').val(); var TotalSoftCal4_02 = jQuery('#TotalSoftCal4_02').val(); var TotalSoftCal4_03 = jQuery('#TotalSoftCal4_03').val(); var TotalSoftCal4_04 = jQuery('#TotalSoftCal4_04').val(); var TotalSoftCal4_05 = jQuery('#TotalSoftCal4_05').val(); var TotalSoftCal4_06 = jQuery('#TotalSoftCal4_06').val(); var TotalSoftCal4_07 = jQuery('#TotalSoftCal4_07').val(); var TotalSoftCal4_08 = jQuery('#TotalSoftCal4_08').val(); var TotalSoftCal4_09 = jQuery('#TotalSoftCal4_09').val(); var TotalSoftCal4_10 = jQuery('#TotalSoftCal4_10').val(); var TotalSoftCal4_11 = jQuery('#TotalSoftCal4_11').val(); var TotalSoftCal4_12 = jQuery('#TotalSoftCal4_12').val(); var TotalSoftCal4_13 = jQuery('#TotalSoftCal4_13').val(); var TotalSoftCal4_14 = jQuery('#TotalSoftCal4_14').val(); var TotalSoftCal4_15 = jQuery('#TotalSoftCal4_15').val(); var TotalSoftCal4_16 = jQuery('#TotalSoftCal4_16').val(); var TotalSoftCal4_17 = jQuery('#TotalSoftCal4_17').val(); var TotalSoftCal4_18 = jQuery('#TotalSoftCal4_18').val(); var TotalSoftCal4_19 = jQuery('#TotalSoftCal4_19').val(); var TotalSoftCal4_20 = jQuery('#TotalSoftCal4_20').val(); var TotalSoftCal4_21 = jQuery('#TotalSoftCal4_21').val(); var TotalSoftCal4_22 = jQuery('#TotalSoftCal4_22').val(); var TotalSoftCal4_23 = jQuery('#TotalSoftCal4_23').val(); var TotalSoftCal4_24 = jQuery('#TotalSoftCal4_24').val(); var TotalSoftCal4_25 = jQuery('#TotalSoftCal4_25').val(); var TotalSoftCal4_26 = jQuery('#TotalSoftCal4_26').val(); var TotalSoftCal4_27 = jQuery('#TotalSoftCal4_27').val(); var TotalSoftCal4_28 = jQuery('#TotalSoftCal4_28').val(); var TotalSoftCal4_29 = jQuery('#TotalSoftCal4_29').val(); var TotalSoftCal4_30 = jQuery('#TotalSoftCal4_30').val(); var TotalSoftCal4_31 = jQuery('#TotalSoftCal4_31').val(); var TotalSoftCal4_32 = jQuery('#TotalSoftCal4_32').val(); var TotalSoftCal4_33 = jQuery('#TotalSoftCal4_33').val(); var TotalSoftCal4_34 = jQuery('#TotalSoftCal4_34').val(); var TotalSoftCal4_35 = jQuery('#TotalSoftCal4_35').val(); var TotalSoftCal4_36 = jQuery('#TotalSoftCal4_36').val(); var TotalSoftCal4_37 = jQuery('#TotalSoftCal4_37').val(); var TotalSoftCal4_38 = jQuery('#TotalSoftCal4_38').val(); var TotalSoftCal4_39 = jQuery('#TotalSoftCal4_39').val(); var TotalSoftCal_4_01 = jQuery('#TotalSoftCal_4_01').val(); var TotalSoftCal_4_02 = jQuery('#TotalSoftCal_4_02').val(); var TotalSoftCal_4_03 = jQuery('#TotalSoftCal_4_03').val(); var TotalSoftCal_4_04 = jQuery('#TotalSoftCal_4_04').val(); var TotalSoftCal_4_05 = jQuery('#TotalSoftCal_4_05').val(); var TotalSoftCal_4_06 = jQuery('#TotalSoftCal_4_06').val(); var TotalSoftCal_4_07 = jQuery('#TotalSoftCal_4_07').val(); var TotalSoftCal_4_08 = jQuery('#TotalSoftCal_4_08').val(); var TotalSoftCal_4_09 = jQuery('#TotalSoftCal_4_09').val(); var TotalSoftCal_4_10 = jQuery('#TotalSoftCal_4_10').val(); var TotalSoftCal_4_11 = jQuery('#TotalSoftCal_4_11').val(); var TotalSoftCal_4_12 = jQuery('#TotalSoftCal_4_12').val(); var TotalSoftCal_4_13 = jQuery('#TotalSoftCal_4_13').val(); var TotalSoftCal_4_14 = jQuery('#TotalSoftCal_4_14').val(); var TotalSoftCal_4_15 = jQuery('#TotalSoftCal_4_15').val(); var TotalSoftCal_4_16 = jQuery('#TotalSoftCal_4_16').val(); var TotalSoftCal_4_17 = jQuery('#TotalSoftCal_4_17').val(); var TotalSoftCal_4_18 = jQuery('#TotalSoftCal_4_18').val(); var TotalSoftCal_4_19 = jQuery('#TotalSoftCal_4_19').val(); var TotalSoftCal_4_20 = jQuery('#TotalSoftCal_4_20').val(); var TotalSoftCal_4_21 = jQuery('#TotalSoftCal_4_21').val(); var TotalSoftCal_4_22 = jQuery('#TotalSoftCal_4_22').val(); var TotalSoftCal_4_23 = jQuery('#TotalSoftCal_4_23').val(); var TotalSoftCal_4_24 = jQuery('#TotalSoftCal_4_24').val(); var TotalSoftCal_4_25 = jQuery('#TotalSoftCal_4_25').val(); var TotalSoftCal_4_26 = jQuery('#TotalSoftCal_4_26').val(); var TotalSoftCal_4_27 = jQuery('#TotalSoftCal_4_27').val(); var TotalSoftCal_4_28 = jQuery('#TotalSoftCal_4_28').val(); var TotalSoftCal_4_29 = jQuery('#TotalSoftCal_4_29').val();

		var obj = new Array( TotalSoftCal_Name, TotalSoftCal_Type, TotalSoftCal4_01, TotalSoftCal4_02, TotalSoftCal4_03, TotalSoftCal4_04, TotalSoftCal4_05, TotalSoftCal4_06, TotalSoftCal4_07, TotalSoftCal4_08, TotalSoftCal4_09, TotalSoftCal4_10, TotalSoftCal4_11, TotalSoftCal4_12, TotalSoftCal4_13, TotalSoftCal4_14, TotalSoftCal4_15, TotalSoftCal4_16, TotalSoftCal4_17, TotalSoftCal4_18, TotalSoftCal4_19, TotalSoftCal4_20, TotalSoftCal4_21, TotalSoftCal4_22, TotalSoftCal4_23, TotalSoftCal4_24, TotalSoftCal4_25, TotalSoftCal4_26, TotalSoftCal4_27, TotalSoftCal4_28, TotalSoftCal4_29, TotalSoftCal4_30, TotalSoftCal4_31, TotalSoftCal4_32, TotalSoftCal4_33, TotalSoftCal4_34, TotalSoftCal4_35, TotalSoftCal4_36, TotalSoftCal4_37, TotalSoftCal4_38, TotalSoftCal4_39, TotalSoftCal_4_01, TotalSoftCal_4_02, TotalSoftCal_4_03, TotalSoftCal_4_04, TotalSoftCal_4_05, TotalSoftCal_4_06, TotalSoftCal_4_07, TotalSoftCal_4_08, TotalSoftCal_4_09, TotalSoftCal_4_10, TotalSoftCal_4_11, TotalSoftCal_4_12, TotalSoftCal_4_13, TotalSoftCal_4_14, TotalSoftCal_4_15, TotalSoftCal_4_16, TotalSoftCal_4_17, TotalSoftCal_4_18, TotalSoftCal_4_19, TotalSoftCal_4_20, TotalSoftCal_4_21, TotalSoftCal_4_22, TotalSoftCal_4_23, TotalSoftCal_4_24, TotalSoftCal_4_25, TotalSoftCal_4_26, TotalSoftCal_4_27, TotalSoftCal_4_28, TotalSoftCal_4_29 );
	}
	var myJSON = JSON.stringify(obj);

	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'Total_Soft_Cal_Prev', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: myJSON, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			jQuery('.Total_Soft_Cal_Loading').css('display','none');
			window.open(Total_Soft_CE_Theme_Prev, "_blank");
		}
	});
}
function TotalSoftCal_EditEv(Total_Soft_CalEv_ID)
{
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_EditEv', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_CalEv_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			jQuery('.Total_Soft_Cal_AMD2').animate({'opacity':0},500);
			jQuery('.Total_Soft_AMMTable1').animate({'opacity':0},500);
			jQuery('.Total_Soft_AMOTable1').animate({'opacity':0},500);
			jQuery('.Total_Soft_Cal_Save_Ev').animate({'opacity':0},500);
			jQuery('.Total_Soft_Cal_Update_Ev').animate({'opacity':1},500);
			jQuery('#Total_SoftCal_EvUpdate').val(Total_Soft_CalEv_ID);

			var data = JSON.parse(response);

			jQuery('#TotalSoftCal_EvName').val(data[0]['TotalSoftCal_EvName']);
			jQuery('#TotalSoftCal_EvCal').val(data[0]['TotalSoftCal_EvCal']);
			jQuery('#TotalSoftCal_EvStartDate').val(data[0]['TotalSoftCal_EvStartDate']);
			jQuery('#TotalSoftCal_EvEndDate').val(data[0]['TotalSoftCal_EvEndDate']);
			jQuery('#TotalSoftCal_EvURL').val(data[0]['TotalSoftCal_EvURL']);
			jQuery('#TotalSoftCal_EvURLNewTab').val(data[0]['TotalSoftCal_EvURLNewTab']);
			jQuery('#TotalSoftCal_EvStartTime').val(data[0]['TotalSoftCal_EvStartTime']);
			jQuery('#TotalSoftCal_EvEndTime').val(data[0]['TotalSoftCal_EvEndTime']);
			jQuery('#TotalSoftCal_EvColor').val(data[0]['TotalSoftCal_EvColor']);

			setTimeout(function(){
				jQuery('.Total_Soft_Cal_Color').alphaColorPicker();
				jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
			},500)
		}
	});
	Total_Soft_Cal_Editor();
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_EditEv_Desc', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_CalEv_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){},
		success: function(response){
			var data = JSON.parse(response);

			jQuery('#TotalSoftCal_EvDesc_1').val(data[0]['TotalSoftCal_EvDesc']);
			tinyMCE.get('TotalSoftCal_EvDesc').setContent(data[0]['TotalSoftCal_EvDesc']);

			jQuery('#TotalSoftCalendar_URL_Image_2').val(data[0]['TotalSoftCal_EvImg']);
			jQuery('#TotalSoftCalendar_URL_Video_2').val(data[0]['TotalSoftCal_EvVid_Src']);
			jQuery('#TotalSoftCalendar_URL_Video_1').val(data[0]['TotalSoftCal_EvVid_Iframe']);
		}
	});

	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_EditEv_Rec', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_CalEv_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){},
		success: function(response){
			var data = JSON.parse(response);

			jQuery('#TotalSoftCal_EvRec').val(data[0]['TotalSoftCal_EvRec']);
			setTimeout(function(){
				jQuery('.Total_Soft_Cal_AMD2').css('display','none');
				jQuery('.Total_Soft_AMMTable1').css('display','none');
				jQuery('.Total_Soft_AMOTable1').css('display','none');
				jQuery('.Total_Soft_Cal_Save_Ev').css('display','none');
				jQuery('.Total_Soft_Cal_Update_Ev').css('display','block');
				jQuery('.Total_Soft_Cal_AMD3').css('display','block');
				jQuery('.Total_Soft_AMEvTable').css('display','table');
				Total_Soft_Cal_Editor();
			},500)
			setTimeout(function(){
				jQuery('.Total_Soft_Cal_AMD3').animate({'opacity':1},500);
				jQuery('.Total_Soft_AMEvTable').animate({'opacity':1},500);
			},500)
			jQuery('.Total_Soft_Cal_Loading').css('display','none');
		}
	});
}
function TotalSoftCal_DelEv(Total_Soft_CalEv_ID)
{
	jQuery('#Total_Soft_AMOTable1_Calendar_tr_'+Total_Soft_CalEv_ID).find('.Total_Soft_Calendar_Del_Span').addClass('Total_Soft_Calendar_Del_Span1');
}
function TotalSoftCal_DelEv_No(Total_Soft_CalEv_ID)
{
	jQuery('#Total_Soft_AMOTable1_Calendar_tr_'+Total_Soft_CalEv_ID).find('.Total_Soft_Calendar_Del_Span').removeClass('Total_Soft_Calendar_Del_Span1');
}
function TotalSoftCal_DelEv_Yes(Total_Soft_CalEv_ID)
{
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCal_DelEv', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_CalEv_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			location.reload();
		}
	});
}
function Total_Soft_CalEv_AMD2_But1()
{
	jQuery('.Total_Soft_Cal_AMD2').animate({'opacity':0},500);
	jQuery('.Total_Soft_AMMTable1').animate({'opacity':0},500);
	jQuery('.Total_Soft_AMOTable1').animate({'opacity':0},500);
	jQuery('.Total_Soft_Cal_Save_Ev').animate({'opacity':1},500);
	jQuery('.Total_Soft_Cal_Update_Ev').animate({'opacity':0},500);
	jQuery('.Total_Soft_Cal_Color').alphaColorPicker();
	jQuery('.wp-picker-holder').addClass('alpha-picker-holder');
	setTimeout(function(){
		jQuery('.Total_Soft_Cal_AMD2').css('display','none');
		jQuery('.Total_Soft_AMMTable1').css('display','none');
		jQuery('.Total_Soft_AMOTable1').css('display','none');
		jQuery('.Total_Soft_Cal_Save_Ev').css('display','block');
		jQuery('.Total_Soft_Cal_Update_Ev').css('display','none');
		jQuery('.Total_Soft_Cal_AMD3').css('display','block');
		jQuery('.Total_Soft_AMEvTable').css('display','table');
		Total_Soft_Cal_Editor();
	},500)
	setTimeout(function(){
		jQuery('.Total_Soft_Cal_AMD3').animate({'opacity':1},500);
		jQuery('.Total_Soft_AMEvTable').animate({'opacity':1},500);
	},500)
}
function TotalSoftCalendar_URL_Clicked()
{
	var nIntervId = setInterval(function(){
		var code = jQuery('#TotalSoftCalendar_URL_1').val();
		if(code.indexOf('https://www.youtube.com/')>0)
		{
			if(code.indexOf('list')>0 || code.indexOf('index')>0)
			{
				if(code.indexOf('embed')>0)
				{
					var TotalSoftCodes1=code.split('[embed]');
					var TotalSoftCodes2=TotalSoftCodes1[1].split('[/embed]');
					var TotalSoftCodes3=TotalSoftCodes2[0].split('www.youtube.com/watch?v=');
					if(TotalSoftCodes3[1].length != 11) { TotalSoftCodes3[1] = TotalSoftCodes3[1].substr(0,11); }
					jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodes3[1]);
					jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodes3[1]);
					jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodes3[1]+'/mqdefault.jpg');

					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0){ clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				}
				else
				{
					var TotalSoftCodes1 = code.split('<a href="https://www.youtube.com/');
					var TotalSoftCodes2= TotalSoftCodes1[1].split("=");
					var TotalSoftCodeSrc = TotalSoftCodes2[1].split('&');
					jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodeSrc[0]); 
					jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodeSrc[0]);
					jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodeSrc[0]+'/mqdefault.jpg');
					
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				}
			}
			else if(code.indexOf('embed')>0)
			{
				var TotalSoftCodes1=code.split('[embed]');
				var TotalSoftCodes2=TotalSoftCodes1[1].split('[/embed]');
				if(TotalSoftCodes2[0].indexOf('watch?')>0)
				{
					var TotalSoftCodes3=TotalSoftCodes2[0].split('=');
					if(TotalSoftCodes3[1].length != 11) { TotalSoftCodes3[1] = TotalSoftCodes3[1].substr(0,11); }
					
					jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodes3[1]); 
					jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodes3[1]);
					jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodes3[1]+'/mqdefault.jpg');
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				}
				else if(TotalSoftCodes2[0].indexOf('/embed/')>0)
				{
					var TotalSoftCodes3=TotalSoftCodes2[0].split('/embed/');
					if(TotalSoftCodes3[1].length != 11) { TotalSoftCodes3[1] = TotalSoftCodes3[1].substr(0,11); }

					jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodes3[1]);
					jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodes3[1]+'/mqdefault.jpg');
					jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/watch?v='+TotalSoftCodes3[1]);

					if(jQuery('#TotalSoftGallery_Video_URL_2').val().length>0){ clearInterval(nIntervId); jQuery('#TotalSoftGallery_Video_URL_1').val(''); }
				}
				else
				{
					var TotalSoftCodeSrc=TotalSoftCodes2[0];
					var TotalSoftImsrc=TotalSoftCodeSrc.split('embed/');

					jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftImsrc[1]); 
					jQuery('#TotalSoftCalendar_URL_Video_2').val(TotalSoftCodeSrc);
					jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftImsrc[1]+'/mqdefault.jpg');
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				}
			}
			else
			{
				var TotalSoftCodes2= TotalSoftCodes1[1].split('=');
				var TotalSoftCodeSrc = TotalSoftCodes2[1].split('">https://');

				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodeSrc[0]); 
				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodeSrc[0]);
				jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodeSrc[0]+'/mqdefault.jpg');
				if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
			}
		}
		else if(code.indexOf('https://youtu.be/')>0)
		{
			if(code.indexOf('embed')>0)
			{
				var TotalSoftCodes1=code.split('[embed]');
				var TotalSoftCodes2=TotalSoftCodes1[1].split('[/embed]');
				var TotalSoftCodes3=TotalSoftCodes2[0].split('youtu.be/');
				if(TotalSoftCodes3[1].length != 11) { TotalSoftCodes3[1] = TotalSoftCodes3[1].substr(0,11); }

				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodes3[1]);
				jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodes3[1]+'/mqdefault.jpg');
				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodes3[1]);

				if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0){ clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
			}
			else
			{
				var TotalSoftCodes1 = code.split('<a href="https://youtu.be/'); 
				var TotalSoftCodeSrc = TotalSoftCodes1[1].split('">https://');

				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://www.youtube.com/embed/'+TotalSoftCodeSrc[0]);
				jQuery('#TotalSoftCalendar_URL_Image_2').val('http://img.youtube.com/vi/'+TotalSoftCodeSrc[0]+'/mqdefault.jpg');
				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://www.youtube.com/watch?v='+TotalSoftCodeSrc[0]);

				if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
			}
		}
		else if(code.indexOf('https://vimeo.com/')>0)
		{
			if(code.indexOf('embed')>0)
			{
				var s1=code.split('[embed]https://vimeo.com/');
				var src=s1[1].split('[/embed]');
				if(src[0].length>9)
				{
					var real_src=src[0].split('/');
					src[0]=real_src[2];
				}
				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://player.vimeo.com/video/'+src[0]);
				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://vimeo.com/'+src[0]);

				var ajaxurl = object.ajaxurl;
				var data = {
				action: 'TSoftCal_Vimeo_Video_Image', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
				foobar: 'https://player.vimeo.com/video/'+src[0], // translates into $_POST['foobar'] in PHP
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#TotalSoftCalendar_URL_Image_2').val(response);
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				});
			}
			else if(code.indexOf('player')>0)
			{
				var s1 = code.split('<a href="https://player.vimeo.com/video/'); 
				var src = s1[1].split('">https://');
				if(src[0].length>9)
				{
					var real_src=src[0].split('/');
					src[0]=real_src[2];
				}
				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://vimeo.com/'+src[0]); 
				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://player.vimeo.com/video/'+src[0]);
				
				var ajaxurl = object.ajaxurl;
				var data = {
				action: 'TSoftCal_Vimeo_Video_Image', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
				foobar: 'https://player.vimeo.com/video/'+src[0], // translates into $_POST['foobar'] in PHP
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#TotalSoftCalendar_URL_Image_2').val(response);
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				});
			}
			else
			{
				var s1 = code.split('<a href="https://vimeo.com/'); 
				var src = s1[1].split('">https://');
				if(src[0].length>9)
				{
					var real_src=src[0].split('/');
					src[0]=real_src[2];
				}
				jQuery('#TotalSoftCalendar_URL_Video_2').val('https://player.vimeo.com/video/'+src[0]);
				jQuery('#TotalSoftCalendar_URL_Video_1').val('https://vimeo.com/'+src[0]);

				var ajaxurl = object.ajaxurl;
				var data = {
				action: 'TSoftCal_Vimeo_Video_Image', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
				foobar: 'https://player.vimeo.com/video/'+src[0], // translates into $_POST['foobar'] in PHP
				};
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#TotalSoftCalendar_URL_Image_2').val(response);
					if(jQuery('#TotalSoftCalendar_URL_Video_2').val().length>0){ clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
				});
			}
		}
		else if(code.indexOf('img')>0)
		{
			var s=code.split('src="'); 
			var src=s[1].split('"');
			jQuery('#TotalSoftCalendar_URL_Video_1').val(src[0]);
			jQuery('#TotalSoftCalendar_URL_Image_2').val(src[0]);
			if(jQuery('#TotalSoftCalendar_URL_Image_2').val().length>0) { clearInterval(nIntervId); jQuery('#TotalSoftCalendar_URL_1').val(''); }
		}
	},100)
}
function TotalSoftCal_EditCl(Total_Soft_CalEv_ID)
{
	jQuery.ajax({
		type: 'POST',
		url: object.ajaxurl,
		data: {
			action: 'TotalSoftCalEv_Clon', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
			foobar: Total_Soft_CalEv_ID, // translates into $_POST['foobar'] in PHP
		},
		beforeSend: function(){
			jQuery('.Total_Soft_Cal_Loading').css('display','block');
		},
		success: function(response){
			location.reload();
		}
	});
}
function TS_Cal_Del_Vid_Cl()
{
	jQuery('#TotalSoftCalendar_URL_Video_2').val('');
	jQuery('#TotalSoftCalendar_URL_Video_1').val('');
	jQuery('#TotalSoftCalendar_URL_Image_2').val('');
}
function Total_Soft_Cal_Editor()
{
	tinymce.init({
		selector: '#TotalSoftCal_EvDesc',
		menubar: false,
		statusbar: false,
		height: 250,
		plugins: [
			'advlist autolink lists link image charmap print preview hr',
			'searchreplace wordcount code media ',
			'insertdatetime save table contextmenu directionality',
			'paste textcolor colorpicker textpattern imagetools codesample'
		],
		toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
		toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink code | insertdatetime preview | forecolor backcolor",
		toolbar3: "table | hr | subscript superscript | charmap | print | codesample ",
		fontsize_formats: '8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px',
		font_formats: 'Abadi MT Condensed Light = Abadi MT Condensed Light; ABeeZee = ABeeZee, sans-serif; Abel = Abel, sans-serif; Abhaya Libre = Abhaya Libre, serif; Abril Fatface = Abril Fatface, cursive; Aclonica = Aclonica, sans-serif; Acme = Acme, sans-serif; Actor = Actor, sans-serif; Adamina = Adamina, serif; Advent Pro = Advent Pro, sans-serif; Aguafina Script = Aguafina Script, cursive; Aharoni = Aharoni; Akronim = Akronim, cursive; Aladin = Aladin, cursive; Aldhabi = Aldhabi; Aldrich = Aldrich, sans-serif; Alef = Alef, sans-serif; Alegreya = Alegreya, serif; Alegreya Sans = Alegreya Sans, sans-serif; Alegreya Sans SC = Alegreya Sans SC, sans-serif; Alegreya SC = Alegreya SC, serif; Alex Brush = Alex Brush, cursive; Alfa Slab One = Alfa Slab One, cursive; Alice = Alice, serif; Alike = Alike, serif; Alike Angular = Alike Angular, serif; Allan = Allan, cursive; Allerta = Allerta, sans-serif; Allerta Stencil = Allerta Stencil, sans-serif; Allura = Allura, cursive; Almendra = Almendra, serif; Almendra Display = Almendra Display, cursive; Almendra SC = Almendra SC, serif; Amarante = Amarante, cursive; Amaranth = Amaranth, sans-serif; Amatic SC = Amatic SC, cursive; Amethysta = Amethysta, serif; Amiko = Amiko, sans-serif; Amiri = Amiri, serif; Amita = Amita, cursive; Anaheim = Anaheim, sans-serif; Andada = Andada, serif; Andalus = Andalus; Andika = Andika, sans-serif; Angkor = Angkor, cursive; Angsana New = Angsana New; AngsanaUPC = AngsanaUPC; Annie Use Your Telescope = Annie Use Your Telescope, cursive; Anonymous Pro = Anonymous Pro, monospace; Antic = Antic, sans-serif; Antic Didone = Antic Didone, serif; Antic Slab = Antic Slab, serif; Anton = Anton, sans-serif; Aparajita = Aparajita; Arabic Typesetting = Arabic Typesetting; Arapey = Arapey, serif; Arbutus = Arbutus, cursive; Arbutus Slab = Arbutus Slab, serif; Architects Daughter = Architects Daughter, cursive; Archivo = Archivo, sans-serif; Archivo Black = Archivo Black, sans-serif; Archivo Narrow = Archivo Narrow, sans-serif; Aref Ruqaa = Aref Ruqaa, serif; Arial = Arial; Arial Black = Arial Black; Arimo = Arimo, sans-serif; Arima Madurai = Arima Madurai, cursive; Arizonia = Arizonia, cursive; Armata = Armata, sans-serif; Arsenal = Arsenal, sans-serif; Artifika = Artifika, serif; Arvo = Arvo, serif; Arya = Arya, sans-serif; Asap = Asap, sans-serif; Asap Condensed = Asap Condensed, sans-serif; Asar = Asar, serif; Asset = Asset, cursive; Assistant = Assistant, sans-serif; Astloch = Astloch, cursive; Asul = Asul, sans-serif; Athiti = Athiti, sans-serif; Atma = Atma, cursive; Atomic Age = Atomic Age, cursive; Aubrey = Aubrey, cursive; Audiowide = Audiowide, cursive; Autour One = Autour One, cursive; Average = Average, serif; Average Sans = Average Sans, sans-serif; Averia Gruesa Libre = Averia Gruesa Libre, cursive; Averia Libre = Averia Libre, cursive; Averia Sans Libre = Averia Sans Libre, cursive; Averia Serif Libre = Averia Serif Libre, cursive; Bad Script = Bad Script, cursive; Bahiana = Bahiana, cursive; Baloo = Baloo, cursive; Balthazar = Balthazar, serif; Bangers = Bangers, cursive; Barlow = Barlow, sans-serif; Barlow Condensed = Barlow Condensed, sans-serif; Barlow Semi Condensed = Barlow Semi Condensed, sans-serif; Barrio = Barrio, cursive; Basic = Basic, sans-serif; Batang = Batang; BatangChe = BatangChe; Battambang = Battambang, cursive; Baumans = Baumans, cursive; Bayon = Bayon, cursive; Belgrano = Belgrano, serif; Bellefair = Bellefair, serif; Belleza = Belleza, sans-serif; BenchNine = BenchNine, sans-serif; Bentham = Bentham, serif; Berkshire Swash = Berkshire Swash, cursive; Bevan = Bevan, cursive; Bigelow Rules = Bigelow Rules, cursive; Bigshot One = Bigshot One, cursive; Bilbo = Bilbo, cursive; Bilbo Swash Caps = Bilbo Swash Caps, cursive; BioRhyme = BioRhyme, serif; BioRhyme Expanded = BioRhyme Expanded, serif; Biryani = Biryani, sans-serif; Bitter = Bitter, serif; Black And White Picture = Black And White Picture, sans-serif; Black Han Sans = Black Han Sans, sans-serif; Black Ops One = Black Ops One, cursive; Bokor = Bokor, cursive; Bonbon = Bonbon, cursive; Boogaloo = Boogaloo, cursive; Bowlby One = Bowlby One, cursive; Bowlby One SC = Bowlby One SC, cursive; Brawler = Brawler, serif; Bree Serif = Bree Serif, serif; Browallia New = Browallia New; BrowalliaUPC = BrowalliaUPC; Bubbler One = Bubbler One, sans-serif; Bubblegum Sans = Bubblegum Sans, cursive; Buda = Buda, cursive; Buenard = Buenard, serif; Bungee = Bungee, cursive; Bungee Hairline = Bungee Hairline, cursive; Bungee Inline = Bungee Inline, cursive; Bungee Outline = Bungee Outline, cursive; Bungee Shade = Bungee Shade, cursive; Butcherman = Butcherman, cursive; Butterfly Kids = Butterfly Kids, cursive; Cabin = Cabin, sans-serif; Cabin Condensed = Cabin Condensed, sans-serif; Cabin Sketch = Cabin Sketch, cursive; Caesar Dressing = Caesar Dressing, cursive; Cagliostro = Cagliostro, sans-serif; Cairo = Cairo, sans-serif; Calibri = Calibri; Calibri Light = Calibri Light; Calisto MT = Calisto MT; Calligraffitti = Calligraffitti, cursive; Cambay = Cambay, sans-serif; Cambo = Cambo, serif; Cambria = Cambria; Candal = Candal, sans-serif; Candara = Candara; Cantarell = Cantarell, sans-serif; Cantata One = Cantata One, serif; Cantora One = Cantora One, sans-serif; Capriola = Capriola, sans-serif; Cardo = Cardo, serif; Carme = Carme, sans-serif; Carrois Gothic = Carrois Gothic, sans-serif; Carrois Gothic SC = Carrois Gothic SC, sans-serif; Carter One = Carter One, cursive; Catamaran = Catamaran, sans-serif; Caudex = Caudex, serif; Caveat = Caveat, cursive; Caveat Brush = Caveat Brush, cursive; Cedarville Cursive = Cedarville Cursive, cursive; Century Gothic = Century Gothic; Ceviche One = Ceviche One, cursive; Changa = Changa, sans-serif; Changa One = Changa One, cursive; Chango = Chango, cursive; Chathura = Chathura, sans-serif; Chau Philomene One = Chau Philomene One, sans-serif; Chela One = Chela One, cursive; Chelsea Market = Chelsea Market, cursive; Chenla = Chenla, cursive; Cherry Cream Soda = Cherry Cream Soda, cursive; Cherry Swash = Cherry Swash, cursive; Chewy = Chewy, cursive; Chicle = Chicle, cursive; Chivo = Chivo, sans-serif; Chonburi = Chonburi, cursive; Cinzel = Cinzel, serif; Cinzel Decorative = Cinzel Decorative, cursive; Clicker Script = Clicker Script, cursive; Coda = Coda, cursive; Coda Caption = Coda Caption, sans-serif; Codystar = Codystar, cursive; Coiny = Coiny, cursive; Combo = Combo, cursive; Comic Sans MS = Comic Sans MS; Coming Soon = Coming Soon, cursive; Comfortaa = Comfortaa, cursive; Concert One = Concert One, cursive; Condiment = Condiment, cursive; Consolas = Consolas; Constantia = Constantia; Content = Content, cursive; Contrail One = Contrail One, cursive; Convergence = Convergence, sans-serif; Cookie = Cookie, cursive; Copperplate Gothic = Copperplate Gothic; Copperplate Gothic Light = Copperplate Gothic Light; Copse = Copse, serif; Corbel = Corbel; Corben = Corben, cursive; Cordia New = Cordia New; CordiaUPC = CordiaUPC; Cormorant = Cormorant, serif; Cormorant Garamond = Cormorant Garamond, serif; Cormorant Infant = Cormorant Infant, serif; Cormorant SC = Cormorant SC, serif; Cormorant Unicase = Cormorant Unicase, serif; Cormorant Upright = Cormorant Upright, serif; Courgette = Courgette, cursive; Courier New = Courier New; Cousine = Cousine, monospace; Coustard = Coustard, serif; Covered By Your Grace = Covered By Your Grace, cursive; Crafty Girls = Crafty Girls, cursive; Creepster = Creepster, cursive; Crete Round = Crete Round, serif; Crimson Text = Crimson Text, serif; Croissant One = Croissant One, cursive; Crushed = Crushed, cursive; Cuprum = Cuprum, sans-serif; Cute Font = Cute Font, cursive; Cutive = Cutive, serif; Cutive Mono = Cutive Mono, monospace; Damion = Damion, cursive; Dancing Script = Dancing Script, cursive; Dangrek = Dangrek, cursive; DaunPenh = DaunPenh; David = David; David Libre = David Libre, serif; Dawning of a New Day = Dawning of a New Day, cursive; Days One = Days One, sans-serif; Delius = Delius, cursive; Delius Swash Caps = Delius Swash Caps, cursive; Delius Unicase = Delius Unicase, cursive; Della Respira = Della Respira, serif; Denk One = Denk One, sans-serif; Devonshire = Devonshire, cursive; DFKai-SB = DFKai-SB; Dhurjati = Dhurjati, sans-serif; Didact Gothic = Didact Gothic, sans-serif; DilleniaUPC = DilleniaUPC; Diplomata = Diplomata, cursive; Diplomata SC = Diplomata SC, cursive; Do Hyeon = Do Hyeon, sans-serif; DokChampa = DokChampa; Dokdo = Dokdo, cursive; Domine = Domine, serif; Donegal One = Donegal One, serif; Doppio One = Doppio One, sans-serif; Dorsa = Dorsa, sans-serif; Dosis = Dosis, sans-serif; Dotum = Dotum; DotumChe = DotumChe; Dr Sugiyama = Dr Sugiyama, cursive; Duru Sans = Duru Sans, sans-serif; Dynalight = Dynalight, cursive; Eagle Lake = Eagle Lake, cursive; East Sea Dokdo = East Sea Dokdo, cursive; Eater = Eater, cursive; EB Garamond = EB Garamond, serif; Ebrima = Ebrima; Economica = Economica, sans-serif; Eczar = Eczar, serif; El Messiri = El Messiri, sans-serif; Electrolize = Electrolize, sans-serif; Elsie = Elsie, cursive; Elsie Swash Caps = Elsie Swash Caps, cursive; Emblema One = Emblema One, cursive; Emilys Candy = Emilys Candy, cursive; Encode Sans = Encode Sans, sans-serif; Encode Sans Condensed = Encode Sans Condensed, sans-serif; Encode Sans Expanded = Encode Sans Expanded, sans-serif; Encode Sans Semi Condensed = Encode Sans Semi Condensed, sans-serif; Encode Sans Semi Expanded = Encode Sans Semi Expanded, sans-serif; Engagement = Engagement, cursive; Englebert = Englebert, sans-serif; Enriqueta = Enriqueta, serif; Erica One = Erica One, cursive; Esteban = Esteban, serif; Estrangelo Edessa = Estrangelo Edessa; EucrosiaUPC = EucrosiaUPC; Euphemia = Euphemia; Euphoria Script = Euphoria Script, cursive; Ewert = Ewert, cursive; Exo = Exo, sans-serif; Expletus Sans = Expletus Sans, cursive; FangSong = FangSong; Fanwood Text = Fanwood Text, serif; Farsan = Farsan, cursive; Fascinate = Fascinate, cursive; Fascinate Inline = Fascinate Inline, cursive; Faster One = Faster One, cursive; Fasthand = Fasthand, serif; Fauna One = Fauna One, serif; Faustina = Faustina, serif; Federant = Federant, cursive; Federo = Federo, sans-serif; Felipa = Felipa, cursive; Fenix = Fenix, serif; Finger Paint = Finger Paint, cursive; Fira Mono = Fira Mono, monospace; Fira Sans = Fira Sans, sans-serif; Fira Sans Condensed = Fira Sans Condensed, sans-serif; Fira Sans Extra Condensed = Fira Sans Extra Condensed, sans-serif; Fjalla One = Fjalla One, sans-serif; Fjord One = Fjord One, serif; Flamenco = Flamenco, cursive; Flavors = Flavors, cursive; Fondamento = Fondamento, cursive; Fontdiner Swanky = Fontdiner Swanky, cursive; Forum = Forum, cursive; Francois One = Francois One, sans-serif; Frank Ruhl Libre = Frank Ruhl Libre, serif; Franklin Gothic Medium = Franklin Gothic Medium; FrankRuehl = FrankRuehl; Freckle Face = Freckle Face, cursive; Fredericka the Great = Fredericka the Great, cursive; Fredoka One = Fredoka One, cursive; Freehand = Freehand, cursive; FreesiaUPC = FreesiaUPC; Fresca = Fresca, sans-serif; Frijole = Frijole, cursive; Fruktur = Fruktur, cursive; Fugaz One = Fugaz One, cursive; Gabriela = Gabriela, serif; Gabriola = Gabriola; Gadugi = Gadugi; Gaegu = Gaegu, cursive; Gafata = Gafata, sans-serif; Galada = Galada, cursive; Galdeano = Galdeano, sans-serif; Galindo = Galindo, cursive; Gamja Flower = Gamja Flower, cursive; Gautami = Gautami; Gentium Basic = Gentium Basic, serif; Gentium Book Basic = Gentium Book Basic, serif; Geo = Geo, sans-serif; Georgia = Georgia; Geostar = Geostar, cursive; Geostar Fill = Geostar Fill, cursive; Germania One = Germania One, cursive; GFS Didot = GFS Didot, serif; GFS Neohellenic = GFS Neohellenic, sans-serif; Gidugu = Gidugu, sans-serif; Gilda Display = Gilda Display, serif; Gisha = Gisha; Give You Glory = Give You Glory, cursive; Glass Antiqua = Glass Antiqua, cursive; Glegoo = Glegoo, serif; Gloria Hallelujah = Gloria Hallelujah, cursive; Goblin One = Goblin One, cursive; Gochi Hand = Gochi Hand, cursive; Gorditas = Gorditas, cursive; Gothic A1 = Gothic A1, sans-serif; Graduate = Graduate, cursive; Grand Hotel = Grand Hotel, cursive; Gravitas One = Gravitas One, cursive; Great Vibes = Great Vibes, cursive; Griffy = Griffy, cursive; Gruppo = Gruppo, cursive; Gudea = Gudea, sans-serif; Gugi = Gugi, cursive; Gulim = Gulim; GulimChe = GulimChe; Gungsuh = Gungsuh; GungsuhChe = GungsuhChe; Gurajada = Gurajada, serif; Habibi = Habibi, serif; Halant = Halant, serif; Hammersmith One = Hammersmith One, sans-serif; Hanalei = Hanalei, cursive; Hanalei Fill = Hanalei Fill, cursive; Handlee = Handlee, cursive; Hanuman = Hanuman, serif; Happy Monkey = Happy Monkey, cursive; Harmattan = Harmattan, sans-serif; Headland One = Headland One, serif; Heebo = Heebo, sans-serif; Henny Penny = Henny Penny, cursive; Herr Von Muellerhoff = Herr Von Muellerhoff, cursive; Hi Melody = Hi Melody, cursive; Hind = Hind, sans-serif; Holtwood One SC = Holtwood One SC, serif; Homemade Apple = Homemade Apple, cursive; Homenaje = Homenaje, sans-serif; IBM Plex Mono = IBM Plex Mono, monospace; IBM Plex Sans = IBM Plex Sans, sans-serif; IBM Plex Sans Condensed = IBM Plex Sans Condensed, sans-serif; IBM Plex Serif = IBM Plex Serif, serif; Iceberg = Iceberg, cursive; Iceland = Iceland, cursive; IM Fell Double Pica = IM Fell Double Pica, serif; IM Fell Double Pica SC = IM Fell Double Pica SC, serif; IM Fell DW Pica = IM Fell DW Pica, serif; IM Fell DW Pica SC = IM Fell DW Pica SC, serif; IM Fell English = IM Fell English, serif; IM Fell English SC = IM Fell English SC, serif; IM Fell French Canon = IM Fell French Canon, serif; IM Fell French Canon SC = IM Fell French Canon SC, serif; IM Fell Great Primer = IM Fell Great Primer, serif; IM Fell Great Primer SC = IM Fell Great Primer SC, serif; Impact = Impact; Imprima = Imprima, sans-serif; Inconsolata = Inconsolata, monospace; Inder = Inder, sans-serif; Indie Flower = Indie Flower, cursive; Inika = Inika, serif; Irish Grover = Irish Grover, cursive; IrisUPC = IrisUPC; Istok Web = Istok Web, sans-serif; Iskoola Pota = Iskoola Pota; Italiana = Italiana, serif; Italianno = Italianno, cursive; Itim = Itim, cursive; Jacques Francois = Jacques Francois, serif; Jacques Francois Shadow = Jacques Francois Shadow, cursive; Jaldi = Jaldi, sans-serif; JasmineUPC = JasmineUPC; Jim Nightshade = Jim Nightshade, cursive; Jockey One = Jockey One, sans-serif; Jolly Lodger = Jolly Lodger, cursive; Jomhuria = Jomhuria, cursive; Josefin Sans = Josefin Sans, sans-serif; Josefin Slab = Josefin Slab, serif; Joti One = Joti One, cursive; Jua = Jua, sans-serif; Judson = Judson, serif; Julee = Julee, cursive; Julius Sans One = Julius Sans One, sans-serif; Junge = Junge, serif; Jura = Jura, sans-serif; Just Another Hand = Just Another Hand, cursive; Just Me Again Down Here = Just Me Again Down Here, cursive; Kadwa = Kadwa, serif; KaiTi = KaiTi; Kalam = Kalam, cursive; Kalinga = Kalinga; Kameron = Kameron, serif; Kanit = Kanit, sans-serif; Kantumruy = Kantumruy, sans-serif; Karla = Karla, sans-serif; Karma = Karma, serif; Kartika = Kartika; Katibeh = Katibeh, cursive; Kaushan Script = Kaushan Script, cursive; Kavivanar = Kavivanar, cursive; Kavoon = Kavoon, cursive; Kdam Thmor = Kdam Thmor, cursive; Keania One = Keania One, cursive; Kelly Slab = Kelly Slab, cursive; Kenia = Kenia, cursive; Khand = Khand, sans-serif; Khmer = Khmer, cursive; Khmer UI = Khmer UI; Khula = Khula, sans-serif; Kirang Haerang = Kirang Haerang, cursive; Kite One = Kite One, sans-serif; Knewave = Knewave, cursive; KodchiangUPC = KodchiangUPC; Kokila = Kokila; Kotta One = Kotta One, serif; Koulen = Koulen, cursive; Kranky = Kranky, cursive; Kreon = Kreon, serif; Kristi = Kristi, cursive; Krona One = Krona One, sans-serif; Kurale = Kurale, serif; La Belle Aurore = La Belle Aurore, cursive; Laila = Laila, serif; Lakki Reddy = Lakki Reddy, cursive; Lalezar = Lalezar, cursive; Lancelot = Lancelot, cursive; Lao UI = Lao UI; Lateef = Lateef, cursive; Latha = Latha; Lato = Lato, sans-serif; League Script = League Script, cursive; Leckerli One = Leckerli One, cursive; Ledger = Ledger, serif; Leelawadee = Leelawadee; Lekton = Lekton, sans-serif; Lemon = Lemon, cursive; Lemonada = Lemonada, cursive; Levenim MT = Levenim MT; Libre Baskerville = Libre Baskerville, serif; Libre Franklin = Libre Franklin, sans-serif; Life Savers = Life Savers, cursive; Lilita One = Lilita One, cursive; Lily Script One = Lily Script One, cursive; LilyUPC = LilyUPC; Limelight = Limelight, cursive; Linden Hill = Linden Hill, serif; Lobster = Lobster, cursive; Lobster Two = Lobster Two, cursive; Londrina Outline = Londrina Outline, cursive; Londrina Shadow = Londrina Shadow, cursive; Londrina Sketch = Londrina Sketch, cursive; Londrina Solid = Londrina Solid, cursive; Lora = Lora, serif; Love Ya Like A Sister = Love Ya Like A Sister, cursive; Loved by the King = Loved by the King, cursive; Lovers Quarrel = Lovers Quarrel, cursive; Lucida Console = Lucida Console; Lucida Handwriting Italic = Lucida Handwriting Italic; Lucida Sans Unicode = Lucida Sans Unicode; Luckiest Guy = Luckiest Guy, cursive; Lusitana = Lusitana, serif; Lustria = Lustria, serif; Macondo = Macondo, cursive; Macondo Swash Caps = Macondo Swash Caps, cursive; Mada = Mada, sans-serif; Magra = Magra, sans-serif; Maiden Orange = Maiden Orange, cursive; Maitree = Maitree, serif; Mako = Mako, sans-serif; Malgun Gothic = Malgun Gothic; Mallanna = Mallanna, sans-serif; Mandali = Mandali, sans-serif; Mangal = Mangal; Manny ITC = Manny ITC; Manuale = Manuale, serif; Marcellus = Marcellus, serif; Marcellus SC = Marcellus SC, serif; Marck Script = Marck Script, cursive; Margarine = Margarine, cursive; Marko One = Marko One, serif; Marlett = Marlett; Marmelad = Marmelad, sans-serif; Martel = Martel, serif; Martel Sans = Martel Sans, sans-serif; Marvel = Marvel, sans-serif; Mate = Mate, serif; Mate SC = Mate SC, serif; Maven Pro = Maven Pro, sans-serif; McLaren = McLaren, cursive; Meddon = Meddon, cursive; MedievalSharp = MedievalSharp, cursive; Medula One = Medula One, cursive; Meera Inimai = Meera Inimai, sans-serif; Megrim = Megrim, cursive; Meie Script = Meie Script, cursive; Meiryo = Meiryo; Meiryo UI = Meiryo UI; Merienda = Merienda, cursive; Merienda One = Merienda One, cursive; Merriweather = Merriweather, serif; Merriweather Sans = Merriweather Sans, sans-serif; Metal = Metal, cursive; Metal Mania = Metal Mania, cursive; Metamorphous = Metamorphous, cursive; Metrophobic = Metrophobic, sans-serif; Michroma = Michroma, sans-serif; Microsoft Himalaya = Microsoft Himalaya; Microsoft JhengHei = Microsoft JhengHei; Microsoft JhengHei UI = Microsoft JhengHei UI; Microsoft New Tai Lue = Microsoft New Tai Lue; Microsoft PhagsPa = Microsoft PhagsPa; Microsoft Sans Serif = Microsoft Sans Serif; Microsoft Tai Le = Microsoft Tai Le; Microsoft Uighur = Microsoft Uighur; Microsoft YaHei = Microsoft YaHei; Microsoft YaHei UI = Microsoft YaHei UI; Microsoft Yi Baiti = Microsoft Yi Baiti; Milonga = Milonga, cursive; Miltonian = Miltonian, cursive; Miltonian Tattoo = Miltonian Tattoo, cursive; Mina = Mina, sans-serif; MingLiU_HKSCS = MingLiU_HKSCS; MingLiU_HKSCS-ExtB = MingLiU_HKSCS-ExtB; Miniver = Miniver, cursive; Miriam = Miriam; Miriam Libre = Miriam Libre, sans-serif; Mirza = Mirza, cursive; Miss Fajardose = Miss Fajardose, cursive; Mitr = Mitr, sans-serif; Modak = Modak, cursive; Modern Antiqua = Modern Antiqua, cursive; Mogra = Mogra, cursive; Molengo = Molengo, sans-serif; Molle = Molle, cursive; Monda = Monda, sans-serif; Mongolian Baiti = Mongolian Baiti; Monofett = Monofett, cursive; Monoton = Monoton, cursive; Monsieur La Doulaise = Monsieur La Doulaise, cursive; Montaga = Montaga, serif; Montez = Montez, cursive; Montserrat = Montserrat, sans-serif; Montserrat Alternates = Montserrat Alternates, sans-serif; Montserrat Subrayada = Montserrat Subrayada, sans-serif; MoolBoran = MoolBoran; Moul = Moul, cursive; Moulpali = Moulpali, cursive; Mountains of Christmas = Mountains of Christmas, cursive; Mouse Memoirs = Mouse Memoirs, sans-serif; Mr Bedfort = Mr Bedfort, cursive; Mr Dafoe = Mr Dafoe, cursive; Mr De Haviland = Mr De Haviland, cursive; Mrs Saint Delafield = Mrs Saint Delafield, cursive; Mrs Sheppards = Mrs Sheppards, cursive; MS UI Gothic = MS UI Gothic; Mukta = Mukta, sans-serif; Muli = Muli, sans-serif; MV Boli = MV Boli; Myanmar Text = Myanmar Text; Mystery Quest = Mystery Quest, cursive; Nanum Brush Script = Nanum Brush Script, cursive; Nanum Gothic = Nanum Gothic, sans-serif; Nanum Gothic Coding = Nanum Gothic Coding, monospace; Nanum Myeongjo = Nanum Myeongjo, serif; Nanum Pen Script = Nanum Pen Script, cursive; Narkisim = Narkisim; Neucha = Neucha, cursive; Neuton = Neuton, serif; New Rocker = New Rocker, cursive; News Cycle = News Cycle, sans-serif; News Gothic MT = News Gothic MT; Niconne = Niconne, cursive; Nirmala UI = Nirmala UI; Nixie One = Nixie One, cursive; Nobile = Nobile, sans-serif; Nokora = Nokora, serif; Norican = Norican, cursive; Nosifer = Nosifer, cursive; Nothing You Could Do = Nothing You Could Do, cursive; Noticia Text = Noticia Text, serif; Noto Sans = Noto Sans, sans-serif; Noto Serif = Noto Serif, serif; Nova Cut = Nova Cut, cursive; Nova Flat = Nova Flat, cursive; Nova Mono = Nova Mono, monospace; Nova Oval = Nova Oval, cursive; Nova Round = Nova Round, cursive; Nova Script = Nova Script, cursive; Nova Slim = Nova Slim, cursive; Nova Square = Nova Square, cursive; NSimSun = NSimSun; NTR = NTR, sans-serif; Numans = Numans, sans-serif; Nunito = Nunito, sans-serif; Nunito Sans = Nunito Sans, sans-serif; Nyala = Nyala; Odor Mean Chey = Odor Mean Chey, cursive; Offside = Offside, cursive; Old Standard TT = Old Standard TT, serif; Oldenburg = Oldenburg, cursive; Oleo Script = Oleo Script, cursive; Oleo Script Swash Caps = Oleo Script Swash Caps, cursive; Open Sans = Open Sans, sans-serif; Open Sans Condensed = Open Sans Condensed, sans-serif; Oranienbaum = Oranienbaum, serif; Orbitron = Orbitron, sans-serif; Oregano = Oregano, cursive; Orienta = Orienta, sans-serif; Original Surfer = Original Surfer, cursive; Oswald = Oswald, sans-serif; Over the Rainbow = Over the Rainbow, cursive; Overlock = Overlock, cursive; Overlock SC = Overlock SC, cursive; Overpass = Overpass, sans-serif; Overpass Mono = Overpass Mono, monospace; Ovo = Ovo, serif; Oxygen = Oxygen, sans-serif; Oxygen Mono = Oxygen Mono, monospace; Pacifico = Pacifico, cursive; Padauk = Padauk, sans-serif; Palanquin = Palanquin, sans-serif; Palanquin Dark = Palanquin Dark, sans-serif; Palatino Linotype = Palatino Linotype; Pangolin = Pangolin, cursive; Paprika = Paprika, cursive; Parisienne = Parisienne, cursive; Passero One = Passero One, cursive; Passion One = Passion One, cursive; Pathway Gothic One = Pathway Gothic One, sans-serif; Patrick Hand = Patrick Hand, cursive; Patrick Hand SC = Patrick Hand SC, cursive; Pattaya = Pattaya, sans-serif; Patua One = Patua One, cursive; Pavanam = Pavanam, sans-serif; Paytone One = Paytone One, sans-serif; Peddana = Peddana, serif; Peralta = Peralta, cursive; Permanent Marker = Permanent Marker, cursive; Petit Formal Script = Petit Formal Script, cursive; Petrona = Petrona, serif; Philosopher = Philosopher, sans-serif; Piedra = Piedra, cursive; Pinyon Script = Pinyon Script, cursive; Pirata One = Pirata One, cursive; Plantagenet Cherokee = Plantagenet Cherokee; Plaster = Plaster, cursive; Play = Play, sans-serif; Playball = Playball, cursive; Playfair Display = Playfair Display, serif; Playfair Display SC = Playfair Display SC, serif; Podkova = Podkova, serif; Poiret One = Poiret One, cursive; Poller One = Poller One, cursive; Poly = Poly, serif; Pompiere = Pompiere, cursive; Pontano Sans = Pontano Sans, sans-serif; Poor Story = Poor Story, cursive; Poppins = Poppins, sans-serif; Port Lligat Sans = Port Lligat Sans, sans-serif; Port Lligat Slab = Port Lligat Slab, serif; Pragati Narrow = Pragati Narrow, sans-serif; Prata = Prata, serif; Preahvihear = Preahvihear, cursive; Pridi = Pridi, serif; Princess Sofia = Princess Sofia, cursive; Prociono = Prociono, serif; Prompt = Prompt, sans-serif; Prosto One = Prosto One, cursive; Proza Libre = Proza Libre, sans-serif; PT Mono = PT Mono, monospace; PT Sans = PT Sans, sans-serif; PT Sans Caption = PT Sans Caption, sans-serif; PT Sans Narrow = PT Sans Narrow, sans-serif; PT Serif = PT Serif, serif; PT Serif Caption = PT Serif Caption, serif; Puritan = Puritan, sans-serif; Purple Purse = Purple Purse, cursive; Quando = Quando, serif; Quantico = Quantico, sans-serif; Quattrocento = Quattrocento, serif; Quattrocento Sans = Quattrocento Sans, sans-serif; Questrial = Questrial, sans-serif; Quicksand = Quicksand, sans-serif; Quintessential = Quintessential, cursive; Qwigley = Qwigley, cursive; Raavi = Raavi; Racing Sans One = Racing Sans One, cursive; Radley = Radley, serif; Rajdhani = Rajdhani, sans-serif; Rakkas = Rakkas, cursive; Raleway = Raleway, sans-serif; Raleway Dots = Raleway Dots, cursive; Ramabhadra = Ramabhadra, sans-serif; Ramaraja = Ramaraja, serif; Rambla = Rambla, sans-serif; Rammetto One = Rammetto One, cursive; Ranchers = Ranchers, cursive; Rancho = Rancho, cursive; Ranga = Ranga, cursive; Rasa = Rasa, serif; Rationale = Rationale, sans-serif; Ravi Prakash = Ravi Prakash, cursive; Redressed = Redressed, cursive; Reem Kufi = Reem Kufi, sans-serif; Reenie Beanie = Reenie Beanie, cursive; Revalia = Revalia, cursive; Rhodium Libre = Rhodium Libre, serif; Ribeye = Ribeye, cursive; Ribeye Marrow = Ribeye Marrow, cursive; Righteous = Righteous, cursive; Risque = Risque, cursive; Roboto = Roboto, sans-serif; Roboto Condensed = Roboto Condensed, sans-serif; Roboto Mono = Roboto Mono, monospace; Roboto Slab = Roboto Slab, serif; Rochester = Rochester, cursive; Rock Salt = Rock Salt, cursive; Rod = Rod; Rokkitt = Rokkitt, serif; Romanesco = Romanesco, cursive; Ropa Sans = Ropa Sans, sans-serif; Rosario = Rosario, sans-serif; Rosarivo = Rosarivo, serif; Rouge Script = Rouge Script, cursive; Rozha One = Rozha One, serif; Rubik = Rubik, sans-serif; Rubik Mono One = Rubik Mono One, sans-serif; Ruda = Ruda, sans-serif; Rufina = Rufina, serif; Ruge Boogie = Ruge Boogie, cursive; Ruluko = Ruluko, sans-serif; Rum Raisin = Rum Raisin, sans-serif; Ruslan Display = Ruslan Display, cursive; Russo One = Russo One, sans-serif; Ruthie = Ruthie, cursive; Rye = Rye, cursive; Sacramento = Sacramento, cursive; Sahitya = Sahitya, serif; Sail = Sail, cursive; Saira = Saira, sans-serif; Saira Condensed = Saira Condensed, sans-serif; Saira Extra Condensed = Saira Extra Condensed, sans-serif; Saira Semi Condensed = Saira Semi Condensed, sans-serif; Sakkal Majalla = Sakkal Majalla; Salsa = Salsa, cursive; Sanchez = Sanchez, serif; Sancreek = Sancreek, cursive; Sansita = Sansita, sans-serif; Sarala = Sarala, sans-serif; Sarina = Sarina, cursive; Sarpanch = Sarpanch, sans-serif; Satisfy = Satisfy, cursive; Scada = Scada, sans-serif; Scheherazade = Scheherazade, serif; Schoolbell = Schoolbell, cursive; Scope One = Scope One, serif; Seaweed Script = Seaweed Script, cursive; Secular One = Secular One, sans-serif; Sedgwick Ave = Sedgwick Ave, cursive; Sedgwick Ave Display = Sedgwick Ave Display, cursive; Segoe Print = Segoe Print; Segoe Script = Segoe Script; Segoe UI Symbol = Segoe UI Symbol; Sevillana = Sevillana, cursive; Seymour One = Seymour One, sans-serif; Shadows Into Light = Shadows Into Light, cursive; Shadows Into Light Two = Shadows Into Light Two, cursive; Shanti = Shanti, sans-serif; Share = Share, cursive; Share Tech = Share Tech, sans-serif; Share Tech Mono = Share Tech Mono, monospace; Shojumaru = Shojumaru, cursive; Shonar Bangla = Shonar Bangla; Short Stack = Short Stack, cursive; Shrikhand = Shrikhand, cursive; Shruti = Shruti; Siemreap = Siemreap, cursive; Sigmar One = Sigmar One, cursive; Signika = Signika, sans-serif; Signika Negative = Signika Negative, sans-serif; SimHei = SimHei; SimKai = SimKai; Simonetta = Simonetta, cursive; Simplified Arabic = Simplified Arabic; SimSun = SimSun; SimSun-ExtB = SimSun-ExtB; Sintony = Sintony, sans-serif; Sirin Stencil = Sirin Stencil, cursive; Six Caps = Six Caps, sans-serif; Skranji = Skranji, cursive; Slackey = Slackey, cursive; Smokum = Smokum, cursive; Smythe = Smythe, cursive; Sniglet = Sniglet, cursive; Snippet = Snippet, sans-serif; Snowburst One = Snowburst One, cursive; Sofadi One = Sofadi One, cursive; Sofia = Sofia, cursive; Song Myung = Song Myung, serif; Sonsie One = Sonsie One, cursive; Sorts Mill Goudy = Sorts Mill Goudy, serif; Source Code Pro = Source Code Pro, monospace; Source Sans Pro = Source Sans Pro, sans-serif; Source Serif Pro = Source Serif Pro, serif; Space Mono = Space Mono, monospace; Special Elite = Special Elite, cursive; Spectral = Spectral, serif; Spectral SC = Spectral SC, serif; Spicy Rice = Spicy Rice, cursive; Spinnaker = Spinnaker, sans-serif; Spirax = Spirax, cursive; Squada One = Squada One, cursive; Sree Krushnadevaraya = Sree Krushnadevaraya, serif; Sriracha = Sriracha, cursive; Stalemate = Stalemate, cursive; Stalinist One = Stalinist One, cursive; Stardos Stencil = Stardos Stencil, cursive; Stint Ultra Condensed = Stint Ultra Condensed, cursive; Stint Ultra Expanded = Stint Ultra Expanded, cursive; Stoke = Stoke, serif; Strait = Strait, sans-serif; Stylish = Stylish, sans-serif; Sue Ellen Francisco = Sue Ellen Francisco, cursive; Suez One = Suez One, serif; Sumana = Sumana, serif; Sunflower = Sunflower, sans-serif; Sunshiney = Sunshiney, cursive; Supermercado One = Supermercado One, cursive; Sura = Sura, serif; Suranna = Suranna, serif; Suravaram = Suravaram, serif; Suwannaphum = Suwannaphum, cursive; Swanky and Moo Moo = Swanky and Moo Moo, cursive; Sylfaen = Sylfaen; Syncopate = Syncopate, sans-serif; Tahoma = Tahoma; Tajawal = Tajawal, sans-serif; Tangerine = Tangerine, cursive; Taprom = Taprom, cursive; Tauri = Tauri, sans-serif; Taviraj = Taviraj, serif; Teko = Teko, sans-serif; Telex = Telex, sans-serif; Tenali Ramakrishna = Tenali Ramakrishna, sans-serif; Tenor Sans = Tenor Sans, sans-serif; Text Me One = Text Me One, sans-serif; The Girl Next Door = The Girl Next Door, cursive; Tienne = Tienne, serif; Tillana = Tillana, cursive; Times New Roman = Times New Roman; Timmana = Timmana, sans-serif; Tinos = Tinos, serif; Titan One = Titan One, cursive; Titillium Web = Titillium Web, sans-serif; Trade Winds = Trade Winds, cursive; Traditional Arabic = Traditional Arabic; Trebuchet MS = Trebuchet MS; Trirong = Trirong, serif; Trocchi = Trocchi, serif; Trochut = Trochut, cursive; Trykker = Trykker, serif; Tulpen One = Tulpen One, cursive; Tunga = Tunga; Ubuntu = Ubuntu, sans-serif; Ubuntu Condensed = Ubuntu Condensed, sans-serif; Ubuntu Mono = Ubuntu Mono, monospace; Ultra = Ultra, serif; Uncial Antiqua = Uncial Antiqua, cursive; Underdog = Underdog, cursive; Unica One = Unica One, cursive; UnifrakturCook = UnifrakturCook, cursive; UnifrakturMaguntia = UnifrakturMaguntia, cursive; Unkempt = Unkempt, cursive; Unlock = Unlock, cursive; Unna = Unna, serif; Utsaah = Utsaah; Vampiro One = Vampiro One, cursive; Vani = Vani; Varela = Varela, sans-serif; Varela Round = Varela Round, sans-serif; Vast Shadow = Vast Shadow, cursive; Vesper Libre = Vesper Libre, serif; Vibur = Vibur, cursive; Vidaloka = Vidaloka, serif; Viga = Viga, sans-serif; Vijaya = Vijaya; Voces = Voces, cursive; Volkhov = Volkhov, serif; Vollkorn = Vollkorn, serif; Vollkorn SC = Vollkorn SC, serif; Voltaire = Voltaire, sans-serif; VT323 = VT323, monospace; Waiting for the Sunrise = Waiting for the Sunrise, cursive; Wallpoet = Wallpoet, cursive; Walter Turncoat = Walter Turncoat, cursive; Warnes = Warnes, cursive; Wellfleet = Wellfleet, cursive; Wendy One = Wendy One, sans-serif; Wire One = Wire One, sans-serif; Work Sans = Work Sans, sans-serif; Yanone Kaffeesatz = Yanone Kaffeesatz, sans-serif; Yantramanav = Yantramanav, sans-serif; Yatra One = Yatra One, cursive; Yellowtail = Yellowtail, cursive; Yeon Sung = Yeon Sung, cursive; Yeseva One = Yeseva One, cursive; Yesteryear = Yesteryear, cursive; Yrsa = Yrsa, serif; Zeyada = Zeyada, cursive; Zilla Slab = Zilla Slab, serif; Zilla Slab Highlight = Zilla Slab Highlight, cursive'
	});
}
function Total_Soft_Cal_Desc_1()
{
	jQuery('#TotalSoftCal_EvDesc_1').val(tinyMCE.get('TotalSoftCal_EvDesc').getContent());
}
function TotalSoftCal_EventSort()
{
	jQuery('.Total_Soft_AMOTable1 tbody').sortable({
		update: function( event, ui ){ 
			jQuery(this).find('tr').each(function(i){
				jQuery(this).find('td:nth-child(1)').html((i+1));
				jQuery(this).find('td:nth-child(5)').find('input[type=text]').attr('name', 'TSoft_Cal_Move_ID_'+(i+1));
				TotalSoftCal_EventSort1();
			});
		}
	})
}
function TotalSoftCal_EventSort1()
{
	jQuery('.Total_Soft_Cal_AMD2_But1').css('opacity','1');
}
function Total_Soft_CalEv_AMD2_But3()
{
	jQuery('.Total_Soft_Cal_AMD2_But1').css('opacity','0');
}