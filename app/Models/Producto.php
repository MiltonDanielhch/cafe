<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'disponible',
        'imagen'
    ];

    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute()
    {
        return $this->imagen ? asset("storage/{$this->imagen}") : asset('images/default.jpg');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class)
            ->withPivot('cantidad', 'precio_unitario', 'instrucciones');
    }
    
    
}
