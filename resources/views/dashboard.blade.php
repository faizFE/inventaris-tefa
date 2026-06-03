@extends('layouts.app')
@section('title', 'Dashboard')
<?php
use App\Models\Barang;
use App\Models\Peminjam;
use App\Models\Peminjaman;
?>
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded p-3 fs-4">
                    <i class="bi bi-archive"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Barang</div>
                    <div class="fs-4 fw-bold">{{Barang::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning text-white rounded p-3 fs-4">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Peminjaman</div>
                    <div class="fs-4 fw-bold">{{Peminjaman::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->role === 'admin')
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success text-white rounded p-3 fs-4">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Peminjam</div>
                    <div class="fs-4 fw-bold">{{Peminjam::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection