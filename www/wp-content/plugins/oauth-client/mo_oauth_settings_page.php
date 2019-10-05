<?php
include("views/instructions_page.php");

function mo_register() {

	$currenttab = "";
	if(isset($_GET['tab']))
		$currenttab = $_GET['tab'];
	?>
	<?php
		if(mo_oauth_is_curl_installed()==0){ ?>
			<p style="color:red;">(Warning: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled. Please install/enable it before you proceed.)</p>
		<?php
		}
		
		mo_oauth_client_menu($currenttab);
	?>

<div id="mo_oauth_settings">
	<?php
        if ( $currenttab == 'licensing' || ! get_option( 'mo_oauth_client_show_mo_server_message' ) ) {
            ?>
            <form name="f" method="post" action="" id="mo_oauth_client_mo_server_form">
                <input type="hidden" name="option" value="mo_oauth_client_mo_server_message"/>
                <div class="notice notice-info" style="padding-right: 38px;position: relative;">
                    <h4>If you are looking for an OAuth Server, you can try out <a href="https://idp.miniorange.com" target="_blank">miniOrange On-Premise OAuth Server</a>.</h4>
                    <button type="button" class="notice-dismiss" id="mo_oauth_client_mo_server"><span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>
            </form>
            <script>
                jQuery("#mo_oauth_client_mo_server").click(function () {
                    jQuery("#mo_oauth_client_mo_server_form").submit();
                });
            </script>
            <?php
        }
        ?>
	<div class="miniorange_container">
		<table style="width:100%;">
		<tr>
		<td style="vertical-align:top;width:65%;" class="mo_oauth_content">
		<?php
		if($currenttab == 'customization')
			mo_oauth_app_customization();
		else if($currenttab == 'signinsettings')
			mo_oauth_sign_in_settings();
		else if($currenttab == 'licensing')
			mo_oauth_licensing();
		else if($currenttab == 'reports')
			mo_oauth_client_reports();
		else if($currenttab == 'faq') {
			mo_oauth_faq(); 
		} else if($currenttab == 'login') {
			if (get_option ( 'verify_customer' ) == 'true') {
				mo_oauth_show_verify_password_page();
			} else if (trim ( get_option ( 'mo_oauth_admin_email' ) ) != '' && trim ( get_option ( 'mo_oauth_admin_api_key' ) ) == '' && get_option ( 'new_registration' ) != 'true') {
				mo_oauth_show_verify_password_page();
			} else if(get_option('mo_oauth_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_oauth_registration_status')=='MO_OTP_VALIDATION_FAILURE' ||get_option('mo_oauth_registration_status') ==  'MO_OTP_DELIVERED_SUCCESS_PHONE' ||get_option('mo_oauth_registration_status') == 'MO_OTP_DELIVERED_FAILURE_PHONE') {
				mo_oauth_show_otp_verification();
			} else {
				if(!mo_oauth_is_customer_registered()) {
					delete_option ( 'password_mismatch' );
					mo_oauth_show_new_registration_page();
				} else {
					mo_oauth_show_customer_info_page();
				}
			}
		} else
			mo_oauth_apps_config();
	?>
			</td>
			<?php if($currenttab != 'licensing') { ?>
				<td style="vertical-align:top;padding-left:1%;" class="mo_oauth_sidebar">
					<?php echo miniorange_support(); ?>
				</td>
			<?php } ?>
			</tr>
			</table>
		</div>
		<?php
}

function mo_oauth_faq()
{?>
<div class="mo_table_layout">
    <object type="text/html" data="https://faq.miniorange.com/kb/oauth-openid-connect/" width="100%" height="600px" > 
    </object>
</div>
	<?php
}

function mo_oauth_show_customer_info_page() {
	?>
	<div class="mo_table_layout" >
		<h2>Thank you for registering with miniOrange.</h2>

		<table border="1"
		   style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:85%">
		<tr>
			<td style="width:45%; padding: 10px;">miniOrange Account Email</td>
			<td style="width:55%; padding: 10px;"><?php echo get_option( 'mo_oauth_admin_email' ); ?></td>
		</tr>
		<tr>
			<td style="width:45%; padding: 10px;">Customer ID</td>
			<td style="width:55%; padding: 10px;"><?php echo get_option( 'mo_oauth_admin_customer_key' ) ?></td>
		</tr>
		</table>
		<br /><br />

	<table>
	<tr>
	<td>
	<form name="f1" method="post" action="" id="mo_oauth_goto_login_form">
		<input type="hidden" value="change_miniorange" name="option"/>
		<input type="submit" value="Change Email Address" class="button button-primary button-large"/>
	</form>
	</td><td>
	<a href="<?php echo add_query_arg( array( 'tab' => 'licensing' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>"><input type="button" class="button button-primary button-large" value="Check Licensing Plans"/></a>
	</td>
	</tr>
	</table>

				<br />
	</div>

	<?php
}

function mo_oauth_show_new_registration_page() {
	update_option ( 'new_registration', 'true' );
	$current_user = wp_get_current_user();
	?>
			<!--Register with miniOrange-->
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_oauth_register_customer" />
			<div class="mo_table_layout">
				<div id="toggle1" class="panel_toggle">
					<h3>Register with miniOrange</h3>
				</div>
				<div id="panel1">
					<!--<p><b>Register with miniOrange</b></p>-->
					<p>Please enter a valid Email ID that you have access to. You will be able to move forward after verifying an OTP that we will be sending to this email.
					</p>
					<table class="mo_settings_table">
						<tr>
							<td><b><font color="#FF0000">*</font>Email:</b></td>
							<td><input class="mo_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php echo get_option('mo_oauth_admin_email');?>" />
							</td>
						</tr>
						<tr class="hidden">
							<td><b><font color="#FF0000">*</font>Website/Company Name:</b></td>
							<td><input class="mo_table_textbox" type="text" name="company"
							required placeholder="Enter website or company name"
							value="<?php echo $_SERVER['SERVER_NAME']; ?>"/></td>
						</tr>
						<tr  class="hidden">
							<td><b>&nbsp;&nbsp;First Name:</b></td>
							<td><input class="mo_openid_table_textbox" type="text" name="fname"
							placeholder="Enter first name" value="<?php echo $current_user->user_firstname;?>" /></td>
						</tr>
						<tr class="hidden">
							<td><b>&nbsp;&nbsp;Last Name:</b></td>
							<td><input class="mo_openid_table_textbox" type="text" name="lname"
							placeholder="Enter last name" value="<?php echo $current_user->user_lastname;?>" /></td>
						</tr>

						<tr  class="hidden">
							<td><b>&nbsp;&nbsp;Phone number :</b></td>
							 <td><input class="mo_table_textbox" type="text" name="phone" pattern="[\+]?([0-9]{1,4})?\s?([0-9]{7,12})?" id="phone" title="Phone with country code eg. +1xxxxxxxxxx" placeholder="Phone with country code eg. +1xxxxxxxxxx" value="<?php echo get_option('mo_oauth_admin_phone');?>" />
							 This is an optional field. We will contact you only if you need support.</td>
							</tr>
						</tr>
						<tr  class="hidden">
							<td></td>
							<td>We will call only if you need support.</td>
						</tr>
						<tr>
							<td><b><font color="#FF0000">*</font>Password:</b></td>
							<td><input class="mo_table_textbox" required type="password"
								name="password" placeholder="Choose your password (Min. length 8)" /></td>
						</tr>
						<tr>
							<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
							<td><input class="mo_table_textbox" required type="password"
								name="confirmPassword" placeholder="Confirm your password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><br /><input type="submit" name="submit" value="Save" style="width:100px;"
								class="button button-primary button-large" /></td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		<script>
			jQuery("#phone").intlTelInput();
		</script>
		<?php
}
function mo_oauth_show_verify_password_page() {
	?>
			<!--Verify password with miniOrange-->
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_oauth_verify_customer" />
			<div class="mo_table_layout">
				<div id="toggle1" class="panel_toggle">
					<h3>Login with miniOrange</h3>
				</div>
				<p><b>It seems you already have an account with miniOrange. Please enter your miniOrange email and password.<br/> <a href="#mo_oauth_forgot_password_link">Click here if you forgot your password?</a></b></p>

				<div id="panel1">
					</p>
					<table class="mo_settings_table">
						<tr>
							<td><b><font color="#FF0000">*</font>Email:</b></td>
							<td><input class="mo_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php echo get_option('mo_oauth_admin_email');?>" /></td>
						</tr>
						<td><b><font color="#FF0000">*</font>Password:</b></td>
						<td><input class="mo_table_textbox" required type="password"
							name="password" placeholder="Choose your password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit"
								class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</form>

								<input type="button" name="back-button" id="mo_oauth_back_button" onclick="document.getElementById('mo_oauth_change_email_form').submit();" value="Back" class="button button-primary button-large" />

								<form id="mo_oauth_change_email_form" method="post" action="">
									<input type="hidden" name="option" value="mo_oauth_change_email" />
								</form></td>


							</td>
						</tr>
					</table>
				</div>
			</div>

		<form name="f" method="post" action="" id="mo_oauth_forgotpassword_form">
				<input type="hidden" name="option" value="mo_oauth_forgot_password_form_option"/>
		</form>
		<script>

			jQuery("a[href=\"#mo_oauth_forgot_password_link\"]").click(function(){
				jQuery("#mo_oauth_forgotpassword_form").submit();
			});
		</script>

		<?php
}

function mo_oauth_sign_in_settings(){
	?>
	<div class="mo_table_layout">
		<h2>Sign in options</h2> 
		<h4>Option 1: Use a Widget</h4>
		<ol>
			<li>Go to Appearances > Widgets.</li>
			<li>Select <b>"miniOrange OAuth"</b>. Drag and drop to your favourite location and save.</li>
		</ol>

		<h4>Option 2: Use a Shortcode <small class="mo_premium_feature">[STANDARD]</small></h4>
		<ul>
			<li>Place shortcode <b>[mo_oauth_login]</b> in wordpress pages or posts.</li>
		</ul>
	</div>
	
	<!--div class="mo_oauth_premium_option_text"><span style="color:red;">*</span>This is a premium feature. 
		<a href="admin.php?page=mo_oauth_settings&tab=licensing">Click Here</a> to see our full list of Premium Features.</div-->
	<div class="mo_table_layout ">
		<h3>Advanced Settings <small class="mo_premium_feature"> [PREMIUM]</small></h3>
		<!--br><br-->
		<form id="role_mapping_form" name="f" method="post" action="">
		<h4>Select Grant Type</h4>
		<input checked type="checkbox"> Authorization Code Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Password Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Client Credentials Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Implicit Grant&nbsp;&nbsp;
		<input disabled type="checkbox"> Refresh Token Grant
		<br><br><hr><br>
		<input disabled="true" type="checkbox"><strong> Restrict site to logged in users</strong> ( Users will be auto redirected to OAuth login if not logged in )
		<p><input disabled="true" type="checkbox"><strong> Open login window in Popup</strong></p>
		<p><input disabled="true" type="checkbox"> <strong> Auto register Users </strong>(If unchecked, only existing users will be able to log-in)</p>
		<p><input disabled type="checkbox"><b> Enable User Analytics </b><small style="color:red">[ENTERPRISE]</small></p>

		<table class="mo_oauth_client_mapping_table" style="width:90%">
			<tbody>
			<tr>
				<td><font style="font-size:13px;font-weight:bold;">Restricted Domains </font><br>(Comma separated domains ex. domain1.com,domain2.com etc)
				</td>
				<td><input disabled="true" type="text"placeholder="domain1.com,domain2.com" style="width:100%;" ></td>
			</tr>
			<tr>
				<td><font style="font-size:13px;font-weight:bold;">Custom redirect URL after login </font><br>(Keep blank in case you want users to redirect to page from where SSO originated)
				</td>
				<td><input disabled="true" type="text" placeholder="" style="width:100%;"></td>
			</tr>
			<tr>
				<td><font style="font-size:13px;font-weight:bold;">Custom redirect URL after logout </font>
				</td>
				<td><input disabled="true" type="text" style="width:100%;"></td>
			</tr>
			<tr>
				<td><font style="font-size:13px;font-weight:bold;">Dynamic Callback URL </font><small class="mo_premium_feature"> [ENTERPRISE]</small>
				</td>
				<td><input disabled type="text"  placeholder="Callback / Redirect URI" style="width:100%;"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>				
			<tr>
				<td><input disabled="true" type="submit" class="button button-primary button-large" value="Save Settings"></td>
				<td>&nbsp;</td>
			</tr>
		</tbody></table>
	</form>
	</div>
		
	<?php
}


function mo_oauth_client_menu($currenttab){
	?>
	
	<div class="wrap">
		<div><img style="float:left;" src="<?php echo plugin_dir_url( __FILE__ );?>/images/logo.png"></div>
		<h1>OAuth Client</h1>			
	</div>
				
	<div id="tab">
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php if($currenttab == '') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings">Configure OAuth</a>
		<a class="nav-tab <?php if($currenttab == 'customization') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=customization">Customizations</a>
		<?php if(get_option('mo_oauth_eveonline_enable') == 1 ){?><a class="nav-tab <?php if($currenttab == 'mo_oauth_eve_online_setup') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_eve_online_setup">Advanced EVE Online Settings</a><?php } ?>
		<a class="nav-tab <?php if($currenttab == 'signinsettings') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=signinsettings">Sign In Settings</a>
		<a class="nav-tab <?php if($currenttab == 'reports') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=reports">Reports</a>
		<a class="nav-tab <?php if($currenttab == 'faq') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=faq">Frequently Asked Questions [FAQ]</a>
		<a class="nav-tab <?php if($currenttab == 'login') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=login">Account Setup</a>
		<a class="nav-tab <?php if($currenttab == 'licensing') echo 'nav-tab-active';?>" href="admin.php?page=mo_oauth_settings&tab=licensing">Licensing Plans</a>
		</h2>
	</div>
<?php }

