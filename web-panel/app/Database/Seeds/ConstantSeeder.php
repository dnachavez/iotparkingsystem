<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConstantSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'tollgate',
            'value' => 'close',
        ];

        $this->db->table('constants')->insert($data);
    }
}
