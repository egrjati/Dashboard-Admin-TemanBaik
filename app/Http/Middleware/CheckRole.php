<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // BAGIAN 1: Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // BAGIAN 2: Ambil role user yang sedang login
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userRole = $user->role;

        // BAGIAN 3: Cek apakah role-nya ada di daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // BAGIAN 4: Lolos semua pengecekan, teruskan ke Controller
        return $next($request);
    }
}
