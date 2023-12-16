<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConstant extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
        ]);
        
        $this->forge->addUniqueKey('name');

        $this->forge->createTable('constants');
    }

    public function down()
    {
        $this->forge->dropTable('constants');
    }
}
