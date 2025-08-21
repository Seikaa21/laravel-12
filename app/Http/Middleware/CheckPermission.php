<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (Auth::check() && Auth::user()->$permission) {
            return $next($request);
        }

        abort(403, 'Anda tidak punya izin untuk mengakses halaman ini.');
    }
}
