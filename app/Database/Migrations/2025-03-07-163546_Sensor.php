<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sensor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'turbidity' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'pH' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'tds' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Membuat primary key
        $this->forge->addKey('id', true);

        // Membuat tabel sensor
        $this->forge->createTable('sensor', true);
    }

    public function down()
    {
        // Menghapus tabel sensor
        $this->forge->dropTable('sensor', true);
    }
}
