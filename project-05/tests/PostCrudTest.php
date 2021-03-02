<?php

use App\Entities\Post;
use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class PostCrudTest extends DatabaseTestCase
{
	use FeatureTestTrait;

	protected $routes;

	protected $refresh = true;

	/**
	 * @var \App\Models\PostModel
	 */
	protected $model;

	public function setUp(): void
	{
		parent::setUp();

		$this->model = model(\App\Models\PostModel::class);
	}

	public function testCanViewPostList()
	{
		$response = $this->get( 'posts');

		$response->assertStatus(200);
		$response->assertSee('Manage Posts');
	}

	public function testCanViewNewPostForm()
	{
		$response = $this->call('get', 'posts/create');

		$response->assertStatus(200);
		$response->assertSee('Create New Post');
	}

	public function testCanCreatePost()
	{
		$this->dontSeeInDatabase('posts', [
			'title' => 'Post A'
		]);

		$response = $this->call('post', 'posts', [
			'title' => 'Post A',
			'publish_at' => date('Y-m-d', strtotime('+1 week')),
			'body' => 'My Great Post'
		]);

		$response->assertRedirect();
		$response->assertSessionHas('message');

		$this->seeInDatabase('posts', [
			'title' => 'Post A'
		]);
	}

	public function testCreatePostValidationErrors()
	{
		$response = $this->call('post', 'posts', [
			'title' => '',
			'publish_at' => '',
			'body' => '',
		]);

		$response->assertRedirect();
		$response->assertSessionHas('errors');
	}

	public function testCanViewEditPostForm()
	{
		// We have already seeded fake posts so grab one
		$post = $this->model->first();

		$response = $this->call('get', "posts/{$post->id}");

		$response->assertStatus(200);
		$response->assertSee('Edit Post');

		// Form should be filled with post data.
		$response->assertSee($post->title);
	}

	public function testCanEditPost()
	{
		// Getting weird errors when all tests ran together
		// so let's bypass that here...
		db_connect()->table('posts')->truncate();

		// create a new fake post in the database we can work with.
		$post = fake(\App\Models\PostModel::class);

		$this->seeInDatabase('posts', [
			'id' => $post->id,
			'title' => $post->title
		]);

		$response = $this->post("posts/{$post->id}", [
			'title' => 'Post A',
			'publish_at' => date('Y-m-d 00:00:00', strtotime('+1 week')),
			'body' => 'My Great Post'
		]);

		$response->assertStatus(302);

		$this->seeInDatabase('posts', [
			'id' => $post->id,
			'title' => 'Post A',
			'body' => 'My Great Post',
			'publish_at' => date('Y-m-d 00:00:00', strtotime('+1 week')),
		]);
	}
}
