@extends('adminlte::page')

@section('title', 'Nuevo Producto')

@section('content_header')
    <h1 class="m-0 text-dark d-flex align-items-center">
        <i class="fas fa-box mr-2"></i> Nuevo Producto
    </h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Formulario de Registro</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <div class="row">
                <!-- Categoría -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoría <span class="text-danger">*</span></label>
                        <select name="categoria_id" 
                                class="form-control select2 @error('categoria_id') is-invalid @enderror" 
                                required>
                            <option value="">Seleccione categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" 
                                        data-icon="{{ $categoria->icono ?? 'fas fa-tag' }}" 
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nombre -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nombre" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre') }}" 
                               placeholder=""
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" 
                          class="form-control @error('descripcion') is-invalid @enderror" 
                          rows="3"
                          placeholder="Características y detalles del producto">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <!-- Precio -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Precio (Bs.) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs.</span>
                            </div>
                            <input type="number" 
                                   name="precio" 
                                   step="0.01" 
                                   min="0.01"
                                   class="form-control @error('precio') is-invalid @enderror" 
                                   value="{{ old('precio', 0.00) }}" 
                                   required>
                        </div>
                        @error('precio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Stock -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Stock Disponible <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="stock" 
                               class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', 0) }}" 
                               min="0"
                               required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Imagen</label>
                        <div class="custom-file">
                            <input type="file" 
                                   name="imagen" 
                                   class="custom-file-input @error('imagen') is-invalid @enderror" 
                                   id="imagen"
                                   accept="image/*">
                            <label class="custom-file-label" for="imagen">Seleccionar imagen</label>
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">
                            Formatos permitidos: JPG, PNG (Max 2MB)
                        </small>
                    </div>
                </div>
            </div>

            <!-- Opciones -->
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" 
                           class="custom-control-input" 
                           id="disponible" 
                           name="disponible" 
                           {{ old('disponible', true) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="disponible">
                        Disponible para venta
                    </label>
                </div>
            </div>

            <!-- Vista Previa de Imagen -->
            <div class="row" id="previewContainer" style="display: none;">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <img id="imagenPreview" src="#" alt="Vista previa" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save mr-2"></i> Guardar Producto
                </button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        border-radius: 0.25rem;
    }
    .select2-results__option {
        display: flex;
        align-items: center;
        padding: 8px 12px;
    }
    .select2-results__option:before {
        content: attr(data-icon);
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Select2 con íconos
        $('.select2').select2({
            placeholder: 'Buscar categoría...',
            allowClear: true,
            templateResult: function(option) {
                if (!option.id) return option.text;
                return $(`
                    <span>
                        <i class="${$(option).data('icon')} mr-2"></i>
                        ${option.text}
                    </span>
                `);
            }
        });

        // Vista previa de imagen
        $('#imagen').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagenPreview').attr('src', e.target.result);
                    $('#previewContainer').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#previewContainer').hide();
            }
        });

        // Validación en tiempo real
        $('#productForm').submit(function() {
            $('input').removeClass('is-invalid');
            
            // Validar imagen
            const imagen = $('#imagen')[0].files[0];
            if (imagen && imagen.size > 2*1024*1024) {
                alert('La imagen no puede superar 2MB');
                return false;
            }
        });
    });
</script>
@stop