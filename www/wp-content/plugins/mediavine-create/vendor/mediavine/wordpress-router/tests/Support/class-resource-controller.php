<?php

namespace Mediavine\WordPress\Router\Tests\Controllers;
use \WP_REST_Request as Request;

class ResourceController {
	public function index(Request $request) {
		return 'index';
	}
	public function store(Request $request) {
		return 'created';
	}
	public function update(Request $request) {
		return 'updated';
	}
	public function show(Request $request) {
		return 'shown';
	}
	public function destroy(Request $request) {
		return 'destroyed';
	}
}
