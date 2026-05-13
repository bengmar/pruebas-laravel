<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Lógica de redirección según rol
            $user = Auth::user();

            if ($user->role_id === 1) {
                return redirect()->intended('/admin'); // Panel de Filament
            }

            return redirect()->intended('/panel-usuario'); // Tu panel personalizado
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }
    public function logout(Request $request)
    {
        // 1. Cerramos la sesión en el "Guard" de Laravel
        Auth::logout();

        // 2. Invalidamos la sesión del usuario en el servidor
        $request->session()->invalidate();

        // 3. Regeneramos el token CSRF para la siguiente visita
        $request->session()->regenerateToken();

        // 4. Redirigimos a la página principal o al login
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
