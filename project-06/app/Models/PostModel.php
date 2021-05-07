<?php namespace App\Models;

use App\Entities\Post;
use CodeIgniter\Model;
use Faker\Generator;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $allowedFields = ['title', 'body', 'publish_at'];
    protected $returnType = Post::class;

    /**
     * Filters any future queries to only include published posts.
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function published()
    {
        $this->where('publish_at <=', date('Y-m-d H:i:s'));

        return $this;
    }

    /**
     * Generate a set of fake data for this post.
     *
     * @param Generator $faker
     *
     * @return array
     */
    public function fake(Generator &$faker)
    {
        return [
            'title' => $faker->words(4, true),
            'body' => $faker->realText(300) ."\n\n". $faker->realText(300),
            'publish_at' => $faker->dateTime()
        ];
    }
}
