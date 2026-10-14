<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     * Hanya user dengan role 'admin' yang diizinkan melewati middleware ini.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== 'admin') {
            abort(403, 'Halaman ini hanya bisa diakses oleh admin.');
        }

        return $next($request);
    }
}
