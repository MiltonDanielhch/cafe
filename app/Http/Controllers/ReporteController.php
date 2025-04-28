<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use Carbon\Carbon;
use PDF;
use App\Exports\OrdenesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }
    public function generar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'nullable|in:pendiente,preparacion,completado,cancelado'
        ]);

        $query = Orden::query();

        if ($request->fecha_inicio && $request->fecha_fin) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        $ordenes = $query->with('cliente')->get();
        $total = $ordenes->sum('total');

        return view('reportes.resultados', compact('ordenes', 'total'));
    }

    public function exportar(Request $request)
    {
        $ordenes = Orden::whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ])
            ->get();

        $pdf = PDF::loadView('reportes.pdf', compact('ordenes'));
        // return $pdf->download('reporte_ordenes.pdf');
        return Excel::download(new OrdenesExport(
            $request->fecha_inicio,
            $request->fecha_fin
        ), 'ordenes.xlsx');
    }
}
