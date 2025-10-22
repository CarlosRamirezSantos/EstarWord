<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;

class MantenimientoCotroller extends Controller
{
    
    public function insertarMantenimiento (Request $request) {
        
        $mantenimiento = new Mantenimiento($request->all());

        $mantenimiento->save();

        return response()->json($mantenimiento, 201);
    }

    public function mostrarMantenimiento ($idMantenimiento) {

        $mantenimiento = Mantenimiento::findOrFail($idMantenimiento);

        return response()->json($mantenimiento,200);
    }

    public function mostrarMantenimientoEntreFechas ($fecha_inicio, $fecha_fin) {

        $mantenimientos = Mantenimiento::whereBetween("fecha", [$fecha_inicio, $fecha_fin])->get();

        return response()->json($mantenimientos,200);
    }
}
