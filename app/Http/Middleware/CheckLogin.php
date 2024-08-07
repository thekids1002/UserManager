<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Check if logged
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
        if (Auth::check() && Auth::user()->deleted_date == null) {
            return $next($request);
        }

        $request->session()->put('previous_url', $request->fullUrl());

        return redirect()->route('login');
    }
}
