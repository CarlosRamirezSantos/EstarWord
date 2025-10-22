<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaveController;
use App\Http\Controllers\PlanetaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::put('modificarNave/{id}',[NaveController::class, 'modificarNave']);
Route::post('insertarNave', [NaveController::class, 'insertarNave']);
Route::get('mostrarNave/{id}',[NaveController::class,'mostrarNave']);
Route::post('/planetas', [PlanetaController::class, 'insertarPlaneta']);
