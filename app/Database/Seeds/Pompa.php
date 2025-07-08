<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pompa extends Seeder
{
    public function run()
    {
        // 
        $pompa_data = [

        ];

        foreach ($pompa_data as $data) {
            // insert semua data ke tabel
            $this->db->table('pompa')->insert($data);
        }
    }
}
