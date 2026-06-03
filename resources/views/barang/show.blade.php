@extends('layouts.app')
@section('title', 'Detail Barang')

@section('content')
    <div class="card border-0 shadow-sm" style="max-width: 500px;">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->nama_barang }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $barang->kategori_barang }}</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>{{ $barang->stok }}</td>
                </tr>
                <tr>
                    <th>Kondisi</th>
                    <td>{{ $barang->kondisi_barang }}</td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td>
                        @if ($barang->foto)
                            <img src="{{ asset('img/barang/' . $barang->foto) }}" width="150" class="rounded border">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
