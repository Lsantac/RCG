<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;
use PHPUnit\TextUI\XmlConfiguration\GroupCollection;

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
                                             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')

                                             ->groupBy('id_st_trans')
                                             ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                             
                                             ;

       
        /*dd($stat_of);*/

        $stat_of_tr = DB::table('participantes')->where('participantes.id',$id_part)
                                                ->where(function($query) use($id_rede){
                                                  if($id_rede > 0){ 
                                                     $query->where('redesparts.id_rede','=',$id_rede)
                                                           ->join('redesparts','participantes.id','=','redesparts.id_part'); 
                                                  }
                                             })

                                             ->join('ofertas_part','participantes.id','=','ofertas_part.id_part')
                                             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')

                                             ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                             ->groupBy('id_st_trans')
                                             ->union($stat_of)
                                             ->get()
                                             ;

        
        /*dd($stat_of_tr);*/

        $num_itens_of_tr =count($stat_of_tr);

        $i = 0;
        $id_ant = 0;
        $total_qt_st = 0;

        $data="[";
        foreach ($stat_of_tr as $val) {
            
            if($id_ant == $val->id_st_trans){
                $total_qt_st += $val->qt_status;
            }else{

                if($total_qt_st > 0){
                    $data .= $total_qt_st;
                }else{
                    $data .= $val->qt_status;
                }
                
                $total_qt_st = $val->qt_status;
                
            }

            if(++$i < $num_itens_of_tr){
                if($id_ant <> $val->id_st_trans){
                  $data .= ","  ;
                }  

            $id_ant = $val->id_st_trans;
            }
        }
        
        $data.="],";

        dd($data);

        return view('charts.chart_status',['data'=>$data]);

        

    }

}
