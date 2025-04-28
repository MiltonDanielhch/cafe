<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes'; 
    protected $fillable = [
        'user_id',    // <-- Agregar esta línea
        'cliente',
        'estado',
        'total',
        'notas'
    ];    
    // app/Models/Orden.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // app/Models/Orden.php

    public function cliente()
    {
        return $this->belongsTo(Cliente::class); // Ajusta el nombre del modelo si es diferente
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'orden_productos')
                    ->withPivot('cantidad', 'precio_unitario', 'instrucciones')
                    ->using(OrdenProducto::class);
    }
}
