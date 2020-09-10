<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Acoustic Guitar', 'description' => 'Well loved and road worn.', 'price' => '10000'],
            ['name' => 'Electric Guitar', 'description' => 'An icon of rock and roll.', 'price' => '20000'],
            ['name' => 'Ukulele', 'description' => 'For the songwriter in all of us.', 'price' => '12000'],
            ['name' => 'Bar Piano', 'description' => 'Only a little beer left on it.', 'price' => '22000'],
            ['name' => 'Tin Whistle', 'description' => 'Irish at heart, for epic fantasy.', 'price' => '2000'],
            ['name' => 'Tamborine', 'description' => 'Jingle Jangle Man', 'price' => '1000'],
            ['name' => 'Cajon', 'description' => 'Give me a beat!', 'price' => '10500'],
        ];

        foreach($products as $product) {
            $this->db->table('products')->insert($product);
        }
    }
}
