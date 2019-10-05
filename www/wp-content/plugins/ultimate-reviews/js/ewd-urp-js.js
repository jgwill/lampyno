var Filtering_Running = "No";
jQuery(function(){ //DOM Ready
    URPSetClickHandlers();
    URPSetKeyStrokeCounters();
    URPSetKarmaHandlers();
    URPSetStarHandlers();
    URPSetFilteringHandlers();
    URPSetPaginationHandlers();
    URPSetToggleHandlers();
    URPInfiniteScroll();
    URPFormSubmitHandler();
    URPThumbnailReadMoreAJAXHAndler();
    URPSetClickableSummaryHandler();
    URPSetFlagInappropriateHandler();
    URPPositionElements();
    URPSetWCTabSwitchers();
    URPSetStarRequiredHandlers();

    jQuery('#urp-ajax-text-input').on('keyup', function() {

	    var Question = jQuery('.urp-text-input').val();
	    var product_name = jQuery('#urp-search-product-name').val();
	    var orderby = jQuery('#urp-search-orderby').val();
	    var order = jQuery('#urp-search-order').val();
	    var post_count = jQuery('#urp-search-post-count').val();

	    if (product_name == undefined) {product_name = "";}

	    jQuery('#urp-ajax-results').html('<h3>Retrieving results...</h3>');

	    var data = 'Q=' + Question + '&product_name=' + encodeURIComponent(product_name) + '&orderby=' + orderby + '&order=' + order + '&post_count=' + post_count + '&action=urp_search';
		jQuery.post(ajaxurl, data, function(response) {
	        response = response.substring(0, response.length - 1);
	        jQuery('#urp-ajax-results').html(response);
	        URPSetClickHandlers();
	        URPSetFilteringHandlers();
	        URPSetKarmaHandlers();
	        URPSetPaginationHandlers();
	        URPSetFlagInappropriateHandler();
	        URPPositionElements();
	    });
	});

});

function URPSetClickHandlers() {
	jQuery('.ewd-urp-product-name-text-input').on('keyup', function() {
		if (typeof autocompleteProductNames === 'undefined' || autocompleteProductNames === null) {autocompleteProductNames = "No";}
		if (typeof restrictProductNames === 'undefined' || restrictProductNames === null) {restrictProductNames = "No";}

		if (restrictProductNames == "Yes") {
			if (jQuery.inArray(jQuery('.ewd-urp-product-name-text-input').val(), productNames) == -1) {
				jQuery('#ewd-urp-restrict-product-names-message').html("Please make sure the product name matches exactly.");
				jQuery('#ewd-urp-review-submit').prop('disabled', true);
			}
			else {
				jQuery('#ewd-urp-restrict-product-names-message').html("");
				jQuery('#ewd-urp-review-submit').prop('disabled', false);
			}
		}

		if (autocompleteProductNames == "Yes") {
			jQuery('.ewd-urp-product-name-text-input').autocomplete({
				source: productNames
			});
			if (jQuery('.ewd-urp-product-name-text-input').val().length >1) {
				jQuery('.ewd-urp-product-name-text-input').autocomplete( "enable" );
			}
			else {
				jQuery('.ewd-urp-product-name-text-input').autocomplete( "disable" );
			}
		}
	});

	jQuery('.ewd-urp-expandable-title').on('click', function(event) {
		if (typeof accordionExpandable === 'undefined' || accordionExpandable === null) {accordionExpandable = "No";}

		var reviewID = jQuery(this).data('postid');

		if (jQuery('#ewd-urp-review-content-'+reviewID).hasClass('ewd-urp-content-hidden')) {var action = 'Open';}
		else {var action = 'Close';}

		if (accordionExpandable == "Yes") {
			jQuery('.ewd-urp-review-content').addClass('ewd-urp-content-hidden');
		}

		if (action == 'Close') {jQuery('#ewd-urp-review-content-'+reviewID).addClass('ewd-urp-content-hidden');}
		else {
			jQuery('#ewd-urp-review-content-'+reviewID).removeClass('ewd-urp-content-hidden');
			var data = 'post_id=' + reviewID + '&action=urp_record_view';
    		jQuery.post(ajaxurl, data, function(response) {});
		}

		event.preventDefault();
	});
}

