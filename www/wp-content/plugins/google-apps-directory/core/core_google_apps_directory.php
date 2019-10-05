<?php

class core_google_apps_directory {

	// Constructor
	protected function __construct() {
		$this->add_actions();
		register_activation_hook($this->my_plugin_basename(), array( $this, 'gad_activation_hook' ) );
	}

	// Register with GAL

	public function gad_gather_serviceacct_reqs($reqs_array) {
		$reqs_array[] = array('Google Apps Directory',
			array('https://www.googleapis.com/auth/admin.directory.user.readonly'
			=> 'Search for user information in your domain'));
		return $reqs_array;
	}

	public function gad_activation_hook($network_wide) {
		global $gad_core_already_exists;
		if ($gad_core_already_exists) {
			deactivate_plugins( $this->my_plugin_basename() );
			echo( 'Please Deactivate the free version of Google Apps Directory before you activate the new Enterprise version.' );
			exit;
		}
	}

	public function gad_plugins_loaded() {
		load_plugin_textdomain( 'google-apps-directory', false, dirname($this->my_plugin_basename()).'/lang/' );
	}


	// Handle AJAX etc
	// ***************

	protected function get_approved_orgunitpaths() {
		return array();
	}

	protected function get_approved_adminemails() {
		return array();
	}

	protected function are_orgunitpaths_restricted() {
		return false;
	}

	protected function are_orgunitpaths_exact() {
		return false;
	}

	public function gad_directory_search() {

		$options = $this->get_option_gad();
		if (!$options['gad_allow_loggedout'] && !is_user_logged_in()) {
			die (json_encode(Array('error'=> __('You need to be logged in to search', 'google-apps-directory'))));
		}

		$is_table = isset($_POST['gad_istable']) && $_POST['gad_istable'];

		$orgunitpath = '/'; //$is_table ? '/' : '';
		if (isset($_POST['gad_orgunitpath'])) {
			$orgunitpath = trim($_POST['gad_orgunitpath']);
			if ($orgunitpath === '') {
				$orgunitpath = '/';
			}
		}

		$adminemail = '';
		$adminemail_id = '';
		if (isset($_POST['gad_adminemail']) && $_POST['gad_adminemail'] != '') {
			$approved_adminemails = $this->get_approved_adminemails();
			$adminemail_id = $_POST['gad_adminemail'];
			if (isset($approved_adminemails[intval($adminemail_id)])) {
				$adminemail = $approved_adminemails[intval($adminemail_id)];
			}
			else {
				die ( json_encode( Array( 'error' => 'The adminemail value is invalid.' ) ) );
			}

		}

		if ($is_table && $this->are_orgunitpaths_restricted()) {
			if (!in_array($orgunitpath, $this->get_approved_orgunitpaths())) {
				die ( json_encode( Array( 'error' => sprintf(__('Your admin settings for Google Apps Directory restrict the orgunitpaths allowed, and you have not specified "%s"', 'google-apps-directory'), esc_js($orgunitpath)) ) ) );
			}
		}

		$department = isset($_POST['gad_department']) ? trim($_POST['gad_department']) : '';

		$searchstr = '';
		if (isset($_POST['gad_search'])) {
			$searchstr = $_POST['gad_search'];
		}

		$nonce = isset($_POST['gad_nonce']) ? $_POST['gad_nonce'] : '';

		if ($is_table) {
			if (!wp_verify_nonce($nonce, $this->generate_listing_nonce_input($orgunitpath, $adminemail_id))) {
				die ( json_encode( Array( 'error' => __('No permission to make AJAX call for table listing', 'google-apps-directory') ) ) );
			}
		}
		else {
			if (!$this->is_search_widget_allowed()) {
				die ( json_encode( Array( 'error' => __('Search widget is disabled in your Google Apps Directory plugin settings', 'google-apps-directory') ) ) );
			}
			if (!wp_verify_nonce($nonce, 'gad-nonce')) {
				die ( json_encode( Array( 'error' => __('No permission to make AJAX call for search widget', 'google-apps-directory') ) ) );
			}
		}

		if (!$is_table && $searchstr == '') {
			die (json_encode(Array('error'=> __('Please specify a search string', 'google-apps-directory'))));
		}

		// Fetch data

		$outdata = array();

		try {

			$oupaths = explode(';', $orgunitpath); // There may be multiple orgunitpaths

			foreach ($oupaths as $oup) {
			    if ($oup !== '') {
				    $thisoutdata = $this->getGoogleAdminData( $searchstr, $oup, $adminemail, $department );
				    $outdata = array_merge( $outdata, $thisoutdata );
			    }
			}
		}
		catch (Exception $e) {
			die( json_encode(Array('error' => $e->getMessage())) );
		}

		die( json_encode(Array('users'=>$outdata)) );
	}

