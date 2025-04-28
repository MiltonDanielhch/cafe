<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            [
                'categoria' => 'Bebidas frías',
                'nombre' => 'Té frío',
                'precio' => 7.00,
                'stock' => 0,
                'disponible' => true
            ],

            [
                'categoria' => 'Cafés',
                'nombre' => 'Espresso',
                'descripcion' => 'Espresso',
                'precio' => 10.00,
                'stock' => 3,
                'disponible' => true
            ],
            [
                'categoria' => 'Tortas / Dulces',
                'nombre' => 'Torta de chocolate',
                'precio' => 15.00,
                'stock' => 0,
                'disponible' => true
            ],
        ];

        foreach ($productos as $producto) {
            // Obtener categoría por nombre
            $categoria = Categoria::where('nombre', $producto['categoria'])->first();

            DB::table('productos')->insert([
                'categoria_id' => $categoria->id,
                'nombre' => $producto['nombre'],
                'descripcion' => $producto['descripcion'] ?? null,
                'precio' => $producto['precio'],
                'stock' => $producto['stock'],
                'disponible' => $producto['disponible'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}