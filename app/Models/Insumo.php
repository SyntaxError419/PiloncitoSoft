<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Insumo extends Model
{
    use HasFactory;

    protected $fillable = ['estado',
    'nombre_insumo',
    'cantidad'
];

    public function compras(){
        return $this->belongsToMany(Compra::class, 'detallecompras','id_insumo','id_compra' );
        }

            
        public function detallecompra(){
            return $this->hasMany(Detallecompra::class, 'id_insumo');   
        } 
        
}
