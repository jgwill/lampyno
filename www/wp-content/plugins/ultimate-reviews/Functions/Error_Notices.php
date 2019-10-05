<?php
/* Add any update or error notices to the top of the admin page */
function EWD_URP_Error_Notices(){
    global $ewd_urp_message;
	if (isset($ewd_urp_message)) {
		if (isset($ewd_urp_message['Message_Type']) and $ewd_urp_message['Message_Type'] == "Update") {echo "<div class='updated'><p>" . $ewd_urp_message['Message'] . "</p></div>";}
		if (isset($ewd_urp_message['Message_Type']) and $ewd_urp_message['Message_Type'] == "Error") {echo "<div class='error'><p>" . $ewd_urp_message['Message'] . "</p></div>";}
	}

	if( get_transient( 'ewd-urp-admin-install-notice' ) ){ ?>
		<div class="updated notice is-dismissible">
            <p>Head over to the <a href="admin.php?page=EWD-URP-Options">Ultimate Reviews Dashboard</a> to get started using the plugin!</p>
        </div>

        <?php
        delete_transient( 'ewd-urp-admin-install-notice' );
	}

	$Ask_Review_Date = get_option('EWD_URP_Ask_Review_Date');
	if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("EWD_URP_Install_Time") + 3600*24*4;}

	if ($Ask_Review_Date < time() and get_option("EWD_URP_Install_Time") < time() - 3600*24*4) {

		global $pagenow;
		if($pagenow != 'post.php' && $pagenow != 'post-new.php'){ ?>

			<div class='notice notice-info is-dismissible ewd-urp-main-dashboard-review-ask' style='display:none'>
				<div class='ewd-urp-review-ask-plugin-icon'></div>
				<div class='ewd-urp-review-ask-text'>
					<p class='ewd-urp-review-ask-starting-text'>Enjoying using the Ultimate Reviews plugin?</p>
					<p class='ewd-urp-review-ask-feedback-text urp-hidden'>Help us make the plugin better! Please take a minute to rate the plugin. Thanks!</p>
					<p class='ewd-urp-review-ask-review-text urp-hidden'>Please let us know what we could do to make the plugin better!<br /><span>(If you would like a response, please include your email address.)</span></p>
					<p class='ewd-urp-review-ask-thank-you-text urp-hidden'>Thank you for taking the time to help us!</p>
				</div>
				<div class='ewd-urp-review-ask-actions'>
					<div class='ewd-urp-review-ask-action ewd-urp-review-ask-not-really ewd-urp-review-ask-white'>Not Really</div>
					<div class='ewd-urp-review-ask-action ewd-urp-review-ask-yes ewd-urp-review-ask-green'>Yes!</div>
					<div class='ewd-urp-review-ask-action ewd-urp-review-ask-no-thanks ewd-urp-review-ask-white urp-hidden'>No Thanks</div>
					<a href='https://wordpress.org/support/plugin/ultimate-reviews/reviews/' target='_blank'>
						<div class='ewd-urp-review-ask-action ewd-urp-review-ask-review ewd-urp-review-ask-green urp-hidden'>OK, Sure</div>
					</a>
				</div>
				<div class='ewd-urp-review-ask-feedback-form urp-hidden'>
					<div class='ewd-urp-review-ask-feedback-explanation'>
						<textarea></textarea>
						<br>
						<input type="email" name="feedback_email_address" placeholder="<?php _e('Email Address', 'ultimate-reviews'); ?>">
					</div>
					<div class='ewd-urp-review-ask-send-feedback ewd-urp-review-ask-action ewd-urp-review-ask-green'>Send Feedback</div>
				</div>
				<div class='ewd-urp-clear'></div>
			</div>

			<?php
		}
	}

}


