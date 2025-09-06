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
        $productos = Producto::all();
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
            'codigo' => 'required|unique:productos,codigo|max:20',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ]);
        
        try {
            // Asegurar que el código sea string
            $data = $request->all();
            $data['codigo'] = (string) $data['codigo'];
            
            Producto::create($data);
            
            return redirect()->route('productos.index')
                            ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear producto: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Error al crear el producto.')
                            ->withInput();
        }
    }
         
    // Mostrar formulario para editar producto
    public function edit($codigo)
    {
        $producto = Producto::where('codigo', (string) $codigo)->firstOrFail();
        return view('productos.edit', compact('producto'));
    }
         
    // Actualizar producto
    public function update(Request $request, $codigo)
    {
        $request->validate([
            'codigo' => 'required|max:20|unique:productos,codigo,' . $codigo . ',codigo',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ]);
        
        try {
            $producto = Producto::where('codigo', (string) $codigo)->firstOrFail();
            
            // Asegurar que el código sea string
            $data = $request->all();
            $data['codigo'] = (string) $data['codigo'];
            
            $producto->update($data);
            
            return redirect()->route('productos.index')
                            ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar producto: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'Error al actualizar el producto.')
                            ->withInput();
        }
    }
         
    // Eliminar producto
    public function destroy($codigo)
    {
        try {
            DB::beginTransaction();
            
            $producto = Producto::where('codigo', (string) $codigo)->firstOrFail();
            
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
                            ->with('error', 'Error al eliminar el producto.');
        }
    }
}