<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 2.5em;
            font-weight: bold;
        }
        .menu-options {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .menu-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }
        .menu-card:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-color: #007bff;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,123,255,0.3);
        }
        .menu-card h3 {
            margin: 0 0 15px 0;
            color: #007bff;
            font-size: 1.5em;
            font-weight: bold;
        }
        .menu-card p {
            margin: 0;
            color: #666;
            font-size: 1.1em;
            line-height: 1.4;
        }
        .menu-card .icon {
            font-size: 3em;
            margin-bottom: 15px;
            display: block;
        }
        .productos-icon {
            color: #28a745;
        }
        .ventas-icon {
            color: #ffc107;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 30px 20px;
            }
            h1 {
                font-size: 2em;
            }
            .menu-card h3 {
                font-size: 1.3em;
            }
            .menu-card p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Inventario</h1>
        
        <div class="menu-options">
            <a href="{{ route('productos.index') }}" class="menu-card">
                <div class="icon productos-icon">📦</div>
                <h3>Gestionar Productos</h3>
                <p>Ver, agregar, editar y eliminar productos del inventario</p>
            </a>
            
            <a href="{{ route('ventas.index') }}" class="menu-card">
                <div class="icon ventas-icon">💰</div>
                <h3>Gestionar Ventas</h3>
                <p>Ver historial de ventas y registrar nuevas ventas</p>
            </a>
        </div>
    </div>
</body>
</html>