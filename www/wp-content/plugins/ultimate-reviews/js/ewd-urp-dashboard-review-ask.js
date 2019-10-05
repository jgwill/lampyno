jQuery(document).ready(function($) {
	jQuery('.ewd-urp-main-dashboard-review-ask').css('display', 'block');

	jQuery('.ewd-urp-main-dashboard-review-ask').on('click', function(event) {
		if (jQuery(event.srcElement).hasClass('notice-dismiss')) {
			var data = 'Ask_Review_Date=3&action=ewd_urp_hide_review_ask';
        	jQuery.post(ajaxurl, data, function() {});
        }
	});

	jQuery('.ewd-urp-review-ask-yes').on('click', function() {
		jQuery('.ewd-urp-review-ask-feedback-text').removeClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-starting-text').addClass('urp-hidden');

		jQuery('.ewd-urp-review-ask-no-thanks').removeClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-review').removeClass('urp-hidden');

		jQuery('.ewd-urp-review-ask-not-really').addClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-yes').addClass('urp-hidden');

		var data = 'Ask_Review_Date=7&action=ewd_urp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-urp-review-ask-not-really').on('click', function() {
		jQuery('.ewd-urp-review-ask-review-text').removeClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-starting-text').addClass('urp-hidden');

		jQuery('.ewd-urp-review-ask-feedback-form').removeClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-actions').addClass('urp-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_urp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-urp-review-ask-no-thanks').on('click', function() {
		var data = 'Ask_Review_Date=1000&action=ewd_urp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-urp-main-dashboard-review-ask').css('display', 'none');
	});

	jQuery('.ewd-urp-review-ask-review').on('click', function() {
		jQuery('.ewd-urp-review-ask-feedback-text').addClass('urp-hidden');
		jQuery('.ewd-urp-review-ask-thank-you-text').removeClass('urp-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_urp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-urp-review-ask-send-feedback').on('click', function() {
		var Feedback = jQuery('.ewd-urp-review-ask-feedback-explanation textarea').val();
		var EmailAddress = jQuery('.ewd-urp-review-ask-feedback-explanation input[name="feedback_email_address"]').val();
		var data = 'Feedback=' + Feedback + '&EmailAddress=' + EmailAddress + '&action=ewd_urp_send_feedback';
        jQuery.post(ajaxurl, data, function() {});

        var data = 'Ask_Review_Date=1000&action=ewd_urp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-urp-review-ask-feedback-form').addClass('urp-hidden');
        jQuery('.ewd-urp-review-ask-review-text').addClass('urp-hidden');
        jQuery('.ewd-urp-review-ask-thank-you-text').removeClass('urp-hidden');
	});
});