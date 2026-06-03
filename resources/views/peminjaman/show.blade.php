@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="card border-0 shadow-sm" style="max-width: 500px;">
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th>Peminjam</th><td>{{ $peminjaman->peminjam->nama_peminjam }}</td></tr>
            <tr><th>Kelas</th><td>{{ $peminjaman->peminjam->kelas }}</td></tr>
            <tr><th>Barang</th><td>{{ $peminjaman->barang->nama_barang }}</td></tr>
            <tr><th>Jumlah</th><td>{{ $peminjaman->jumlah_pinjam }}</td></tr>
            <tr><th>Tgl Pinjam</th><td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td></tr>
            <tr><th>Tgl Kembali</th><td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}</td></tr>
            <tr><th>Status</th><td>{{ $peminjaman->status_peminjaman }}</td></tr>
        </table>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection