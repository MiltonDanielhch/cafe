<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clientes.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'nit_codigo' => [
                'required',
                'string',
                'max:20',
                'unique:clientes,nit_codigo'
            ],
            'telefono' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9+\-\(\) ]+$/'
            ],
        ]);

        // Creación del cliente
        $cliente = Cliente::create([
            'nombre_cliente' => $request->nombre_cliente,
            'nit_codigo' => $request->nit_codigo,
            'telefono' => $request->telefono,
        ]);

        // Redirección con mensaje de éxito
        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
