<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pompa extends Seeder
{
    public function run()
    {
        // 
        $pompa_data = [
            [
                'jenis_pompa' => 'pengurasan',
                'status'  => 'on'
            ],
            [
                'jenis_pompa' => 'pengurasan',
                'status'  => 'off'
            ]
        ];

        foreach ($pompa_data as $data) {
            // insert semua data ke tabel
            $this->db->table('pompa')->insert($data);
        }
    }
}
