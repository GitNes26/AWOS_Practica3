<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios'; //reafirmamos que este modelo esta casado con la tabla "comentarios"

    public function usuarios(){
        return $this->belongsTo('App\Models\User');
        // Esta tabla 'comentarios(Comentario)' PERTENSE A la tabla 'users(User) 
    }

    public function productos(){
        return $this->belongsTo('App\Models\Producto');
        // Esta tabla 'comentarios(Comentario)' PERTENSE A la tabla 'productos(Producto)'

    }
}