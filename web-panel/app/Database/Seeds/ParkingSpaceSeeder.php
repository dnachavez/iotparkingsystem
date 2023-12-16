<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParkingSpaceSeeder extends Seeder
{
    public function run()
    {
        $now = new \DateTime('now');
        $currentDateTime = $now->format('Y-m-d H:i:s');
        
        $data = [
            [
                'name' => 'P1',
                'status' => '1',
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ],
            [
                'name' => 'P2',
                'status' => '1',
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ],
            [
                'name' => 'P3',
                'status' => '1',
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ],
            [
                'name' => 'P4',
                'status' => '1',
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ],
        ];

        $this->db->table('parking_spaces')->insertBatch($data);
    }
}
