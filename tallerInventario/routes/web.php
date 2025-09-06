<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;

// Ruta principal - redirige al menú
Route::get('/', function () {
    return redirect()->route('menu');
});

// Ruta del menú principal
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

// Rutas para productos
Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
    Route::get('/{codigo}/edit', [ProductoController::class, 'edit'])->name('edit');
    Route::put('/{codigo}', [ProductoController::class, 'update'])->name('update');
    Route::delete('/{codigo}', [ProductoController::class, 'destroy'])->name('destroy');
});

// Rutas para ventas
Route::prefix('ventas')->name('ventas.')->group(function () {
    Route::get('/', [VentaController::class, 'index'])->name('index');
    Route::get('/create', [VentaController::class, 'create'])->name('create');
    Route::post('/', [VentaController::class, 'store'])->name('store');
});