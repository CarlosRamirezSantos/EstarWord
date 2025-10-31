<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planeta;
use Illuminate\Support\Facades\Validator;
class PlanetaController extends Controller
{

   public function mostrarPlanetas()
    {
        $planetas = Planeta::all();

        return response()->json([
            "success" => true,
            "data" => $planetas,
            "message" => "Lista de planetas recuperada con éxito"
        ], 200);
    }

}
