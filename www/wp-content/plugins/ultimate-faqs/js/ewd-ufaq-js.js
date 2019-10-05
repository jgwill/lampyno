var filtering_running = 'No';

jQuery(function(){ //DOM Ready
    ufaqSetClickHandlers();
    UFAQSetAutoCompleteClickHandlers();
    UFAQSetRatingHandlers();
    UFAQSetExpandCollapseHandlers();
    UFAQSetPaginationHandlers();
});

function runEffect(display, post_id) {
    var selectedEffect = reveal_effect;
    // most effect types need no options passed by default
    var options = {};
    // some effects have required parameters
    if ( selectedEffect === "size" ) {
      options = { to: { width: 200, height: 60 } };
    }
    // run the effect
    if (display == "show") {jQuery( "#ufaq-body-"+post_id ).show( selectedEffect, options, 500, handleStyles(display, post_id) );}
	if (display == "hide") {jQuery( "#ufaq-body-"+post_id ).hide( selectedEffect, options, 500, handleStyles(display, post_id) );}
};

// callback function to bring a hidden box back
function handleStyles(display, post_id) {
	if (display == "show") {setTimeout(function() {jQuery('#ufaq-body-'+post_id).removeClass("ewd-ufaq-hidden"); }, 500 );}
	if (display == "hide") {setTimeout(function() {jQuery('#ufaq-body-'+post_id).addClass("ewd-ufaq-hidden");}, 500 );}
};

function ufaqSetClickHandlers() {
	jQuery('.ufaq-faq-toggle').off('click').on('click', function(event) {
		var post_id = jQuery(this).attr("data-postid");
		
		event.preventDefault();
		
		var selectedIDString = 'ufaq-body-'+post_id;
		
		if (jQuery('#'+selectedIDString).hasClass("ewd-ufaq-hidden")) {
			EWD_UFAQ_Reveal_FAQ(post_id, selectedIDString);
		}
		else {
			EWD_UFAQ_Hide_FAQ(post_id);
		}
	});

	jQuery('.ufaq-faq-category-title-toggle').off('click').on('click', function(event) {
		var category_id = jQuery(this).attr("data-categoryid");
		var closed = jQuery('#ufaq-faq-category-body-'+category_id).hasClass("ufaq-faq-category-body-hidden");

		if (jQuery(this).hasClass('ufaq-faq-category-title-accordion')) {
			jQuery('.ufaq-faq-category-inner').addClass("ufaq-faq-category-body-hidden");
		}
		
		if (closed) {
			jQuery('#ufaq-faq-category-body-'+category_id).removeClass("ufaq-faq-category-body-hidden");
		}
		else {
			jQuery('#ufaq-faq-category-body-'+category_id).addClass("ufaq-faq-category-body-hidden");
		}
	});

	jQuery('.ufaq-back-to-top-link').off('click').on('click', function(event) {
		event.preventDefault();

		jQuery('html, body').animate({scrollTop: jQuery("#ufaq-faq-list").offset().top -80}, 100);
	});

	jQuery('.ufaq-faq-header-link').off('click').on('click', function(event) {
		event.preventDefault();

		var faqID = jQuery(this).data("postid");
		if (jQuery('#ufaq-body-'+faqID).hasClass('ewd-ufaq-hidden')) {
			var selectedIDString = 'ufaq-body-'+faqID;
			EWD_UFAQ_Reveal_FAQ(faqID, selectedIDString);
		}
		jQuery('html, body').animate({scrollTop: jQuery("#ufaq-post-"+faqID).offset().top -20}, 100);
	});
}

