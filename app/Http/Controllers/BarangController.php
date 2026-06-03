<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // untuk menangkap data dari form
use App\Models\Barang;        // import Model Barang supaya bisa akses tabel barang
use Illuminate\Support\Facades\Storage; // untuk hapus file foto lama

class BarangController extends Controller
{
    // METHOD 1: menampilkan daftar semua barang
    public function index()
    {
        $barang = Barang::latest()->paginate(10);
        // Barang::latest()    = ambil data dari tabel barang, diurutkan dari yang terbaru
        //          (berdasarkan created_at DESC)
        // ->paginate(10)      = tampilkan 10 data per halaman (otomatis ada tombol next/prev)

        return view('barang.index', compact('barang'));
        // compact('barang') = kirim variabel $barang ke view
        // sama seperti menulis: ['barang' => $barang]
    }

    // METHOD 2: menampilkan form tambah barang
    public function create()
    {
        return view('barang.create');
        // cukup tampilkan form kosong, tidak perlu ambil data apapun
    }

    // METHOD 3: menyimpan data barang baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'kategori_barang' => 'required|string|max:255',
            'stok'            => 'required|integer|min:0',
            'kondisi_barang'  => 'required|string|max:255',
            // nullable  = tidak wajib upload
            // file      = bisa berupa file (bukan hanya gambar)
            // extensions:jpg,jpeg,png = format yang diizinkan
            // max:2048  = maksimal 2MB
        ]);

        $data = $request->all();

        // kalau ada foto yang diupload
        if ($request->hasFile('foto')) {
            // dd(
            //     $request->file('foto')->getClientOriginalName(),
            //     $request->file('foto')->getMimeType(),
            //     $request->file('foto')->getSize(),
            //     public_path('img/barang')
            // );
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();

            // simpan langsung ke folder public/img/barang
            $foto->move(public_path('img/barang'), $namaFoto);

            $data['foto'] = $namaFoto;
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // METHOD 4: menampilkan detail satu barang
    public function show(Barang $barang)
    // $barang di sini BUKAN variabel biasa
    // Laravel otomatis cari data di database berdasarkan ID yang ada di URL
    // ini namanya "Route Model Binding"
    // contoh: URL /barang/3 → Laravel otomatis ambil barang dengan id=3
    {
        return view('barang.show', compact('barang'));
        // kirim data barang yang ditemukan ke view
    }

    // METHOD 5: menampilkan form edit barang
    public function edit(Barang $barang)
    // sama seperti show(), Laravel otomatis ambil data barang berdasarkan ID di URL
    {
        return view('barang.edit', compact('barang'));
        // kirim data barang ke view supaya form bisa diisi dengan data yang sudah ada
    }

    // METHOD 6: menyimpan perubahan data barang ke database
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'kategori_barang' => 'required|string|max:255',
            'stok'            => 'required|integer|min:0',
            'kondisi_barang'  => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();

            // simpan langsung ke folder public/img/barang
            $foto->move(public_path('img/barang'), $namaFoto);

            $data['foto'] = $namaFoto;
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diubah.');
    }

    // METHOD 7: menghapus data barang dari database
    public function destroy(Barang $barang)
    {
        // hapus foto dari storage kalau ada
        if ($barang->foto) {
            Storage::delete('public/barang/' . $barang->foto);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
