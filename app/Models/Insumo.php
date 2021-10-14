<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    public function productos(){
        return $this->belongsToMany(Producto::class, 'detallecompra','id_insumo','id_producto');
        
    }

    public function Insumoproductos(){
        return $this->belongsToMany(Insumoproductos::class, 'insumo_producto');
        
    }
}
