<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Café Cielo - Menú</title>
    <!-- Optimizado: Preload de recursos críticos -->
    <link rel="preload" href="{{ asset('css/styles.css') }}" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/sweetalert2@11" as="script">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <header>
        <h1>Café Cielo</h1>
    </header>
    <nav>
        <ul>
            @foreach($categorias as $categoria)
                <li><a href="#{{ Str::slug($categoria->nombre) }}">{{ $categoria->nombre }}</a></li>
            @endforeach
        </ul>
    </nav>
    <main>
        @foreach($categorias as $categoria)
        <section id="{{ Str::slug($categoria->nombre) }}" class="seccion-productos">
            <h2>{{ $categoria->nombre }}</h2>
            <div class="productos-container">
                @foreach($categoria->productos as $producto)
                <div class="producto-card" data-product-id="{{ $producto->id }}">
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="producto-imagen">
                    <h3 class="producto-nombre">{{ $producto->nombre }}</h3>
                    <p class="producto-precio">Bs. {{ number_format($producto->precio, 2) }}</p>
                    <button class="btn-anadir" 
                            data-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->nombre }}"
                            data-precio="{{ $producto->precio }}"
                            data-stock="{{ $producto->stock }}"
                            {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                        +
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach

        <!-- Carrito -->
         
        <aside id="carrito" class="p-3 shadow">
            <br>
            <div class="d-flex gap-2 mb-4 justify-content-end">
                @auth
                    <a href="{{ route('ordenes.index') }}" class="btn btn-outline-dark btn-sm">Panel</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">Iniciar sesión</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm">Registrarse</a>
                    @endif
                @endauth
            </div>

            <h2 class="h4 mb-3 text-center">Tu Pedido</h2>
            <div id="carrito-items" class="mb-2" style="max-height: 400px; overflow-y: auto;"></div>
            
            <div class="mt-auto">
                <p class="mb-3 fw-bold">Total: Bs. <span id="carrito-total">0</span></p>
                <button id="confirmar-pedido" class="btn btn-success w-100 py-2">Confirmar Pedido</button>
            </div>
        </aside>
    </main>
    <footer>
        <p>&copy; 2025 Café Cielo. Todos los derechos reservados.</p>
    </footer>

    <script>
    // HACEMOS carrito GLOBAL
    let carrito = [];

    document.addEventListener('DOMContentLoaded', () => {
        // Cargamos el carrito de localStorage una sola vez
        carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        const carritoItems = document.getElementById('carrito-items');
        const carritoTotal = document.getElementById('carrito-total');
        const botonConfirmar = document.getElementById('confirmar-pedido');

        const actualizarCarrito = () => {
            let total = 0;
            carritoItems.innerHTML = carrito.map((item, index) => {
                total += item.precio * item.cantidad;
                return `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span>${item.nombre} x${item.cantidad}</span>
                            ${item.stock < item.cantidad ? '<span class="text-danger ml-2">(Stock insuficiente)</span>' : ''}
                        </div>
                        <div>
                            <span>Bs. ${(item.precio * item.cantidad).toFixed(2)}</span>
                            <button class="btn btn-sm btn-danger ml-2" onclick="eliminarDelCarrito(${index})">×</button>
                        </div>
                    </div>`;
            }).join('');

            carritoTotal.textContent = total.toFixed(2);
            localStorage.setItem('carrito', JSON.stringify(carrito));
        };

        window.eliminarDelCarrito = (index) => {
            carrito.splice(index, 1);
            actualizarCarrito();
        };

        document.querySelectorAll('.btn-anadir').forEach(btn => {
            btn.addEventListener('click', () => {
                const producto = {
                    id: btn.dataset.id,
                    nombre: btn.dataset.nombre,
                    precio: parseFloat(btn.dataset.precio),
                    stock: parseInt(btn.dataset.stock),
                    cantidad: 1
                };

                const itemExistente = carrito.find(item => item.id === producto.id);

                if (producto.stock <= 0) {
                    Swal.fire('Error', 'Producto agotado', 'error');
                    return;
                }

                if (itemExistente) {
                    if (itemExistente.cantidad >= producto.stock) {
                        Swal.fire('Error', 'No hay suficiente stock', 'error');
                        return;
                    }
                    itemExistente.cantidad++;
                } else {
                    carrito.push(producto);
                }

                actualizarCarrito();
            });
        });

        botonConfirmar.addEventListener('click', async () => {
            if (carrito.length === 0) {
                Swal.fire('Carrito Vacío', 'Agrega productos antes de confirmar', 'warning');
                return;
            }

            try {
                botonConfirmar.disabled = true;
                botonConfirmar.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

                const payload = {
                    productos: carrito.map(item => ({
                        id: item.id,
                        cantidad: item.cantidad
                    })),
                    cliente_id: @json(Auth::id())
                };

                let url = '{{ route("ordenes.store") }}';

                // Forzar HTTPS si la página está cargada en HTTPS
                if (location.protocol === 'https:' && url.startsWith('http://')) {
                    url = url.replace('http://', 'https://');
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });


                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const data = await response.json();

                Swal.fire({
                    icon: 'success',
                    title: '¡Pedido Registrado!',
                    html: `
                        <p>${data.message}</p>
                        <div class="mt-3">
                            <strong>Código:</strong> ${data.codigo}<br>
                            <strong>Total:</strong> Bs. ${data.total.toFixed(2)}
                        </div>
                    `
                });

                carrito = []; // Vaciamos carrito en memoria
                localStorage.removeItem('carrito');
                actualizarCarrito();

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Procesar',
                    text: error.message || 'Error en la comunicación con el servidor'
                });
            } finally {
                botonConfirmar.disabled = false;
                botonConfirmar.textContent = 'Confirmar Pedido';
            }
        });

        actualizarCarrito();
    });
    </script>

    
    <!-- Optimizado: Scripts al final del body -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
</body>
</html>