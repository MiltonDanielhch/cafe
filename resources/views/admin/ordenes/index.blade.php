@extends('adminlte::page')

@section('title', 'Gestión de Órdenes')

@section('content_header')
    <h1 class="m-0 text-dark">Órdenes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Órdenes</h3>
        <div class="card-tools">
            <a href="{{ route('ordenes.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus-circle"></i> Nueva Orden
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <!-- <th>Usuario</th> -->
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenes as $orden)
                <tr>
                    <td>{{ $orden->id }}</td>
                    <!-- <td>{{ $orden->cliente ?? 'Cliente no registrado' }}</td> -->
                    <td>{{ $orden->user->name }}</td>
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
                    <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                    <td>

                    </td>
                </tr>

                <!-- Modal Detalles -->
                <div class="modal fade" id="ordenModal{{ $orden->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detalles Orden #{{ $orden->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Cliente:</strong> {{ $orden->cliente ?? 'N/A' }}</p>
                                        <p><strong>Usuario:</strong> {{ $orden->user->name }}</p>
                                        <p><strong>Estado:</strong> 
                                            @switch($orden->estado)
                                                @case('pendiente') Pendiente @break
                                                @case('preparacion') En preparación @break
                                                @case('completado') Completado @break
                                                @case('cancelado') Cancelado @break
                                            @endswitch
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total:</strong> Bs. {{ number_format($orden->total, 2) }}</p>
                                        <p><strong>Fecha creación:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Última actualización:</strong> {{ $orden->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h5>Notas:</h5>
                                    <p>{{ $orden->notas ?? 'Sin notas adicionales' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<style>
    .modal-body p {
        margin-bottom: 0.5rem;
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@stop