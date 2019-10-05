<?php
namespace Mediavine\WordPress\Router\Tests;
/**
 * Base test case
 *
 * @package Mediavine_WordPress_Router
 */

class MV_TestCase extends \WP_UnitTestCase
{

    protected $namespaced_route = '/mv-router/v1';

    function setUp()
    {
        parent::setUp();
        global $wp_rest_server;
        $this->server = $wp_rest_server = new \WP_REST_Server;
        do_action('rest_api_init');
        do_action('init');
    }

    /**
     * Make a GET request to the given route.
     *
     * Assumes `$this->namespaced_route` is already set.
     *
     * @param  string $route        the route to GET -- `/creations`
     * @param  array  $query_params an array of query params -- `[ 'id' => 1 ]`
     * @return \WP_REST_Response`
     */
    function get( $route, $query_params = [] )
    {
        $request = new \WP_REST_Request('GET', $this->namespaced_route . $route);
        $request->set_query_params($query_params);

        return rest_do_request($request);
    }

    function post( $route, $params = [])
    {
        $request = new \WP_REST_Request('POST', $this->namespaced_route . $route);
        $request->set_body_params($params);

        return rest_do_request($request);
    }

    function patch( $route, $params = [])
    {
        $request = new \WP_REST_Request('PATCH', $this->namespaced_route . $route);
        $request->set_body_params($params);

        return rest_do_request($request);
    }

    function put( $route, $params = [])
    {
        $request = new \WP_REST_Request('PUT', $this->namespaced_route . $route);
        $request->set_body_params($params);

        return rest_do_request($request);
    }

    function delete( $route, $params = [])
    {
        $request = new \WP_REST_Request('DELETE', $this->namespaced_route . $route);
        $request->set_body_params($params);

        return rest_do_request($request);
    }

    function get_page( $route ) {
        $path = trim($_SERVER['REMOTE_ADDR'], '/') . DIRECTORY_SEPARATOR . trim($route, '/');
        ob_start();
        $this->go_to($path);
        $response = ob_get_contents();
        ob_end_clean();
        return $response;
    }

    /**
     * Dump the contents of a variable into the readable stream.
     *
     * @param  mixed  $var
     * @param  string $message
     * @return void
     */
    function dump( $var, $message = '' )
    {
        fwrite(STDERR, $message . "\r\n" . print_r($var, true));
    }

    /**
     * @test
     */
    function test_that_get_helper_function_fails_if_the_namespaced_route_does_not_exist()
    {
        $this->namespaced_route = '/non-existent/v1';
        $response = $this->get('/posts');

        $this->assertEquals(404, $response->status);
    }

}
