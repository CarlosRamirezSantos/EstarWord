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
// Logout (revoca todos los tokens)
Route::post('logout', [AuthController::class, 'logout']);
Route::get('/nologin', function () {
    return response()->json(["success" => false, "message" => "Unauthorised"], 203);
});

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    

    // Rutas solo para admin
    Route::middleware('mid.admin')->group(function () {
        Route::get('usuarios', [UserController::class, 'index']);
        Route::post('usuarios', [UserController::class, 'store']);
        Route::put('usuarios/{id}', [UserController::class, 'update']);
        Route::delete('usuarios/{id}', [UserController::class, 'destroy']);
        Route::post('usuarios/{id}/role', [UserController::class, 'setRole']);
        Route::put('modificarNave/{id}', [NaveController::class, 'modificarNave']);
        Route::post('insertarNave', [NaveController::class, 'insertarNave']);
        Route::post('insertarPiloto',[PilotoController::class, 'insertarPiloto']);
        Route::post('/subircloud/{idPiloto}', [PilotoController::class,'subirImagenCloud']);
    });

    // Rutas para admin + gestor (acciones de mantenimiento y asignación de pilotos)
        Route::post('insertarMantenimiento', [MantenimientoCotroller::class, 'insertarMantenimiento'])->middleware('mid.mantenimientoCrear');
        Route::delete('eliminarMantenimiento/{id}', [MantenimientoCotroller::class, 'destroy'])->middleware('mid.mantenimientoBorrar');
        Route::post('asignarPilotoANave/{idNave}', [NaveController::class, 'asignarPilotoANave'])->middleware('mid.pilotoAsignar');
        Route::post('desasignarPilotoANave/{idPiloto}/{idNave}', [NaveController::class, 'desasignarPilotoANave'])->middleware('mid.pilotoDesasignar');

    // Rutas accesibles para cualquier usuario autenticado
        Route::get('mostrarMantenimientoEntreFechas/{fechaI}/{fechaF}', [MantenimientoCotroller::class, 'mostrarMantenimientoEntreFechas'])->middleware('mid.mantenimientoMostrar');
        Route::get('mostrarNave/{id}', [NaveController::class, 'mostrarNave'])->middleware('mid.naveMostrar');
        Route::post('planetas', [PlanetaController::class, 'mostrarPlanetas'])->middleware('mid.planetasMostrar');
        Route::get('mostrarNavesSinPiloto', [NaveController::class, 'mostrarNavesSinPiloto'])->middleware('mid.naveMostrar');
        Route::get('mostrarPilotosConNave', [PilotoController::class, 'mostrarPilotosConNave'])->middleware('mid.pilotoMostrar');
        Route::get('mostrarPilotosConNaveActual', [PilotoController::class, 'mostrarPilotosConNaveActual'])->middleware('mid.pilotoMostrar');
});