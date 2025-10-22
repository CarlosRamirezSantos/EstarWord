<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nave;

class NaveController extends Controller
{
    public function insertarNave(Request $request)
    {
        
        $nave = new Nave();
        $nave->nombre = $request->nombre;
        $nave->modelo = $request->modelo;
        $nave->tripulacion = $request->tripulacion;
        $nave->pasajeros = $request->pasajeros;
        $nave->clase_nave = $request->clase_nave;
        $nave->planeta_id = $request->planeta_id;
        $nave->save();

        return response()->json($nave, 201);
    }

    public function mostrarNave($id)
    {
        $nave = Nave::with(['planeta', 'pilotos', 'mantenimientos'])->findOrFail($id);
        return response()->json($nave);
    }

    public function modificarNave(Request $request, $id)
    {
        $nave = Nave::findOrFail($id);

        
        if ($request->has('nombre')) $nave->nombre = $request->nombre;
        if ($request->has('modelo')) $nave->modelo = $request->modelo;
        if ($request->has('tripulacion')) $nave->tripulacion = $request->tripulacion;
        if ($request->has('pasajeros')) $nave->pasajeros = $request->pasajeros;
        if ($request->has('clase_nave')) $nave->clase_nave = $request->clase_nave;
        if ($request->has('planeta_id')) $nave->planeta_id = $request->planeta_id;

        $nave->save();

        return response()->json($nave);
    }

    public function destroy($id)
    {
        $nave = Nave::findOrFail($id);
        $nave->delete();
        return response()->json(null, 204);
    }
    
}
