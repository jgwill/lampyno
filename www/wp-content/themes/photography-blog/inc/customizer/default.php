<?php
/**
 * Default theme options.
 *
 * @package Photography blog
 */

if (!function_exists('photography_blog_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function photography_blog_get_default_theme_options() {

	$defaults = array();

	// Slider Section.
	$defaults['show_slider_section']           = 1;
	$defaults['number_of_home_slider']         = 3;
	$defaults['number_of_content_home_slider'] = 30;
	$defaults['select_slider_from']            = 'from-category';
    $defaults['select-page-for-slider']        = 0;
    $defaults['select_category_for_slider']    = 1;

    $defaults['enable_featured_page_section'] = 0;
    $defaults['select_featured_page'] = 0;
    $defaults['featured_page_button_text'] = esc_html__('VIEW MORE', 'photography-blog');
    $defaults['featured_page_additional_button_text'] = esc_html__('BUY NOW', 'photography-blog');
    $defaults['featured_page_additional_button_link'] = '';

    $defaults['enable_featured_blog'] = 0;
    $defaults['select_category_for_featured_blog'] = 1;

    /*layout*/
	$defaults['enable_overlay_option']    = 0;
	$defaults['homepage_layout_option']   = 'full-width';
	$defaults['read_more_button_text']    = esc_html__('Continue Reading', 'photography-blog');
	$defaults['global_layout']            = 'no-sidebar';
	$defaults['excerpt_length_global']    = 50;
	$defaults['pagination_type']          = 'default';
	$defaults['copyright_text']           = esc_html__('Copyright All rights reserved', 'photography-blog');

	// Pass through filter.
	$defaults = apply_filters('photography_blog_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;