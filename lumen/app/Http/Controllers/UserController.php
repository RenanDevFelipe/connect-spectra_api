<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
{
    /**
     * Listar todos os usuários
     */

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Mostrar detalhes de um usuário específico
     */

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Atualizar informações de um usuário
     */

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            'user' => $user
        ]);

    }

    /**
     * Deletar um usuário
     */

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso'
        ]);
    }
}

?>
