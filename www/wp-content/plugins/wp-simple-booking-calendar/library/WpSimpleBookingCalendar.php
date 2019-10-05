<?php
/**
 * @package WP Simple Booking Calendar
 *
 * Copyright (c) 2011 WP Simple Booking Calendar
 */

/**
 * WP Simple Booking Calendar
 */
class WpSimpleBookingCalendar
{
	/**
	 * Plugin initialization
	 * @return void
	 */
	public static function init()
	{
		// Backend hooks and action callbacks
		if (is_admin())
		{
			add_action('admin_menu', array( __CLASS__, 'init_admin_menu' ) );
		}
		else
		{
		  function enq_styles(){
		      wp_enqueue_style('sbc', SBC_DIR_URL . 'css/sbc.css');
			wp_enqueue_script('sbc', SBC_DIR_URL . 'js/sbc.js', array('jquery'));
		  }    
	      add_action('init', 'enq_styles');
		}
		
		// Register shortcode
		add_action('init', array( __CLASS__, 'init_shortcode' ) );
		
		// Register AJAX actions
		add_action('init', array( __CLASS__, 'init_ajax_actions' ) );
		
		// Register widget
		add_action('widgets_init', array( __CLASS__, 'init_widgets' ) );

	}

	/**
	 * Initializes the admin menu
	 *
	 */
	public static function init_admin_menu() {

		new WpSimpleBookingCalendar_Controller();

	}

	/**
	 * Initializes the shortcode
	 *
	 */
	public static function init_shortcode() {

		new WpSimpleBookingCalendar_Shortcode();

	}

	/**
	 * Initializes the ajax actions
	 *
	 */
	public static function init_ajax_actions() {

		new WpSimpleBookingCalendar_Ajax();

	}

	/**
	 * Initializes the widgets
	 *
	 */
	public static function init_widgets() {

		return register_widget( "WpSimpleBookingCalendar_Widget" );

	}

}