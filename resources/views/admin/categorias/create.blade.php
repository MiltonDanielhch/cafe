@extends('adminlte::page')

@section('title', 'Crear Nueva Categoría')

@section('content_header')
    <h1 class="m-0 text-dark">Nueva Categoría</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Categoría</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre') }}"
                                   required
                                   autofocus>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="icono">Icono (Font Awesome)</label>
                            <select name="icono" 
                                    id="icono" 
                                    class="form-control select2 @error('icono') is-invalid @enderror">
                                <option value="">Seleccionar Icono</option>
                                @foreach($iconos as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ old('icono') == $valor ? 'selected' : '' }}>
                                        {{ $etiqueta }} ({{ $valor }})
                                    </option>
                                @endforeach
                            </select>
                            @error('icono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" 
                               class="custom-control-input" 
                               id="activo" 
                               name="activo" 
                               {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Categoría Activa</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Categoría
                    </button>
                    
                    <!-- <a href="{{ route('categorias.index') }}" class="btn btn-light">
                        <i class="fas fa-undo"></i> Cancelar
                    </a> -->
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Buscar icono...",
                allowClear: true
            });
        });
    </script>
@stop