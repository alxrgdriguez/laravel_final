<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOrTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(Auth::user()->role, [UserRole::ADMIN, UserRole::TEACHER])) {
            return $next($request);
        }

        // Redirige con un mensaje de error SIN el código 403 aquí
        return redirect('/')->with('error', 'No tienes permiso para acceder.');
    }
}
