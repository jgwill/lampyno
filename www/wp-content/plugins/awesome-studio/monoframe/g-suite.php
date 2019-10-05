<?php

class aw2_gsuite_wrapper {

	/**
	 * The single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * Ensures only one instance of this class is loaded.
	 */
	public static function single_instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor for this class.
	 */
	function __construct() {
		add_action( 'wp_loaded', array( $this, 'initialize' ) );
	}

	/**
	* Inculde required files and attach actions/filters.
	*/
	public function initialize(){

		// Retrieve G-Suite OAuth from Settings panel.
		$is_enabled_g_suite_oauth = aw2_library::get("site_settings.opt-g-suite-or-google-authenticator-enable-check" );

		// If G-Suite Authentication is enabled then only, include files and hook actions / filters.
		if( 'g-suite-login' === $is_enabled_g_suite_oauth ) {

			// Autoload G-Suite API.
			require_once __DIR__.'/apis/g-suite/vendor/autoload.php';

			// Hooks Actions and Filters.
			$this->hook_gsuite_actions_filters();
		}
	}

	/**
	 * Hook required G-Suite actions and filters.
	 */
	public function hook_gsuite_actions_filters() {

		// Add Link "login with Google" above login form.
		add_filter( 'login_message', array( $this, 'gsuite_login_with_google' ), 100 );

		// Authenticate G-Suite user and log him in.
		add_filter( 'authenticate', array( $this, 'gsuite_authenticate'), 5, 3 );

		// Enque styles required.
		add_action( 'login_enqueue_scripts', array( $this, 'gsuite_login_form_styles' ) );

		// Add "login with google" link before WP loginform.
		add_action( 'login_footer', array( $this, 'login_with_google_link_before_wp_loginform' ) );

		$turn_off_wp_login = aw2_library::get( "site_settings.opt-g-suite-hide-wp-login" );

		// Hide WP Login if Settings options is set.
		if( ! empty( $turn_off_wp_login ) ) {
			add_filter( 'login_message', array( $this, 'aw2_gsuite_hide_wp_login_form' ) );
		}
	}

