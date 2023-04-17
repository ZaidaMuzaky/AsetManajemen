<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->tipe_user == $role) {
            return $next($request);
        }
        // abort(403, 'Anda tidak memiliki hak mengakses laman tersebut!');
        alert('Anda tidak memiliki hak untuk mengakses laman tersebut!')->background('#df6464');
        return redirect()->to(route('dashboard'));
    }
}
