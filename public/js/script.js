// Estado del pedido
const estadoPedido = {
    items: [],
    total: 0
};

// Base de datos de productos
// const productos = [
//     {
//         id: "cafe",
//         nombre: "Café",
//         precio: 10,
//         categoria: "cafes",
//         imagen: "images/a.jpeg",
//         inventario: 10
//     },
//     {
//         id: "te",
//         nombre: "Té",
//         precio: 8,
//         categoria: "cafes",
//         imagen: "images/a.jpeg",
//         inventario: 15
//     },
//     // Añadir todos los productos restantes aquí...
// ];

// Cargar productos en el DOM
function cargarProductos() {
    const categorias = [...new Set(productos.map(p => p.categoria))];
    
    categorias.forEach(categoria => {
        const contenedor = document.querySelector(`#${categoria} .productos-container`);
        const productosCategoria = productos.filter(p => p.categoria === categoria);
        
        productosCategoria.forEach(producto => {
            const card = document.createElement('div');
            card.className = 'producto-card';
            card.innerHTML = `
                <img src="${producto.imagen}" alt="${producto.nombre}" class="producto-imagen">
                <h3 class="producto-nombre">${producto.nombre}</h3>
                <p class="producto-precio">Bs. ${producto.precio}</p>
                <p class="inventario">Disponibles: ${producto.inventario}</p>
                <button class="btn-anadir" 
                    data-id="${producto.id}" 
                    ${producto.inventario === 0 ? 'disabled' : ''}>
                    ${producto.inventario > 0 ? '+' : 'Agotado'}
                </button>
            `;
            contenedor.appendChild(card);
        });
    });
}

// Actualizar carrito
// Optimizado: Mejor estructura y manejo de errores
document.addEventListener('DOMContentLoaded', () => {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    
    window.actualizarCarrito = () => {
        const carritoItems = document.getElementById('carrito-items');
        const carritoTotal = document.getElementById('carrito-total');
        let total = 0;
        
        carritoItems.innerHTML = carrito.map((item, index) => {
            total += item.precio * item.cantidad;
            return `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span>${item.nombre} x${item.cantidad}</span>
                        ${item.stock < item.cantidad ? 
                            '<span class="text-danger ml-2">(Stock insuficiente)</span>' : ''}
                    </div>
                    <div>
                        <span>Bs. ${(item.precio * item.cantidad).toFixed(2)}</span>
                        <button class="btn btn-sm btn-danger ml-2" 
                                onclick="eliminarDelCarrito(${index})">
                            ×
                        </button>
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
    const btnConfirmar = document.getElementById('confirmar-pedido');

    // Delegación de eventos para mejor performance
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-anadir')) {
            const productoId = e.target.dataset.id;
            const producto = productos.find(p => p.id === productoId);
            
            if(producto && producto.inventario > 0) {
                producto.inventario--;
                estadoPedido.items.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    precio: producto.precio
                });
                
                actualizarCarrito();
                actualizarInventarioUI(productoId);
            }
        }
        
        if (e.target.classList.contains('btn-eliminar')) {
            const index = e.target.dataset.index;
            carrito.splice(index, 1);
            actualizarCarrito();
        }
    });
});



// Actualizar inventario en UI
function actualizarInventarioUI(productoId) {
    const producto = productos.find(p => p.id === productoId);
    const boton = document.querySelector(`[data-id="${productoId}"]`);
    
    if(producto.inventario === 0) {
        boton.textContent = 'Agotado';
        boton.disabled = true;
    }
    
    const inventarioElement = boton.previousElementSibling;
    if(inventarioElement) {
        inventarioElement.textContent = `Disponibles: ${producto.inventario}`;
    }
}

// Confirmar pedido
document.getElementById('confirmar-pedido').addEventListener('click', () => {
    const venta = {
        fecha: new Date().toISOString(),
        items: [...estadoPedido.items],
        total: estadoPedido.total
    };
    
    // Guardar en localStorage
    const historial = JSON.parse(localStorage.getItem('historial') || '[]');
    historial.push(venta);
    localStorage.setItem('historial', JSON.stringify(historial));
    
    // Resetear estado
    estadoPedido.items = [];
    estadoPedido.total = 0;
    actualizarCarrito();
    alert('Pedido confirmado! Gracias por su compra.');
});

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    cargarProductos();
});