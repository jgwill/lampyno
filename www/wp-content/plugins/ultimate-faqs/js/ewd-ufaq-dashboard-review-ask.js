jQuery(document).ready(function($) {
	jQuery('.ewd-ufaq-main-dashboard-review-ask').css('display', 'block');

	jQuery('.ewd-ufaq-main-dashboard-review-ask').on('click', function(event) {
		if (jQuery(event.srcElement).hasClass('notice-dismiss')) {
			var data = 'Ask_Review_Date=3&action=ewd_ufaq_hide_review_ask';
        	jQuery.post(ajaxurl, data, function() {});
        }
	});

	jQuery('.ewd-ufaq-review-ask-yes').on('click', function() {
		jQuery('.ewd-ufaq-review-ask-feedback-text').removeClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-starting-text').addClass('ufaq-hidden');

		jQuery('.ewd-ufaq-review-ask-no-thanks').removeClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-review').removeClass('ufaq-hidden');

		jQuery('.ewd-ufaq-review-ask-not-really').addClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-yes').addClass('ufaq-hidden');

		var data = 'Ask_Review_Date=7&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-ufaq-review-ask-not-really').on('click', function() {
		jQuery('.ewd-ufaq-review-ask-review-text').removeClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-starting-text').addClass('ufaq-hidden');

		jQuery('.ewd-ufaq-review-ask-feedback-form').removeClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-actions').addClass('ufaq-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-ufaq-review-ask-no-thanks').on('click', function() {
		var data = 'Ask_Review_Date=1000&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-ufaq-main-dashboard-review-ask').css('display', 'none');
	});

	jQuery('.ewd-ufaq-review-ask-review').on('click', function() {
		jQuery('.ewd-ufaq-review-ask-feedback-text').addClass('ufaq-hidden');
		jQuery('.ewd-ufaq-review-ask-thank-you-text').removeClass('ufaq-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-ufaq-review-ask-send-feedback').on('click', function() {
		var Feedback = jQuery('.ewd-ufaq-review-ask-feedback-explanation textarea').val();
		var EmailAddress = jQuery('.ewd-ufaq-review-ask-feedback-explanation input[name="feedback_email_address"]').val();
		var data = 'Feedback=' + Feedback + '&EmailAddress=' + EmailAddress + '&action=ewd_ufaq_send_feedback';
        jQuery.post(ajaxurl, data, function() {});

        var data = 'Ask_Review_Date=1000&action=ewd_ufaq_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-ufaq-review-ask-feedback-form').addClass('ufaq-hidden');
        jQuery('.ewd-ufaq-review-ask-review-text').addClass('ufaq-hidden');
        jQuery('.ewd-ufaq-review-ask-thank-you-text').removeClass('ufaq-hidden');
	});
});