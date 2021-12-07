<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{
    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

           /*Transações com mensagens unicas Ofertas e trocas */

           $mens_unica_of_tr = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->Where(function($query) {
              $query->where('of_nec_tr','of')
                    ->orwhere('of_nec_tr','tr');
              })

             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) = ?', [1])
             ->get();

            $num_mens_unica_of_tr = $mens_unica_of_tr->count();

            /*Transações com mensagens unicas Necessidades */

            $mens_unica_nec = DB::table('mensagens_trans')
            ->where('id_part',$id_logado)
            ->where('of_nec_tr','nec')
            ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
            ->groupBy('id_part','id_trans')
            ->havingRaw('COUNT(id_part) = ?', [1])
            ->get();

            $num_mens_unica_nec = $mens_unica_nec->count();

            /*Transações com mais de uma mensagem - Em Andamento */

            $mens_anda_of_tr = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->Where(function($query) {
              $query->where('of_nec_tr','of')
                    ->orwhere('of_nec_tr','tr');
              })
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) > ?', [1])
             ->get();

             $num_mens_anda_of_tr = $mens_anda_of_tr->count();

             $mens_anda_nec = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->where('of_nec_tr','nec')
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) > ?', [1])
             ->get();

             $num_mens_anda_nec = $mens_anda_nec->count();

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
                         'num_mens_unica_of_tr' => $num_mens_unica_of_tr,
                         'num_mens_unica_nec' => $num_mens_unica_nec,
                         'num_mens_anda_of_tr' => $num_mens_anda_of_tr,
                         'num_mens_anda_nec' => $num_mens_anda_nec,
                         'num_ofp_parc' => $num_ofp_parc,
                         'num_ofp_final' => $num_ofp_final,
                         'num_nec_parc' => $num_ofp_parc,
                         'num_nec_final' => $num_ofp_final
                         ]);

    }
}
