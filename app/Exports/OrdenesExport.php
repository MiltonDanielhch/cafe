<?php

namespace App\Exports;

use App\Models\Orden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdenesExport implements FromCollection, WithHeadings
{
    protected $fecha_inicio;
    protected $fecha_fin;

    public function __construct($fecha_inicio, $fecha_fin)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function collection()
    {
        return Orden::select('id', 'cliente_id', 'estado', 'total', 'created_at')
            ->whereBetween('created_at', [$this->fecha_inicio, $this->fecha_fin])
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente ID',
            'Estado',
            'Total',
            'Fecha de Creación'
        ];
    }
}
