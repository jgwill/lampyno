<?php

namespace Mediavine\WordPress\Router\Tests\Controllers;
use \WP_REST_Request as Request;

class InvokeableController {
	function __invoke(Request $request) {
		return 'success';
	}
}
