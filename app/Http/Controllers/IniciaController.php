<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{
    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

            /*Transações com alguma mensagem - Em Andamento */

            $num_mens_anda_of_tr = DB::table('ofertas_part')
            ->where('id_part',$id_logado)
            ->where('status',2)
            ->count(); 

            $num_mens_anda_nec = DB::table('necessidades_part')
            ->where('id_part',$id_logado)
            ->where('status',2)
            ->count(); 

             /* Ofertas parcialmente finalizadas*/
             $num_ofp_parc = DB::table('ofertas_part')
             ->where('id_part',$id_logado)
             ->where('status',3)
             ->count(); 
             
             $num_nec_parc = DB::table('necessidades_part')
             ->where('id_part',$id_logado)
             ->where('status',3)
             ->count();

             /* Ofertas totalmente finalizadas*/
             $num_ofp_final = DB::table('ofertas_part')
             ->where('id_part',$id_logado)
             ->where('status',4)
             ->count();                 

             $num_nec_final = DB::table('necessidades_part')
             ->where('id_part',$id_logado)
             ->where('status',4)
             ->count();                 

             return view('home',[
                         'num_mens_anda_of_tr' => $num_mens_anda_of_tr,
                         'num_mens_anda_nec' => $num_mens_anda_nec,
                         'num_ofp_parc' => $num_ofp_parc,
                         'num_ofp_final' => $num_ofp_final,
                         'num_nec_parc' => $num_nec_parc,
                         'num_nec_final' => $num_nec_final
                         ]);

    }
}
