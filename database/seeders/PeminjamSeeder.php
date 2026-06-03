<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjam;

class PeminjamSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_peminjam' => 'Ahmad Fauzan',  'kelas' => 'XI PPLG 1', 'jurusan' => 'PPLG', 'no_hp' => '081234567890'],
            ['nama_peminjam' => 'Rizky Pratama', 'kelas' => 'XI PPLG 2', 'jurusan' => 'PPLG', 'no_hp' => '081234567891'],
            ['nama_peminjam' => 'Dinda Putri',   'kelas' => 'XI PPLG 1', 'jurusan' => 'PPLG', 'no_hp' => '081234567892'],
        ];

        foreach ($data as $item) {
            Peminjam::create($item);
        }
    }
}