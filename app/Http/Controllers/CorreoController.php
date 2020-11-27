<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CorreoClass;
use \Mailjet\Resources;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class CorreoController extends Controller
{
    public function enviarCorreo(){
        $datosEnvio = Mail::to('19170068@utt.edu.mx')->send(new CorreoClass());
        return response()->json(["Correo Enviado Exitosamente!" => $datosEnvio],200);
    }
}
