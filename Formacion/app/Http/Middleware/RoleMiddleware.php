<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role->value, explode('|', $role))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
