<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ventas - Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1400px;
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
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
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
        .no-sales {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .no-sales h3 {
            color: #999;
            margin-bottom: 20px;
        }
        .precio, .total {
            text-align: right;
            font-weight: bold;
        }
        .cantidad, .id-venta {
            text-align: center;
        }
        .fecha {
            white-space: nowrap;
            font-size: 13px;
        }
        .producto-vendido {
            font-weight: 500;
            color: #007bff;
        }
        .sales-summary {
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            border: 2px solid #dee2e6;
        }
        .summary-item {
            text-align: center;
            flex: 1;
            min-width: 150px;
        }
        .summary-number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-number.ventas {
            color: #007bff;
        }
        .summary-number.ingresos {
            color: #28a745;
        }
        .summary-number.productos {
            color: #ffc107;
        }
        .summary-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }
        .id-venta {
            font-weight: bold;
            color: #6c757d;
        }
        .total-destacado {
            background-color: #e8f5e9;
            color: #2e7d32;
            font-weight: bold;
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
            .sales-summary {
                flex-direction: column;
                text-align: center;
            }
            .summary-item {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💰 Gestionar Ventas</h1>
        
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
        
        <!-- Resumen de ventas -->
        @if($ventas->count() > 0)
            <div class="sales-summary">
                <div class="summary-item">
                    <div class="summary-number ventas">{{ $ventas->count() }}</div>
                    <div class="summary-label">📊 Total Ventas</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number ingresos">${{ number_format($ventas->sum('total'), 2) }}</div>
                    <div class="summary-label">💵 Ingresos Totales</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number productos">{{ $ventas->sum('cantidad_vendida') }}</div>
                    <div class="summary-label">📦 Productos Vendidos</div>
                </div>
            </div>
        @endif
        
        <!-- Botones de acción -->
        <div class="actions">
            <a href="{{ route('ventas.create') }}" class="btn btn-success">➕ Registrar Nueva Venta</a>
            <a href="/menu" class="btn btn-secondary">🏠 Regresar al Menú</a>
        </div>
        
        <!-- Tabla de ventas -->
        @if($ventas->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Producto Vendido</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total Venta</th>
                            <th>Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td class="id-venta">#{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="producto-vendido">
                                    @if($venta->producto)
                                        {{ $venta->producto->nombre }}
                                        <small style="color: #666;">(Código: {{ $venta->producto->codigo }})</small>
                                    @else
                                        <span style="color: #dc3545;">Producto eliminado</span>
                                    @endif
                                </td>
                                <td class="cantidad">{{ number_format($venta->cantidad_vendida) }}</td>
                                <td class="precio">${{ number_format($venta->precio_unitario, 2) }}</td>
                                <td class="total total-destacado">${{ number_format($venta->total, 2) }}</td>
                                <td class="fecha">
                                    {{ $venta->fecha->format('d/m/Y') }}<br>
                                    <small>{{ $venta->fecha->format('H:i:s') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-sales">
                <h3>📋 No hay ventas registradas</h3>
                <p>No se han registrado ventas en el sistema.</p>
                <p>Comience registrando su primera venta.</p>
                <a href="{{ route('ventas.create') }}" class="btn btn-success">➕ Registrar Primera Venta</a>
            </div>
        @endif
    </div>
</body>
</html>