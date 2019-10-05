<?php

namespace Mediavine\Create;

use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Color\Rgba;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Creations_Views' ) ) {

	class Creations_Views_Colors extends Creations_Views {

		public static function lighten( $color, $percent = 20 ) {
			$hex       = new Hex( $color );
			$new_color = $hex->tint( $percent );

			return $new_color;
		}

		public static function darken( $color, $percent = 20 ) {
			$hex       = new Hex( $color );
			$new_color = $hex->shade( $percent );

			return $new_color;
		}

		public static function mix( $color1, $color2, $percent = 50 ) {
			$hex1      = new Hex( $color1 );
			$hex2      = new Hex( $color2 );
			$new_color = $hex1->mix( $hex2, $percent );

			return $new_color;
		}

		public static function is_light( $color ) {
			$hex    = new Hex( $color );
			$return = $hex->isLight();

			return $return;
		}

		public static function is_dark( $color ) {
			$hex    = new Hex( $color );
			$return = $hex->isDark();

			return $return;
		}

		public static function to_rgba( $color, $percent = 1 ) {
			$hex  = new Hex( $color );
			$rgba = $hex->toRgba();
			$rgba = $rgba->alpha( $percent );

			return $rgba;
		}

	}

}
