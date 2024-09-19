<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!check_permission($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
