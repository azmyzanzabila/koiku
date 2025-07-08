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
                'turbidity' => '10',
                'pH'  => '7',
                'tds' => '200'
            ],
            [
                'turbidity' => '20',
                'pH'  => '8',
                'tds' => '250'
            ],
            [
                'turbidity' => '9',
                'pH'  => '7',
                'tds' => '350'
            ],
            [
                'turbidity' => '12',
                'pH'  => '6',
                'tds' => '270'
            ]
        ];

        foreach ($sensor_data as $data) {
            // insert semua data ke tabel
            $this->db->table('sensor')->insert($data);
        }
    }
}
