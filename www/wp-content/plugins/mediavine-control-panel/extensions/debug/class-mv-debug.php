<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * Contains Debug Class.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */

if ( ! class_exists( 'MV_Debug' ) ) {

	/**
	 * Debug Class.
	 *
	 * @category     WordPress_Plugin
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
	class MV_Debug extends MV_Extension {

		/**
		 * Constructor for initializing state and dependencies.
		 *
		 * @ignore
		 * @since 1.0
		 * @param class $mvcp_instance instance of mvcp.
		 */
		public function __construct() {

			$this->init_plugin_actions();
		}

		/**
		 * Init actions against WP Hooks.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function init_plugin_actions() {
			add_action( 'wp_ajax_mv_debug', array( $this, 'dump_wp_data' ) );
			add_action( 'wp_ajax_nopriv_mv_debug', array( $this, 'dump_wp_data' ) );
		}

		/**
		 * Single call for WP blog info dunp.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function dump_wp_data() {
			$vars = array(
				// blog.
				'name'            => get_bloginfo( 'name' ),
				'description'     => get_bloginfo( 'description' ),
				'wpurl'           => get_bloginfo( 'wpurl' ),
				'url'             => get_bloginfo( 'url' ),
				'language'        => get_bloginfo( 'language' ),
				'charset'         => get_bloginfo( 'charset' ),
				'version'         => get_bloginfo( 'version' ),
				// php environment.
				'php_version'     => PHP_VERSION,
				'php_disabled_fn' => ini_get( 'disable_functions' ),
				'php_disabled_cl' => ini_get( 'disable_classes' ),
			);

			$vars['debug'] = array();

			$theme                                = wp_get_theme();
			$vars['debug']['theme']               = array();
			$vars['debug']['theme']['Name']       = $theme->get( 'Name' );
			$vars['debug']['theme']['ThemeURI']   = $theme->get( 'ThemeURI' );
			$vars['debug']['theme']['Version']    = $theme->get( 'Version' );
			$vars['debug']['theme']['TextDomain'] = $theme->get( 'TextDomain' );
			$vars['debug']['theme']['DomainPath'] = $theme->get( 'DomainPath' );

			$vars['debug']['plugins'] = $this->get_installed_plugins();

			$this->respond_json_and_die( $this->array_decode_entities( $vars ) );
		}

		/**
		 * Decode HTML Entities.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $array entities for html decode.
		 */
		public function array_decode_entities( $array ) {
			$new_array = array();

			foreach ( $array as $key => $string ) {
				if ( is_string( $string ) ) {
					$new_array[ $key ] = html_entity_decode( $string, ENT_QUOTES );
				} else {
					$new_array[ $key ] = $string;
				}
			}

			return $new_array;
		}

		/**
		 * List installed Plugins.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function get_installed_plugins() {
			$plugins             = array();
			$plugins['active']   = array();
			$plugins['inactive'] = array();

			foreach ( get_plugins() as $key => $plugin ) {
				$plugin['path']   = $key;
				$plugin['status'] = is_plugin_active( $key ) ? 'Active' : 'Inactive';

				if ( is_plugin_active( $key ) ) {
					array_push( $plugins['active'], $plugin );
				} else {
					array_push( $plugins['inactive'], $plugin );
				}
			}

			return $plugins;
		}

		/**
		 * Format JSON data and respond to request.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $data data for json encode.
		 */
		public function respond_json_and_die( $data ) {
			try {
				header( 'Pragma: no-cache' );
				header( 'Cache-Control: no-cache' );
				header( 'Expires: Thu, 01 Dec 1994 16:00:00 GMT' );
				header( 'Connection: close' );

				header( 'Content-Type: application/json' );

				// response body is optional.
				if ( isset( $data ) ) {
					// adapt_json_encode will handle data escape.
					echo wp_json_encode( $data );
				}
			} catch ( Exception $e ) {
				header( 'Content-Type: text/plain' );
				echo 'Exception in respond_and_die(...): ' . esc_html( $e->getMessage() );
			}

			die();
		}
	}
}

