@extends('layouts.app')
@section('title', 'Data Peminjam')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Daftar Peminjam</h6>
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>No. HP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjam as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->jurusan }}</td>
                    <td>{{ $item->no_hp }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data peminjam.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $peminjam->links() }}
    </div>
</div>
@endsection