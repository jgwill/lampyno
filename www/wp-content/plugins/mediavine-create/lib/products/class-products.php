<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Products extends Plugin {

		public static $instance = null;

		public $api_root = 'mv-create';

		public $api = null;

		public $api_version = 'v1';

		private $table_name = 'mv_products';

		public $schema = array(
			'title'        => 'text',
			'link'         => 'text',
			'thumbnail_id' => 'bigint(20)',
		);

		public $singular = 'product';

		public $plural = 'product';

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		public static function prepare_product_thumbnail( $product ) {
			// Attempt to create a new thumbnail
			if ( isset( $product['remote_thumbnail_uri'] ) ) {
				// Some results won't include protocol -or- use relative URLs, so we coerce these to absolute URLs.
				if ( strpos( $product['remote_thumbnail_uri'], 'http' ) === false ) {
					if ( strpos( $product['remote_thumbnail_uri'], '//' ) === 0 ) { // Only catch at beginning
						$product['remote_thumbnail_uri'] = 'http:' . $product['remote_thumbnail_uri'];
					} else {
						$parsed_url                     = parse_url( $url );
						$params['remote_thumbnail_uri'] = 'http://' . $parsed_url['host'] . $data['remote_thumbnail_uri'];
					}
				}

				$thumbnail_id            = \Mediavine\Images::get_attachment_id_from_url( $product['remote_thumbnail_uri'] );
				$product['thumbnail_id'] = $thumbnail_id;
			}

			return $product;
		}

		public static function restore_product_images( $creation ) {
			if ( empty( $creation ) ) {
				return $creation;
			}

			$metadata = json_decode( $creation->metadata, true );
			if ( empty( $metadata ) ) {
				$metadata = array();
			}

			if ( isset( $metadata['product_images_restored'] ) && $metadata['product_images_restored'] ) {
				return $creation;
			}

			$products = self::$models_v2->mv_products_map->find(
				array(
					'where' => array(
						'creation' => $creation->id,
					),
				)
			);

			$scraper = new \Mediavine\Create\LinkScraper();
			$changed = false;
			foreach ( $products as $product ) {
				if ( $product->thumbnail_id ) {
					continue;
				}

				if ( ! isset( $product->link ) ) {
					continue;
				}

				$data = $scraper->scrape( $product->link );
				if ( ! isset( $data['remote_thumbnail_uri'] ) ) {
					continue;
				}
				$product->remote_thumbnail_uri = $data['remote_thumbnail_uri'];
				unset( $product->thumbnail_id );

				$product = self::prepare_product_thumbnail( (array) $product );
				$updated = self::$models_v2->mv_products_map->update( (array) $product );
				if ( $updated ) {
					$changed = true;
				}
			}
			if ( $changed ) {
				$metadata['product_images_restored'] = true;
				$creation->metadata                  = wp_json_encode( $metadata );
				$creation                            = self::$models_v2->mv_creations->update( (array) $creation );
				return \Mediavine\Create\Creations::publish_creation( $creation->id );
			}
			return $creation;
		}

		function init() {
			$this->api = new Products_API();
			add_filter( 'mv_custom_schema', array( $this, 'custom_schema' ) );
			add_action( 'rest_api_init', array( $this, 'routes' ) );
			add_filter( 'mv_dbi_after_update_' . $this->table_name, array( $this, 'cascade_after_update' ) );
		}

		public function cascade_after_update( $product ) {
			global $wpdb;

			$update_values = array();

			if ( isset( $product->title ) ) {
				$update_values['title'] = $product->title;
			}

			if ( isset( $product->thumbnail_id ) ) {
				$update_values['thumbnail_id'] = $product->thumbnail_id;
			}

			if ( isset( $product->link ) ) {
				$update_values['link'] = $product->link;
			}

			$updated = $wpdb->update(
				$wpdb->prefix . 'mv_products_map',
				$update_values,
				array( 'product_id' => $product->id )
			);

			$result = self::$models_v2->mv_products_map->find(
				array(
					'select' => array( 'creation' ),
					'where'  => array(
						'product_id' => $product->id,
					),
				)
			);

			$ids = array();

			foreach ( $result as $item ) {
				$ids[] = $item->creation;
			}

			\Mediavine\Create\Publish::update_publish_queue( $ids );

			return $product;
		}

		public function custom_schema( $tables ) {
			$tables[] = array(
				'version'    => self::DB_VERSION,
				'table_name' => $this->table_name,
				'schema'     => $this->schema,
			);
			return $tables;
		}

		/**
		 * Given a product id, return array of creations using that product
		 * @param  int   $product_id
		 * @return array             Array of [id, title] arrays
		 */
		public static function get_product_creations( $product_id ) {
			global $wpdb;
			$creations    = $wpdb->prefix . 'mv_creations';
			$products_map = $wpdb->prefix . 'mv_products_map';
			$sql          = "SELECT $creations.type, $creations.object_id, $creations.id, $creations.title FROM $creations JOIN $products_map ON $creations.id = $products_map.creation WHERE $products_map.product_id = %d;";
			$prepared     = $wpdb->prepare( $sql, $product_id );
			$creations    = $wpdb->get_results( $prepared );
			return count( $creations ) ? $creations : array();
		}

		function routes() {
			$namespace = $this->api_root . '/' . $this->api_version;

			register_rest_route(
				$namespace, '/products', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( self::$api_services, 'process_pagination' ),
									array( $this->api, 'find' ),
								), $request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'upsert' ),
								), $request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
				)
			);

			register_rest_route(
				$namespace, '/products/scrape', array(
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function ( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'scrape' ),
								),
								$request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
				)
			);

			register_rest_route(
				$namespace, '/products/(?P<id>\d+)', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								[
									[ $this->api, 'find_one' ],
									[ $this->api, 'get_pagination_links' ],
								], $request
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
