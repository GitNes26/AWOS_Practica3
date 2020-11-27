<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Producto;
use App\Models\User;
use App\Mail\CorreoClass;
use App\Mail\CorreoProductoClass;
use App\Mail\CorreoProductoAdminClass;
use App\Mail\CorreoSolicitudPermisoClass;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ProductoController extends Controller
{
    public function index($id=null){
        $producto = Producto::select('id as ID','producto as Producto', 'cantidad as Cantidad')->where('id',$id)->get();
        $productos = Producto::select('id as ID','producto as Producto', 'cantidad as Cantidad')->get();
        
        if($id)
            return response()->json(["Producto".$id => $producto],200);
        return response()->json(["PRODUCTOS" => $productos],200);
    }

    public function crear(Request $request){
        // $producto = Producto::insert([
        //     'producto' => $request->producto,
        //     'cantidad' => $request->cantidad
        // ]);
        if($request->user()->TokenCan('admin:admin') || $request->user()->TokenCan('user:vendedor')){
            $producto = new Producto;
            $producto->producto = $request->producto;
            $producto->cantidad = $request->cantidad;

            $usuario = $request->user()['name'];
            $correo = $request->user()['email'];

            if($producto->save()){
                $todo = [
                    'usuario'=>$usuario,
                    'correo'=> $correo,
                    'producto'=> $producto->producto,
                    'cantidad'=> $producto->cantidad
                ];
                $enviarCorreoAdmin = Mail::to('19170068@uttcampus.edu.mx')->send(new CorreoProductoAdminClass($todo));
                $enviarCorreoVendedor = Mail::to($todo['correo'])->send(new CorreoProductoClass($todo));

                return response()->json(["Producto Creado Satisfactoriamente" => $producto],201);
            }
        }
        else{
            // $usuario = $request->user($usuario->name);
            // $correo = $request->user($usuario->email);

            $enviarCorreoAdmin = Mail::to('19170068@uttcampus.edu.mx')->send(new CorreoSolicitudPermisoClass($todo));

            return response()->json("No tienes permisos para registrar productos. Se ha enviado un correo para solicitar permiso.",400);
        }
    }

    public function editar($id, Request $request){
        $producto = Producto::find($id);
        $producto->producto = $request->get('producto');
        $producto->cantidad = $request->get('cantidad');

        if($producto->save())
            return response()->json(["El producto ".$id." fue editado satisfactoriamente." => $producto],202);
        return response()->json("El producto ".$id. "no se pudo editar.", 400);
    }

    public function eliminar($id){
        $producto = Producto::where('id',$id)->delete();

        if($producto)
            return response()->json("El producto ".$id." fue eliminado.",200);
        return response()->json("no se encontro el producto ".$id.". Posiblemente no exista",404);
    }
}
