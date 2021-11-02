<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Detallecompra extends Model
{
    use HasFactory;
    protected $fillable =[
        'id_compra',
        'id_insumo',        
        'cantidad',        
        'precio_unitario',        
        'precio_total',
        'iva',
        'subtotal'
    ];

   /*  public function compras(){
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function insumos(){
        return $this->hasMany(Insumo::class, 'id_insumo');   
    } */

   /*  public function func(){
        return $this->hasManyThrough(Insumo::class, 'id_insumo');   
    } */
    
}
