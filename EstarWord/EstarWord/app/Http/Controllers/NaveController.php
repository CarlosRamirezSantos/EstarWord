<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nave;
use App\Models\Piloto;

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

        $nave->nombre = $request->nombre;
        $nave->modelo = $request->modelo;
        $nave->tripulacion = $request->tripulacion;
        $nave->pasajeros = $request->pasajeros;
        $nave->clase_nave = $request->clase_nave;
        $nave->planeta_id = $request->planeta_id;

        $nave->save();

        return response()->json($nave);
    }

    public function destroy($id)
    {
        $nave = Nave::findOrFail($id);
        $nave->delete();
        return response()->json(null, 204);
    }

    public function asignarPilotoANave(Request $request, $idNave)
    {

        $idPiloto = $request->id;
        $nave = Nave::find($idNave);
        $piloto = Piloto::find($idPiloto);

        if (!$nave || !$piloto) {
            return response()->json(['error' => 'Nave o Piloto no encontrado'], 404);
        }

        $existe = $nave->pilotos()
            ->where('piloto_id', $idPiloto)
            ->whereNull('fecha_fin')
            ->first();

        if ($existe) {
            return response()->json(['error' => 'Piloto ya asignado a esta nave'], 400);
        }

        $nave->pilotos()->attach($idPiloto, ['fecha_inicio' => now(), 'fecha_fin' => null]);

        return response()->json(['mensaje' => 'Piloto asignado correctamente']);
    }


    public function desasignarPilotoANave($idPiloto, $idNave)
    {
        $nave = Nave::find($idNave);
        $piloto = Piloto::find($idPiloto);

        if (!$nave || !$piloto) {
            return response()->json(['error' => 'Nave o Piloto no encontrado'], 404);
        }

        $existe = $nave->pilotos()
            ->where('piloto_id', $idPiloto)
            ->whereNull('fecha_fin')
            ->first();

        if (!$existe) {
            return response()->json(['error' => 'No existe piloto asignado para esa nave'], 400);
        }

        $nave->pilotos()->updateExistingPivot($idPiloto, ['fecha_fin' => now()]);

        return response()->json(['mensaje' => 'Piloto desasignado correctamente']);
    }

    public function mostrarNavesSinPiloto()
    {

    $naves = Nave::all();
    $navesSinPiloto = [];

    foreach ($naves as $nave) {
        if (!$nave->pilotos()->exists()) {
            $navesSinPiloto[] = $nave;
        }
    }

    return response()->json($navesSinPiloto);

   // $navesSinPiloto = Nave::doesntHave('pilotos')->get();
    // return response()->json($navesSinPiloto);

}



}