	function getGoogleAdminData($searchstr, $orgunitpath, $adminemail, $department) {
		$outdata = array();
		$msg = '';

		// Allow a filter to override all the data - e.g. for demo purposes
		$outdata = apply_filters('gad_override_data', $outdata, $searchstr, $orgunitpath);
		if (count($outdata) > 0) {
			return $outdata;
		}

		// Now try to
		if (!function_exists('GoogleAppsLogin')) {
			throw new Exception(__("Google Apps Login plugin needs to be activated and configured", 'google-apps-directory'));
		}

		try {
			$gal = GoogleAppsLogin();

			if (!method_exists($gal, 'get_Auth_AssertionCredentials')) {
				throw new Exception('Requires version 2.5+ of Google Apps Login');
			}

			$cred = $gal->get_Auth_AssertionCredentials(
				array('https://www.googleapis.com/auth/admin.directory.user.readonly'),
				$adminemail
			);

			$serviceclient = $gal->get_Google_Client();

			$serviceclient->setAssertionCredentials($cred);

			// Include paths were set when client was created
			if (!class_exists('GoogleGAL_Service_Directory')) {
				require_once( 'Google/Service/Directory.php' );
			}

			$userservice = new GoogleGAL_Service_Directory($serviceclient);

			$are_orgunitpaths_exact = $this->are_orgunitpaths_exact();

			$nextToken = '';

			do {

				$params = Array('customer' => 'my_customer',
					'pageToken' => $nextToken,
					'projection' => 'full',
					'viewType' => 'admin_view');

				$query = '';

				if ($searchstr != '') {
					$query = esc_js($res = preg_replace("/[:'\\\\<=>\/\"]/", "", $searchstr));
					// No longer surround with quotes when supplied to the API
					// if $searchstr == "dan lester", this means the API implicitly ANDs the two words
					// so must find dan in either givenName,familyName, or email AND must find lester in either givenName,familyName, or email

					// If we also add e.g. orgUnitPath='\' so $query == "dan lester orgUnitPath='/'"
					// this means all three clauses must match
				}
				if ($orgunitpath != '' && $orgunitpath != '/') {
					$query .= sprintf(" orgUnitPath='%s'", esc_js($orgunitpath));
				}

				if ($department != '') {
					$query .= sprintf(" orgDepartment='%s'", esc_js($department));
				}

				if ($query != '') {
					$params['query'] = $query;
				}

				$usersresult = $userservice->users->listUsers($params);

				$usersdata = $usersresult->getUsers();

				foreach ($usersdata as $u) {
					if ($u->getSuspended()) {
						continue;
					}
					if ($are_orgunitpaths_exact && $orgunitpath != '' && $u->getOrgUnitPath() != $orgunitpath) {
						continue;
                    }
					$user_outdata = array(
						'primaryEmail' => $u->getPrimaryEmail(),
						'fullName' => $u->name->getFullName(),
						'givenName' => $u->name->getGivenName(),
						'familyName' => $u->name->getFamilyName(),
						'thumbnailPhotoUrl' => $u->getThumbnailPhotoUrl()
					);
					$user_outdata = apply_filters('gad_extract_user_data', $user_outdata, $u);
					if ($user_outdata) {
						$outdata[] = $user_outdata;
					}
				}

				$nextToken = $usersresult->getNextPageToken();

			} while ($nextToken);

		} catch (GoogleGAL_Service_Exception $ge) {
			$errors = $ge->getErrors();
			$doneerr = false;
			if (is_array($errors) && count($errors) > 0) {
				if (isset($errors[0]['reason'])) {
					switch ($errors[0]['reason']) {
						case 'insufficientPermissions':
							$msg = 'User had insufficient permission to fetch Google User data';
							$doneerr = true;
							break;

						case 'accessNotConfigured':
							$msg = 'You need to enable Admin SDK for your project in Google Cloud Console';
							$doneerr = true;
							break;

						case 'forbidden':
							$msg = 'Forbidden - are you sure the user you entered in Service Account settings is a Google Apps admin?';
							$doneerr = true;
							break;

						case 'invalid':
							$msg = isset($errors[0]['message']) ? $errors[0]['message'] : 'Invalid search input';
							$doneerr = true;
							break;
					}
				}
			}

			if (!$doneerr) {
				$msg = 'Service Error fetching Google Users: '.$ge->getMessage();
			}

		} catch (GoogleGAL_Auth_Exception $ge) {
			$error = $ge->getMessage();
			if (preg_match('/Error refreshing the OAuth2 token.+invalid_grant/s', $error)) {
				/*
				 * When keys don't match etc
				* Error refreshing the OAuth2 token, message: '{ "error" : "invalid_grant" }'
				*/
				$msg = 'Error - please check your JSON key and service account email are still valid in Settings -> Google Apps Login (Service Account settings)';
			}
			else if (preg_match('/Error refreshing the OAuth2 token.+unauthorized_client/s', $error)) {
				/*
				 * When sub is wrong
				* Error refreshing the OAuth2 token, message: '{ "error" : "unauthorized_client", "error_description" : "Unauthorized client or scope in request." }'
				*/
				$msg = 'Error - please check you have named a Google Apps admin\'s email address in Settings -> Google Apps Login (Service Account settings)';
			}
			else if (preg_match('/Error refreshing the OAuth2 token.+access_denied/s', $error)) {
				/*
				 * When scope not entered
				* Google Auth Error fetching Users: Error refreshing the OAuth2 token, message: '{
 				* "error" : "access_denied", "error_description" : "Requested client not authorized."}'
				*/
				$msg = 'Error - please check you have added the required permissions scope to your Google Cloud Console project. See Settings -> Google Apps Login (Service Account settings).';
			}
			else {
				$msg = "Google Auth Error fetching Users: ".$ge->getMessage();
			}
		}
		catch (GAL_Service_Exception $e) {
			$msg = "GAL Error fetching Google Users: ".$e->getMessage();
		}
		catch (Exception $e) {
			$msg = "General Error fetching Google Users: ".$e->getMessage();
		}

		if ($msg != '') {
			throw new Exception($msg);
		}

		return $outdata;
	}

