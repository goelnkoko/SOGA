<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $loginField = $request->input('username');
        $password = $request->input('password');

        $credentials = [];
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $loginField];
        } elseif (preg_match('/^[0-9]+$/', $loginField)) {
            $credentials = ['telefone' => $loginField];
        } else {
            $credentials = ['username' => $loginField];
        }

        $credentials['password'] = $password;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home'); // Redireciona para a página desejada
        }

        return back()->withErrors([
            'message' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:40',
            'email' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'password' => bcrypt($request->password), // Criptografando a senha com bcrypt
        ]);

        return redirect()->intended('login');
        // | response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], 201)
    }

    //Funcao para retornar o user logado
    public function loggedUser()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function index()
    {
        $users = User::all()->except(Auth::id());
        return response()->json($users);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20'
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect()->route('users.index')
                         ->with('success', 'Usuario atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
        ->with('success','Usuario deletado com sucesso');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
