<?php
/**
 * Plugin Name:     CPT-onomies: Easiest way to create Custom Post Types
 * Plugin URI:      http://wordpress.org/plugins/cpt-onomies/
 * Description:     Use your custom post types as taxonomies. Create powerful relationships between your posts and, therefore, powerful content.
 * Version:         1.4.0
 * Author:          hypestudio,dejanmarkovic,freemius,nytogroup
 * Author URI:      https://hypestudio.org
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     cpt-onomies
 * Domain Path:     /languages
 */
/*
 *  This plugin was created by  Rachel Carden. HYPEStudio has adopted it in order to keep it alive.
 * */

/*
	function cptoxs_fs() {
		global $cptoxs_fs;

		if ( ! isset( $cptoxs_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$cptoxs_fs = fs_dynamic_init( array(
				'id'                => '2507',
				'slug'              => 'cpt-onomies',
				'public_key'        => 'pk_e209d36dd975fc9defad36a529373',
				'is_premium'        => false,
				'has_addons'        => false,
				'has_paid_plans'    => false,
				'menu'              => array(
					'slug'       => 'options-general.php?page=custom-post-type-onomies',
					'account'    => true,

				),
			) );
		}

		return $cptoxs_fs;
	}

// Init Freemius.
	cptoxs_fs();
*/

/*
// Create a helper function for easy SDK access.
	function cptoxs_fs() {
		global $cptoxs_fs;

		if ( ! isset( $cptoxs_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$cptoxs_fs = fs_dynamic_init( array(
				'id'                  => '2507',
				'slug'                => 'cpt-onomies',
				'type'                => 'plugin',
				'public_key'          => 'pk_e209d36dd975fc9defad36a529373',
				'is_premium'          => false,
				'has_addons'          => false,
				'has_paid_plans'      => false,
				'menu'                => array(
					'slug'           => 'options-general.php?page=custom-post-type-onomies',
					'account'        => true,
					'support'    => true,
					'contact'    => true,
				),
			) );
		}

		return $cptoxs_fs;
	}
*/

