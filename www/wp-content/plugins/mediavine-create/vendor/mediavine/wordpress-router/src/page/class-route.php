<?php
namespace Mediavine\WordPress\Router\Page;

use Mediavine\WordPress\Router\Router;

class Route extends Router
{

	public static function interrupt_request( $current_route, $rewrite_vars = [], callable $callback ) {
		$query_vars = '';
		foreach ( $rewrite_vars as $key => $value ) {
			$query_vars = "{$key}={$value}&";
		}
		$query_vars = trim($query_vars, '&');
		$rewrite = "index.php?{$query_vars}";

		add_action('init', function() use ($current_route, $rewrite, $callback) {
			add_rewrite_rule( $current_route, $rewrite, 'top' );

			add_action( 'parse_request', function( \WP $query ) use ( $callback ) {
				if ( ! property_exists( $query, 'query_vars' ) || ! is_array( $query->query_vars ) ) {
					return;
				}
				$query_vars_as_string = implode( ',', $query->query_vars );
				$sw_filename          = 'sw';

				if ( strpos( $query_vars_as_string, $sw_filename ) !== false ) {
					$callback($query);
				}
			});
		});

	}
}
