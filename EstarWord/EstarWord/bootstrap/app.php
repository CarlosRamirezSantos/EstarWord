<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/api/nologin');
        
        $middleware->alias([ 
        'mid.admin' => \App\Http\Middleware\MidAdmin::class,
        'mid.mantenimientoCrear'=> \App\Http\Middleware\MidMantenimientoCrear::class,
        'mid.mantenimientoBorrar'=> \App\Http\Middleware\MidMantenimientoBorrar::class,
        'mid.pilotoDesasignar'=> \App\Http\Middleware\MidPilotoDesasignar::class,
        'mid.pilotoAsignar'=> \App\Http\Middleware\MidPilotoAsignar::class,
        'mid.pilotoMostrar'=> \App\Http\Middleware\MidPilotoMostrar::class,
        'mid.naveMostrar'=> \App\Http\Middleware\MidNaveMostrar::class,
        'mid.planetasMostrar'=> \App\Http\Middleware\MidPlanetaMostrar::class,
        'mid.mantenimientoMostrar'=> \App\Http\Middleware\MidMantenimientoMostrar::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