function URPSetKeyStrokeCounters() {
	jQuery('.ewd-urp-review-textarea').on('keyup', function() {
		var textareaCount = jQuery(this).data('textareacount');
		var currentChars = jQuery(this).val().length;

		if (ewd_urp_php_data.review_character_limit == "") {return;}

		var returnText = "<label></label>Characters remaining: " + (parseInt(ewd_urp_php_data.review_character_limit) - currentChars);

		if (currentChars > ewd_urp_php_data.review_character_limit) {
			jQuery('#ewd-urp-review-submit').prop('disabled', true);
			jQuery('#ewd-urp-review-character-count-'+textareaCount).css('color', 'red');
		}
		else {
			jQuery('#ewd-urp-review-submit').prop('disabled', false);
			jQuery('#ewd-urp-review-character-count-'+textareaCount).css('color', 'inherit');
		}

		jQuery('#ewd-urp-review-character-count-'+textareaCount).html(returnText);
	})
}

function URPSetKarmaHandlers() {
	jQuery('.ewd-urp-karma-down').on('click', function() {
		var reviewID = jQuery(this).data('reviewid');
		if (reviewID == "0") {return;}

		URPKarmaAJAX('down', reviewID);

		var currentScore = jQuery('#ewd-urp-karma-score-'+reviewID).html();
		currentScore--;
		jQuery('#ewd-urp-karma-score-'+reviewID).html(currentScore);

		jQuery(this).data('reviewid', '0');
	});

	jQuery('.ewd-urp-karma-up').on('click', function() {
		var reviewID = jQuery(this).data('reviewid');
		if (reviewID == "0") {return;}

		URPKarmaAJAX('up', reviewID);

		var currentScore = jQuery('#ewd-urp-karma-score-'+reviewID).html();
		currentScore++;
		jQuery('#ewd-urp-karma-score-'+reviewID).html(currentScore);

		jQuery(this).data('reviewid', '0');
	});
}

function URPKarmaAJAX(direction, reviewID) {
	var data = 'Direction=' + direction + '&ReviewID=' + reviewID + '&action=urp_update_karma';
    jQuery.post(ajaxurl, data, function(response) {});
}

function URPSetStarHandlers() {
	jQuery('.ewd-urp-star-input').on('click', function() {
		var score = jQuery(this).data('reviewscore');
		var inputName = jQuery(this).data('inputname');
		var cssIDAdd = jQuery(this).data('cssidadd');

		var counter = 1;
		while (counter <= ewd_urp_php_data.maximum_score) {
			if (counter <= score) {jQuery('#ewd-urp-star-input-'+cssIDAdd+'-'+counter).addClass('ewd-urp-star-input-filled');}
			else {jQuery('#ewd-urp-star-input-'+cssIDAdd+'-'+counter).removeClass('ewd-urp-star-input-filled');}
			counter++;
		}

		jQuery("input[name='"+inputName+"']").val(score);
	})
}

