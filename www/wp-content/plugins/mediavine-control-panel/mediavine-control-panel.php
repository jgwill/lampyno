<?php
/**
 * Primary file for MCP.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 *
 * Plugin Name: Mediavine Control Panel
 * Plugin URI: https://www.mediavine.com/
 * Description: Manage your ads, analytics and more with our lightweight plugin!
 * Version: 2.2.0
 * Author: mediavine
 * Author URI: https://www.mediavine.com
 * Text Domain: mcp
 * License: GPL2
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! function_exists( 'mcp_is_compatible' ) ) {
	function mcp_is_compatible() {
		global $wp_version;
		$wp         = '3.5';
		$php        = '5.3.10';
		$compatible = true;

		if ( version_compare( PHP_VERSION, $php ) < 0 ) {
			$compatible = false;
		}

		if ( version_compare( $wp_version, $wp ) < 0 ) {
			$compatible = false;
		}

		return $compatible;
	}
}

if ( ! function_exists( 'mcp_activation_check' ) ) {
	function mcp_activation_check() {
		if ( ! mcp_is_compatible() ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( esc_html( 'Mediavine Control Panel requires PHP 5.3.29 or higher and WordPress 3.5 or higher.' ), esc_html( 'PHP or WordPress Version Incompatible' ), array( 'back_link' => true ) );
		}

		return;
	}
}

register_activation_hook( __FILE__, 'mcp_activation_check' );

if ( mcp_is_compatible() ) {
	// Define correct basename for usage in plugin
	if ( ! defined( 'MCP_PLUGIN_BASE' ) ) {
		define( 'MCP_PLUGIN_BASE', plugin_basename( __FILE__ ) );
	}
	require_once( 'class-mv-control-panel.php' );
}
