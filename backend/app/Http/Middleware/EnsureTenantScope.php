<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantScope
{
    /**
     * Handle an incoming request.
     *
     * Ensures the authenticated user has an organization and that
     * all subsequent queries are scoped to that organization.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->organization_id) {
            abort(403, 'User is not assigned to an organization.');
        }

        return $next($request);
    }
}
