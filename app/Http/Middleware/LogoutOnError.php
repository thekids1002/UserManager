<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutOnError
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response && $response->getStatusCode() === Response::HTTP_NOT_FOUND && auth()->check()) {
            auth()->logout();

           return redirect()->route("error");
        }

        return $response;
    }
}
