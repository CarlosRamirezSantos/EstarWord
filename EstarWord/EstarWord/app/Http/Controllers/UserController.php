<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'nullable|in:admin,gestor,usuario'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only(['name','email','rol']);
        $data['password'] = bcrypt($request->password);
        $data['rol'] = $data['rol'] ?? 'usuario';

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6',
            'rol' => 'sometimes|in:admin,gestor,usuario'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->rol = $request->rol;

        $user->save();

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    // Método para que un admin cambie el rol de un usuario
    public function setRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rol' => 'required|in:admin,gestor,usuario'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::findOrFail($id);
        $user->rol = $request->rol;
        $user->save();

        return response()->json(['message' => 'Rol actualizado', 'user' => $user], 200);
    }
}