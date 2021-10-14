<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nombre', 'precio','estado'] ;

    public function detalleventas(){
        return $this->hasMany(DetalleVenta::class, 'id_producto');
    }

    public function insumos(){
        return $this->belongsToMany(Insumo::class, 'insumoproducto','id_producto','id_insumo');
        
    }
}
