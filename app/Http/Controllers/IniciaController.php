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
            ->where('id_part','=',$id_logado)
            ->where('status','=',2)
            ->count(); 

            $num_mens_anda_nec = DB::table('necessidades_part')
            ->where('id_part','=',$id_logado)
            ->where('status','=',2)
            ->count(); 

             /* Ofertas parcialmente finalizadas*/
             $num_ofp_parc = DB::table('ofertas_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',3)
             ->count(); 
             
             $num_nec_parc = DB::table('necessidades_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',3)
             ->count();

             /* Ofertas totalmente finalizadas*/
             $num_ofp_final = DB::table('ofertas_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',4)
             ->count();                 

             $num_nec_final = DB::table('necessidades_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',4)
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

    public function cons_trans_ofertas_part($status,$id_logado,Request $request){

        /*$id_logado = Session('id_logado');*/

        /*dd($status." ".$id_logado);*/

        /*$of_part_1 =DB::table('ofertas_part_1')
        ->select('*')
        ->first();*/

        /*dd($of_part_1);*/

        $of_status = DB::table('ofertas_part')
        ->where('ofertas_part.id_part','=',$id_logado)
        ->where('ofertas_part.status','=',$status)
        
        ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_part')
        ->leftjoin('moedas','transacoes.id_moeda','moedas.id')

        ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
        ->leftjoin('necessidades','necessidades_part.id_nec','necessidades.id')

        ->leftJoin('ofertas_part_1','transacoes.id_of_tr_part','=','ofertas_part_1.id')
        ->leftjoin('ofertas','ofertas_part.id_of','ofertas.id')
        ->leftjoin('ofertas_1','ofertas_part_1.id_of','ofertas_1.id')
        
        ->leftjoin('categorias','ofertas.id_cat','categorias.id')
        ->leftjoin('categorias_1','ofertas_1.id_cat','categorias_1.id')
        ->leftjoin('categorias_2','necessidades.id_cat','categorias_2.id')
        
        ->leftjoin('participantes','ofertas_part.id_part','participantes.id')  
        ->leftjoin('participantes_1','ofertas_part_1.id_part','participantes_1.id')
        ->leftjoin('participantes_2','necessidades_part.id_part','participantes_2.id')
        
        ->select('ofertas_part.id as id_of','ofertas_part.id_part as id_partic_ofertas','ofertas_part.status as status_of',
         'ofertas_part.obs as obs_of','necessidades_part.obs as obs_nec','ofertas_part_1.obs as obs_of_tr',
         'transacoes.id_of_part as id_of_part','moedas.desc_moeda as fluxo',
         'transacoes.id as id_trans','transacoes.id_nec_part as id_nec_part','transacoes.id_of_tr_part as id_of_tr_part',
         'transacoes.quant_of as quant_of','transacoes.quant_nec as quant_nec','transacoes.quant_of_tr as quant_of_tr',
         'transacoes.id_st_trans as id_st_trans','transacoes.quant_moeda as quant_moeda','transacoes.id_moeda as id_moeda',
         'transacoes.data_inic as data_inic','transacoes.data_final_nec_part as data_final_nec_part','transacoes.data_final_of_part as data_final_of_part',
         'transacoes.data_final_of_tr_part as data_final_of_tr_part',
         'ofertas.descricao as desc_of','categorias.descricao as desc_cat_of',
         'ofertas_1.descricao as desc_of_tr','categorias_1.descricao as desc_cat_of_tr',
         'necessidades.descricao as desc_nec','categorias_2.descricao as desc_cat_nec',
         'participantes.nome_part as nome_part_of','participantes_1.nome_part as nome_part_of_tr',
         'participantes_2.nome_part as nome_part_nec'
         )

        ->orderBy('data_inic','desc')
        ->paginate(5);
        $of_status->appends($request->all());

        /*->get();
        dd($of_status);*/

        return view('cons_trans_ofertas_part',['of_status'=>$of_status]);
        
    }    
}
