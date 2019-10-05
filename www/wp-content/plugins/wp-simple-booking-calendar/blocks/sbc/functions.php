<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Function that register the needed categories for the different block
 * available in the plugin
 *
 */
if( ! function_exists( 'wpsbc_register_block_categories' ) ) {

	function wpsbc_register_block_categories( $categories, $post ) {

		/**
		 * Filter the post types where the blocks are available
		 *
		 * @param array
		 *
		 */
		$post_types = apply_filters( 'wpsbc_register_block_categories_post_types', array( 'post', 'page' ) );

		if( ! in_array( $post->post_type, $post_types ) )
			return $categories;

		$categories[] = array(
			'slug'  => 'wp-simple-booking-calendar',
			'title' => 'WP Simple Booking Calendar',
			'icon'	=> ''
		);

		return $categories;

	}
	add_filter( 'block_categories', 'wpsbc_register_block_categories', 10, 2 );

}


/**
 * Adds the front-end files to the admin editor screen
 *
 */
function wpsbc_add_front_end_scripts() {

	if( ! function_exists( 'get_current_screen' ) )
		return;

	$screen = get_current_screen();

	if( is_null( $screen ) )
		return;

	/**
	 * Filter the post types where the calendar media button should appear
	 *
	 * @param array
	 *
	 */
	$post_types = apply_filters( 'wpsbc_register_block_categories_post_types', array( 'post', 'page' ) );

	if( ! in_array( $screen->post_type, $post_types ) )
	    return;


	// Enqueue front-end scripts on the admin part
	wp_register_script( 'sbc-front-end-script', SBC_DIR_URL . 'js/sbc.js', array( 'jquery' ), SBC_VERSION, true );
	wp_enqueue_script( 'sbc-front-end-script' );

	// Enqueue front-end styles on the admin part
	wp_register_style( 'sbc-front-end-style', SBC_DIR_URL . 'css/sbc.css', array(), SBC_VERSION );
	wp_enqueue_style( 'sbc-front-end-style' );

}
add_action( 'admin_enqueue_scripts', 'wpsbc_add_front_end_scripts', 10 );


/**
 * Registers the Single Calendar block
 *
 */
if( function_exists( 'register_block_type' ) ) {

	function wpsbc_register_block_type_sbc() {

		wp_register_script( 'sbc-script-block-sbc', SBC_DIR_URL . 'blocks/sbc/assets/js/script-block-sbc.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n' ) );

		register_block_type(
			'wp-simple-booking-calendar/sbc', 
			array(
				'attributes' => array(
					'title' => array(
						'type' => 'string'
					)
				),
				'editor_script'   => 'sbc-script-block-sbc', 
				'render_callback' => 'wpsbc_block_to_shortcode_sbc'
			)	
		);

	}
	add_action( 'init', 'wpsbc_register_block_type_sbc' );

}


/**
 * Render callback for the server render block
 * Transforms the attributes from the blocks into the needed shortcode arguments
 *
 * @param array $args
 *
 * @return string
 *
 */
function wpsbc_block_to_shortcode_sbc( $args ) {

	$atts = (array) $args;
		
	// Validate booleans
	$booleans = array('title');
	foreach ($booleans as $key)
	{
		if (isset($atts[$key]))
		{
			// Replace string values: Yes = true, No = false
			if (is_bool($atts[$key]) !== true)
			{
				$value = (strcasecmp($atts[$key], 'yes') == 0 || $atts[$key] == '1');
			}
			else
			{
				$value = $atts[$key];
			}
			
			$atts[$key] = $value;
		}
	}
	
	// Process attributes
	$defaults = array('id' => null, 'title' => true);
	$values   = shortcode_atts($defaults, $atts);

	$model  = new WpSimpleBookingCalendar_Model();
	$view   = new WpSimpleBookingCalendar_View();

	return $view->setTemplate('shortcode/sbc')
		->assign('showTitle', $values['title'])
		->assign('calendar', $model->getCalendar())
		->fetch();

}