<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 1. Si es Admin, permitimos que 'intended' lo lleve a donde quería (ej. Filament)
            if ($user->role_id === 1) {
                return redirect()->intended('/admin');
            }

            // 2. Si es Cliente, forzamos la ruta y LIMPIAMOS la intención previa
            if ($user->role_id === 2) {
                $request->session()->forget('url.intended'); // <--- Esto evita el error 403
                return redirect('/panel-usuario');
            }

            // 3. Fallback para otros casos
            return redirect('/');
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
