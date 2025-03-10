<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;

class AdminOrStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(Auth::user()->role->value, [UserRole::ADMIN->value, UserRole::STUDENT->value])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes permiso para acceder.');
    }
}
