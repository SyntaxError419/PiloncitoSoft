<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{

    use HasFactory;
    protected $fillable=[
        'id' ,
        'descripcion',
        'id_menu' ,
        'url' ,
        'metodo' ,
        'igualdad' ,
        'estado' ,

    ];
}
