<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function index()
    {
        $products = model(ProductModel::class);
        $typography = service('typography');

        echo view('product_list', [
            'products' => $products
                ->orderBy('name', 'asc')
                ->paginate(5),
            'pager' => $products->pager,
            'typography' => $typography,
        ]);
    }
}
