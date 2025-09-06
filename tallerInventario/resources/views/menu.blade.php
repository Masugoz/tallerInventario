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
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .menu-options {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .menu-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
        }
        .menu-card:hover {
            background: #e9ecef;
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .menu-card h3 {
            margin: 0 0 10px 0;
            color: #007bff;
        }
        .menu-card p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Inventario</h1>
        
        <div class="menu-options">
            <a href="{{ route('productos.index') }}" class="menu-card">
                <h3>Gestionar Productos</h3>
                <p>Ver, agregar, editar y eliminar productos del inventario</p>
            </a>
            
            <a href="{{ route('ventas.index') }}" class="menu-card">
                <h3>Gestionar Ventas</h3>
                <p>Ver historial de ventas y registrar nuevas ventas</p>
            </a>
        </div>
    </div>
</body>
</html>