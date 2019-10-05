<?php
      /*
      Plugin Name: Calendar Event
      Plugin URI: https://total-soft.com/wp-event-calendar/
      Description: Event Calendar plugin created for showing your events. Total-Soft Calendar is the best if you want to be original on your website.
      Author: totalsoft
      Version: 1.3.8
      Author URI: https://total-soft.com/
      License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
      */
	require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-Widget.php');
	require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-Ajax.php');
	add_action('wp_enqueue_scripts', 'TotalSoft_Cal_Widget_Style');

	function TotalSoft_Cal_Widget_Style(){
		wp_register_style('Total_Soft_Cal', plugins_url('/CSS/Total-Soft-Calendar-Widget.css',__FILE__ ));
		wp_enqueue_style('Total_Soft_Cal');
		wp_register_script('Total_Soft_Cal',plugins_url('/JS/Total-Soft-Calendar-Widget.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Total_Soft_Cal', 'object', array('ajaxurl' => admin_url('admin-ajax.php')));
		wp_enqueue_script('Total_Soft_Cal');
		wp_enqueue_script("jquery");

		wp_register_style('fontawesome-css', plugins_url('/CSS/totalsoft.css', __FILE__)); 
		wp_enqueue_style('fontawesome-css');
	}

	add_action('widgets_init', 'TotalSoft_Cal_Widget_Reg');

	function TotalSoft_Cal_Widget_Reg(){
		register_widget('Total_Soft_Cal');
	}

	add_action("admin_menu", 'TotalSoft_Cal_Admin_Menu');

	function TotalSoft_Cal_Admin_Menu(){
		$complete_url = wp_nonce_url( '', 'edit-menu_', 'TS_CalEv_Nonce' );
		add_menu_page('Admin Menu',__( 'Calendar', 'Total-Soft-Calendar' ), 'manage_options','Total_Soft_Cal' . $complete_url, 'Add_New_Calendar',plugins_url('/Images/admin.png',__FILE__));
		add_submenu_page('Total_Soft_Cal' . $complete_url, 'Admin Menu', __( 'Calendar Manager', 'Total-Soft-Calendar' ), 'manage_options', 'Total_Soft_Cal' . $complete_url, 'Add_New_Calendar');
		add_submenu_page('Total_Soft_Cal' . $complete_url, 'Admin Menu', __( 'Event Manager', 'Total-Soft-Calendar' ), 'manage_options', 'Total_Soft_Events' . $complete_url, 'Total_Soft_Event');
		add_submenu_page('Total_Soft_Cal' . $complete_url, 'Admin Menu', '<span id="TS_Cal_Sup">'. __( 'Support Forum', 'Total-Soft-Calendar' ).'</span>', 'manage_options', 'Total_Soft_Cal_Support', 'TS_Cal_Support');
		add_submenu_page('Total_Soft_Cal' . $complete_url, 'Admin Menu', __( 'Total Products', 'Total-Soft-Calendar' ), 'manage_options', 'Total_Soft_Products' . $complete_url, 'Total_Soft_Product_Cal');
	}

	add_action('admin_init', 'TotalSoft_Cal_Admin_Style');

	function TotalSoft_Cal_Admin_Style(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');

		wp_register_style('Total_Soft_Cal', plugins_url('/CSS/Total-Soft-Calendar-Admin.css',__FILE__));
		wp_enqueue_style('Total_Soft_Cal' );
		wp_register_script('Total_Soft_Cal', plugins_url('/JS/Total-Soft-Calendar-Admin.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Total_Soft_Cal','object', array('ajaxurl'=>admin_url('admin-ajax.php')));
		wp_enqueue_script('Total_Soft_Cal');
		wp_enqueue_script("jquery");
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');

		wp_register_style('fontawesome-css', plugins_url('/CSS/totalsoft.css', __FILE__)); 
		wp_enqueue_style('fontawesome-css');
	}

	add_action ('wp_loaded', 'Total_Soft_Cal_Suport');

	function Total_Soft_Cal_Suport()
	{
		if( $_GET['page'] != 'Total_Soft_Cal_Support' ){
			return;
		}
		$url = 'https://wordpress.org/support/plugin/calendar-event';
		wp_redirect($url);
		exit;
	}

	add_action( 'admin_footer', 'TS_Cal_Support_Blank' );
	function TS_Cal_Support_Blank()
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#TS_Cal_Sup').parent().attr('target','_blank');
			});
		</script>
		<?php
	}

	function Add_New_Calendar()
	{
		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-New.php');
	}
	function Total_Soft_Event()
	{
		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-Events.php');
	}
	function TS_Cal_Support() { }
	function TotalSoftCalInstall()
	{
		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-Install.php');
	}
	function Total_Soft_Product_Cal()
	{
		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Products.php');
	}
	register_activation_hook(__FILE__,'TotalSoftCalInstall');

	function Total_SoftCal_Short_ID($atts, $content = null)
	{
		$atts=shortcode_atts(
			array(
				"id"=>"1"
			),$atts
		);
		return Total_Soft_Draw_Cal($atts['id']);
	}
	add_shortcode('Total_Soft_Cal', 'Total_SoftCal_Short_ID');
	function Total_Soft_Draw_Cal($Cal)
	{
		ob_start();
			$args = shortcode_atts(array('name' => 'Widget Area','id'=>'','description'=>'','class'=>'','before_widget'=>'','after_widget'=>'','before_title'=>'','AFTER_TITLE'=>'','widget_id'=>'','widget_name'=>'Total Soft Calendar'), $Cal, 'Total_Soft_Cal' );
			$Total_Soft_Cal=new Total_Soft_Cal;

			$instance=array('Total_Soft_Cal'=>$Cal);
			$Total_Soft_Cal->widget($args,$instance);
			$cont[]= ob_get_contents();
		ob_end_clean();
		return $cont[0];
	}

	add_action('init', 'TotalSoft_textdomain');
	function TotalSoft_textdomain() 
	{
		$path = dirname(plugin_basename(__FILE__)) . '/languages/';
		$loaded = load_plugin_textdomain('Total-Soft-Calendar', false, $path);
		if ($_GET['page'] == basename(__FILE__) && !$loaded) {
			echo '<div class="error">Total-Soft-Calendar ' . __('Could not load the localization file: ' . $path, 'Total-Soft-Calendar') . '</div>';
			return;
		}
	}
	function TotalSoft_Cal_Color() 
	{
		wp_enqueue_script(
			'alpha-color-picker',
			plugins_url('/JS/alpha-color-picker.js', __FILE__),
			array( 'jquery', 'wp-color-picker' ), // You must include these here.
			null,
			true
		);
		wp_enqueue_style(
			'alpha-color-picker',
			plugins_url('/CSS/alpha-color-picker.css', __FILE__),
			array( 'wp-color-picker' ) // You must include these here.
		);
	}
	add_action( 'admin_enqueue_scripts', 'TotalSoft_Cal_Color' );

	function Total_Soft_Calendar_settings_link($links)
	{
		$forum_link   = '<a target="_blank" href="https://wordpress.org/support/plugin/calendar-event/"> Support </a>';
		$premium_link = '<a target="_blank" href="https://total-soft.com/wp-event-calendar/"> Pro Version </a>';
		array_push($links, $forum_link);
		array_push($links, $premium_link);
		return $links; 
	}

	$plugin = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin", 'Total_Soft_Calendar_settings_link' );

	function TS_Cal_Media_Button() {

		$img = plugins_url('/Images/admin.png',__FILE__);
		$container_id = 'TSCalendar';
		$title = 'Select Total Soft Calendar to insert into post';
		$button_text = 'TS Calendar';
		$context .= '<a class="button thickbox" title="' . $title . '" href="#TB_inline&inlineId=' . $container_id . '&width=400&height=240">
		<span class="wp-media-buttons-icon" style="background: url(' . $img . '); background-repeat: no-repeat; background-position: left bottom;background-size: 18px 18px;"></span>' . $button_text . '</a>';

		echo $context;
	}
	add_action( 'media_buttons', 'TS_Cal_Media_Button');
	add_action( 'admin_footer', 'TS_Cal_Media_Button_Content');

	function TS_Cal_Media_Button_Content()
	{
		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Calendar-Media.php');
	}

	if( isset($_GET['ts_cal_preview']) )
	{
		add_filter('the_content', 'TS_Cal_theContent');
		add_filter('template_include', 'TS_Cal_templateInclude');

		function TS_Cal_theContent()
		{
			if (!is_user_logged_in()) return 'Log In first in order to preview the Calendar.';
			ob_start();
				$args = shortcode_atts(array('name' => 'Widget Area','id'=>'','description'=>'','class'=>'','before_widget'=>'','after_widget'=>'','before_title'=>'','AFTER_TITLE'=>'','widget_id'=>'','widget_name'=>'Total Soft Calendar'), $_GET['ts_cal_preview'], 'Total_Soft_Cal' );
				$Total_Soft_Cal=new Total_Soft_Cal;

				$instance = array('Total_Soft_Cal'=>$_GET['ts_cal_preview']);
				$Total_Soft_Cal->widget($args,$instance);
				$cont[] = ob_get_contents();
			ob_end_clean();
			return $cont[0];
		}
		function TS_Cal_templateInclude()
		{
			return locate_template(array('page.php', 'single.php', 'index.php'));
		}
	}
?>