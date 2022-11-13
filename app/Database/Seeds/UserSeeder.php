<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'ID_PKL' => 'PKL00001',
                'fullname'  => 'Administrator',
                'email'  =>  "admin@admin.com",
                'level'  => 'admin',
                'date_of_birth' => date("Y-m-d"),
                'phone_number' => '081336473785',
                'position' => 'Admin',
                'password'  =>  password_hash("123", PASSWORD_DEFAULT),
                'registration_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'ID_PKL' => 'PKL00002',
                'fullname'  => 'Employee',
                'email'  =>  "employee@employee.com",
                'level'  => 'employee',
                'date_of_birth' => date("Y-m-d"),
                'phone_number' => '081336473755',
                'position' => 'Employee',
                'password'  =>  password_hash("123", PASSWORD_DEFAULT),
                'created_at' => date("Y-m-d H:i:s"),
                'registration_at' => date("Y-m-d H:i:s"),
            ],
            [
                'ID_PKL' => 'PKL00003',
                'fullname'  => 'Ridho',
                'email'  =>  "ridho@employee.com",
                'level'  => 'employee',
                'date_of_birth' => date("Y-m-d"),
                'phone_number' => '081336473755',
                'position' => 'Programmer',
                'password'  =>  password_hash("123", PASSWORD_DEFAULT),
                'registration_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}