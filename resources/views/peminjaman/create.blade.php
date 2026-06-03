@extends('layouts.app')
@section('title', 'Tambah Peminjaman')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Peminjam</label>
                <select name="peminjam_id" class="form-select" required>
                    <option value="">-- Pilih Peminjam --</option>
                    @foreach($peminjam as $p)
                        <option value="{{ $p->id }}" {{ old('peminjam_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_peminjam }} - {{ $p->kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Barang</label>
                <select name="barang_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Pinjam</label>
                <input type="number" name="jumlah_pinjam" class="form-control"
                       value="{{ old('jumlah_pinjam') }}" min="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control"
                       value="{{ old('tanggal_pinjam') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control"
                       value="{{ old('tanggal_kembali') }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection