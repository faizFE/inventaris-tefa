<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_barang' => 'Laptop Asus',          'kategori_barang' => 'Laptop',     'stok' => 10, 'kondisi_barang' => 'Baik'],
            ['nama_barang' => 'Mouse Logitech',        'kategori_barang' => 'Aksesoris',  'stok' => 15, 'kondisi_barang' => 'Baik'],
            ['nama_barang' => 'Keyboard Mechanical',   'kategori_barang' => 'Aksesoris',  'stok' => 8,  'kondisi_barang' => 'Baik'],
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }
    }
}