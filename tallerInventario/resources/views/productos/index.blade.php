<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f4f4f4; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn { 
            padding: 10px 15px; 
            border: none; 
            border-radius: 4px;
            cursor: pointer; 
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin-right: 5px;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.9; }
        
        .alert { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 4px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f0f0f0; }
        
        .codigo { text-align: center; font-weight: bold; color: #007bff; }
        .precio { text-align: right; font-weight: bold; }
        .cantidad { text-align: center; }
        .table-actions { white-space: nowrap; text-align: center; }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            background-color: #dc3545;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
        }
        
        .modal-header h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .modal-body {
            padding: 20px;
            text-align: center;
        }
        
        .modal-body p {
            margin: 10px 0;
            color: #333;
            line-height: 1.5;
        }
        
        .product-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 3px solid #007bff;
        }
        
        .modal-footer {
            padding: 15px 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .modal-footer .btn {
            margin: 0 5px;
            padding: 8px 20px;
        }
        
        @media (max-width: 768px) {
            .container { margin: 10px; padding: 15px; }
            table { font-size: 12px; }
            th, td { padding: 6px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestionar Productos</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="actions">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">Agregar Nuevo Producto</a>
            <a href="/menu" class="btn btn-secondary">Regresar al Menu</a>
        </div>
        
        @if($productos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td class="codigo">{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td class="cantidad">{{ $producto->cantidad }}</td>
                            <td class="precio">${{ number_format($producto->precio, 2) }}</td>
                            <td class="table-actions">
                                <a href="{{ route('productos.edit', $producto->codigo) }}" class="btn btn-warning">Editar</a>
                                <button type="button" class="btn btn-danger" 
                                        onclick="showDeleteModal('{{ $producto->codigo }}', '{{ addslashes($producto->nombre) }}', '{{ $producto->cantidad }}')">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px; color: #666;">
                <p>No hay productos registrados en el sistema.</p>
                <a href="{{ route('productos.create') }}" class="btn btn-primary">Agregar Primer Producto</a>
            </div>
        @endif
    </div>

    <!-- Modal de Confirmación -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmar Eliminación</h3>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar este producto?</p>
                <div class="product-info">
                    <p><strong>Producto:</strong> <span id="modalProductName"></span></p>
                    <p><strong>Código:</strong> <span id="modalProductCode"></span></p>
                    <p><strong>Stock actual:</strong> <span id="modalProductStock"></span> unidades</p>
                </div>
                <p style="color: #dc3545; font-weight: bold;">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Sí, Eliminar</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Form oculto para eliminación -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        let currentProductCode = null;

        function showDeleteModal(codigo, nombre, stock) {
            currentProductCode = codigo;
            document.getElementById('modalProductName').textContent = nombre;
            document.getElementById('modalProductCode').textContent = codigo;
            document.getElementById('modalProductStock').textContent = stock;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            currentProductCode = null;
        }

        function confirmDelete() {
            if (currentProductCode) {
                const form = document.getElementById('deleteForm');
                form.action = '/productos/' + currentProductCode;
                form.submit();
            }
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>