<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compra extends Model
{
    use HasFactory;
    protected $fillable =[
        'numReciboCompra',
        'fecha',    
        'id_proveedor',
        'totalcompra'   

    ];
    
    public function detallecompra($id,$id_insumo,$cantidad){
     Detallecompra::where('id_compra', $id)->where('id_insumo', $id_insumo)
     ->update(['cantidad' => $cantidad]);
    }
    
    public function proveedores(){
        return $this->belongsTo(Proveedores::class, 'id_proveedor');
    }

    public function insumos(){
        return $this->belongsToMany(Insumo::class, 'detallecompras','id_compra','id_insumo');
    }

    

}
