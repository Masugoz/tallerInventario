<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        select, input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error-messages ul {
            margin: 0;
            padding-left: 20px;
        }
        .product-info {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-weight: bold;
            color: #495057;
        }
    </style>
    <script>
        function updateProductInfo() {
            const select = document.getElementById('product_id');
            const infoDiv = document.getElementById('product-info');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value) {
                const nombre = selectedOption.getAttribute('data-nombre');
                const stock = selectedOption.getAttribute('data-stock');
                infoDiv.innerHTML = `Producto: ${nombre} - Stock disponible: ${stock} unidades`;
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Venta</h1>
        
        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @if($productos->count() > 0)
            <form action="{{ route('ventas.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="product_id">Producto:</label>
                    <select name="product_id" id="product_id" required onchange="updateProductInfo()">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ (string) $producto->codigo }}" 
                                    data-nombre="{{ $producto->nombre }}" 
                                    data-stock="{{ $producto->cantidad }}"
                                    {{ old('product_id') === (string) $producto->codigo ? 'selected' : '' }}>
                                {{ $producto->nombre }} ({{ $producto->cantidad }})
                            </option>
                        @endforeach
                    </select>
                    <div id="product-info" class="product-info" style="display: none;"></div>
                </div>
                
                <div class="form-group">
                    <label for="cantidad_vendida">Cantidad a vender:</label>
                    <input type="number" name="cantidad_vendida" id="cantidad_vendida" 
                           value="{{ old('cantidad_vendida') }}" required min="1">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Registrar Venta</button>
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar al Menú</a>
                </div>
            </form>
        @else
            <div class="alert alert-error">
                No hay productos con stock disponible para realizar ventas.
            </div>
            <div class="form-actions">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar al Menú</a>
            </div>
        @endif
    </div>
    
    <script>
        // Inicializar la información del producto si hay uno seleccionado
        window.onload = function() {
            updateProductInfo();
        }
    </script>
</body>
</html>