<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrdenProducto extends Pivot
{
    protected $table = 'orden_productos';
    
    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'instrucciones'
    ];
    
    protected $casts = [
        'precio_unitario' => 'decimal:2'
    ];
}
