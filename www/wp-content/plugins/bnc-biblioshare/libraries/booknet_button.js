//this file defines the HTML form and handles the form submit for the visual editor button

//ajax handler calls server side BookNet preview method
function booknet_button_preview(booknumber, templatenumber, publisherurl) {

	var data = {
		action: 'my_special_action',
		booknumber: booknumber,
		templatenumber: templatenumber,
		publisherurl: publisherurl,
	};

	document.getElementById('booknet-response').innerHTML = "... please wait ...";

	//ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: data,
		success: function(response) { document.getElementById('booknet-response').innerHTML = response; },
		async: false,
		cache: false
	}); 
}

function booknet_button_validations(booknumber, templatenumber, publisherurl) {

	if (booknumber == "") {
		alert("A Book Number is required");
		document.getElementById('booknet-booknumber').focus();
		return false;
	}

	return true;
}

// closure to avoid namespace collision
(function(){
	// creates the plugin
	  tinymce.PluginManager.add('booknet', function(controlManager, url) {
	//tinymce.create('tinymce.plugins.booknet', {
		// creates control instances based on the control's id.
		// our button's id is "booknet_button"
		//createControl : function(id, controlManager) {
			//if (id == 'booknet_button') {
				// creates the button
				var button = controlManager.addButton('booknet_button', {
					title : 'BookNet', // title of the button
					image : '../wp-content/plugins/bnc-biblioshare/libraries/bnc_button.jpg',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'BookNet', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=booknet-form' );
					}
				});
				return button;
//			}
//			return null;
//		}
	});
	
	// registers the plugin
//	tinymce.PluginManager.add('booknet', tinymce.plugins.booknet);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		var form = jQuery('<div id="booknet-form"><table id="booknet-table" class="form-table">\
			<tr><th width="30%">Book Number</th>\
				<td width="70%">\
					<input type="text" name="booknet-booknumber" id="booknet-booknumber" value="" />\
				<br /><small>Enter a valid ISBN.</small></td>\
			</tr>\
			<tr><th>Template Number</th>\
				<td><select name="booknet-templatenumber" id="booknet-templatenumber">\
					<option value="1">1</option>\
					<option value="2">2</option>\
					<option value="3">3</option>\
					<option value="4">4</option>\
					<option value="5">5</option>\
					</select>\
				<br /><small>Select a template number. Matches the template on the <a href="../wp-admin/options-general.php?page=booknet_options.php" target="_blank">BNC BiblioShare Settings</a> page.</small></td>\
			</tr>\
			<tr><th>Publisher URL</th>\
				<td><input type="text" name="booknet-publisherurl" id="booknet-publisherurl" value="" />\
				<br><small>Optional. If you enter a publisher URL it will be used in the publisher display element.</small></td>\
			</tr>\
			<tr><th>Shortcode or HTML</th>\
				<td><input type="radio" name="booknet-shortcode" id="booknet-shortcode" value="shortcode" checked />Shortcode\
					<input type="radio" name="booknet-shortcode" id="booknet-html" value="html" />HTML\
				<br /><small>The shortcode option inserts a tidy code in your post and makes a live call to BiblioShare. The HTML option inserts longer, formatted HTML in your post and loads faster for your readers.</small></td>\
			</tr>\
			</table>\
			<p class="submit"><input type="button" id="booknet-preview" value="Preview" name="booknet-preview" /> <input type="button" id="booknet-insert" value="Insert" name="booknet-insert" /> <input type="reset" id="booknet-reset" value="Reset" name="booknet-reset" /></p>\
			<span id="booknet-response"></span></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the preview button
		form.find('#booknet-preview').click(function(){
		
			var booknumber = document.getElementById('booknet-booknumber').value;
			var templatenumber = document.getElementById('booknet-templatenumber').value;
			var shortcodechecked = document.getElementById('booknet-shortcode').checked;
			var publisherurl = document.getElementById('booknet-publisherurl').value;
			
			if (booknet_button_validations(booknumber, templatenumber, publisherurl)) {
				booknet_button_preview(booknumber, templatenumber, publisherurl);
			}
		});
		
		// handles the click event of the insert button
		form.find('#booknet-insert').click(function(){
	
			var booknumber = document.getElementById('booknet-booknumber').value;
			var templatenumber = document.getElementById('booknet-templatenumber').value;
			var shortcodechecked = document.getElementById('booknet-shortcode').checked;
			var publisherurl = document.getElementById('booknet-publisherurl').value;
			
			if (booknet_button_validations(booknumber, templatenumber, publisherurl)) {
	
				var display = '';
				if (shortcodechecked == true) {

					var shortcode = '[booknet';
					shortcode += ' booknumber="' + booknumber + '"';
					shortcode += ' templatenumber="' + templatenumber + '"';
					if (publisherurl != '') shortcode += ' publisherurl="' + publisherurl + '"';
					shortcode += ']';	

					display = shortcode;
				}
				else {	
					if (document.getElementById('booknet-response').innerHTML=="") {
						booknet_button_preview(booknumber, templatenumber, publisherurl);	
					}
					display = document.getElementById('booknet-response').innerHTML;
				}

				tinyMCE.activeEditor.execCommand('mceInsertContent', 0, display);				
				tb_remove(); //closes form
			}
		});
		
		// handles the click event of the reset button
		form.find('#booknet-reset').click(function(){
			document.getElementById('booknet-booknumber').value="";
			document.getElementById('booknet-templatenumber').value="1";
			document.getElementById('booknet-booknumber').value="";
			document.getElementById('booknet-publisherurl').value="";
			document.getElementById('booknet-shortcode').checked=true;
			document.getElementById('booknet-response').innerHTML="";
		});
	});
})()
