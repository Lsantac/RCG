<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class MailController extends Controller
{
    public function SendEmail($email){

        $ident = DB::table('identidade')->first();
        $nome_ident = $ident->nome_ident;

        $details = [
            'title' => 'Olá '.$email.' da '. $nome_ident .' !',
            'body' => 'Essa mensagem é para voce poder resetar sua senha, clique no link abaixo. Seja Bem Vindo a '. $nome_ident.' !',
           
            
        ];

        /*dd($email);*/
        /*dd($details);*/

        Mail::to($email)->send(new \App\Mail\SendMail($details),['html' => 'email.EnviarMail']);

        /*return "Email enviado para ".$email;*/

        return view('emails.EnviarMail',['details' => $details]);
        

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
