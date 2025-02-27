<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    // Verificar si el usuario está bloqueado
    if (Session::get('login_attempts', 0) >= 3) {
        $lastAttemptTime = Session::get('last_attempt_time');
        $blockTime = 300; // 300 segundos = 5 minutos

        if (time() - $lastAttemptTime < $blockTime) {
            $remainingTime = $blockTime - (time() - $lastAttemptTime);
            return back()->withErrors(['email' => 'Cuenta bloqueada. Intente nuevamente en ' . $remainingTime . ' segundos.']);
        } else {
            // Reiniciar el contador si ha pasado el tiempo de bloqueo
            Session::forget('login_attempts');
            Session::forget('last_attempt_time');
        }
    }

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
        // Reiniciar el contador de intentos fallidos
        Session::forget('login_attempts');
        Session::forget('last_attempt_time');
        Session::put('user', $user);
        Session::put('rol', $user['rol']); // Almacenar el rol en la sesión
        return redirect()->route('home');
    }

    // Incrementar el contador de intentos fallidos
    $attempts = Session::get('login_attempts', 0) + 1;
    Session::put('login_attempts', $attempts);
    Session::put('last_attempt_time', time());

    return back()->withErrors(['email' => 'Las credenciales proporcionadas no son correctas. Intentos restantes: ' . (3 - $attempts)]);
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