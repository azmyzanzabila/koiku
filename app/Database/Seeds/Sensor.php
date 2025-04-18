<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Sensor extends Seeder
{
    public function run()
    {
        //
        $sensor_data = [
            [
                'turbidity' => '130',
                'pH'  => '7',
                'tds' => '8'
            ],
            [
                'turbidity' => '150',
                'pH'  => '8',
                'tds' => '9'
            ]
        ];

        foreach ($sensor_data as $data) {
            // insert semua data ke tabel
            $this->db->table('sensor')->insert($data);
        }
    }
}
