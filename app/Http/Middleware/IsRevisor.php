<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsRevisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->is_revisor)
        {
            return $next($request);
        }
        return redirect()->route('homepage')->with('errorMessage', 'Zona Riservata ai revisori');
        // Optionally, you can redirect or abort if the user is not a revisor
        abort(403, 'Unauthorized');
    }
}
