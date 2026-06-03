@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h6 class="fw-bold mb-0">Daftar Peminjaman</h6>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Tambah Peminjaman
            </a>
        </div>
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->peminjam->nama_peminjam }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->jumlah_pinjam }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $badge = match($item->status_peminjaman) {
                                'Dipinjam'    => 'bg-warning text-dark',
                                'Dikembalikan'=> 'bg-success',
                                'Terlambat'   => 'bg-danger',
                                default       => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $item->status_peminjaman }}</span>
                    </td>
                    <td>
                        <a href="{{ route('peminjaman.show', $item) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('peminjaman.edit', $item) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('peminjaman.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus peminjaman ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $peminjaman->links() }}
    </div>
</div>
@endsection