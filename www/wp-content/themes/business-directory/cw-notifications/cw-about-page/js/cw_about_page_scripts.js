/**
 * Main scripts file for the About business-directory Page
 *
 * @package business-directory
 */

/* global cwAboutPageObject */
/* global console */

jQuery( document ).ready(
	function () {

		/* If there are required actions, add an icon with the number of required actions in the About cw-about-page page -> Actions required tab */
		var ti_about_page_nr_actions_required = cwAboutPageObject.nr_actions_required;

		if ( (typeof ti_about_page_nr_actions_required !== 'undefined') && (ti_about_page_nr_actions_required !== '0') ) {
			jQuery( 'li.cw-about-page-w-red-tab a' ).append( '<span class="cw-about-page-actions-count">' + ti_about_page_nr_actions_required + '</span>' );
		}

		/* Dismiss required actions */
		jQuery( '.cw-about-page-required-action-button' ).click(
			function() {

				var id = jQuery( this ).attr( 'id' ),
				action = jQuery( this ).attr( 'data-action' );

				jQuery.ajax(
					{
						type      : 'GET',
						data      : { action: 'cw_about_page_dismiss_required_action', id: id, todo: action },
						dataType  : 'html',
						url       : cwAboutPageObject.ajaxurl,
						beforeSend: function () {
							jQuery( '.cw-about-page-tab-pane#actions_required h1' ).append( '<div id="temp_load" style="text-align:center"><img src="' + cwAboutPageObject.template_directory + '/cw-notifications/cw-about-page/images/ajax-loader.gif" /></div>' );
						},
						success   : function () {
							location.reload();
							jQuery( '#temp_load' ).remove();
							/* Remove loading gif */
						},
						error     : function (jqXHR, textStatus, errorThrown) {
							console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
						}
					}
				);
			}
		);
		// Remove activate button and replace with activation in progress button.
		jQuery( document ).on(
			'DOMNodeInserted','.activate-now', function () {
				var activateButton = jQuery( this );
				if (activateButton.length) {
					var url = jQuery( activateButton ).attr( 'href' );
					if (typeof url !== 'undefined') {
						// Request plugin activation.
						jQuery.ajax(
							{
								beforeSend: function () {
									jQuery( activateButton ).replaceWith( '<a class="button updating-message">' + cwAboutPageObject.activating_string + '...</a>' );
								},
								async: true,
								type: 'GET',
								url: url,
								success: function () {
									// Reload the page.
									location.reload();
								}
							}
						);
					}
				}
			}
		);
	}
);
