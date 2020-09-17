<?php namespace App\Database\Seeds;

use App\Models\PostModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class PostSeeder extends Seeder
{
	public function run()
	{
		$fabricator = new Fabricator(new PostModel());

		$posts = $fabricator->create(15);
	}
}
