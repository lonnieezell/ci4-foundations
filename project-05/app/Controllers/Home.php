<?php namespace App\Controllers;

use App\Libraries\CatApiWrapper;
use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class Home extends BaseController
{
	/**
	 * @var \App\Libraries\CatApiWrapper
	 */
	protected $api;

	public function __construct()
	{
		$this->api = new CatApiWrapper();
	}

	public function index()
	{
        echo view('home', [
        	'breeds' => $this->api->breeds(),
        ]);
	}

	public function search()
	{
		$breed = $this->request->getVar('breed', FILTER_SANITIZE_STRING);

		if (empty($breed)) {
			return 'You must select a breed.';
		}

		$results = $this->api
			->limit(20)
			->page(1)
			->forBreed($breed)
			->search();

		return view('_results', [
			'images' => $results
		]);
	}

}