	/**
	 * Authenticate G-Suite username and log him in.
	 *
	 * @param  object $user WP_User object.
	 *
	 * @param  string $username Username.
	 *
	 * @param  string $password Password.
	 *
	 * @return WP_User object
	 */
	public function gsuite_authenticate( $user, $username = null, $password = null ) {

		if ( isset( $_GET['code'] ) )	{
			try {

				// Create Google Client Object.
				$client = $this->aw2_google_client();

				// Authenticate to get access token from Google.
				$client->authenticate( $_GET['code'] );

				// New Object of Service OAuth2.
				$google_oauth = new Google_Service_Oauth2( $client );

				// Get the email from the user's data.
				$google_account_email = $google_oauth->userinfo->get()->email;

				// Load the user by email address.
				$user = get_user_by( 'email', $google_account_email );

				// Retrieve hostname from email address.
				$email_domain = explode( '@', $google_account_email );
				$email_domain	= $email_domain[1];

				// Retrieve Hosted Domain from settings panel.
				$gsuite_hosted_domain = aw2_library::get( "site_settings.opt-g-suite-restrict-hosted-doimain" );

				// If user enters a hosted domain in format other than "domain.com", extract just the domain part from it.
				preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $gsuite_hosted_domain, $hosted_domain_extract );

				if( ! empty( $gsuite_hosted_domain ) ) {
					// If e-mail address doesnot match with hosted domain, throw an error.
					if (  $email_domain !== $hosted_domain_extract['domain'] ) {
						throw new Exception( "Sorry, this email is not Registered with the hosted domain '" . $hosted_domain_extract['domain'] . "'");
					}
				}

				// If user object is false, which means user doesnot exists.
				if( false === $user ) {

					// Retrieve create new user flag.
					$create_user_in_wp_flag = aw2_library::get( "site_settings.opt-g-suite-create-user-wp-if-not-exists" );

					if( empty( $create_user_in_wp_flag ) ) {
						// If user doesn't exists with entered G-Suite mail, throw an error.
						throw new Exception( "Sorry, this email is not Registered with G-Suite" );
					} else {

						// Get username.
						$google_account_user_login = $google_oauth->userinfo->get()->name;

						// Get verified email status.
						$verified_email_status = $google_oauth->userinfo->get()->verified_email;

						// If e-mail is not verifed in google, throw an error.
						if ( ! $verified_email_status ) {
							throw new Exception( "Entered Email is not verified with your Google Account, Please verify it." );
						}

						// Format user name according to WP format. For e.g "John Doe" to "john-doe".
						$google_account_user_login = strtolower( str_replace(' ', '-', $google_account_user_login ) );

						// Get user default role, from settings panel.
						$new_user_role = aw2_library::get( "site_settings.opt-g-suite-new-user-assign-role" );

						// Generate password.
						$new_user_password = wp_generate_password();

						// New User options array.
						$userdata = array(
							'user_login' =>  $google_account_user_login,
							'user_email' =>  $google_account_email,
							'user_pass'  =>  $new_user_password,  // When creating an user, `user_pass` is expected.
							'role' 			 => $new_user_role
						);

						// Create new User.
						$new_user_id = wp_insert_user( $userdata );

						if( is_wp_error( $new_user_id ) ) {
							throw new Exception("Sorry, Error while creating user.");
						}

						// Update profile meta from google profile data.
						$this->update_new_user_meta( $new_user_id, $google_oauth->userinfo );

						// load the newly created user object.
						$user = get_userdata( $new_user_id );
					}
				}
			} catch( Exception $gapps_exception ) {

				// If G-Suite API throws error, it has its own method to return error.
				if ( $gapps_exception instanceof Google_Service_Exception ) {

					// Extract message from, G-Suite Exception.
					$error_message = $gapps_exception->getErrors()[0]['message'];
				} else {

					// Else normal Exception is caught.
					$error_message =  $gapps_exception->getMessage();
				}
				$user = new WP_Error( 'g-suite-error', $error_message );
			}
		}
		return $user;
	}

	/**
	 * Hook login_message filter and prepend Login link.
	 *
	 * @param  string $message Username.
	 *
	 * @return string $message.
	 */
	public function gsuite_login_with_google( $message ) {

		// Retrieve Client Id and Client Secret.
		$gsuite_client_id = aw2_library::get( "site_settings.opt-g-suite-client-id" );
		$gsuite_client_secret = aw2_library::get( "site_settings.opt-g-suite-client-secret" );

		// If Client Id and Client Secret is not configured, return an error.
		if ( empty( $gsuite_client_id ) || empty( $gsuite_client_secret ) )	{
			$message .= '<div id="login_error">';
			$message .= 'G-Suite Authentication is not configured correctly. Please contact Administrator.<br>';
			$message .= '</div>';
			return $message;
		}

		// Retrieve Google client object
		$client = $this->aw2_google_client();
		$autologin_flag = true;

		// Create Auth URL.
		$auth_url = $client->createAuthUrl();

		$auto_redirect_to_google_login = aw2_library::get( "site_settings.opt-g-suite-auto-redirect-oauth-login" );

		$logged_out_flag = isset( $_GET['loggedout'] ) ? $_GET['loggedout'] : "";

		if ( isset($_POST['log']) && isset($_POST['pwd']) || ! empty( $logged_out_flag ) || ! empty( $_GET['code'] ))  { // This was a WP username/password login attempt
			$autologin_flag = false;
		}

		// This was a WP username/password login attempt
		if( ! empty( $auto_redirect_to_google_login ) &&  $autologin_flag ) {

			if (! headers_sent() ) {
				wp_redirect($auth_url);
				exit;
			} else {
				// Javascript redirect.
				?>
				<script type="text/javascript">
				window.location = "<?php echo $auth_url; ?>";
				</script>
				<?php
			}
		}
		// Build the "Login With Google" Section.
		$message .= '<div class="aw2_login_with_google_wrapper">';
		$message .= '<p class="aw2_login_with_google">';
		$message .= '<a href="'. $auth_url .'" target="_blank" >';
		$message .= 'Login with Google';
		$message .= '</a>';
		$message .= '</p>';
		$message .= '<p class="aw2_or"> Or';
		$message .= '</p>';
		$message .= '</div>';
		return $message;
	}

	/**
	 * Hook login_message filter and dump css to hide WP login.
	 *
	 * @param string $message Message.
	 *
	 */
	public function aw2_gsuite_hide_wp_login_form( $message ) {
		?>
		<style type="text/css">
		div#login form#loginform p label[for=user_login],
		div#login form#loginform p label[for=user_pass],
		div#login form#loginform p label[for=rememberme],
		div#login form#loginform p.submit,
		div#login p#nav,
		#loginform {
			display: none;
		}
		</style>
		<?php
		// Just return the message.
		return $message;
	}

	/**
	 * Hook login_enqueue_scripts filter and dump CSS for Login link.
	 */
	public function gsuite_login_form_styles() {
		// Enque jQuery on login page.
		wp_enqueue_script('jquery');
		?>
		<style type="text/css">
		.aw2_login_with_google {
			text-align: center;
			color: #72777c;
			font-size: 14px;
			padding: 15px !important;
			background: #fff;
			box-shadow: 0 1px 3px rgba(0,0,0,.13);
		}
		.aw2_login_with_google a {
			text-decoration: none;
		}

		.aw2_or {
			text-align: center;
			margin-top: 20px !important;
		}
		</style>
		<?php
	}

	/**
	 * Add login link before WP login form.
	 */
	public function login_with_google_link_before_wp_loginform() {
		?>
		<script type="text/javascript" >
		jQuery(document).ready( function( $ ) {
			var before_login_form = $('.aw2_login_with_google_wrapper');
			$('#loginform').before( before_login_form );
		});
		</script>
		<?php
	}

	/**
	 * Google Client Object.
	 *
	 * @return object Google Client Object.
	 */
	public function aw2_google_client(){
		// Get the login url.
		$redirect_uri = wp_login_url();

		// Retrieve Client Id and Client secret.
		$client_id = aw2_library::get( "site_settings.opt-g-suite-client-id" );
		$client_secret = aw2_library::get( "site_settings.opt-g-suite-client-secret" );

		// Retireve Hosted domain.
		$hd = aw2_library::get( "site_settings.opt-g-suite-restrict-hosted-doimain" );

		$client = new Google_Client();

		// Scopes array.
		$scopes = array( 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile');
		$client->setScopes($scopes);
		$client->setClientId( $client_id );
		$client->setClientSecret( $client_secret );

		$client->setRedirectUri( $redirect_uri );
		$client->setHostedDomain($hd);
		return $client;
	}

	/**
	 * Uodate user meta according to G-Suite profile data.
	 *
	 * @param int $user_id $user_id.
	 *
	 * @param object Google_Service_Oauth2_Resource_Userinfo User Info object.
	 */
	public function update_new_user_meta( $user_id, $g_suite_user_object ) {
		// id returned from G-Suite.
		update_user_meta( $user_id, 'aw2_gsuite_id', $g_suite_user_object->get()->id );

		// First Name.
		update_user_meta( $user_id, 'first_name', $g_suite_user_object->get()->given_name );

		// Last Name.
		update_user_meta( $user_id, 'last_name', $g_suite_user_object->get()->family_name );

		// Google Plus link.
		update_user_meta( $user_id, 'aw2_gogle_plus_link', $g_suite_user_object->get()->link );

		// Profile picture.
		update_user_meta( $user_id, 'aw2_gsuite_profile_picture', $g_suite_user_object->get()->picture );

		// gender.
		update_user_meta( $user_id, 'aw2_gsuite_gender', $g_suite_user_object->get()->gender );
	}
}

// Load the single instance.
aw2_gsuite_wrapper::single_instance();
