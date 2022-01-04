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

    public function trans_anda_ofertas_part(request $request){

        $id_logado = Session('id_logado');

        /*$of_part_1 =DB::table('ofertas_part_1')
        ->select('*')
        ->first();*/

        /*dd($of_part_1);*/

        $of_st_2 = DB::table('ofertas_part')
        ->where('ofertas_part.status',2)
        ->where('ofertas_part.id_part',$id_logado)

        ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_part')
        ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
        ->leftJoin('ofertas_part_1','transacoes.id_of_tr_part','=','ofertas_part_1.id')
        ->leftjoin('ofertas','ofertas_part.id_of','ofertas.id')
        ->leftjoin('necessidades','transacoes.id_nec_part','necessidades.id')
        ->leftjoin('ofertas_1','transacoes.id_of_tr_part','ofertas_1.id')
        ->leftjoin('categorias','ofertas.id_cat','categorias.id')
        ->leftjoin('categorias_1','ofertas_1.id_cat','categorias_1.id')
        ->leftjoin('participantes','ofertas_part.id_part','participantes.id')  
        ->leftjoin('participantes_1','ofertas_part_1.id_part','participantes_1.id')  

        ->select('ofertas_part.id as id_of','ofertas_part.id_part as id_partic_ofertas','ofertas_part.status as status_of',
         'transacoes.id_of_part as id_of_part',
         'transacoes.id as id_trans','transacoes.id_nec_part as id_nec_part','transacoes.id_of_tr_part as id_of_tr_part',
         'transacoes.quant_of as quant_of','transacoes.quant_nec as quant_nec','transacoes.quant_of_tr as quant_of_tr',
         'transacoes.id_st_trans as id_st_trans','transacoes.quant_moeda as quant_moeda','transacoes.id_moeda as id_moeda',
         'transacoes.data_inic as data_inic','transacoes.data_final_nec_part as data_final_nec_part','transacoes.data_final_of_part as data_final_of_part',
         'transacoes.data_final_of_tr_part as data_final_of_tr_part',
         'ofertas.descricao as desc_of','categorias.descricao as descr_cat_of',
         'ofertas_1.descricao as desc_of_tr','categorias_1.descricao as descr_cat_of_tr',
         )


        ->first();

        dd($of_st_2);
        

    }    
}
