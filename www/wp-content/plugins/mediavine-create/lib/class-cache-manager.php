<?php

namespace Mediavine;

class Cache_Manager {
	/**
	 * Clears single post cache on a variety of caching plugins
	 * @param  int  $id  Id of the post
	 * @return void
	 */
	public static function clear_single_by_id( $id ) {
		// Force ID as integer
		$id = (int) $id;

		// Cachify
		if ( function_exists( 'remove_page_cache_by_post_id' ) ) {
			\Cachify::remove_page_cache_by_post_id( $id );
		}

		// W3TC
		if ( function_exists( 'w3tc_pgcache_flush_post' ) ) {
			w3tc_pgcache_flush_post( $id );
		}

		// WP Fast Cache
		if ( function_exists( 'wp_fast_cache_build_url_from_file' ) && function_exists( 'wp_fast_cache_delete_cached_url' ) ) {
			$permalink = get_permalink( $id );
			if ( ! empty( $permalink ) ) {
				$url = wp_fast_cache_build_url_from_file( $permalink );
				wp_fast_cache_delete_cached_url( $url );
			}
		}

		// WP Fastest Cache
		if ( class_exists( 'WpFastestCache' ) ) {
			$wpfc = new \WpFastestCache();
			$wpfc->singleDeleteCache( false, $id );
		}

		// Comet Cache
		if ( class_exists( '\WebSharks\CometCache\Classes\ApiBase' ) ) {
			\WebSharks\CometCache\Classes\ApiBase::clearPost( $id );
		}

		// WP Super Cache
		if ( file_exists( WP_CONTENT_DIR . '/wp-cache-config.php' ) && function_exists( 'wpsc_delete_post_cache' ) ) {
			wpsc_delete_post_cache( $id );
		}

		// WP Rocket
		if ( function_exists( 'rocket_clean_post' ) ) {
			rocket_clean_post( $id );
		}

		// Litespeed Cache
		if ( method_exists( 'LiteSpeed_Cache_API', 'purge' ) ) {
			\LiteSpeed_Cache_API::purge( \LiteSpeed_Cache_API::TYPE_POST . $id );
		}
	}

	/**
	 * Clears post cache on a single post or an array of posts
	 * @param  int|array  $post_id_or_ids  Id or an array of the post(s) to clear cache
	 * @return void
	 */
	public static function clear_by_id( $post_id_or_ids = array() ) {
		if ( empty( $post_id_or_ids ) ) {
			return;
		}

		if ( is_array( $post_id_or_ids ) ) {
			foreach ( $post_id_or_ids as $id ) {
				self::clear_single_by_id( $id );
			}
			return;
		}
		self::clear_single_by_id( $post_id_or_ids );
	}
}
