<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Cafés',
                'icono' => 'fas fa-ice-cream',
                'activo' => 1
            ],
            [
                'nombre' => 'Bebidas frías',
                'icono' => 'fas fa-coffee',
                'activo' => 1
            ],
            [
                'nombre' => 'Snacks / Salados',
                'icono' => 'fas fa-cookie',
                'activo' => 1
            ],
            [
                'nombre' => 'Tortas / Dulces',
                'icono' => 'fas fa-bread-slice',
                'activo' => 1
            ],
            [
                'nombre' => 'Extras',
                'icono' => 'fas fa-wine-glass',
                'activo' => 1
            ],
        ];

        // Insertar datos
        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'nombre' => $categoria['nombre'],
                'icono' => $categoria['icono'],
                'activo' => $categoria['activo'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}