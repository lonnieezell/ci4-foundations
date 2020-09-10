<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
	public function up()
	{
        $this->forge->addField('id');
        $this->forge->addField([
            'name' => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'text', 'null' => true],
            'price' => ['type' => 'int', 'constraint' => 7, 'unsigned' => true]
        ]);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('products', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('products');
	}
}
