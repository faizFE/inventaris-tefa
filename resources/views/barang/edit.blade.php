@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('barang.update', $barang) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control"
                        value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori_barang" class="form-control"
                        value="{{ old('kategori_barang', $barang->kategori_barang) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $barang->stok) }}"
                        min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kondisi Barang</label>
                    <select name="kondisi_barang" class="form-select" required>
                        <option value="">-- Pilih Kondisi --</option>
                        @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $kondisi)
                            <option value="{{ $kondisi }}"
                                {{ old('kondisi_barang', $barang->kondisi_barang) == $kondisi ? 'selected' : '' }}>
                                {{ $kondisi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Barang</label>

                    {{-- tampilkan foto lama kalau ada --}}
                    @if ($barang->foto)
                        <div class="mb-2">
                           <img src="{{ asset('img/barang/' . $barang->foto) }}" width="100" class="rounded border">
                            <small class="text-muted d-block">Foto saat ini</small>
                        </div>
                    @endif

                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
