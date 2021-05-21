<?php

use App\Entities\Post;
use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\I18n\Time;

class PostApiTest extends DatabaseTestCase
{
	use FeatureTestTrait;

	public function testListNoneFound()
	{
		// Ensure we have an empty table to start with.
		db_connect()->table('posts')->truncate();

		$response = $this->get('/api/posts');

		$response->assertStatus(404);
		$response->assertJSONExact([
			'error' => 404,
			'messages' => [
				'error' => 'Unable to locate any Posts'
			],
			'status' => 404
		]);
	}

	public function testListSingleSuccess()
	{
		// Grab the most recent
		$post1 = fake(\App\Models\PostModel::class, ['publish_at' => Time::parse('-1 day')]);
		$post2 = fake(\App\Models\PostModel::class, ['publish_at' => Time::parse('-1 week')]);
		// No future posts
		$post3 = fake(\App\Models\PostModel::class, ['publish_at' => Time::parse('+1 week')]);

		$response = $this->get('/api/posts?limit=1');

		$response->assertJSONFragment([[
			'id' => $post1->id,
			'title' => $post1->title,
			'links' => [
				'self' => site_url('api/post/'. $post1->id)
			]
		]]);
	}

	public function testCreateNoData()
	{
		$response = $this->post('/api/posts', []);

		$response->assertStatus(400);
		$response->assertJSONExact([
			'status' => 400,
			'error' => 400,
			'messages' => [
				'error' => 'Unable to create post. No data found.'
			]
		]);
	}

	public function testCreateInvalidData()
	{
		$data = [
			'title' => null,
			'body' => 'Body A',
			'publish_at' => Time::now()
		];

		$response = $this->post('/api/posts', $data);

		$response->assertStatus(400);
		$response->assertJSONExact([
			'status' => 400,
			'error' => 400,
			'messages' => [
				'title' => 'The title field is required.'
			]
		]);
	}

	public function testCreateSuccess()
	{
		$data = [
			'title' => 'Title A',
			'body' => 'Body A',
			'publish_at' => Time::now()
		];

		$response = $this->post('/api/posts', $data);

		$response->assertStatus(201);
		$response->assertJSONFragment([
			'message' => 'The post has been created.',
			'post' => [
				'title' => 'Title A'
			]
		]);
	}

	public function testUpdateNotFound()
	{
		$data = [
			'title' => null,
			'body' => 'Body A',
			'publish_at' => Time::now()
		];

		$response = $this->put('/api/post/1234', $data);

		$response->assertStatus(404);
		$response->assertJSONExact([
			'status' => 404,
			'error' => 404,
			'messages' => [
				'error' => 'Not Found'
			]
		]);
	}

	public function testUpdateInvalidData()
	{
		$post = fake(\App\Models\PostModel::class, ['publish_at' => Time::parse('-1 day')]);

		$data = [
			'title' => null,
			'body' => 'Body A',
			'publish_at' => Time::now()
		];

		$response = $this->put('/api/post/'. $post->id, $data);

		$response->assertStatus(400);
		$response->assertJSONExact([
			'status' => 400,
			'error' => 400,
			'messages' => [
				'title' => 'The title field is required.'
			],
		]);
	}

	public function testUpdateSuccess()
	{
		$post = fake(\App\Models\PostModel::class, ['publish_at' => Time::parse('-1 day')]);

		$data = [
			'title' => 'Title A',
			'body' => 'Body A',
			'publish_at' => Time::now()
		];

		$response = $this->put('/api/post/'. $post->id, $data);

		$response->assertStatus(200);
		$response->assertJSONExact([
			'message' => 'The post has been updated.',
			'links' => [
				'self' => site_url('api/post/'. $post->id)
			]
		]);

		$this->seeInDatabase('posts' , [
			'id' => $post->id,
			'title' => 'Title A',
			'body' => 'Body A'
		]);
	}

	public function testDeleteNotFound()
	{
		$response = $this->delete('/api/post/1234');

		$response->assertStatus(404);
		$response->assertJSONExact([
			'status' => 404,
			'error' => 404,
			'messages' => [
				'error' => 'Not Found'
			]
		]);
	}

	public function testDeleteSuccess()
	{
		$post = fake(\App\Models\PostModel::class, ['publish_at' => Time::now()]);

		$response = $this->delete('/api/post/'. $post->id);

		$response->assertStatus(200);
		$response->assertJSONExact([
			'message' => 'The post was deleted.',
		]);

		$this->dontSeeInDatabase('posts', [
			'id' => $post->id
		]);
	}
}
