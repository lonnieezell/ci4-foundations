<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PostModel;

class BlogController extends Controller
{
    /**
     * Displays the 5 most recent posts in their entirety.
     */
    public function index()
    {
        $posts = model(PostModel::class);

        echo view('posts/list', [
            'posts' => $posts
                ->published()
                ->orderBy('title', 'asc')
                ->paginate(5),
            'pager' => $posts->pager,
        ]);
    }

    /**
     * View a single post.
     *
     * @param int $postId
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function view(int $postId)
    {
        $posts = model(PostModel::class);
        $post = $posts->find($postId);

        if ($post === null) {
            return redirect()->back()->with('error', 'Unable to locate the post.');
        }

        echo view('posts/single', [
            'post' => $post,
        ]);
    }

    /**
     * Return the HTML for our Recent Posts cell.
     *
     * @param array $params
     *
     * @return string
     */
    public function recentPostsCell(array $params = [])
    {
        $posts = model(PostModel::class);

        return view('posts/_recent', [
            'posts' => $posts
                ->published()
                ->orderBy('title', 'asc')
                ->paginate($params['limit'] ?? 7),
        ]);
    }
}
