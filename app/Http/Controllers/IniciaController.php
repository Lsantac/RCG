<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{
    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

           $mens = DB::table('mensagens_trans')
             ->where('id_part',$id_logado)
             ->selectRaw('COUNT(id_part) as qt_mens,id_part,id_trans')
             ->groupBy('id_part','id_trans')
             ->havingRaw('COUNT(id_part) = ?', [1])
             ->get();

            $num_mens_unica = $mens->count();

             /*dd($num_mens_unica);*/

             return view('home',['num_mens_unica' => $num_mens_unica]);

    }
}
