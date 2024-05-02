<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // public function handle($request, Closure $next, ...$guards)
    // {
    //     // Jika pengguna terotentikasi, tambahkan informasi pengguna ke dalam objek request
    //     if (Auth::check()) {
    //         Log::info('User authenticated: ' . Auth::user());
    //     }

    //     return $next($request);
    // }
}
