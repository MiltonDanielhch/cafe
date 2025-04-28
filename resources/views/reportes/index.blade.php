@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Generar Reportes</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('reportes.generar') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha inicio:</label>
                        <input type="date" class="form-control" name="fecha_inicio">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha fin:</label>
                        <input type="date" class="form-control" name="fecha_fin">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado:</label>
                        <select class="form-control" name="estado">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="preparacion">En preparación</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>
    </div>
</div>
@stop