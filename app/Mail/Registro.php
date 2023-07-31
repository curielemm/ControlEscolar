<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registro extends Mailable
{
    use Queueable, SerializesModels;
   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $var1;
    public function __construct($var)
    {
       $this->var1 = $var; 
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     if($this->var1==0){
        return $this->view('mensaje');
     }else{
         return $this->view('mensaje2');
     }
    }
}
