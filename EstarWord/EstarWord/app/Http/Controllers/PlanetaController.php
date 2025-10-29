<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planeta;
use Illuminate\Support\Facades\Validator;
class PlanetaController extends Controller
{

    public function insertarPlaneta(Request $request)
    {
        $input = $request->all();
        $rules = [
            'nombre' => 'required|string|max:255',
            'periodo_rotacion' => 'nullable|string|max:100',
            'poblacion' => 'nullable|integer|min:0',
            'clima' => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'min' => 'El campo :attribute debe ser al menos :min.',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $planeta = Planeta::create($request->all());

        return response()->json($planeta, 201);
    }


}