function UFAQSetAutoCompleteClickHandlers() {
	jQuery('#ufaq-ajax-text-input').on('keyup', function() {
		if (typeof autocompleteQuestion === 'undefined' || autocompleteQuestion === null) {autocompleteQuestion = "No";}
		if (autocompleteQuestion == "Yes") {
			jQuery('#ufaq-ajax-text-input').autocomplete({
				source: questionTitles,
				minLength: 3,
				appendTo: "#ewd-ufaq-jquery-ajax-search",
				select: function(event, ui) {
					jQuery(this).val(ui.item.value);
        			Ufaq_Ajax_Reload();
				}
			});
			jQuery('#ufaq-ajax-text-input').autocomplete( "enable" );
		}
	}); 
}

function EWD_UFAQ_Reveal_FAQ(post_id, selectedIDString) {
	var data = 'post_id=' + post_id + '&action=ufaq_record_view';
    jQuery.post(ajaxurl, data, function(response) {});

    jQuery('#ewd-ufaq-post-symbol-'+post_id).html(jQuery('#ewd-ufaq-post-symbol-'+post_id).html().toUpperCase());

	jQuery('#ufaq-excerpt-'+post_id).addClass("ewd-ufaq-hidden");

	if (reveal_effect != "none") {runEffect("show", post_id); }
	else {jQuery('#ufaq-body-'+post_id).removeClass("ewd-ufaq-hidden"); }
			
	if (faq_accordion) {
		jQuery('.ufaq-faq-div').each(function() {
			if (jQuery(this).data("postid") != post_id) {
		  		EWD_UFAQ_Hide_FAQ(jQuery(this).data("postid"));
			} else{
				jQuery(this).addClass("ewd-ufaq-post-active");
			}
		});
	}
	else {
		jQuery('#ufaq-post-'+post_id).addClass("ewd-ufaq-post-active");
	}
}

function EWD_UFAQ_Hide_FAQ(post_id) {
	jQuery('#ufaq-excerpt-'+post_id).removeClass("ewd-ufaq-hidden");

	if (reveal_effect != "none") {runEffect("hide", post_id);}
	else {jQuery('#ufaq-body-'+post_id).addClass("ewd-ufaq-hidden");}
	jQuery('#ufaq-post-'+post_id).removeClass("ewd-ufaq-post-active");
	jQuery('#ewd-ufaq-post-symbol-'+post_id).html(jQuery('#ewd-ufaq-post-symbol-'+post_id).html().toLowerCase());
}

jQuery(document).ready(function() {
	if (typeof(faq_scroll) == "undefined") {faq_scroll = false;}
	if (faq_scroll) {
    	jQuery('.ufaq-faq-title').click(function(){
    		var faqID = jQuery(this).attr('id'); 
    		jQuery('html, body').animate({scrollTop: jQuery(this).offset().top -80}, 100);
    	});
	}

    jQuery("#ufaq-ajax-search-btn").click(function(){
		Ufaq_Ajax_Reload();
    });

	jQuery('#ufaq-ajax-form').submit( function(event) {
		event.preventDefault();
		Ufaq_Ajax_Reload();
	});

	jQuery('#ufaq-ajax-text-input').keyup(function() {
		Ufaq_Ajax_Reload();
	});

	if (jQuery('#ufaq-ajax-text-input').length) {
		if (jQuery('#ufaq-ajax-text-input').val() != "") {Ufaq_Ajax_Reload();}
	}

	if (typeof(Display_FAQ_ID) != "undefined" && Display_FAQ_ID !== null) {
		Display_FAQ_ID_Pos = Display_FAQ_ID.indexOf('-');
		Display_FAQ_ID = Display_FAQ_ID.substring(0, Display_FAQ_ID_Pos);
		var selectedIDString = jQuery('.ufaq-body-'+Display_FAQ_ID).attr('id');
		Display_FAQ_ID = selectedIDString.substring(10);
		EWD_UFAQ_Reveal_FAQ(Display_FAQ_ID, selectedIDString);
		jQuery('html, body').delay(800).animate({scrollTop: jQuery("#"+selectedIDString).offset().top - 180}, 300);
	}
});

