<?php
add_action('current_screen', 'EWD_URP_Deactivation_Survey');
function EWD_URP_Deactivation_Survey() {
	if (in_array(get_current_screen()->id, array( 'plugins', 'plugins-network' ), true)) {
		add_action('admin_enqueue_scripts', 'EWD_URP_Enqueue_Deactivation_Scripts');
		add_action( 'admin_footer', 'EWD_URP_Deactivation_Survey_HTML'); 
	}
}

function EWD_URP_Enqueue_Deactivation_Scripts() {
	wp_enqueue_style('ewd-urp-deactivation-css', EWD_URP_CD_PLUGIN_URL . 'css/ewd-urp-plugin-deactivation.css');
	wp_enqueue_script('ewd-urp-deactivation-js', EWD_URP_CD_PLUGIN_URL . 'js/ewd-urp-plugin-deactivation.js', array('jquery'));

	wp_localize_script('ewd-urp-deactivation-js', 'ewd_urp_deactivation_data', array('site_url' => site_url()));
}

function EWD_URP_Deactivation_Survey_HTML() {
	$Install_Time = get_option("EWD_URP_Install_Time");

	$options = array(
		1 => array(
			'title'   => esc_html__( 'I no longer need the plugin', 'ultimate-reviews' ),
		),
		2 => array(
			'title'   => esc_html__( 'I\'m switching to a different plugin', 'ultimate-reviews' ),
			'details' => esc_html__( 'Please share which plugin', 'ultimate-reviews' ),
		),
		3 => array(
			'title'   => esc_html__( 'I couldn\'t get the plugin to work', 'ultimate-reviews' ),
			'details' => esc_html__( 'Please share what wasn\'t working', 'ultimate-reviews' ),
		),
		4 => array(
			'title'   => esc_html__( 'It\'s a temporary deactivation', 'ultimate-reviews' ),
		),
		5 => array(
			'title'   => esc_html__( 'Other', 'ultimate-reviews' ),
			'details' => esc_html__( 'Please share the reason', 'ultimate-reviews' ),
		),
	);
	?>
	<div class="ewd-urp-deactivate-survey-modal" id="ewd-urp-deactivate-survey-ultimate-faqs">
		<div class="ewd-urp-deactivate-survey-wrap">
			<form class="ewd-urp-deactivate-survey" method="post" data-installtime="<?php echo $Install_Time; ?>">
				<span class="ewd-urp-deactivate-survey-title"><span class="dashicons dashicons-testimonial"></span><?php echo ' ' . __( 'Quick Feedback', 'ultimate-reviews' ); ?></span>
				<span class="ewd-urp-deactivate-survey-desc"><?php echo __('If you have a moment, please share why you are deactivating Ultimate Reviews:', 'ultimate-reviews' ); ?></span>
				<div class="ewd-urp-deactivate-survey-options">
					<?php foreach ( $options as $id => $option ) : ?>
						<div class="ewd-urp-deactivate-survey-option">
							<label for="ewd-urp-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="ewd-urp-deactivate-survey-option-label">
								<input id="ewd-urp-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="ewd-urp-deactivate-survey-option-input" type="radio" name="code" value="<?php echo $id; ?>" />
								<span class="ewd-urp-deactivate-survey-option-reason"><?php echo $option['title']; ?></span>
							</label>
							<?php if ( ! empty( $option['details'] ) ) : ?>
								<input class="ewd-urp-deactivate-survey-option-details" type="text" placeholder="<?php echo $option['details']; ?>" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="ewd-urp-deactivate-survey-footer">
					<button type="submit" class="ewd-urp-deactivate-survey-submit button button-primary button-large"><?php _e('Submit and Deactivate', 'ultimate-reviews' ); ?></button>
					<a href="#" class="ewd-urp-deactivate-survey-deactivate"><?php _e('Skip and Deactivate', 'ultimate-reviews' ); ?></a>
				</div>
			</form>
		</div>
	</div>
	<?php
}

?>