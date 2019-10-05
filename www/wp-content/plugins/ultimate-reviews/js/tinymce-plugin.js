(function() {
    tinymce.PluginManager.add('URP_Shortcodes', function( editor, url ) {
        //editor.on('init', function(args){EWD_UFAQ_Disable_Non_Premium();});
        editor.addButton( 'URP_Shortcodes', {
            title: 'URP Shortcodes',
            text: 'Reviews',
            type: 'menubutton',
            icon: 'wp_code',
            menu: [{
            	text: 'Display Reviews',
            	value: 'ultimate-reviews',
            	onclick: function() {
				    var win = editor.windowManager.open( {
				        title: 'Insert Ultimate Reviews Shortcode',
				        body: [{
            				type: 'listbox',
            				name: 'post_count',
            				label: '# of Reviews:',
				            'values': [
            				    {text: 'All', value: '-1'},
            				    {text: '1', value: '1'},
            				    {text: '2', value: '2'},
            				    {text: '3', value: '3'},
            				    {text: '4', value: '4'},
            				    {text: '5', value: '5'}
            				]
				        },
				        {
            				type: 'listbox',
            				name: 'product_name',
            				label: 'Reviews for Product:',
				            'values': EWD_URP_Create_Product_List('All')
				        }],
				        onsubmit: function( e ) {
				            if (e.data.post_count != -1) {var post_text = "post_count='" + e.data.post_count + "'";}
				            else {var post_text = "";}
				            if (e.data.product_name != -1) {var inc_prod_text = "product_name='" + e.data.product_name + "'";}
				            else {var inc_prod_text = "";}

				            editor.insertContent( '[ultimate-reviews '+post_text+' '+inc_prod_text+']');
				        }
				    });
				}
			},
			{
            	text: 'Search Reviews',
            	onPostRender: function() {EWD_URP_Search_Non_Premium();},
            	value: 'ultimate-review-search',
            	id: 'review-search',
            	onclick: function() {
				    var premium = EWD_URP_Is_Premium();
				    if (!premium) {return;}

				    var win = editor.windowManager.open( {
				        title: 'Insert Ultimate Reviews Shortcode',
				        body: [{
            				type: 'listbox',
            				name: 'product_name',
            				label: 'Reviews for Product:',
				            'values': EWD_URP_Create_Product_List('All')
				        },
				        {
            				type: 'checkbox',
            				name: 'show_on_load',
            				label: 'Show all reviews on pageload:'
				        }],
				        onsubmit: function( e ) {
				            if (e.data.product_name != -1) {var inc_prod_text = "product_name='" + e.data.product_name + "'";}
				            else {var inc_prod_text = "";}
				            if (e.data.show_on_load) {var show_on_load_text = "show_on_load='Yes'";}
				            else {var show_on_load_text = "";}

				            editor.insertContent( '[ultimate-review-search '+inc_prod_text+' '+show_on_load_text+']');
				        }
				    });
				}
			},
			{
            	text: 'Submit Review',
            	value: 'submit-review',
            	onclick: function() {
				    var win = editor.windowManager.open( {
				        title: 'Insert Ultimate Reviews Shortcode',
				        body: [{
            				type: 'listbox',
            				name: 'product_name',
            				label: 'Reviews for Product:',
				            'values': EWD_URP_Create_Product_List('All')
				        }],
            			onsubmit: function( e ) {
            				if (e.data.product_name != -1) {var inc_prod_text = "product_name='" + e.data.product_name + "'";}
				            else {var inc_prod_text = "";}

				    		editor.insertContent( '[submit-review '+inc_prod_text+']');
				    	}
					});
				}
			}],
        });
    });
})();


function EWD_URP_Create_Product_List(initial) {
	if (initial == "All") {var result = [{text: 'All', value: '-1'}];}
	else {var result = [{text: 'None', value: '-1'}];}
    var d = {};

	jQuery(urp_products).each(function(index, el) {
		var d = {};
		d['text'] = el;
		d['value'] = el;
		result.push(d)
	});

    return result;
}

function EWD_URP_Search_Non_Premium() {
	var premium = EWD_URP_Is_Premium();

	if (!premium) {
		jQuery('#review-search').css('opacity', '0.5');
		jQuery('#review-search').css('cursor', 'default');
	}
}

function EWD_URP_Is_Premium() {
	if (urp_premium == "Yes") {return true;}
	
	return false;
}
