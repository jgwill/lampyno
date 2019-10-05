<?php

namespace Mediavine;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\Settings' ) ) {

	class Settings {

		private $api_route = 'mv-settings';

		private $api_version = 'v1';

		private $table_name = 'mv_settings';

		private $api = null;

		public $db_version = '1.0.0';

		public static $models = null;

		public $schema = array(
			'type'    => array(
				'type'    => 'varchar(20)',
				'default' => '\'setting\'',
			),
			'slug'    => array(
				'type'   => 'varchar(170)',
				'unique' => true,
			),
			'value'   => 'longtext',
			'data'    => 'longtext',
			'`group`' => array(
				'type' => 'varchar(170)',
				'key'  => true,
			),
			'`order`' => 'tinyint(10)',
		);

		public static function create_settings_filter( $settings = array() ) {
			$gathered_settings = apply_filters( 'mv_create_settings', $settings );

			if ( is_array( $gathered_settings ) ) {

				$value_filtered = array();

				foreach ( $gathered_settings as $setting ) {
					$existing_setting = self::get_settings( $setting['slug'] );

					if ( isset( $setting['force_update_value'] ) && $setting['force_update_value'] ) {
						$value_filtered[] = $setting;
						continue;
					}

					if ( isset( $existing_setting->value ) ) {
						// Convert line breaks into `\n` so they insert properly into the db
						$existing_value   = str_replace( [ "\r", "\n" ], '\n', $existing_setting->value );
						$setting['value'] = $existing_value;
					}
					$value_filtered[] = $setting;
				}

				self::create_settings( $value_filtered );

			}

		}

		/**
		 * Migrates a setting from an old to a new value
		 * @param   array   $settings   Current list of settings
		 * @param   string  $slug       Slug to check
		 * @param   string  $old_value  Current value you want to check against
		 * @param   string  $new_value  New value you want
		 * @param   string  $callback   Callback to be run
		 * @return  array               List of settings after migrated change made
		 */
		public static function migrate_setting_value( array $settings, $slug, $old_value, $new_value, $callback = null ) {
			$current_value = self::get_setting( $slug );

			if ( 'boolean_switch' === $callback ) {
				$old_value = $current_value;
				$new_value = ! wp_validate_boolean( $current_value );
			}

			if ( $current_value && $current_value === $old_value ) {
				$settings_slugs = array_flip( wp_list_pluck( $settings, 'slug' ) );

				$settings[ $settings_slugs[ $slug ] ]['value']              = $new_value;
				$settings[ $settings_slugs[ $slug ] ]['force_update_value'] = true;
			}

			return $settings;
		}

		/**
		 * Migrates a setting slug to a new slug
		 * @param   array   $settings  Current list of settings
		 * @param   string  $old_slug  Current sug to be replaced
		 * @param   string  $new_slug  New slug you want
		 * @param   string  $callback  Callback to be run
		 * @return  array              List of settings after migrated change made
		 */
		public static function migrate_setting_slug( array $settings, $old_slug, $new_slug, $callback = null ) {
			$old_slug_value = self::get_setting( $old_slug );

			if ( 'boolean_switch' === $callback ) {
				$old_slug_value = ! wp_validate_boolean( $old_slug_value );
			}

			// $old_slug_value will be null if no setting
			if ( $old_slug_value || false === $old_slug_value ) {
				$settings_slugs = array_flip( wp_list_pluck( $settings, 'slug' ) );

				if ( isset( $settings_slugs[ $new_slug ] ) ) {
					$settings[ $settings_slugs[ $new_slug ] ]['value'] = $old_slug_value;
				}
				\Mediavine\Settings::delete_setting( $old_slug );
			}

			return $settings;
		}

		public static function create_settings( $settings ) {
			$Settings_Models = new MV_DBI( 'mv_settings' );

			$collection = array();
			if ( wp_is_numeric_array( $settings ) ) {
				foreach ( $settings as $setting ) {

					if ( isset( $params['slug'] ) ) {
						$setting['slug'] = sanitize_text_field( $setting['slug'] );
					}

					if ( isset( $setting['value'] ) ) {
						$setting['value'] = sanitize_text_field( $setting['value'] );
					}

					if ( isset( $setting['data'] ) ) {
						$setting['data'] = wp_json_encode( $setting['data'] );
					}

					if ( isset( $setting['group'] ) ) {
						$setting['group'] = sanitize_text_field( $setting['group'] );
					}

					// Only add setting if it has slug
					if ( ! empty( $setting['slug'] ) ) {
						$collection[] = $Settings_Models->upsert( $setting );
					}
				}
				return $collection;
			}

			if ( isset( $settings['data'] ) ) {
				$settings['data'] = wp_json_encode( $settings['data'] );
			}

			// Only add setting if it has slug
			if ( ! empty( $settings['slug'] ) ) {
				return $Settings_Models->upsert( $settings );
			}

			return false;
		}

		public static function extract( $setting ) {
			if ( empty( $setting->data ) ) {
				return $setting;
			}
			if ( ! empty( $setting->value ) ) {
				$setting->value = str_replace( '\n', "\n", $setting->value );
			}
			$data = maybe_unserialize( $setting->data );
			if ( gettype( $data ) === 'string' ) {
				$data = json_decode( $setting->data );
				if ( gettype( $data ) === 'string' ) {
					$data = json_decode( $data );
				}
			}
			$setting->data = (array) $data;
			return $setting;
		}

		public static function get_settings( $setting_slug = null, $setting_group = null ) {
			$Settings = new MV_DBI( 'mv_settings' );

			if ( $setting_slug ) {
				$setting = $Settings->find_one(
					array(
						'col' => 'slug',
						'key' => $setting_slug,
					)
				);

				if ( $setting ) {
					return self::extract( $setting );
				}
				return null;
			}

			if ( $setting_group ) {
				$settings = $Settings->find(
					array(
						'where'    => array(
							'`group`' => $setting_group,
						),
						'order_by' => '`order`',
						'order'    => 'ASC',
					)
				);

				if ( ! empty( $settings ) ) {
					foreach ( $settings as &$setting ) {
						$setting = self::extract( $setting );
					}
					return $settings;
				}

				return null;
			}

			$settings = $Settings->find();

			if ( ! empty( $settings ) ) {
				foreach ( $settings as &$setting ) {
					$setting = self::extract( $setting );
				}
				return $settings;
			}

			return null;
		}

		/**
		 * Gets the setting value of a single setting
		 * @param string $setting_slug Slug to retreive
		 * @param string $default_setting Default if no setting exists
		 * @return mixed|null Value from the setting or default setting or null if no setting found
		 */
		public static function get_setting( $setting_slug, $default_setting = null ) {
			$setting = \Mediavine\Settings::get_settings( $setting_slug );

			if ( isset( $setting->value ) ) {
				return $setting->value;
			}

			if ( isset( $default_setting ) ) {
				return $default_setting;
			}

			return null;
		}

		/**
		 * Deletes the setting value of a single setting or group
		 * @param string $setting_slug Slug to delete
		 * @param string $setting_group Group to delete - $setting_slug MUST be null
		 * @return boolean True if deleted, fasle if not deleted (usually because not found)
		 */
		public static function delete_settings( $setting_slug, $setting_group = null ) {
			$Settings_Models = new MV_DBI( 'mv_settings' );
			$args            = array();

			$args = array(
				'col' => 'slug',
				'key' => $setting_slug,
			);

			if ( is_null( $setting_slug ) && ! empty( $setting_group ) ) {
				$args = array(
					'col' => 'group',
					'key' => $setting_group,
				);
			}

			return $Settings_Models->delete( $args );
		}

		/**
		 * Deletes the setting value of a single setting (Alias of `delete_settings`)
		 * @param string $setting_slug Slug to delete
		 * @return boolean True if deleted, fasle if not deleted (usually because not found)
		 */
		public static function delete_setting( $setting_slug ) {
			self::delete_settings( $setting_slug );
		}

		/**
		 * Initializes the class and adss filters and sets class state
		 *
		 * @return None
		 */
		function init() {
			add_filter( 'mv_custom_schema', array( $this, 'custom_tables' ) );

			self::$models       = MV_DBI::get_models(
				array(
					$this->table_name,
				)
			);
			$this->settings_api = new Settings_API();

			add_action( 'rest_api_init', array( $this, 'routes' ) );
		}

		/**
		 * @param  array Array of tables to be created
		 * @return array extends custom tables filter for processing
		 */
		public function custom_tables( $tables ) {
			$tables[] = array(
				'version'    => $this->db_version,
				'table_name' => $this->table_name,
				'schema'     => $this->schema,
			);
			return $tables;
		}

		/**
		 * Create Routes for Settings API
		 *
		 * @return none
		 */
		function routes() {
			$route_namespace = $this->api_route . '/' . $this->api_version;

			register_rest_route(
				$route_namespace, '/settings', array(
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => array( $this->settings_api, 'create' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->settings_api, 'read' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/settings/(?P<id>\d+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->settings_api, 'read_single' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => array( $this->settings_api, 'update_single' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
					array(
						'methods'             => \WP_REST_Server::DELETABLE,
						'callback'            => array( $this->settings_api, 'delete' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/settings/slug/(?P<slug>\S+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->settings_api, 'read_single_by_slug' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);

			register_rest_route(
				$route_namespace, '/group/(?P<slug>\S+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->settings_api, 'read_by_group' ),
						'permission_callback' => function () {
							return current_user_can( 'manage_options' );
						},
					),
				)
			);
		}
	}
}
