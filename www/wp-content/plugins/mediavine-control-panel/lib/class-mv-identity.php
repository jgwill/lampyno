<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class MV_Identity {

	public static $instance;

	/**
	 * Makes sure class is only instantiated once
	 *
	 * @return object Instantiated class
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
			add_action( 'wp_ajax_mv_identity', array( self::$instance, 'store_token' ) );
		}
		return self::$instance;
	}

	// phpcs:disable
	function store_token() {
		$auth  = null;
		$token = null;
		$hash  = null;
		if ( ! isset( $_GET['auth'] ) && ! isset( $_GET['auth'] ) ) {
			return wp_safe_redirect( '/', 302 );
		}

		if ( isset( $_GET['auth'] ) ) {
			$auth = sanitize_text_field( wp_unslash( $_GET['auth'] ) );
		}

		if ( isset( $_GET['token'] ) ) {
			$token = sanitize_text_field( wp_unslash( $_GET['token'] ) );
		}

		if ( isset( $_GET['hash'] ) ) {
			$hash = sanitize_text_field( wp_unslash( $_GET['hash'] ) );
		}

		$data = json_decode( base64_decode( $auth ) );
		if ( ! user_can( $data->id, 'manage_options' ) ) {
			return wp_safe_redirect( '/', 302 );
		}

		$token_values = explode( '.', $token );
		if ( ! empty( $token_values[1] ) ) {
			$data           = json_decode( base64_decode( $token_values[1] ) );
			$data->intercom = $hash;

			\Mediavine\MCP\Settings::upsert(
				array(
					'slug'  => 'mcp-services-api-token',
					'value' => $token,
					'data'  => $data,
				)
			);
		}

		wp_safe_redirect( '/wp-admin/options-general.php?page=mediavine_amp_settings', 302 );
		exit;
	}
	// phpcs:enable
}