/*
	//Create a helper function for easy SDK access.
function cptoxs_fs() {
	global $cptoxs_fs;

	if ( ! isset( $cptoxs_fs ) ) {
		// Include Freemius SDK.
		require_once dirname(__FILE__) . '/freemius/start.php';

		$cptoxs_fs = fs_dynamic_init( array(
			'id'                  => '2507',
			'slug'                => 'cpt-onomies',
			'type'                => 'plugin',
			'public_key'          => 'pk_e209d36dd975fc9defad36a529373',
			'is_premium'          => false,
			'has_addons'          => false,
			'has_paid_plans'      => false,
			'menu'                => array(
				'slug'           => 'options-general.php?page=custom-post-type-onomies',
			),
		) );
	}

	return $cptoxs_fs;
}

// Init Freemius.
cptoxs_fs();
// Signal that SDK was initiated.
do_action( 'cptoxs_fs_loaded' );
*/

	function cptoxs_fs() {
		global $cptoxs_fs;

		if ( ! isset( $cptoxs_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$cptoxs_fs = fs_dynamic_init( array(
				'id'                  => '2507',
				'slug'                => 'cpt-onomies',
				'type'                => 'plugin',
				'public_key'          => 'pk_e209d36dd975fc9defad36a529373',
				'is_premium'          => false,
				'has_addons'          => false,
				'has_paid_plans'      => false,
				'menu'                => array(
					'slug'           => 'custom-post-type-onomies',
					'parent'         => array(
						'slug' => 'options-general.php',
					),
				),
			) );
		}

		return $cptoxs_fs;
	}

// Init Freemius.
	cptoxs_fs();
// Signal that SDK was initiated.
	do_action( 'cptoxs_fs_loaded' );
/*
// Signal that SDK was initiated.
	do_action( 'cptoxs_fs_loaded' );
// Customize msg
	function cptoxs_custom_connect_message(
		$message,
		$user_first_name,
		$plugin_title,
		$user_login,
		$site_link,
		$freemius_link
	) {
		return sprintf(
			__fs( 'hey-x' ) . '<br>' .
			__( 'In order to enjoy all our features and functionality, %s needs to connect your user, %s at %s, to %s', 'freemius' ),
			$user_first_name,
			'<b>' . $plugin_title . '</b>',
			'<b>' . $user_login . '</b>',
			$site_link,
			$freemius_link
		);
	}

	cptoxs_fs()->add_filter('connect_message', 'cptoxs_custom_connect_message', 10, 6);
*/

	function cptoxs_fs_custom_connect_message_on_update(
		$message,
		$user_first_name,
		$plugin_title,
		$user_login,
		$site_link,
		$freemius_link
	) {
		return sprintf(
			__( 'Hey %1$s' ) . ',<br>' .
			__( 'Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'cpt-onomies' ),
			$user_first_name,
			'<b>' . $plugin_title . '</b>',
			'<b>' . $user_login . '</b>',
			$site_link,
			$freemius_link
		);
	}

	cptoxs_fs()->add_filter('connect_message_on_update', 'cptoxs_fs_custom_connect_message_on_update', 10, 6);
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If you define them, will they be used?
define( 'CPT_ONOMIES_VERSION', '1.3.7' );
define( 'CPT_ONOMIES_PLUGIN_DIRECTORY_URL', 'http://wordpress.org/extend/plugins/cpt-onomies/' );
define( 'CPT_ONOMIES_PLUGIN_FILE', 'cpt-onomies/cpt-onomies.php' );
define( 'CPT_ONOMIES_OPTIONS_PAGE', 'custom-post-type-onomies' ); // @TODO remove when we create admin class
define( 'CPT_ONOMIES_POSTMETA_KEY', '_custom_post_type_onomies_relationship' ); // @TODO remove when we create admin class

// If we build them, they will load.
require_once plugin_dir_path( __FILE__ ) . 'cpt-onomy.php';
require_once plugin_dir_path( __FILE__ ) . 'manager.php';
require_once plugin_dir_path( __FILE__ ) . 'widgets.php';

// We only need these in the admin.
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin-settings.php';
}

// Extend all the things.
require_once plugin_dir_path( __FILE__ ) . 'extend/gravity-forms-custom-post-types.php';

/**
 * Our main plugin class.
 *
 * Class    CPT_onomies
 * @since   1.3.5
 */
class CPT_onomies {

	/**
	 * Whether or not this plugin is network active.
	 *
	 * @since	1.3.5
	 * @access	public
	 * @var		boolean
	 */
	public $is_network_active;

	/**
	 * Holds the class instance.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @var		CPT_onomies
	 */
	private static $instance;

	/**
	 * Returns the instance of this class.
	 *
	 * @access  public
	 * @since   1.3.5
	 * @return	CPT_onomies
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			$class_name = __CLASS__;
			self::$instance = new $class_name;
		}
		return self::$instance;
	}

	/**
	 * Let's warm up the engine.
	 *
	 * @access  protected
	 * @since   1.3.5
	 */
	protected function __construct() {

		// Is this plugin network active?
		$this->is_network_active = is_multisite() && ( $plugins = get_site_option( 'active_sitewide_plugins' ) ) && isset( $plugins[ CPT_ONOMIES_PLUGIN_FILE ] );

		// Load our text domain.
		add_action( 'init', array( $this, 'textdomain' ) );

		// Runs on install.
		register_activation_hook( __FILE__, array( $this, 'install' ) );

		// Runs when the plugin is upgraded.
		add_action( 'upgrader_process_complete', array( $this, 'upgrader_process_complete' ), 1, 2 );

	}

	/**
	 * Method to keep our instance from being cloned.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @return	void
	 */
	private function __clone() {}

	/**
	 * Method to keep our instance from being unserialized.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @return	void
	 */
	private function __wakeup() {}

	/**
	 * Runs when the plugin is installed.
	 *
	 * @access  public
	 * @since   1.3.5
	 */
	public function install() {

		/*
		 * Rewrite rules can be a pain in the ass
		 * so let's flush them out and start fresh.
		 */
		flush_rewrite_rules( false );

	}

	/**
	 * Runs when the plugin is upgraded.
	 *
	 * @access  public
	 * @since   1.3.5
	 * @param   Plugin_Upgrader $upgrader   Plugin_Upgrader instance.
	 * @param   array $upgrade_info         Array of bulk item update data.
	 *              @type string $action   Type of action. Default 'update'.
	 *              @type string $type     Type of update process. Accepts 'plugin', 'theme', or 'core'.
	 *              @type bool   $bulk     Whether the update process is a bulk update. Default true.
	 *              @type array  $packages Array of plugin, theme, or core packages to update.
	 */
	public function upgrader_process_complete( $upgrader, $upgrade_info ) {

		/*
		 * For some reason I find myself having to flush my
		 * rewrite rules whenever I upgrade WordPress so just
		 * helping everyone out by taking care of this automatically
		 */
		flush_rewrite_rules( false );

	}

	/*
	 * Internationalization FTW.
	 * Load our textdomain.
	 *
	 * @access  public
	 * @since   1.3.5
	 */
	public function textdomain() {
		load_plugin_textdomain( 'cpt-onomies', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

}

/*
 * Returns the instance of our main CPT_onomies class.
 *
 * Will come in handy when we need to access the
 * class to retrieve data throughout the plugin.
 *
 * @since	1.3.5
 * @access	public
 * @return	CPT_onomies
 */
function cpt_onomies() {
	return CPT_onomies::instance();
}

// Let's get this show on the road.
cpt_onomies();


require_once dirname( __FILE__ ) . '/extend/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cptoo_register_required_plugins1' );

function cptoo_register_required_plugins1() {
	$plugins = array (
		array(
			'name' => __( 'Social Web Suite - Social Media Auto Post, Auto Publish and Schedule', 'topcat-lite' ),
			'slug' => 'social-web-suite',
			'required' => false,
		),
	);

	$config = array (
		'id' => 'buffer-my-post',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',

		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'buffer-my-post' ),
			'menu_title'                      => __( 'Install Plugins', 'buffer-my-post' ),

			'installing'                      => __( 'Installing Plugin: %s', 'buffer-my-post' ),

			'updating'                        => __( 'Updating Plugin: %s', 'buffer-my-post' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'buffer-my-post' ),
			'notice_can_install_required'     => _n_noop(
				'This plugin requires the following plugin: %1$s.',
				'This plugin requires the following plugins: %1$s.',
				'buffer-my-post'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This plugin recommends the following plugin: %1$s.',
				'This plugin recommends the following plugins: %1$s.',
				'buffer-my-post'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'buffer-my-post'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'buffer-my-post'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'buffer-my-post'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'buffer-my-post'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'buffer-my-post'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'buffer-my-post'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'buffer-my-post'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'buffer-my-post' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'buffer-my-post' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'buffer-my-post' ),
		),

	);
	tgmpa( $plugins, $config );
}