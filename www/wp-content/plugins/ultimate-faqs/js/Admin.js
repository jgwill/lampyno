/* Used to show and hide the admin tabs for UPCP */
function ShowTab(TabName) {
		jQuery(".OptionTab").each(function() {
				jQuery(this).addClass("HiddenTab");
				jQuery(this).removeClass("ActiveTab");
		});
		jQuery("#"+TabName).removeClass("HiddenTab");
		jQuery("#"+TabName).addClass("ActiveTab");
		
		jQuery(".nav-tab").each(function() {
				jQuery(this).removeClass("nav-tab-active");
		});
		jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

jQuery(document).ready(function() {
	jQuery('.ewd-ufaq-review-ask-overlay, .ewd-ufaq-review-ask-popup').removeClass('ufaq-hidden');
});
/* This code is required to make changing the FAQ order a drag-and-drop affair */
jQuery(document).ready(function() {
	jQuery('.ewd-ufaq-list').sortable({
		items: '.ewd-ufaq-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
				var order = jQuery(this).sortable('serialize') + '&action=UFAQ_update_order';
				jQuery.post(ajaxurl, order, function(response) {});
		}
	});
});

/* This code is required to make changing the FAQ order a drag-and-drop affair */
jQuery(document).ready(function() {
	jQuery('.ewd-ufaq-elements-table').sortable({
		items: '.ewd-ufaq-element',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			jQuery('.ewd-ufaq-element td').each(function(index, el) {
				var Element_Name = jQuery(this).find('.ewd-ufaq-element-name').html();
				jQuery(this).find('input').val(Element_Name).attr('name', 'Element_' + index);
			});
		}
	});
});

