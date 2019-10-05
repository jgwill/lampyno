<?php

namespace Mediavine\WordPress\Router;

use Mediavine\WordPress\Support\Arr;
// use Mediavine\WordPress\Support\Str;
use Mediavine\WordPress\Support\Str;
use BadMethodCallException;

class Router
{
	public function register_routes()
	{
		global $router;

		require $router->get('api.routes_file');
	}

	public function parse_action($action)
	{
		if (is_string($action) && !is_callable($action)) {
			$class = $this->find_controller_class($action);
			$method = $this->find_controller_method($action, $class);
			return [new $class, $method];
		}
		if (is_callable($action)) {
			return $action;
		}
	}

	public function find_controller_class($action)
	{
		global $router;

		$controller = $action;
		$namespace  = $router->get('api.controller_namespace');

		/**
		 * If the controller contains a `\`, we assume that it is a FQCN and update the namespace
		 * and controller to correctly parse for the rest of the method.
		 * Ex: `HTTP\Controllers\ExampleController@index`
		 * Namespace becomes `HTTP\Controllers`
		 * Controller becomes `ExampleController@index` for further parsing.
		 */
		if (is_string($controller) && Str::contains('\\', $controller)) {
			$pieces = explode('\\', $controller);
			$controller = array_pop($pieces);

			$namespace = implode('\\', $pieces) . '\\';
		}

		/**
		 * If the action is formatted `Controller@method`, split the string and assume the namespace
		 * so we can return the FQCN.
		 */
		if (is_string($controller) && Str::contains('@', $controller)) {
			$class = Arr::first(explode('@', $controller));
			return $namespace . $class;
		}
		/**
		 * If the action is just the name of a class, assume the namespace and return the FQCN.
		 */
		if (is_string($controller) && !Str::contains('@', $controller)) {
			return $namespace . $controller;
		}

		if (!class_exists($controller)) {
			throw new \Exception("No controller could be found for {$controller}.");
		}
		return $controller;
	}

	/**
	 * Determines what method to call on the controller for a route.
	 *
	 * @param string $action
	 * @param object $class
	 * @return string $method
	 * @throws BadMethodCallException
	 */
	public function find_controller_method($action, $class)
	{
		/**
		 * If the action contains
		 */
		if (Str::contains('@', $action)) {
			$method = Arr::last(explode('@', $action));
		}
		if (!Str::contains('@', $action)) {
			$method = '__invoke';
		}

		if (!method_exists($class, $method)) {
			throw new BadMethodCallException("The method '{$method}' does not exist on '{$class}'. From '{$action}'.");
		}
		return $method;
	}

	public function parse_uri($uri = '/')
	{
		if (Str::contains('{', $uri)) {
			/**
			 * This regex assumes a route like `/posts/{ID}` or `/posts/{s:slug}`
			 * The letter on the left of the `:` must be `d` (integer), `f` (float), or `s` (string), corresponding to the proper sprintf value type.
			 * If there is no `:`, `d` (integer) is assumed.
			 * https://regex101.com/r/KR5oVD/1
			 */
			$re = '/{(([a-zA-Z])\:)?(.+)}/';
			$uris = array_filter(explode('/', $uri));
			foreach ( $uris as $path ) {
				\preg_match($re, $path, $match);
				if ($match && ! empty($match[3])) {
					$type = ! empty($match[2]) ? $match[2] : 'd';
					$name = $match[3];
					$param = "(?P<{$name}>\\{$type}+)";
					$uri = Str::replace($match[0], $param, $uri);
				}
			}
		}
		return $uri;
	}
}
