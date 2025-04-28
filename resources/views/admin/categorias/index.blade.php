@extends('adminlte::page')

@section('title', 'Listado de Categorías')

@section('content_header')
    <h1 class="m-0 text-dark">Categorías</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Categorías</h3>
            <div class="card-tools">
                <a href="{{ route('categorias.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle"></i> Nueva Categoría
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Icono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td>
                            @if($categoria->icono)
                            <i class="{{ $categoria->icono }}"></i>
                            @else
                            <span class="text-muted">Sin icono</span>
                            @endif
                        </td>
                        <td>
                            @if($categoria->activo)
                            <span class="badge badge-success">Activo</span>
                            @else
                            <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <!-- <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
@stop

@section('css')
    <style>
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@stop