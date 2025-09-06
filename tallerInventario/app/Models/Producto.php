<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    
    protected $table = 'productos';
    protected $primaryKey = 'codigo';
    public $incrementing = false; // No es autoincremental
    protected $keyType = 'int'; // Clave primaria es INT
    public $timestamps = false; // Sin timestamps
    
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'cantidad',
        'precio'
    ];
    
    protected $casts = [
        'codigo' => 'integer',
        'precio' => 'decimal:2',
        'cantidad' => 'integer'
    ];
    
    // Relación con ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'product_id', 'codigo');
    }
    
    // Verificar si tiene ventas asociadas
    public function tieneVentas()
    {
        return $this->ventas()->exists();
    }
}