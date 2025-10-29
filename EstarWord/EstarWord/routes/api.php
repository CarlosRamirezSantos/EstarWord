<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MantenimientoCotroller;
use App\Http\Controllers\NaveController;
use App\Http\Controllers\PlanetaController;
use App\Http\Controllers\PilotoController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas públicas
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('/nologin', function () {
    return response()->json(["success" => false, "message" => "Unauthorised"], 203);
});

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {

    // Logout (revoca el token actual)
    Route::post('logout', [AuthController::class, 'logout']);

    // Rutas solo para admin
    Route::middleware('mid.admin')->group(function () {
        Route::get('usuarios', [UserController::class, 'index']);
        Route::post('usuarios', [UserController::class, 'store']);
        Route::put('usuarios/{id}', [UserController::class, 'update']);
        Route::delete('usuarios/{id}', [UserController::class, 'destroy']);
        Route::post('usuarios/{id}/role', [UserController::class, 'setRole']);
    });

    // Rutas para admin + gestor (acciones de mantenimiento y asignación de pilotos)
    Route::middleware('mid.gestor')->group(function () {
        Route::post('insertarMantenimiento', [MantenimientoCotroller::class, 'insertarMantenimiento']);
        Route::delete('eliminarMantenimiento/{id}', [MantenimientoCotroller::class, 'destroy']);
        Route::get('mostrarMantenimientoEntreFechas/{fechaI}/{fechaF}', [MantenimientoCotroller::class, 'mostrarMantenimientoEntreFechas']);
        Route::post('asignarPilotoANave/{idNave}', [NaveController::class, 'asignarPilotoANave']);
        Route::post('desasignarPilotoANave/{idPiloto}/{idNave}', [NaveController::class, 'desasignarPilotoANave']);
    });

    // Rutas accesibles para cualquier usuario autenticado
    Route::put('modificarNave/{id}', [NaveController::class, 'modificarNave']);
    Route::post('insertarNave', [NaveController::class, 'insertarNave']);
    Route::get('mostrarNave/{id}', [NaveController::class, 'mostrarNave']);
    Route::post('planetas', [PlanetaController::class, 'insertarPlaneta']);
    Route::get('mostrarNavesSinPiloto', [NaveController::class, 'mostrarNavesSinPiloto']);
    Route::get('mostrarPilotosConNave', [PilotoController::class, 'mostrarPilotosConNave']);
    Route::get('mostrarPilotosConNaveActual', [PilotoController::class, 'mostrarPilotosConNaveActual']);
});