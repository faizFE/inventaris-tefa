<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman; // import model Peminjaman
use App\Models\Peminjam;   // import model Peminjam (untuk dropdown form)
use App\Models\Barang;     // import model Barang (untuk cek & update stok)
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // METHOD 1: tampilkan daftar semua peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with(['peminjam', 'barang'])->latest()->paginate(10);
        // with(['peminjam', 'barang']) = eager loading, ambil sekalian data relasi
        //   tanpa with() → setiap baris tabel akan query ke database lagi (boros)
        //   dengan with() → cukup 3 query sekaligus (peminjaman + peminjam + barang)
        // latest()     = urutkan dari yang terbaru (created_at DESC)
        // paginate(10) = tampilkan 10 data per halaman

        return view('peminjaman.index', compact('peminjaman'));
    }

    // METHOD 2: tampilkan form tambah peminjaman
    public function create()
    {
        $peminjam = Peminjam::all();
        // ambil SEMUA data peminjam untuk ditampilkan di dropdown form

        $barang = Barang::where('stok', '>', 0)->get();
        // ambil barang yang stoknya LEBIH DARI 0
        // where('stok', '>', 0) = filter, jangan tampilkan barang yang stoknya habis
        // supaya user tidak bisa meminjam barang yang stoknya 0

        return view('peminjaman.create', compact('peminjam', 'barang'));
        // kirim kedua data ke view untuk ditampilkan di dropdown
    }

    // METHOD 3: simpan data peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'peminjam_id'     => 'required|exists:peminjam,id',
            // exists:peminjam,id = cek apakah id ini benar-benar ada di tabel peminjam
            // mencegah manipulasi data dari luar

            'barang_id'       => 'required|exists:barang,id',
            // sama, cek apakah barang_id ada di tabel barang

            'tanggal_pinjam'  => 'required|date',
            // date = harus format tanggal yang valid

            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            // after_or_equal:tanggal_pinjam = tanggal kembali tidak boleh
            // lebih awal dari tanggal pinjam

            'jumlah_pinjam'   => 'required|integer|min:1',
            // min:1 = minimal pinjam 1, tidak boleh 0
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        // findOrFail() = cari barang berdasarkan id
        // kalau tidak ketemu → otomatis error 404
        // lebih aman daripada find() yang return null kalau tidak ketemu

        // CEK STOK: jumlah pinjam tidak boleh melebihi stok
        if ($request->jumlah_pinjam > $barang->stok) {
            return back()->withErrors([
                'jumlah_pinjam' => 'Jumlah pinjam melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok,
            ])->withInput();
            // back()        = kembali ke halaman sebelumnya (form)
            // withErrors()  = kirim pesan error ke view
            // withInput()   = pertahankan inputan user supaya tidak perlu isi ulang form
        }

        // KURANGI STOK otomatis saat peminjaman dibuat
        $barang->decrement('stok', $request->jumlah_pinjam);
        // decrement('stok', 3) = stok dikurangi 3
        // contoh: stok 10 → jadi 7

        // SIMPAN data peminjaman
        Peminjaman::create([
            'peminjam_id'       => $request->peminjam_id,
            'barang_id'         => $request->barang_id,
            'tanggal_pinjam'    => $request->tanggal_pinjam,
            'tanggal_kembali'   => $request->tanggal_kembali,
            'jumlah_pinjam'     => $request->jumlah_pinjam,
            'status_peminjaman' => 'Dipinjam', // default saat baru dibuat selalu 'Dipinjam'
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // METHOD 4: tampilkan detail satu peminjaman
    // yang benar
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['peminjam', 'barang']);
        return view('peminjaman.show', compact('peminjaman'));
        // load() dulu relasinya, baru kirim ke view pakai compact()
    }

    // METHOD 5: tampilkan form edit peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        $peminjam = Peminjam::all();
        $barang   = Barang::all();
        // ambil SEMUA barang (termasuk stok 0) karena di edit kita perlu tampilkan
        // barang yang sedang dipinjam meskipun stoknya sudah 0

        return view('peminjaman.edit', compact('peminjaman', 'peminjam', 'barang'));
    }

    // METHOD 6: simpan perubahan data peminjaman (yang paling kompleks!)
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'peminjam_id'       => 'required|exists:peminjam,id',
            'barang_id'         => 'required|exists:barang,id',
            'tanggal_pinjam'    => 'required|date',
            'tanggal_kembali'   => 'required|date|after_or_equal:tanggal_pinjam',
            'jumlah_pinjam'     => 'required|integer|min:1',
            'status_peminjaman' => 'required|in:Dipinjam,Dikembalikan',
            // in:... = hanya boleh salah satu dari nilai ini
        ]);

        $barang     = Barang::findOrFail($request->barang_id);
        $statusLama = $peminjaman->status_peminjaman; // status sebelum diubah
        $statusBaru = $request->status_peminjaman;    // status yang baru dikirim dari form
        $jumlahLama = $peminjaman->jumlah_pinjam;     // jumlah sebelum diubah
        $jumlahBaru = $request->jumlah_pinjam;        // jumlah yang baru dikirim dari form

        // KONDISI A: barang tidak diganti (barang_id sama)
        if ($peminjaman->barang_id == $request->barang_id) {

            $selisih = $jumlahBaru - $jumlahLama;
            // contoh: lama=3, baru=5 → selisih=2 (butuh 2 stok lagi)
            // contoh: lama=5, baru=3 → selisih=-2 (kembalikan 2 stok)

            // cek stok kalau jumlah bertambah
            if ($selisih > 0 && $selisih > $barang->stok) {
                return back()->withErrors([
                    'jumlah_pinjam' => 'Jumlah pinjam melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok,
                ])->withInput();
            }

            if ($statusBaru === 'Dikembalikan' && $statusLama !== 'Dikembalikan') {
                // KASUS: status berubah jadi Dikembalikan
                // → tambah stok kembali sebanyak jumlah yang dipinjam
                $barang->increment('stok', $jumlahLama);
                // increment('stok', 3) = stok ditambah 3
                // contoh: stok 7 → jadi 10

            } elseif ($statusLama === 'Dikembalikan' && $statusBaru !== 'Dikembalikan') {
                // KASUS: status dari Dikembalikan balik ke Dipinjam
                // → kurangi stok lagi karena barang dipinjam lagi
                $barang->decrement('stok', $jumlahBaru);
            } else {
                // KASUS: status tidak berubah, tapi jumlah berubah
                // → sesuaikan stok berdasarkan selisih
                $barang->decrement('stok', $selisih);
                // kalau selisih negatif (-2), decrement(-2) = stok bertambah 2
            }

            // KONDISI B: barang diganti (barang_id berbeda)
        } else {
            $barangLama = Barang::findOrFail($peminjaman->barang_id);
            // ambil data barang LAMA untuk dikembalikan stoknya

            if ($statusLama !== 'Dikembalikan') {
                // kalau status lama bukan Dikembalikan berarti barang masih dipinjam
                // → kembalikan stok barang lama
                $barangLama->increment('stok', $jumlahLama);
            }

            if ($statusBaru !== 'Dikembalikan') {
                // kalau status baru bukan Dikembalikan berarti barang baru ikut dipinjam
                // → kurangi stok barang baru
                if ($jumlahBaru > $barang->stok) {
                    return back()->withErrors([
                        'jumlah_pinjam' => 'Jumlah pinjam melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok,
                    ])->withInput();
                }
                $barang->decrement('stok', $jumlahBaru);
            }
        }

        $peminjaman->update($request->all());
        // simpan semua perubahan data peminjaman ke database

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diubah.');
    }

    // METHOD 7: hapus data peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman !== 'Dikembalikan') {
            // kalau status BUKAN Dikembalikan berarti barang masih di luar
            // → kembalikan stok sebelum data dihapus
            $peminjaman->barang->increment('stok', $peminjaman->jumlah_pinjam);
            // $peminjaman->barang = akses data barang lewat relasi (belongsTo)
            // tidak perlu Barang::find() lagi karena relasi sudah didefinisikan di model
        }
        // kalau status sudah Dikembalikan → stok sudah bertambah saat status diubah
        // jadi tidak perlu tambah stok lagi

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
