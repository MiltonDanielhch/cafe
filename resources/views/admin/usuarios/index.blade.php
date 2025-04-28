@extends('adminlte::page')

@section('title', 'Listado de Usuarios')

@section('content_header')
    <h1 class="text-bold">Listado de Usuarios</h1>
    <hr>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Usuarios Registrados</h3>
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Usuario
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @foreach($usuario->roles as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <!-- <a href="{{ route('usuarios.show', $usuario) }}" 
                                           class="btn btn-info btn-sm"
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('usuarios.edit', $usuario) }}" 
                                           class="btn btn-warning btn-sm mx-1"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('usuarios.destroy', $usuario) }}" 
                                              method="POST"
                                              class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form> -->
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay usuarios registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Eliminar usuario?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop