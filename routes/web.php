<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Models\Categoria;

Route::get('/', function () {
    $categorias = Categoria::with(['productos' => function($query) {
        $query->where('disponible', true);
    }])->get();

    return view('welcome', compact('categorias'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
     // Recursos
     Route::resource('admin/productos', ProductoController::class);
     Route::resource('admin/ordenes', OrdenController::class);
     Route::get('/productos/stock', [ProductoController::class, 'stock'])->name('productos.stock');

     Route::resource('admin/categorias', CategoriaController::class);
    //rutas para usuarios
    Route::resource('/admin/usuarios', UsuarioController::class);
    Route::resource('/admin/clientes', ClienteController::class);
    

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::post('/reportes/generar', [ReporteController::class, 'generar'])->name('reportes.generar');
    Route::get('/reportes/exportar', [ReporteController::class, 'exportar'])->name('reportes.exportar');


      // Rutas personalizadas
    // Route::post('/ordenes/{orden}/completar', [OrdenController::class, 'completar'])->name('ordenes.completar');
    // Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
});
