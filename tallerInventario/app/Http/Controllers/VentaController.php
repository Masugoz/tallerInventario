<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $productos = Producto::where('cantidad', '>', 0)->get();
        return view('ventas.create', compact('productos'));
    }
    
    // Registrar nueva venta
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:productos,codigo',
            'cantidad_vendida' => 'required|integer|min:1'
        ]);

        try {
            // ⚡ Forzar el código a string
            $codigo = strval($request->input('product_id'));

            // ⚡ Buscar producto como string
            $producto = Producto::where('codigo', $codigo)->firstOrFail();

            // Verificar stock disponible
            if ($request->cantidad_vendida > $producto->cantidad) {
                return redirect()->back()
                    ->with('error', 'Stock insuficiente. Disponible: ' . $producto->cantidad)
                    ->withInput();
            }

            // Calcular total
            $total = $request->cantidad_vendida * $producto->precio;

            // ⚡ Transacción segura
            DB::transaction(function () use ($codigo, $request, $producto, $total) {
                // Crear la venta
                Venta::create([
                    'product_id'       => $codigo, // siempre string
                    'cantidad_vendida' => $request->cantidad_vendida,
                    'precio_unitario'  => $producto->precio,
                    'total'            => $total,
                    'fecha'            => now()
                ]);

                // ⚡ Actualizar stock forzando string en el WHERE
                Producto::where('codigo', $codigo)
                    ->update([
                        'cantidad' => DB::raw("cantidad - " . intval($request->cantidad_vendida))
                    ]);
            });

            return redirect()->route('ventas.index')
                ->with('success', 'Venta registrada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al registrar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }
}
