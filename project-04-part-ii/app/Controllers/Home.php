<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
        $this->cachePage(DAY);

        echo view('home', [
            'siteName' => 'Acme, Inc',
            'categories' => ['rockets', 'magnets', 'tools']
        ]);
	}

	//--------------------------------------------------------------------

}
