<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class Help {

		public static function dump( $var, $label = 'Dump' ) {
			if ( $label ) {
				$label = "\r\n\n##################\n#### {$label}\r\n##################\n\n\n";
			}
			// phpcs:disable
			error_log( $label . print_r( $var, true ) );
			// phpcs:enable
		}

		/**
		 * Checks given data array or object for values at matching keys.
		 *
		 * Example:
		 * $keys = array(
		 *    'a',
		 *    'c',
		 * );
		 * $data = array(
		 *    'a' => 'apple',
		 *    'b' => 'banana',
		 * );
		 * $result = static::set_keys_where_value_exists( $keys, $data );
		 * // array(
		 * //    'a' => 'apple',
		 * // );
		 *
		 * @param array $keys array of keys to check
		 * @param array|object $data array or object to check against
		 * @return array $return_data
		 */
		public static function set_keys_where_value_exists( $keys = array(), $data = array() ) {
			$return_data = array();
			foreach ( $keys as $key ) {
				if ( is_array( $data ) ) {
					if ( ! empty( $data[ $key ] ) ) {
						$return_data[ $key ] = $data[ $key ];
					}
				}
				if ( is_object( $data ) ) {
					if ( ! empty( $data->{$key} ) ) {
						$return_data[ $key ] = $data->{$key};
					}
				}
			}
			return $return_data;
		}
	}

}
