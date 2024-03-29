<?php namespace App\Entities;

use CodeIgniter\Entity;

/**
 * Class Post
 *
 * Represents a single blog post.
 */
class Post extends Entity
{
    // Added 'publish_at' so we get a Time instance
    // to make it simpler to work with.
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'publish_at'
    ];

    /**
     * Return the URL to this post.
     *
     * @return string
     */
    public function link()
    {
        return site_url('/post/'. $this->id);
    }

    public function getBody()
    {
        return nl2br(esc($this->attributes['body']));
    }

	/**
	 * @param bool $onlyChanged
	 * @param bool $cast
	 * @param bool $recursive
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function apiArray(): array
	{
		$data = parent::toArray();

		// Add our entity links in the response.
		$data['links'] = [
			'self' => site_url('api/post/'. $this->id),
		];

		return $data;
    }
}
