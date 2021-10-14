<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumoproducto extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_insumo',
        'id_producto',        
        'cantidad',        
              
    ];

    
    public function productos(){
        return $this->belongsTo(productos::class, 'id_producto');
    }

    public function insumos(){
        return $this->belongsTo(insumos::class, 'id_insumo');
    }
}
