<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoClass extends Mailable
{
    use Queueable, SerializesModels;

    public $todo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todo)
    {
        $this->todo = $todo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('19170068@uttcampus.edu.mx')
                    ->view('Ejemplo');
        // switch($todo['vista']){
        //     case "registro":
        //         return $this->from('19170068@uttcampus.edu.mx')
        //                     ->view('Ejemplo');
        //     break;

        //     case "producto":
        //         return $this->from('19170068@uttcampus.edu.mx')
        //                     ->view('NotificarProductoAdmin');
        //     break;
        // }
    }
}
