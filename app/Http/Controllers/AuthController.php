<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function home()
    {
        if (!Session::has('user')) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión.']);
        }

        $user = Session::get('user');
        return view('auth.home', compact('user'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    // Verifica que los datos se estén enviando correctamente
    $credentials = $request->only('nombre', 'email', 'password');

    $response = Http::get('http://localhost:3000/usuarios');
    if ($response->failed()) {
        return back()->withErrors(['email' => 'Error al conectarse con el servidor.']);
    }

    $users = $response->json();

    // Buscar el usuario en la API
    $user = collect($users)->first(function ($user) use ($credentials) {
        return strtolower(trim($user['nombre'])) === strtolower(trim($credentials['nombre'])) &&
               strtolower(trim($user['email'])) === strtolower(trim($credentials['email'])) &&
               trim($user['password']) === trim($credentials['password']);
    });

    if ($user) {
        Session::put('user', $user);
        return redirect()->route('home');
    }

    return back()->withErrors(['email' => 'Las credenciales proporcionadas no son correctas.']);
}

public function showRegisterForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $credentials = $request->only('nombre', 'email', 'password');

    // Asegúrate de que el rol sea 'tecnico'
    $credentials['rol'] = 'tecnico';

    // Enviar los datos a la API para crear el usuario
    $response = Http::post('http://localhost:3000/usuarios', $credentials);

    if ($response->successful()) {
        return redirect()->route('login')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    } else {
        return back()->withErrors(['error' => 'Error al registrar el usuario.']);
    }
}
    public function logout(Request $request)
    {
        Session::forget('user');
        return redirect()->route('login');
    }
}
