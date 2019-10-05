<?php
/*
Plugin Name: Feedback
Plugin URI: http://www.socialintents.com
Description: Feedback helps you improve your product with private, unbiased feedback. To get started: 1) Click the "Activate" link to the left of this description, 2) Go to your Feedback plugin Settings page, and click Get My API Key.
Version: 1.3.39
Author: Social Intents
Author URI: http://www.socialintents.com/
*/

$siuf_domain = plugins_url();
add_action('init', 'siuf_init');
add_action('admin_notices', 'siuf_notice');
add_filter('plugin_action_links', 'siuf_plugin_actions', 10, 2);
add_action('wp_footer', 'siuf_insert',4);
add_action('admin_footer', 'siufRedirect');

define('SIUF_DASHBOARD_URL', "https://www.socialintents.com/dashboard.do");
define('SIUF_SMALL_LOGO',plugin_dir_url( __FILE__ ).'si-small.png');


function siuf_init() {
    if(function_exists('current_user_can') && current_user_can('manage_options')) {
        add_action('admin_menu', 'siuf_add_settings_page');
	add_action('admin_menu', 'siuf_create_menu');
    }
}

function siuf_insert() {
    global $current_user;
    if(strlen(get_option('siuf_widgetID')) == 32 ) {
	echo("\n\n<!-- Feedback by www.socialintents.com -->\n<script type=\"text/javascript\">\n");
        
	echo("(function() {function socialintents(){\n");
        echo("    var siJsHost = ((\"https:\" === document.location.protocol) ? \"https://\" : \"http://\");\n");
        echo("    var s = document.createElement('script');s.type = 'text/javascript';s.async = true;s.src = siJsHost+'www.socialintents.com/api/fb/socialintents.1.3.js#".get_option('siuf_widgetID')."';\n");
        
        echo("    var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};\n");
        echo("if (window.attachEvent)window.attachEvent('onload', socialintents);else window.addEventListener('load', socialintents, false);})();\n");
        echo("</script>\n");
    }

    
}

function siuf_notice() {
    if(!get_option('siuf_widgetID')) echo('<div class="error"><p><strong>'.sprintf(__('Your Feedback Plugin is disabled. Please go to the <a href="%s">plugin settings</a> to enter a valid widget key.  Find your widget key by logging in at www.socialintents.com and selecting your App Settings.  New to socialintents.com?  <a href="http://www.socialintents.com">Sign up for a Free Trial!</a>' ), admin_url('options-general.php?page=user-feedback-and-ratings-by-social-intents')).'</strong></p></div>');
}

function siuf_plugin_actions($links, $file) {
    static $this_plugin;
    $siuf_domain = plugins_url();
    if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
    if($file == $this_plugin && function_exists('admin_url')) {
        $settings_link = '<a href="'.admin_url('options-general.php?page=user-feedback-and-ratings-by-social-intents').'">'.__('Settings', $siuf_domain).'</a>';
        array_unshift($links, $settings_link);
    }
    return($links);
}

