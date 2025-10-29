<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MidGestor
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

        // gestor puede: gestionar mantenimientos (alta/baja), asociar/desasignar pilotos a naves y ver listados
        if (
            ($user->rol === 'admin' ||
            $user->rol === 'gestor') && (
            $request->user()->tokenCan('mantenimiento:create') ||
            $request->user()->tokenCan('mantenimiento:delete') ||
            $request->user()->tokenCan('piloto:asignar') ||
            $request->user()->tokenCan('piloto:desasignar') ||
            $request->user()->tokenCan('listados:ver') ||
            $request->user()->tokenCan('mantenimiento:*')) // opcional si usas wildcard
        ) {
            return $next($request);
        }

        return response()->json(['error' => 'No autorizado (gestor)'], 403);
    }
}