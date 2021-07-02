<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if ($user->level != $role) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ["Forbidden! Please check account again, Or contact administrator!"]
            ]);
        }

        return $next($request);
    }
}