function ShowOptionTab(TabName) {
	jQuery(".ufaq-option-set").each(function() {
		jQuery(this).addClass("ufaq-hidden");
	});
	jQuery("#"+TabName).removeClass("ufaq-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".ufaq-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".ufaq-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
	jQuery('input[name="Display_Tab"]').val(TabName);
}

jQuery(document).ready(function() {
	SetCustomFieldDeleteHandlers();

	jQuery('.ewd-ufaq-add-custom-field').on('click', function(event) {
		var Counter = jQuery(this).data('nextid');
		var Max_ID = jQuery(this).data('maxid');

		var HTML = "<tr id='ewd-ufaq-custom-field-row-" + Counter + "'>";
		HTML += "<td><input type='hidden' name='Custom_Field_" + Counter + "_ID' value='" + Max_ID + "' /><a class='ewd-ufaq-delete-custom-field' data-fieldid='" + Counter + "'>Delete</a></td>";
		HTML += "<td><input type='text' name='Custom_Field_" + Counter + "_Name'></td>";
		HTML += "<td><select name='Custom_Field_" + Counter + "_Type'>";
		HTML += "<option value='text'>Text</option>";
		HTML += "<option value='textarea'>Text Area</option>";
		HTML += "<option value='select'>Select Box</option>";
		HTML += "<option value='radio'>Radio Buttons</option>";
		HTML += "<option value='checkbox'>Checkbox</option>";
		HTML += "<option value='file'>File</option>";
		HTML += "<option value='link'>Link</option>";
		HTML += "<option value='date'>Date</option>";
		HTML += "<option value='datetime'>Date/Time</option>";
		HTML += "</select></td>";
		HTML += "<td><input type='text' name='Custom_Field_" + Counter + "_Values'></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#ewd-ufaq-custom-fields-table tr:last').before(HTML);

		Counter++;
		Max_ID++;
		jQuery(this).data('nextid', Counter); //updates but doesn't show in DOM
		jQuery(this).data('maxid', Max_ID);

		SetCustomFieldDeleteHandlers();

		event.preventDefault();
	});
});

function SetCustomFieldDeleteHandlers() {
	jQuery('.ewd-ufaq-delete-custom-field').on('click', function(event) {
		var ID = jQuery(this).data('fieldid');
		var tr = jQuery('#ewd-ufaq-custom-field-row-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}

jQuery(document).ready(function() {
    jQuery('.ewd-ufaq-hide-review-ask').on('click', function() {
        var Ask_Review_Date = jQuery(this).data('askreviewdelay');

        jQuery('.ewd-ufaq-review-ask-popup, #ewd-ufaq-review-ask-overlay').addClass('ufaq-hidden');

        var data = 'Ask_Review_Date=' + Ask_Review_Date + '&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
    });
    jQuery('#ewd-ufaq-review-ask-overlay').on('click', function() {
    	jQuery('.ewd-ufaq-review-ask-popup, #ewd-ufaq-review-ask-overlay').addClass('ufaq-hidden');
    })
});

jQuery(document).ready(function() {
	jQuery('.ewd-ufaq-spectrum').spectrum({
		showInput: true,
		showInitial: true,
		preferredFormat: "hex",
		allowEmpty: true
	});

	jQuery('.ewd-ufaq-spectrum').css('display', 'inline');

	jQuery('.ewd-ufaq-spectrum').on('change', function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UFAQ_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
		else {
			jQuery(this).css('background', 'none');
		}
	});

	jQuery('.ewd-ufaq-spectrum').each(function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UFAQ_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
	});
});

function EWD_UFAQ_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-ufaq-dash-mobile-menu-open').click(function(){
		$('.EWD_UFAQ_Menu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-ufaq-dash-mobile-menu-up-caret').toggle();
		$('#ewd-ufaq-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 800){
				$('.EWD_UFAQ_Menu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.EWD_UFAQ_Menu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-ufaq-dash-mobile-menu-up-caret').hide();
				$('#ewd-ufaq-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-ufaq-dashboard-support-widget-box .ewd-ufaq-dashboard-new-widget-box-top').click(function(){
		$('#ewd-ufaq-dashboard-support-widget-box .ewd-ufaq-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-ufaq-dash-mobile-support-up-caret').toggle();
		$('#ewd-ufaq-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-ufaq-dashboard-optional-table .ewd-ufaq-dashboard-new-widget-box-top').click(function(){
		$('#ewd-ufaq-dashboard-optional-table .ewd-ufaq-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-ufaq-dash-optional-table-up-caret').toggle();
		$('#ewd-ufaq-dash-optional-table-down-caret').toggle();
	});
});

//OPTIONS HELP/DESCRIPTION TEXT
jQuery(document).ready(function($) {
	$('.ufaq-option-set .form-table tr').each(function(){
		var thisOptionClick = $(this);
		thisOptionClick.find('th').click(function(){
			thisOptionClick.find('td p').toggle();
		});
	});
	$('.ewdOptionHasInfo').each(function(){
		var thisNonTableOptionClick = $(this);
		thisNonTableOptionClick.find('.ewd-ufaq-admin-styling-subsection-label').click(function(){
			thisNonTableOptionClick.find('fieldset p').toggle();
		});
	});
	$(function(){
		$(window).resize(function(){
			$('.ufaq-option-set .form-table tr').each(function(){
				var thisOption = $(this);
				if( $(window).width() < 783 ){
					if( thisOption.find('.ewd-ufaq-admin-hide-radios').length > 0 ) {
						thisOption.find('td p').show();			
						thisOption.find('th').css('background-image', 'none');			
						thisOption.find('th').css('cursor', 'default');			
					}
					else{
						thisOption.find('td p').hide();
						thisOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-faqs/images/options-asset-info.png)');			
						thisOption.find('th').css('background-position', '95% 20px');			
						thisOption.find('th').css('background-size', '18px 18px');			
						thisOption.find('th').css('background-repeat', 'no-repeat');			
						thisOption.find('th').css('cursor', 'pointer');								
					}		
				}
				else{
					thisOption.find('td p').hide();
					thisOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-faqs/images/options-asset-info.png)');			
					thisOption.find('th').css('background-position', 'calc(100% - 20px) 15px');			
					thisOption.find('th').css('background-size', '18px 18px');			
					thisOption.find('th').css('background-repeat', 'no-repeat');			
					thisOption.find('th').css('cursor', 'pointer');			
				}
			});
			$('.ewdOptionHasInfo').each(function(){
				var thisNonTableOption = $(this);
				if( $(window).width() < 783 ){
					if( thisNonTableOption.find('.ewd-ufaq-admin-hide-radios').length > 0 ) {
						thisNonTableOption.find('fieldset p').show();			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-image', 'none');			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('cursor', 'default');			
					}
					else{
						thisNonTableOption.find('fieldset p').hide();
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/ultimate-faqs/images/options-asset-info.png)');			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-size', '18px 18px');			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
						thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('cursor', 'pointer');								
					}		
				}
				else{
					thisNonTableOption.find('fieldset p').hide();
					thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/ultimate-faqs/images/options-asset-info.png)');			
					thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
					thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-size', '18px 18px');			
					thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
					thisNonTableOption.find('ewd-ufaq-admin-styling-subsection-label').css('cursor', 'pointer');			
				}
			});
		}).resize();
	});	
});


//OPTIONS PAGE YES/NO TOGGLE SWITCHES
jQuery(document).ready(function($) {
	jQuery('.ewd-ufaq-admin-option-toggle').on('change', function() {
		var Input_Name = jQuery(this).data('inputname'); console.log(Input_Name);
		if (jQuery(this).is(':checked')) {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', false);
		}
		else {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', true);
		}
	});
	$(function(){
		$(window).resize(function(){
			$('.ufaq-option-set .form-table tr').each(function(){
				var thisOptionTr = $(this);
				if( $(window).width() < 783 ){
					if( thisOptionTr.find('.ewd-ufaq-admin-switch').length > 0 ) {
						thisOptionTr.find('th').css('width', 'calc(90% - 50px');			
						thisOptionTr.find('th').css('padding-right', 'calc(5% + 50px');			
					}
					else{
						thisOptionTr.find('th').css('width', '90%');			
						thisOptionTr.find('th').css('padding-right', '5%');			
					}		
				}
				else{
					thisOptionTr.find('th').css('width', '200px');			
					thisOptionTr.find('th').css('padding-right', '46px');			
				}
			});
		}).resize();
	});	
});
