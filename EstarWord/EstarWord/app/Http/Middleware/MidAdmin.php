<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MidAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = $request->user();
        if (!$usuario) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

        // comprobar rol o ability
        if ($usuario && $request->user()->tokenCan('*')) {
            return $next($request);
        }

        return response()->json(['error' => 'No autorizado (admin)'], 403);
    }
}