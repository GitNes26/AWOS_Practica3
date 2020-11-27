<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Producto extends Model
{
    use Notifiable, HasApiTokens;
    
    protected $table = 'productos'; //reafirmamos que este modelo esta casado con la tabla "productos"

    public function comentarios(){
        return $this->hasMany('App\Models\Comentario');
        // Esta tabla 'productos(Producto)' TIENE UNA RELACION con la tabla 'comentarios(Comentario)'
    }

    public function usuarios(){
        return$this->belongsTo('App\Models\User');
        // Esta tabla 'productos(Producto)' PERTENECE a la tabla 'users(User)'
    }
}
