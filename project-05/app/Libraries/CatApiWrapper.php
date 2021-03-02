<?php

namespace App\Libraries;

use Config\Services;

class CatApiWrapper
{
	/**
	 * @var \CodeIgniter\HTTP\CURLRequest
	 */
	protected $curl;

	protected $limit = 20;

	protected $page = 1;

	/**
	 * @var string
	 */
	protected $breedId;

	public function __construct()
	{
		$this->curl = Services::curlrequest();
		$this->curl->setHeader('x-api-key', config('CatApi')->apiKey);
	}

	/**
	 * Returns all breeds from the API.
	 *
	 * @return \CodeIgniter\Cache\CacheInterface|\CodeIgniter\HTTP\ResponseInterface|mixed
	 */
	public function breeds()
	{
		if (! $breeds = cache('breeds'))
		{
			$result = $this->curl->get('https://api.thecatapi.com/v1/breeds');
			$rawBreeds = json_decode($result->getBody());

			$breeds = [];
			foreach ($rawBreeds as $row) {
				$breeds[] = [
					'id' => $row->id,
					'name' => $row->name,
				];
			}

			cache()->save('breeds', $breeds);
		}

		return $breeds;
	}

	public function limit(int $limit)
	{
		$this->limit = $limit;

		return $this;
	}

	public function page(int $page)
	{
		$this->page = $page;

		return $this;
	}

	public function forBreed(string $breedId)
	{
		$this->breedId = $breedId;

		return $this;
	}

	public function search()
	{
		$url = 'https://api.thecatapi.com/v1/images/search';

		$params = [
			'breed_id' => $this->breedId,
			'limit' => $this->limit,
			'page' => $this->page,
			'size' => 'thumb',
		];

		$query = http_build_query($params);
		$result = $this->curl->get($url.'?'.$query);

		return $result->setStatusCode(200)
			? json_decode($result->getBody())
			: null;
	}
}
