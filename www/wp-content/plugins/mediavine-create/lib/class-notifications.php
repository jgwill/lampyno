<?php

namespace Mediavine;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Notifications {

	const DB_VERSION = '1.0.0';

	const TEXT_DOMAIN = 'mv_notices';

	const PLUGIN_DOMAIN = 'mv_notices';

	private static $instance = null;

	private $api_version = 'v1';

	private $api_route = 'mv-notices';

	private $table_name = 'mv_notifications';

	public $models = null;

	private $api_services = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function init() {

		add_filter( 'mv_custom_tables', array( $this, 'create_custom_tables' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );

	}

	private function __construct() {
		$this->models = new Models();

		$this->models->{'notifications'} = new \Mediavine\MV_DBI( 'mv_notifications' );
		$this->api_services              = API_Services::get_instance();
	}

	function get_notification( $notice_id ) {
		return $this->models->notifications->select_one_by_id( $notice_id );
	}

	public function update_notification( $update ) {
		$updated = $this->models->notifications->update( $update );
		if ( 0 < $updated ) {
			return $this->get_notification( $update['id'] );
		}
		if ( 0 === $updated ) {
			return array(
				'error' => 'Update had no changes',
			);
		}
		return false;
	}

	public function get_notifications() {
		global $wpdb;

		$limit    = 30;
		$offset   = 0;
		$order_by = 'id';
		$order    = 'DESC';

		if ( isset( $args['limit'] ) ) {
			$limit = $args['limit'];
		}

		if ( isset( $args['offset'] ) ) {
			$offset = $args['offset'];
		}

		if ( isset( $args['order_by'] ) ) {
			$order_by = $args['order_by'];
		}

		if ( isset( $args['order'] ) ) {
			$order = $args['order'];
		}

		$full_table_name = $wpdb->prefix . $this->table_name;

		$statement = "SELECT * FROM $full_table_name  WHERE (active IS TRUE) ORDER BY $order_by $order LIMIT $limit OFFSET $offset";

		return $this->models->notifications->select( null, $statement );
	}

	function create_custom_tables( $custom_tables ) {

		$custom_tables[] = array(
			'version'    => self::DB_VERSION,
			'table_name' => 'mv_notifications',
			'sql'        => "
				id bigint(20) NOT NULL AUTO_INCREMENT,
				type varchar(20) NOT NULL DEFAULT 'notice',
				message mediumtext NOT NULL default '',
				status tinytext,
				active boolean NOT NULL default 1,
				origin mediumtext,
				origin_id tinytext,
				link mediumtext,
				expires bigint(20) NOT NULL,
				created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (id)",
		);

		return $custom_tables;

	}

	function generate_notices_auth( \WP_REST_REQUEST $request ) {
		return new \WP_REST_RESPONSE(
			array(
				'token' => '3WNCk6r5hgWTR0T0jHuH',
			), 201
		);
	}

	function create_notice( \WP_REST_REQUEST $request ) {

		$data        = null;
		$status_code = 500;
		$response    = array(
			'error' => 'It went wah wah',
		);
		$sanity      = $request->sanitize_params();
		if ( $sanity ) {
			$data = $request->get_params();

			$this->models->notifications->insert( $data );

			if ( $inserted ) {
				$response    = $this->api_services->prepare_item_for_response( $inserted, $request );
				$status_code = 201;
			}
		}

		return new \WP_REST_RESPONSE( $response, $status_code );
	}

	function read_notices( \WP_REST_REQUEST $request ) {

		$data = $this->get_notifications();

		$status_code = 500;
		$response    = array(
			'error' => 'NOOOPE',
		);

		if ( is_array( $data ) ) {
			$response          = array();
			$response['links'] = $this->api_services->prepare_collection_links( $request );
			$response['data']  = array();
			foreach ( $data as $notice ) {
				$response['data'][] = $this->api_services->prepare_item_for_response( $notice, $request );
			}
			$status_code = 200;
		}

		return new \WP_REST_RESPONSE( $response, $status_code );
	}

	function update_notice( \WP_REST_REQUEST $request ) {

		$sanity      = $request->sanitize_params();
		$status_code = 500;
		$response    = array(
			'error' => 'I need to work on error messages',
		);
		if ( is_wp_error( $sanity ) ) {

		}
		$params = $request->get_params();

		$updated_notice = $this->update_notification( $params );

		if ( $updated_notice ) {
			$response    = $this->api_services->prepare_item_for_response( $updated_notice, $request );
			$status_code = 200;
		}

		return new \WP_REST_RESPONSE( $response, $status_code );
	}

	function register_routes() {
		$route_namespace = $this->api_route . '/' . $this->api_version;
		register_rest_route(
			$route_namespace, '/notices/auth', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'generate_notices_auth' ),
			)
		);

		register_rest_route(
			$route_namespace, '/notices', array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'read_notices' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
				array(
					'methods'  => 'POST',
					'callback' => array( $this, 'create_notice' ),

				),
			)
		);

		register_rest_route(
			$route_namespace, '/notices/(?P<id>\d+)', array(
				array(
					'methods'             => 'PUT',
					'callback'            => array( $this, 'update_notice' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			)
		);

	}

}
