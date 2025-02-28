<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ChakeUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // إذا كان المستخدم غير مفعل أو ليس لديه دور الأدمن
        if ($user->hasPermissionTo('not_active') && !$user->hasRole('admin')) {
            Auth::logout();
            return redirect()->route('isActive');
        }

        return $next($request);
    }
}
