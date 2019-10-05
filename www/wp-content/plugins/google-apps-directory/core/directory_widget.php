<?php

class GAD_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'gad_widget', // Base ID
			__('Google Apps Directory', 'google-apps-directory'), // Name
			array( 'description' => __('Google Apps Directory Widget', 'google-apps-directory' ), ) // Args
		);
		
		if ( is_active_widget(false, false, $this->id_base) ) {
			add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_gad_scripts') );
		}
	}
	
	public function enqueue_gad_scripts() {
		// This JS script was registered in the main plugin
		wp_enqueue_script( 'gad_widget_js' );
		$this->localize_script();
		wp_enqueue_style( 'gad_widget_css' );
	}

	protected $already_localized = false;
	protected function localize_script() {
		if ($this->already_localized) {
			return;
		}
		wp_localize_script('gad_widget_js', 'gad_vars', array(
			'nonce' => wp_create_nonce('gad-nonce'),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'spinnerurl' => admin_url( "images/spinner.gif" ),
			'extraoutputfields' => apply_filters('gad_extra_output_fields', '')
		));
		$this->already_localized = true;
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		echo '<form class="gad-widget-search-form">';
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		?>

		<input value="" name="gad-search" class="gad-widget-search-box" type="text">
		<input class="gad-widget-search-btn" value="<?php esc_attr_e('Search', 'google-apps-directory'); ?>" type="submit">
		
		<div class="gad-widget-results-box">
		</div>
		
		<?php
		echo '</form>';
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = $instance ? esc_attr($instance['title']) : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'google-apps-directory'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

}