function siuf_add_settings_page() {
    function siuf_settings_page() {
        global $siuf_domain ?>
<div class="wrap">
        <?php screen_icon() ?>
    <h2><?php _e('Feedback by Social Intents', $siuf_domain) ?></h2>
    <div class="metabox-holder meta-box-sortables ui-sortable pointer">
        <div class="postbox" style="float:left;width:30em;margin-right:10px">
            <h3 class="hndle"><span><?php _e('Feedback Settings', $siuf_domain) ?></span></h3> 
            <div class="inside" style="padding: 0 10px">
                <form id="saveSettings" method="post" action="options.php">
                    <p style="text-align:center"><?php wp_nonce_field('update-options') ?>
			<a href="http://www.socialintents.com/" title="Feedback and Apps that help grow your business">
			<?php echo '<img src="'.plugins_url( 'socialintents.png' , __FILE__ ).'" height="150"  "/> ';?></a></p>

                    <p><label for="siuf_widgetID"><?php printf(__('Enter your Widget App Key below to activate the plugin.  If you don\'t have your key but have already signed up, you can <a href=\'http://www.socialintents.com\' target=\'_blank\'>login here</a> to grab your key under your Apps --> Feedback --> Your App Key.<br>', $siuf_domain), '<strong><a href="http://www.socialintents.com/" title="', '">', '</a></strong>') ?></label><br />
			<input type="text" name="siuf_widgetID" id="siuf_widgetID" placeholder="Your Widget Key" value="<?php echo(get_option('siuf_widgetID')) ?>" style="width:100%" />
		    
			<input type="hidden" name="siuf_tab_text" id="siuf_tab_text" value="Leave Feedback"/>
                    <p class="submit" style="padding:0"><input type="hidden" name="action" value="update" />
                        <input type="hidden" name="page_options" value="siuf_widgetID,siuf_tab_text" />
                        <input type="submit" name="siuf_submit" id="siuf_submit" value="<?php _e('Save Settings', $siuf_domain) ?>" class="button-primary" /> 
			</p>
                 </form>
            </div>
        </div>
        <div class="postbox" style="float:left;width:38em">
            <h3 class="hndle"><span id="siuf_noAccountSpan"><?php _e('No Account?  Sign up for a Free Social Intents Trial!', $siuf_domain) ?></span></h3>
            <div id="siuf_register" class="inside" style="padding: -30px 10px">			
		<p><?php printf(__('Social Intents is a user  feedback and social widgets platform that helps you engage visitors and grow your business with simple, effective plugins.
			Please visit %1$sSocial Intents%2$ssocialintents.com%3$s to 
				learn more.', $siuf_domain), '<a href="
http://www.socialintents.com/" title="', '">', '</a>') ?></p>
			<b>Sign Up For a Free Trial Now!</b> (or register directly on our site at <a href="http://www.socialintents.com" target="_blank">Social Intents</a>)<br>
			<input type="text" name="siuf_email" id="siuf_email" value="<?php echo(get_option('admin_email')) ?>" placeholder="Your Email" style="width:50%;margin:3px;" />
			<input type="text" name="siuf_name" id="siuf_name" value="<?php echo(get_option('user_nicename')) ?>" placeholder="Your Name" style="width:50%;margin:3px;" />
			<input type="password" name="siuf_password" id="siuf_password" value="" placeholder="Your Password" style="width:50%;margin:3px;" />
			<br><input type="button" name="siuf_inputRegister" id="siuf_inputRegister" value="Register" class="button-primary" style="margin:3px;" /> 
			
			
               
            </div>
	    <div id="siuf_registerComplete" class="inside" style="padding: -20px 10px;display:none;">
		<p>View feedback responses and customize advanced settings on our website at <a href='http://www.socialintents.com'>www.socialintents.com</a>
		</p>
		<p><a href='https://www.socialintents.com/dashboard.do' class="button button-primary" target="_blank">Feedback Dashboard</a>&nbsp;
			<a href='https://www.socialintents.com/widget.do?id=<?php echo(get_option('siuf_widgetID')) ?>' class="button button-primary" target="_blank">Advanced Settings</a>
		</p><form id='saveDetailSettings' method="post" action="options.php">
		<?php wp_nonce_field('update-options') ?>
		<input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="siuf_tab_text,siuf_tab_type,siuf_header_text,siuf_intro_text,siuf_rating_text,siuf_feedback_text,siuf_time_on_page,siuf_tab_color" />
		<table width="100%" >
		<tr><td width="25%">Tab Text: </td>
		<td >
		<?php
		if(get_option('siuf_tab_text') ) {
     		?>
     			<input type="text" class="siuf_tab_text" name="siuf_tab_text" id="siuf_tab_text" value="<?php echo(get_option('siuf_tab_text')) ?>" style="margin:3px;width:100%;" />
		
    		<?php 
			} else {
   		?>
			<input type="text" class="siuf_tab_text" name="siuf_tab_text" id="siuf_tab_text" value="Leave Feedback" style="margin:3px;width:100%;" />
		<?php 
			}
   		?>
		</td>
		</tr>
		<tr><td width="25%">Tab Color: </td>
		<td >
		<?php
		if(get_option('siuf_tab_color') && get_option('siuf_tab_color') != '') {
     		?>
     			<input type="text" name="siuf_tab_color" id="siuf_tab_color" value="<?php echo(get_option('siuf_tab_color')) ?>" style="margin:3px;width:100%;" />
		
    		<?php 
			} else {
   		?>
			<input type="text" name="siuf_tab_color" id="siuf_tab_color" value="#00AEEF" style="margin:3px;width:100%;" />
		<?php 
			}
   		?>
		</td>
		</tr>
		<tr><td>Tab Type: </td><td>
		<?php 
		if(get_option('siuf_tab_type') == '') {
     		?>
     		<select id="siuf_tab_type" name="siuf_tab_type">
			<option value="" selected>Tab with Text</option>
			<option value="circle">Floating Circle with Icon</option>
		</select> 	
    		<?php 
			} else if(get_option('siuf_tab_type') == 'circle') {
   		?>
		<select id="siuf_tab_type" name="siuf_tab_type">
			<option value="">Tab with Text</option>
			<option value="circle" selected>Floating Circle with Feedback Icon</option>
		</select> 
		<?php 
			}
   		?>
		
		</td></tr>
		<tr><td>Auto Trigger Popup: </td><td>
		<?php 
		if(get_option('siuf_time_on_page') == '0') {
     		?>
     		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0" selected>Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 	
    		<?php 
			} else if(get_option('siuf_time_on_page') == '-1') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1" selected>Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 
		<?php 
			} else if(get_option('siuf_time_on_page') == '10') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10"  selected>10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select>  
		<?php 
			} else if(get_option('siuf_time_on_page') == '15') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15"  selected>15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 
		<?php 
			} else if(get_option('siuf_time_on_page') == '20') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20"   selected>20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 
		<?php 
			} else if(get_option('siuf_time_on_page') == '30') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20" >20 Seconds</option>
			<option value="30"  selected>30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 
		<?php 
			} else if(get_option('siuf_time_on_page') == '45') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20" >20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45"  selected>45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select> 
		<?php 
			} else if(get_option('siuf_time_on_page') == '60') {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1">Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60"  selected>60 Seconds</option>
		</select>  
		<?php 
			} else {
   		?>
		<select id="siuf_time_on_page" name="siuf_time_on_page">
			<option value="0">Immediately</option>
			<option value="-1" selected>Don't Auto Pop</option>
			<option value="10">10 Seconds</option>
			<option value="15">15 Seconds</option>
			<option value="20">20 Seconds</option>
			<option value="30">30 Seconds</option>
			<option value="45">45 Seconds</option>
			<option value="60">60 Seconds</option>
		</select>  
		<?php 
			}
   		?>
		
		</td></tr>
		<tr><td>Header Text: </td><td>
		<?php 
		if(get_option('siuf_header_text') && get_option('siuf_header_text') != '') {
     		?>
     		<input type="text" name="siuf_header_text" id="siuf_header_text" value="<?php echo(get_option('siuf_header_text')) ?>" style="margin:3px;width:100%;" />
		
    		<?php 
			} else {
   		?>
		<input type="text" name="siuf_header_text" id="siuf_header_text" value="Have Feedback or a Question For Us?" style="margin:3px;width:100%;" />
		<?php 
			}
   		?>
		</td></tr>
		<tr><td>Intro Text: </td>
		<td>
		<?php 
		if(get_option('siuf_intro_text') && get_option('siuf_intro_text') != '') {
     		?>
     		<textarea rows="2" name="siuf_intro_text" id="siuf_intro_text" style="margin:3px;width:100%;"><?php echo(get_option('siuf_intro_text')) ?></textarea>
		<?php 
			} else {
   		?>
		<textarea rows="2" name="siuf_intro_text" id="siuf_intro_text" style="margin:3px;width:100%;">Hello, we'd love to hear your thoughts about our Website</textarea>
		<?php 
			}
   		?>
		</td></tr>

		<tr><td>Rating Question: </td>
		<td>
		<?php 
		if(get_option('siuf_rating_text') && get_option('siuf_rating_text') != '') {
     		?>
     		<textarea rows="2" name="siuf_rating_text" id="siuf_rating_text" style="margin:3px;width:100%;"><?php echo(get_option('siuf_rating_text')) ?></textarea>
		<?php 
			} else {
   		?>
		<textarea rows="2" name="siuf_rating_text" id="siuf_rating_text" style="margin:3px;width:100%;">How likely would you be to recommend us to your friends?</textarea>
		<?php 
			}
   		?>
		</td></tr>

		<tr><td>Prompt for Feedback: </td>
		<td>
		<?php 
		if(get_option('siuf_feedback_text') && get_option('siuf_feedback_text') != '') {
     		?>
     		<textarea rows="2" name="siuf_feedback_text" id="siuf_feedback_text" style="margin:3px;width:100%;"><?php echo(get_option('siuf_feedback_text')) ?></textarea>
		<?php 
			} else {
   		?>
		<textarea rows="2" name="siuf_feedback_text" id="siuf_feedback_text" style="margin:3px;width:100%;">How can we improve our website?  Do you have ideas, questions, or need help?  Let us know!</textarea>
		<?php 
			}
   		?>
		</td></tr>


		<tr><td></td><td>
		<input id='siuf_inputSaveSettings' type="button" value="<?php _e('Save Settings', $siuf_domain) ?>" class="button-primary" /> 
		<br><small >If you don't see your latest settings reflected in your site, please refresh your browser cache
		or close and open the browser.
		</small>	
		</td></tr>
		</table> 
			
		</form>
	    </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {

var siuf_wid= $('#siuf_widgetID').val();
if (siuf_wid=='') 
{}
else
{
	$( "#siuf_register" ).hide();
	$( "#siuf_registerComplete" ).show();
	$( "#siuf_noAccountSpan" ).html("Configure your User Feedback and Ratings Widget");

}
$(document).on("click", "#siuf_inputSaveSettings", function () {

var siuf_wid= $('#siuf_widgetID').val();
var siuf_tt= encodeURIComponent($('.siuf_tab_text').val());
var siuf_ht= encodeURIComponent($('#siuf_header_text').val());
var siuf_intro= encodeURIComponent($('#siuf_intro_text').val());
var siuf_rating= encodeURIComponent($('#siuf_rating_text').val());
var siuf_fb= encodeURIComponent($('#siuf_feedback_text').val());

var siuf_ww= $('#siuf_popup_width').val();
var siuf_wh= $('#siuf_popup_height').val();
var siuf_rc= $('#siuf_rounded_corners').val();

var siuf_tp= $('#siuf_tab_type').val();
var siuf_top= $('#siuf_time_on_page').val();
var url = 'https://www.socialintents.com/json/jsonSaveFeedbackSettings.jsp?tt='+siuf_tt+'&wh='+siuf_wh+'&ww='+siuf_ww+'&ht='+siuf_ht+'&wid='+siuf_wid+'&intro='+siuf_intro+'&rate='+siuf_rating+'&fb='+siuf_fb+'&rc='+siuf_rc
+'&tp='+siuf_tp+'&top='+siuf_top+'&callback=?';


sessionStorage.removeItem("si_settings");
$.ajax({
   type: 'GET',
    url: url,
    async: false,
    jsonpCallback: 'jsonCallBack',
    contentType: "application/json",
    dataType: 'jsonp',
    success: function(json) {
       $('#siuf_widgetID').val(json.key);
	sessionStorage.removeItem("si_settings");
	sessionStorage.setItem("si_hasSeenPopup","false");
	sessionStorage.removeItem("socialintents_vs_feedback");
	$( "#saveDetailSettings" ).submit();
	
    },
    error: function(e) {
    }
});

  });

$(document).on("click", "#siuf_inputRegister", function () {

var siuf_email= $('#siuf_email').val();
var siuf_name= $('#siuf_name').val();
var siuf_password= $('#siuf_password').val();
var url = 'https://www.socialintents.com/json/jsonSignup.jsp?type=feedback&name='+siuf_name+'&email='+siuf_email+'&pw='+siuf_password+'&callback=?';
$.ajax({
   type: 'GET',
    url: url,
    async: false,
    jsonpCallback: 'jsonCallBack',
    contentType: "application/json",
    dataType: 'jsonp',
    success: function(json) {
	if (json.msg=='') {
         	$('#siuf_widgetID').val(json.key);
		alert("Thanks for signing up!");
		$( "#saveSettings" ).submit();
		
	}
	else {
		alert(json.msg);
	}
    },
    error: function(e) {
       
    }
});

});
});

</script>
    <?php }
    $siuf_domain = plugins_url();
    add_submenu_page('options-general.php', __('Social Intents', $siuf_domain), __('Social Intents', $siuf_domain), 'manage_options', 'user-feedback-and-ratings-by-social-intents', 'siuf_settings_page');
}
function addSiufLink() {
$dir = plugin_dir_path(__FILE__);
include $dir . 'options.php';
}
function siuf_create_menu() {
  $optionPage = add_menu_page('Feedback', 'Feedback', 'administrator', 'siuf_dashboard', 'addSiufLink', plugins_url('user-feedback-and-ratings-by-social-intents/si-small.png'));
}
function siufRedirect() {
$redirectUrl = "https://www.socialintents.com/dashboard.do";
echo "<script> jQuery('a[href=\"admin.php?page=siuf_dashboard\"]').attr('href', '".$redirectUrl."').attr('target', '_blank') </script>";
}
?>
