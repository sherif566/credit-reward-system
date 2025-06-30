<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        Log::info('IsAdmin middleware triggered', ['user_id' => optional($user)->id, 'is_admin' => optional($user)->is_admin]);

        if (! $user || ! $user->is_admin) {
            Log::warning('Unauthorized admin access attempt', ['user_id' => optional($user)->id]);

            return response()->json(['error' => 'Access denied. Admins only.'], 403);
        }

        return $next($request);
    }
}
