<?php
/*
Plugin Name: Ultimate Reviews
Plugin URI: http://www.EtoileWebDesign.com/plugins/ultimate-reviews/
Description: Reviews plugin to let visitors submit reviews and display them via shortcode or widget. Replace WooCommerce reviews and ratings. Require login, etc.
Author: Etoile Web Design
Author URI: http://www.EtoileWebDesign.com/plugins/ultimate-reviews/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: ultimate-reviews
Version: 2.1.21
*/

global $ewd_urp_message;
global $URP_Full_Version;

$EWD_URP_Version = '2.1.0c';

define( 'EWD_URP_CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EWD_URP_CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//define('WP_DEBUG', true);

register_activation_hook(__FILE__,'Set_EWD_URP_Options');
register_activation_hook(__FILE__,'Run_URP_Tutorial');
register_activation_hook(__FILE__,'EWD_URP_Show_Dashboard_Link');

/* Hooks neccessary admin tasks */
if ( is_admin() ){
	add_action('admin_head', 'EWD_URP_Admin_Options');
	add_action('widgets_init', 'Update_EWD_URP_Content');
	add_action('admin_init', 'Add_EWD_URP_Scripts');
	add_action('admin_head', 'EWD_URP_Output_JS_Vars');
	add_action('admin_notices', 'EWD_URP_Error_Notices');
}

add_action('admin_menu', 'EWD_URP_Unapproved_Reviews');
function EWD_URP_Unapproved_Reviews($Title) {
	global $wpdb;
	global $menu;

	$Admin_Approval = get_option("EWD_URP_Admin_Approval");
	if ($Admin_Approval == "Yes") {
		$Unapproved_Reviews = $wpdb->get_results("SELECT ID FROM " . $wpdb->posts . " WHERE post_status='draft' and post_type='urp_review'");
		foreach ($menu as $key => $menu_item) {
			if ($menu_item[0] == "Reviews") {
				if ($menu_item[2] == "EWD-URP-Options") {
					if ($wpdb->num_rows != 0) {$menu[$key][0] .= " <span class='update-plugins count-2' title='Unapproved Reviews'><span class='update-count'>" . $wpdb->num_rows . "</span></span>";}
				}
			}
		}
	}
}

function EWD_URP_Enable_Sub_Menu() {
	global $submenu;

	$Admin_Approval = get_option("EWD_URP_Admin_Approval");

	add_menu_page( 'Ultimate Reviews', 'Reviews', 'edit_posts', 'EWD-URP-Options', 'EWD_URP_Output_Options', 'dashicons-star-filled', '49.1' );
	add_submenu_page('EWD-URP-Options', 'URP WooCommerce Import', 'Import', 'edit_posts', 'EWD-URP-Options&DisplayPage=WooCommerceImport', 'EWD_URP_Output_Options');
	if ($Admin_Approval == "Yes") {
		$submenu['EWD-URP-Options'][5] = $submenu['EWD-URP-Options'][1];
		$submenu['EWD-URP-Options'][1] = array( 'Approved Reviews', 'edit_posts', "edit.php?post_type=urp_review&post_status=publish", "Approved Reviews" );
		$submenu['EWD-URP-Options'][2] = array( 'Awaiting Approval', 'edit_posts', "edit.php?post_type=urp_review&post_status=draft", "Awaiting Approval" );
		$submenu['EWD-URP-Options'][3] = array( 'Add New', 'edit_posts', "post-new.php?post_type=urp_review", "Add New" );
		$submenu['EWD-URP-Options'][4] = array( 'Review Categories', 'manage_categories', "edit-tags.php?taxonomy=urp-review-category&post_type=urp_review", "Review Categories" );
	}
	else {
		$submenu['EWD-URP-Options'][4] = $submenu['EWD-URP-Options'][1];
		$submenu['EWD-URP-Options'][1] = array( 'Reviews', 'edit_posts', "edit.php?post_type=urp_review", "Reviews" );
		$submenu['EWD-URP-Options'][2] = array( 'Add New', 'edit_posts', "post-new.php?post_type=urp_review", "Add New" );
		$submenu['EWD-URP-Options'][3] = array( 'Review Categories', 'manage_categories', "edit-tags.php?taxonomy=urp-review-category&post_type=urp_review", "Review Categories" );
	}
	add_submenu_page('EWD-URP-Options', 'URP Options', 'Options', 'edit_posts', 'EWD-URP-Options&DisplayPage=Options', 'EWD_URP_Output_Options');

	$submenu['EWD-URP-Options'][0][0] = "Dashboard";
	ksort($submenu['EWD-URP-Options']);

	update_option("URP_SubMenus", $submenu);
}
add_action('admin_menu' , 'EWD_URP_Enable_Sub_Menu');

function EWD_URP_Add_Header_Bar($Called = "No") {
	global $pagenow;

	if ($Called != "Yes" and (!isset($_GET['post_type']) or $_GET['post_type'] != "urp_review")) {return;}

	$Admin_Approval = get_option("EWD_URP_Admin_Approval"); ?>

	<div class="EWD_URP_Menu">
		<h2 class="nav-tab-wrapper">
		<a id="ewd-urp-dash-mobile-menu-open" href="#" class="MenuTab nav-tab"><?php _e("MENU", 'ultimate-reviews'); ?><span id="ewd-urp-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-urp-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
		<a id="Dashboard_Menu" href='admin.php?page=EWD-URP-Options' class="MenuTab nav-tab <?php if (!isset($_GET['post_type']) and ($_GET['DisplayPage'] == '' or $_GET['DisplayPage'] == 'Dashboard')) {echo 'nav-tab-active';}?>"><?php _e("Dashboard", 'ultimate-reviews'); ?></a>
		<?php if ($Admin_Approval == "Yes") { ?>
			<a id="Approved_Reviews_Menu" href='edit.php?post_type=urp_review&post_status=publish' class="MenuTab nav-tab <?php if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and $pagenow == 'edit.php' and (!isset($_GET['post_status']) or $_GET['post_status'] == 'publish')) {echo 'nav-tab-active';}?>"><?php _e("Approved Reviews", 'ultimate-reviews'); ?></a>
			<a id="Awaiting_Approval_Menu" href='edit.php?post_type=urp_review&post_status=draft' class="MenuTab nav-tab <?php if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and $pagenow == 'edit.php' and $_GET['post_status'] == 'draft') {echo 'nav-tab-active';}?>"><?php _e("Awaiting Approval", 'ultimate-reviews'); ?></a>
		<?php } else { ?>
			<a id="Reviews_Menu" href='edit.php?post_type=urp_review' class="MenuTab nav-tab <?php if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and $pagenow == 'edit.php') {echo 'nav-tab-active';}?>"><?php _e("Reviews", 'ultimate-reviews'); ?></a>
		<?php } ?>
		<a id="Add_New_Menu" href='post-new.php?post_type=urp_review' class="MenuTab nav-tab <?php if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and $pagenow == 'post-new.php') {echo 'nav-tab-active';}?>"><?php _e("Add New", 'ultimate-reviews'); ?></a>
		<a id="Review_Categories_Menu" href='edit-tags.php?taxonomy=urp-review-category&post_type=urp_review' class="MenuTab nav-tab <?php if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and $pagenow == 'post-new.php') {echo 'nav-tab-active';}?>"><?php _e("Categories", 'ultimate-reviews'); ?></a>
		<a id="WooCommerce_Import_Menu" href='admin.php?page=EWD-URP-Options&DisplayPage=WooCommerceImport' class="MenuTab nav-tab <?php if (!isset($_GET['post_type']) and $_GET['DisplayPage'] == 'WooCommerceImport') {echo 'nav-tab-active';}?>"><?php _e("Import", 'ultimate-reviews'); ?></a>
		<a id="WooCommerce_Import_Menu" href='admin.php?page=EWD-URP-Options&DisplayPage=Export' class="MenuTab nav-tab <?php if (!isset($_GET['post_type']) and $_GET['DisplayPage'] == 'Export') {echo 'nav-tab-active';}?>"><?php _e("Export", 'ultimate-reviews'); ?></a>
		<a id="Options_Menu" href='admin.php?page=EWD-URP-Options&DisplayPage=Options' class="MenuTab nav-tab <?php if (!isset($_GET['post_type']) and $_GET['DisplayPage'] == 'Options') {echo 'nav-tab-active';}?>"><?php _e("Options", 'ultimate-reviews'); ?></a>
		</h2>
	</div>
<?php }
add_action('admin_notices', 'EWD_URP_Add_Header_Bar');

/* Add localization support */
function EWD_URP_localization_setup() {
		load_plugin_textdomain('ultimate-reviews', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('after_setup_theme', 'EWD_URP_localization_setup');

// Add settings link on plugin page
function EWD_URP_plugin_settings_link($links) {
  $settings_link = '<a href="admin.php?page=EWD-URP-Options">Settings</a>';
  array_unshift($links, $settings_link);
  return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'EWD_URP_plugin_settings_link' );

function Add_EWD_URP_Scripts() {
	global $EWD_URP_Version;

	wp_enqueue_script('ewd-urp-review-ask', plugins_url("js/ewd-urp-dashboard-review-ask.js", __FILE__), array('jquery'), $EWD_URP_Version);

	if ((isset($_GET['post_type']) && $_GET['post_type'] == 'urp_review') or (isset($_GET['page']) && $_GET['page'] == 'EWD-URP-Options')) {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script(  'jquery-ui-sortable' );
		$url_one = plugins_url("ultimate-reviews/js/Admin.js");
		wp_enqueue_script('PageSwitch', $url_one, array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), $EWD_URP_Version);
		wp_enqueue_script('spectrum', plugins_url("ultimate-reviews/js/spectrum.js"), array('jquery'));
	}

	if (isset($_GET['page']) && $_GET['page'] == 'ewd-urp-getting-started') {
		wp_enqueue_script('ewd-urp-getting-started', EWD_URP_CD_PLUGIN_URL . 'js/ewd-urp-getting-started.js', array('jquery'), $EWD_URP_Version);
		wp_enqueue_script('spectrum', EWD_URP_CD_PLUGIN_URL . 'js/spectrum.js', array('jquery'), $EWD_URP_Version);
		wp_enqueue_script('PageSwitch', EWD_URP_CD_PLUGIN_URL . 'js/Admin.js', array('jquery', 'jquery-ui-sortable', 'spectrum'), $EWD_URP_Version);
	}
}

function Add_EWD_URP_Admin_Datepicker($hook){
    global $post;
    global $EWD_URP_Version;
    
    if($hook == 'post-new.php' || $hook == 'post.php'){
        if('urp_review' === $post->post_type){     
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );
			wp_enqueue_style('ewd-urp-jquery-datepicker-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
			wp_enqueue_script('ewd-urp-jquery-datepicker', plugins_url( 'ultimate-reviews/js/ewd-urp-datepicker.js' ), array( 'jquery'));
        }
    }

    wp_enqueue_style( 'ewd-urp-welcome-screen', EWD_URP_CD_PLUGIN_URL . 'css/ewd-urp-welcome-screen.css', array(), $EWD_URP_Version);
}
add_action('admin_enqueue_scripts', 'Add_EWD_URP_Admin_Datepicker');

function EWD_URP_Output_JS_Vars() {
	global $URP_Full_Version;

	$Email_Messages_Array = get_option("EWD_URP_Email_Messages_Array");
	if (!is_array($Email_Messages_Array)) {$Email_Messages_Array = array();}

	$plugin = "ultimate-wp-mail/Main.php";
	$UWPM_Installed = is_plugin_active($plugin);

	$UWPM_Emails_Array = array();
	if ($UWPM_Installed) {
		$UWPM_Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
		foreach ($UWPM_Emails as $Email) {$UWPM_Emails_Array[] = array('ID' => $Email->ID, 'Name' => $Email->post_title);}
	}

	$Status_Array = array();
	if (function_exists('wc_get_order_statuses')) {
		$Statuses = wc_get_order_statuses();
		foreach ($Statuses as $key => $value) {$Status_Array[] = array("key" => $key, "value" => $value);}
	}
	else {$Statuses = array();}

	echo "<script type='text/javascript'>";
	echo "var urp_messages = " . json_encode($Email_Messages_Array) . ";\n";
	echo "var uwpm_emails = " . json_encode($UWPM_Emails_Array) . ";\n";
	echo "var urp_wc_statuses = " . json_encode($Status_Array) . ";\n";
	echo "</script>";
}

add_action( 'wp_enqueue_scripts', 'Add_EWD_URP_FrontEnd_Scripts' );
function Add_EWD_URP_FrontEnd_Scripts() {
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_script('jquery-ui-slider');

	wp_enqueue_script('ewd-urp-masonry-js', plugins_url( '/js/masonry.pkgd.min.js' , __FILE__ ), array( 'jquery'));

	wp_register_script('ewd-urp-js', plugins_url( '/js/ewd-urp-js.js' , __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-autocomplete', 'jquery-ui-slider' ));

	$Maximum_Score = get_option("EWD_URP_Maximum_Score");
	$Review_Character_Limit = get_option('EWD_URP_Review_Character_Limit');
	$Flag_Inappropriate = get_option("EWD_URP_Flag_Inappropriate");
	$Data_Array = array(	'maximum_score' => $Maximum_Score,
							'review_character_limit' => $Review_Character_Limit,
							'flag_inappropriate_enabled' => $Flag_Inappropriate
		);
	wp_localize_script( 'ewd-urp-js', 'ewd_urp_php_data', $Data_Array );
	wp_enqueue_script('ewd-urp-js');

	wp_register_script('ewd-urp-pie-graph-js', plugins_url( '/js/ewd-urp-pie-graph.js' , __FILE__ ), array( 'jquery'));
	$urp_Circle_Graph_Background_Color = get_option("EWD_urp_Circle_Graph_Background_Color");
	$urp_Circle_Graph_Fill_Color = get_option("EWD_urp_Circle_Graph_Fill_Color");
	$Pie_Data_Array = array(
		'maximum_score' => $Maximum_Score,
		'circle_graph_background_color' => $urp_Circle_Graph_Background_Color,
		'circle_graph_fill_color' => $urp_Circle_Graph_Fill_Color
	);
	wp_localize_script( 'ewd-urp-pie-graph-js', 'ewd_urp_pie_data', $Pie_Data_Array );
	wp_enqueue_script('ewd-urp-pie-graph-js');

	wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );
	wp_enqueue_style('ewd-urp-jquery-datepicker-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
	wp_enqueue_script('ewd-urp-jquery-datepicker', plugins_url( 'ultimate-reviews/js/ewd-urp-datepicker.js' ), array( 'jquery'));
}


add_action( 'wp_enqueue_scripts', 'EWD_URP_Add_Stylesheet' );
function EWD_URP_Add_Stylesheet() {
    global $URP_Full_Version;

    $Reviews_Skin = get_option("EWD_URP_Reviews_Skin");

    wp_enqueue_style( 'dashicons' );

    wp_register_style( 'ewd-urp-style', plugins_url('css/ewd-urp-styles.css', __FILE__) );
    wp_enqueue_style( 'ewd-urp-style' );

    wp_register_style( 'ewd-urp-jquery-ui', plugins_url('css/ewd-urp-jquery-ui.css', __FILE__) );
    wp_enqueue_style( 'ewd-urp-jquery-ui' );

    if ($Reviews_Skin != "Basic" and $Reviews_Skin != "") {
    	wp_register_style('ewd-urp-addtl-stylesheet', EWD_URP_CD_PLUGIN_URL . "css/addtl/" . $Reviews_Skin . ".css");
    	wp_enqueue_style('ewd-urp-addtl-stylesheet');
    }
}

function EWD_URP_Admin_Options() {
	global $EWD_URP_Version;

	wp_enqueue_style( 'ewd-urp-admin', plugins_url("ultimate-reviews/css/Admin.css"), array(), $EWD_URP_Version);
	wp_enqueue_style( 'spectrum', plugins_url("ultimate-reviews/css/spectrum.css"));
}

$PrettyLinks = get_option("EWD_URP_Pretty_Permalinks");
if ($PrettyLinks == "Yes") {
	add_filter( 'query_vars', 'EWD_URP_add_query_vars_filter' );
	add_filter('init', 'EWD_URP_Rewrite_Rules');
	update_option("EWD_URP_Update_RR_Rules", "No");
}

$Show_TinyMCE = get_option("EWD_URP_Show_TinyMCE");
if ($Show_TinyMCE == "Yes") {
	add_filter( 'mce_buttons', 'EWD_URP_Register_TinyMCE_Buttons' );
	add_filter( 'mce_external_plugins', 'EWD_URP_Register_TinyMCE_Javascript' );
	add_action('admin_head', 'EWD_URP_Output_TinyMCE_Vars');
}

function EWD_URP_Register_TinyMCE_Buttons( $buttons ) {
   array_push( $buttons, 'separator', 'URP_Shortcodes' );
   return $buttons;
}

function EWD_URP_Register_TinyMCE_Javascript( $plugin_array ) {
   $plugin_array['URP_Shortcodes'] = plugins_url( '/js/tinymce-plugin.js',__FILE__ );

   return $plugin_array;
}

function EWD_URP_Output_TinyMCE_Vars() {
   global $URP_Full_Version;
   $Products = EWD_URP_Get_All_Products();

   echo "<script type='text/javascript'>";
   echo "var urp_premium = '" . $URP_Full_Version . "';\n";
   echo "var urp_products = " . json_encode($Products) . ";\n";
   echo "</script>";
}

function EWD_URP_Get_All_Products() {
	global $wpdb;

    $Products = $wpdb->get_col("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='EWD_URP_Product_Name' and meta_value!=''");

    return $Products;
}

function Run_URP_Tutorial() {
	update_option("URP_Run_Tutorial", "Yes");
}

if (get_option("URP_Run_Tutorial") == "Yes" and isset($_GET['page']) and $_GET['page'] == 'EWD-URP-Options') {
	add_action( 'admin_enqueue_scripts', 'URP_Set_Pointers', 10, 1);
}

function URP_Set_Pointers($page) {
	  $Pointers = URP_Return_Pointers();

	  //Arguments: pointers php file, version (dots will be replaced), prefix
	  $manager = new URPPointersManager( $Pointers, '1.0', 'urp_admin_pointers' );
	  $manager->parse();
	  $pointers = $manager->filter( $page );
	  if ( empty( $pointers ) ) { // nothing to do if no pointers pass the filter
	    return;
	  }
	  wp_enqueue_style( 'wp-pointer' );
	  $js_url = plugins_url( 'js/ewd-urp-pointers.js', __FILE__ );
	  wp_enqueue_script( 'urp_admin_pointers', $js_url, array('wp-pointer'), NULL, TRUE );
	  //data to pass to javascript
	  $data = array(
	    'next_label' => __( 'Next' ),
	    'close_label' => __('Close'),
	    'pointers' => $pointers
	  );
	  wp_localize_script( 'urp_admin_pointers', 'MyAdminPointers', $data );
	update_option("URP_Run_Tutorial", "No");
}

function EWD_URP_Show_Dashboard_Link() {
	set_transient('ewd-urp-getting-started', true, 30);
}

//add_action('activated_plugin','save_urp_error');
function save_urp_error(){
		update_option('plugin_error',  ob_get_contents());
		file_put_contents("Error.txt", ob_get_contents());
}

function Set_EWD_URP_Options() {
	global $URP_Full_Version;

	$Default_Fields = array(
		array("CategoryName" => "Product Name (if applicable)", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Author", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Reviewer Email (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Title", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Image (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Video (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review", "CategoryRequired" => "Yes", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => ""),
		array("CategoryName" => "Review Category (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => "")
	);

	if (get_option("EWD_URP_Maximum_Score") == "") {update_option("EWD_URP_Maximum_Score", "5");}
	if (get_option("EWD_URP_Review_Style") == "") {update_option("EWD_URP_Review_Style", "Points");}
	if (get_option("EWD_URP_Review_Score_Input") == "") {update_option("EWD_URP_Review_Score_Input", "Stars");}
	if (get_option("EWD_URP_Review_Image") == "") {update_option("EWD_URP_Review_Image", "No");}
	if (get_option("EWD_URP_Review_Video") == "") {update_option("EWD_URP_Review_Video", "No");}
	if (get_option("EWD_URP_Review_Category") == "") {update_option("EWD_URP_Review_Category", "No");}
	if (get_option("EWD_URP_Review_Filtering") == "") {update_option("EWD_URP_Review_Filtering", array("Name","Score"));}
	if (get_option("EWD_URP_Submit_Review_Toggle") == "") {update_option("EWD_URP_Submit_Review_Toggle", "No");}
	if (get_option("EWD_URP_Allow_Reviews") == "") {update_option("EWD_URP_Allow_Reviews", array());}
	if (get_option("EWD_URP_InDepth_Reviews") == "") {update_option("EWD_URP_InDepth_Reviews", "No");}
	if (get_option("EWD_URP_Review_Categories_Array") == "") {update_option("EWD_URP_Review_Categories_Array", $Default_Fields);}
	if (get_option("EWD_URP_Autocomplete_Product_Names") == "") {update_option("EWD_URP_Autocomplete_Product_Names", "Yes");}
	if (get_option("EWD_URP_Restrict_Product_Names") == "") {update_option("EWD_URP_Restrict_Product_Names", "No");}
	if (get_option("EWD_URP_Product_Name_Input_Type") == "") {update_option("EWD_URP_Product_Name_Input_Type", "Text");}
	if (get_option("EWD_URP_UPCP_Integration") == "") {update_option("EWD_URP_UPCP_Integration", "No");}
	if (get_option("EWD_URP_Product_Names_Array") == "") {update_option("EWD_URP_Product_Names_Array", array());}
	if (get_option("EWD_URP_Link_To_Post") == "") {update_option("EWD_URP_Link_To_Post", "No");}
	if (get_option("EWD_URP_Display_Author") == "") {update_option("EWD_URP_Display_Author", "Yes");}
	if (get_option("EWD_URP_Display_Categories") == "") {update_option("EWD_URP_Display_Categories", "No");}
	if (get_option("EWD_URP_Display_Date") == "") {update_option("EWD_URP_Display_Date", "Yes");}
	if (get_option("EWD_URP_Author_Click_Filter") == "") {update_option("EWD_URP_Author_Click_Filter", "No");}
	if (get_option("EWD_URP_Flag_Inappropriate") == "") {update_option("EWD_URP_Flag_Inappropriate", "Yes");}
	if (get_option("EWD_URP_Review_Comments") == "") {update_option("EWD_URP_Review_Comments", "No");}
	if (get_option("EWD_URP_Reviews_Per_Page") == "") {update_option("EWD_URP_Reviews_Per_Page", "1000");}
	if (get_option("EWD_URP_Pagination_Location") == "") {update_option("EWD_URP_Pagination_Location", "Both");}
	if (get_option("EWD_URP_Show_TinyMCE") == "") {update_option("EWD_URP_Show_TinyMCE", "Yes");}

	if (get_option("EWD_URP_Review_Format") == "") {update_option("EWD_URP_Review_Format", "Standard");}
	if (get_option("EWD_URP_Summary_Statistics") == "") {update_option("EWD_URP_Summary_Statistics", "None");}
	if (get_option("EWD_URP_Summary_Clickable") == "") {update_option("EWD_URP_Summary_Clickable", "No");}
	if (get_option("EWD_URP_Display_Microdata") == "") {update_option("EWD_URP_Display_Microdata", "No");}
	if (get_option("EWD_URP_Pretty_Permalinks") == "") {update_option("EWD_URP_Pretty_Permalinks", "No");}
	if (get_option("EWD_URP_Thumbnail_Characters") == "") {update_option("EWD_URP_Thumbnail_Characters", "140");}
	if (get_option("EWD_URP_Read_More_AJAX") == "") {update_option("EWD_URP_Read_More_AJAX", "No");}
	if (get_option("EWD_URP_Review_Weights") == "") {update_option("EWD_URP_Review_Weights", "No");}
	if (get_option("EWD_URP_Review_Karma") == "") {update_option("EWD_URP_Review_Karma", "No");}
	if (get_option("EWD_URP_Use_Captcha") == "") {update_option("EWD_URP_Use_Captcha", "No");}
	if (get_option("EWD_URP_Infinite_Scroll") == "") {update_option("EWD_URP_Infinite_Scroll", "No");}
	if (get_option("EWD_URP_Admin_Notification") == "") {update_option("EWD_URP_Admin_Notification", "No");}
	if (get_option("EWD_URP_Admin_Approval") == "") {update_option("EWD_URP_Admin_Approval", "No");}
	if (get_option("EWD_URP_Require_Email") == "") {update_option("EWD_URP_Require_Email", "No");}
	if (get_option("EWD_URP_Email_Confirmation") == "") {update_option("EWD_URP_Email_Confirmation", "No");}
	if (get_option("EWD_URP_Display_On_Confirmation") == "") {update_option("EWD_URP_Display_On_Confirmation", "Yes");}
	if (get_option("EWD_URP_One_Review_Per_Product_Person") == "") {update_option("EWD_URP_One_Review_Per_Product_Person", "No");}
	if (get_option("EWD_URP_Require_Login") == "") {update_option("EWD_URP_Require_Login", "No");}
	if (get_option("EWD_URP_Login_Options") == "") {update_option("EWD_URP_Login_Options", array());}

	if (get_option("EWD_URP_Replace_WooCommerce_Reviews") == "") {update_option("EWD_URP_Replace_WooCommerce_Reviews", "No");}
	if (get_option("EWD_URP_WooCommerce_Review_Submit_First") == "") {update_option("EWD_URP_WooCommerce_Review_Submit_First", "No");}
	if (get_option("EWD_URP_Only_WooCommerce_Products") == "") {update_option("EWD_URP_Only_WooCommerce_Products", "No");}
	if (get_option("EWD_URP_WooCommerce_Review_Types") == "") {update_option("EWD_URP_WooCommerce_Review_Types", array("Default"));}
	if (get_option("EWD_URP_Override_WooCommerce_Theme") == "") {update_option("EWD_URP_Override_WooCommerce_Theme", "No");}
	if (get_option("EWD_URP_Display_WooCommerce_Verified") == "") {update_option("EWD_URP_Display_WooCommerce_Verified", "No");}
	if (get_option("EWD_URP_WooCommerce_Minimum_Days") == "") {update_option("EWD_URP_WooCommerce_Minimum_Days", 0);}
	if (get_option("EWD_URP_WooCommerce_Maximum_Days") == "") {update_option("EWD_URP_WooCommerce_Maximum_Days", 1000);}
	if (get_option("EWD_URP_Match_WooCommerce_Categories") == "") {update_option("EWD_URP_Match_WooCommerce_Categories", "No");}
	if (get_option("EWD_URP_WooCommerce_Category_Product_Reviews") == "") {update_option("EWD_URP_WooCommerce_Category_Product_Reviews", 0);}

	if (get_option("EWD_URP_Group_By_Product") == "") {update_option("EWD_URP_Group_By_Product", "No");}
	if (get_option("EWD_URP_Group_By_Product_Order") == "") {update_option("EWD_URP_Group_By_Product_Order", "ASC");}
	if (get_option("EWD_URP_Ordering_Type") == "") {update_option("EWD_URP_Ordering_Type", "Date");}
	if (get_option("EWD_URP_Order_Direction") == "") {update_option("EWD_URP_Order_Direction", "DESC");}

	if (get_option("EWD_URP_Reviews_Skin") == "") {update_option("EWD_URP_Reviews_Skin", "Basic");}
	if (get_option("EWD_URP_Display_Numerical_Score") == "") {update_option("EWD_URP_Display_Numerical_Score", "Yes");}

	if (get_option("EWD_URP_Install_Flag") == "") {update_option("EWD_URP_Install_Flag", "Yes");}
	if (get_option("EWD_URP_Install_Flag") == "") {update_option("EWD_URP_Install_Flag", "Yes");}

	if (get_option("EWD_URP_Read_More_Style") == "") {update_option("EWD_URP_Read_More_Style", "StandardLink");}

	if (get_option("EWD_URP_Install_Version") == "") {update_option("EWD_URP_Install_Version", 2.0);}
	if (get_option("EWD_URP_Install_Time") == "") {update_option("EWD_URP_Install_Time", time());}

	$Includes_Review_Category = false;
	$Review_Categories = get_option("EWD_URP_Review_Categories_Array");
	if (!is_array($Review_Categories)) {$Review_Categories = array();}
	foreach ($Review_Categories as $Review_Category) {
		if ($Review_Category['CategoryName'] == 'Review Category (if applicable)') {$Includes_Review_Category = true;}
	}

	if (!$Includes_Review_Category) {
		$Review_Categories[] = array("CategoryName" => "Review Category (if applicable)", "CategoryRequired" => "No", "ExplanationAllowed" => "No", "CategoryType" => "Default", "Options" => "");
		update_option("EWD_URP_Review_Categories_Array", $Review_Categories);
	}

	$Review_Categories = get_option("EWD_URP_Review_Categories_Array");
	$Unique_Categories = EWD_URP_unique_multidim_array($Review_Categories, 'CategoryName');
	update_option("EWD_URP_Review_Categories_Array", $Unique_Categories); 
}

$URP_Full_Version = get_option("EWD_URP_Full_Version");
if (isset($_GET['post_type']) and $_GET['post_type'] == 'urp_review' and isset($_GET['page']) and $_GET['page'] == "urp-options" and $URP_Full_Version != "Yes") {add_action("admin_notices", "EWD_URP_Upgrade_Box");}

if (isset($_POST['EWD_URP_Upgrade_To_Full'])) {
	add_action('admin_init', 'EWD_URP_Upgrade_To_Full');
}

function URP_Post_Edit_Styles( $hook_suffix ){
    $cpt = 'urp_review';
    if( in_array( $hook_suffix, array('post.php', 'post-new.php') ) ){
        $screen = get_current_screen();
        if( is_object( $screen ) && $cpt == $screen->post_type ){
            wp_enqueue_style( 'ewd-urp-post-edit-styles', plugins_url("ultimate-reviews/css/ewd-urp-post-edit-styles.css"));
        }
    }
}
add_action('admin_enqueue_scripts', 'URP_Post_Edit_Styles');

include "blocks/ewd-urp-blocks.php";
include "Functions/Error_Notices.php";
include "Functions/EWD_URP_Add_Views_Column.php";
include "Functions/EWD_URP_Captcha.php";
include "Functions/EWD_URP_Deactivation_Survey.php";
include "Functions/EWD_URP_Facebook_Config.php";
include "Functions/EWD_URP_Export.php";
include "Functions/EWD_URP_Help_Pointers.php";
include "Functions/EWD_URP_Helper_Functions.php";
include "Functions/EWD_URP_Import.php";
include "Functions/EWD_URP_Initial_Data.php";
include "Functions/EWD_URP_Output_Buffering.php";
include "Functions/EWD_URP_Output_Options.php";
include "Functions/EWD_URP_Pointers_Manager_Interface.php";
include "Functions/EWD_URP_Pointers_Manager_Class.php";
include "Functions/EWD_URP_Replace_WooCommerce_Reviews.php";
include "Functions/EWD_URP_Rewrite_Rules.php";
include "Functions/EWD_URP_Styling.php";
include "Functions/EWD_URP_Submit_Review.php";
include "Functions/EWD_URP_Twitter_Login.php";
include "Functions/EWD_URP_Upgrade_Box.php";
include "Functions/EWD_URP_Version_Reversion.php";
include "Functions/EWD_URP_Version_Update.php";
include "Functions/EWD_URP_Widgets.php";
include "Functions/EWD_URP_WooCommerce_Category_Sync.php";
include "Functions/EWD_URP_WooCommerce_Review_Import.php";
include "Functions/EWD_URP_WooCommerce_Review_Reminders.php";
include "Functions/FrontEndAjaxUrl.php";
include "Functions/Full_Upgrade.php";
include "Functions/Process_Ajax.php";
include "Functions/Register_EWD_URP_Posts_Taxonomies.php";
include "Functions/Update_EWD_URP_Admin_Databases.php";
include "Functions/Update_EWD_URP_Content.php";

include "Shortcodes/Display_Summary_Statistics.php";
include "Shortcodes/Display_URP_Search.php";
include "Shortcodes/DisplayReviews.php";
include "Shortcodes/SelectReview.php";
include "Shortcodes/SubmitReview.php";

if ($EWD_URP_Version != get_option('EWD_URP_Version')) {
	Set_EWD_URP_Options();
	EWD_URP_Version_Update();
}

function EWD_URP_unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 
?>
