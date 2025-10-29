<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\Validator;

class MantenimientoCotroller extends Controller
{

    public function insertarMantenimiento(Request $request)
    {
        $input = $request->all();

        $rules = [
            'nave_id' => 'required|exists:naves,id',
            'fecha' => 'required|date',
            'descripcion' => 'required|string|max:1000',
            'coste' => 'required|numeric|min:0',
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'exists' => 'La nave indicada no existe.',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mantenimiento = Mantenimiento::create($request->all());
        return response()->json($mantenimiento, 201);
    }

    public function mostrarMantenimiento($idMantenimiento)
    {

        $mantenimiento = Mantenimiento::findOrFail($idMantenimiento);

        return response()->json($mantenimiento, 200);
    }

    public function mostrarMantenimientoEntreFechas($fecha_inicio, $fecha_fin)
    {

        $mantenimientos = Mantenimiento::whereBetween("fecha", [$fecha_inicio, $fecha_fin])->get();

        return response()->json($mantenimientos, 200);
    }
}
