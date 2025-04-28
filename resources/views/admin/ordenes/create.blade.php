@extends('adminlte::page')

@section('title', 'Crear Nueva Orden')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-file-invoice"></i> Nueva Orden</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('ordenes.store') }}" method="POST" id="ordenForm">
            @csrf
            
            <!-- Selección de Cliente -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cliente <span class="text-danger">*</span></label>
                        <select name="cliente_id" class="form-control select2-cliente" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nombre_cliente }} 
                                    - {{ $cliente->nit_codigo }}
                                    @if($cliente->email)
                                        | {{ $cliente->email }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notas Adicionales</label>
                        <textarea name="notas" class="form-control" rows="2" placeholder="Instrucciones especiales"></textarea>
                    </div>
                </div>
            </div>

            <!-- Productos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h4 class="border-bottom pb-2">Productos <span class="text-danger">*</span></h4>
                    <div id="productosContainer">
                        <!-- Plantilla de producto -->
                        <div class="producto-item row mb-3 align-items-center">
                            <div class="col-md-5">
                                <select name="productos[0][id]" class="form-control select2-producto" required>
                                    <option value="">Seleccionar producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                            data-precio="{{ $producto->precio }}"
                                            data-stock="{{ $producto->stock }}">
                                            {{ $producto->nombre }} 
                                            (Stock: {{ $producto->stock }})
                                            @if($producto->descripcion)
                                                - {{ Str::limit($producto->descripcion, 30) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" 
                                       name="productos[0][cantidad]" 
                                       class="form-control cantidad" 
                                       min="1" 
                                       value="1" 
                                       required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" 
                                       name="productos[0][instrucciones]" 
                                       class="form-control" 
                                       placeholder="Ej: Sin azúcar, empaque especial, etc.">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-remove" disabled>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-success mt-2" id="btnAddProducto">
                        <i class="fas fa-plus-circle"></i> Agregar Producto
                    </button>
                </div>
            </div>

            <!-- Resumen de orden -->
            <div class="row bg-light p-3 mb-4">
                <div class="col-md-6">
                    <h5>Detalles de la Orden</h5>
                    <p>
                        <i class="fas fa-user"></i> Cliente: 
                        <span id="clienteSeleccionado">Ninguno</span>
                    </p>
                </div>
                <div class="col-md-6 text-right">
                    <h4>Total: <span id="totalOrden" class="text-success">Bs. 0.00</span></h4>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Guardar Orden
                </button>
                <a href="{{ route('ordenes.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Cancelar
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
        height: 38px;
        border-radius: 4px;
    }
    .producto-item {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        transition: all 0.3s;
    }
    .producto-item:hover {
        border-color: #80bdff;
    }
    .btn-remove {
        transition: transform 0.2s;
    }
    .btn-remove:hover {
        transform: scale(1.1);
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        let itemIndex = 0;
        
        // Inicializar Select2
        $('.select2-cliente').select2({
            placeholder: 'Buscar cliente',
            allowClear: true
        });
        
        $('.select2-producto').select2({
            placeholder: 'Buscar producto',
            allowClear: true
        });

        // Actualizar cliente seleccionado
        $('.select2-cliente').on('change', function() {
            const cliente = $(this).find('option:selected').text();
            $('#clienteSeleccionado').text(cliente);
        });

        // Agregar nuevo producto
        $('#btnAddProducto').click(function() {
            itemIndex++;
            const newItem = `
                <div class="producto-item row mb-3 align-items-center">
                    <div class="col-md-5">
                        <select name="productos[${itemIndex}][id]" class="form-control select2-producto" required>
                            <option value="">Seleccionar producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" 
                                    data-precio="{{ $producto->precio }}"
                                    data-stock="{{ $producto->stock }}">
                                    {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" 
                               name="productos[${itemIndex}][cantidad]" 
                               class="form-control cantidad" 
                               min="1" 
                               value="1" 
                               required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" 
                               name="productos[${itemIndex}][instrucciones]" 
                               class="form-control" 
                               placeholder="Instrucciones especiales">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>`;
            
            $('#productosContainer').append(newItem);
            $(`select[name="productos[${itemIndex}][id]"]`).select2({
                placeholder: 'Buscar producto',
                allowClear: true
            });
            updateRemoveButtons();
            updateTotal();
        });

        // Calcular totales y validar stock
        $(document).on('change', '.select2-producto, .cantidad', function() {
            updateTotal();
            validateStock($(this).closest('.producto-item'));
        });

        // Eliminar producto
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('.producto-item').remove();
            updateTotal();
            updateRemoveButtons();
        });

        // Validación de stock
        function validateStock(item) {
            const select = item.find('.select2-producto');
            const cantidad = item.find('.cantidad');
            const stock = select.find('option:selected').data('stock');
            
            if(stock < cantidad.val()) {
                cantidad.addClass('is-invalid');
                select.closest('.producto-item').addClass('border-danger');
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `Solo hay ${stock} unidades disponibles`
                });
            } else {
                cantidad.removeClass('is-invalid');
                select.closest('.producto-item').removeClass('border-danger');
            }
        }

        // Actualizar total
        function updateTotal() {
            let total = 0;
            $('.producto-item').each(function() {
                const precio = $(this).find('.select2-producto option:selected').data('precio') || 0;
                const cantidad = $(this).find('.cantidad').val() || 0;
                total += precio * cantidad;
            });
            $('#totalOrden').text(`Bs. ${total.toFixed(2)}`);
        }

        // Controlar botones de eliminación
        function updateRemoveButtons() {
            $('.btn-remove').prop('disabled', $('.producto-item').length === 1);
        }

        // Validación antes de submit
        $('#ordenForm').submit(function(e) {
            let isValid = true;
            
            // Validar productos
            $('.producto-item').each(function() {
                const producto = $(this).find('.select2-producto').val();
                const cantidad = $(this).find('.cantidad').val();
                
                if(!producto || !cantidad) {
                    isValid = false;
                    $(this).find('input').addClass('is-invalid');
                }
            });

            if(!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campos incompletos',
                    text: 'Debe completar todos los productos y cantidades'
                });
            }
        });
    });
</script>
@stop