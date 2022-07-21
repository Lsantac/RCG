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

    public function send_email_mailer() {
        $to      = 'lsantac@gmail.com';
        $subject = 'Teste de email pelo LARAVEL';
        $message = "Testando de Email pelo LARAVEL";
        $headers = 'From: lsantac@gmail.com'       . "\r\n" .
                    'Reply-To: lsantac@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                    ini_set("SMTP","localhost");
                    ini_set("smtp_port","25");
                    ini_set("sendmail_from","lsantac.redecolaborativa@gmail.com");
                    ini_set("sendmail_path", "C:\wamp\bin\sendmail.exe -t");                    

        mail($to, $subject, $message, $headers);

        return "Email enviado com sucesso!";
    }

}
