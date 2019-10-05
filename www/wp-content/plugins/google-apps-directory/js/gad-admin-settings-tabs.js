
// Do tabs

jQuery(document).ready(function() {
	
	function gadSetActionToTab(id) {
		var frm = jQuery('#gad_form');
		frm.attr('action', frm.attr('action').replace(/(#.+)?$/, '#'+id) );
	}

	jQuery('#gad-tabs').find('a').click(function() {
			jQuery('#gad-tabs').find('a').removeClass('nav-tab-active');
			jQuery('.gadtab').removeClass('active');
			var id = jQuery(this).attr('id').replace('-tab','');
			jQuery('#' + id + '-section').addClass('active');
			jQuery(this).addClass('nav-tab-active');
			
			// Set submit URL to this tab
			gadSetActionToTab(id);
	});
	
	// Did page load with a tab active?
	var active_tab = window.location.hash.replace('#','');
	if (active_tab == '') {
		var alltabs = jQuery('#gad-tabs a');
		if (alltabs.length == 0) {
			return;
		}
		active_tab = alltabs.first().attr('id').replace('-tab','');
	}
	var activeSection = jQuery('#' + active_tab + '-section');
	var activeTab = jQuery('#' + active_tab + '-tab');

	if (activeSection && activeTab) {
		jQuery('#gad-tabs').find('a').removeClass('nav-tab-active');
		jQuery('.gadtab').removeClass('active');

		activeSection.addClass('active');
		activeTab.addClass('nav-tab-active');
		gadSetActionToTab(active_tab);
	}

	// Hide gadunitpaths text area unless 'restrict' is checked
	clickfn = function() {
        if (jQuery('#gad_restrict_orgunitpath').is(':checked')) {
            jQuery('#gad_allowed_orgunitpaths').show();
        }
        else {
            jQuery('#gad_allowed_orgunitpaths').hide();
        }
	};
	jQuery('#gad_restrict_orgunitpath').on('click', clickfn);
	clickfn();
});