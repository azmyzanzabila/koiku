<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel user
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false, // Menambahkan null => false jika email wajib diisi
            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        // Membuat primary key
        $this->forge->addKey('id', true);

        // Membuat tabel user
        $this->forge->createTable('user', true);
    }

    public function down()
    {
        // Menghapus tabel user
        $this->forge->dropTable('user', true);
    }
}
