<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Supplies extends Plugin {

		public static $instance = null;

		public $api_root = 'mv-create';

		public $api_version = 'v1';

		public $api = null;

		private $table_name = 'mv_supplies';

		public $schema = array(
			'type'          => 'varchar(20)',
			'creation'      => array(
				'type' => 'bigint(20)',
				'key'  => true,
			),
			'original_text' => 'longtext',
			'note'          => 'longtext',
			'link'          => 'longtext',
			'`group`'       => 'longtext',
			'position'      => 'mediumint(9)',
			'amount'        => 'longtext',
			'max_amount'    => 'longtext',
			'nofollow'      => array(
				'type'    => 'tinyint(1)',
				'default' => 1,
			),
		);

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		public static function get_creation_supplies( $creation_id, $type = null ) {
			global $wpdb;
			$table       = self::$models_v2->mv_supplies->table_name;
			$creation_id = intval( $creation_id );

			$prepared_statement = $wpdb->prepare( "SELECT * FROM {$table} WHERE creation = %d ORDER BY %s, %s ASC", array( $creation_id, 'type', 'position' ) );

			if ( $type ) {
				$prepared_statement = $wpdb->prepare( "SELECT * FROM {$table} WHERE creation = %d AND type = %s ORDER BY %s, %s ASC", array( $creation_id, $type, 'type', 'position' ) );
			}

			return $wpdb->get_results( $prepared_statement );
		}

		public static function put_supplies_in_groups_array( $supplies = array() ) {
			$output = array();
			if ( is_array( $supplies ) ) {
				foreach ( $supplies as $supply ) {

					if ( ! isset( $output[ $supply->group ] ) ) {
						$output[ $supply->group ] = array();
					}
					$output[ $supply->group ][] = (array) $supply;

					usort( $output[ $supply->group ], array( '\Mediavine\Create\Supplies', 'sort_supply' ) );
				}
			}
			return $output;
		}

		function init() {
			$this->api = new Supplies_API();

			add_filter( 'mv_custom_schema', array( $this, 'custom_schema' ) );
			add_action( 'rest_api_init', array( $this, 'routes' ) );
		}

		public function custom_schema( $tables ) {
			$tables[] = array(
				'version'    => self::DB_VERSION,
				'table_name' => $this->table_name,
				'schema'     => $this->schema,
			);
			return $tables;
		}

		public static function delete_all_supplies( $creation_id, $type ) {
			return self::$models_v2->mv_supplies->delete(
				array(
					'where' => array(
						'creation' => $creation_id,
						'type'     => $type,
					),
				)
			);
		}

		public static function sort_supply( $a, $b ) {
			$a = (array) $a;
			$b = (array) $b;

			if ( is_null( $a['position'] ) || is_null( $b['position'] ) ) {
				return 0;
			}
			if ( $a['position'] < $b['position'] ) {
				return -1;
			}
			if ( $a['position'] > $b['position'] ) {
				return 1;
			}
			return 0;
		}

		public static function prepare_supplies( $supplies ) {
			$supplies_list = array();
			$groups        = array();
			$no_group      = array();
			if ( is_array( $supplies ) ) {
				foreach ( $supplies as $supply ) {
					if ( ! empty( $supply->group ) ) {
						$groups[ $supply->group ][] = $supply;
					} else {
						$no_group[] = $supply;
					}
				}
				// Uses long key that likely will never be used as a real group title
				$supplies_list = array_merge( array( 'mv-has-no-group' => $no_group ), $groups );

			}
			return $supplies_list;
		}
		function routes() {
			$namespace = $this->api_root . '/' . $this->api_version;

			register_rest_route(
				$namespace, '/supplies', array(
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'create' ),
								),
								$request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
				)
			);

			register_rest_route(
				$namespace, '/creations/(?P<id>\d+)/supplies', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => array( $this->api, 'read_creation_supplies' ),
						'callback'            => function ( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'read_creation_supplies' ),
								),
								$request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'set_supplies' ),
								),
								$request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
				)
			);

		}
	}
}
