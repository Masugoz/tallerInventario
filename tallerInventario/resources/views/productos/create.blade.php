<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f4f4f4; 
        }
        .container { 
            max-width: 600px; 
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
        .form-group { 
            margin-bottom: 15px; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
            color: #333;
        }
        input, textarea { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .btn { 
            padding: 10px 20px; 
            margin: 5px; 
            border: none; 
            border-radius: 4px;
            cursor: pointer; 
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }
        .btn-primary { 
            background: #28a745; 
            color: white; 
        }
        .btn-secondary { 
            background: #6c757d; 
            color: white; 
        }
        .btn:hover {
            opacity: 0.9;
        }
        .alert { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 4px;
        }
        .alert-danger { 
            background: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb;
        }
        .required {
            color: #dc3545;
        }
        .form-actions {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Producto</h1>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="codigo">Código Producto <span class="required">*</span></label>
                <input type="number" id="codigo" name="codigo" value="{{ old('codigo') }}" 
                       required min="1" placeholder="Ej: 1001">
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre Producto <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" 
                       required maxlength="100" placeholder="Ej: Trapero de microfibra">
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" 
                          placeholder="Descripción opcional del producto">{{ old('descripcion') }}</textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad">Cantidad Inicial <span class="required">*</span></label>
                    <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad', 0) }}" 
                           required min="0" placeholder="0">
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio Unitario <span class="required">*</span></label>
                    <input type="number" id="precio" name="precio" value="{{ old('precio') }}" 
                           required min="0" step="0.01" placeholder="0.00">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>