function mo_oauth_licensing(){
	$sssborder = 'none;';
	$sspborder = 'none;';
	$sseborder = 'none;';
	$mspborder = 'none;';
	$mseborder = 'none;';
	$msbborder = 'none;';

	echo '<style>.update-nag, .updated, .error, .is-dismissible, .notice, .notice-error { display: none; }</style>';
	?>
	<style>
		*, *::after, *::before {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}

		html {
			font-size: 62.5%;
		}

		html * {
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}

		.pricing-container {
			font-size: 1.6rem;
			font-family: "Open Sans", sans-serif;
			color: #fff;
		}

		/* --------------------------------

		Main Components

		-------------------------------- */
		.cd-header{
			margin-top:100px;
		}
		.cd-header>h1{
			text-align: center;
			color: #FFFFFF;
			font-size: 3.2rem;
		}

		.cd-pricing-container {
			width: 90%;
			max-width: 1170px;
			margin: 4em auto;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-container {
				margin: auto;
			}
			.cd-pricing-container.cd-full-width {
				width: 100%;
				max-width: none;
			}
		}

		.cd-pricing-switcher {
			text-align: center;
		}
		.cd-pricing-switcher .fieldset {
			display: inline-block;
			position: relative;
			border-radius: 50em;
			border: 1px solid #e97d68;
		}
		.cd-pricing-switcher input[type="radio"] {
			position: absolute;
			opacity: 0;
		}
		.cd-pricing-switcher label {
			position: relative;
			z-index: 1;
			display: inline-block;
			float: left;
			width: 160px;
			height: 40px;
			line-height: 40px;
			cursor: pointer;
			font-size: 1.4rem;
			color: #FFFFFF;
			font-size:18px;
		}
		.cd-pricing-switcher .cd-switch {
			/* floating background */
			position: absolute;
			top: 2px;
			left: 2px;
			height: 40px;
			width: 160px;
			background-color: black;
			border-radius: 50em;
			-webkit-transition: -webkit-transform 0.5s;
			-moz-transition: -moz-transform 0.5s;
			transition: transform 0.5s;
		}
		.cd-pricing-switcher input[type="radio"]:checked + label + .cd-switch,
		.cd-pricing-switcher input[type="radio"]:checked + label:nth-of-type(n) + .cd-switch {
			/* use label:nth-of-type(n) to fix a bug on safari with multiple adjacent-sibling selectors*/
			-webkit-transform: translateX(155px);
			-moz-transform: translateX(155px);
			-ms-transform: translateX(155px);
			-o-transform: translateX(155px);
			transform: translateX(155px);
		}

		.no-js .cd-pricing-switcher {
			display: none;
		}

		.cd-pricing-list {
			margin: 2em 0 0;
		}
		.cd-pricing-list > li {
			position: relative;
			margin-bottom: 1em;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-list {
				margin: 3em 0 0;
			}
			.cd-pricing-list:after {
				content: "";
				display: table;
				clear: both;
			}
			.cd-pricing-list > li {
				width: 35.3333333333%;
				float: left;
			}
			.cd-has-margins .cd-pricing-list > li {
				width: 32.3333333333%;
				float: left;
				margin-right: 1.5%;
			}
			.cd-has-margins .cd-pricing-list > li:last-of-type {
				margin-right: 0;
			}
		}

		.cd-pricing-wrapper {
			/* this is the item that rotates */
			overflow: show;
			position: relative;
		}



		.touch .cd-pricing-wrapper {
			/* fix a bug on IOS8 - rotating elements dissapear*/
			-webkit-perspective: 2000px;
			-moz-perspective: 2000px;
			perspective: 2000px;
		}
		.cd-pricing-wrapper.is-switched .is-visible {
			/* totate the tables - anticlockwise rotation */
			-webkit-transform: rotateY(180deg);
			-moz-transform: rotateY(180deg);
			-ms-transform: rotateY(180deg);
			-o-transform: rotateY(180deg);
			transform: rotateY(180deg);
			-webkit-animation: cd-rotate 0.5s;
			-moz-animation: cd-rotate 0.5s;
			animation: cd-rotate 0.5s;
		}
		.cd-pricing-wrapper.is-switched .is-hidden {
			/* totate the tables - anticlockwise rotation */
			-webkit-transform: rotateY(0);
			-moz-transform: rotateY(0);
			-ms-transform: rotateY(0);
			-o-transform: rotateY(0);
			transform: rotateY(0);
			-webkit-animation: cd-rotate-inverse 0.5s;
			-moz-animation: cd-rotate-inverse 0.5s;
			animation: cd-rotate-inverse 0.5s;
			opacity: 0;
		}
		.cd-pricing-wrapper.is-switched .is-selected {
			opacity: 1;
		}
		.cd-pricing-wrapper.is-switched.reverse-animation .is-visible {
			/* invert rotation direction - clockwise rotation */
			-webkit-transform: rotateY(-180deg);
			-moz-transform: rotateY(-180deg);
			-ms-transform: rotateY(-180deg);
			-o-transform: rotateY(-180deg);
			transform: rotateY(-180deg);
			-webkit-animation: cd-rotate-back 0.5s;
			-moz-animation: cd-rotate-back 0.5s;
			animation: cd-rotate-back 0.5s;
		}
		.cd-pricing-wrapper.is-switched.reverse-animation .is-hidden {
			/* invert rotation direction - clockwise rotation */
			-webkit-transform: rotateY(0);
			-moz-transform: rotateY(0);
			-ms-transform: rotateY(0);
			-o-transform: rotateY(0);
			transform: rotateY(0);
			-webkit-animation: cd-rotate-inverse-back 0.5s;
			-moz-animation: cd-rotate-inverse-back 0.5s;
			animation: cd-rotate-inverse-back 0.5s;
			opacity: 0;
		}
		.cd-pricing-wrapper.is-switched.reverse-animation .is-selected {
			opacity: 1;
		}
		.cd-pricing-wrapper > li {
			background-color: #FFFFFF;
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
			/* Firefox bug - 3D CSS transform, jagged edges */
			outline: 1px solid transparent;
		}
		.cd-pricing-wrapper > li::after {
			/* subtle gradient layer on the right - to indicate it's possible to scroll */
			content: '';
			position: absolute;
			top: 0;
			right: 0;
			height: 100%;
			width: 50px;
			pointer-events: none;
			background: -webkit-linear-gradient( right , #FFFFFF, rgba(255, 255, 255, 0));
			background: linear-gradient(to left, #FFFFFF, rgba(255, 255, 255, 0));
		}
		.cd-pricing-wrapper > li.is-ended::after {
			/* class added in jQuery - remove the gradient layer when it's no longer possible to scroll */
			display: none;
		}
		.cd-pricing-wrapper .is-visible {
			/* the front item, visible by default */
			position: relative;
			background-color: #f2f5f8;
		}
		.cd-pricing-wrapper .is-hidden {
			/* the hidden items, right behind the front one */
			position: absolute;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
			z-index: 1;
			-webkit-transform: rotateY(180deg);
			-moz-transform: rotateY(180deg);
			-ms-transform: rotateY(180deg);
			-o-transform: rotateY(180deg);
			transform: rotateY(180deg);
		}
		.cd-pricing-wrapper .is-selected {
			/* the next item that will be visible */
			z-index: 3 !important;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-wrapper > li::before {
				/* separator between pricing tables - visible when number of tables > 3 */
				content: '';
				position: absolute;
				z-index: 6;
				left: -1px;
				top: 50%;
				bottom: auto;
				-webkit-transform: translateY(-50%);
				-moz-transform: translateY(-50%);
				-ms-transform: translateY(-50%);
				-o-transform: translateY(-50%);
				transform: translateY(-50%);
				height: 50%;
				width: 1px;
				background-color: #b1d6e8;
			}
			.cd-pricing-wrapper > li::after {
				/* hide gradient layer */
				display: none;
			}
			.cd-popular .cd-pricing-wrapper > li {
				box-shadow: inset 0 0 0 3px #e97d68;
			}
			.cd-has-margins .cd-pricing-wrapper > li, .cd-has-margins .cd-popular .cd-pricing-wrapper > li {
				box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
			}
			.cd-secondary-theme .cd-pricing-wrapper > li {
				background: #3aa0d1;
				background: -webkit-linear-gradient( bottom , #3aa0d1, #3ad2d1);
				background: linear-gradient(to top, #3aa0d1, #3ad2d1);
			}
			.cd-secondary-theme .cd-popular .cd-pricing-wrapper > li {
				background: #e97d68;
				background: -webkit-linear-gradient( bottom , #e97d68, #e99b68);
				background: linear-gradient(to top, #e97d68, #e99b68);
				box-shadow: none;
			}
			:nth-of-type(1) > .cd-pricing-wrapper > li::before {
				/* hide table separator for the first table */
				display: none;
			}
			.cd-has-margins .cd-pricing-wrapper > li {
				border-radius: 4px 4px 6px 6px;
			}
			.cd-has-margins .cd-pricing-wrapper > li::before {
				display: none;
			}
		}
		@media only screen and (min-width: 1500px) {
			.cd-full-width .cd-pricing-wrapper > li {
				padding: 2.5em 0;
			}
		}

		.no-js .cd-pricing-wrapper .is-hidden {
			position: relative;
			-webkit-transform: rotateY(0);
			-moz-transform: rotateY(0);
			-ms-transform: rotateY(0);
			-o-transform: rotateY(0);
			transform: rotateY(0);
			margin-top: 1em;
		}

		@media only screen and (min-width: 768px) {
			.cd-popular .cd-pricing-wrapper > li::before {
				/* hide table separator for .cd-popular table */
				display: none;
			}

			.cd-popular + li .cd-pricing-wrapper > li::before {
				/* hide table separator for tables following .cd-popular table */
				display: none;
			}
		}
		.cd-pricing-header {
			position: relative;

			height: 80px;
			padding: 1em;
			pointer-events: none;
			background-color: #3aa0d1;
			color: #FFFFFF;
		}
		.cd-pricing-header h2 {
			margin-bottom: 3px;
			font-weight: 700;
			text-transform: uppercase;
		}
		.cd-popular .cd-pricing-header {
			background-color: #e97d68;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-header {
				height: auto;
				padding: 1.9em 0.9em 1.6em;
				pointer-events: auto;
				text-align: center;
				color: #2f6062;
				background-color: transparent;
			}
			.cd-popular .cd-pricing-header {
				color: #e97d68;
				background-color: transparent;
			}
			.cd-secondary-theme .cd-pricing-header {
				color: #FFFFFF;
			}
			.cd-pricing-header h2 {
				font-size: 1.8rem;
				letter-spacing: 2px;
			}
		}

		.cd-currency, .cd-value {
			font-size: 4rem;
			font-weight: 300;
		}

		.cd-duration {
			font-weight: 800;
			font-size: 1.3rem;
			color: #8dc8e4;
			text-transform: uppercase;
		}
		.user-label {
			font-weight: 700;
			font-size: 1.3rem;
			color: #8dc8e4;
			text-transform: uppercase;
		}
		.cd-popular .cd-duration {
			color: #f3b6ab;
		}
		.cd-duration::before {
			content: '/';
			margin-right: 2px;
		}

		@media only screen and (min-width: 768px) {
			.cd-value {
				font-size: 4rem;
				font-weight: 300;
			}

			.cd-contact {
				font-size: 3rem;

			}

			.cd-currency, .cd-duration {
				color: rgba(23, 61, 80, 0.4);
			}
			.cd-popular .cd-currency, .cd-popular .cd-duration {
				color: #e97d68;
			}
			.cd-secondary-theme .cd-currency, .cd-secondary-theme .cd-duration {
				color: #2e80a7;
			}
			.cd-secondary-theme .cd-popular .cd-currency, .cd-secondary-theme .cd-popular .cd-duration {
				color: #ba6453;
			}

			.cd-currency {
				display: inline-block;
				margin-top: 10px;
				vertical-align: top;
				font-size: 2rem;
				font-weight: 700;
			}

			.cd-duration {
				font-size: 1.4rem;
			}
		}
		.cd-pricing-body {
			overflow-x: auto;
			-webkit-overflow-scrolling: touch;
		}
		.is-switched .cd-pricing-body {
			/* fix a bug on Chrome Android */
			overflow: hidden;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-body {
				overflow-x: visible;
			}
		}

		.cd-pricing-features {
			width: 600px;
		}
		.cd-pricing-features:after {
			content: "";
			display: table;
			clear: both;
		}
		.cd-pricing-features li {
			width: 100px;
			float: left;
			padding: 1.6em 1em;
			font-size: 1.4rem;
			text-align: center;
			white-space: initial;

			line-height:1.4em;

			text-overflow: ellipsis;
			color: black;
			overflow-wrap: break-word;
			margin: 0 !important;

		}
		.cd-pricing-features em {
			display: block;
			margin-bottom: 5px;
			font-weight: 600;
			color: black;
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-features {
				width: auto;
				word-wrap: break-word;
			}
			.cd-pricing-features li {
				float: none;
				width: auto;
				padding: 1em;
				word-wrap: break-word;
			}
			.cd-popular .cd-pricing-features li {
				margin: 0 3px;
			}
			.cd-pricing-features li:nth-of-type(2n+1) {
				background-color: rgba(23, 61, 80, 0.06);
			}
			.cd-pricing-features em {
				display: inline-block;
				margin-bottom: 0;
				word-wrap: break-word;
			}
			.cd-has-margins .cd-popular .cd-pricing-features li, .cd-secondary-theme .cd-popular .cd-pricing-features li {
				margin: 0;
			}
			.cd-secondary-theme .cd-pricing-features li {
				color: #FFFFFF;
			}
			.cd-secondary-theme .cd-pricing-features li:nth-of-type(2n+1) {
				background-color: transparent;
			}
		}

		.cd-pricing-footer {
			position: absolute;
			z-index: 1;
			top: 0;
			left: 0;
			/* on mobile it covers the .cd-pricing-header */
			height: 80px;
			width: 100%;
		}
		.cd-pricing-footer::after {
			/* right arrow visible on mobile */
			content: '';
			position: absolute;
			right: 1em;
			top: 50%;
			bottom: auto;
			-webkit-transform: translateY(-50%);
			-moz-transform: translateY(-50%);
			-ms-transform: translateY(-50%);
			-o-transform: translateY(-50%);
			transform: translateY(-50%);
			height: 20px;
			width: 20px;
			background: url(../img/cd-icon-small-arrow.svg);
		}
		@media only screen and (min-width: 768px) {
			.cd-pricing-footer {
				position: relative;
				height: auto;
				padding: 1.8em 0;
				text-align: center;
			}
			.cd-pricing-footer::after {
				/* hide arrow */
				display: none;
			}
			.cd-has-margins .cd-pricing-footer {
				padding-bottom: 0;
			}
		}

		.cd-select {
			position: relative;
			z-index: 1;
			display: block;
			height: 100%;
			/* hide button text on mobile */
			overflow: hidden;
			text-indent: 100%;
			white-space: nowrap;
			color: transparent;
		}
		@media only screen and (min-width: 768px) {
			.cd-select {
				position: static;
				display: inline-block;
				height: auto;
				padding: 1.3em 3em;
				color: #FFFFFF;
				border-radius: 2px;
				background-color: #0c1f28;
				font-size: 1.4rem;
				text-indent: 0;
				text-transform: uppercase;
				letter-spacing: 2px;
			}
			.no-touch .cd-select:hover {
				background-color: #112e3c;
			}
			.cd-popular .cd-select {
				background-color: #e97d68;
			}
			.no-touch .cd-popular .cd-select:hover {
				background-color: #ec907e;
			}
			.cd-secondary-theme .cd-popular .cd-select {
				background-color: #0c1f28;
			}
			.no-touch .cd-secondary-theme .cd-popular .cd-select:hover {
				background-color: #112e3c;
			}
			.cd-has-margins .cd-select {
				display: block;
				padding: 1.7em 0;
				border-radius: 0 0 4px 4px;
			}
		}
		/* --------------------------------

		xkeyframes

		-------------------------------- */
		@-webkit-keyframes cd-rotate {
			0% {
				-webkit-transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(200deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(180deg);
			}
		}
		@-moz-keyframes cd-rotate {
			0% {
				-moz-transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-moz-transform: perspective(2000px) rotateY(200deg);
			}
			100% {
				-moz-transform: perspective(2000px) rotateY(180deg);
			}
		}
		@keyframes cd-rotate {
			0% {
				-webkit-transform: perspective(2000px) rotateY(0);
				-moz-transform: perspective(2000px) rotateY(0);
				-ms-transform: perspective(2000px) rotateY(0);
				-o-transform: perspective(2000px) rotateY(0);
				transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(200deg);
				-moz-transform: perspective(2000px) rotateY(200deg);
				-ms-transform: perspective(2000px) rotateY(200deg);
				-o-transform: perspective(2000px) rotateY(200deg);
				transform: perspective(2000px) rotateY(200deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(180deg);
				-moz-transform: perspective(2000px) rotateY(180deg);
				-ms-transform: perspective(2000px) rotateY(180deg);
				-o-transform: perspective(2000px) rotateY(180deg);
				transform: perspective(2000px) rotateY(180deg);
			}
		}
		@-webkit-keyframes cd-rotate-inverse {
			0% {
				-webkit-transform: perspective(2000px) rotateY(-180deg);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(20deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(0);
			}
		}
		@-moz-keyframes cd-rotate-inverse {
			0% {
				-moz-transform: perspective(2000px) rotateY(-180deg);
			}
			70% {
				/* this creates the bounce effect */
				-moz-transform: perspective(2000px) rotateY(20deg);
			}
			100% {
				-moz-transform: perspective(2000px) rotateY(0);
			}
		}
		@keyframes cd-rotate-inverse {
			0% {
				-webkit-transform: perspective(2000px) rotateY(-180deg);
				-moz-transform: perspective(2000px) rotateY(-180deg);
				-ms-transform: perspective(2000px) rotateY(-180deg);
				-o-transform: perspective(2000px) rotateY(-180deg);
				transform: perspective(2000px) rotateY(-180deg);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(20deg);
				-moz-transform: perspective(2000px) rotateY(20deg);
				-ms-transform: perspective(2000px) rotateY(20deg);
				-o-transform: perspective(2000px) rotateY(20deg);
				transform: perspective(2000px) rotateY(20deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(0);
				-moz-transform: perspective(2000px) rotateY(0);
				-ms-transform: perspective(2000px) rotateY(0);
				-o-transform: perspective(2000px) rotateY(0);
				transform: perspective(2000px) rotateY(0);
			}
		}
		@-webkit-keyframes cd-rotate-back {
			0% {
				-webkit-transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(-200deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(-180deg);
			}
		}
		@-moz-keyframes cd-rotate-back {
			0% {
				-moz-transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-moz-transform: perspective(2000px) rotateY(-200deg);
			}
			100% {
				-moz-transform: perspective(2000px) rotateY(-180deg);
			}
		}
		@keyframes cd-rotate-back {
			0% {
				-webkit-transform: perspective(2000px) rotateY(0);
				-moz-transform: perspective(2000px) rotateY(0);
				-ms-transform: perspective(2000px) rotateY(0);
				-o-transform: perspective(2000px) rotateY(0);
				transform: perspective(2000px) rotateY(0);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(-200deg);
				-moz-transform: perspective(2000px) rotateY(-200deg);
				-ms-transform: perspective(2000px) rotateY(-200deg);
				-o-transform: perspective(2000px) rotateY(-200deg);
				transform: perspective(2000px) rotateY(-200deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(-180deg);
				-moz-transform: perspective(2000px) rotateY(-180deg);
				-ms-transform: perspective(2000px) rotateY(-180deg);
				-o-transform: perspective(2000px) rotateY(-180deg);
				transform: perspective(2000px) rotateY(-180deg);
			}
		}
		@-webkit-keyframes cd-rotate-inverse-back {
			0% {
				-webkit-transform: perspective(2000px) rotateY(180deg);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(-20deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(0);
			}
		}
		@-moz-keyframes cd-rotate-inverse-back {
			0% {
				-moz-transform: perspective(2000px) rotateY(180deg);
			}
			70% {
				/* this creates the bounce effect */
				-moz-transform: perspective(2000px) rotateY(-20deg);
			}
			100% {
				-moz-transform: perspective(2000px) rotateY(0);
			}
		}
		@keyframes cd-rotate-inverse-back {
			0% {
				-webkit-transform: perspective(2000px) rotateY(180deg);
				-moz-transform: perspective(2000px) rotateY(180deg);
				-ms-transform: perspective(2000px) rotateY(180deg);
				-o-transform: perspective(2000px) rotateY(180deg);
				transform: perspective(2000px) rotateY(180deg);
			}
			70% {
				/* this creates the bounce effect */
				-webkit-transform: perspective(2000px) rotateY(-20deg);
				-moz-transform: perspective(2000px) rotateY(-20deg);
				-ms-transform: perspective(2000px) rotateY(-20deg);
				-o-transform: perspective(2000px) rotateY(-20deg);
				transform: perspective(2000px) rotateY(-20deg);
			}
			100% {
				-webkit-transform: perspective(2000px) rotateY(0);
				-moz-transform: perspective(2000px) rotateY(0);
				-ms-transform: perspective(2000px) rotateY(0);
				-o-transform: perspective(2000px) rotateY(0);
				transform: perspective(2000px) rotateY(0);
			}
		}


		.tab-content {
			margin-left: 0%!important;
			margin-top: 0%!important;

		}
		.tab-content>.active {
			width: 100% !important;
		}

		.tab-pane,.cd-pricing-container,.cd-pricing-switcher ,.cd-row,.cd-row>div{

		}

		.center-pills { display: inline-block; }

		.nav-pills{
			border: 1px solid #fff;
			height:48px;
		}

		.nav-pills>li{
			width:250px;
		}

		.tab-font{
			vertical-align:text-bottom;
			font-size:20px;
		}

		.nav-pills>li+li {
			margin-left: 0px;
		}

		.nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus,.nav-pills>li.active>a:active{
			color: #1e3334;
			background-color:white;
			height:47px;
		}

		.nav-pills>li>a:hover {
			color:#fff;
			background: #E97D68;
			height:46px;
		}

		.nav-pills>li>a:focus{
			color:#fff;
			background:grey;
			height:47px;

		}

		.nav-pills>li.active{
			background-color: #fff;
		}

		.nav-pills>li>a {
			border-radius: 0px;
			height:47px;
			border-color:#E85700;
			font-weight: 500;
			color: #d3f3d3;
			text-transform:uppercase;
		}


		.ui-widget-content {
			border: 1px solid #bdc3c7;
			background: #e1e1e1;
			color: #222222;
			margin-top: 4px;
		}

		.ui-slider .ui-slider-handle {
			position: absolute !important;
			z-index: 2 !important;
			width: 3.2em !important;
			height: 2.2em !important;
			cursor: default !important;
			margin: 0 -20px auto !important;
			text-align: center !important;
			line-height: 30px !important;
			color: #FFFFFF !important;
			font-size: 15px !important;
		}




		.ui-state-default,
		.ui-widget-content .ui-state-default {
			background: #393a40 !important;
		}
		.ui-slider .ui-slider-handle {width:2em;left:-.6em;text-decoration:none;text-align:center;}
		.ui-slider-horizontal .ui-slider-handle {
			margin-left: -0.5em !important;
		}

		.ui-slider .ui-slider-handle {
			cursor: pointer;
		}

		.ui-slider a,
		.ui-slider a:focus {
			cursor: pointer;
			outline: none;
		}

		.price, .lead p {
			font-weight: 600;
			font-size: 32px;
			display: inline-block;
			line-height: 60px;
		}


		.price-slider {
			margin-top: 30px;
			margin-bottom: 30px;
		}

		.price-form {
			background: #ffffff;
			margin-bottom: 10px;
			padding: 20px;
			border: 1px solid #eeeeee;
			border-radius: 4px;
		}



		.help-text {
			display: block;
			margin-top: 32px;
			margin-bottom: 10px;
			color: #737373;
			position: absolute;
			font-weight: 200;
			text-align: right;
			width: 188px;
		}

		.price-form label {
			font-weight: 200;
			font-size: 21px;
		}

		.ui-slider-range-min {
			background: #2980b9;
		}

		.ui-slider-label-inner {
			border-top: 10px solid #393a40;
			display: block;
			left: 50%;
			position: absolute;
			top: 10%;
			z-index: 99;
		}

		.ui-slider-horizontal .ui-slider-handle {
			top: -.6em !important;
		}
		/***********************ADDED BY SHAILESH************************/

		.plan-tagline{
			margin:1px;
			font-size: 2rem;
			font-weight: 400;
		}

		.pricing-tooltip {
			position: relative;
			display: inline-block;
			/* color:black; */
		}

		.tooltip {
			display:none;
			background: black;
			font-size:12px;
			height:10px;
			width:80px;
			padding:10px;
			color:#fff;
			z-index: 99;
			bottom: 10px;
			border: 2px solid white;
			/* for IE */
			filter:alpha(opacity=80);
			/* CSS3 standard */
			opacity:0.8;
		}
		.pricing-tooltip .pricing-tooltiptext {
			visibility: hidden;
			background-color: black;
			line-height: 1.5em;
			font-size:12px;
			min-width: 300px;
			color: rgb(253, 252, 252);
			padding: 10px;
			border-radius: 6px;
			position: absolute;
			z-index: 5;
			text-align: center;
		}

		.pricing-tooltiptext .body{
			font-weight:100;
		}

		.pricing-tooltip:hover .pricing-tooltiptext {
			visibility: visible;
		}

		.pricing-dotted-border{
			border-bottom: 1px dotted black;
		}
		.pricing-tooltip-class,.pricing-tooltip-class:hover{
			color:black;
			border-bottom: 1px dotted black;
		}
		.pricing-tooltip-class:focus{
			color:black;
			text-decoration: none;
		}

		.toggle-div{
			cursor: pointer;
			font-size:1.5em;
		}

		.toggler_more{
			font-size: 1.1em;
			font-weight: bold;

			cursor: pointer;
		}

		.cd-pricing-features>li>a{
			color:#E97D68;
		}

		.pc-header{
			font-size:18px;
		}

		.cd-row .col-md-4, .cd-row .col-md-6 {
			padding-left: 30px!important;
			font-size: 16px;
			padding: 4px;
		}

		.cd-row .col-md-6 {
			width: 60.33333333%;
		}


		.ribbon {
			font-size: 12px !important;
			/* This ribbon is based on a 16px font side and a 24px vertical rhythm. I've used em's to position each element for scalability. If you want to use a different font size you may have to play with the position of the ribbon elements */

			width: 8%;

			position: relative;
			background: #ba89b6;
			color: #fff;
			text-align: center;
			padding-top: 8px; /* Adjust to suit */
			padding-bottom: 8px;
			margin: 2em auto 3em; /* Based on 24px vertical rhythm. 48px bottom margin - normally 24 but the ribbon 'graphics' take up 24px themselves so we double it. */
		}
		.ribbon:before, .ribbon:after {
			content: "";
			position: absolute;
			display: block;
			bottom: -1em;
			border: 15px solid #986794;
			z-index: -1;
		}
		.ribbon:before {
			left: -2em;
			border-right-width: 1.5em;
			border-left-color: transparent;
		}
		.ribbon:after {
			right: -2em;
			border-left-width: 1.5em;
			border-right-color: transparent;
		}
		.ribbon .ribbon-content:before, .ribbon .ribbon-content:after {
			content: "";
			position: absolute;
			display: block;
			border-style: solid;
			border-color: #804f7c transparent transparent transparent;
			bottom: -1em;
		}
		.ribbon .ribbon-content:before {
			left: 0;
			border-width: 0em 0 0 1em;
		}
		.ribbon .ribbon-content:after {
			right: 0;
			border-width: 0em 1em 0 0;
		}
		.ribbon-placement-1{
			margin-left: -34%;
			position: relative;
			margin-bottom: -80px;
			z-index: 1;
		}

		.ribbon-placement-2{
			margin-left: 34%;
			position: relative;
			margin-bottom: -60px;
			z-index: 1;
		}

		.popover {
			max-width: 25%;
			width: 25%;
			border-radius: 5px;
		}
		.popover-header{ background: rgb(233, 125, 104); color: white;}


	</style>
<div class="wrap">
			<div style="text-align:center;">
				<h2>miniOrange SSO using OAuth2/OpenID Connect</h2>
			</div>
			<div style="float:left;">
				<a  class="add-new-h2 add-new-hover" style="font-size: 16px; color: #000;" href="<?php echo add_query_arg( array( 'tab' => 'config' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: bottom;"></span> Back To Plugin Configuration</a>
			</div>
				<!-- span style="float:right;">
				<a  class="add-new-h2 add-new-hover" style="font-size: 16px; color: #000;" data-toggle="modal" data-target="#standardPremiumModalCenter" ><span class="dashicons dashicons-warning" style="vertical-align: bottom;"></span> Help me choose the right plan</a></span -->
				<br />
				<div style="text-align:center; color: rgb(233, 125, 104);">
					<br><h2>You are currently on the Free version of the plugin</h2>
					<span style="font-size: 16px; margin-bottom: 0Px;">
						<ul>
							<li style="margin-bottom: 0px;margin-top: 0px;">Free version is recommended for setting up Proof of Concept (PoC)</li>
							<li style="margin-bottom: 0px;margin-top: 0px;">Try it to test the SSO connection with your OAuth2/OpenID Connect compliant Providers</li>
							<li style="color: dimgray; margin-top: 0px;list-style-type: none;">
								<a tabindex="0"  style="cursor: pointer;color:dimgray;" id="popoverfree" data-toggle="popover" data-trigger="focus" title="<h3>Why should I upgrade to premium plugin?</h3>" data-placement="bottom" data-html="true" data-content="<p>You should upgrade to seek the support of our SSO expert team.<br /><br />Free version does not support attribute mapping, role mapping, single logout features and Multisite Network Installation. <br /><br />Premium version supports OpenID Connect, which is required by many providers.<br /><br />Check the features given in the Licensing Plans for more detail.</p>">
								Why should I upgrade?</a></li>
						</ul>
						</span>
					</div>
		<div style="text-align: center; font-size: 14px; background: forestgreen; color: white; padding-top: 4px; padding-bottom: 4px; border-radius: 16px;"></div>
	<input type="hidden" id="mo_license_plan_selected" value="" />
	<div class="tab-content">
	<div class="tab-pane active text-center" id="cloud">

		<div class="cd-pricing-container cd-has-margins"><br>
			<h1 style="font-size: 32px;">Choose Your Licensing Plan</h1>
			<div class="cd-pricing-switcher">
				<p class="fieldset" style="background-color: #e97d68;">
					<input type="radio" name="sitetype" value="singlesite" id="singlesite" checked>
					<label for="singlesite">Single Site</label>
				</p>
			</div>
			<style>
				.add-new-hover:hover{
					color: white !important;
				}

			</style>
			<script>
				jQuery(document).ready(function(){
					jQuery("#popover").popover({ trigger: "hover" });
					jQuery("#popover1").popover({ trigger: "hover" });
					jQuery("#popover2").popover({ trigger: "hover" });
					jQuery("#popover3").popover({ trigger: "hover" });
					jQuery("#popover4").popover({ trigger: "hover" });
					jQuery("#popover5").popover({ trigger: "hover" });
					jQuery("#popoverfree").popover({ trigger: "focus" });


				});
			</script>
			<!-- .cd-pricing-switcher -->



			<!--div style="z-index: 1;position: relative;">


					<button type="button" data-toggle="modal" data-target="#standardPremiumModalCenter" >
						-COMPARE-
					</button>

				<button type="button" data-toggle="modal" data-target="#premiumEnterpriseModalCenter" style="cursor: pointer; font-size: 15px;background-color: #ba89b6;border-radius: 4px;padding: 5px;color: white;margin-left: 300px;">
					-COMPARE-
				</button>
			</div -->



			<input type="hidden" value="<?php echo mo_oauth_is_customer_registered();?>" id="mo_customer_registered">
			<ul class="cd-pricing-list cd-bounce-invert" >
				<li>

					<ul class="cd-pricing-wrapper">
						<li data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sssborder; ?>">
							<a id="popover" data-toggle="popover" title="<h3>Why should I choose this plan?</h3>" data-placement="top" data-html="true"
							data-content="<p>Choose this plan if you are looking for the features like <br /><b>Login using link / shortcode</b><br /><b>Basic Attribute Mapping (Username, Email, First Name, Last Name, Display Name)</b><br /><span style='color:red;'></p>">
							<header class="cd-pricing-header">

								<h2 style="margin-bottom: 10px" >Standard<span style="font-size:0.5em"></span></h2>
								<h3 style="color:black;">(Unlimited Users)<br /><br /></h3>
								<div class="cd-price" >
									<span class="cd-currency">$</span>
									<span class="cd-value">149*</span></span>

								</div>
								<div>(One Time)</div>

							</header> <!-- .cd-pricing-header -->
							</a>
							<footer class="cd-pricing-footer">
								<a href="#" class="cd-select" onclick="upgradeform('wp_oauth_client_standard_plan')" >Upgrade Now</a>
							</footer>
							<b style="color: coral;">See the Standard Plugin features list below</b>
							<div class="cd-pricing-body">
								<ul class="cd-pricing-features">
									<li>1 OAuth provider support</li>
									<li>Auto Create Users<br>(Unlimited Users)</li>
									<li>Account Linking</li>
									<li>Auto fill OAuth servers configuration</li>
									<li>Advanced Attribute Mapping (Username, FirstName, LastName, Email, Group Name)</li>
									<li>Login Widget</li>
									<li style="padding-bottom:16%!important;">Authorization Code Grant</li>
									<li>Login using link / shortcode</li>
									<li>Custom login buttons and CSS</li>
									<li>Custom Redirect URL after login and logout</li>
									<li>Basic Role Mapping<br>(Support for default role for new users)</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;<br>&nbsp;</li>
									<li><b>Support</b><br>Basic Email Support Plans On Demand</li>
								</ul>
							</div> <!-- .cd-pricing-body -->
						</li>
					</ul> <!-- .cd-pricing-wrapper -->
				</li>

				<li class="cd-popular">
					<ul class="cd-pricing-wrapper">
						<li data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sspborder; ?>">
							<a id="popover1" data-toggle="popover" title="<h3>Why should I choose this plan?</h3>" data-placement="top" data-html="true"
							data-content="<p>Choose this plan if you are looking for the features like <br /><b>Advance Attribute Mapping<br />Role Mapping<br />Single Logout<br />OpenId Connect Support<br /></b><span style='color:red;'></p>">
							<header class="cd-pricing-header">

								<h2 style="margin-bottom: 10px">Premium</h2>
								<h3 style="color:black;">(OpenID Connect Support)<br /><br /></h3>

								<div class="cd-price" >
									<span class="cd-currency">$</span>
									<span class="cd-value">349*</span></span>

								</div>
								<div>(One Time)</div>

							</header> <!-- .cd-pricing-header -->
							</a>
							<footer class="cd-pricing-footer">
								<a href="#" class="cd-select" onclick="upgradeform('wp_oauth_client_premium_plan')" >Upgrade Now</a>
							</footer>
							<b>See the Premium Plugin features list below</b>
							<div class="cd-pricing-body">
								<ul class="cd-pricing-features">
									<li>1 OAuth provider support</li>
									<li>Auto Create Users<br>(Unlimited Users)</li>
									<li>Account Linking</li>
									<li>Auto fill OAuth servers configuration</li>
									<li>Advanced Attribute Mapping (Username, FirstName, LastName, Email, Group Name)</li>
									<li>Login Widget</li>
									<li>Authorization Code Grant, Password Grant, Client Credentials Grant, Implicit Grant, Refresh token Grant</li>
									<li>Login using link / shortcode</li>
									<li>Custom login buttons and CSS</li>
									<li>Custom Redirect URL after login and logout</li>
									<li>Advanced Role Mapping</li>
									<li>JWT Support</li>
									<li>Force authentication / Protect complete site</li>
									<li>OpenId Connect Support<br>(Login using OpenId Connect Server)</li>
									<li>Multiple Userinfo endpoints support</li>
									<li>Domain specific registration</li>
									<li>Multi-site Support</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li><b>Support</b><br>GoToMeeting Support Plans On Demand</li>
								</ul>
							</div> <!-- .cd-pricing-body -->
						</li>

					</ul> <!-- .cd-pricing-wrapper -->
				</li>

				<li>
					<ul class="cd-pricing-wrapper">
						<li data-type="singlesite" class="mosslp is-visible" style="border: <?php echo $sseborder; ?>">
							<a id="popover2" data-toggle="popover" title="<h3>Why should I choose this plan?</h3>" data-placement="top" data-html="true"
							data-content="<p>Choose this plan if you are looking for features like <br /><b>BuddyPress Attribute Mapping<br />Dynamic Callback URL</b><br /><b>Unlimited OAuth Providers</b><br />Click  on Upgrade now to Upgrade!<br /><span style='color:red;'></p>">
							<header class="cd-pricing-header">
								<h2 style="margin-bottom:10px;">Enterprise</h2>
								<h3 style="color:black;">(Unlimited OAuth Providers)<br /><br /></h3>
								<div class="cd-price" >
									<span class="cd-currency">$</span>
									<span class="cd-value">449*</span></span>

								</div>
								<div>(One Time)</div>
							</header> <!-- .cd-pricing-header -->
							</a>
							<footer class="cd-pricing-footer">
								<a href="#" class="cd-select" onclick="upgradeform('wp_oauth_client_enterprise_plan')" >Upgrade Now</a>
							</footer>
							<b style="color: coral;">See the Enterprise Plugin features list below</b>
							<div class="cd-pricing-body">
								<ul class="cd-pricing-features ">
								<li>Unlimited OAuth provider support</li>
									<li>Auto Create Users<br>(Unlimited Users)</li>
									<li>Account Linking</li>
									<li>Auto fill OAuth servers configuration</li>
									<li>Advanced Attribute Mapping (Username, FirstName, LastName, Email, Group Name)</li>
									<li>Login Widget</li>
									<li>Authorization Code Grant, Password Grant, Client Credentials Grant, Implicit Grant, Refresh token Grant</li>
									<li>Login using link / shortcode</li>
									<li>Custom login buttons and CSS</li>
									<li>Custom Redirect URL after login and logout</li>
									<li>Advanced Role Mapping</li>
									<li>JWT Support</li>
									<li>Force authentication / Protect complete site</li>
									<li>OpenId Connect Support<br>(Login using OpenId Connect Server)</li>
									<li>Multiple Userinfo endpoints support</li>
									<li>Domain specific registration</li>
									<li>Multi-site Support</li>
									<li>Account Linking</li>
									<li>BuddyPress Attribute Mapping</li>
									<li>Dynamic Callback URL</li>
									<li>Page Restriction</li>
									<li>WP hooks for different events</li>
									<li>Login Reports / Analytics</li>
									<li>&nbsp;</li>
									<li>&nbsp;</li>
									<li><b>Support</b><br>GoToMeeting Support Plans On Demand</li>
								</ul>
							</div> <!-- .cd-pricing-body -->

						</li>
					</ul> <!-- .cd-pricing-wrapper -->
				</li>
			</ul> <!-- .cd-pricing-list -->
		</div> <!-- .cd-pricing-container -->
		<div style="text-align:left; font-size:12px; padding-left:30px; padding-right:30px;">
			<h3>Steps to Upgrade to Premium Plugin -</h3>
			<p>1. Click on 'Upgrade now' button of the required licensing plan. You will be redirected to miniOrange Login Console. Enter your password with which you created an account
				with us. After that you will be redirected to payment page.</p>
			<p>2. Enter you card details and complete the payment. On successful payment completion, you will see the link
				to download the premium plugin.</p>
			<p>3. To install the premium plugin, first deactivate and delete the free version of the plugin.

			<p>4. From this point on, do not update the premium plugin from the Wordpress store.</p>
			
			<br />
			<h3>* MultiSite Network Support - </h3>
			<p>There is additional cost for the number of subsites in Multisite Network .</p>

			<h3>10 Days Return Policy -</h3>
			At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is
			not working as advertised and you've attempted to resolve any issues with our support team, which couldn't get
			resolved. We will refund the whole amount within 10 days of the purchase. Please email us at info@xecurify.com
			for any queries regarding the return policy.

		</div>
	</div>





	</div>

	<a  id="mobacktoaccountsetup" style="display:none;" href="<?php echo add_query_arg( array( 'tab' => 'login' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Back</a>
	<form style="display:none;" id="loginform"
				action="<?php echo get_option( 'host_name' ) . '/moas/login'; ?>"
				target="_blank" method="post">
		<input type="email" name="username" value="<?php echo get_option( 'mo_oauth_admin_email' ); ?>"/>
		<input type="text" name="redirectUrl"
			value="<?php echo get_option( 'host_name' ) . '/moas/initializepayment'; ?>"/>
		<input type="text" name="requestOrigin" id="requestOrigin"/>
	</form>
	<style>

		.btn_blue{
			padding:5px !important;
			width:150px;
		}

		.table-onpremisetable{
			width: 30%;
			padding-top: 100px;
			margin: auto;
			width: 40%;
			padding: 10px;
		}


		.table-onpremisetable2{
			padding-top: 100px;
			margin: auto;
			width:	60%;
			padding: 10px;
			border: 2px solid #fff;
			table-layout:fixed;
			color: #173d50;

		}

		.table-onpremisetable2 th {
			background-color: #fcfdff;

			text-align: center;
			vertical-align:center;
		}

		.table-onpremisetable2 td {
			background-color: #fcfdff;

			text-align: center;
			vertical-align:center;
		}


		/* the third */
		.table-plugin-pricing{
			margin: auto;
			width: 70%;
			padding: 30px;
			background-color: transparent;
			border-collapse: collapse;
			border-spacing: 0;
		}

		/* .table-plugin-pricing td:nth-child(1) {
		width: 25%;
		height:auto;

		background-color: #fff !important;
		color: black;
		vertical-align: middle;


		} */

		/* the second */
		/* width: 20%;
		background-color: transparent;
		height:auto; */
		/* .table-plugin-pricing td:nth-child(2) {

			border: 1px solid #c4c4c4;
			min-width: 8%;
			padding: 10px 5px 10px 20px;
			word-break: normal;

		} */

		.give-some-space-dude{
			margin: 30px auto 45px;
		}


		.onpremise-container{
			color: black ;
			background-color: #fff !important;
		}

		.plugins-pricing{
			padding:50px;
			width:80%;
			margin: auto;
			background-color: inherit;
		}
		h1 {
			margin: .67em 0;
			font-size: 2em;
		}
		.tab-content-plugins-pricing div {
			background: #173d50;
		}

		/* .onpremise-container{
			background-color: #fff !important;
		} */
		.color-make-black{
			color:black;
		}
		.tip-icon {
			display: inline-block;
			width: 15px;
			height: 15px;
			background-image: url(https://cdn.auth0.com/website/assets/pages/pricing/img/tip-help-fc9f80876e.svg);
			background-size: 100%;
			background-repeat: no-repeat;
			background-position: 50%;
			vertical-align: middle;
			margin: 0 0 2px 5px;
			opacity: .3;
		}
	</style>
	<script>

		function upgradeform(planType) {
			jQuery('#requestOrigin').val(planType);
			if(jQuery('#mo_customer_registered').val()==1)
				jQuery('#loginform').submit();
			else{
				location.href = jQuery('#mobacktoaccountsetup').attr('href');
			}

		}

		jQuery("input[name=sitetype]:radio").change(function() {

			if (this.value == 'multisite') {
				jQuery('.mosslp').removeClass('is-visible').addClass('is-hidden');
				jQuery('.momslp').addClass('is-visible').removeClass('is-hidden is-selected');

			}
		});

		jQuery(document).ready(function($){

			//hide the subtle gradient layer (.cd-pricing-list > li::after) when pricing table has been scrolled to the end (mobile version only)
			checkScrolling($('.cd-pricing-body'));
			$(window).on('resize', function(){
				window.requestAnimationFrame(function(){checkScrolling($('.cd-pricing-body'))});
			});
			$('.cd-pricing-body').on('scroll', function(){
				var selected = $(this);
				window.requestAnimationFrame(function(){checkScrolling(selected)});
			});

			function checkScrolling(tables){
				tables.each(function(){
					var table= $(this),
						totalTableWidth = parseInt(table.children('.cd-pricing-features').width()),
						tableViewport = parseInt(table.width());
					if( table.scrollLeft() >= totalTableWidth - tableViewport -1 ) {
						table.parent('li').addClass('is-ended');
					} else {
						table.parent('li').removeClass('is-ended');
					}
				});
			}

			//switch from monthly to annual pricing tables
			bouncy_filter($('.cd-pricing-container'));

			function bouncy_filter(container) {
				container.each(function(){
					var pricing_table = $(this);
					var filter_list_container = pricing_table.children('.cd-pricing-switcher'),
						filter_radios = filter_list_container.find('input[type="radio"]'),
						pricing_table_wrapper = pricing_table.find('.cd-pricing-wrapper');

					//store pricing table items
					var table_elements = {};
					filter_radios.each(function(){
						var filter_type = $(this).val();
						table_elements[filter_type] = pricing_table_wrapper.find('li[data-type="'+filter_type+'"]');
					});

					//detect input change event
					filter_radios.on('change', function(event){
						event.preventDefault();
						//detect which radio input item was checked
						var selected_filter = $(event.target).val();

						//give higher z-index to the pricing table items selected by the radio input
						show_selected_items(table_elements[selected_filter]);

						//rotate each cd-pricing-wrapper
						//at the end of the animation hide the not-selected pricing tables and rotate back the .cd-pricing-wrapper

						if( !Modernizr.cssanimations ) {
							hide_not_selected_items(table_elements, selected_filter);
							pricing_table_wrapper.removeClass('is-switched');
						} else {
							pricing_table_wrapper.addClass('is-switched').eq(0).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
								hide_not_selected_items(table_elements, selected_filter);
								pricing_table_wrapper.removeClass('is-switched');
								//change rotation direction if .cd-pricing-list has the .cd-bounce-invert class
								if(pricing_table.find('.cd-pricing-list').hasClass('cd-bounce-invert')) pricing_table_wrapper.toggleClass('reverse-animation');
							});
						}
					});
				});
			}
			function show_selected_items(selected_elements) {
				selected_elements.addClass('is-selected');
			}

			function hide_not_selected_items(table_containers, filter) {
				$.each(table_containers, function(key, value){
					if ( key != filter ) {
						$(this).removeClass('is-visible is-selected').addClass('is-hidden');

					} else {
						$(this).addClass('is-visible').removeClass('is-hidden is-selected');
					}
				});
			}
		});
	</script>
<?php
}


function mo_oauth_app_customization(){
	$custom_css = get_option('mo_oauth_icon_configure_css');
	$cclass = $cscript = '';
	function format_custom_css_value( $textarea ){ 
		$lines = explode(";", $textarea);
		for($i=0;$i<count($lines);$i++)
		{if($i<count($lines)-1)
			echo $lines[$i].";\r\n";
		
		else if($i==count($lines)-1)
			echo $lines[$i]."\r\n";
		}
	}
	
	?>
	
	<?php if(mo_oauth_hbca_xyake() || !mo_oauth_is_customer_registered()) { echo '<div class="mo_oauth_premium_option_text"><span style="color:red;">*</span>This is a standard feature. 
	<a href="admin.php?page=mo_oauth_settings&tab=licensing">Click Here</a> to see our full list of Standard Features.</div>'; $cclass = 'mo_oauth_premium_option'; $cscript = '<script>jQuery( document ).ready(function() { jQuery(".mo_oauth_premium_option :input").prop("disabled", true);}); </script>'; }
	?>
	
	<div id="mo_oauth_customiztion" class="mo_table_layout mo_oauth_app_customization <?php echo $cclass; ?>">
	<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings&tab=customization">
		<input type="hidden" name="option" value="mo_oauth_app_customization" />
		<h2>Customize Icons</h2>
		<table class="mo_settings_table">
			<tr>
				<td><strong>Icon Width:</strong></td>
				<td><input type="text" id="mo_oauth_icon_width" name="mo_oauth_icon_width" value="<?php echo get_option('mo_oauth_icon_width');?>"> e.g. 200px or 100%</td>
			</tr>
			<tr>
				<td><strong>Icon Height:</strong></td>
				<td><input  type="text" id="mo_oauth_icon_height" name="mo_oauth_icon_height" value="<?php echo get_option('mo_oauth_icon_height');?>"> e.g. 50px or auto</td>
			</tr>
			<tr>
				<td><strong>Icon Margins:</strong></td>
				<td><input  type="text" id="mo_oauth_icon_margin" name="mo_oauth_icon_margin" value="<?php echo get_option('mo_oauth_icon_margin');?>"> e.g. 2px 0px or auto</td>
			</tr>
			<tr>
				<td><strong>Custom CSS:</strong></td>
				<td><textarea type="text" id="mo_oauth_icon_configure_css" style="resize: vertical; width:400px; height:180px;  margin:5% auto;" rows="6" name="mo_oauth_icon_configure_css"><?php echo rtrim(trim(format_custom_css_value( $custom_css )),';');?></textarea><br/><b>Example CSS:</b> 
<pre>.oauthloginbutton{ 
	 width:100%;
	 height:50px;
	 padding-top:15px;
	 padding-bottom:15px;
	 margin-bottom:-1px;
	 border-radius:4px;
	 background: #7272dc;
	 text-align:center;
	 font-size:16px;
	 color:#fff;
 }
 .custom_logo{
	 padding-top:-1px;
	 padding-right:15px;
	 padding-left:15px;
	 padding-top:15px;
	 background: #7272dc;
	 color:#fff;
 }</pre>
			</td>
			</tr>
			<tr>
				<td><strong>Custom Logout button text:</strong></td>
				<td><input type="text" style="resize: vertical; width:200px; height:30px;  margin:5% auto;" placeholder ="Howdy ,##user##" id="mo_oauth_custom_logout_text" name="mo_oauth_custom_logout_text" value="<?php echo get_option('mo_oauth_custom_logout_text');?>"><b>##user## is replaced by Username</b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Save settings"
					class="button button-primary button-large"/></td>
			</tr>
		</table>
	</form>
	</div>
	<?php echo $cscript; ?>
		
	<?php

}

function mo_oauth_apps_config() {
	?>
	
	<div class="mo_table_layout">
	<?php

		if(isset($_GET['action']) && $_GET['action']=='delete'){
			if(isset($_GET['app']) && check_admin_referer('mo_oauth_delete_'.$_GET['app'] ))
				mo_oauth_delete_app($_GET['app']);
		} 

		if(isset($_GET['action']) && $_GET['action']=='add'){
			add_app();
		}
		else if(isset($_GET['action']) && $_GET['action']=='update'){
			if(isset($_GET['app']))
				update_app($_GET['app']);
		}
		else if(get_option('mo_oauth_apps_list'))
		{
			$appslist = get_option('mo_oauth_apps_list');
			if(sizeof($appslist)>0)
				echo "<br><a href='#'><button disabled style='float:right'>Add Application</button></a>";
			else
				echo "<br><a href='admin.php?page=mo_oauth_settings&action=add'><button style='float:right'>Add Application</button></a>";
			echo "<h3>Applications List</h3>";
			if(is_array($appslist) && sizeof($appslist)>0)
				echo "<p style='color:#a94442;background-color:#f2dede;border-color:#ebccd1;border-radius:5px;padding:12px'>You can only add 1 application with free version. Upgrade to <a href='admin.php?page=mo_oauth_settings&tab=licensing'><b>enterprise</b></a> to add more.</p>";
			echo "<table class='tableborder'>";
			echo "<tr><th><b>Name</b></th><th>Action</th></tr>";
			foreach($appslist as $key => $app){
				$delete_url = wp_nonce_url( "admin.php?page=mo_oauth_settings&action=delete&app=".$key , 'mo_oauth_delete_'.$key );
				echo "<tr><td>".$key."</td><td><a href='admin.php?page=mo_oauth_settings&action=update&app=".$key."'>Edit Application</a> | <a href='admin.php?page=mo_oauth_settings&action=update&app=".$key."#attribute-mapping'>Attribute Mapping</a> | <a href='admin.php?page=mo_oauth_settings&action=update&app=".$key."#role-mapping'>Role Mapping</a> | <a href='".$delete_url ."' onclick =\"return confirm('Are you sure you want to delete this item?');\">Delete</a> | <a href='admin.php?page=mo_oauth_settings&action=update&app=".$key."#howtoconfigure'>How to Configure?</a></td></tr>";
			}
			echo "</table>";
			echo "<br><br>";

		} else {
			add_app();
		 } ?>
		</div>
	<?php
		//if(get_option('mo_oauth_eveonline_enable'))
			//mo_oauth_apps_config_old();
}

function add_app(){


		$appslist = get_option('mo_oauth_apps_list');
		if(is_array($appslist) && sizeof($appslist)>0) {
			echo "<p style='color:#a94442;background-color:#f2dede;border-color:#ebccd1;border-radius:5px;padding:12px'>You can only add 1 application with free version. Upgrade to <a href='admin.php?page=mo_oauth_settings&tab=licensing'><b>premium</b></a> to add more.</p>";
			exit;
		}


	?>

		<script>
			function selectapp() {
				var appname = document.getElementById("mo_oauth_app").value;
				document.getElementById("instructions").innerHTML  = "";
				if(appname=="google"){
					document.getElementById("instructions").innerHTML  = '<?php mo_oauth_client_instructions("google", false);?>';
				} else if(appname=="facebook"){
					document.getElementById("instructions").innerHTML  = '<?php mo_oauth_client_instructions("facebook", false);?>';
				} else if(appname=="eveonline"){
					document.getElementById("instructions").innerHTML  = '<?php mo_oauth_client_instructions("eveonline", false);?>';
				} else{
					document.getElementById("instructions").innerHTML  = '<?php mo_oauth_client_instructions("other", false);?>';
				}

				 if(appname=="eveonline") { 
					jQuery("#mo_oauth_display_app_name_div").hide();
					jQuery("#mo_oauth_custom_app_name_div").hide();
					jQuery("#mo_oauth_authorizeurl_div").hide();
					jQuery("#mo_oauth_accesstokenurl_div").hide();
					jQuery("#mo_oauth_resourceownerdetailsurl_div").hide();
					jQuery("#mo_oauth_email_attr_div").hide();
					jQuery("#mo_oauth_name_attr_div").hide();
					jQuery("#mo_oauth_custom_app_name").removeAttr('required');
					jQuery("#mo_oauth_authorizeurl").removeAttr('required');
					jQuery("#mo_oauth_accesstokenurl").removeAttr('required');
					jQuery("#callbackurl").val("https://login.xecurify.com/moas/oauth/client/callback");
					
				}else if(appname){
					jQuery("#mo_oauth_display_app_name_div").show();
					jQuery("#mo_oauth_custom_app_name_div").show();
					jQuery("#mo_oauth_authorizeurl_div").show();
					jQuery("#mo_oauth_accesstokenurl_div").show();
					jQuery("#mo_oauth_resourceownerdetailsurl_div").show();
					jQuery("#mo_oauth_email_attr_div").show();
					jQuery("#mo_oauth_name_attr_div").show();
					jQuery("#mo_oauth_custom_app_name").attr('required','true');
					jQuery("#mo_oauth_email_attr").attr('required','true');
					jQuery("#mo_oauth_name_attr").attr('required','true');
					jQuery("#callbackurl").val("<?php echo site_url();?>");
					document.getElementById('mo_oauth_custom_app_name').value = "";
				
					// if( (appname=="google") || (appname=="facebook") || (appname=="windows")  || (appname=="eveonlinenew") ) {
						
						if(appname=="facebook"){
							var scope = "email";
							var authorizeurl = 'https://www.facebook.com/dialog/oauth';
							var accesstokenurl = 'https://graph.facebook.com/v2.8/oauth/access_token';
							var resourceownerdetailsurl = 'https://graph.facebook.com/me/?fields=id,name,email,age_range,first_name,gender,last_name,link&access_token=';
						} else if(appname=="google"){
							var scope = "email";
							var authorizeurl = "https://accounts.google.com/o/oauth2/auth";
							var accesstokenurl = "https://www.googleapis.com/oauth2/v4/token";
							var resourceownerdetailsurl = "https://www.googleapis.com/oauth2/v1/userinfo";
						}  else if(appname=="windows"){
							var scope = "email";
							var authorizeurl = "https://login.live.com/oauth20_authorize.srf";
							var accesstokenurl = "https://login.live.com/oauth20_token.srf";
							var resourceownerdetailsurl = "https://apis.live.net/v5.0/me";
						} else if(appname=="eveonlinenew"){
							var scope ="publicData";
							var authorizeurl = 'https://login.eveonline.com/oauth/authorize';
							var accesstokenurl = 'https://login.eveonline.com/oauth/token';
							var resourceownerdetailsurl = 'https://esi.evetech.net/verify';
							jQuery("#mo_oauth_custom_app_name_div").hide();
							document.getElementById('mo_oauth_custom_app_name').value = "EveOnlineApp";	
						} else if(appname=="cognito"){
							var scope = "openid profile";
							var authorizeurl = "https://<cognito-app-domain>/oauth2/authorize";
							var accesstokenurl = "https://<cognito-app-domain>/oauth2/token";
							var resourceownerdetailsurl = "https://<cognito-app-domain>/oauth2/userInfo";
						} else if(appname=="linkedin"){
							var scope = "r_basicprofile";
							var authorizeurl = "https://www.linkedin.com/oauth/v2/authorization";
							var accesstokenurl = "https://www.linkedin.com/oauth/v2/accessToken";
							var resourceownerdetailsurl = "https://api.linkedin.com/v2/me";
						} else if(appname=="strava"){
							var scope = "public";
							var authorizeurl = "https://www.strava.com/oauth/authorize";
							var accesstokenurl = "https://www.strava.com/oauth/token";
							var resourceownerdetailsurl = "https://www.strava.com/api/v3/athlete";
						}  else if(appname=="fitbit"){
							var scope = "profile";
							var authorizeurl = "https://www.fitbit.com/oauth2/authorize";
							var accesstokenurl = "https://api.fitbit.com/oauth2/token";
							var resourceownerdetailsurl = "https://www.fitbit.com/1/user";
						}   else if(appname=="discord"){
							var scope = "identify email";
							var authorizeurl = "https://discordapp.com/api/oauth2/authorize";
							var accesstokenurl = "https://discordapp.com/api/oauth2/token";
							var resourceownerdetailsurl = "https://discordapp.com/api/users/@me";
						}  else if(appname=="bitrix24"){
							var scope = "user";
							var authorizeurl = "http://[your-id].bitrix24.com/oauth/authorize";
							var accesstokenurl = "http://[your-id].bitrix24.com/oauth/token";
							var resourceownerdetailsurl = "https://[your-id].bitrix24.com/rest/user.current.json?auth=";
						} else if(appname=="github"){
							var scope = "user";
							var authorizeurl = "https://github.com/login/oauth/authorize";
							var accesstokenurl = "https://github.com/login/oauth/access_token";
							var resourceownerdetailsurl = "https://api.github.com/user?access_token=";
						}  else if(appname=="gitlab"){
							var scope = "read_user";
							var authorizeurl = "https://gitlab.com/oauth/authorize";
							var accesstokenurl = "http://gitlab.com/oauth/token";
							var resourceownerdetailsurl = "https://gitlab.com/api/v4/user";
						}else if(appname=="clever"){
							var scope = "read";
							var authorizeurl = "https://clever.com/oauth/authorize";
							var accesstokenurl = "https://clever.com/oauth/tokens";
							var resourceownerdetailsurl = "https://api.clever.com/v1.1/me";
						}  else if(appname=="box"){
							var scope = "root_readwrite";
							var authorizeurl = "https://account.box.com/api/oauth2/authorize";
							var accesstokenurl = "https://api.box.com/oauth2/token";
							var resourceownerdetailsurl = "https://api.box.com/2.0/users/me";
						}   else if(appname=="hr_answerlink"){
							var scope = "/app";
							var authorizeurl = "https://<your-domain>.myhrsupportcenter.com/oauth/token";
							var accesstokenurl = "https://<your-domain>.myhrsupportcenter.com/sso/v2/tokens?user_id=";
							var resourceownerdetailsurl = "https://<your-domain>.myhrsupportcenter.com/sso/v2/sessions";
						}  else if(appname=="invision_community"){
							var scope = "email";
							var authorizeurl = "https://ips.dev/oauth/authorize";
							var accesstokenurl = "https://ips.dev/oauth/token";
							var resourceownerdetailsurl = "https://ips.dev/oauth/core/me";
						}  else if(appname=="azure"){
							var scope ="openid";
							var authorizeurl = 'https://login.microsoftonline.com/<TENANT-ID>/oauth2/authorize';
							var accesstokenurl = 'https://login.microsoftonline.com/<TENANT-ID>/oauth2/token';
							var resourceownerdetailsurl = 'https://login.windows.net/common/openid/userinfo';
						}
						else
						{
							var scope ="email";
							var authorizeurl = "";
							var accesstokenurl = "";
							var resourceownerdetailsurl = "";
						} 
						
					// } else {
						// document.getElementById('mo_oauth_custom_app_name').value = "";
						document.getElementById('mo_oauth_scope').value = scope;
						document.getElementById('mo_oauth_authorizeurl').value=authorizeurl;
						document.getElementById('mo_oauth_accesstokenurl').value=accesstokenurl;
						document.getElementById('mo_oauth_resourceownerdetailsurl').value=resourceownerdetailsurl;
					// }					
						jQuery("#mo_oauth_authorizeurl").attr('required','true');
						jQuery("#mo_oauth_accesstokenurl").attr('required','true');
					//jQuery("#mo_oauth_resourceownerdetailsurl").attr('required','true');
				}

			}

		</script>
		<div id="toggle2" class="panel_toggle">
			<h3>Add Application</h3>
		</div>
		<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings">
		<input type="hidden" name="option" value="mo_oauth_add_app" />
		<table class="mo_settings_table">
			<tr>
			<td><strong><font color="#FF0000">*</font>Select Application:</strong></td>
			<td>
				<select class="mo_table_textbox" required="true" name="mo_oauth_app_name" id="mo_oauth_app" onchange="selectapp()">
				  <option value="">Select Application</option>
				  <option value="google">Google</option>
				  <option value="facebook">Facebook</option>
				  <option value="windows">Windows Account</option>
				  <option value="eveonlinenew">Eve Online</option>
				  <option value="cognito">AWS Cognito</option>
				  <option value="linkedin">LinkedIn</option>
				  <option value="strava">Strava</option>
				  <option value="fitbit">FitBit</option>
				  <!-- newly added-->
				  <option value="azure">Azure</option>
				  <option value="discord">Discord</option>
				  <option value="bitrix24">Bitrix 24</option>
				  <option value="github">GitHub</option>
				  <option value="gitlab">GitLab</option>
				  <option value="clever">Clever</option>
				  <option value="box">Box</option>
				  <option value="hr_answerlink">HR Answerlink</option>
				  <option value="invision_community">Invision Community</option>
				  <option value="other">Custom OAuth 2.0 Provider</option>
				</select>
			</td>
			</tr>
			<tr><td><strong>Redirect / Callback URL</strong></td>
			<td><input class="mo_table_textbox" id="callbackurl"  type="text" readonly="true" value='<?php echo site_url();?>'></td>
			</tr>
			<tr  style="display:none" id="mo_oauth_custom_app_name_div">
				<td><strong><font color="#FF0000">*</font>Custom App Name:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_custom_app_name" name="mo_oauth_custom_app_name" value="" pattern="[a-zA-Z0-9\s]+" title="Please do not add any special characters."></td>
			</tr>
			<tr style="display:none" id="mo_oauth_display_app_name_div">
				<td><strong>Display App Name:</strong><br>&emsp;<font color="#FF0000"><small>[STANDARD]</small></font></td>
				<td><input disabled class="mo_table_textbox" type="text" id="mo_oauth_display_app_name" name="mo_oauth_display_app_name" value=""></td>
			</tr>
			<tr>
				<td><strong><font color="#FF0000">*</font>Client ID:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_id" value=""></td>
			</tr>
			<tr>
				<td><strong><font color="#FF0000">*</font>Client Secret:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text"  name="mo_oauth_client_secret" value=""></td>
			</tr>
			<tr>
				<td><strong>Scope:</strong></td>
				<td><input class="mo_table_textbox" type="text" name="mo_oauth_scope" id="mo_oauth_scope" value="email"></td>
			</tr>
			<tr style="display:none" id="mo_oauth_authorizeurl_div">
				<td><strong><font color="#FF0000">*</font>Authorize Endpoint:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_authorizeurl" name="mo_oauth_authorizeurl" value=""></td>
			</tr>
			<tr style="display:none" id="mo_oauth_accesstokenurl_div">
				<td><strong><font color="#FF0000">*</font>Access Token Endpoint:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_accesstokenurl" name="mo_oauth_accesstokenurl" value=""></td>
			</tr>
			<tr style="display:none" id="mo_oauth_resourceownerdetailsurl_div">
				<td><strong><font color="#FF0000">*</font>Get User Info Endpoint:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_resourceownerdetailsurl" name="mo_oauth_resourceownerdetailsurl" value=""></td>
			</tr>
			<tr style="display: none"><td></td><td><input class="mo_table_textbox" type="checkbox" name="disable_authorization_header" id="disable_authorization_header" value="" > (Check if does not require Authorization Header)</td></tr>
			<!--<tr style="display:none" id="mo_oauth_email_attr_div">
				<td><strong><font color="#FF0000">*</font>Email Attribute:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_email_attr" name="mo_oauth_email_attr" value=""></td>
			</tr>
			<tr style="display:none" id="mo_oauth_name_attr_div">
				<td><strong><font color="#FF0000">*</font>Name Attribute:</strong></td>
				<td><input class="mo_table_textbox" type="text" id="mo_oauth_name_attr" name="mo_oauth_name_attr" value=""></td>
			</tr>-->
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Save settings"
					class="button button-primary button-large" /></td>
			</tr>
			</table>
		</form>

		<div id="instructions">

		</div>

		<?php
}

function update_app($appname){

	$appslist = get_option('mo_oauth_apps_list');
	foreach($appslist as $key => $app){
		if($appname == $key){
			$currentappname = $appname;
			$currentapp = $app;
			if(isset($currentapp['accesstokenurl']) && strpos($currentapp['accesstokenurl'], "google") !== false) {
				$currentapp['accesstokenurl'] = "https://www.googleapis.com/oauth2/v4/token";
			}
			if(isset($currentapp['authorizeurl']) && strpos($currentapp['authorizeurl'], "google") !== false) {
				$currentapp['authorizeurl'] = "https://accounts.google.com/o/oauth2/auth";
			}
			if(isset($currentapp['resourceownerdetailsurl']) && strpos($currentapp['resourceownerdetailsurl'], "google") !== false) {
				$currentapp['resourceownerdetailsurl'] = "https://www.googleapis.com/oauth2/v1/userinfo";
			}
			break;
		}
	}
	

	if(!isset($currentapp))
		return;

	$is_eveonline = false;
	//if(in_array($currentappname, array("eveonline")))
	if(strpos(strtolower($currentappname),"eveonline")!==false)
		$is_eveonline = true;

	?>

		<div id="toggle2" class="panel_toggle">
			<h3>Update Application : <?php echo $currentappname;?></h3>
		</div>
		<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings">
		<input type="hidden" name="option" value="mo_oauth_add_app" />
		<table class="mo_settings_table">
			<tr>
			<td><strong><font color="#FF0000">*</font>Application:</strong></td>
			<td>
				<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_app_name" value="<?php echo $currentappname;?>">
				<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_custom_app_name" value="<?php echo $currentappname;?>">
				<?php echo $currentappname;?><br><br>
			</td>
			</tr>
			<tr><td><strong>Redirect / Callback URL</strong></td>
			<td><input class="mo_table_textbox"  type="text" readonly="true" value='<?php echo $currentapp['redirecturi'];?>'></td>
			</tr>
			
			<tr>
				<td><strong>Display App Name:</strong><br>&emsp;<font color="#FF0000"><small>[STANDARD]</small></font></td>
				<td><input disabled class="mo_table_textbox" type="text" name="mo_oauth_display_app_name" value="<?php echo isset($currentapp['displayappname']) ? $currentapp['displayappname'] : '';?>"></td>
			</tr>
			
			<tr>
				<td><strong><font color="#FF0000">*</font>Client ID:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_id" value="<?php echo $currentapp['clientid'];?>"></td>
			</tr>
			<tr>
				<td><strong><font color="#FF0000">*</font>Client Secret:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" name="mo_oauth_client_secret" value="<?php echo $currentapp['clientsecret'];?>"></td>
			</tr>
			<tr>
				<td><strong>Scope:</strong></td>
				<td><input class="mo_table_textbox" type="text" name="mo_oauth_scope" pattern="[a-zA-Z0-9\s]+" title="Please do not add any special characters." value="<?php echo $currentapp['scope'];?>"></td>
			</tr>
			<?php 
				if($is_eveonline){ 
					$displaystyle= "display:none";
				} else
					$displaystyle= "";
			?>
			<tr  id="mo_oauth_authorizeurl_div" style="<?php echo $displaystyle;?>">
				<td><strong><font color="#FF0000">*</font>Authorize Endpoint:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" id="mo_oauth_authorizeurl" name="mo_oauth_authorizeurl" value="<?php echo $currentapp['authorizeurl'];?>"></td>
			</tr>
			
			<tr id="mo_oauth_accesstokenurl_div" style="<?php echo $displaystyle;?>">
				<td><strong><font color="#FF0000">*</font>Access Token Endpoint:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" id="mo_oauth_accesstokenurl" name="mo_oauth_accesstokenurl" value="<?php echo $currentapp['accesstokenurl'];?>"></td>
			</tr>
			<tr id="mo_oauth_resourceownerdetailsurl_div" style="<?php echo $displaystyle;?>">
				<td><strong><font color="#FF0000">*</font>Get User Info Endpoint:</strong></td>
				<td><input class="mo_table_textbox" required="" type="text" id="mo_oauth_resourceownerdetailsurl" name="mo_oauth_resourceownerdetailsurl" value="<?php echo $currentapp['resourceownerdetailsurl'];?>"></td>
			</tr>
			<?php if( $currentappname != "EveOnlineApp" ) { ?>
			<tr><td></td><td><input class="mo_table_textbox" type="checkbox" name="disable_authorization_header" id="disable_authorization_header" <?php (checked( get_option('mo_oauth_client_disable_authorization_header') == true ));?> > (Check if does not require Authorization Header)</td></tr>
			<?php } ?>
			<tr>
				<tr></tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" name="submit" value="Save settings" class="button button-primary button-large" />
					<?php if($currentappname != "eveonline"){?><input type="button" name="button" value="Test Configuration" class="button button-primary button-large" onclick="testConfiguration()" /><?php } ?>
				</td>
			</tr>
		</table>
		</form>
		</div>

		<?php 
		
		
			/*if(!$is_eveonline){*/
				mo_oauth_attribute_mapping($currentapp, $currentappname);
				$current_appname = get_option("mo_oauth_app_name_".$currentappname);
			/*}
			else
				$current_appname = "eveonline";*/
	        
		mo_oauth_client_instructions($current_appname, true);
		
} 

		function mo_oauth_attribute_mapping($currentapp, $currentappname) {
		?>
		<div class="mo_table_layout" id="attribute-mapping">
		<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings">
		<h3>Attribute Mapping</h3>
		<p style="font-size:13px;color:#dc2424">Do <b>Test Configuration</b> above to get configuration for attribute mapping.<br></p>
		<input type="hidden" name="option" value="mo_oauth_attribute_mapping" />
		<input class="mo_table_textbox" required="" type="hidden" id="mo_oauth_app_name" name="mo_oauth_app_name" value="<?php echo $currentappname;?>">
		<input class="mo_table_textbox" required="" type="hidden" name="mo_oauth_custom_app_name" value="<?php echo $currentappname;?>">
		<table class="mo_settings_table">
			<tr id="mo_oauth_email_attr_div">
				<td><strong><font color="#FF0000">*</font>Email attribute:</strong></td>
				<td><input class="mo_table_textbox" required="" placeholder="Email Attribute Name" type="text" id="mo_oauth_email_attr" name="mo_oauth_email_attr" value="<?php if(isset( $currentapp['email_attr']))echo $currentapp['email_attr'];?>"></td>
			</tr>
			<tr id="mo_oauth_name_attr_div">
				<td><strong><font color="#FF0000">*</font>First Name Attribute:</strong></td>
				<td><input class="mo_table_textbox" required="" placeholder="FirstName Attribute Name" type="text" id="mo_oauth_name_attr" name="mo_oauth_name_attr" value="<?php if(isset( $currentapp['name_attr'])) echo $currentapp['name_attr'];?>"></td>
			</tr>
			
			
		<?php
		echo '<tr>
			<td><strong>Last Name Attribute:</strong></td>
			<td>
				<p>Custom attribute mapping is available in <a href="admin.php?page=mo_oauth_settings&amp;tab=licensing"><b>standard</b></a> version.</p>
				<input type="text" name="oauth_client_am_last_name" placeholder="LastName Attribute Name" style="width: 350px;" value="" readonly /></td>
		  </tr>
		  <tr>
			<td><strong>Username Attribute:</strong></td>
			<td><input type="text" name="oauth_client_am_group_name" placeholder="Username Attribute Name" style="width: 350px;" value="" readonly /></td>
		  </tr>
		  <tr>
			<td><strong>Group Attribute Name:</strong></td>
			<td><input type="text" name="oauth_client_am_group_name" placeholder="Group Attribute Name" style="width: 350px;" value="" readonly /></td>
		  </tr>
		  <tr>
			<td><strong>Display Name:</strong></td>
			<td>
				<select disabled style="background-color: #eee;">
					<option>FirstName</option>
				</select>
			</td></tr>';?>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Save settings"
					class="button button-primary button-large" /></td>
			</tr>
			</table>
		</form>
		</div>

		

		<div class="mo_table_layout" id="role-mapping">
		<h3>Role Mapping (Optional)</h3>
		<p>Role mapping is available in <a href="admin.php?page=mo_oauth_settings&amp;tab=licensing"><b>premium</b></a> version.</p>
		<table width="100%">
			<p><input disabled type="checkbox" name="keep_existing_user_roles" value="" /><strong> Keep existing user roles</strong><small class="premium_feature"> [PREMIUM]</small><br><small>Role mapping won't apply to existing wordpress users.</small></p>
				<p><input disabled type="checkbox" name="restrict_login_for_mapped_roles" value="" > <strong> Do Not allow login if roles are not mapped here </strong><small class="premium_feature"> [PREMIUM]</small></p><small>We won't allow users to login if we don't find users role/group mapped below.</small></p>
			    <tr><td>&nbsp;</td></tr>
						<tr>
							<td><font style="font-size:13px;font-weight:bold;">Default Role </font><small class="premium_feature"> [STANDARD]</small>
							</td>
							<td>
								<select disabled name="mapping_value_default" style="width:100%" id="default_group_mapping" >
								   <?php
									 wp_dropdown_roles('Subscriber');
									 ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan=2><i> Default role will be assigned to all users for which mapping is not specified.</i></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td style="width:50%"><b><?php echo 'Group Attribute Value';?></b><small class="premium_feature"> [PREMIUM]</small></td>
							<td style="width:50%"><b>WordPress Role</b></td>
						</tr>
						
						<tr>
							<td><input disabled class="mo_oauth_client_table_textbox" type="text" name="mapping_key_1"
								 value="" placeholder="group name" />
							</td>
							<td>
								<select disabled name="mapping_value_1" id="role" style="width:100%" >
								</select>
							</td>
						</tr>
						<tr><td><a style=" " id="add_mapping">Add More Mapping</a><br><br></td><td>&nbsp;</td></tr>
						<tr>
							<td><input type="submit" class="button button-primary button-large" value="Save Mapping" /></td>
							<td>&nbsp;</td>
						</tr>
				</tbody></table>
				<script>
		function testConfiguration(){
			var mo_oauth_app_name = jQuery("#mo_oauth_app_name").val();
			var myWindow = window.open('<?php echo site_url(); ?>' + '/?option=testattrmappingconfig&app='+mo_oauth_app_name, "Test Attribute Configuration", "width=600, height=600");
		}
		</script>
		<?php
}

function mo_oauth_delete_app($appname){
	$appslist = get_option('mo_oauth_apps_list');
	foreach($appslist as $key => $app){
		if($appname == $key){
			unset($appslist[$key]);
			if($appname=="eveonline" || $appname=="EveOnlineApp")
				update_option( 'mo_oauth_eveonline_enable', 0);
			else
				delete_option( "mo_oauth_app_name_".$appname); //delete appgroup
		}
	}
	update_option('mo_oauth_apps_list', $appslist);
}

function mo_oauth_apps_config_old() { 
	?>
			<!-- Google configurations -->
		<form id="form-google" name="form-google" method="post" action="" style="display:none">
			<input type="hidden" name="option" value="mo_oauth_google" />
			<input type="hidden" name="mo_oauth_google_scope" value="email" />
			<div class="mo_table_layout">
				<div id="toggle2" class="panel_toggle">
					<h3>Login with Google</h3>
				</div>
				<div id="panel2">
					<table class="mo_settings_table">
						<tr>
							<td class="mo_table_td_checkbox"><input type="checkbox"
								id="google_enable" name="mo_oauth_google_enable" value="1"
								<?php checked( get_option('mo_oauth_google_enable') == 1 );?> /><strong>Enable
									Google</strong></td>
							<td></td>
						</tr>
						<tr>
							<td><strong><font color="#FF0000">*</font>Client ID:</strong></td>
							<td><input class="mo_table_textbox" required class="textbox"
								type="text" placeholder="Click on Help to know more"
								name="mo_oauth_google_client_id"
								value="<?php echo get_option('mo_oauth_google_client_id'); ?>" /></td>
						</tr>

						<tr>
							<td><strong><font color="#FF0000">*</font>Client Secret:</strong></td>
							<td><input class="mo_table_textbox" required type="text"
								placeholder="Click on Help to know more"
								name="mo_oauth_google_client_secret"
								value="<?php echo get_option('mo_oauth_google_client_secret'); ?>" /></td>
						</tr>

						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit" value="Save settings"
								class="button button-primary button-large" />&nbsp;&nbsp; <input
								type="button" id="google_help" class="help" value="Help" /></td>
						</tr>
						<tr>
							<td colspan="2" id="google_instru" hidden>
								<p>
									<strong>Instructions:</strong>

								<ol>
									<li>Visit the Google website for developers <a
										href='https://console.developers.google.com/project'
										target="_blank">console.developers.google.com</a>.
									</li>
									<li>At Google, create a new Project and enable the Google+ API.
										This will enable your site to access the Google+ API.</li>
									<li>At Google, provide <b><?php echo site_url();?></b>
										for the new Project's Redirect URI.
									</li>
									<li>At Google, you must also configure the Consent Screen with
										your Email Address and Product Name. This is what Google will
										display to users when they are asked to grant access to your
										site/app.</li>
									<li>Paste your Client ID/Secret provided by Google into the
										fields above.</li>
									<li>Click on the Save settings button.</li>
									<li>Go to Appearance->Widgets. Among the available widgets you
										will find miniOrange OAuth, drag it to the widget area where
										you want it to appear.</li>
									<li>Now logout and go to your site. You will see a login link
										where you placed that widget.</li>
								</ol>
								</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		<!-- Eveonline configurations -->
		<form id="form-eveonline" name="form-eveonline" method="post"
			action="">
			<input type="hidden" name="option" value="mo_oauth_eveonline" /> <input
				type="hidden" name="mo_oauth_eveonline_scope" value="" />
			<!--value of scope?-->
			<div class="mo_table_layout">
				<div id="toggle3" class="panel_toggle">
					<h3>Login with EVE Online</h3>
				</div>
				<div id="panel3">
					<table class="mo_settings_table">
						<tr>
							<td class="mo_table_td_checkbox"><input type="checkbox"
								id="eve_enable" name="mo_oauth_eveonline_enable" value="1"
								<?php checked( get_option('mo_oauth_eveonline_enable') == 1 );?> /><strong>Enable
									Eveonline</strong></td>
							<td></td>
						</tr>
						<tr>
							<td><strong><font color="#FF0000">*</font>Client ID:</strong></td>
							<td><input class="mo_table_textbox" required type="text"
								placeholder="Click on Help to know more"
								name="mo_oauth_eveonline_client_id"
								value="<?php echo get_option('mo_oauth_eveonline_client_id'); ?>" /></td>
						</tr>

						<tr>
							<td><strong><font color="#FF0000">*</font>Client Secret:</strong></td>
							<td><input class="mo_table_textbox" type="text" required
								placeholder="Click on Help to know more"
								name="mo_oauth_eveonline_client_secret"
								value="<?php echo get_option('mo_oauth_eveonline_client_secret'); ?>" pattern="[a-zA-Z0-9\s]+" title="Please do not add any special characters." /></td>
						</tr>
						<tr>
							<td><a href="admin.php?page=mo_oauth_eve_online_setup">Advanced
									Settings</a></td>
							<td><input type="submit" name="submit" value="Save settings"
								class="button button-primary button-large" />&nbsp;&nbsp; <input
								type="button" id="eve_help" value="Help" /></td>
						</tr>
						<tr>
							<td colspan="2" id="eve_instru" hidden>
								<p>
									<strong>Instructions:</strong>

								<ol>
									<li>Log in to your EVE Online account</li>
									<li>At EVE Online, go to Support. Request for enabling OAuth
										for a third-party application.</li>
									<li>At EVE Online, add a new project/application. Generate
										Client ID and Client Secret.</li>
									<li>At EVE Online, set Redirect URL as <b><?php echo site_url();?></b></li>
									<li>Enter your Client ID and Client Secret above.</li>
									<li>Click on the Save settings button.</li>
									<li>Go to Appearance->Widgets. Among the available widgets you
										will find miniOrange OAuth, drag it to the widget area where
										you want it to appear.</li>
									<li>Now logout and go to your site. You will see a login link
										where you placed that widget.</li>
								</ol>
								</p>
							</td>

						</tr>
					</table>
				</div>
			</div>
		</form>

		<!-- Facebook -->
		<form id="form-facebook" name="form-facebook" method="post" action=""  style="display:none">
			<input type="hidden" name="option" value="mo_oauth_facebook" />
			<input type="hidden" name="mo_oauth_facebook_scope" value="email" />
			<div class="mo_table_layout">
				<div id="toggle4" class="panel_toggle">
					<h3>Login with Facebook</h3>
				</div>
				<div id="panel4">
					<table class="mo_settings_table">
						<tr>
							<td class="mo_table_td_checkbox"><input type="checkbox"
								id="facebook_enable" name="mo_oauth_facebook_enable" value="1"
								<?php checked( get_option('mo_oauth_facebook_enable') == 1 );?> /><strong>Enable
									Facebook</strong></td>
							<td></td>
						</tr>
						<tr>
							<td><strong><font color="#FF0000">*</font>App ID:</strong></td>
							<td><input class="mo_table_textbox" required class="textbox"
								type="text" placeholder="Click on Help to know more"
								name="mo_oauth_facebook_client_id"
								value="<?php echo get_option('mo_oauth_facebook_client_id'); ?>" /></td>
						</tr>

						<tr>
							<td><strong><font color="#FF0000">*</font>App Secret:</strong></td>
							<td><input class="mo_table_textbox" required type="text"
								placeholder="Click on Help to know more"
								name="mo_oauth_facebook_client_secret"
								value="<?php echo get_option('mo_oauth_facebook_client_secret'); ?>" /></td>
						</tr>

						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit" value="Save settings"
								class="button button-primary button-large" />&nbsp;&nbsp; <input
								type="button" id="facebook_help" class="help" value="Help" /></td>
						</tr>
						<tr>
							<td colspan="2" id="facebook_instru" hidden>
								<p>
									<strong>Instructions:</strong>

								<ol>
									<li>Go to Facebook developers console <a
										href='https://developers.facebook.com/apps/'
										target="_blank">https://developers.facebook.com/apps/</a>.
									</li>
									<li>Click on Create a New App/Add new App button. You will need to register as a Facebook developer to create an App.</li>
									<li>Enter <b>Display Name</b>. And choose category.</li>
									<li>Click on <b>Create App ID</b>.</li>
									<li>From the left pane, select <b>Settings</b>.</li>
									<li>From the tabs above, select <b>Advanced</b>.</li>
									<li>Under <b>Client OAuth Settings</b>, enter <b><?php echo site_url();?></b> in Valid OAuth redirect URIs and click <b>Save Changes</b>.</li>
									<li>Paste your App ID/Secret provided by Facebook into the
										fields above.</li>
									<li>Click on the Save settings button.</li>
									<li>Go to Appearance->Widgets. Among the available widgets you
										will find miniOrange OAuth, drag it to the widget area where
										you want it to appear.</li>
									<li>Now logout and go to your site. You will see a login link
										where you placed that widget.</li>
								</ol>
								</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>

</div>

<?php
}
function mo_eve_online_config() {
	
	//mo_oauth_client_menu("mo_oauth_eve_online_setup");
?>
<div id="tab">
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab" href="admin.php?page=mo_oauth_settings">Configure Apps</a>
		<a class="nav-tab nav-tab-active" href="admin.php?page=mo_oauth_eve_online_setup">Advanced EVE Online Settings</a>
		<a class="nav-tab" href="admin.php?page=mo_oauth_settings&tab=customization">Customizations</a>
		<a class="nav-tab" href="admin.php?page=mo_oauth_settings&tab=signinsettings">Sign In Settings</a>
		<a class="nav-tab" href="admin.php?page=mo_oauth_settings&tab=licensing">Licensing Plans</a>
		<a class="nav-tab" href="admin.php?page=mo_oauth_settings&tab=faq">FAQ</a>
	</h2>
</div>

<div id="mo_eve_online_config">
		<?php
	$customerRegistered = mo_oauth_is_customer_registered ();
	if ($customerRegistered) {
		if (! get_option ( 'mo_oauth_eveonline_enable' )) {
			?>
				<h4>NOTE: Please enable EVE Online app to see Advanced EVE Online Settings dashboard.</h4>
				<?php
		} else {
			?>

	<!--Get list of allowed and denied corporations-->
	<form id="mo_eve_save_allowed" name="mo_eve_save_allowed" method="post"
		action="">
		<input type="hidden" name="option" value="mo_eve_save_allowed" />
		<div class="mo_eve_table_layout">
			<h4>Please choose the Corporations, Alliances or Character ID's to be allowed. If none are mentioned, by default all corporations and alliances will be allowed.</h4>
			<table class="mo_settings_table">
				<tr>
					<td class="col1"><strong>Allowed Corporations:</strong></td>
					<td><input class="mo_eve_table_textbox"
						placeholder="Enter Corporation ID separared by comma( , )"
						class="textbox" type="text" name="mo_eve_allowed_corps"
						value="<?php echo get_option('mo_eve_allowed_corps');?>" /></td>
				</tr>

				<tr>
					<td class="col1"><strong>Allowed Alliances:</strong></td>
					<td><input class="mo_eve_table_textbox"
						placeholder="Enter Alliance ID separared by comma( , )"
						type="text" name="mo_eve_allowed_alliances"
						value="<?php echo get_option('mo_eve_allowed_alliances');?>" /></td>
				</tr>

				<tr>
					<td class="col1"><strong>Allowed Characters (Character ID's):</strong></td>
					<td><input class="mo_eve_table_textbox"
						placeholder="Enter Character ID separared by comma( , )"
						type="text" name="mo_eve_allowed_char_name"
						value="<?php echo get_option('mo_eve_allowed_char_name');?>" /></td>
				</tr>
				<tr>
					<td class="col1">&nbsp;</td>
					<td><input type="submit" name="submit" value="Save"
						class="button button-primary button-large" /></td>
				</tr>
				<!--<tr>
					<td colspan="2">
						<p>
							<strong>How do I see my Corporation, Alliance and Character Name
								from EVE Online?</strong> <br /> You can view your Corporation,
							Alliance and Character Name in your Edit Profile. Copy the
							following code in the end of your theme's `Theme
							Functions(functions.php)`. You can find `Theme
							Functions(functions.php)` in `Appearance->Editor`. <br />
							<br />
							<code>
								add_action( 'show_user_profile', 'mo_oauth_my_show_extra_profile_fields' );<br />
								add_action( 'edit_user_profile', 'mo_oauth_my_show_extra_profile_fields' );
							</code>
						</p>
					</td>

				</tr>-->
			</table>
		</div>
	</form>
				<?php
			}
			?>
			</div>
<?php
		} else {
			?>
<h4>NOTE: Please first Register with miniOrange and then enable EVE Online app to see Advanced EVE Online Settings dashboard.</h4>
<?php
		}
	}
	function miniorange_support(){
?>
	<div class="mo_support_layout">
		<div>
			<h3>Contact Us</h3>
			<p>Need any help? Couldn't find an answer in <a href="<?php echo add_query_arg( array('tab' => 'faq'), $_SERVER['REQUEST_URI'] ); ?>">FAQ</a>?<br>Just send us a query so we can help you.</p>
			<form method="post" action="">
				<input type="hidden" name="option" value="mo_oauth_contact_us_query_option" />
				<table class="mo_settings_table">
					<tr>
						<td><input type="email" class="mo_table_textbox" required name="mo_oauth_contact_us_email" placeholder="Enter email here"
						value="<?php echo get_option("mo_oauth_admin_email"); ?>"></td>
					</tr>
					<tr>
						<td><input type="tel" id="contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" placeholder="Enter phone here" class="mo_table_textbox" name="mo_oauth_contact_us_phone" value="<?php $phone_no = get_option('mo_oauth_admin_phone'); if( $phone_no != "false" ) echo $phone_no; ?>"></td>
					</tr>
					<tr>
						<td><textarea class="mo_table_textbox" onkeypress="mo_oauth_valid_query(this)" placeholder="Enter your query here" onkeyup="mo_oauth_valid_query(this)" onblur="mo_oauth_valid_query(this)" required name="mo_oauth_contact_us_query" rows="4" style="resize: vertical;"></textarea></td>
					</tr>
				</table>
				<div style="text-align:center;">
					<input type="submit" name="submit" style="margin:15px; width:100px;" class="button button-primary button-large" />
				</div>
				<p>If you want custom features in the plugin, just drop an email at <a href="mailto:info@xecurify.com">info@xecurify.com</a>.</p>
			</form>
		</div>
	</div>
	<script>
		jQuery("#contact_us_phone").intlTelInput();
		function mo_oauth_valid_query(f) {
			!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
					/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
		}
	</script>
	<br/>
		<div class="mo_support_layout">
			<div>
				<p><b>Looking for user provisioning? </b><a href="https://www.miniorange.com/wordpress-miniorange-scim-user-provisioner-with-onelogin">Click here </a> to know more about miniOrange SCIM User Provisioner Add-On.<br></p>
			</div>
		</div>
		<br/>
		<div class="mo_support_layout">
			<div>
				<p>Looking for Wordpress OAuth Server plugin? Now create your own WordPress site as OAuth Server.
				</p>

			<script type='text/javascript'>
			<!--//--><![CDATA[//><!--
			!function(a,b){"use strict";function c(){if(!e){e=!0;var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");for(c=0;c<i.length;c++){if(d=i[c],!d.getAttribute("data-secret"))f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f);if(g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)}}}var d=!1,e=!1;if(b.querySelector)if(a.addEventListener)d=!0;if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){var d=c.data;if(d)if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');for(e=0;e<k.length;e++)k[e].style.display="none";for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){if(f.removeAttribute("style"),"height"===d.message){if(g=parseInt(d.value,10),g>1e3)g=1e3;else if(~~g<200)g=200;f.height=g}if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value}else;}},d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)}(window,document);
				//--><!]]>
			</script><iframe sandbox="allow-scripts" security="restricted" src="https://wordpress.org/plugins/miniorange-oauth-20-server/embed/" width="350" height="230" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" class="wp-embedded-content"></iframe>
			</div>
		</div>
<?php
}


function mo_oauth_jkhuiysuayhbw($ejhi, $nabnbj)
{
	$option = 0; $flag = false;	
	if(!empty(get_option( 'mo_oauth_authorizations' )))
	   	$option = get_option( 'mo_oauth_authorizations' ); 
	if(mo_oauth_hjsguh_kiishuyauh878gs($ejhi, $nabnbj));								
		++$option;							
	update_option( 'mo_oauth_authorizations', $option);
	if($option >= 10)
	{
		$mo_oauth_set_val = base64_decode('bW9fb2F1dGhfZmxhZw==');
	    update_option($mo_oauth_set_val, true);
	}
}

function mo_oauth_show_otp_verification(){
	?>
		<!-- Enter otp -->
		<form name="f" method="post" id="otp_form" action="">
			<input type="hidden" name="option" value="mo_oauth_validate_otp" />
				<div class="mo_table_layout">
					<div id="panel5">
						<table class="mo_settings_table">
							<h3>Verify Your Email</h3>
							<tr>
								<td><b><font color="#FF0000">*</font>Enter OTP:</b></td>
								<td><input class="mo_table_textbox" autofocus="true" type="text" name="mo_oauth_otp_token" required placeholder="Enter OTP" style="width:61%;" pattern="[0-9]{6,8}"/>
								 &nbsp;&nbsp;<a style="cursor:pointer;" onclick="document.getElementById('mo_oauth_resend_otp_form').submit();">Resend OTP</a></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><br /><input type="submit" name="submit" value="Validate OTP" class="button button-primary button-large" />

									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" name="back-button" id="mo_oauth_back_button" onclick="document.getElementById('mo_oauth_change_email_form').submit();" value="Back" class="button button-primary button-large" />
								</td>
							</tr>
						</table>

				</div>
		</form>
		<form name="f" id="mo_oauth_resend_otp_form" method="post" action="">
			<?php


			if(get_option('mo_oauth_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_oauth_registration_status') == 'MO_OTP_VALIDATION_FAILURE') {
				echo '<input type="hidden" name="option" value="mo_oauth_resend_otp_email"/>';
			} else {
				echo '<input type="hidden" name="option" value="mo_oauth_resend_otp_phone"/>';
			}
			?>
		</form>
		<form id="mo_oauth_change_email_form" method="post" action="">
			<input type="hidden" name="option" value="mo_oauth_change_email" />
		</form>
		<?php

			if(get_option('mo_oauth_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_oauth_registration_status') == 'MO_OTP_DELIVERED_FAILURE'|| get_option('mo_oauth_registration_status')=='MO_OTP_VALIDATION_FAILURE') {
			echo '<hr>

			<h3>I did not recieve any email with OTP . What should I do ?</h3>
			<form id="mo_oauth_register_with_phone_form" method="post" action="">
				<input type="hidden" name="option" value="mo_oauth_register_with_phone_option" />
				If you cannot see the email from miniOrange in your mails, please check your <b>SPAM</b> folder. If you don\'t see an email even in the SPAM folder, verify your identity with our alternate method.
				<br><br>
				<b>Enter your valid phone number here and verify your identity using one time passcode sent to your phone.</b><br><br>
				<input class="mo_oauth_table_textbox" type="tel" id="phone_contact" style="width:40%;"
				pattern="[\+]\d{11,14}|[\+]\d{1,4}([\s]{0,1})(\d{0}|\d{9,10})" class="mo_oauth_table_textbox" name="phone"
				title="Phone with country code eg. +1xxxxxxxxxx" required
				placeholder="Phone with country code eg. +1xxxxxxxxxx"
				value="'. get_site_option('mo_oauth_admin_phone').'" />
				<br /><br /><input type="submit" value="Send OTP" class="button button-primary button-large" />

			</form>';
		}?></div>
<?php
}

function mo_oauth_jhuyn_jgsukaj($temp_var, $ntemp)
{
	mo_oauth_jkhuiysuayhbw($temp_var, $ntemp);
}

function mo_oauth_hbca_xyake(){if(get_option('mo_oauth_admin_customer_key') > 135430)return true;else return false;}

function mo_oauth_client_reports(){
	
	$disabled = true;
	echo'<div class="mo_oauth_premium_option_text"><span style="color:red;">*</span>This is a enterprise feature. 
		<a href="admin.php?page=mo_oauth_settings&tab=licensing">Click Here</a> to see our full list of Enterprise Features.</div>
		<div class="mo_table_layout mo_oauth_premium_option">
		<div class="mo_oauth_client_small_layout">';
	echo'<h2>Login Transactions Report</h2>
			<div class="mo_oauth_client_small_layout hidden">	
				<div style="float:right;margin-top:10px">
					<input type="submit" '.$disabled.' name="printcsv" style="width:100px;" value="Print PDF" class="button button-success button-large">
					<input type="submit" '.$disabled.' name="printpdf" style="width:100px;" value="Print CSV" class="button button-success button-large">
				</div>
				<h3>Advanced Report</h3>
				
				<form id="mo_oauth_client_advanced_reports" method="post" action="">
					<input type="hidden" name="option" value="mo_oauth_client_advanced_reports">
					<table style="width:100%">
					<tr>
					<td width="33%">WordPress Username : <input class="mo_oauth_client_table_textbox" type="text" '.$disabled.' name="username" required="" placeholder="Search by username" value=""></td>
					<td width="33%">IP Address :<input class="mo_oauth_client_table_textbox" type="text" '.$disabled.' name="ip" required="" placeholder="Search by IP" value=""></td>
					<td width="33%">Status : <select '.$disabled.' name="status" style="width:100%;">
						  <option value="success" selected="">Success</option>
						  <option value="failed">Failed</option>
						</select>
					</td>
					</tr>
					<tr><td><br></td></tr>
					<tr>
					<td width="33%">User Action : <select '.$disabled.' name="action" style="width:100%;">
						  <option value="login" selected="">User Login</option>
						  <option value="register">User Registeration</option>
						</select>
					</td>
					<td width="33%">From Date : <input '.$disabled.' class="mo_oauth_client_table_textbox" type="date"  name="fromdate"></td>
					<td width="33%">To Date :<input '.$disabled.' class="mo_oauth_client_table_textbox" type="date"  name="todate"></td>
					</tr>
					</table>
					<br><input type="submit" '.$disabled.' name="Search" style="width:100px;" value="Search" class="button button-primary button-large">
				</form>
				<br>
			</div>
			
			<table id="login_reports" class="display" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>IP Address</th>
						<th>Username</th>
						<th>Status</th>
		                <th>TimeStamp</th>
		            </tr>
		        </thead>
		        <tbody>';
		           
echo'	        </tbody>
		    </table>
		</div>
		
	</div>';

}

?>