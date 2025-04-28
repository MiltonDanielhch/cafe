@extends('adminlte::page')

@section('title', 'Listado de Productos')

@section('content_header')
    <h1 class="m-0 text-dark">Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestión de Productos</h3>
            <div class="card-tools">
                <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Producto
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>
                            @if($producto->disponible)
                                <span class="badge badge-success">Disponible</span>
                            @else
                                <span class="badge badge-danger">Agotado</span>
                            @endif
                        </td>
                        <td>
                            <!-- <a href="{{ route('productos.edit', $producto) }}" 
                               class="btn btn-sm btn-primary"
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('productos.destroy', $producto) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar">
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
        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
    </style>
@stop