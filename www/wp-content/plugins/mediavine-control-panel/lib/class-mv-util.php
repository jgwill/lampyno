<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * Utility class with helpers?.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */

if ( ! class_exists( 'MV_Util' ) ) {

	/**
	 * Small Utility Class
	 *
	 * @category     Class
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
	class MV_Util {

		/**
		 * Remove null variables?.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array $array loopable variables.
		 */
		public static function filter_null( $array ) {
			return array_filter(
				$array, function ( $var ) {
					return ! is_null( $var );
				}
			);
		}

		/**
		 * Get value or return null.
		 *
		 * @ignore
		 * @since 1.0
		 * @param array  $array list of variables.
		 * @param string $index index being looked for.
		 */
		public static function get_or_null( $array, $index ) {
			if ( array_key_exists( $index, $array ) ) {
				return $array[ $index ];
			}

			return null;
		}
	}
}

