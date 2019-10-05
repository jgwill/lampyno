<?php
namespace Mediavine\WordPress\Router\API;

use \WP_REST_Server as Server;
use Mediavine\WordPress\Support\Arr;
use Mediavine\WordPress\Router\Router;

class Route extends Router
{
	public static $verbs = [
		'get' => Server::READABLE,
		'post' => Server::CREATABLE,
		'delete' => Server::DELETABLE,
		'put' => Server::EDITABLE,
		'patch' => Server::EDITABLE,
		'resource' => [Server::READABLE, Server::CREATABLE, Server::EDITABLE, Server::DELETABLE],
		'any' => Server::ALLMETHODS,
	];
	public $resource_verbs = [
		'index' => [
			'append_uri' => '/',
			'method'     => 'index',
		],
		'get'  => [
			'append_uri' => '/{d:ID}',
			'method'     => 'show',
		],
		'post' => [
			'append_uri' => '/{d:ID}',
			'method'     => 'store',
		],
		'put' => [
			'append_uri' => '/{d:ID}',
			'method'     => 'update',
		],
		'delete' => [
			'append_uri' => '/{d:ID}',
			'method'     => 'destroy',
		],
	];

	protected $namespace;
	protected $uri;
	protected $controller;
	protected $args;
	public $routes = [];

	public function register_route($method, $uri, $action, $args = [])
	{
		$namespace = $this->get_namespace();

		$uri = $this->parse_uri($uri);

		$action = $this->parse_action($action);

		$this->routes[$method][] = ['uri' => $uri, 'action' => $action ];
		register_rest_route(
			$namespace,
			$uri,
			[
				[
					'methods' => static::$verbs[$method],
					'callback' => $action,
					'args' => $args,
				]
			]
		);
		return $this;
	}

	public function register_resource_routes($uri, $controller, $args = []) {
		foreach ($this->resource_verbs as $verb => $details ) {
			if ( $verb === 'index' ) {
				$verb = 'get';
			}
			$path = $uri . $details['append_uri'];
			$this->register_route($verb, $path, $controller . '@' . $details['method']);
		}
		return $this;
	}

	public function get_namespace()
	{
		global $router;
		return $router->get('api.namespace') . '/' . $router->get('api.version');
	}

	public static function __callStatic($method, $arguments)
	{
		$verbs = ['get','post','put','patch','delete','any','fallback'];
		if ( in_array( $method, $verbs ) ){
			return (new static)->register_route($method, ...$arguments);
		}
		if ( $method === 'resource' ) {
			return (new static)->register_resource_routes(...$arguments);
		}

		throw new \BadMethodCallException('This method does not exist.');
	}
}
