<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    // Mostrar lista de ventas
    public function index()
    {
        $ventas = Venta::with('producto')
                      ->orderBy('fecha', 'desc')
                      ->get();
        
        return view('ventas.index', compact('ventas'));
    }
    
    // Mostrar formulario para registrar venta
    public function create()
    {
        $productos = Producto::where('cantidad', '>', 0)
                            ->orderBy('nombre', 'asc')
                            ->get();
        return view('ventas.create', compact('productos'));
    }
    
    // Registrar nueva venta
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:productos,codigo',
            'cantidad_vendida' => 'required|integer|min:1'
        ], [
            'product_id.required' => 'Debe seleccionar un producto.',
            'product_id.integer' => 'El producto seleccionado no es válido.',
            'product_id.exists' => 'El producto seleccionado no existe.',
            'cantidad_vendida.required' => 'La cantidad a vender es obligatoria.',
            'cantidad_vendida.integer' => 'La cantidad debe ser un número entero.',
            'cantidad_vendida.min' => 'La cantidad debe ser mayor a 0.'
        ]);

        try {
            DB::beginTransaction();
            
            // Obtener el producto
            $codigo = (int) $request->product_id;
            $producto = Producto::where('codigo', $codigo)->lockForUpdate()->firstOrFail();

            // Verificar stock disponible
            if ($request->cantidad_vendida > $producto->cantidad) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stock insuficiente. Stock disponible: ' . $producto->cantidad . ' unidades.')
                    ->withInput();
            }

            // Calcular total
            $total = $request->cantidad_vendida * $producto->precio;

            // Crear la venta
            $venta = new Venta();
            $venta->product_id = $codigo;
            $venta->cantidad_vendida = (int) $request->cantidad_vendida;
            $venta->precio_unitario = $producto->precio;
            $venta->total = $total;
            $venta->fecha = now();
            $venta->save();

            // Actualizar stock del producto
            $producto->cantidad = $producto->cantidad - $request->cantidad_vendida;
            $producto->save();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta registrada exitosamente. Total: $' . number_format($total, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar venta: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al registrar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }
}