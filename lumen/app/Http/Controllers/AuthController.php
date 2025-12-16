<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Registrar usuário
     */

    public function register(Request $request)
    {
        $this->validate($request , [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create($request->only([
            'name',
            'email',
            'password'
        ]));

        return response()->json([
            'message' => 'Usuário registrado com sucesso',
            'user' => $user
        ], 201);
    }

    /**
     * Login do usuário
     */

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'type' => 'bearer',
            'user' => auth()->user()
        ]);
    }

    /**
     * Usuário autenticado
     */

    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Logout do usuário
     */

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
?>
