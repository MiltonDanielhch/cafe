@extends('adminlte::page')

@section('content_header')
<h1><b>Listado de Clientes </b></h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Clientes Registrados</h3>
                <div class="card-tools">
                    <a href="/admin/clientes/create" class="btn btn-primary"><i class="fa fa-plus"></i> Crear Nuevo</a>
                </div>
            </div>

            <div class="card-body">
                <table id="mitabla" class="table table-striped table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del Clientes</th>
                            <th scope="col">Nit/codigo del Clientes</th>
                            <th scope="col">Telefono</th>
                            <th scope="col" style="text-align: center">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $cliente->nombre_cliente }}</td>
                            <td>{{ $cliente->nit_codigo }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td style="text-align: center">                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    $('#mitabla').DataTable({
       "pageLength": 10,
       "language": {
            "processing": "Procesando...",
            "info": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
       }

    });
</script>
@stop
