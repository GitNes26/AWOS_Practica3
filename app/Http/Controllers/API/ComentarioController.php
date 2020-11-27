<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ComentarioController extends Controller
{
    public function index($id=null){
        $comentarios = Comentario::join('users','comentarios.usuario_id','users.id')->join('productos','comentarios.producto_id','productos.id')->select('comentarios.id as ID','comentario as Comentario','name as Usuario','producto as Producto')->orderBy('comentarios.id')->get();
        $comentario = Comentario::join('users','comentarios.usuario_id','users.id')->join('productos','comentarios.producto_id','productos.id')->select('comentarios.id as ID','comentario as Comentario','name as Usuario','producto as Producto')->where('comentarios.id',$id)->get();

        if($id)
            return response()->json(["Comentario ".$id => $comentario],200);
        return response()->json(["COMENTARIOS:" => $comentarios],200);
    }

    public function crear(Request $request){
            $comentario = new Comentario;
            $comentario->comentario = $request->comentario;
            $comentario->usuario_id = $request->ID_usuario;
            $comentario->producto_id = $request->ID_producto;

            if($comentario->save()){
                $consulta = Comentario::join('users','comentarios.usuario_id','users.id')->join('productos','comentarios.producto_id','productos.id')->select('comentario as Comentario','email as Correo','producto as Producto', 'vendedor_id as Vendedor')->where('users.id',$request->ID_usuario)->orderByDesc('comentarios.id')->limit(1)->get();
                // return response()->json(["Comentario publicado exitosamente" => $comentario],201);

                $todo = [
                    'usuario'=>$consulta->Comentario,
                    'correo'=> $consulta->correo,
                    'producto'=> $consulta->producto,
                ];
                $enviarCorreoVendedor = Mail::to('19170068@uttcampus.edu.mx')->send(new CorreoProductoAdminClass($todo));
                $enviarCorreoUsuario = Mail::to($todo['correo'])->send(new CorreoProductoClass($todo));

                return response()->json(["Comentario publicado exitosamente" => $usuario],201);

            }
        return response()->json("No se ha podido publicar tu comentario, revisa tus datos.",400);
    }

    public function editar($id, Request $request){
        $comentario = Comentario::find($id);
        $comentario->comentario = $request->get('comentario');
        $comentario->usuario_id = $request->get('ID_usuario');
        $comentario->producto_id = $request->get('ID_producto');

        if($comentario->save())
            return response()->json(["El comentario ".$id." fue editado." => $comentario],202);
        return response()->json("El comentario ".$id." no pudo editarse, verifica tus datos",400);
    }

    public function eliminar($id){
        $comentario = Comentario::where('id',$id)->delete();

        if($comentario)
            return response()->json("El comentario ".$id." fue elminado.",200);
        return response()->json("El comentario ".$id." no se encontro.",404);
    }

    //Busquedas avanzadas
    public function comentariosUsuario($id){
        $comentarios = Comentario::join('users','comentarios.usuario_id','users.id')->join('productos','comentarios.producto_id','productos.id')->select('comentarios.id as ID','comentario as Comentario','producto as Producto')->where('users.id',$id)->get();
        
        $usuario = DB::table('users')->select('name')->where('id',$id)->get();

        if($id)
            return response()->json(["Comentarios de ".$usuario.":" => $comentarios],200);
        return response()->json("Usuario ".$id." no encontrado",404);
    }

    public function comentariosProducto($id){
        $comentarios = Comentario::join('users','comentarios.usuario_id','users.id')->join('productos','comentarios.producto_id','productos.id')->select('comentarios.id as ID','comentario as Comentario','name as Usuario')->where('productos.id',$id)->get();

        $producto = DB::table('productos')->select('producto')->where('id',$id)->get();

        if($id)
            return response()->json(["Comentarios sobre ".$producto.":" => $comentarios],200);
        return response()->json("El producto ".$id." no ha sido encontrado.",400);
    }
}
