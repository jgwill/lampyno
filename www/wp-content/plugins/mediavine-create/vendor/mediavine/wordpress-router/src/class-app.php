<?php
namespace Mediavine\WordPress\Router;

use Mediavine\WordPress\Support\Arr;
use Mediavine\WordPress\Support\Collection;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You have no business here' );
}

class App {

	protected $registry;

	function __construct($config = [])
	{
		$this->registry = new Collection(compact('config'));
	}

	public function bind($key, $value) {
		$this->registry = $this->registry->add([$key => $value]);
	}

	public function get($key, $default = null) {
		return Arr::data_get($this->registry->all(), $key, $default);
	}
}