var RequestCount = 0;
function Ufaq_Ajax_Reload(pagination, append_results) {
	filtering_running = 'Yes';

    var Question = jQuery('.ufaq-text-input').val();
    var include_cat = jQuery('#ufaq-include-category').val();
    var exclude_cat = jQuery('#ufaq-exclude-category').val();
    var orderby = jQuery('#ufaq-orderby').val();
    var order = jQuery('#ufaq-order').val();
    var post_count = jQuery('#ufaq-post-count').val();
    var current_url = jQuery('#ufaq-current-url').val();
    var show_on_load = jQuery('#ufaq-show-on-load').val();

    if (Question == undefined) {Question = '';}

    if (pagination == 'Yes') {
    	var faqs_only = 'Yes';
    	var faq_page = jQuery('.ewd-ufaq-bottom').data('currentpage');
    }
    else {
    	var faqs_only = 'No';
    	var faq_page = 0;
    }

    jQuery('#ufaq-ajax-results').html('<h3>' + ewd_ufaq_php_data.retrieving_results + '</h3>');
    RequestCount = RequestCount + 1;

    if (show_on_load == 'No' && Question.length == 0) {jQuery('#ufaq-ajax-results').html(''); return;} 

    var data = 'Q=' + Question + '&include_category=' + include_cat + '&exclude_category=' + exclude_cat + '&orderby=' + orderby + '&order=' + order + '&post_count=' + post_count + '&request_count=' + RequestCount + '&current_url=' + current_url + '&faqs_only=' + faqs_only + '&faq_page=' + faq_page + '&action=ufaq_search';
    jQuery.post(ajaxurl, data, function(response) {
		var parsed_response = jQuery.parseJSON(response);
		if (parsed_response.request_count == RequestCount) {
			if (append_results == 'Yes') {jQuery('.ewd-ufaq-faqs').append(parsed_response.message);}
			else if (pagination == 'Yes') {jQuery('.ewd-ufaq-faqs').html(parsed_response.message)}
			else {jQuery('#ufaq-ajax-results').html(parsed_response.message);}
       		ufaqSetClickHandlers();
       		UFAQSetRatingHandlers();
       		UFAQUpdatePaginationButtons();

       		filtering_running = 'No';
       	}
    });
}

function UFAQSetRatingHandlers() {
	jQuery('.ewd-ufaq-rating-button').off('click');
	jQuery('.ewd-ufaq-rating-button').on('click', function() {
		var FAQ_ID = jQuery(this).data('ratingfaqid');
		jQuery('*[data-ratingfaqid="' + FAQ_ID + '"]').off('click');

		var Current_Count = jQuery(this).html();
		Current_Count++;
		jQuery(this).html(Current_Count);

		if (jQuery(this).hasClass("ewd-ufaq-up-vote")) {Vote_Type = "Up";}
		else {Vote_Type = "Down";}

		var data = '&FAQ_ID=' + FAQ_ID + '&Vote_Type=' + Vote_Type + '&action=ufaq_update_rating';
    	jQuery.post(ajaxurl, data, function(response) {
    	});
	});
}

function UFAQSetExpandCollapseHandlers() {
	jQuery('.ewd-ufaq-expand-all').on('click', function() {
		jQuery('.ufaq-faq-toggle').each(function() {
			var post_id = jQuery(this).attr("data-postid");
			var selectedIDString = 'ufaq-body-'+post_id;
			EWD_UFAQ_Reveal_FAQ(post_id, selectedIDString);
		});
		jQuery('.ufaq-faq-category-inner').removeClass('ufaq-faq-category-body-hidden');
		jQuery('.ewd-ufaq-collapse-all').removeClass('ewd-ufaq-hidden');
		jQuery('.ewd-ufaq-expand-all').addClass('ewd-ufaq-hidden');
	});
	jQuery('.ewd-ufaq-collapse-all').on('click', function() {
		jQuery('.ufaq-faq-toggle').each(function() {
			var post_id = jQuery(this).attr("data-postid");
			EWD_UFAQ_Hide_FAQ(post_id);
		});
		if (jQuery('.ufaq-faq-category-title-toggle').length > 0) {jQuery('.ufaq-faq-category-inner').addClass('ufaq-faq-category-body-hidden');}
		jQuery('.ewd-ufaq-expand-all').removeClass('ewd-ufaq-hidden');
		jQuery('.ewd-ufaq-collapse-all').addClass('ewd-ufaq-hidden');
	});
}