	protected function generate_listing_nonce_input($orgunitpath, $adminemail) {
		return 'gad-listing|'.$orgunitpath.'|'.$adminemail;
	}

	// HOOKS AND FILTERS
	// *****************

	protected function add_actions() {
		add_action('plugins_loaded', array($this, 'gad_plugins_loaded'));

		add_action('init', array($this, 'gad_init'));
		if (is_admin()) {
			add_action( 'admin_init', array( $this, 'gad_admin_init' ) );
			add_action(is_multisite() ? 'network_admin_menu' : 'admin_menu', array($this, 'gad_admin_menu'));
			if (is_multisite()) {
				add_filter('network_admin_plugin_action_links', array($this, 'gad_plugin_action_links'), 10, 2 );
				add_action('network_admin_edit_'.$this->get_options_menuname(), array($this, 'gad_save_network_options'));
			}
			else {
				add_filter( 'plugin_action_links', array($this, 'gad_plugin_action_links'), 10, 2 );
			}
		}
		add_action('widgets_init', array($this, 'gad_widgets_init'));
		add_filter('gal_gather_serviceacct_reqs',  array($this, 'gad_gather_serviceacct_reqs'));

        add_action('wp_ajax_nopriv_gad_directory_search', array($this, 'gad_directory_search'));

		add_action('wp_ajax_gad_directory_search', array($this, 'gad_directory_search'));
	}

	public function gad_widgets_init() {
		if ($this->is_search_widget_allowed()) {
			require_once( plugin_dir_path( __FILE__ ) . '/directory_widget.php' );
			register_widget( 'GAD_Widget' );
		}
	}

