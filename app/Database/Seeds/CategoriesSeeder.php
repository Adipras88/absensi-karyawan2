<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => "Sakit",
                'slug' => "sakit",
                'created_at' => date("Y-m-d", time()),
                'updated_at' => date("Y-m-d", time()),
            ],
            [
                'name' => "Izin",
                'slug' => "izin",
                'created_at' => date("Y-m-d", time()),
                'updated_at' => date("Y-m-d", time()),
            ],
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}