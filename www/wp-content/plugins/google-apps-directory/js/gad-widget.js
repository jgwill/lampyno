
/*
 WIDGET!!
*/

jQuery(document).ready(function ($) {
	
	function displayResults(response, outputbox) {
		outputbox.empty();
		if (response.error) {
			var errp = $('<p></p>', {class: 'gad-error'});
			errp.append(document.createTextNode(response.error));
			outputbox.append(errp);
		}
		else {
			var outp = $('<div></div>', {class: 'gad-users'});
			if (response.users && response.users.length > 0) {
				
				// Any extra fields to display?
				var extraoutputfields = (typeof(gad_vars.extraoutputfields)=="string" ? gad_vars.extraoutputfields.split(",") : Array());
				
				for (var i=0; i < response.users.length ; ++i) {
					var thisdiv = $('<div></div>', {class: 'gad-user'});
					var imgdiv = $('<div></div>', {class: 'gad-user-imgdiv'});
					imgdiv.append($('<img></img>', {src: response.users[i].thumbnailPhotoUrl, class: 'gad-user-img'}));
					thisdiv.append(imgdiv);
					var textdiv = $('<div></div>', {class: 'gad-user-textinfo'});
					textdiv.append($('<div></div>', {class: 'gad-user-name'}).append(document.createTextNode(response.users[i].fullName)));
					textdiv.append($('<div></div>', {class: 'gad-user-email'}).append($('<a></a>',{href: 'mailto:'+response.users[i].primaryEmail})
																				.append(document.createTextNode(response.users[i].primaryEmail))));
					
					for (var j=0; j < extraoutputfields.length ; ++j) {
						var fieldname = extraoutputfields[j].trim();
						var outval = (response.users[i])[fieldname];
						if (outval) {
							textdiv.append($('<div>'+outval+'</div>', {class: 'gad-user-extrafield'}));
						}
					}
					
					thisdiv.append(textdiv);
					outp.append(thisdiv);
				}
				
			}
			else if (response == '0') {
				outp.append(document.createTextNode('You need to be logged in to search'));
			}
			else {
				outp.append(document.createTextNode('No matches found'));
			}
			outputbox.append(outp);
		}
	}
	
	$('.gad-widget-search-form').submit(function(e){
		var form = $(e.target);
		var searchtext = $(form.find('.gad-widget-search-box')).val();
		
		form.find(':input').attr('disabled', true);
		
		var data = {
				action: 'gad_directory_search',
				gad_nonce: gad_vars.nonce,
				gad_search: searchtext
		};
		
		var resultsbox = form.find('.gad-widget-results-box');
		resultsbox.empty();
		resultsbox.append($('<img></img>', {src: gad_vars.spinnerurl, class: 'gad-spinner-img'}));
		
		$.post(gad_vars.ajaxurl, data, function(response){
				displayResults(response, resultsbox);
			},
			'json'
		).fail(function(){
			displayResults({error: 'Error contacting the web server'}, resultsbox);
		}).always(function(){
			form.find(':input').removeAttr('disabled');
		});
		
		e.preventDefault();
	});
	
	$('.gad-widget-search-box').keydown(function(e){
		if (e.keyCode == 13) {
			$(e.target).closest('form').submit();
		}
	}); 

	
});



