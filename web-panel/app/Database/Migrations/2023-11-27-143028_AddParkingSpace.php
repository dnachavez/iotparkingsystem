<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParkingSpace extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1', '2'],
                'default' => '1',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        
        $this->forge->addUniqueKey('name');

        $this->forge->createTable('parking_spaces');
    }

    public function down()
    {
        $this->forge->dropTable('parking_spaces');
    }
}
