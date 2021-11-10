<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolemenu extends Model
{
    use HasFactory;
    protected $fillable=[
        'id' ,
        'id_rol',
        'id_menu' ,
    ];
    protected $table='rolemenu';
}
