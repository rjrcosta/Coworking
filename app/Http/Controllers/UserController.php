<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //criado e editado by jose lindo sousa
    //21/10/2024

    public function create()
    {
        // Supondo que você tenha uma lista de papéis disponíveis
        $role = ['admin', 'user ']; // Você pode substituir por dados do banco de dados

        // Retorna a view de criação de usuário com os papéis
        return view('users.create', compact('role'));
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string', // Validação do papel
        ]);

        // Criação do novo usuário
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Criptografa a senha
        $user->role = $request->role; // Atribui o papel ao usuário
        $user->save();

        // Redireciona para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Usuário criado com sucesso!');
    }
    //
    public function show($id)
    {
        // Obter o usuário pelo ID
        $user = User::findOrFail($id);

        // Retornar a view com os dados do usuário
        return view('users.show', compact('user'));
    }

    // Método para listar os usuários
    public function index()
    {

        // Obtém todos os usuários do banco de dados

        $users = User::paginate(10); // Você pode ajustar o número de itens por página conforme necessário

        // Retorna a view com os usuários
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        // Busca o usuário pelo ID
        $user = User::findOrFail($id);

        // Retorna a view com o usuário
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            // Adicione outras validações conforme necessário
        ]);

        // Busca o usuário pelo ID
        $user = User::findOrFail($id);

        // Atualiza os dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;

        // Atualize outros campos conforme necessário
        $user->save();

        // Redireciona para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuário eliminado com sucesso!');
        }
        return redirect()->route('users.index')->with('error', 'Usuário não encontrado.');
    }
}
