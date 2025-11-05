<?php

namespace App\Http\Controllers;
use App\Models\Piloto;
use App\Models\Nave;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PilotoController extends Controller
{

    public function insertarPiloto(Request $request){

        $input = $request->all();

       $rules = [
            'nombre' => 'required|string|max:255',
        
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $input['profile_photo'] = asset('images/piloto_predeterminado.png');

        $piloto = Piloto::create($input);
        return response()->json($piloto, 201);
    }


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

public function subirImagenCloud(Request $request, $idPiloto){

    
        $piloto = Piloto::findOrFail($idPiloto);

        $messages = [
        'image.required' => 'Falta el archivo',
        'image.mimes' => 'Tipo no soportado',
        'image.max' => 'El archivo excede el tamaño máximo permitido',
        ];

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $file = $request->file('image');

            // Generamos un nombre único para la imagen
            // Obtenemos nombre y extensión por separado
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Generamos nombre único y seguro
            $filename = uniqid('piloto_') . '_' . Str::slug($originalName) . '.' . $extension;

            // Subimos el archivo usando el disco "cloudinary"
            $uploadedFilePath = Storage::disk('cloudinary')->putFileAs('laravel', $file, $filename);

            // Obtenemos la URL pública
            $url = Storage::disk('cloudinary')->url($uploadedFilePath);

            $piloto->profile_photo = $url;
            $piloto->save();

            return response()->json(['url' => $url], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al subir la imagen: ' . $e->getMessage()], 500);
        }
        }

        return response()->json(['error' => 'No se recibió ningún archivo.'], 400);
    }


    public function destroy($id)
    {
        $piloto = Piloto::findOrFail($id);
        $piloto->delete();
        return response()->json(null, 204);
    }

}


