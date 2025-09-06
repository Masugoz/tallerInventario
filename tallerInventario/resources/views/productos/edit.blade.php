<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #ffc107;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        .btn {
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-right: 10px;
            display: inline-block;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .error-list {
            margin: 0;
            padding-left: 20px;
        }
        .required {
            color: #dc3545;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .product-info {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            border-left: 4px solid #ffc107;
        }
        .product-info h3 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .product-info p {
            margin: 5px 0;
            color: #856404;
        }
        .form-header {
            background-color: #f8f9fa;
            padding: 20px;
            margin: -30px -30px 30px -30px;
            border-radius: 10px 10px 0 0;
            border-bottom: 3px solid #ffc107;
        }
        .form-header h1 {
            margin: 0;
            color: #ffc107;
        }
        
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            .container {
                margin: 10px;
                padding: 20px;
            }
            .form-header {
                margin: -20px -20px 20px -20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1>✏️ Editar Producto</h1>
        </div>
        
        <div class="product-info">
            <h3>📦 Producto Actual</h3>
            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
            <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
            <p><strong>Stock actual:</strong> {{ $producto->cantidad }} unidades</p>
            <p><strong>Precio actual:</strong> ${{ number_format($producto->precio, 2) }}</p>
        </div>
        
        <!-- Mostrar errores de validación -->
        @if($errors->any())
            <div class="alert alert-error">
                <strong>❌ Por favor corrija los siguientes errores:</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('productos.update', $producto->codigo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="codigo">Código Producto <span class="required">*</span></label>
                <input type="number" id="codigo" name="codigo" 
                       value="{{ old('codigo', $producto->codigo) }}" required min="1">
                <div class="help-text">Código numérico único del producto</div>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre Producto <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" 
                       value="{{ old('nombre', $producto->nombre) }}" required maxlength="100">
                <div class="help-text">Máximo 100 caracteres</div>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" 
                          placeholder="Descripción del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
                <div class="help-text">Campo opcional para detalles del producto</div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad">Cantidad en Stock <span class="required">*</span></label>
                    <input type="number" id="cantidad" name="cantidad" 
                           value="{{ old('cantidad', $producto->cantidad) }}" required min="0">
                    <div class="help-text">Cantidad disponible en inventario</div>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio Unitario <span class="required">*</span></label>
                    <input type="number" id="precio" name="precio" 
                           value="{{ old('precio', $producto->precio) }}" required min="0" step="0.01">
                    <div class="help-text">Precio en pesos colombianos</div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-warning">💾 Actualizar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>