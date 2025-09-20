<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Set the flash message in the session
        if (!$request->expectsJson()) {
            session()->flash('auth_error', 'Anda perlu login untuk mengakses URL atau halaman ini.');

        }

        return route('login');
    }
}
