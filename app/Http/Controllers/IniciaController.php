<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{
    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

           /*Transações com mensagens unicas */

           $mens_unica_of = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->where('of_nec_tr','of')
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) = ?', [1])
             ->get();

           $mens_unica_tr = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->where('of_nec_tr','tr')
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) = ?', [1])
             ->get();

            $num_mens_of_unica = $mens_unica_of->count();
            $num_mens_tr_unica = $mens_unica_tr->count();
            $num_mens_unica = $num_mens_of_unica + $num_mens_tr_unica;

            /*Transações com mais de uma mensagem - Em Andamento */

            $mens_anda_of = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->where('of_nec_tr','of')
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) > ?', [1])
             ->get();

           $mens_anda_tr = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->where('of_nec_tr','tr')
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) > ?', [1])
             ->get();

             $num_mens_of_anda = $mens_anda_of->count();
             $num_mens_tr_anda = $mens_anda_tr->count();
             $num_mens_anda = $num_mens_of_anda + $num_mens_tr_anda;

             return view('home',[
                         'num_mens_unica' => $num_mens_unica,
                         'num_mens_anda' => $num_mens_anda

                        ]);

    }
}