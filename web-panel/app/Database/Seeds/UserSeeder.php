<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = new \DateTime('now');
        $currentDateTime = $now->format('Y-m-d H:i:s');

        $data = [
            'username' => 'admin',
            'password' => '$2y$10$.JYh0Xhsqfb.DRT7vOmwx.J4hrx6RF3mXUXHeinrLnT.OYlsOVecy',
            'role' => '5',
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime,
        ];
        
        $this->db->table('users')->insert($data);
    }
}
