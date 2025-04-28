<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = Orden::all();
        return view('admin.ordenes.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener productos disponibles con stock
        $productos = Producto::where('disponible', true)
            ->where('stock', '>', 0)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio', 'stock']);

        // Obtener clientes (usuarios con rol cliente)
        $clientes = User::whereHas('roles', function($query) {
                $query->where('name', 'cliente');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        // Validar datos requeridos
        if($productos->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay productos disponibles para crear órdenes');
        }

        if($clientes->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay clientes registrados');
        }

        return view('admin.ordenes.create', [
            'productos' => $productos,
            'clientes' => $clientes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'cliente_id' => 'required|exists:users,id',
    //         'productos' => 'required|array|min:1',
    //         'productos.*.id' => 'required|exists:productos,id',
    //         'productos.*.cantidad' => 'required|integer|min:1',
    //         'productos.*.instrucciones' => 'nullable|string|max:255',
    //         'notas' => 'nullable|string|max:500'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $orden = Orden::create([
    //             'user_id' => $validated['cliente_id'],
    //             'total' => 0,
    //             'estado' => 'pendiente',
    //             'notas' => $validated['notas'] ?? null
    //         ]);

    //         $total = 0;

    //         foreach ($validated['productos'] as $producto) {
    //             $productoModel = Producto::findOrFail($producto['id']);
                
    //             if ($productoModel->stock < $producto['cantidad']) {
    //                 throw new \Exception("Stock insuficiente para {$productoModel->nombre}");
    //             }

    //             $orden->productos()->attach($productoModel->id, [
    //                 'cantidad' => $producto['cantidad'],
    //                 'precio_unitario' => $productoModel->precio,
    //                 'instrucciones' => $producto['instrucciones'] ?? null
    //             ]);

    //             $total += $productoModel->precio * $producto['cantidad'];

    //             // Decrementar stock
    //             $productoModel->decrement('stock', $producto['cantidad']);

    //             // Si después de descontar, el stock es 0, marcar como no disponible
    //             if ($productoModel->stock <= 0) {
    //                 $productoModel->disponible = false;
    //                 $productoModel->save();
    //             }
    //         }

    //         $orden->update(['total' => $total]);

    //         DB::commit();

    //         return redirect()->route('ordenes.index')
    //             ->with('success', 'Orden creada exitosamente');
            
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withInput()
    //             ->with('error', 'Error al crear la orden: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:users,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.instrucciones' => 'nullable|string|max:255',
            'notas' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $orden = Orden::create([
                'user_id' => $validated['cliente_id'],
                'total' => 0,
                'estado' => 'pendiente',
                'notas' => $validated['notas'] ?? null
            ]);

            $total = 0;

            foreach ($validated['productos'] as $producto) {
                $productoModel = Producto::lockForUpdate()->findOrFail($producto['id']); 
                // 🔒 Bloqueamos para evitar race conditions

                if ($productoModel->stock < $producto['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$productoModel->nombre}");
                }

                $orden->productos()->attach($productoModel->id, [
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $productoModel->precio,
                    'instrucciones' => $producto['instrucciones'] ?? null
                ]);

                $total += $productoModel->precio * $producto['cantidad'];

                $productoModel->decrement('stock', $producto['cantidad']);
            }

            $orden->update(['total' => $total]);

            DB::commit();

            return response()->json([
                'message' => 'Orden creada exitosamente',
                'codigo' => $orden->id,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error al crear la orden: ' . $e->getMessage()
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Orden $orden)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orden $orden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orden $orden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orden $orden)
    {
        //
    }
}
