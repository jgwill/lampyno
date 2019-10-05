<?php
/**
 * Elementor WPRM Recipe Widget.
 *
 * Elementor widget for inserting WP Recipe Maker recipes.
 *
 * @since 5.0.0
 */
class WPRM_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 5.0.0
	 */
	public function get_name() {
		return 'wprm-recipe';
	}

	/**
	 * Get widget title.
	 * 
	 * @since 5.0.0
	 */
	public function get_title() {
		return 'WPRM Recipe';
	}

	/**
	 * Get widget icon.
	 *
	 * @since 5.0.0
	 */
	public function get_icon() {
		return 'fa fa-cutlery';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 5.0.0
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Register widget controls.
	 *
	 * @since 5.0.0
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => 'WP Recipe Maker',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'wrpm_create',
			array(
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '&gt; <a href="' . esc_url( admin_url( 'admin.php?page=wprecipemaker' ) ) .'" target="_blank">' . __( 'Create or edit Recipe', 'wp-recipe-maker' ) . '</a>',
			)
		);

		$this->add_control(
			'wprm_recipe_id',
			array(
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => false,
			)
		);

		$this->add_control(
			'wprm_recipe_select',
			array(
				'type' => 'wprm-recipe-select',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 5.0.0
	 */
	protected function render() {
		$id = intval( $this->get_settings_for_display( 'wprm_recipe_id' ) );
		
		if ( $id ) {
			// Output recipe.
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$output = '';

				// Get Template Style.
				$template = WPRM_Template_Manager::get_template_by_type( 'single' );
				if ( 'modern' === $template['mode'] ) {
					$output .= '<style type="text/css">' . WPRM_Template_Manager::get_template_css( $template ) . '</style>';
				} else {
					$output .= '<style type="text/css">' . WPRM_Assets::get_custom_css( 'recipe' ) . '</style>';
				}

				$output .= do_shortcode( '[wprm-recipe id="' . $id . '" template="' . $template['slug'] . '"]' );
			} else {
				$output = '[wprm-recipe id="' . $id . '"]';
			}

			echo $output;
		}
	}

}