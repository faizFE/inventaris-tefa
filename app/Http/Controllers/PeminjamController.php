<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam; // import model Peminjam

class PeminjamController extends Controller
{
    // METHOD 1: tampilkan daftar semua peminjam (SATU-SATUNYA method yang dipakai)
    public function index()
    {
        $peminjam = Peminjam::latest()->paginate(10);
        // latest()     = urutkan dari yang terbaru
        // paginate(10) = tampilkan 10 data per halaman

        return view('peminjam.index', compact('peminjam'));
        // tampilkan ke halaman daftar peminjam
    }

    // ↓ method-method di bawah ini SENGAJA dikosongkan
    // karena peminjam tidak punya CRUD, datanya hanya dari Seeder

    public function create()
    {
        // dikosongkan, tidak ada form tambah peminjam
    }

    public function store(Request $request)
    {
        // dikosongkan, tidak ada proses simpan peminjam
    }

    public function show(string $id)
    {
        // dikosongkan, tidak ada halaman detail peminjam
    }

    public function edit(string $id)
    {
        // dikosongkan, tidak ada form edit peminjam
    }

    public function update(Request $request, string $id)
    {
        // dikosongkan, tidak ada proses update peminjam
    }

    public function destroy(string $id)
    {
        // dikosongkan, tidak ada proses hapus peminjam
    }
}