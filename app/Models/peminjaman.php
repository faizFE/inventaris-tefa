<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjam;
use App\Models\Barang;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'peminjam_id',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah_pinjam',
        'status_peminjaman',
    ];

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);// "aku (peminjaman) milik satu peminjam"
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);// "aku (peminjaman) milik satu barang"
    }
}