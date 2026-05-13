<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SweetAlert2\Laravel\Swal;

class SignUpController extends Controller
{
    public function create(){
        return view('auth.signup');
    }
    public function store(SignUpRequest $request){

        $validated = $request->validated();
        User::create($validated);
        Swal::success([
            'title' => '!Hecho!',
            'text' => '¡La cuenta ha sido creada'
        ]);
        return redirect()->back()->with('success', 'Se ha creado la cuenta de usuario exitosamente');
    }
}
