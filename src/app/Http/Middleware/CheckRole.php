<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !$user->is_active || !$user->role) {
            abort(403, 'Unauthorized access.');
        }

        foreach ($roles as $role) {
            if (strcasecmp($user->role->name, $role) === 0) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this module.');
    }
}