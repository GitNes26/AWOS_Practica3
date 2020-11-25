<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class VerificarCantidad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $producto = DB::table('productos')->select('producto', 'cantidad')->where('id',$request->id)->get();

        foreach ($producto as $key => $value) {
            if($value->cantidad > 0)
                return response()->json(["El producto '".$value->producto."' no se puede eliminar porque aun hay en existencia"],300);
        }
        return $next($request);
    }
}
