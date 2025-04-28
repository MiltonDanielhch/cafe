<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
   public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }
    public function create()
    {
        $roles = Role::all();
    return view('admin.usuarios.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create($validated);
        $user->assignRole($request->role);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }
}
