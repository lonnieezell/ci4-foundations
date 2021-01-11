<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'title'      => ['type' => 'varchar', 'constraint' => 255],
            'body'       => ['type' => 'text', 'null' => true],
            'publish_at' => ['type' => 'datetime', 'null' => true, 'default' => null],
            'created_at' => ['type' => 'datetime', 'null' => true, 'default' => null],
            'deleted_at' => ['type' => 'datetime', 'null' => true, 'default' => null],
        ]);
        $this->forge->createTable('posts', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
