<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
         * auth()->check() untuk mengecek apakah sudah login atau belum. Jika belum login, maka false
         * auth()->guest() untuk mengecek apakah user belum login. Jika belum login, maka return true
         * auth()->user() untuk mengembalikan data user yang sedang login
         * abort 403 artinya forbiden
         */
        if (!auth()->check() || auth()->user()->is_admin == false)
        {
            abort(403);
        }
        return $next($request);
    }
}
