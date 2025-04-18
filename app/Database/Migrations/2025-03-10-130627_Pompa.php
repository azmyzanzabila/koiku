<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pompa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'statusPompa' => [
                'type'       => 'INT',
                'constraint' => '10',
            ],
            'statusValve' => [
                'type'       => 'INT',
                'constraint' => '10',
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        // Membuat primary key
        $this->forge->addKey('id', true);

        // Membuat tabel pompa
        $this->forge->createTable('pompa', true);
    }

    public function down()
    {
        //// Menghapus tabel pompa
        $this->forge->dropTable('sensor', true);
    }
}
