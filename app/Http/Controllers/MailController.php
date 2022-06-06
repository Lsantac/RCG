<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class MailController extends Controller
{
    public function SendEmail(){

        $details = [
            'title' => 'Olá participante da Rede Colaborativa Global !',
            'body' => 'Essa mensagem é para voce poder resetar sua senha, clique no link abaixo.',
            
        ];

        /*Mail :: send('emails.testmail', $details, function($message){
            $message->to('lsantac@gmail.com');
            $message->subject('Hello World');
            }
             
        );*/

        Mail::to("lsantac@gmail.com")->send(new \App\Mail\SendMail($details));
        return "Email Sent";

    }  

}
