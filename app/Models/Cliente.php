<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','apellidos','numerodocumento','tipodocumento','estado','correo','edad','parentesco','genero'];

    public function ventas(){
        return $this->hasMany(Venta::class, 'id');
    }
}
