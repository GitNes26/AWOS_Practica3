<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illumainate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registro(Request $request){

        $request->validate([
            'nombre'=>'required',
            'correo'=>'required|email',
            'contrasena'=>'required'
        ]);
        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->correo;
        $usuario->password = Hash::make($request->contrasena);

        if($usuario->save())
            return response()->json(["Usuario Registrado"=>$usuario],200);
        return abort(422, "Fallo al insertar.");
    }

    public function logIn(Request $request){
        $request->validate([
            'correo'=>'required|email',
            'contrasena'=>'required'
        ]);

        $usuario = User::where('email',$request->correo)->first();

        if(!$usuario || !Hash::check($request->contrasena, $usuario->password)){
            throw ValidationException::withMessages([
                'email|password' => ['Correo o Contraseña Incorrecta']
            ]);
        }

        if($usuario->id == 1){
            $token = $usuario->createToken($request->correo,['admin:admin'])->plainTextToken;
            
            return response()->json(['token de Administrador otorgado:' => $token],201);
        }

        if($usuario->id > 1){
            $token = $usuario->createToken($request->correo,['user:user'])->plainTextToken;

            return response()->json(['token de usuario' => $token],201);
        }
    }

    public function index(Request $request){
        if($request->user()->tokenCan('admin:admin'))
            return response()->json(['USUARIOS' => User::all()],200);

        if($request->user()->tokenCan('user:user'))
            return response()->json(['Mi Perfil' => $request->user()],200);

        abort(401, "Scope invalido");
    }

    public function logOut(Request $request){
        return response()->json(["Tokens eliminados"=>$request->user()->tokens()->delete()],200);
    }

    public function otorgarPermiso(Request $request){
        if($request->user()->tokenCan('admin:admin'))
        {
            $request->validate(['correo'=>'required|email']);            
        }
        
        $usuario = User::where('email', $request->correo)->first();
            
        if(!$usuario)
        {
            throw validationException::withMessages([
                'email'=>['Correo Incorrecto']
            ]);
        }
        if($request->perimso == "user:user" || $request->perimso == "user:info" || $request->perimso == "admin:admin"){
            $token = $usuario->createToken($request->correo,[$request->permiso])->plainTextToken;
            return response()->json(["Token" => $token],201);
        }
        return response()->json("No existe este permiso.",400);
    }
}
