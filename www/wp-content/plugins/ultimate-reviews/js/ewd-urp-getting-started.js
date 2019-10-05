jQuery(document).ready(function() {
	jQuery('.ewd-urp-welcome-screen-box h2').on('click', function() {
		var page = jQuery(this).parent().data('screen');
		EWD_URP_Toggle_Welcome_Page(page);
	});

	jQuery('.ewd-urp-welcome-screen-next-button').on('click', function() {
		var page = jQuery(this).data('nextaction');
		EWD_URP_Toggle_Welcome_Page(page);
	});

	jQuery('.ewd-urp-welcome-screen-previous-button').on('click', function() {
		var page = jQuery(this).data('previousaction');
		EWD_URP_Toggle_Welcome_Page(page);
	});

	jQuery('.ewd-urp-welcome-screen-add-submit-review-page-button').on('click', function() {
		var submit_review_page_title = jQuery('.ewd-urp-welcome-screen-add-submit-review-page-name input').val();

		EWD_URP_Toggle_Welcome_Page('display-review');

		var data = 'submit_review_page_title=' + submit_review_page_title + '&action=ewd_urp_welcome_add_submit_review_page';
		jQuery.post(ajaxurl, data, function(response) {});
	});

	jQuery('.ewd-urp-welcome-screen-add-display-review-page-button').on('click', function() {
		var display_review_page_title = jQuery('.ewd-urp-welcome-screen-add-display-review-page-name input').val();

		EWD_URP_Toggle_Welcome_Page('options');

		var data = 'display_review_page_title=' + display_review_page_title + '&action=ewd_urp_welcome_add_display_review_page';
		jQuery.post(ajaxurl, data, function(response) {});
	});

	jQuery('.ewd-urp-welcome-screen-save-options-button').on('click', function() {
		var maximum_score = jQuery('input[name="maximum_score"]').val(); 
		var review_score_input = jQuery('input[name="review_score_input"]:checked').val(); 
		var review_category = jQuery('input[name="review_category"]:checked').val();
		var review_filtering = [];
		jQuery('input[name="review_filtering[]"]:checked').each(function() {review_filtering.push(jQuery(this).val());});

		var data = 'maximum_score=' + maximum_score + '&review_score_input=' + review_score_input + '&review_category=' + review_category + '&review_filtering=' + JSON.stringify(review_filtering) + '&action=ewd_urp_welcome_set_options';
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('.ewd-urp-welcome-screen-save-options-button').after('<div class="ewd-urp-save-message"><div class="ewd-urp-save-message-inside"Options have been saved.</div></div>');
			jQuery('.ewd-urp-save-message').delay(2000).fadeOut(400, function() {jQuery('.ewd-urp-save-message').remove();});
		});
	});

	jQuery('.ewd-urp-welcome-screen-add-category-button').on('click', function() {

		jQuery('.ewd-urp-welcome-screen-show-created-categories').show();

		var category_name = jQuery('.ewd-urp-welcome-screen-add-category-name input').val();
		var category_description = jQuery('.ewd-urp-welcome-screen-add-category-description textarea').val();

		jQuery('.ewd-urp-welcome-screen-add-category-name input').val('');
		jQuery('.ewd-urp-welcome-screen-add-category-description textarea').val('');

		var data = 'category_name=' + category_name + '&category_description=' + category_description + '&action=ewd_urp_welcome_add_category';
		jQuery.post(ajaxurl, data, function(response) {
			var HTML = '<div class="ewd-urp-welcome-screen-category">';
			HTML += '<div class="ewd-urp-welcome-screen-category-name">' + category_name + '</div>';
			HTML += '<div class="ewd-urp-welcome-screen-category-description">' + category_description + '</div>';
			HTML += '</div>';

			jQuery('.ewd-urp-welcome-screen-show-created-categories').append(HTML);
		});
	});
});

function EWD_URP_Toggle_Welcome_Page(page) {
	jQuery('.ewd-urp-welcome-screen-box').removeClass('ewd-urp-welcome-screen-open');
	jQuery('.ewd-urp-welcome-screen-' + page).addClass('ewd-urp-welcome-screen-open');
}