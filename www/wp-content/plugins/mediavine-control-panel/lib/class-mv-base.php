<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * Base Utility class for MCP.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */

	/**
	 * Small Utility Class
	 *
	 * @category     Class
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
require_once( 'class-mv-util.php' );

if ( ! class_exists( 'MV_Base' ) ) {

	/**
	 * Primary class for MCP.
	 *
	 * @category     WordPress_Plugin
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
	class MV_Base {

		/**
		 * Class Settings.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $settings = array();

		/**
		 * Class Settings Defaults.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $settings_defaults = array();

		/**
		 * Class Settings Options Prefix.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $setting_prefix = 'MV_';

		/**
		 * Not totally Sure yet.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public $keyword_attr_only = '__SINGLE__';

		/**
		 * Something to do with the utility for building script tag.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		protected $_script_attrs = array();

		/**
		 * Class instance of MCVP for some reason.
		 *
		 * @since 4.6.0
		 * @var array
		 */
		public static $mvcp;

		/**
		 * Constructor for initializing state and dependencies.
		 *
		 * @ignore
		 * @since 1.0
		 * @param class $mvcp_instance instance of mvcp.
		 */
		public function __construct( $mvcp_instance ) {
			self::$mvcp = $mvcp_instance;
			if ( $this->has_script_loader_filter() ) {
				add_filter( 'script_loader_tag', array( $this, 'filter_script_loader' ), 10, 2 );
			} else {
				add_filter( 'clean_url', array( $this, 'filter_script_legacy' ), 10, 2 );
			}
		}

		/**
		 * Utility for generation of correct script tag.
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $tag html tag of script output.
		 * @param string $handle wp id of script for enqueue.
		 */
		public function filter_script_loader( $tag, $handle ) {
			if ( array_key_exists( $handle, $this->_script_attrs ) ) {
				foreach ( $this->_script_attrs[ $handle ] as $attr_name => $value ) {
					if ( $this->keyword_attr_only === $value ) {
						$tag = str_replace( ' src', " {$attr_name} src", $tag );
					} else {
						$tag = str_replace( ' src', " {$attr_name}=\"{$value}\" src", $tag );
					}
				}
			}

			return $tag;
		}


		/**
		 * Provide support for legacy wp.
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $url string url to input to tag.
		 */
		public function filter_script_legacy( $url ) {
			if ( array_key_exists( $url, $this->_script_attrs ) ) {
				foreach ( $this->_script_attrs[ $url ] as $attr_name => $value ) {
					$url = "{$url}' {$attr_name}='${value}";
				}
			}

			return $url;
		}

		/**
		 * Get WP Version for condtional on support.
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function get_wp_ver() {
			return get_bloginfo( 'version' );
		}

		/**
		 * Identify the if the version of WP supports script loader
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $wp_version allow manual passing of $wp_version but with default.
		 */
		public function has_script_loader_filter( $wp_version = null ) {
			if ( ! is_string( $wp_version ) ) {
				$wp_version = $this->get_wp_ver();
			}
			$pattern = '/\d+\.\d+/';
			if ( preg_match( $pattern, $wp_version, $match ) && is_array( $match ) && sizeof( $match ) > 0 ) {
				return floatval( $match[0] ) >= 4.1;
			} else {
				return false;
			}
		}

		/**
		 * Create Script Enqueue array.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $opts options for script enqueue.
		 */
		public function build_script_enqueue( $opts ) {
			$handle          = $opts['handle'];
			$src             = $opts['src'];
			$deps            = MV_Util::get_or_null( $opts, 'deps' );
			$ver             = MV_Util::get_or_null( $opts, 'ver' );
			$in_footer       = MV_Util::get_or_null( $opts, 'in_footer' );
			$attr            = MV_Util::get_or_null( $opts, 'attr' );
			$wp_enqueue_args = MV_Util::filter_null( array( $handle, $src, $deps, $ver, $in_footer ) );
			if ( is_array( $attr ) ) {
				if ( $this->has_script_loader_filter() ) {
					$this->_script_attrs[ $handle ] = $attr;
				} else {
					$this->_script_attrs[ $src ] = $attr;
				}
			}
			return $wp_enqueue_args;
		}

		/**
		 * Function to add built enqueue to wp enqueue.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $opts options for script enqueue.
		 */
		public function mv_enqueue_script( $opts ) {
			$wp_enqueue_args = $this->build_script_enqueue( $opts );
			call_user_func_array( 'wp_enqueue_script', $wp_enqueue_args );
		}

		/**
		 * Get key name by adding prefix and provided string
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $setting_name the name of the setting minus prefix.
		 */
		public function get_key( $setting_name ) {
			return $this->setting_prefix . $setting_name;
		}

		/**
		 * Load and process default settings
		 *
		 * @ignore
		 * @since 1.0
		 */
		public function initialize_settings() {
			$group = $this->setting_prefix;

			foreach ( $this->settings as $key => $value ) {
				register_setting( $group, $group . $key );
			}
		}

		/**
		 * Get options from wp option table
		 *
		 * @ignore
		 * @since 1.0
		 * @param string $name option name minus prefix.
		 * @param string $new_value optional new value for option name.
		 */
		public function option( $name, $new_value = null ) {
			$key = $this->get_key( $name );
			if ( isset( $new_value ) ) {
				$update = update_option( $key, $new_value );
			}
			$opt = get_option( $key );
			if ( false === $opt && array_key_exists( $name, $this->settings ) && 'bool' !== $this->settings[ $name ] ) {
				return $this->option( $name, $this->settings_defaults[ $name ] );
			}
			if ( array_key_exists( $name, $this->settings ) && 'bool' === $this->settings[ $name ] ) {
				return ( $opt && strtolower( $opt ) !== 'false' );
			}
			return $opt;
		}
	}
}

