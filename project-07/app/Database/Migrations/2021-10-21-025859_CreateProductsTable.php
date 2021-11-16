<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
           'id' => ['type' => 'int', 'constraint' => 11, 'autoincrement' => true, 'unsigned' => true],
           'name' => ['type' => 'varchar', 'constraint' => 255],
           'manufacturer' => ['type' => 'varchar', 'constraint' => 255],
            'location' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'category' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('products', true);
	}

	public function down()
	{
		$this->forge->dropTable('products');
	}
}
