<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            abort(Response::HTTP_FORBIDDEN, 'You must be logged in.');
        }

        if (! $request->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN, 'Only admin users can view this page.');
        }

        return $next($request);
    }
}
