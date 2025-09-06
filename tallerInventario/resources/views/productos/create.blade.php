<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
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
        .form-header {
            background-color: #f8f9fa;
            padding: 20px;
            margin: -30px -30px 30px -30px;
            border-radius: 10px 10px 0 0;
            border-bottom: 3px solid #007bff;
        }
        .form-header h1 {
            margin: 0;
            color: #007bff;
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
            <h1>➕ Agregar Nuevo Producto</h1>
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
        
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="codigo">Código Producto <span class="required">*</span></label>
                <input type="number" id="codigo" name="codigo" value="{{ old('codigo') }}" 
                       required min="1" placeholder="Ej: 1001">
                <div class="help-text">Ingrese un código numérico único para el producto</div>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre Producto <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" 
                       required maxlength="100" placeholder="Ej: Trapero de microfibra">
                <div class="help-text">Máximo 100 caracteres</div>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" 
                          placeholder="Descripción opcional del producto">{{ old('descripcion') }}</textarea>
                <div class="help-text">Campo opcional para agregar detalles del producto</div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad">Cantidad Inicial <span class="required">*</span></label>
                    <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad', 0) }}" 
                           required min="0" placeholder="0">
                    <div class="help-text">Stock inicial del producto</div>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio Unitario <span class="required">*</span></label>
                    <input type="number" id="precio" name="precio" value="{{ old('precio') }}" 
                           required min="0" step="0.01" placeholder="0.00">
                    <div class="help-text">Precio en pesos colombianos</div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>container {
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
            border-color: #007bff;
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
        .btn-primary {
            background-color: #28a745;
            color: white;
        }
        .btn-primary:hover {
            background-color: #218838;
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
        .