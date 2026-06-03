<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // dijalankan saat migrate → BUAT tabel
    {
        Schema::create('peminjam', function (Blueprint $table) {
            $table->id();                    // kolom 'id' auto increment (1, 2, 3, ...)
            $table->string('nama_peminjam'); // kolom teks, VARCHAR(255)
            $table->string('kelas');         // kolom teks
            $table->string('jurusan');       // kolom teks
            $table->string('no_hp');         // kolom teks
            $table->timestamps();            // otomatis buat kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // dijalankan saat rollback → HAPUS tabel
    {
        Schema::dropIfExists('peminjam');
    }
};
