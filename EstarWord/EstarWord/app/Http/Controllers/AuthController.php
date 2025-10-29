<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Debe ser un email válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();

            if ($auth->rol === 'admin') {
                $abilities = ['*'];
            } else if ($auth->rol === 'gestor') {
                $abilities = [
                    'mantenimiento:*',
                    'piloto:asignar',
                    'piloto:desasignar',
                    'listados:ver'
                ];
            } else { // usuario u otros
                $abilities = ['listados:ver'];
            }

            // Crear token (una sola vez) con abilities
            $tokenResult = $auth->createToken('Atleti', $abilities);

            // Actualizar expiración si se usa (opcional, depende de configuración)
            $hours = (int) env('SANCTUM_EXPIRATION_HOURS', 2);
            if (isset($tokenResult->accessToken)) {
                $tokenResult->accessToken->expires_at = now()->addHours($hours);
                $tokenResult->accessToken->save();
            }

            $success = [
                'id' => $auth->id,
                'name' => $auth->name,
                'rol' => $auth->rol,
                'token' => $tokenResult->plainTextToken,
                'expires_at' => isset($tokenResult->accessToken->expires_at) ? $tokenResult->accessToken->expires_at->toDateTimeString() : null
            ];

            return response()->json(["success" => true, "data" => $success, "message" => "Usuario logueado!"], 200);
        } else {
            return response()->json(["success" => false, "message" => "No autorizado"], 401);
        }
    }
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'edad' => 'required|integer|between:18,190'
        ];
        $messages = [
            'unique' => 'El :attribute ya está registrado en la base de datos.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'same' => 'El campo :attribute y :other deben coincidir.',
            'max' => 'El campo :attribute no debe exceder el tamaño máximo permitido.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'between' => 'El campo :attribute debe estar entre :min y :max años.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'required' => 'El campo :attribute es obligatorio.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        if (empty($input['rol'])) {
            $input['rol'] = 'usuario';
        }
        $user = User::create($input);

        $tokenResult = $user->createToken('LaravelSanctumAuth');
        // Actualizar expiración
        $hours = (int) env('SANCTUM_EXPIRATION_HOURS', 2);
        if (isset($tokenResult->accessToken)) {
            $tokenResult->accessToken->expires_at = now()->addHours($hours);
            $tokenResult->accessToken->save();
        }

        $success = [
            'id' => $user->id,
            'name' => $user->name,
            'rol' => $user->rol,
            'token' => $tokenResult->plainTextToken,
            'expires_at' => isset($tokenResult->accessToken->expires_at) ? $tokenResult->accessToken->expires_at->toDateTimeString() : null
        ];

        return response()->json(["success" => true, "data" => $success, "message" => "User successfully registered!"], 201);
    }

    /**
     * Por defecto los tokens de Sanctum no expiran. Se puede modificar esto añadiendo una cantidad en minutos a la variable 'expiration' en el archivo de config/sanctum.php.
     */
    public function logout(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $cantidad = Auth::user()->tokens()->delete();
            return response()->json(["success" => true, "message" => "Tokens Revoked: " . $cantidad], 200);
        } else {
            return response()->json("Unauthorised", 203);
        }

    }
}