function URPSetFilteringHandlers() {
	jQuery('.ewd-urp-filtering-toggle').on('click', function() {
		if (jQuery('.ewd-urp-filtering-controls').hasClass('ewd-urp-hidden')) {
			jQuery('.ewd-urp-filtering-controls').removeClass('ewd-urp-hidden');
			jQuery('.ewd-urp-filtering-toggle').removeClass('ewd-urp-filtering-toggle-downcaret');
			jQuery('.ewd-urp-filtering-toggle').addClass('ewd-urp-filtering-toggle-upcaret');
		}
		else {
			jQuery('.ewd-urp-filtering-controls').addClass('ewd-urp-hidden');
			jQuery('.ewd-urp-filtering-toggle').removeClass('ewd-urp-filtering-toggle-upcaret');
			jQuery('.ewd-urp-filtering-toggle').addClass('ewd-urp-filtering-toggle-downcaret');
		}
	});

	jQuery('.ewd-urp-filtering-select').on('change', function(event) {
		var Shortcode_ID = jQuery(this).data('shortcodeid');
		URPFilterResults(Shortcode_ID);
	});

    jQuery(".ewd-urp-review-score-filter").slider({
    	range: true,
    	min: 1,
    	max: ewd_urp_php_data.maximum_score,
    	values: [ 1, ewd_urp_php_data.maximum_score ],
        change: function( event, ui ) {
           jQuery(".ewd-urp-score-range").text( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
           var Shortcode_ID = jQuery(this).data('shortcodeid');
           URPFilterResults(Shortcode_ID);
        }
    });
}

function URPFilterResults(Shortcode_ID, AddResults, selectedScore) {
	var search_string = jQuery('#urp-search-string[data-shortcodeid="' + Shortcode_ID + '"]').val();
	if (jQuery('.ewd-filtering-product-name[data-shortcodeid="' + Shortcode_ID + '"]').val() == "All" || jQuery('.ewd-filtering-product-name[data-shortcodeid="' + Shortcode_ID + '"]').val() == undefined) {var product_name = jQuery('#urp-product-name[data-shortcodeid="' + Shortcode_ID + '"]').val();}
	else {var product_name = jQuery('.ewd-filtering-product-name[data-shortcodeid="' + Shortcode_ID + '"]').val();}
	if (jQuery('.ewd-filtering-review-author[data-shortcodeid="' + Shortcode_ID + '"]').val() == "All" || jQuery('.ewd-filtering-review-author[data-shortcodeid="' + Shortcode_ID + '"]').val() == undefined) {var review_author = jQuery('#urp-review-author[data-shortcodeid="' + Shortcode_ID + '"]').val();}
	else {var review_author = jQuery('.ewd-filtering-review-author[data-shortcodeid="' + Shortcode_ID + '"]').val();}
	if (jQuery('.ewd-urp-custom-filter[data-shortcodeid="' + Shortcode_ID + '"]').length == 0) {var custom_filters = jQuery('#urp-custom-filters[data-shortcodeid="' + Shortcode_ID + '"]').val();}
	else {
		var custom_filters_array = {};
		jQuery('.ewd-urp-custom-filter[data-shortcodeid="' + Shortcode_ID + '"]').each(function() {
			custom_filters_array[jQuery(this).data("fieldname")] = jQuery(this).val();
		});
		var custom_filters = JSON.stringify(custom_filters_array);
	}
	var values = jQuery('.ewd-urp-review-score-filter[data-shortcodeid="' + Shortcode_ID + '"]').slider("option", "values");
	var min_score = values[0];
	var max_score = values[1];
	if (min_score == undefined) {min_score = 0;}
	if (max_score == undefined) {max_score = 1000000;}
	if (selectedScore !== undefined) {min_score = selectedScore;}
	if (selectedScore !== undefined) {max_score = selectedScore;}
	var orderby = jQuery('#urp-orderby[data-shortcodeid="' + Shortcode_ID + '"]').val();
	var order = jQuery('#urp-order[data-shortcodeid="' + Shortcode_ID + '"]').val();
	var post_count = jQuery('#urp-post-count[data-shortcodeid="' + Shortcode_ID + '"]').val();
	var current_page = jQuery('#urp-current-page[data-shortcodeid="' + Shortcode_ID + '"]').val();
	if (current_page == undefined) {current_page = 1;}

	if (AddResults == "Yes") {jQuery('.urp-infinite-scroll-content-area[data-shortcodeid="' + Shortcode_ID + '"]').html('<h3>Retrieving results...</h3>');}
	else {jQuery('.ewd-urp-reviews-container[data-shortcodeid="' + Shortcode_ID + '"]').html('<h3>Retrieving results...</h3>');}
	var data = 'Shortcode_ID=' + Shortcode_ID + '&Q=' + search_string + '&product_name=' + encodeURIComponent(product_name) + '&review_author=' + review_author + '&custom_filters=' + custom_filters + '&min_score=' + min_score + '&max_score=' + max_score + '&orderby=' + orderby + '&order=' + order + '&post_count=' + post_count + '&current_page=' + current_page + '&only_reviews=Yes&action=urp_search';
	
	jQuery.post(ajaxurl, data, function(response) {
	    response = response.substring(0, response.length - 1); 
	    if (AddResults == "Yes") {jQuery('.urp-infinite-scroll-content-area[data-shortcodeid="' + Shortcode_ID + '"]').replaceWith(response);}
	    else {jQuery('.ewd-urp-reviews-container[data-shortcodeid="' + Shortcode_ID + '"]').html(response); }
	    URPSetClickHandlers();
	    URPSetPaginationHandlers();
	    URPSetKarmaHandlers();
	    URPThumbnailReadMoreAJAXHAndler();
	    URPSetFlagInappropriateHandler();
	    URPPositionElements();
	    URPSetClickableSummaryHandler();
	    Filtering_Running = "No";
	});
}

function URPSetPaginationHandlers() {
	jQuery('.ewd-urp-page-control').on('click', function() { 
		var action = jQuery(this).data('controlvalue');
		if (action == 'first') {jQuery('#urp-current-page').val(1);}
		if (action == 'back') {jQuery('#urp-current-page').val(Math.max(1, jQuery('#urp-current-page').val()-1));}
		if (action == 'next') {jQuery('#urp-current-page').val(Math.min(jQuery('#urp-max-page').val(), parseInt(jQuery('#urp-current-page').val())+1));}
		if (action == 'last') {jQuery('#urp-current-page').val(jQuery('#urp-max-page').val());}

		var Shortcode_ID = jQuery(this).data('shortcodeid');

		URPFilterResults(Shortcode_ID);
	});
}

function URPSetToggleHandlers() {
	jQuery('.ewd-urp-submit-review-toggle').on('click', function() {
		jQuery('.ewd-urp-submit-review-toggle').addClass('ewd-urp-content-hidden');
		jQuery('.ewd-urp-review-form').removeClass('ewd-urp-content-hidden');
	})
}

function URPInfiniteScroll() {
	if (jQuery('.ewd-urp-review-list').hasClass('urp-infinite-scroll')) {
		jQuery(window).scroll(function(){
			var InfinitePos = jQuery('.urp-infinite-scroll-content-area').position();
			if (InfinitePos != undefined && jQuery('#urp-max-page').val() != parseInt(jQuery('#urp-current-page').val())) {
				//console.log("scrollTop:" + jQuery(window).scrollTop() + "\nDoc Height: " + jQuery(document).height() + "\nInfinite Top: " + InfinitePos.top + "\nWindow Height: " + jQuery(window).height());
				if  ((jQuery(window).height() + jQuery(window).scrollTop() > InfinitePos.top) && Filtering_Running == "No"){
					jQuery('#urp-current-page').val(Math.min(jQuery('#urp-max-page').val(), parseInt(jQuery('#urp-current-page').val())+1));
					Filtering_Running = "Yes";
					var Add_Results = "Yes";
					var Shortcode_ID = jQuery('.urp-infinite-scroll-content-area').data('shortcodeid');
					URPFilterResults(Shortcode_ID, Add_Results);
				}
			}
		});
	}
}

function URPFormSubmitHandler() {
	jQuery('#review_order').on('submit', function(e) {
		if (jQuery('#ewd-urp-overall-score').val() == "") {
			jQuery('.ewd-urp-submit').prepend("<div id='ewd-urp-submit-warning'>Please select a score before submitting the form.</div>");
			setTimeout(function() {jQuery('#ewd-urp-submit-warning').remove()}, 5000);
			e.preventDefault();
		}
	});
}

function URPThumbnailReadMoreAJAXHAndler() {
	jQuery('.ewd-urp-thumbnail-read-more.Yes').on('click', function(event) {
		var postID = jQuery(this).data('postid');
		var ID = postID.substring(4);
		jQuery("#ewd-urp-review-"+postID).html('Retrieving full review...');
		jQuery(this).remove();
		var data = 'ID=' + ID + '&action=urp_thumbnail_ajax';
		jQuery.post(ajaxurl, data, function(response) {
			jQuery("#ewd-urp-review-"+postID).html(response);
			URPReadLessHandler();
		});
		event.preventDefault();
	});
}

function URPReadLessHandler() {
	jQuery('.ewd-urp-ajax-read-less').off();
	jQuery('.ewd-urp-ajax-read-less').on('click', function() {
		var Thumbnail_Chars = jQuery(this).data('thumbnailchars');
		var Parent_Span = jQuery(this).parent();

		jQuery(this).remove();
		Parent_Span.html(Parent_Span.html().substring(0, Thumbnail_Chars));
	});
}

function URPSetClickableSummaryHandler() {
	jQuery('.ewd-urp-summary-clickable').on('click', function() {
		var selectedScore = jQuery(this).data('reviewscore'); 
		var values = jQuery('#ewd-urp-review-score-filter').slider("option", "values"); 
		var Shortcode_ID = jQuery(this).data('shortcodeid');
		if (values[0] !== undefined) {
			jQuery('.ewd-urp-review-score-filter').slider("values", 0, selectedScore);
			jQuery('.ewd-urp-review-score-filter').slider("values", 1, selectedScore);
		}
		else {
			jQuery(this).parent().append("<div class='ewd-urp-remove-score-filter'>Show all reviews</div>");
			URPFilterResults(Shortcode_ID, "No", selectedScore);
		}
	});

	jQuery('.ewd-urp-remove-score-filter').on('click', function() {
		var Shortcode_ID = jQuery(this).parent().data('shortcodeid');

		jQuery(this).remove();
		URPFilterResults(Shortcode_ID);
	});
}

function URPSetFlagInappropriateHandler() {
	jQuery('.ewd-urp-flag-inappropriate').off('click');
	jQuery('.ewd-urp-flag-inappropriate').on('click', function() {
		if (jQuery(this).hasClass('ewd-urp-content-flagged')) {return;}

		jQuery(this).addClass('ewd-urp-content-flagged');

		var ReviewID = jQuery(this).data('reviewid');
		var data = 'ReviewID=' + ReviewID + '&action=urp_flag_inappropriate';
		jQuery.post(ajaxurl, data, function(response) {});
	});
}

function URPPositionElements() {
  if(ewd_urp_php_data.flag_inappropriate_enabled == "Yes"){
    jQuery('.ewd-urp-flag-inappropriate').show();
  }
  jQuery('.ewd-urp-review-header').each(function(){
    var thisReview = jQuery(this);
    var reviewScoreHeight = thisReview.find('.ewd-urp-review-score').height();
    var reviewScoreTextHeight = thisReview.find('.ewd-urp-review-score-number').height();
    var reviewScoreTextMargin = (reviewScoreHeight - reviewScoreTextHeight) / 2;
    var reviewFlagMargin = (reviewScoreHeight / 2) - 9;
    var reviewTitleTextHeight = thisReview.find('.ewd-urp-review-link').height();
    var reviewTitleTextMargin = (reviewScoreHeight - reviewTitleTextHeight) / 2;
    thisReview.find('.ewd-urp-review-score-number').css('margin-top', reviewScoreTextMargin+'px');
    thisReview.find('.ewd-urp-flag-inappropriate').css('margin-top', reviewFlagMargin+'px');
    thisReview.find('.ewd-urp-review-link').css('margin-top', reviewTitleTextMargin+'px');
  });
}

function URPSetWCTabSwitchers() {
	jQuery('.ewd-urp-wc-tab-title').on('click', function() {
		jQuery('.ewd-urp-wc-tab-title').removeClass('ewd-urp-wc-active-tab-title');
		jQuery(this).addClass('ewd-urp-wc-active-tab-title');
		
		jQuery('.ewd-urp-wc-tab').removeClass('ewd-urp-wc-active-tab');
		var tab = jQuery(this).data('tab');
		jQuery('[data-tab="' + tab + '"]').addClass('ewd-urp-wc-active-tab');
	});
}

function URPSetStarRequiredHandlers() {
	jQuery('.ewd-urp-review-form form').on('submit', function(event) {
		jQuery('.ewd-urp-hidden.required').each(function(index, el) {
			 if (jQuery(this).val() == "") {
				event.preventDefault(); 
				//jQuery(this).before.parent.prepend('<span class="urp-required">Please select a score</span>');
				jQuery(this).parent().prepend('<span class="urp-required">Please select a score</span>').focus();
			} 
		});

		jQuery('.ewd-urp-submit-review-radio-checkbox-each input[type="checkbox"]').each(function(index, el) {
			if (jQuery(this).data('required') == 'required') {
				var name = jQuery(this).attr('name');
				if (!jQuery('input[name="' + name + '"]:checked').length) {
					event.preventDefault();
					if (!jQuery(this).parent().parent().find('.urp-required').length) {
						jQuery(this).parent().parent().prepend('<span class="urp-required">Please select at least one checkbox option</span>').focus();
					}
				}
			}
		});
	});
}

jQuery(document).ready(function($){
	$('.ewd-urp-thumbnail-masonry').masonry({
		itemSelector: '.ewd-urp-thumbnail-review',
	});
	$('.ewd-urp-image-masonry').masonry({
		itemSelector: '.ewd-urp-image-review',
	});
});