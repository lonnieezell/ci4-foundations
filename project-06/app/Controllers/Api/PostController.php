<?php namespace App\Controllers\Api;

use App\Models\PostModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

/**
 * Class PostController
 *
 * Provides an API to handle the CRUD for our blog posts.
 *
 * @package App\Controllers\Api
 */
class PostController extends Controller
{
	use ResponseTrait;

	protected $postModel;

	public function __construct()
	{
		$this->postModel = model(PostModel::class);
	}

	/**
	 * List all posts in the system.
	 * Optionally paginate the results.
	 *
	 * @return mixed
	 */
	public function list()
	{
		$limit = $this->request->getGet('limit');

		$posts = $this->postModel
			->published()
			->orderBy('publish_at', 'desc')
			->findAll((int)$limit);

		if (empty($posts)) {
			return $this->failNotFound('Unable to locate any Posts');
		}

		$results = [];

		foreach($posts as $post) {
			$results[] = $post->apiArray();
		}

		return $this->respond($results);
	}

	/**
	 * Creates a new POST
	 */
	public function create()
	{
		$data = $this->request->getPost();

		if (empty($data)) {
			return $this->failValidationErrors('Unable to create post. No data found.');
		}

		if (! $postId = $this->postModel->insert($data)) {
			return $this->failValidationErrors($this->postModel->errors());
		}

		$post = $this->postModel->find($postId);

		return $this->respondCreated([
			'message' => 'The post has been created.',
			'post' => $post->apiArray()
		]);
	}

	/**
	 * Update an existing post.
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function update(int $id)
	{
		$data = $this->request->getVar();

		if (empty($data)) {
			return $this->failValidationErrors('Unable to update post. No data found.');
		}

		$post = $this->postModel->find($id);

		if ($post === null) {
			return $this->failNotFound();
		}

		$post = $post->fill($data);

		if (! $this->postModel->save($post)) {
			return $this->failValidationErrors($this->postModel->errors());
		}

		return $this->respondUpdated([
			'message' => 'The post has been updated.',
			'links' => [
				'self' => site_url('api/post/'. $post->id)
			],
		]);
	}

	public function delete(int $id)
	{
		$post = $this->postModel->find($id);

		if ($post === null) {
			return $this->failNotFound();
		}

		$this->postModel->where('id', $id)->delete();

		return $this->respondDeleted([
			'message' => 'The post was deleted.',
		]);
	}
}
