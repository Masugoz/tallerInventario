<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('producto')->orderBy('fecha', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }
    
    public function create()
    {
        $productos = Producto::where('cantidad', '>', 0)->get();
        return view('ventas.create', compact('productos'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'cantidad_vendida' => 'required|integer|min:1'
        ]);

        $producto = Producto::where('codigo', $request->product_id)->first();
        
        if ($request->cantidad_vendida > $producto->cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente');
        }

        $venta = new Venta();
        $venta->product_id = $request->product_id;
        $venta->cantidad_vendida = $request->cantidad_vendida;
        $venta->precio_unitario = $producto->precio;
        $venta->total = $request->cantidad_vendida * $producto->precio;
        $venta->fecha = now();
        $venta->save();

        $producto->cantidad -= $request->cantidad_vendida;
        $producto->save();

        return redirect()->route('ventas.index');
    }
}