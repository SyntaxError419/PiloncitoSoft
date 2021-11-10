<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fechaestado extends Model
{
    use HasFactory;

    protected $fillable = ['id_venta', 'estado', 'fecha'];

    public function ventas(){
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
