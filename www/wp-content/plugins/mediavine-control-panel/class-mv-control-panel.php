<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * Base Class provides helpers.
 *
 * @category     Class
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */
require_once( 'lib/class-mv-base.php' );

/**
 * Empty Class whose purpose I don't know
 *
 * @category     Class
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */
require_once( 'lib/class-mv-extension.php' );

/**
 * Extends core WP functions that only work in admin to front-end
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( ! class_exists( 'MV_Control_Panel' ) ) {

	/**
	 * Primary class for MCP.
	 *
	 * @category     WordPress_Plugin
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
	class MV_Control_Panel extends MV_Base {

		const VERSION = '2.2.0';

		const DB_VERSION = '0.0.1.0';

		const TEXT_DOMAIN = 'mediavine';

		const PLUGIN_DOMAIN = 'mv_recipe_cards';

		const PREFIX = '_mv_';

		const PLUGIN_FILE_PATH = __FILE__;

		const PLUGIN_ACTIVATION_FILE = 'mediavine-control-panel.php';

		public $api_route = 'mv-control-panel';

		public $api_version = 'v1';

		public static $extensions = array();

		/**
		 * Globalized variables.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $globals = array(
			'did_append_adhesion' => false,
		);

		public $dependencies = array(
			'lib/class-api-services.php',
			'admin/class-admin-init.php',
			'lib/settings/class-settings.php',
			'lib/settings/class-settings-api.php',
			'lib/video/class-video.php',
			'lib/class-mv-identity.php',
			'lib/class-video-sitemap.php',
		);

		/**
		 * Map of file names to Class Names.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $extension_map = array(
			array(
				'folder_name'    => 'amp',
				'file_name'      => 'class-mvamp',
				'extension_name' => 'amp',
				'class_name'     => 'MVAMP',
			),
			array(
				'folder_name'    => 'security',
				'file_name'      => 'class-mv-security',
				'extension_name' => 'security',
				'class_name'     => 'MV_Security',
			),
			array(
				'folder_name'    => 'debug',
				'file_name'      => 'class-mv-debug',
				'extension_name' => 'debug',
				'class_name'     => 'MV_Debug',
			),
			array(
				'folder_name'    => 'adtext',
				'file_name'      => 'class-mv-adtext',
				'extension_name' => 'adtext',
				'class_name'     => 'MV_Adtext',
			),
		);

		/**
		 * Default Settings types.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $settings = array(
			'include_script_wrapper' => 'bool',
			'site_id'                => 'string',
			'disable_admin_ads'      => 'bool',
			'has_loaded_before'      => 'bool',
		);

		/**
		 * Plugin default settings.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $settings_defaults = array(
			'include_script_wrapper' => false,
			'site_id'                => '',
			'disable_admin_ads'      => false,
			'has_loaded_before'      => false,
		);

		/**
		 * Plugin Prefix.
		 *
		 * @since 4.6.0
		 * @var string
		 */
		public $setting_prefix = 'MVCP_';

		/**
		 * Array of Class Extensions.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		private $_extensions = array();

		/**
		 * Constructor for initializing state and dependencies.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function __construct() {
			parent::__construct( $this );

			$this->init_views();
			$this->load_extensions();
			$this->load_v2_dependencies();
		}

		/**
		 * Reliably return the base directory for plugin, important in order to enqueue files elsewhere
		 * @return plugin directory url based on this plugin directory
		 */
		public static function assets_url() {
			return plugin_dir_url( __FILE__ );
		}

		public static function get_activation_path() {
			return dirname( __FILE__ ) . '/' . self::PLUGIN_ACTIVATION_FILE;
		}
		/**
		 * Run through conditionals to maybe enable ads.txt support on activation
		 *
		 * @since 1.9.5
		 */
		public function maybe_enable_ads_txt() {

			if ( get_option( '_mv_mcp_adtext_disabled' ) ) {
				return;
			}

			if ( ! $this->option( 'site_id' ) ) {
				return;
			}

			if ( false === wp_next_scheduled( 'get_ad_text_cron_event' ) ) {
				wp_schedule_event( time(), 'daily', 'get_ad_text_cron_event' );
			}

			return;
		}

		public function primary_plugin_activation() {
			// This runs after all plugins are loaded so it can run after update
			// Check version instead of DB_VERSION for non-custom tables support
			if ( get_option( 'mv_mcp_version' ) === self::VERSION ) {
				return;
			}
			$this->maybe_enable_ads_txt();

			update_option( 'mv_mcp_version', self::VERSION );
			flush_rewrite_rules();
		}

		public function plugin_activation() {
			// This runs after all plugins are loaded so it can run after update
			// Check version instead of DB_VERSION for non-custom tables support
			if ( get_option( 'mv_mcp_version' ) === self::VERSION ) {
				return;
			}
			$this->maybe_enable_ads_txt();

			update_option( 'mv_mcp_version', self::VERSION );
		}

		public function plugin_deactivation() {
			wp_clear_scheduled_hook( 'get_ad_text_cron_event' );
			flush_rewrite_rules();
		}

		/**
		 * Load admin settings views.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function init_views() {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mv_admin_enqueue_scripts' ) );
		}

		/**
		 * Loop dependencies and call load them.
		 *
		 * @ignore
		 * @since 1.0
		 */
		private function load_v2_dependencies() {
			foreach ( $this->dependencies as $file ) {
				$filepath = plugin_dir_path( __FILE__ ) . $file;
				if ( ! $filepath ) {
					triggor_error( sprintf( 'Error location %s for inclusion', $file ), E_USER_ERROR );
				}
				require_once $filepath;
			}
		}

		/**
		 * Loop extensions and call 'load_extension'.
		 *
		 * @ignore
		 * @since 1.0
		 */
		private function load_extensions() {
			foreach ( $this->extension_map as $extension ) {
				try {
					require_once( "extensions/{$extension['folder_name']}/{$extension['file_name']}.php" );
					$this->load_extension_class( $extension['extension_name'], $extension['class_name'] );
				} catch ( Exception $e ) {
					// TODO: Error handling.
				}
			}
		}


		/**
		 * Add extension on to primary class.
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $extension_name Extension name string.
		 * @param string $class_name Class Name.
		 */
		private function load_extension_class( $extension_name, $class_name ) {
			$instance                            = new $class_name();
			self::$extensions[ $extension_name ] = $instance;
		}

		public function admin_notices() {
			$has_token = get_option( 'mcp_mcp-services-api-token' );

			if ( $has_token ) {
				return;
			}

			$screen = get_current_screen();
			if ( ( 'plugins' === $screen->base ) || ( 'dashboard' === $screen->base ) ) {
				echo wp_kses_post(
					'<div class="notice notice-mv">
						<h2>' . __( 'Log In with Mediavine', 'mediavine' ) . '</h2>
						<a class="mv-link-btn mv-modal-btn" style="text-decoration: none" href="' . admin_url( '/options-general.php?page=mediavine_amp_settings' ) . '">' . __( 'Get Started', 'mediavine' ) . '</a>
						<p>' . __( 'If you have logged in before you will need to reauthorize your site.', 'mediavine' ) . '</p>
					</div>'
				);
			}
		}

		/**
		 * Initialize admin UI.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function admin_init() {
			add_filter( 'plugin_action_links_' . MCP_PLUGIN_BASE, array( $this, 'add_action_links' ) );

			$this->initialize_settings();
			$this->get_extension( 'amp' )->initialize_settings();
			$this->get_extension( 'security' )->initialize_settings();

			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}

		public $should_disable_ads = false;

		public $pagebuilders = array(
			'divi-builder/divi-builder.php',
			'thrive-visual-editor/thrive-visual-editor.php',
			'elementor/elementor.php',
			'live-composer-page-builder/live-composer-page-builder.php',
		);

		public function mv_should_disable_ads() {
			if ( ! current_user_can( 'edit_posts' ) ) {
				return;
			}

			$disable_admin_ads = $this->option( 'disable_admin_ads' );
			if ( $disable_admin_ads ) {
				$this->should_disable_ads = true;
				return;
			}

			foreach ( $this->pagebuilders as $item ) {
				$this->should_disable_ads = is_plugin_active( $item );
				if ( true === $this->should_disable_ads ) {
					break;
				}
			}

		}

		public function mv_admin_enqueue_scripts( $hook ) {
			if ( 'settings_page_mediavine_amp_settings' !== $hook ) {
				return;
			}
			wp_register_script( 'mv/intercom.js', plugin_dir_url( __FILE__ ) . 'views/assets/js/intercom.js', array(), null, true );

			$data                 = array();
			$current_user         = wp_get_current_user();
			$data['email']        = $current_user->user_email;
			$data['access_token'] = null;
			$data['site_info']    = '';
			$data['intercom']     = null;

			$token_data = \Mediavine\MCP\Settings::read( 'mcp-services-api-token' );

			if ( isset( $token_data->value ) ) {
				$data['access_token'] = $token_data->value;
			}

			if ( isset( $token_data->data->intercom ) ) {
				$data['intercom'] = $token_data->data->intercom;
			}

			if ( isset( $token_data->data->email ) ) {
				$data['email'] = $token_data->data->email;
			}

			if ( ! empty( $current_user ) ) {
				$data['site_info'] = esc_html( $current_user->display_name ) . ' | Site: ' . esc_url( site_url() );
			}

			wp_localize_script( 'mv/intercom.js', 'mvmcp_intercom', $data, self::VERSION );
			wp_enqueue_script( 'mv/intercom.js' );
		}

		/**
		 * Adds links to plugins page
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $links WP array of links used for admin menus.
		 */
		public function add_action_links( $links ) {
			return array_merge(
				$links, array(
					'<a href="' . admin_url( 'options-general.php?page=mediavine_amp_settings' ) . '">Settings</a>',
					'<a href="https://help.mediavine.com/">Support</a>',
				)
			);
		}

		/**
		 * Add MCP settings page to admin menu.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function admin_menu() {
			add_options_page(
				'Mediavine Control Panel', 'Mediavine Control Panel', 'manage_options', 'mediavine_amp_settings', array(
					$this,
					'render_settings_page',
				)
			);
		}

		/**
		 * Enqueue Mediavine Script Wrapper.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			$this->mv_should_disable_ads();
			$site_id     = $this->option( 'site_id' );
			$use_wrapper = $this->option( 'include_script_wrapper' );
			$customizer  = false;

			if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
				$customizer = true;
			}
			if ( $site_id && $use_wrapper && ! $customizer && ! $this->should_disable_ads ) {
				$this->mv_enqueue_script(
					array(
						'handle' => 'mv-script-wrapper',
						'src'    => '//scripts.mediavine.com/tags/' . $site_id . '.js',
						'attr'   => array(
							'async'          => 'async',
							'data-noptimize' => '1',
							'data-cfasync'   => 'false',
						),
					)
				);
			}

			if ( $this->get_extension( 'amp' )->option( 'disable_amphtml_link' ) ) {
				// Remove the AMP frontend action right before wp_head fires.
				remove_action( 'wp_head', 'amp_add_amphtml_link' );
				remove_action( 'wp_head', 'amp_frontend_add_canonical' );
			}
		}

		/**
		 * Render Settings for MCP.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function render_settings_page() {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( sprintf( '%s/views/settings.php', dirname( __FILE__ ) ) );
		}

		/**
		 * Checks for AMP Plugins.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function hasAMP() {
			return $this->hasAMPOfficial() || $this->hasAMPForWP();
		}


		/**
		 * Checks for Official AMP Plugin.
		 *
		 * @ignore
		 * @since 1.9.4
		 */
		public function hasAMPOfficial() {
			return is_plugin_active( 'amp/amp.php' );
		}

		/**
		 * Gets version of Official AMP Plugin
		 *
		 * @return string plugin version
		 */
		public function AMPOfficialVersion() {
			$plugin_data    = get_plugins();
			$amp            = $plugin_data['amp/amp.php'];
			$plugin_version = $amp['Version'];
			return $plugin_version;
		}

		/**
		 * Checks for AMP Plugin 'AMP for WP'.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function hasAMPForWP() {
			return is_plugin_active( 'accelerated-mobile-pages/accelerated-moblie-pages.php' );
		}


		/**
		 * Returns Extension class for use.
		 *
		 * @ignore
		 * @since 1.0
		 *
		 * @param string $name Name of extension to return.
		 */
		public function get_extension( $name ) {
			if ( array_key_exists( $name, self::$extensions ) ) {
				return self::$extensions[ $name ];
			}

			return false;
		}
	}
}

if ( class_exists( 'MV_Control_Panel' ) ) {
	// instantiate the plugin class.
	$mvcp          = new MV_Control_Panel();
	$video_sitemap = \Mediavine\MCP\Video_Sitemap::get_instance();

	// Installation and uninstallation hooks.
	register_activation_hook( $mvcp::get_activation_path(), array( $mvcp, 'primary_plugin_activation' ) );
	register_activation_hook( $mvcp::get_activation_path(), array( $mvcp, 'maybe_enable_ads_txt' ) );
	add_action( 'plugins_loaded', array( $mvcp, 'plugin_activation' ), 10, 2 );
	register_deactivation_hook( $mvcp::get_activation_path(), array( $mvcp, 'plugin_deactivation' ) );

	if ( function_exists( 'rest_api_init' ) ) {
		$MVCP_Settings = \Mediavine\MCP\Settings::get_instance();
		$MVCP_Identity = \Mediavine\MCP\MV_Identity::get_instance();

		$MVCP_Video = new \Mediavine\MCP\Video();
		$MVCP_Video->init();

		$MVCP_Admin = new Mediavine\Control_Panel\Admin_Init();
		$MVCP_Admin->init();
	}
}
