<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'cantidad_vendida',
        'precio_unitario',
        'total',
        'fecha'
    ];
    
    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'cantidad_vendida' => 'integer'
        // Removemos el cast de fecha para evitar conflictos
    ];
    
    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id', 'codigo');
    }
    
    // Accessor para formatear fecha en las vistas
    public function getFechaAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }
}