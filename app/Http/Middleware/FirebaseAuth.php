<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirebaseAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Create a user object dari session data untuk diakses via $request->user()
        $user = new \stdClass();
        $user->id = session('user_id');
        $user->email = session('email');
        $user->name = session('name');

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
