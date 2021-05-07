<?php

use CodeIgniter\Test\CIDatabaseTestCase;

class PostModelTest extends CIDatabaseTestCase
{
    /**
     * @var \App\Models\PostModel
     */
    protected $posts;

    protected $namespace = 'App';

    public function setUp(): void
    {
        parent::setUp();

        $this->posts = new \App\Models\PostModel();
    }

    public function testPublishedFilterWithPublishedPosts()
    {
        $this->posts->insertBatch([
            ['title' => 'Post A', 'body' => 'Post A Body', 'publish_at' => date('Y-m-d', strtotime('-1 week'))],
            ['title' => 'Post B', 'body' => 'Post B Body', 'publish_at' => date('Y-m-d', strtotime('-1 week'))],
            ['title' => 'Post C', 'body' => 'Post C Body', 'publish_at' => date('Y-m-d', strtotime('+1 week'))],
        ]);

        $results = $this->posts->published()->get()->getResult();

        $this->assertCount(2, $results);
    }

    public function testPublishedFilterWithoutPublishedPosts()
    {
        $this->posts->insertBatch([
            ['title' => 'Post A', 'body' => 'Post A Body', 'publish_at' => date('Y-m-d', strtotime('+1 week'))],
            ['title' => 'Post B', 'body' => 'Post B Body', 'publish_at' => date('Y-m-d', strtotime('+1 week'))],
            ['title' => 'Post C', 'body' => 'Post C Body', 'publish_at' => date('Y-m-d', strtotime('+1 week'))],
        ]);

        $results = $this->posts->published()->get()->getResult();

        $this->assertCount(0, $results);
    }
}
