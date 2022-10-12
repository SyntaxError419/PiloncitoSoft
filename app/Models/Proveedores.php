<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    
    use HasFactory;

    protected $fillable = ['estado'] ;

    public function compras(){
        return $this->hasMany(Compra::class, 'id');
        }
}