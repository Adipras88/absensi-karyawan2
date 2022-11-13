<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'type_of_work'  => 'Administrator',
                'description'  =>  "admin@admin.com",
                'point'  => 600,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'user_id' => 2,
                'type_of_work'  => 'Programmer',
                'description'  =>  "Membuat sebuah database yang ramah dilihat user",
                'point'  => 7000,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ];
        $this->db->table('jobs')->insertBatch($data);
    }
}