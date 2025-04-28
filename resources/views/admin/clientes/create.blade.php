@extends('adminlte::page')

@section('content_header')
    <h1 class="text-primary"><b>Nuevo Cliente</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingrese los datos del cliente</h3>
                <div class="card-tools">
                    <a href="{{ route('clientes.index') }}" class="btn btn-tool">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_cliente">Nombre del Cliente</label>
                                <input type="text" 
                                       class="form-control @error('nombre_cliente') is-invalid @enderror" 
                                       id="nombre_cliente"
                                       name="nombre_cliente" 
                                       value="{{ old('nombre_cliente') }}">
                                @error('nombre_cliente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nit_codigo">NIT/Código</label>
                                <input type="text" 
                                       class="form-control @error('nit_codigo') is-invalid @enderror" 
                                       id="nit_codigo"
                                       name="nit_codigo" 
                                       value="{{ old('nit_codigo') }}">
                                @error('nit_codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono"
                                       name="telefono" 
                                       value="{{ old('telefono') }}">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Registrar Cliente
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    // Agrega aquí cualquier script personalizado si es necesario
</script>
@stop   