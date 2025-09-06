<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Venta extends Model
{
    use HasFactory;
    
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    public $incrementing = true; // ID es SERIAL (autoincremental)
    protected $keyType = 'int';
    public $timestamps = false; // Sin timestamps de Laravel
    
    protected $fillable = [
        'product_id',
        'cantidad_vendida',
        'precio_unitario',
        'total',
        'fecha'
    ];
    
    protected $casts = [
        'product_id' => 'integer',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'cantidad_vendida' => 'integer',
        'fecha' => 'datetime'
    ];
    
    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id', 'codigo');
    }
}