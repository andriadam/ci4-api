<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Pegawai extends Migration
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
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'created_at' => [
                'type'      => 'DATETIME',
                'default'      => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'      => 'DATETIME',
                'default'      => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true); // column_name, is auto increement
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}
