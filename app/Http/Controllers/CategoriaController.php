<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iconos = [
            'fas fa-coffee' => 'Café',
            'fas fa-bread-slice' => 'Pan',
            'fas fa-ice-cream' => 'Helado',
            'fas fa-mug-hot' => 'Taza caliente',
            'fas fa-cookie' => 'Galleta',
            'fas fa-wine-glass' => 'Bebida'
        ];
    
        return view('admin.categorias.create', compact('iconos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'icono' => 'nullable|string|max:255',
            'activo' => 'sometimes|accepted' // Para el checkbox
        ]);
    
        // Convertir el estado del checkbox a booleano
        $validatedData['activo'] = $request->has('activo');
    
        // Crear la categoría
        Categoria::create($validatedData);
    
        // Redireccionar con mensaje de éxito
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
