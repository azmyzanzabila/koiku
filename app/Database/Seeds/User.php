<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        // membuat data
        $user_data = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
            ],
            [
                'nama' => 'Tiara',
                'email' => 'tiara@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
            ]
        ];

        foreach ($user_data as $data) {
            // insert semua data ke tabel
            $this->db->table('user')->insert($data);
        }
    }
}
