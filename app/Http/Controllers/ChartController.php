<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function ChartStatus($id_part,$id_rede){
 
        $stat_of = DB::table('participantes')->where('participantes.id',$id_part)
                                             ->where(function($query) use($id_rede){
                                                  if($id_rede > 0){ 
                                                     $query->where('redesparts.id_rede','=',$id_rede)
                                                           ->join('redesparts','participantes.id','=','redesparts.id_part'); 
                                                  }
                                             })

                                             ->join('ofertas_part','participantes.id','=','ofertas_part.id_part')
                                             ->join('transacoes','ofertas_part.id_of','=','transacoes.id_of_part')

                                             ->groupBy('id_st_trans')
                                             
                                             ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                             ->get()
                                             ;

       
        /*dd($stat_of);*/

        $num_itens =count($stat_of);
        $total = 0;
        foreach ($stat_of as $val) {
            $total += $val->qt_status;
        } 

        $i = 0;

        $data="[";
        foreach ($stat_of as $val) {
            /*$data .= ($val->qt_status/$total)*100;*/
            $data .= $val->qt_status;
            if(++$i < $num_itens){
              $data .= ","  ;
            }
            
        }

        $data.="],";

        /*dd($data);*/

        return view('charts.chart_status',['data'=>$data]);

        

    }

}
