document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 0;

    // Inicializar Select2
    $('.select2-cliente').select2({ placeholder: 'Buscar cliente', allowClear: true });
    $('.select2-producto').select2({ placeholder: 'Buscar producto', allowClear: true });

    // Cambia cliente
    $('.select2-cliente').on('change', function() {
        const cliente = $(this).find('option:selected').text();
        document.getElementById('clienteSeleccionado').innerText = cliente;
    });

    // Agregar producto
    document.getElementById('btnAddProducto').addEventListener('click', function() {
        itemIndex++;

        const productoOptions = productos.map(producto => 
            `<option value="${producto.id}" data-precio="${producto.precio}" data-stock="${producto.stock}">
                ${producto.nombre} (Stock: ${producto.stock})
            </option>`).join('');

        const newItem = `
            <div class="producto-item row mb-3 align-items-center">
                <div class="col-md-5">
                    <select name="productos[${itemIndex}][id]" class="form-control select2-producto" required>
                        <option value="">Seleccionar producto</option>
                        ${productoOptions}
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
            </div>
        `;

        document.getElementById('productosContainer').insertAdjacentHTML('beforeend', newItem);

        $(`select[name="productos[${itemIndex}][id]"]`).select2({ placeholder: 'Buscar producto', allowClear: true });

        updateRemoveButtons();
        updateTotal();
    });

    // Eliminar producto
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('.producto-item').remove();
            updateRemoveButtons();
            updateTotal();
        }
    });

    // Actualizar cuando cambia cantidad o producto
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad')) {
            validateStock(e.target.closest('.producto-item'));
            updateTotal();
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select2-producto')) {
            updateTotal();
        }
    });

    // Validar stock disponible
    function validateStock(item) {
        const select = item.querySelector('.select2-producto');
        const cantidadInput = item.querySelector('.cantidad');

        if (select && cantidadInput) {
            const selectedOption = select.options[select.selectedIndex];
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            const cantidad = parseInt(cantidadInput.value) || 0;

            if (cantidad > stock) {
                cantidadInput.classList.add('is-invalid');
                item.classList.add('border-danger');
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `Solo hay ${stock} unidades disponibles`
                });
            } else {
                cantidadInput.classList.remove('is-invalid');
                item.classList.remove('border-danger');
            }
        }
    }

    // Actualizar total
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.producto-item').forEach(item => {
            const select = item.querySelector('.select2-producto');
            const cantidadInput = item.querySelector('.cantidad');

            if (select && cantidadInput && select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const precio = parseFloat(selectedOption.dataset.precio) || 0;
                const cantidad = parseInt(cantidadInput.value) || 0;

                total += precio * cantidad;
            }
        });
        document.getElementById('totalOrden').innerText = `Bs. ${total.toFixed(2)}`;
    }

    // Botones eliminar
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.btn-remove');
        if (removeButtons.length === 1) {
            removeButtons[0].disabled = true;
        } else {
            removeButtons.forEach(btn => btn.disabled = false);
        }
    }

    // Enviar formulario
    document.getElementById('ordenForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        let isValid = true;
        document.querySelectorAll('.producto-item').forEach(item => {
            const select = item.querySelector('.select2-producto');
            const cantidad = item.querySelector('.cantidad');

            if (!select.value || !cantidad.value) {
                isValid = false;
                item.classList.add('border-danger');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Debe completar todos los productos y cantidades'
            });
            return;
        }

        let url = this.action;
        if (url.startsWith('http://')) {
            url = url.replace('http://', 'https://');
        }

        

        const formData = new FormData(this);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            if (!response.ok) {
                throw new Error('Error al guardar la orden.');
            }

            Swal.fire({
                icon: 'success',
                title: 'Orden guardada',
                text: 'La orden se creó exitosamente'
            }).then(() => {
                window.location.href = '/admin/ordenes';
            });

        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al guardar la orden.'
            });
        }
    });

});
