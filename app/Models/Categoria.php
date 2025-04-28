<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'icono',
        'activo'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
