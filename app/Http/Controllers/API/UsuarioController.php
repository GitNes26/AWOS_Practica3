<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index($id=null){
        $usuario = User::select('id as ID','name as Usuario', 'email as Correo',)->where('id',$id)->get();
        $usuarios = User::select('id as ID', 'name as Usuario', 'email as Correo')->get();

        if($id)
            return response()->json(["Usuario ".$id => $usuario],200);
        return response()->json(["USUARIOS:" => $usuarios],200);
    }

    public function crear(Request $request){
        $usuario = new User;
        $usuario->name = $request->nombre;
        $usuario->email = $request->correo;
        $usuario->email_verified_at = now();
        $usuario->password = Hash::make($request->contrasena);
        $usuario->remember_token = Str::random(10);

        if($usuario->save())
            return response()->json(["Usuario Creado Satisfactoriamente" => $usuario],201);
        return response()->json(null,400);
    }

    public function editar($id, Request $request){
        $usuario = User::find($id);
        $usuario->name = $request->get('nombre');
        $usuario->email = $request->get('correo');
        $usuario->password = $request->get('contrasena');

        if($usuario->save())
            return response()->json(["Usuario ".$id." Editado Satisfactoriamente" => $usuario],200);
        return response()->json(400, "El usuario no se pude editar.");
    }

    public function eliminar($id){
        $usuario = User::where('id', $id)->delete();

        if($usuario)
            return response()->json("El usuario ".$id." fue eliminado.",200);
        return response()->json(["Usuario no encontrado. Es posible que el usuario ".$id." no exista."],404);
    }
}
