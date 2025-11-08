<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        $user = auth('admin')->user();
        
        if (!$user || ($user->role !== 'admin' && $user->role !== 'super_admin')) {
            return redirect('/admin/login')->withErrors(['error' => 'Você precisa fazer login como administrador.']);
        }

        return $next($request);
    }
}
