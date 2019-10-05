<?php
add_action('current_screen', 'EWD_UFAQ_Deactivation_Survey');
function EWD_UFAQ_Deactivation_Survey() {
	if (in_array(get_current_screen()->id, array( 'plugins', 'plugins-network' ), true)) {
		add_action('admin_enqueue_scripts', 'EWD_UFAQ_Enqueue_Deactivation_Scripts');
		add_action( 'admin_footer', 'EWD_UFAQ_Deactivation_Survey_HTML'); 
	}
}

function EWD_UFAQ_Enqueue_Deactivation_Scripts() {
	wp_enqueue_style('ewd-ufaq-deactivation-css', EWD_UFAQ_CD_PLUGIN_URL . 'css/ewd-ufaq-plugin-deactivation.css');
	wp_enqueue_script('ewd-ufaq-deactivation-js', EWD_UFAQ_CD_PLUGIN_URL . 'js/ewd-ufaq-plugin-deactivation.js', array('jquery'));

	wp_localize_script('ewd-ufaq-deactivation-js', 'ewd_ufaq_deactivation_data', array('site_url' => site_url()));
}

function EWD_UFAQ_Deactivation_Survey_HTML() {
	$Install_Time = get_option("EWD_UFAQ_Install_Time");

	$options = array(
		1 => array(
			'title'   => esc_html__( 'I no longer need the plugin', 'ultimate-faqs' ),
		),
		2 => array(
			'title'   => esc_html__( 'I\'m switching to a different plugin', 'ultimate-faqs' ),
			'details' => esc_html__( 'Please share which plugin', 'ultimate-faqs' ),
		),
		3 => array(
			'title'   => esc_html__( 'I couldn\'t get the plugin to work', 'ultimate-faqs' ),
			'details' => esc_html__( 'Please share what wasn\'t working', 'ultimate-faqs' ),
		),
		4 => array(
			'title'   => esc_html__( 'It\'s a temporary deactivation', 'ultimate-faqs' ),
		),
		5 => array(
			'title'   => esc_html__( 'Other', 'ultimate-faqs' ),
			'details' => esc_html__( 'Please share the reason', 'ultimate-faqs' ),
		),
	);
	?>
	<div class="ewd-ufaq-deactivate-survey-modal" id="ewd-ufaq-deactivate-survey-ultimate-faqs">
		<div class="ewd-ufaq-deactivate-survey-wrap">
			<form class="ewd-ufaq-deactivate-survey" method="post" data-installtime="<?php echo $Install_Time; ?>">
				<span class="ewd-ufaq-deactivate-survey-title"><span class="dashicons dashicons-testimonial"></span><?php echo ' ' . __( 'Quick Feedback', 'ultimate-faqs' ); ?></span>
				<span class="ewd-ufaq-deactivate-survey-desc"><?php echo __('If you have a moment, please share why you are deactivating Ultimate FAQs:', 'ultimate-faqs' ); ?></span>
				<div class="ewd-ufaq-deactivate-survey-options">
					<?php foreach ( $options as $id => $option ) : ?>
						<div class="ewd-ufaq-deactivate-survey-option">
							<label for="ewd-ufaq-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="ewd-ufaq-deactivate-survey-option-label">
								<input id="ewd-ufaq-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="ewd-ufaq-deactivate-survey-option-input" type="radio" name="code" value="<?php echo $id; ?>" />
								<span class="ewd-ufaq-deactivate-survey-option-reason"><?php echo $option['title']; ?></span>
							</label>
							<?php if ( ! empty( $option['details'] ) ) : ?>
								<input class="ewd-ufaq-deactivate-survey-option-details" type="text" placeholder="<?php echo $option['details']; ?>" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="ewd-ufaq-deactivate-survey-footer">
					<button type="submit" class="ewd-ufaq-deactivate-survey-submit button button-primary button-large"><?php _e('Submit and Deactivate', 'ultimate-faqs' ); ?></button>
					<a href="#" class="ewd-ufaq-deactivate-survey-deactivate"><?php _e('Skip and Deactivate', 'ultimate-faqs' ); ?></a>
				</div>
			</form>
		</div>
	</div>
	<?php
}

?>