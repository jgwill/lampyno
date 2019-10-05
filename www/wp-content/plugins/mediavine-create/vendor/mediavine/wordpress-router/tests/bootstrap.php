<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Mediavine_WordPress_Router
 */

require_once dirname( __FILE__ , 2 ) . '/vendor/autoload.php';

use Mediavine\WordPress\Router\RouterConfiguration;

$_tests_dir = getenv('WP_TESTS_DIR');

if (! $_tests_dir ) {
    $_tests_dir = '/tmp/wordpress-tests-lib';
}

if (! file_exists($_tests_dir . '/includes/functions.php') ) {
    throw new Exception("Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh?");
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

$router = new RouterConfiguration( [
    'api' => [
		'namespace' => 'mv-router',
		'version'   => 'v1',
		'controller_namespace' => 'Mediavine\\WordPress\\Router\\Tests\\Controllers\\',
	]
] );
