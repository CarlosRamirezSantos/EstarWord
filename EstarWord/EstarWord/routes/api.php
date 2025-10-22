<?php

use App\Http\Controllers\MantenimientoCotroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaveController;
use App\Http\Controllers\PlanetaController;
use App\Http\Controllers\PilotoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::put('modificarNave/{id}',[NaveController::class, 'modificarNave']);
Route::post('insertarNave', [NaveController::class, 'insertarNave']);
Route::get('mostrarNave/{id}',[NaveController::class,'mostrarNave']);
Route::post('planetas', [PlanetaController::class, 'insertarPlaneta']);
Route::post('asignarPilotoANave/{idNave}', [NaveController::class,'asignarPilotoANave']);
Route::post('desasignarPilotoANave/{idPiloto}/{idNave}', [NaveController::class, 'desasignarPilotoANave']);
Route::get('mostrarNavesSinPiloto', [NaveController::class,'mostrarNavesSinPiloto']);
Route::get('mostrarPilotosConNave', [PilotoController::class,'mostrarPilotosConNave']);
Route::get('mostrarPilotosConNaveActual', [PilotoController::class,'mostrarPilotosConNaveActual']);
Route::post('insertarMantemiento', [MantenimientoCotroller::class,'insertarMantemiento']);
Route::get('mostrarMantenimientoEntreFechas/{fechaI}/{fechaF}', [MantenimientoCotroller::class,'mostrarMantenimientoEntreFechas']);