	public function gad_init() {
		wp_register_script( 'gad_widget_js', $this->my_plugin_url().'js/gad-widget.js', array('jquery'), $this->PLUGIN_VERSION );
		wp_register_style( 'gad_widget_css', $this->my_plugin_url().'css/gad-widget.css', array(), $this->PLUGIN_VERSION );
		wp_register_style( 'gad_admin_settings_css', $this->my_plugin_url().'css/gad-admin-settings.css', array(), $this->PLUGIN_VERSION );
		wp_register_script( 'gad_admin_settings_tabs_js', $this->my_plugin_url().'js/gad-admin-settings-tabs.js', array('jquery'), $this->PLUGIN_VERSION );
	}

	public function gad_admin_init() {

		register_setting( $this->get_options_pagename(), $this->get_options_name(), Array($this, 'gad_options_validate') );

		// Check Google Apps Login is configured - display warnings if not
		if (apply_filters('gal_get_clientid', '') == '') {
			add_action('admin_notices', Array($this, 'gad_admin_auth_message'));
			if (is_multisite()) {
				add_action('network_admin_notices', Array($this, 'gad_admin_auth_message'));
			}
		}
	}

	public function gad_admin_auth_message() {
		?>
		<div class="error">
			<p>You will need to install and configure
				<a href="http://wp-glogin.com/glogin/?utm_source=Admin%20Configmsg&utm_medium=freemium&utm_campaign=Directory"
				   target="_blank">Google Apps Login</a>
				plugin in order for Google Apps Directory to work. (Free, Premium, or Enterprise version)
			</p>
		</div> <?php
	}

	// ADMIN OPTIONS
	// *************

