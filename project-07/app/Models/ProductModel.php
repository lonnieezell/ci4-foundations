<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $table                = 'products';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $allowedFields        = ['name', 'manufacturer', 'location', 'category'];

	// Dates
	protected $useTimestamps        = false;
}
