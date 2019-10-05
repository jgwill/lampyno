<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * MVSecurity Class
 *
 * @category Class
 * @package  Mediavine Control Panel
 * @author   Mediavine
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.mediavine.com
 */

if ( ! class_exists( 'MV_Security' ) ) {
	class MV_Security extends MV_Extension {

		public $settings = array(
			'enable_forced_ssl'   => 'bool', // Legacy, "upgrade-insecure-requests" setting
			'block_mixed_content' => 'bool',
		);

		public $settings_defaults = array(
			'enable_forced_ssl'   => false,
			'block_mixed_content' => false,
		);

		public $setting_prefix = 'MVCP_';

		public function __construct() {

			$this->init_plugin_actions();
		}

		public function init_plugin_actions() {
			add_action( 'send_headers', array( $this, 'send_headers' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}

		public function send_headers() {
			// Don't send CSP headers if on Customizer
			$customizer = false;
			if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
				$customizer = true;
			}

			if ( $this->option( 'block_mixed_content' ) && ! $customizer ) {
				header( 'Content-Security-Policy: block-all-mixed-content' );
			}
		}

		public function admin_notices() {
			if ( $this->option( 'enable_forced_ssl' ) && ! $this->option( 'block_mixed_content' ) ) {
				echo '<div class="notice notice-warning is-dismissible">
                <p><strong>Mediavine Control Panel</strong> &raquo; Your Content Security Policy is no longer supported. Please <a href="options-general.php?page=mediavine_amp_settings">update your security settings</a>.</p>
                </div>';
			}
		}

		// Hooks
	}
}


