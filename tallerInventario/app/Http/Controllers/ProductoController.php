<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    // Mostrar lista de productos
    public function index()
    {
        $productos = Producto::orderBy('codigo', 'asc')->get();
        return view('productos.index', compact('productos'));
    }
    
    // Mostrar formulario para crear producto
    public function create()
    {
        return view('productos.create');
    }
    
    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|integer|unique:productos,codigo|min:1',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ], [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.integer' => 'El código debe ser un número entero.',
            'codigo.unique' => 'Ya existe un producto con este código.',
            'codigo.min' => 'El código debe ser mayor a 0.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser negativa.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.'
        ]);
        
        try {
            $producto = new Producto();
            $producto->codigo = (int) $request->codigo;
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->cantidad = (int) $request->cantidad;
            $producto->precio = $request->precio;
            $producto->save();
            
            return redirect()->route('productos.index')
                           ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Error al crear el producto: ' . $e->getMessage())
                           ->withInput();
        }
    }
    
    // Mostrar formulario para editar producto
    public function edit($codigo)
    {
        try {
            $producto = Producto::where('codigo', (int) $codigo)->firstOrFail();
            return view('productos.edit', compact('producto'));
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                           ->with('error', 'Producto no encontrado.');
        }
    }
    
    // Actualizar producto
    public function update(Request $request, $codigo)
    {
        $request->validate([
            'codigo' => 'required|integer|unique:productos,codigo,' . $codigo . ',codigo|min:1',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ], [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.integer' => 'El código debe ser un número entero.',
            'codigo.unique' => 'Ya existe otro producto con este código.',
            'codigo.min' => 'El código debe ser mayor a 0.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser negativa.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.'
        ]);
        
        try {
            $producto = Producto::where('codigo', (int) $codigo)->firstOrFail();
            
            $producto->codigo = (int) $request->codigo;
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->cantidad = (int) $request->cantidad;
            $producto->precio = $request->precio;
            $producto->save();
            
            return redirect()->route('productos.index')
                           ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Error al actualizar el producto: ' . $e->getMessage())
                           ->withInput();
        }
    }
    
    // Eliminar producto
    public function destroy($codigo)
    {
        try {
            DB::beginTransaction();
            
            $producto = Producto::where('codigo', (int) $codigo)->firstOrFail();
            
            // Verificar si el producto tiene ventas registradas
            if ($producto->tieneVentas()) {
                DB::rollBack();
                return redirect()->route('productos.index')
                               ->with('error', 'No se puede eliminar el producto porque tiene ventas registradas.');
            }
            
            $producto->delete();
            DB::commit();
            
            return redirect()->route('productos.index')
                           ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            return redirect()->route('productos.index')
                           ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}