<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // foreignId = kolom yang menghubungkan ke tabel lain
            $table->foreignId('peminjam_id')
                ->constrained('peminjam')  // merujuk ke tabel 'peminjam'
                ->onDelete('cascade');     // kalau peminjam dihapus, peminjamannya ikut terhapus

            $table->foreignId('barang_id')
                ->constrained('barang')
                ->onDelete('cascade');

            $table->date('tanggal_pinjam');  // kolom khusus tanggal (YYYY-MM-DD)
            $table->date('tanggal_kembali');
            $table->integer('jumlah_pinjam');

            // enum = kolom yang hanya boleh diisi dengan nilai tertentu
            $table->enum('status_peminjaman', ['Dipinjam', 'Dikembalikan'])
                ->default('Dipinjam');     // nilai default kalau tidak diisi

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
