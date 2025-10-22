<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planeta;
class PlanetaController extends Controller
{
    
public function insertarPlaneta(Request $request)
{
    $planeta = new Planeta();
    $planeta->nombre = $request->nombre;
    $planeta->periodo_rotacion = $request->periodo_rotacion;
    $planeta->poblacion = $request->poblacion;
    $planeta->clima = $request->clima;
    $planeta->save();

    return response()->json($planeta, 201);
}
}