function UFAQSetPaginationHandlers() {
	jQuery('.ewd-ufaq-previous-faqs').on('click', function() {
		var current_page = jQuery('.ewd-ufaq-bottom').data('currentpage');
		jQuery('.ewd-ufaq-bottom').data('currentpage', Math.max(current_page - 1, 0));
		jQuery('.ewd-ufaq-max-faqs-not-reached').remove();
		Ufaq_Ajax_Reload("Yes", "No");
	});

	jQuery('.ewd-ufaq-next-faqs').on('click', function() {
		var current_page = jQuery('.ewd-ufaq-bottom').data('currentpage');
		jQuery('.ewd-ufaq-bottom').data('currentpage', current_page + 1);
		jQuery('.ewd-ufaq-max-faqs-not-reached').remove();
		Ufaq_Ajax_Reload("Yes", "No");
	});

	jQuery('.ewd-ufaq-load-more').on('click', function() {
		var current_page = jQuery('.ewd-ufaq-bottom').data('currentpage');
		jQuery('.ewd-ufaq-bottom').data('currentpage', current_page + 1);
		jQuery('.ewd-ufaq-max-faqs-not-reached').remove();
		Ufaq_Ajax_Reload("Yes", "Yes");
	});

	if (jQuery('.ewd-ufaq-page-type-Infinite_Scroll').length) {
		jQuery(window).scroll(function(){
			var InfinitePos = jQuery('.ewd-ufaq-page-type-Infinite_Scroll').position();
			if (InfinitePos != undefined && jQuery('.ewd-ufaq-max-faqs-not-reached').length) {
				if  ((jQuery(window).height() + jQuery(window).scrollTop() > InfinitePos.top) && filtering_running == "No"){
					jQuery('.ewd-ufaq-bottom').data('currentpage', jQuery('.ewd-ufaq-bottom').data('currentpage') + 1)
					Ufaq_Ajax_Reload("Yes", "Yes");
				}
			}
		});
	}
}

function UFAQUpdatePaginationButtons() {
	jQuery('.ewd-ufaq-bottom').first().appendTo('.ufaq-faq-list');

	if (jQuery('.ewd-ufaq-max-faqs-not-reached').length) {
		jQuery('.ewd-ufaq-load-more, .ewd-ufaq-next-faqs').removeClass('ewd-ufaq-hidden');
	}
	else {jQuery('.ewd-ufaq-load-more, .ewd-ufaq-next-faqs').addClass('ewd-ufaq-hidden');}

	if (jQuery('.ewd-ufaq-bottom').data('currentpage') == 0) {
		jQuery('.ewd-ufaq-previous-faqs').addClass('ewd-ufaq-hidden');
	}
	else {jQuery('.ewd-ufaq-previous-faqs').removeClass('ewd-ufaq-hidden');}
}

/*jQuery(document).ready(function() {
  jQuery('a[href*=#]:not([href=#])').click(function() {
  	var post_id = jQuery(this).attr("data-postid"); 
    var selectedIDString = 'ufaq-body-'+post_id;
    
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {

    jQuery('html,body').on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
       jQuery('html,body').stop();
    });
		
		if (jQuery('#'+selectedIDString).hasClass("ewd-ufaq-hidden")) {
			EWD_UFAQ_Reveal_FAQ(post_id, selectedIDString);
		}

        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        //return false;
      }
    }
  });
});*/