	public function gad_plugin_action_links( $links, $file ) {
		if ($file == $this->my_plugin_basename()) {
			$settings_link = '<a href="'.$this->get_settings_url().'">Settings</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	protected function get_options_name() {
		return 'gad_directory';
	}

	protected function get_options_menuname() {
		return 'gad_list_options';
	}

	protected function get_options_pagename() {
		return 'gad_options';
	}

	protected function get_settings_url() {
		return is_multisite()
			? network_admin_url( 'settings.php?page='.$this->get_options_menuname() )
			: admin_url( 'options-general.php?page='.$this->get_options_menuname() );
	}

	public function gad_admin_menu() {
		if (is_multisite()) {
			add_submenu_page( 'settings.php', 'Google Apps Directory settings', 'Google Apps Directory',
				'manage_network_options', $this->get_options_menuname(),
				array($this, 'gad_options_do_page'));
		}
		else {
			add_options_page( 'Google Apps Directory settings', 'Google Apps Directory',
				'manage_options', $this->get_options_menuname(),
				array($this, 'gad_options_do_page'));
		}
	}

	public function enqueue_admin_settings_scripts() {
		wp_enqueue_style( 'gad_admin_settings_css' );
		wp_enqueue_script( 'gad_admin_settings_tabs_js' );
	}

	public function gad_options_do_page() {

		$submit_page = is_multisite() ? 'edit.php?action='.$this->get_options_menuname() : 'options.php';

		$this->enqueue_admin_settings_scripts();

		if (is_multisite()) {
			$this->gad_options_do_network_errors();
		}
		?>

		<div>

			<h2>Google Apps Directory setup</h2>

			<?php $this->gad_pretab_options_text(); ?>

			<div id="gad-tablewrapper">

				<?php $this->draw_admin_settings_tabs(); ?>

				<form action="<?php echo $submit_page; ?>" method="post" id="gad_form">

					<?php
					settings_fields($this->get_options_pagename());

					$this->gad_mainsection_text();

					$this->gad_licensesection_text();

					$this->gad_options_submit();
					?>

				</form>
			</div>

			<?php $this->gad_options_do_sidebar(); ?>

		</div>  <?php
	}

	protected function gad_options_do_sidebar() {
	}

	protected function gad_pretab_options_text() {
	}

	protected function draw_admin_settings_tabs() {
		?>
		<h2 id="gad-tabs" class="nav-tab-wrapper">
			<?php $this->draw_admin_settings_tabs_start(); ?>
			<a href="#main" id="main-tab" class="nav-tab nav-tab-active">Main Settings</a>
			<?php $this->draw_admin_settings_tabs_end(); ?>
		</h2>
		<?php
	}

	protected function draw_admin_settings_tabs_start() {
	}

	protected function draw_admin_settings_tabs_end() {
	}

	// Override in Enterprise
	protected function gad_licensesection_text() {
	}

	protected function gad_mainsection_text() {
		$options = $this->get_option_gad();

		echo '<div id="main-section" class="gadtab active">';

		echo "<h3>Security Controls</h3>";
		echo '<label for="input_gad_allow_loggedout" class="textinput big">Allow logged out users to view your Directory</label> &nbsp;';
		echo "<input id='input_gad_allow_loggedout' class='checkbox' name='".$this->get_options_name()."[gad_allow_loggedout]' type='checkbox' ".($options['gad_allow_loggedout'] ? 'checked ' : '')."'/>";

		$this->more_mainsection_text();

		echo '</div>';
	}

	protected function more_mainsection_text() {
	}

	protected function is_search_widget_allowed() {
		return true;
	}

	protected function gad_options_submit() {
		?>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
		</p>
		<?php
	}

	// Options

	public function gad_options_validate($input) {
		$newinput = Array();
		$newinput['gad_version'] = $this->PLUGIN_VERSION;

		$newinput['gad_allow_loggedout'] = isset($input['gad_allow_loggedout']) && $input['gad_allow_loggedout'];

		return $newinput;
	}

	protected function get_error_string($fielderror) {
		return 'Unspecified error';
	}

	public function gad_save_network_options() {
		check_admin_referer( $this->get_options_pagename().'-options' );

		if (isset($_POST[$this->get_options_name()]) && is_array($_POST[$this->get_options_name()])) {
			$inoptions = $_POST[$this->get_options_name()];

			$outoptions = $this->gad_options_validate($inoptions);

			$error_code = Array();
			$error_setting = Array();
			foreach (get_settings_errors() as $e) {
				if (is_array($e) && isset($e['code']) && isset($e['setting'])) {
					$error_code[] = $e['code'];
					$error_setting[] = $e['setting'];
				}
			}

			update_site_option($this->get_options_name(), $outoptions);

			// redirect to settings page in network
			wp_redirect(
				add_query_arg(
					array( 'page' => $this->get_options_menuname(),
						'updated' => true,
						'error_setting' => $error_setting,
						'error_code' => $error_code ),
					network_admin_url( 'admin.php' )
				)
			);
			exit;
		}
	}

	protected function gad_options_do_network_errors() {
		if (isset($_REQUEST['updated']) && $_REQUEST['updated']) {
			?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p>
					<strong>Settings saved</strong>
				</p>
			</div>
			<?php
		}

		if (isset($_REQUEST['error_setting']) && is_array($_REQUEST['error_setting'])
		    && isset($_REQUEST['error_code']) && is_array($_REQUEST['error_code'])) {
			$error_code = $_REQUEST['error_code'];
			$error_setting = $_REQUEST['error_setting'];
			if (count($error_code) > 0 && count($error_code) == count($error_setting)) {
				for ($i=0; $i<count($error_code) ; ++$i) {
					?>
					<div id="setting-error-settings_<?php echo $i; ?>" class="error settings-error">
						<p>
							<strong><?php echo htmlentities2($this->get_error_string($error_setting[$i].'|'.$error_code[$i])); ?></strong>
						</p>
					</div>
					<?php
				}
			}
		}
	}

	// OPTIONS

	protected function get_default_options() {
		return Array('gad_version' => $this->PLUGIN_VERSION,
			'gad_allow_loggedout' => false);
	}

	protected $gad_options = null;
	protected function get_option_gad() {
		if ($this->gad_options != null) {
			return $this->gad_options;
		}

		$option = get_site_option($this->get_options_name(), Array());

		$default_options = $this->get_default_options();
		foreach ($default_options as $k => $v) {
			if (!isset($option[$k])) {
				$option[$k] = $v;
			}
		}

		$this->gad_options = $option;
		return $this->gad_options;
	}


}

