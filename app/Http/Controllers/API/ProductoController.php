<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

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
        $producto = new Producto;
        $producto->producto = $request->producto;
        $producto->cantidad = $request->cantidad;

        if($producto)
            return response()->json(["Producto Creado Satisfactoriamente" => $producto],201);
        return response()->json(null,400);
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
