<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\peminjaman;

class Peminjam extends Model
{
    protected $table = 'peminjam';

    protected $fillable = [
        'nama_peminjam',
        'kelas',
        'jurusan',
        'no_hp',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class); // "aku (peminjam) punya banyak peminjaman"
    }
}