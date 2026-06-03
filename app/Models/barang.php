<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjam;
use App\Models\Peminjaman;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'kategori_barang',
        'stok',
        'kondisi_barang',
        'foto',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);// "aku (barang) bisa ada di banyak peminjaman"
    }
}