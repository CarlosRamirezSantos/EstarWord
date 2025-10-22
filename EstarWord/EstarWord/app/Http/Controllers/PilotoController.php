<?php

namespace App\Http\Controllers;
use App\Models\Piloto;
use App\Models\Nave;

use Illuminate\Http\Request;

class PilotoController extends Controller
{
    public function mostrarPilotosConNave(){

    $pilotoConNave = Piloto::has('naves')->get();
    return response()->json($pilotoConNave);

    }


  public function mostrarPilotosConNaveActual()
{
    $pilotoConNave = Piloto::whereHas('naves', function ($query) {
        $query->whereNull('piloto_nave.fecha_fin');
    })->with(['naves' => function ($query) {
        $query->whereNull('piloto_nave.fecha_fin');
    }])->get();

    return response()->json($pilotoConNave);
}

}


