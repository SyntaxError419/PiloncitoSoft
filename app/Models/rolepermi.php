<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolepermi extends Model
{
    use HasFactory;
    protected $fillable=[
        'id' ,
        'id_rol',
        'id_permi' ,
    
    ];
    protected $table='rolepermi';
}
