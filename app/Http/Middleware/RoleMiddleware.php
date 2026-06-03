<?php

namespace App\Http\Middleware;

// import yang dibutuhkan
use Closure;                                          // representasi dari "request berikutnya"
use Illuminate\Http\Request;                          // data request dari user
use Symfony\Component\HttpFoundation\Response;        // tipe return dari method handle
use Illuminate\Support\Facades\Auth;                  // untuk cek status login & ambil data user
use App\Models\User;                                  // untuk bantu IDE kenali tipe $user

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    // $request      = data request yang masuk (url, method, input, dll)
    // $next         = "pintu" ke halaman yang dituju, kalau lolos middleware
    // string ...$roles = role yang diizinkan, bisa lebih dari satu
    //   contoh: 'role:admin'          → $roles = ['admin']
    //   contoh: 'role:admin,petugas'  → $roles = ['admin', 'petugas']
    // '...' artinya parameter ini bisa menerima banyak nilai sekaligus
    {
        // CEK 1: apakah user sudah login?
        if (!Auth::check()) {
            // Auth::check() = return true kalau sudah login, false kalau belum
            // ! = kebalikannya, jadi "kalau BELUM login"
            return redirect()->route('login');
            // belum login → paksa ke halaman login
        }

        /** @var User $user */
        $user = Auth::user();
        // ambil data user yang sedang login
        // @var User $user = komentar khusus untuk IDE supaya tau $user itu tipe User
        //                   tidak mempengaruhi jalannya program

        // CEK 2: apakah role user termasuk yang diizinkan?
        if (!in_array($user->role, $roles)) {
            // in_array($user->role, $roles) = cek apakah role user ada di dalam array $roles
            // contoh: $user->role = 'petugas', $roles = ['admin']
            //         in_array('petugas', ['admin']) = false
            //         !false = true → masuk if → abort 403
            abort(403, 'Akses Ditolak');
            // 403 = kode HTTP "Forbidden" (tidak punya izin akses)
        }

        return $next($request);
        // lolos semua pengecekan → lanjutkan ke halaman yang dituju
    }
}