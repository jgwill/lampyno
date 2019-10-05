<?php
namespace Mediavine\WordPress\Support;

use Mediavine\WordPress\Support\Arr;

class Str {

	/**
	 * Determine if a given string contains a given substring.
	 *
	 * @param  string|array  $searches
	 * @param  string  $subject
	 * @return bool
	 */
	public static function contains( $searches, $subject ) {
		foreach ( Arr::wrap( $searches ) as $search ) {
			if ( '' !== $search && false !== strpos( $subject, $search ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Determine if a given string matches a given pattern.
	 *
	 * @param  string|array  $possibilities
	 * @param  string  $value
	 * @return bool
	 */
	public static function is( $possibilities, $value ) {
		foreach ( Arr::wrap( $possibilities ) as $possibility ) {
			if ( $possibility === $value ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Return the length of the given string.
	 *
	 * @param  string  $value
	 * @param  string  $encoding
	 * @return int
	 */
	public static function length( $value, $encoding = null ) {
		$encoding = $encoding ? $encoding : mb_internal_encoding();
		return mb_strlen( $value, $encoding );
	}

	/**
	 * Replace each occurrence of a given value in the string.
	 *
	 * @param  string|int  $search
	 * @param  string|int  $replace
	 * @param  string  $subject
	 * @return string
	 */
	public static function replace( $search, $replace, $subject ) {
		if ( empty( $search ) || $search === $replace ) {
			return $subject;
		}
		$search   = (string) $search;
		$replace  = (string) $replace;
		$position = strpos( $subject, $search );
		if ( false !== $position ) {
			$subject = str_replace( $search, $replace, $subject );
		}
		return $subject;
	}

	/**
	 * Determines whether string `$subject` ends with string `$search`.
	 *
	 * @param string|int $search
	 * @param string $needle
	 * @return boolean
	 */
	public static function endsWith($search, $subject)
	{
		$search = (string) $search;
		$length = strlen($search);
		if ($length == 0) {
			return true;
		}
		return substr($subject, -$length) === $search;
	}

	/**
	 * Determines whether string `$subject` begins with string `$search`.
	 *
	 * @param string|int $search
	 * @param string $needle
	 * @return boolean
	 */
	public static function beginsWith($search, $subject)
	{
		$search = (string) $search;
		$length = strlen($search);
		if ($length == 0) {
			return true;
		}
		return substr($subject, 0, $length) === $search;
	}

	/**
	 * Appends a string to the end of a string.
	 *
	 * @param string $append
	 * @param string $subject
	 * @param string $appendWith
	 * @return string the concatenated string
	 */
	public static function append( $append, $subject = '', $appendWith = ' ' ) {
		if ( empty( $append ) ) {
			return $subject;
		}
		return $subject . $appendWith . $append;
	}

	/**
	 * Prepends a string to the beginning of a string.
	 *
	 * @param string $prepend
	 * @param string $subject
	 * @param string $appendWith
	 * @return string the concatenated string
	 */
	public static function prepend( $prepend, $subject, $prependWith = ' ' ) {
		if ( empty( $prepend ) || empty( $subject ) ) {
			return $subject;
		}
		return $prepend . $prependWith . $subject;
	}

	/**
	 * Combines multiple strings together with glue.
	 *
	 * @param string|array $one either a string or an array of strings
	 * @param string $two either the second string to combine or the glue to combine an array of strings with
	 * @param string $glue the glue to combine strings with if $one is not an array
	 * @return string $final the combined string
	 */
	public static function combine( $one, $two = ' ', $glue = ' ' ) {
		if ( is_array($one) ) {
			$glue = $two;
			$final = implode($glue, $one);
			return trim($final, $glue);
		}
		return trim($one . $glue . $two);
	}
}
