<?php

namespace Mediavine\Create;

use Mediavine\API_Services;
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Products_Map extends Plugin {

		public static $instance = null;

		public $api_root = 'mv-create';

		public $api = null;

		public $api_version = 'v1';

		private $table_name = 'mv_products_map';

		public $schema = array(
			'type'         => array(
				'type'    => 'varchar(20)',
				'default' => "'product_map'",
			),
			'creation'     => 'bigint(20)',
			'product_id'   => 'bigint(20)',
			'recipe_id'    => 'bigint(20)',
			'title'        => 'text',
			'link'         => 'text',
			'thumbnail_id' => 'bigint(20)',
			'position'     => 'tinyint(3)',
		);

		public $singular = 'product_map';

		public $plural = 'product_map';

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		public static function sort_product_map( $a, $b ) {
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

		public static function get_creation_products_map( $creation_id ) {
			global $wpdb;
			$table       = self::$models_v2->mv_products_map->table_name;
			$creation_id = intval( $creation_id );

			if ( 'list' === Creations::get_creation_type( $creation_id ) ) {
				static::delete_all_products_maps( $creation_id );
				return [];
			}

			$prepared_statement = $wpdb->prepare( "SELECT * FROM {$table} WHERE creation = %d ORDER BY %s ASC", array( $creation_id, 'position' ) );
			$products           = $wpdb->get_results( $prepared_statement );

			foreach ( $products as &$product ) {
				$product->thumbnail_uri = wp_get_attachment_url( $product->thumbnail_id );
			}

			usort( $products, array( '\Mediavine\Create\Products_Map', 'sort_product_map' ) );

			return $products;
		}

		public static function delete_all_products_maps( $creation_id ) {
			return self::$models_v2->mv_products_map->delete(
				array(
					'col' => 'creation',
					'key' => $creation_id,
				)
			);
		}

		function init() {
			$this->api = new Products_Map_API();
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
				$namespace, '/creations/(?P<id>\d+)/products', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'find' ),
								), $request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
					array(
						'methods'             => \WP_REST_Server::DELETABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'destroy' ),
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
