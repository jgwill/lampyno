<?php

namespace Mediavine\WordPress\Router\Tests;

use Mediavine\WordPress\Router\API\Route;

/**
 * API Route Test
 *
 * @package Mediavine_WordPress_Router
 */
class TestAPIRoutes extends MV_TestCase {

	/** @test */
	public function it_can_register_a_GET_route()
	{
		$route = Route::get('/test-route', function() {
			return response(['test' => 'response']);
		});
		$data = $this->get('/test-route')->data;
		$this->assertEquals('response', $data['test']);
	}

	/**
	 * @test
	 * @dataProvider postContentProvider
	 */
	public function it_can_register_a_POST_route($postContent)
	{
		Route::post('/posts', function(\WP_REST_Request $request) {
			$params = get_request_params($request, ['post_title', 'post_content']);
			$post_id = \wp_insert_post($params);
			$data = \get_post($post_id);
			return response($data);
		});
		$response = $this->post('/posts', $postContent);

		$post = $response->get_data();

		$this->assertEquals($postContent['post_title'], $post['post_title']);
		$this->assertEquals($postContent['post_content'], $post['post_content']);
	}

	/**
	 * @test
	 * @dataProvider postContentProvider
	 */
	public function it_can_register_a_PUT_route($originalContent, $updatedContent)
	{
		$id = \wp_insert_post($originalContent);
		Route::put('/posts/{ID}', function(\WP_REST_Request $request) {
			$params = get_request_params($request, ['ID', 'post_title', 'post_content']);

			\wp_update_post($params);
			$data = \get_post($params['ID']);
			return response($data);
		});
		$response = $this->put('/posts/' . $id, $updatedContent);

		$post = $response->get_data();

		$this->assertEquals($updatedContent['post_title'], $post['post_title']);
		$this->assertEquals($updatedContent['post_content'], $post['post_content']);
	}

	/**
	 * @test
	 * @dataProvider postContentProvider
	 */
	public function it_can_register_a_PATCH_route($originalContent, $updatedContent)
	{
		$id = \wp_insert_post($originalContent);
		Route::patch('/posts/{ID}', function(\WP_REST_Request $request) {
			$params = get_request_params($request, ['ID', 'post_title', 'post_content']);

			\wp_update_post($params);
			$data = \get_post($params['ID']);
			return response($data);
		});
		$response = $this->patch('/posts/' . $id, $updatedContent);

		$post = $response->get_data();

		$this->assertEquals($updatedContent['post_title'], $post['post_title']);
		$this->assertEquals($updatedContent['post_content'], $post['post_content']);
	}

	/**
	 * @test
	 * @dataProvider postContentProvider
	 */
	public function it_can_register_a_DELETE_route($originalContent)
	{
		$id = \wp_insert_post($originalContent);
		Route::delete('/posts/{id}', function(\WP_REST_Request $request) {
			$params = get_request_params($request, 'id');

			$data = wp_delete_post($params['id'], true);
			return response(compact('data'));
		});
		$response = $this->delete('/posts/' . $id);

		$post = $response->get_data()['data'];
		$this->assertNotSame(false, $post);
		$this->assertEquals($id, $post->ID);
	}

	/**
	 * @test
	 */
	function it_can_register_a_resource_route()
	{
		Route::resource('/test', 'ResourceController');
		$index = $this->get('/test');
		$single = $this->get('/test/1');
		$post = $this->post('/test/1');
		$update = $this->put('/test/1');
		$destroy = $this->delete('/test/1');

		$this->assertEquals('index', $index->get_data());
		$this->assertEquals('shown', $single->get_data());
		$this->assertEquals('created', $post->get_data());
		$this->assertEquals('updated', $update->get_data());
		$this->assertEquals('destroyed', $destroy->get_data());
	}

	/**
	 * @test
	 */
	function it_can_register_an_invokeable_controller()
	{
		Route::get('/test', 'InvokeableController');
		$response = $this->get('/test')->get_data();

		$this->assertEquals('success', $response);
	}

	public function postContentProvider() {
		return [
			[['post_title' => 'Title', 'post_content' => 'Content'], ['post_title' => 'Changed Title', 'post_content' => 'Changed Content']],
			[['post_title' => 'A Different Title', 'post_content' => 'Different Content'], ['post_title' => 'Another Changed Title', 'post_content' => 'More Changed Content']]
		];
	}


}
