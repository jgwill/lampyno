<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Relations extends Plugin {

		public $api_root = 'mv-create';

		public $api_version = 'v1';

		public $api = null;

		private $table_name = 'mv_relations';

		public $schema = array(
			'type'              => 'varchar(20)',
			'content_type'      => 'varchar(20)',
			'secondary_type'    => 'varchar(20)',
			'creation'          => 'bigint(20)',
			'relation_id'       => 'bigint(20)',
			'title'             => 'longtext',
			'description'       => 'longtext',
			'canonical_post_id' => 'bigint(20)',
			'thumbnail_id'      => 'bigint(20)',
			'url'               => 'longtext',
			'thumbnail_credit'  => 'longtext',
			'position'          => 'mediumint(9)',
			'meta'              => 'longtext',
			'nofollow'          => 'tinyint(1)',
			'link_text'         => 'longtext',
		);

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		function init() {
			$this->api = new Relations_API();

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

		public static function get_creation_relations( $creation_id ) {
			global $wpdb;
			$table       = self::$models_v2->mv_relations->table_name;
			$creation_id = intval( $creation_id );

			$prepared_statement = $wpdb->prepare( "SELECT * FROM {$table} WHERE creation = %d ORDER BY %s, %s ASC", array( $creation_id, 'type', 'position' ) );

			$relations = $wpdb->get_results( $prepared_statement );

			foreach ( $relations as &$relation ) {
				// Everything needs a thumbnail
				if ( ! empty( $relation->thumbnail_id ) ) {
					$relation->thumbnail_uri = wp_get_attachment_url( $relation->thumbnail_id );
				}
				// If the relation content type is not a card or there is no relation id,
				// DO NOT TRY TO FIND A CREATION -- it will not work, I promise.
				if ( 'card' !== $relation->content_type ) {
					continue;
				}

				$creation = self::$models_v2->mv_creations->find_one_by_id( $relation->relation_id );
				if ( ! isset( $creation->associated_posts ) ) {
					continue;
				}
				$associated_posts = json_decode( $creation->associated_posts );
				$relation->posts  = [];

				if ( $associated_posts ) {
					foreach ( $associated_posts as &$post ) {
						$post = [
							'id'    => $post,
							'title' => get_the_title( $post ),
						];
					}
					$relation->posts = $associated_posts;
				}
			}

			return $relations;
		}

		public static function delete_all_relations( $creation_id, $type ) {
			return self::$models_v2->mv_relations->delete(
				array(
					'where' => array(
						'creation' => $creation_id,
						'type'     => $type,
					),
				)
			);
		}

		function routes() {
			$namespace = $this->api_root . '/' . $this->api_version;

			register_rest_route(
				$namespace, '/list/search', array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => function( \WP_REST_Request $request ) {
						return \Mediavine\API_Services::middleware(
							array(
								array( $this->api, 'content_search' ),
							),
							$request
						);
					},
					'permission_callback' => array( self::$api_services, 'permitted' ),
				)
			);

			register_rest_route(
				$namespace, '/creations/(?P<id>\d+)/relations', array(
					array(
						'methods'             => \WP_REST_Server::READABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'read_creation_relations' ),
								),
								$request
							);
						},
						'permission_callback' => array( self::$api_services, 'permitted' ),
					),
					array(
						'methods'             => \WP_REST_Server::EDITABLE,
						'callback'            => function( \WP_REST_Request $request ) {
							return \Mediavine\API_Services::middleware(
								array(
									array( $this->api, 'set_relations' ),
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
