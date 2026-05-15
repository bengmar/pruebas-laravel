<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SweetAlert2\Laravel\Swal;

class SignUpController extends Controller
{
    public function create()
    {
        return view('auth.signup');
    }
    public function store(SignUpRequest $request)
    {

        $validated = $request->validated();

        // Aseguramos que el role_id sea 2 y la contraseña esté encriptada
        User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']), // encriptado
            'role_id'    => 2, // Siempre el usuario creado por formulario es cliente
        ]);

        // Creando el usuario
        User::create($validated);
        Swal::success([
            'title' => '!Hecho!',
            'text' => '¡La cuenta ha sido creada'
        ]);
        return redirect()->back()->with('success', 'Se ha creado la cuenta de usuario exitosamente');
    }
}
