<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Prevent redirecting to the "login" route
        if (! $request->expectsJson() && ! $request->is('api/*')) {
            return route('login');
        }

        return null;
    }
}
