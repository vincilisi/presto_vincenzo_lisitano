<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsRevisor
{
    /**
     * Gestisce la richiesta in entrata e verifica se l'utente è un revisore.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_revisor) {
            return $next($request);
        }

        return redirect()->route('homepage')
                         ->with('errorMessage', 'Zona riservata ai revisori.');
    }
}
