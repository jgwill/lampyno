<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Nutrition extends Plugin {

		public static $instance = null;

		public $api_root = 'mv-create';

		public $api = null;

		public $api_version = 'v1';

		private $table_name = 'mv_nutrition';

		public $schema = array(
			'creation'           => array(
				'type' => 'bigint(20)',
				'key'  => true,
			),
			'serving_size'       => array(
				'type'    => 'text',
				'default' => 'NULL',
			),
			'number_of_servings' => array(
				'type'    => 'text',
				'default' => 'NULL',
			),
			'calories'           => 'text',
			'total_fat'          => 'text',
			'saturated_fat'      => 'text',
			'trans_fat'          => 'text',
			'unsaturated_fat'    => 'text',
			'cholesterol'        => 'text',
			'sodium'             => 'text',
			'carbohydrates'      => 'text',
			'fiber'              => 'text',
			'sugar'              => 'text',
			'protein'            => 'text',
			'net_carbs'          => 'text',
			'sugar_alcohols'     => 'text',
			'calculated'         => 'datetime',
			'source'             => 'text',
		);

		public $singular = 'nutrition';

		public $plural = 'nutrition';

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		public static function get_creation_nutrition( $creation_id ) {
			global $wpdb;
			$table       = self::$models_v2->mv_nutrition->table_name;
			$creation_id = intval( $creation_id );

			$prepared_statement = $wpdb->prepare( "SELECT * FROM {$table} WHERE creation = %d", array( $creation_id ) );
			$nutrition          = $wpdb->get_results( $prepared_statement );
			if ( count( $nutrition ) ) {
				return $nutrition[0];
			}
			return array();
		}

		function init() {
			$this->api = new Nutrition_API();
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

		function routes() {
			$namespace = $this->api_root . '/' . $this->api_version;

			register_rest_route(
				$namespace, '/creations/(?P<id>\d+)/nutrition', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'find_one' ),
								), $request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'upsert' ),
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
