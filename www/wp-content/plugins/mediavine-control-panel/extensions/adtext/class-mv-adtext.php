<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'MV_Adtext' ) ) {
	class MV_Adtext extends MV_Extension {

		public $document_root = null;

		public function __construct() {

			$this->init_plugin_actions();

			$this->document_root = $this->get_root_path();
		}

		public function get_root_path() {
			$root_path = ABSPATH;
			if ( ! empty( $_SERVER['DOCUMENT_ROOT'] ) ) {
				$root_path = $_SERVER['DOCUMENT_ROOT']; // phpcs:disable WordPress.VIP.ValidatedSanitizedInput.MissingUnslash, WordPress.VIP.ValidatedSanitizedInput.InputNotSanitized
			}
			if ( defined( 'MVCP_ROOT_PATH' ) ) {
				$root_path = MVCP_ROOT_PATH;
			}
			return trailingslashit( $root_path );
		}

		public function get_root_url() {
			$root_url = get_home_url();
			if ( defined( 'MVCP_ROOT_URL' ) ) {
				$root_url = MVCP_ROOT_URL;
			}
			return $root_url;
		}

		public function ads_txt_exists() {
			return file_exists( realpath( $this->document_root . 'ads.txt' ) );
		}

		public function has_contents() {
			return filesize( realpath( $this->document_root . 'ads.txt' ) ) > 0;
		}

		public function remove_adstxt() {
			if ( true === $this->ads_txt_exists() ) {
				return unlink( realpath( $this->document_root . 'ads.txt' ) );
			}
			return false;
		}

		public function remove_if_empty() {
			if ( true === $this->ads_txt_exists() ) {
				if ( ! $this->has_contents() ) {
					unlink( realpath( $this->document_root . 'ads.txt' ) );
				}
			}
		}

		public function init_plugin_actions() {
			add_action( 'get_ad_text_cron_event', array( $this, 'write_ad_text_file' ) );
			add_action( 'wp_ajax_mv_adtext', array( $this, 'write_ad_text_ajax' ) );
			add_action( 'wp_ajax_mv_disable_adtext', array( $this, 'disable_ad_text_ajax' ) );
			add_action( 'wp_ajax_mv_enable_adtext', array( $this, 'enable_ad_text_ajax' ) );

		}

		public function enable_ad_text() {
			$worked = $this->write_ad_text_file();
			$this->remove_if_empty();

			if ( false === wp_next_scheduled( 'get_ad_text_cron_event' ) ) {
				wp_schedule_event( time(), 'twicedaily', 'get_ad_text_cron_event' );
			}

			delete_option( '_mv_mcp_adtext_disabled' );
			$data = array( 'success' => $worked );
			return $data;
		}

		public function disable_adstxt() {
			wp_clear_scheduled_hook( 'get_ad_text_cron_event' );
			return true;
		}

		public function get_ad_text( $slug = null, $live_site = false ) {
			if ( ! $slug ) {
				$slug = MV_Control_Panel::$mvcp->option( 'site_id' );
			}

			$url = 'https://adstxt.mediavine.com/sites/' . $slug . '/ads.txt';

			if ( $live_site ) {
				$url = $this->get_root_url() . '/ads.txt';
			}

			$request = wp_remote_get( $url );

			// Try again with non-https if error (prevent cURL error 35: SSL connect error)
			if ( is_wp_error( $request ) && ! $live_site && ! empty( $request->errors['http_request_failed'] ) ) {
				$url     = 'http://adstxt.mediavine.com/sites/' . $slug . '/ads.txt';
				$request = wp_remote_get( $url );
			}

			$code    = wp_remote_retrieve_response_code( $request );
			$ad_text = wp_remote_retrieve_body( $request );

			if ( $code >= 200 && $code < 400 ) {
				return $ad_text;
			}

			return false;
		}

		public function write_ad_text_file( $slug = null ) {
			$ad_text = $this->get_ad_text( $slug );

			// Better failure messages
			if ( false === $ad_text ) {
				return __( 'Cannot connect to Mediavine Ads.txt file.', 'mcp' );
			}
			if ( empty( $ad_text ) || strlen( $ad_text ) <= 0 ) {
				return __( 'Mediavine Ads.txt file empty.', 'mcp' );
			}

			$fp = fopen( $this->document_root . 'ads.txt', 'w' );

			fwrite( $fp, $ad_text );

			fclose( $fp );

			// Remove autoupdate transient if it exists
			delete_transient( 'mv_ad_text_autoupdate_failed' );

			// Run match ads.txt check to set correct transient
			$this->match_ad_text_file();

			return true;
		}

		public function enable_ad_text_ajax() {
			$data = $this->enable_ad_text();
			$this->respond_json_and_die( $data );
		}

		public function disable_ad_text_ajax() {
			$worked = $this->disable_adstxt();
			$this->remove_adstxt();
			add_option( '_mv_mcp_adtext_disabled', true );
			$data = array( 'success' => $worked );
			$this->respond_json_and_die( $data );
		}

		public function write_ad_text_ajax() {
			$worked = $this->write_ad_text_file();
			$this->remove_if_empty();
			$data = array( 'error' => $worked );
			if ( true === $worked ) {
				$data = array( 'success' => $worked );
			}
			$this->respond_json_and_die( $data );
		}

		public function respond_json_and_die( $data ) {
			try {
				header( 'Pragma: no-cache' );
				header( 'Cache-Control: no-cache' );
				header( 'Expires: Thu, 01 Dec 1994 16:00:00 GMT' );
				header( 'Connection: close' );

				header( 'Content-Type: application/json' );

				// response body is optional //
				if ( isset( $data ) ) {
					// adapt_json_encode will handle data escape //
					echo wp_json_encode( $data );
				}
			} catch ( Exception $e ) {
					header( 'Content-Type: text/plain' );
					echo esc_html( 'Exception in respond_and_die(...): ' . $e->getMessage() );
			}

			die();
		}

		public function match_ad_text_file() {

			$ad_text_match   = false;
			$site_id         = MV_Control_Panel::$mvcp->option( 'site_id' );
			$mv_ad_text      = $this->trim_ad_text( $this->get_ad_text( $site_id ) );
			$current_ad_text = $this->trim_ad_text( $this->get_ad_text( $site_id, true ) );

			if ( $mv_ad_text === $current_ad_text ) {

				$ad_text_match = true;

				// Remove autoupdate transient if match passes
				delete_transient( 'mv_ad_text_autoupdate_failed' );

			}

			// Set transient
			set_transient( 'mv_ad_text_match', $ad_text_match, 12 * HOUR_IN_SECONDS );

			return $ad_text_match;
		}

			// Matches ads.txt file with Mediavine servers
		public function match_ad_text_notice() {

			$site_id       = MV_Control_Panel::$mvcp->option( 'site_id' );
			$enabled       = ! get_option( '_mv_mcp_adtext_disabled' );
			$ad_text_match = get_transient( 'mv_ad_text_match' );

			if ( $site_id ) {

				// Only check if no match transient exists
				if ( false === $ad_text_match ) {
					$ad_text_match = $this->match_ad_text_file();
				}

				// Only proceed if files don't match
				if ( empty( $ad_text_match ) ) {

					$worked                       = false;
					$autoupdate_previously_failed = get_transient( 'mv_ad_text_autoupdate_failed' );

					// Try to update ads.txt and autoupdate didn't fail recently
					if ( $enabled && ! $autoupdate_previously_failed ) {

						$worked = $this->write_ad_text_file();

						// Retry matched check after autoupdate
						$ad_text_match = $this->match_ad_text_file();

						// If ads.txt didn't update pause autoupdater from trying for 12 hours
						if ( true !== $worked ) {
							set_transient( 'mv_ad_text_autoupdate_failed', true, 12 * HOUR_IN_SECONDS );
						}
					}

					// Only display notice if ads.txt still doesn't match
					if ( empty( $ad_text_match ) ) {

						// Don't display notice if multisite with ads.txt disabled
						if ( ! $enabled && is_multisite() ) {
							return;
						}

						// Add update_ads_text param on url string to give instructions
						$url   = esc_url( 'https://help.mediavine.com/advanced/ads-txt-help/setting-up-your-adstxt-file' );
						$class = 'notice notice-error';
						/* translators: %s: url */
						$message = sprintf( __( '<span style="font-size: 1.5em;">The automatic Ads.txt update failed due to settings on your server. You\'ll need to <a href="%s" target="_blank">update this manually by FOLLOWING THESE INSTRUCTIONS</a>. <strong>This impacts your revenue and needs to be updated ASAP.</strong></span>', 'mcp' ), $url );

						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

					}
				}
			}

		}

			// Trim all whitespace and normalize line breaks
		public function trim_ad_text( $ad_text ) {
			$ad_text = trim( preg_replace( '~\r\n?~', "\n", $ad_text ) );

			return $ad_text;
		}

	}

}
