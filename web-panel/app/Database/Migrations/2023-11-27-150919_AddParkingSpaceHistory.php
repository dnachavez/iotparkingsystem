<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParkingSpaceHistory extends Migration
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
            'parking_space_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1'],
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

        $this->forge->addForeignKey('parking_space_id', 'parking_spaces', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('parking_space_histories');
    }

    public function down()
    {
        $this->forge->dropTable('parking_space_histories');
    }
}
