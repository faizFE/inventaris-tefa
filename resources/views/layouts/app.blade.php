<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris TeFa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
        }
        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background-color: #34495e;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 sidebar p-0">
            <div class="p-3 text-white fw-bold fs-5 border-bottom border-secondary">
                <i class="bi bi-box-seam"></i> Inventaris
            </div>
            <ul class="nav flex-column mt-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link px-3 py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('barang.index') }}"
                       class="nav-link px-3 py-2 {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <i class="bi bi-archive"></i> Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('peminjaman.index') }}"
                       class="nav-link px-3 py-2 {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i> Peminjaman
                    </a>
                </li>

                {{-- Khusus Admin --}}
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('peminjam.index') }}"
                       class="nav-link px-3 py-2 {{ request()->routeIs('peminjam.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Peminjam
                    </a>
                </li>
                @endif
            </ul>

            {{-- Logout --}}
            <div class="mt-auto p-3 position-absolute bottom-0 w-20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-20">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 main-content p-4">
            {{-- Topbar --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">@yield('title')</h5>
                <span class="badge bg-secondary">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                </span>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>