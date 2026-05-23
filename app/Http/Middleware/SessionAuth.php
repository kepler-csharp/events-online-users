<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('user') || !session('auth_token')) {
            return redirect('login')
                ->withErrors([
                    'error' => 'Debes iniciar sesión.'
                ]);
        }
        return $next($request);
    }
}
