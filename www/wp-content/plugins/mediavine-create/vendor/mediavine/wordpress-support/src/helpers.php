<?php
use Mediavine\WordPress\Support\Arr;
use Mediavine\WordPress\Support\Str;
use Mediavine\WordPress\Support\Collection;

if (!function_exists('mv_get_value')) {
	/**
 * Return the default value of the given value.
 *
 * @param  mixed  $value
 * @return mixed
 */
	function mv_get_value($value)
	{
		return $value instanceof Closure ? $value() : $value;
	}
}

if (!function_exists('mv_data_get')) {
	/**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed   $target
     * @param  string|array|int  $key
     * @param  mixed   $default
     * @return mixed
     */
	function mv_data_get($target, $key, $default = null)
	{
		if (is_null($key)) {
			return $target;
		}

		$key = is_array($key) ? $key : explode('.', $key);

		while (!is_null($segment = array_shift($key))) {
			if ($segment === '*') {
				if ($target instanceof Collection) {
					$target = $target->all();
				} elseif (!is_array($target)) {
					return mv_get_value($default);
				}

				$result = [];

				foreach ($target as $item) {
					$result[] = mv_data_get($item, $key);
				}

				return in_array('*', $key) ? Arr::collapse($result) : $result;
			}

			if (Arr::accessible($target) && Arr::exists($target, $segment)) {
				$target = $target[$segment];
			} elseif (is_object($target) && isset($target->{$segment})) {
				$target = $target->{$segment};
			} else {
				return mv_get_value($default);
			}
		}

		return $target;
	}
}
