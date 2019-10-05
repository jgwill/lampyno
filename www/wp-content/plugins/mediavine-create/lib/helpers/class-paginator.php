<?php

namespace Mediavine\Create;

use Mediavine\WordPress\Support\Str;

// Prevent direct access

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Paginator {

		/**
		 * Get links with required fields from a table.
		 *
		 * @param string $table
		 * @param array $fields
		 * @param mixed $id
		 * @param string $id_column
		 * @return array
		 */
		public static function make_links( $table, $fields, $id, $id_column = 'id' ) {
			global $wpdb;
			if ( empty( $id ) ) {
				return [];
			}

			$table = Str::contains( $table, $wpdb->prefix ) ? $table : $wpdb->prefix . $table;

			$fields    = implode( ', ', $fields );
			$fields    = trim( $fields, ', ' );
			$statement = "SELECT {$fields} FROM {$table} ORDER BY {$id_column} ASC";
			$items     = $wpdb->get_results( $statement, ARRAY_A );

			if ( empty( $items ) ) {
				return [];
			}
			$links = [
				'first' => reset( $items ),
				'last'  => end( $items ),
			];
			$total = count( $items );

			foreach ( $items as $key => $item ) {
				if ( $item[ $id_column ] == $id ) { // phpcs:ignore
					$links['current'] = $items[ $key ];
					// If the item is not the first in the array ($key > 0),
					// the previous item is one index lower than the current ($key - 1).
					// If the key is the first in the array ($key === 0),
					// the previous item is the last item in the array (end( $items ))
					$links['previous'] = $key > 0 ? $items[ $key - 1 ] : end( $items );
					// If the item index is lower than the count - 1 (because 0-indexing),
					// the next item is the next index ($key + 1).
					// Otherwise, the next item is the first in the array ( reset($items) ).
					$links['next'] = $key < $total - 1 ? $items[ $key + 1 ] : reset( $items );
				}
			}

			return $links;
		}
	}
}
