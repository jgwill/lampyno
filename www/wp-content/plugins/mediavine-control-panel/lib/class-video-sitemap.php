<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class Video_Sitemap {

	public static $instance = null;

/**
 * Makes sure class is only instantiated once
 *
 * @return object
 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
			self::$instance->init();
		}
		return self::$instance;
	}

	/**
	 * Link functions to WP Lifecycle
	 * @return void No return initialization function
	 */
	function init() {
		add_filter( 'allowed_redirect_hosts', [ $this, 'allowed_hosts' ] );
		add_action( 'init', [ $this, 'create_rewrites' ] );
	}

	/**
	 * Adds 'dashboard.mediavine.com' to allowed hosts for redirects
	 *
	 * @param [type] $hosts
	 * @return void
	 */
	function allowed_hosts( $hosts ) {
		$hosts[] = 'sitemaps.mediavine.com';
		return $hosts;
	}

	/**
	 * Adds rewrite rules for catching 'mv-video-sitemap'
	 *
	 * @return void
	 */
	public function create_rewrites() {
		add_rewrite_rule( '^mv-video-sitemap$', 'index.php?mv-video-sitemap=1' );
		add_action( 'parse_request', [ $this, 'parse_sitemap_route' ] );
	}

	/**
	 * Parse Sitemap Route
	 *
	 * Function parse the query route to identify if it should be pass to the fire redirect function
	 *
	 * @param WP $query Current WordPress environment instance (passed by reference)
	 * @param bool $testing Return early for testing purposes
	 * @return void
	 */
	public function parse_sitemap_route( $query, $testing = false ) {
		if ( ! property_exists( $query, 'query_vars' ) || ! is_array( $query->query_vars ) ) {
			return;
		}
		$query_vars_as_string = implode( '', $query->query_vars );

		if ( 'mv-video-sitemap' === $query_vars_as_string ) {
			$this->fire_redirect();

			return $query_vars_as_string;
		}
		return;
	}

	/**
	 * process the redirect after user hits the specific url, if user hits this and site id is missing will redirect to home
	 *
	 * @return void Return $url if testing and site_id set
	 */
	public function fire_redirect() {
		$site_id = get_option( 'MVCP_site_id' );

		if ( $site_id ) {
			$url = 'https://sitemaps.mediavine.com/sites/' . $site_id . '/video-sitemap.xml';

			// Return early when testing so headers aren't thrown
			if ( class_exists( 'WP_UnitTestCase' ) ) {
				return $url;
			}

			wp_safe_redirect( $url, 301 );
			exit();
			return;
		}

		// Return early when testing so headers aren't thrown
		if ( class_exists( 'WP_UnitTestCase' ) ) {
			return;
		}

		wp_safe_redirect( '/', 302 );
		exit();
		return;
	}
}
