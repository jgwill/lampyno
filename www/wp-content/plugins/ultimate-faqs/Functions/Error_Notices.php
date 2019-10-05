<?php
/* Add any update or error notices to the top of the admin page */
function EWD_UFAQ_Error_Notices(){
    global $ewd_ufaq_message;
	if (isset($ewd_ufaq_message)) {
		if (isset($ewd_ufaq_message['Message_Type']) and $ewd_ufaq_message['Message_Type'] == "Update") {echo "<div class='updated'><p>" . $ewd_ufaq_message['Message'] . "</p></div>";}
		if (isset($ewd_ufaq_message['Message_Type']) and $ewd_ufaq_message['Message_Type'] == "Error") {echo "<div class='error'><p>" . $ewd_ufaq_message['Message'] . "</p></div>";}
	}

	if( get_transient( 'ewd-ufaq-admin-install-notice' ) ){ ?>
		<div class="updated notice is-dismissible">
            <p>Head over to the <a href="admin.php?page=EWD-UFAQ-Options">Ultimate FAQs Dashboard</a> to get started using the plugin!</p>
        </div>

        <?php
        delete_transient( 'ewd-ufaq-admin-install-notice' );
	}

	$Ask_Review_Date = get_option('EWD_UFAQ_Ask_Review_Date');
	if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("EWD_UFAQ_Install_Time") + 3600*24*4;}

	if ($Ask_Review_Date < time() and get_option("EWD_UFAQ_Install_Time") < time() - 3600*24*4) {

		global $pagenow;
		if($pagenow != 'post.php' && $pagenow != 'post-new.php'){ ?>

			<div class='notice notice-info is-dismissible ewd-ufaq-main-dashboard-review-ask' style='display:none'>
				<div class='ewd-ufaq-review-ask-plugin-icon'></div>
				<div class='ewd-ufaq-review-ask-text'>
					<p class='ewd-ufaq-review-ask-starting-text'>Enjoying using the Ultimate FAQs plugin?</p>
					<p class='ewd-ufaq-review-ask-feedback-text ufaq-hidden'>Help us make the plugin better! Please take a minute to rate the plugin. Thanks!</p>
					<p class='ewd-ufaq-review-ask-review-text ufaq-hidden'>Please let us know what we could do to make the plugin better!<br /><span>(If you would like a response, please include your email address.)</span></p>
					<p class='ewd-ufaq-review-ask-thank-you-text ufaq-hidden'>Thank you for taking the time to help us!</p>
				</div>
				<div class='ewd-ufaq-review-ask-actions'>
					<div class='ewd-ufaq-review-ask-action ewd-ufaq-review-ask-not-really ewd-ufaq-review-ask-white'>Not Really</div>
					<div class='ewd-ufaq-review-ask-action ewd-ufaq-review-ask-yes ewd-ufaq-review-ask-green'>Yes!</div>
					<div class='ewd-ufaq-review-ask-action ewd-ufaq-review-ask-no-thanks ewd-ufaq-review-ask-white ufaq-hidden'>No Thanks</div>
					<a href='https://wordpress.org/support/plugin/ultimate-faqs/reviews/' target='_blank'>
						<div class='ewd-ufaq-review-ask-action ewd-ufaq-review-ask-review ewd-ufaq-review-ask-green ufaq-hidden'>OK, Sure</div>
					</a>
				</div>
				<div class='ewd-ufaq-review-ask-feedback-form ufaq-hidden'>
					<div class='ewd-ufaq-review-ask-feedback-explanation'>
						<textarea></textarea>
						<br>
						<input type="email" name="feedback_email_address" placeholder="<?php _e('Email Address', 'ultimate-faqs'); ?>">
					</div>
					<div class='ewd-ufaq-review-ask-send-feedback ewd-ufaq-review-ask-action ewd-ufaq-review-ask-green'>Send Feedback</div>
				</div>
				<div class='ewd-ufaq-clear'></div>
			</div>

			<?php
		}
	}
}


