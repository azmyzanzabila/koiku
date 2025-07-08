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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'statusPompa' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '0=OFF, 1=ON'
            ],
            'statusValve' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '0=OFF, 1=ON'
            ],
            'mode' => [
                'type'       => 'ENUM',
                'constraint' => ['auto', 'manual'],
                'comment'    => 'Type of pump being controlled',
                'default' => 'auto',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('pompa', true);
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('pompa', true);
    }
}
