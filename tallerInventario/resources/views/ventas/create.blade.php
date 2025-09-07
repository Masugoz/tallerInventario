<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, input { width: 100%; padding: 8px; border: 1px solid #ddd; }
        .btn { padding: 10px 20px; margin: 5px; border: none; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 10px; margin: 10px 0; background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Venta</h1>
        
        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif
        
        @if($productos->count() > 0)
            <form action="{{ route('ventas.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Producto:</label>
                    <select name="product_id" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->codigo }}">
                                {{ $producto->nombre }} ({{ $producto->cantidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Cantidad a vender:</label>
                    <input type="number" name="cantidad_vendida" min="1" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Registrar Venta</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar al Menu</a>
            </form>
        @else
            <p>No hay productos con stock disponible.</p>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Regresar al Menu</a>
        @endif
    </div>
</body>
</html>