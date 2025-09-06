<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos - Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2em;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn {
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            padding: 8px 12px;
            font-size: 12px;
            margin-right: 5px;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .no-products h3 {
            color: #999;
            margin-bottom: 20px;
        }
        .table-actions {
            white-space: nowrap;
            text-align: center;
        }
        .codigo {
            text-align: center;
            font-weight: bold;
            color: #007bff;
        }
        .precio {
            text-align: right;
            font-weight: bold;
        }
        .cantidad {
            text-align: center;
        }
        .stock-low {
            color: #dc3545;
            font-weight: bold;
        }
        .stock-medium {
            color: #ffc107;
            font-weight: bold;
        }
        .stock-high {
            color: #28a745;
            font-weight: bold;
        }
        .nombre-producto {
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 10px;
            }
            table {
                font-size: 12px;
            }
            th, td {
                padding: 8px 4px;
            }
            .btn {
                padding: 8px 12px;
                font-size: 12px;
            }
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Gestionar Productos</h1>
        
        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif
        
        <!-- Botones de acción -->
        <div class="actions">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">➕ Agregar Nuevo Producto</a>
            <a href="/menu" class="btn btn-secondary">🏠 Regresar al Menú</a>
        </div>
        
        <!-- Tabla de productos -->
        @if($productos->count() > 0)
            <div class="table-responsive">
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
                                <td class="nombre-producto">{{ $producto->nombre }}</td>
                                <td class="cantidad">
                                    <span class="{{ $producto->cantidad <= 5 ? 'stock-low' : ($producto->cantidad <= 20 ? 'stock-medium' : 'stock-high') }}">
                                        {{ $producto->cantidad }}
                                    </span>
                                </td>
                                <td class="precio">${{ number_format($producto->precio, 2) }}</td>
                                <td class="table-actions">
                                    <a href="{{ route('productos.edit', $producto->codigo) }}" class="btn btn-warning">✏️ Editar</a>
                                    <form action="{{ route('productos.destroy', $producto->codigo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar este producto?\\n\\nProducto: {{ $producto->nombre }}\\nCódigo: {{ $producto->codigo }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">🗑️ Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 6px;">
                <strong>Total de productos:</strong> {{ $productos->count() }}
                <br>
                <strong>Valor total del inventario:</strong> ${{ number_format($productos->sum(function($p) { return $p->precio * $p->cantidad; }), 2) }}
            </div>
        @else
            <div class="no-products">
                <h3>📋 No hay productos registrados</h3>
                <p>No hay productos registrados en el sistema.</p>
                <a href="{{ route('productos.create') }}" class="btn btn-primary">➕ Agregar Primer Producto</a>
            </div>
        @endif
    </div>
</body>
</html>