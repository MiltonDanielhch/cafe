<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $productos = Producto::with('categoria')->get();
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('admin.productos.create', compact('categorias'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'disponible' => 'sometimes|accepted',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $validated['disponible'] = $request->has('disponible');
    
        if($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $path;
        }
    
        Producto::create($validated);
    
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
