<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['estado', 'pago', 'cancelado'] ;

    public function detalleventa($id,$id_producto,$cantidad){
        Detalleventa::where('id_venta', $id)->where('id_producto', $id_producto)
        ->update(['cantidad' => $cantidad]);
    }
    public function clientes(){
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function productos(){
        return $this->belongsToMany(Producto::class, 'detalleventas', 'id_venta', 'id_producto');   
    }

}