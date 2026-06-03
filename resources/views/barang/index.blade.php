@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-bold mb-0">Daftar Barang</h6>
                <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Barang
                </a>
            </div>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->foto)
                                    <img src="{{ asset('img/barang/' . $item->foto) }}" width="50" height="50"
                                        class="rounded" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori_barang }}</td>
                            <td>
                                <span class="badge {{ $item->stok <= 3 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>{{ $item->kondisi_barang }}</td>
                            <td>
                                <a href="{{ route('barang.show', $item) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('barang.edit', $item) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $barang->links() }}
        </div>
    </div>
@endsection
