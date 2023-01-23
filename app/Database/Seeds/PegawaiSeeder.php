<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => 'Andri Adam',
            'alamat'    => 'Jalan Faliman Jaya',
            'email'    => 'adam@gmail.com',
            'jabatan'    => 'Backend Developer',
            'bidang'    => 'IT',
        ];

        // Simple Queries
        $this->db->query('INSERT INTO pegawai (nama, alamat, email, jabatan, bidang) VALUES(:nama:, :alamat:,
        :email:, :jabatan:, :bidang:)', $data);

        // Using Query Builder
        $this->db->table('pegawai')->insert($data);
    }
}
