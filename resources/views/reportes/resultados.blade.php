@extends('adminlte::page')

@section('title', 'Resultados del Reporte')

@section('content_header')
    <h1>Resultados del Reporte</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <strong>Total de ventas:</strong> Bs. {{ number_format($total, 2) }}
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenes as $orden)
                <tr>
                    <td>{{ $orden->id }}</td>
                    <td>{{ $orden->cliente->nombre ?? 'N/A' }}</td>
                    <td>
                        @switch($orden->estado)
                            @case('pendiente')
                                <span class="badge badge-warning">Pendiente</span>
                                @break
                            @case('preparacion')
                                <span class="badge badge-info">En preparación</span>
                                @break
                            @case('completado')
                                <span class="badge badge-success">Completado</span>
                                @break
                            @case('cancelado')
                                <span class="badge badge-danger">Cancelado</span>
                                @break
                        @endswitch
                    </td>
                    <td>Bs. {{ number_format($orden->total, 2) }}</td>
                    <td>{{ $orden->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <a href="{{ route('reportes.exportar') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar a Excel
            </a>
        </div>
    </div>
</div>
@stop