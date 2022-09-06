<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ChartController extends Controller
{
    public function ChartStatus_part($id_part){

        $redes = DB::table('redesparts')->where('redesparts.id_part',$id_part)
                                        ->join('redes','redesparts.id_rede',"=",'redes.id') 
                                        ->get()
                                        ;

       /* dd($redes);*/

        
        $stat_of = DB::table('participantes')->where('participantes.id',$id_part)

                                                ->join('ofertas_part','participantes.id','=','ofertas_part.id_part')
                                                ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')

                                                ->groupBy('id_st_trans')
                                                ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                                
                                                ;    


        $stat_of_tr = DB::table('participantes')->where('participantes.id',$id_part)
                                               
                                                ->join('ofertas_part','participantes.id','=','ofertas_part.id_part')
                                                ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')

                                                ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                                ->groupBy('id_st_trans')
                                                ->union($stat_of)
                                                ->orderby('id_st_trans')
                                                ->get()
                                                ;

        
        /*dd($stat_of_tr);*/

        $num_itens_of_tr =count($stat_of_tr);
        
        $i = 0;
        $total_qt_st = 0;

        $data="[";
        foreach ($stat_of_tr as $val) {

            if($i <= $num_itens_of_tr-1){
                $pos_current = $stat_of_tr[$i]->id_st_trans;
                if(($i+1) <= $num_itens_of_tr-1){
                    $pos_next = $stat_of_tr[$i+1]->id_st_trans;
                }else{
                    $pos_next = 0;
                }
            }
        
            if($pos_current == $pos_next){
                $total_qt_st += $val->qt_status;
               
            }else{
                if($total_qt_st == 0){
                    $data .= $val->qt_status;
                }else{
                    $total_qt_st += $val->qt_status;
                    $data .= $total_qt_st;
                    $total_qt_st = 0;
                }
                
            }

            if(++$i < $num_itens_of_tr){
                if($pos_current <> $pos_next){
                  $data .= ","  ;
                }  
            }
        }
        
        $data.="],";

       /* dd($data);*/

        return view('charts.chart_status',['data'=>$data,'redes'=>$redes,'nome_rede'=>""]);

    }

    public function ChartStatus_rede($id_rede,$id_part){

       
        $redes = DB::table('redesparts')->where('redesparts.id_part',$id_part)
                                        ->join('redes','redesparts.id_rede',"=",'redes.id') 
                                        ->get()
                                        ;

        $cons_rede = DB::table('redes')->where('id','=',$id_rede)->select('nome')->first();
        $nome_rede = $cons_rede->nome;

        /*dd($nome_rede);*/

        
        $stat_of = DB::table('transacoes')->where('redesparts.id_rede',$id_rede)

                                            ->join('ofertas_part','transacoes.id_of_part','=','ofertas_part.id')
                                            ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                            ->join('redesparts','participantes.id','=','redesparts.id_part')

                                            ->groupBy('id_st_trans')
                                            ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                            
                                            ;    

       /* dd($stat_of); */                                           


        $stat_of_tr = DB::table('transacoes')->where('redesparts.id_rede',$id_rede)

                                            ->join('ofertas_part','transacoes.id_of_tr_part','=','ofertas_part.id')
                                            ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                            ->join('redesparts','participantes.id','=','redesparts.id_part')

                                            ->groupBy('id_st_trans')
                                            ->selectRaw('id_st_trans,COUNT(id_st_trans) as qt_status')
                                            ->union($stat_of)
                                            ->orderby('id_st_trans')
                                            ->get()
                                            ;

        
        /*dd($stat_of_tr);*/

        $num_itens_of_tr =count($stat_of_tr);
        
        $i = 0;
        $total_qt_st = 0;

        $data="[";
        foreach ($stat_of_tr as $val) {

            if($i <= $num_itens_of_tr-1){
                $pos_current = $stat_of_tr[$i]->id_st_trans;
                if(($i+1) <= $num_itens_of_tr-1){
                    $pos_next = $stat_of_tr[$i+1]->id_st_trans;
                }else{
                    $pos_next = 0;
                }
            }
        
            if($pos_current == $pos_next){
                $total_qt_st += $val->qt_status;
               
            }else{
                if($total_qt_st == 0){
                    $data .= $val->qt_status;
                }else{
                    $total_qt_st += $val->qt_status;
                    $data .= $total_qt_st;
                    $total_qt_st = 0;
                }
                
            }

            if(++$i < $num_itens_of_tr){
                if($pos_current <> $pos_next){
                  $data .= ","  ;
                }  
            }
        }
        
        $data.="],";

       /* dd($data);*/

        return view('charts.chart_status',['data'=>$data,'redes'=>$redes,'nome_rede'=>$nome_rede]);

        

    }

}
