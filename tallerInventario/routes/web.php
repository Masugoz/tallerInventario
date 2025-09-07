<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal que redirige al menú
Route::get('/', function () {
    return redirect('/menu');
});

// Ruta del menú principal
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

// Rutas para productos (Resource Controller)
Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{codigo}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{codigo}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{codigo}', [ProductoController::class, 'destroy'])->name('destroy');
});

// Rutas para ventas (Resource Controller)
Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/', [VentaController::class, 'index'])->name('index');
    Route::get('/create', [VentaController::class, 'create'])->name('create');
    Route::post('/', [VentaController::class, 'store'])->name('store');
});

// Rutas adicionales para casos específicos
Route::fallback(function () {
    return redirect('/menu')->with('error', 'Página no encontrada. Redirigido al menú principal.');
});

// Ruta de prueba para debug
Route::get('/test-debug', function() {
    $productos = \App\Models\Producto::all();
    return response()->json([
        'productos_count' => $productos->count(),
        'productos' => $productos->toArray()
    ]);
});