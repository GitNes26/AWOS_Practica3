<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; //reafirmamos que este modelo esta casado con la tabla "productos"

    public function comentarios(){
        return $this->hasMany('App\Models\Comentario');
        // Esta tabla 'productos(Producto)' TIENE UNA RELACION con la tabla 'comentarios(Comentario)'
    }
}
