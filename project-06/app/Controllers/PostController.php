<?php namespace App\Controllers;

use App\Entities\Post;
use App\Models\PostModel;

class PostController extends BaseController
{
	/**
	 * @var PostModel
	 */
	protected $posts;

	public function __construct()
	{
		$this->posts = model(PostModel::class);
	}

	/**
	 * Lists all posts in the system.
	 */
	public function manage()
	{
		$posts = $this->posts
			->orderBy('publish_at', 'asc')
		    ->paginate(10);

		echo view('crud/list', [
			'posts' => $posts,
			'pager' => $this->posts->pager,
		]);
	}

	/**
	 * Displays the form to create a new Post.
	 */
	public function createView()
	{
		echo view('crud/form', [
			'formType' => 'create'
		]);
	}

	/**
	 * Displays the edit post form
	 *
	 * @param int $postId
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function editView(int $postId)
	{
		$post = $this->posts->find($postId);

		if ($post === null) {
			return redirect()->back()->with('error', 'Unable to find that post.');
		}

		echo view('crud/form', [
			'formType' => 'edit',
			'post' => $post,
		]);
	}

	/**
	 * Saves/Creates a post.
	 *
	 * @param int $postId
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function save(int $postId=null)
	{
		if (! $this->validate([
			'title' => 'required|string',
			'body' => 'required|string',
			'publish_at' => 'required|valid_date',
		])) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$post = $postId === null
			? new Post($this->request->getPost())
			: $this->posts->find($postId);

		if ($post === null) {
			return redirect()->back()->with('error', 'Unable to find that post.');
		}

		$post->fill($this->request->getPost());
		$this->posts->save($post);

		return redirect()->to('/posts')->with('message', 'Your post has been saved.');
	}

	/**
	 * Deletes a single post.
	 *
	 * @param int $postId
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function delete(int $postId)
	{
		$post = $this->posts->find($postId);

		if ($post === null) {
			return redirect()->back()->with('error', 'Unable to find that post.');
		}

		$post->delete();

		return redirect()->to('/posts')->with('message', 'Your post has been deleted.');
	}
}
