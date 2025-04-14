<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
    
        if ($user->role !== $role) { // Pastikan kolom dan nilai sesuai
            return response()->json([
                'message' => 'Unauthorized: Invalid role',
            ], 403);
        }
    
        return $next($request);
    }
}
