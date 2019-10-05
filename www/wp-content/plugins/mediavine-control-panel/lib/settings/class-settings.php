<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\MCP\Settings' ) ) {

	class Settings {

		public static $instance;

		private static $setting_prefix = 'mcp_';

		private $api = null;

		/**
		 * Makes sure class is only instantiated once
		 *
		 * @return object Instantiated class
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance      = new self();
				self::$instance->api = Settings_API::get_instance();
			}

			return self::$instance;
		}

		/**
		 * Builds the setting against a default and current setting if exists
		 *
		 * @param string $slug Unprefixed setting slug
		 * @param array $setting New setting data
		 * @param boolean $save_value Should the original value be retained
		 * @return array New setting to be saved
		 */
		public static function build_setting( $slug, $setting, $save_value = false ) {
			$date            = date( 'Y-m-d H:i:s' );
			$default_setting = array(
				'id'       => crc32( self::$setting_prefix . $slug ), // Unique ID based of slug
				'type'     => 'setting',
				'created'  => $date,
				'modified' => $date,
				'value'    => null,
				'group'    => null,
				'order'    => null,
				'data'     => array(),
			);

			// Make current default if it exists
			$has_current_setting = false;
			$current_setting     = self::read( $slug, null, true );
			if ( ! empty( $current_setting ) && ! is_wp_error( $current_setting ) ) {
				$has_current_setting = true;

				// Modified must always be updated
				unset( $current_setting['modified'] );

				$default_setting = array_merge( $default_setting, $current_setting );
			}

			$updated_setting = array_merge( $default_setting, $setting );

			// Setting keys to be caried over
			$updated_setting['created'] = $default_setting['created'];
			if ( $save_value && $has_current_setting ) {
				$updated_setting['value'] = $default_setting['value'];
			}

			return $updated_setting;
		}

		/**
		 * Upsert setting into WP options table
		 *
		 * @param array $setting New setting data
		 * @param boolean $save_value Should the original value be retained
		 * @return object New setting data that was saved
		 */
		public static function upsert( $setting, $save_value = false ) {
			$collection = array();

			// Recursively run function if associative array
			if ( wp_is_numeric_array( $setting ) ) {
				foreach ( $setting as $setting_element ) {
					$collection[] = self::upsert( $setting_element );
				}
				return $collection;
			}

			// Build slug and generate setting from
			$slug        = self::$setting_prefix . $setting['slug'];
			$new_setting = self::build_setting( $setting['slug'], $setting, $save_value );

			$encoded       = wp_json_encode( $new_setting );
			$stored_option = update_option( $slug, $encoded );

			return json_decode( $encoded );
		}

		public static function mv_settings_sort_settings( $item1, $item2 ) {
			if ( $item1->order > $item2->order ) {
				return 1;
			}
			if ( $item2->order > $item1->order ) {
				return -1;
			}
			return 0;
		}

		/**
		 * Gets setting(s) from the WP options table
		 *
		 * @param string $setting_slug Unprefixed setting slug
		 * @param string $setting_group Unprefixed settings group -
		 *                              Only used if $setting_slug is null
		 * @param boolean $array_output Should the output be an array (true) or an object (false)
		 * @return object|array|\WP_Error|null Retreived setting data. WP_Error (slug or group)
		 *                                    or null (all Trellis settings) if not found
		 */
		public static function read( $setting_slug = null, $setting_group = null, $array_output = false ) {
			if ( $setting_slug ) {
				// Not Found Error as Default
				$error = new \WP_Error(
					404, __( 'Setting Not Found', 'mediavine' ), array(
						// Translators: setting slug
						'message' => sprintf( __( 'No setting found with slug: %s', 'mediavine' ), $setting_slug ),
						'class'   => 'Mediavine\Trellis_Settings',
						'method'  => 'read',
					)
				);

				$setting = get_option( self::$setting_prefix . $setting_slug, $error );
				if ( is_string( $setting ) ) {
					$setting = json_decode( $setting, $array_output );
				}

				return $setting;
			}

			// Get all settings by default (performance faster than searching with SQL)
			global $wpdb;
			$collection = array();
			// phpcs:disable
			$settings = $wpdb->get_results(
				$wpdb->prepare( "SELECT * FROM $wpdb->options WHERE option_name LIKE %s", $wpdb->esc_like( self::$setting_prefix ) . '%' )
			);
			// phpcs:enable

			foreach ( $settings as $setting ) {
				$setting = json_decode( $setting->option_value, $array_output );

				if ( $setting_group ) {
					if ( ! empty( $setting->group ) && $setting->group === $setting_group ) {
						$collection[] = $setting;
						continue;
					}
				}

				if ( null === $setting_group ) {
					$collection[] = $setting;
				}
			}

			if ( ! empty( $collection ) ) {
				// Sort by order if group
				if ( $setting_group ) {
					usort( $collection, 'Mediavine\MCP\Settings::mv_settings_sort_settings' );
				}

				return $collection;
			}

			// Throw WP Error if $setting_group is not null or set
			if ( null !== $setting_group && empty( $collection ) ) {
				return new \WP_Error(
					404, __( 'Settings Group Not Found', 'mediavine' ), array(
						// Translators: setting group
						'message' => sprintf( __( 'No settings group found with slug: %s', 'mediavine' ), $setting_group ),
						'class'   => 'Mediavine\MCP\Settings',
						'method'  => 'read',
					)
				);
			}

			return null;
		}

		/**
		 * Get all settings
		 *
		 * @param boolean $array_output Should the output be an array (true) or an object (false)
		 * @return object|array|null Retreived setting data. Null if not found
		 */
		public static function read_all( $array_output = false ) {
			$settings = self::read( null, null, $array_output );

			return $settings;
		}

		/**
		 * Get all settings from a group
		 *
		 * @param string $setting_group Unprefixed settings group
		 * @param boolean $array_output Should the output be an array (true) or an object (false)
		 * @return object|array|\WP_Error Retreived setting data. WP_Error if not found
		 */
		public static function read_group( $setting_group, $array_output = false ) {
			$settings = self::read( null, $setting_group, $array_output );

			return $settings;
		}

		/**
		 * Get single setting
		 *
		 * @param string $setting_slug Unprefixed setting slug
		 * @param boolean $array_output Should the output be an array (true) or an object (false)
		 * @return object|array|\WP_Error Retreived setting data. WP_Error if not found
		 */
		public static function read_one( $setting_slug, $array_output = false ) {
			$settings = self::read( $setting_slug, null, $array_output );

			return $settings;
		}

		/**
		 * Deletes setting
		 *
		 * @param string $setting_slug Unprefixed setting slug
		 * @return true|false True if setting deleted. False if not found
		 */
		public static function delete( $setting_slug ) {
			return delete_option( self::$setting_prefix . $setting_slug );
		}

		/**
		 * Deletes setting. Alias of `delete`
		 *
		 * @param string $setting_slug Unprefixed setting slug
		 * @return true|false True if setting deleted. False if not found
		 */
		public static function delete_one( $setting_slug ) {
			return self::delete( $setting_slug );
		}
	}
}
