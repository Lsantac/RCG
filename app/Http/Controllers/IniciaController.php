<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{

    public static function consulta_status_transacoes_of_anda($id_of_part){

        /*Ofertas com transações em andamento*/

        $num_mens_anda_of = DB::table('transacoes')
        ->where('transacoes.id_of_part','=',$id_of_part)
        ->where('transacoes.id_st_trans','=',2)
        ->count(); 

        return($num_mens_anda_of);

    }

    public static function consulta_status_transacoes_of_parc($id_of_part){

        /*Ofertas com transações parcialmente finalizadas*/

        $num_mens_parc_of = DB::table('transacoes')
        ->where('transacoes.id_of_part','=',$id_of_part)
        ->where('transacoes.id_st_trans','=',3)
        ->count(); 

        return($num_mens_parc_of);

    }

    public static function consulta_status_transacoes_of_final($id_of_part){

        /*Ofertas com transações totalmente finalizadas*/

        $num_mens_final_of = DB::table('transacoes')
        ->where('transacoes.id_of_part','=',$id_of_part)
        ->where('transacoes.id_st_trans','=',4)
        ->count(); 

        return($num_mens_final_of);

    }


    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

            /*Ofertas com transações em andamento*/

            $num_mens_anda_of = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','=',2)

            ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
            ->count(); 

            $num_mens_anda_tr = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','=',2)

            ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
            ->count(); 

            $num_mens_anda_of_tr = $num_mens_anda_of + $num_mens_anda_tr;

            /* Necessidades com transações em andamento -------------------------------------------------------------*/

            $num_mens_anda_nec = DB::table('necessidades_part')
            ->where('necessidades_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','=',2)

            ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
            ->count(); 

             /* Ofertas parcialmente finalizadas ----------------------------------------------------------------------*/

             $num_of_parc = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',3)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
             ->count(); 

             $num_of_tr_parc = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',3)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
             ->count();
             
             $num_ofp_parc = $num_of_parc + $num_of_tr_parc;

             /* Necessidades parcialmente finalizadas ------------------------------------------------------------------*/
             
             $num_nec_parc = DB::table('necessidades_part')
             ->where('necessidades_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',3)

             ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
             ->count();

             /* Ofertas totalmente finalizadas --------------------------------------------------------------------------*/

             $num_of_final = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',4)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
             ->count();     

             $num_of_tr_final = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',4)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
             ->count(); 
             
             $num_ofp_final = $num_of_final + $num_of_tr_final;


             /* Necessidades totalmente finalizadas -------------------------------------------------------------------------*/

             $num_nec_final = DB::table('necessidades_part')
             ->where('necessidades_part.id_part','=',$id_logado)
             ->where('transacoes.id_st_trans','=',4)

             ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
             ->count();   
             
             /*Calculo dos marcadores dos mapas -------------------------------------------------------------------------------*/
             
             $participantes_tr= DB::table('participantes')->select('*');
             $participantes_of= DB::table('participantes')->select('*');
             $ofertas_part_tr= DB::table('ofertas_part')->select('*');
             $ofertas_part_of= DB::table('ofertas_part')->select('*');

             $cons_markers_ofs = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','>',1)

            ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_part')
            ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
            ->leftjoin('participantes','necessidades_part.id_part','=','participantes.id')

            ->leftjoinSub($ofertas_part_tr, 'ofertas_part_tr', function ($join) {
                $join->on('transacoes.id_of_tr_part', '=', 'ofertas_part_tr.id');
            })

            ->leftjoinSub($participantes_tr, 'participantes_tr', function ($join) {
                $join->on('ofertas_part_tr.id_part', '=', 'participantes_tr.id');
            }) 

            ->leftjoinSub($ofertas_part_of, 'ofertas_part_of', function ($join) {
                $join->on('transacoes.id_of_part', '=', 'ofertas_part_of.id');
            })

            ->leftjoinSub($participantes_of, 'participantes_of', function ($join) {
                $join->on('ofertas_part_of.id_part', '=', 'participantes_of.id');
            }) 

            ->select('transacoes.id_st_trans',
            'transacoes.id_of_tr_part as id_of_tr_trans',
            'participantes.nome_part as nome_part_nec',
            'participantes.endereco as endereco_nec',
            'participantes.latitude as lat_nec',
            'participantes.longitude as long_nec',

            'participantes_tr.nome_part as nome_part_tr',
            'participantes_tr.endereco as endereco_tr',
            'participantes_tr.latitude as lat_tr',
            'participantes_tr.longitude as long_tr',

            'participantes_of.nome_part as nome_part_of_trans',
            'participantes_of.endereco as endereco_of_trans',
            'participantes_of.latitude as lat_of_trans',
            'participantes_of.longitude as long_of_trans'
            );

            /*->get(); */

            $cons_markers_ofs_tr_final = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','>',1)

            ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
            ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
            ->leftjoin('participantes','necessidades_part.id_part','=','participantes.id')

            ->leftjoinSub($ofertas_part_tr, 'ofertas_part_tr', function ($join) {
                $join->on('transacoes.id_of_tr_part', '=', 'ofertas_part_tr.id');
            })

            ->leftjoinSub($participantes_tr, 'participantes_tr', function ($join) {
                $join->on('ofertas_part_tr.id_part', '=', 'participantes_tr.id');
            }) 

            ->leftjoinSub($ofertas_part_of, 'ofertas_part_of', function ($join) {
                $join->on('transacoes.id_of_part', '=', 'ofertas_part_of.id');
            })

            ->leftjoinSub($participantes_of, 'participantes_of', function ($join) {
                $join->on('ofertas_part_of.id_part', '=', 'participantes_of.id');
            }) 

            ->select('transacoes.id_st_trans',
            'transacoes.id_of_tr_part as id_of_tr_trans',
            'participantes.nome_part as nome_part_nec',
            'participantes.endereco as endereco_nec',
            'participantes.latitude as lat_nec',
            'participantes.longitude as long_nec',

            'participantes_tr.nome_part as nome_part_tr',
            'participantes_tr.endereco as endereco_tr',
            'participantes_tr.latitude as lat_tr',
            'participantes_tr.longitude as long_tr',

            'participantes_of.nome_part as nome_part_of_trans',
            'participantes_of.endereco as endereco_of_trans',
            'participantes_of.latitude as lat_of_trans',
            'participantes_of.longitude as long_of_trans'
            )

            ->union($cons_markers_ofs)
            ->get(); 

            /*dd($cons_markers_ofs_tr_final);*/

            $markers_of =  DB::table('markers_of')->where('id','>',0)->delete();

            if($cons_markers_ofs_tr_final){
                
                foreach($cons_markers_ofs_tr_final as $of){

                    if($of->id_of_tr_trans == null){                       

                        if($of->lat_nec <> null and $of->long_nec <> null ){
                    
                                if($of->lat_nec <> null){
                                    $lat = $of->lat_nec;
                                }else{
                                    $lat = 0;
                                }

                                if($of->long_nec <> null){
                                    $long = $of->long_nec;
                                }else{
                                    $long = 0;
                                }

                                $markers_of = DB::table('markers_of')->insert([
                                        'nome_part'=> $of->nome_part_nec,
                                        'endereco'=> $of->endereco_nec,
                                        'latitude'=> $lat,
                                        'longitude'=> $long,
                                        'status'=> $of->id_st_trans,
                                ]);
                        }

                    }else{

                        if($of->lat_of_trans <> null and $of->long_of_trans <> null ){
                    
                                if($of->lat_of_trans <> null){
                                    $lat = $of->lat_of_trans;
                                }else{
                                    $lat = 0;
                                }

                                if($of->long_of_trans <> null){
                                    $long = $of->long_of_trans;
                                }else{
                                    $long = 0;
                                }

                                $markers_of = DB::table('markers_of')->insert([
                                        'nome_part'=> $of->nome_part_of_trans,
                                        'endereco'=> $of->endereco_of_trans,
                                        'latitude'=> $lat,
                                        'longitude'=> $long,
                                        'status'=> $of->id_st_trans,
                                ]);
                        }

                    }
                
                } 
            }

            $cons_markers_necs = DB::table('necessidades_part')
            ->where('necessidades_part.id_part','=',$id_logado)
            ->where('transacoes.id_st_trans','>',1)

            ->leftjoin('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
            ->leftjoin('ofertas_part','transacoes.id_of_part','=','ofertas_part.id')
            ->leftjoin('participantes','ofertas_part.id_part','=','participantes.id')

            ->get(); 

            $markers_nec =  DB::table('markers_nec')->where('id','>',0)->delete();

            if($cons_markers_necs){
                
                foreach($cons_markers_necs as $nec){
    
                        if($nec->latitude <> null and $nec->longitude <> null ){
                    
                        if($nec->latitude <> null){
                            $lat = $nec->latitude;
                        }else{
                            $lat = 0;
                        }
    
                        if($nec->longitude <> null){
                            $long = $nec->longitude;
                        }else{
                            $long = 0;
                        }
    
                        $markers_nec = DB::table('markers_nec')->insert([
                                'nome_part'=> $nec->nome_part,
                                'endereco'=> $nec->endereco,
                                'latitude'=> $lat,
                                'longitude'=> $long,
                                'status'=> $nec->id_st_trans,
                        ]);
    
                        
                        }
                
                } 
            }    

            /* Retorno para a pagina inicial com as variaveis respectivas ----------------------------------------------*/

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

        /*dd(request('cons_of_tela_inic'));*/

        $request->session()->put('criterio_of_tela_inic', request('cons_of_tela_inic')); 

        $ofertas_tr= DB::table('ofertas')->select('*');
        $ofertas_of= DB::table('ofertas')->select('*');

        $ofertas_part_tr= DB::table('ofertas_part')->select('*');
        $ofertas_part_of= DB::table('ofertas_part')->select('*');

        $categorias_of= DB::table('categorias')->select('*');
        $categorias_tr= DB::table('categorias')->select('*');
        $categorias_nec= DB::table('categorias')->select('*');

        $participantes_of= DB::table('participantes')->select('*');
        $participantes_tr= DB::table('participantes')->select('*');
        $participantes_nec= DB::table('participantes')->select('*');
        
        $string = request('cons_of_tela_inic');

        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY); 

        $of_status = DB::table('ofertas_part')
        ->where('ofertas_part.id_part','=',$id_logado)
        ->where('transacoes.id_st_trans','=',$status)

        ->where(function($query) use ($searchValues){
            foreach ($searchValues as $value) {
            $query->orwhere('ofertas_part.obs','like','%'.($value).'%')
                  ->orwhere('necessidades_part.obs','like','%'.($value).'%')
                  ->orwhere('ofertas_part_tr.obs','like','%'.($value).'%')

                  ->orwhere('ofertas.descricao','like','%'.($value).'%')
                  ->orwhere('ofertas_of.descricao','like','%'.($value).'%')
                  ->orwhere('ofertas_tr.descricao','like','%'.($value).'%')

                  ->orwhere('necessidades.descricao','like','%'.($value).'%')

                  ->orwhere('categorias.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_of.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_tr.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_nec.descricao','like','%'.($value).'%')

                  ->orwhere('participantes_of.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_of.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_of.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_of.estado','like','%'.($value).'%')
                  ->orwhere('participantes_of.pais','like','%'.($value).'%')

                  ->orwhere('participantes_tr.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_tr.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_tr.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_tr.estado','like','%'.($value).'%')
                  ->orwhere('participantes_tr.pais','like','%'.($value).'%')

                  ->orwhere('participantes_nec.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_nec.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_nec.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_nec.estado','like','%'.($value).'%')
                  ->orwhere('participantes_nec.pais','like','%'.($value).'%')
                  
                  ->orwhere('moedas.desc_moeda','like','%'.($value).'%')
                  ;

            }      
      })
        
        ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_part')

        ->leftjoin('moedas','transacoes.id_moeda','=','moedas.id')

        ->leftjoin('ofertas','ofertas_part.id_of','=','ofertas.id')
        ->leftjoin('categorias','ofertas.id_cat','=','categorias.id')
        ->leftjoin('participantes','ofertas_part.id_part','=','participantes.id')  

        /*dados da oferta da transacao -------------------------------------------------------------------------------*/

        ->leftjoinSub($ofertas_part_of, 'ofertas_part_of', function ($join) {
            $join->on('transacoes.id_of_part', '=', 'ofertas_part_of.id');
        }) 
        ->leftjoinSub($ofertas_of, 'ofertas_of', function ($join) {
            $join->on('ofertas_part_of.id_of', '=', 'ofertas_of.id');
        })  
        ->leftjoinSub($categorias_of, 'categorias_of', function ($join) {
            $join->on('ofertas_of.id_cat', '=', 'categorias_of.id');
        })  
        ->leftjoinSub($participantes_of, 'participantes_of', function ($join) {
            $join->on('ofertas_part_of.id_part', '=', 'participantes_of.id');
        })  

        /*dados da oferta de troca da transacao -------------------------------------------------------------------------------*/

        ->leftjoinSub($ofertas_part_tr, 'ofertas_part_tr', function ($join) {
            $join->on('transacoes.id_of_tr_part', '=', 'ofertas_part_tr.id');
        }) 
        ->leftjoinSub($ofertas_tr, 'ofertas_tr', function ($join) {
            $join->on('ofertas_part_tr.id_of', '=', 'ofertas_tr.id');
        })  
        ->leftjoinSub($categorias_tr, 'categorias_tr', function ($join) {
            $join->on('ofertas_tr.id_cat', '=', 'categorias_tr.id');
        })  
        ->leftjoinSub($participantes_tr, 'participantes_tr', function ($join) {
            $join->on('ofertas_part_tr.id_part', '=', 'participantes_tr.id');
        })  

        /*dados da necessidade da transacao -------------------------------------------------------------------------------*/

        ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
        ->leftjoin('necessidades','necessidades_part.id_nec','=','necessidades.id')
        ->leftjoinSub($categorias_nec, 'categorias_nec', function ($join) {
            $join->on('necessidades.id_cat', '=', 'categorias_nec.id');
        })  
        ->leftjoinSub($participantes_nec, 'participantes_nec', function ($join) {
            $join->on('necessidades_part.id_part', '=', 'participantes_nec.id');
        })  
        
        ->select(
         'ofertas_part.id as id_of',
         'ofertas.descricao as desc_of',
         'ofertas_of.descricao as desc_of_trans',
         'ofertas_tr.descricao as desc_of_tr',

         'ofertas_part.id_part as id_partic_ofertas',
         'ofertas_part.status as status_of',

         'ofertas_part.obs as obs_of',
         'ofertas_part_of.obs as obs_of_trans',
         'ofertas_part_tr.obs as obs_of_tr',

         'necessidades_part.obs as obs_nec',
         'necessidades.descricao as desc_nec',
         
         'moedas.desc_moeda as fluxo',

         'transacoes.id_of_part as id_of_part',
         'transacoes.id as id_trans',
         'transacoes.id_nec_part as id_nec_part',
         'transacoes.id_of_tr_part as id_of_tr_part',
         'transacoes.quant_of as quant_of',
         'transacoes.quant_nec as quant_nec',
         'transacoes.quant_of_tr as quant_of_tr',
         'transacoes.id_st_trans as id_st_trans',
         'transacoes.quant_moeda as quant_moeda',
         'transacoes.id_moeda as id_moeda',
         'transacoes.data_inic as data_inic',
         'transacoes.data_final_nec_part as data_final_nec_part',
         'transacoes.data_final_of_part as data_final_of_part',
         'transacoes.data_final_of_tr_part as data_final_of_tr_part',

         'categorias.descricao as desc_cat_of',
         'categorias_of.descricao as desc_cat_of_trans',
         'categorias_tr.descricao as desc_cat_of_tr',
         'categorias_nec.descricao as desc_cat_nec',

         'participantes.nome_part as nome_part_of',

         'participantes_of.nome_part as nome_part_of_trans',
         'participantes_of.endereco as endereco_of_trans',
         'participantes_of.cidade as cidade_of_trans',
         'participantes_of.estado as estado_of_trans',
         'participantes_of.pais as pais_of_trans',
         
         'participantes_nec.nome_part as nome_part_nec',
         'participantes_nec.endereco as endereco_nec',
         'participantes_nec.cidade as cidade_nec',
         'participantes_nec.estado as estado_nec',
         'participantes_nec.pais as pais_nec',

         'participantes_tr.nome_part as nome_part_of_tr',
         'participantes_tr.endereco as endereco_of_tr',
         'participantes_tr.cidade as cidade_of_tr',
         'participantes_tr.estado as estado_of_tr',
         'participantes_tr.pais as pais_of_tr'
        );

        /*->orderBy('data_inic','desc');*/
        /*->paginate(5);*/
        /*$of_status->appends($request->all());*/
        
        /*->get();*/
        /*dd($of_status);*/

        /* Consulta transações de troca e faz união com as ofertas normais ---------------------------------------------------------------------------------------*/

        $of_status_tr_final = DB::table('ofertas_part')
        ->where('ofertas_part.id_part','=',$id_logado)
        ->where('transacoes.id_st_trans','=',$status)

        ->where(function($query) use ($searchValues){
            foreach ($searchValues as $value) {
                $query->orwhere('ofertas_part.obs','like','%'.($value).'%')
                  ->orwhere('necessidades_part.obs','like','%'.($value).'%')
                  ->orwhere('ofertas_part_tr.obs','like','%'.($value).'%')

                  ->orwhere('ofertas.descricao','like','%'.($value).'%')
                  ->orwhere('ofertas_of.descricao','like','%'.($value).'%')
                  ->orwhere('ofertas_tr.descricao','like','%'.($value).'%')

                  ->orwhere('necessidades.descricao','like','%'.($value).'%')

                  ->orwhere('categorias.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_of.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_tr.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_nec.descricao','like','%'.($value).'%')

                  ->orwhere('participantes_of.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_of.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_of.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_of.estado','like','%'.($value).'%')
                  ->orwhere('participantes_of.pais','like','%'.($value).'%')

                  ->orwhere('participantes_tr.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_tr.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_tr.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_tr.estado','like','%'.($value).'%')
                  ->orwhere('participantes_tr.pais','like','%'.($value).'%')

                  ->orwhere('participantes_nec.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_nec.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_nec.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_nec.estado','like','%'.($value).'%')
                  ->orwhere('participantes_nec.pais','like','%'.($value).'%')
                  
                  ->orwhere('moedas.desc_moeda','like','%'.($value).'%')
                ;

            }      
      })
        
        ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')

        ->leftjoin('moedas','transacoes.id_moeda','=','moedas.id')

        ->leftjoin('ofertas','ofertas_part.id_of','=','ofertas.id')
        ->leftjoin('categorias','ofertas.id_cat','=','categorias.id')
        ->leftjoin('participantes','ofertas_part.id_part','=','participantes.id')  

        /*dados da oferta da transacao -------------------------------------------------------------------------------*/

        ->leftjoinSub($ofertas_part_of, 'ofertas_part_of', function ($join) {
            $join->on('transacoes.id_of_part', '=', 'ofertas_part_of.id');
        }) 
        ->leftjoinSub($ofertas_of, 'ofertas_of', function ($join) {
            $join->on('ofertas_part_of.id_of', '=', 'ofertas_of.id');
        })  
        ->leftjoinSub($categorias_of, 'categorias_of', function ($join) {
            $join->on('ofertas_of.id_cat', '=', 'categorias_of.id');
        })  
        ->leftjoinSub($participantes_of, 'participantes_of', function ($join) {
            $join->on('ofertas_part_of.id_part', '=', 'participantes_of.id');
        })  

        /*dados da oferta de troca da transacao -------------------------------------------------------------------------------*/

        ->leftjoinSub($ofertas_part_tr, 'ofertas_part_tr', function ($join) {
            $join->on('transacoes.id_of_tr_part', '=', 'ofertas_part_tr.id');
        }) 
        ->leftjoinSub($ofertas_tr, 'ofertas_tr', function ($join) {
            $join->on('ofertas_part_tr.id_of', '=', 'ofertas_tr.id');
        })  
        ->leftjoinSub($categorias_tr, 'categorias_tr', function ($join) {
            $join->on('ofertas_tr.id_cat', '=', 'categorias_tr.id');
        })  
        ->leftjoinSub($participantes_tr, 'participantes_tr', function ($join) {
            $join->on('ofertas_part_tr.id_part', '=', 'participantes_tr.id');
        })  

        /*dados da necessidade da transacao -------------------------------------------------------------------------------*/

        ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
        ->leftjoin('necessidades','necessidades_part.id_nec','=','necessidades.id')
        ->leftjoinSub($categorias_nec, 'categorias_nec', function ($join) {
            $join->on('necessidades.id_cat', '=', 'categorias_nec.id');
        })  
        ->leftjoinSub($participantes_nec, 'participantes_nec', function ($join) {
            $join->on('necessidades_part.id_part', '=', 'participantes_nec.id');
        })  
        
        ->select(
            'ofertas_part.id as id_of',
            'ofertas.descricao as desc_of',
            'ofertas_of.descricao as desc_of_trans',
            'ofertas_tr.descricao as desc_of_tr',
   
            'ofertas_part.id_part as id_partic_ofertas',
            'ofertas_part.status as status_of',
   
            'ofertas_part.obs as obs_of',
            'ofertas_part_of.obs as obs_of_trans',
            'ofertas_part_tr.obs as obs_of_tr',
   
            'necessidades_part.obs as obs_nec',
            'necessidades.descricao as desc_nec',
            
            'moedas.desc_moeda as fluxo',
   
            'transacoes.id_of_part as id_of_part',
            'transacoes.id as id_trans',
            'transacoes.id_nec_part as id_nec_part',
            'transacoes.id_of_tr_part as id_of_tr_part',
            'transacoes.quant_of as quant_of',
            'transacoes.quant_nec as quant_nec',
            'transacoes.quant_of_tr as quant_of_tr',
            'transacoes.id_st_trans as id_st_trans',
            'transacoes.quant_moeda as quant_moeda',
            'transacoes.id_moeda as id_moeda',
            'transacoes.data_inic as data_inic',
            'transacoes.data_final_nec_part as data_final_nec_part',
            'transacoes.data_final_of_part as data_final_of_part',
            'transacoes.data_final_of_tr_part as data_final_of_tr_part',
   
            'categorias.descricao as desc_cat_of',
            'categorias_of.descricao as desc_cat_of_trans',
            'categorias_tr.descricao as desc_cat_of_tr',
            'categorias_nec.descricao as desc_cat_nec',
   
            'participantes.nome_part as nome_part_of',
   
            'participantes_of.nome_part as nome_part_of_trans',
            'participantes_of.endereco as endereco_of_trans',
            'participantes_of.cidade as cidade_of_trans',
            'participantes_of.estado as estado_of_trans',
            'participantes_of.pais as pais_of_trans',
            
            'participantes_nec.nome_part as nome_part_nec',
            'participantes_nec.endereco as endereco_nec',
            'participantes_nec.cidade as cidade_nec',
            'participantes_nec.estado as estado_nec',
            'participantes_nec.pais as pais_nec',
   
            'participantes_tr.nome_part as nome_part_of_tr',
            'participantes_tr.endereco as endereco_of_tr',
            'participantes_tr.cidade as cidade_of_tr',
            'participantes_tr.estado as estado_of_tr',
            'participantes_tr.pais as pais_of_tr'
           )
   
        ->union($of_status)
        ->orderBy('data_inic','desc')
        
        ->paginate(5);
        $of_status_tr_final->appends($request->all());
        
        /*->get();*/
        /*dd($of_status_tr_final);*/


        /*---------------------------------------------------------------------------------------------------------------------*/

        return view('cons_trans_ofertas_part',['of_status'=>$of_status_tr_final,'status'=>$status]);
        
    }
    
    public function cons_trans_necessidades_part($status,$id_logado,Request $request){

        /*$id_logado = Session('id_logado');*/

        /*dd($status." ".$id_logado);*/

        $request->session()->put('criterio_nec_tela_inic', request('cons_nec_tela_inic')); 

        $categorias_1= DB::table('categorias')->select('*');
        $participantes_1= DB::table('participantes')->select('*');

        $string = request('cons_nec_tela_inic');

        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY); 
        
        $nec_status = DB::table('necessidades_part')
        ->where('necessidades_part.id_part','=',$id_logado)
        ->where('transacoes.id_st_trans','=',$status)

        ->where(function($query) use ($searchValues){
            foreach ($searchValues as $value) {
            $query->orwhere('ofertas_part.obs','like','%'.($value).'%')
                  ->orwhere('necessidades_part.obs','like','%'.($value).'%')
                  
                  ->orwhere('ofertas.descricao','like','%'.($value).'%')
                  ->orwhere('necessidades.descricao','like','%'.($value).'%')

                  ->orwhere('categorias.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_1.descricao','like','%'.($value).'%')
                  
                  ->orwhere('participantes.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes.endereco','like','%'.($value).'%')
                  ->orwhere('participantes.cidade','like','%'.($value).'%')
                  ->orwhere('participantes.estado','like','%'.($value).'%')
                  ->orwhere('participantes.pais','like','%'.($value).'%')

                  ->orwhere('moedas.desc_moeda','like','%'.($value).'%')
                  ;

            }      
      })
        
        ->leftjoin('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
        ->leftjoin('moedas','transacoes.id_moeda','=','moedas.id')

        ->leftjoin('necessidades','necessidades_part.id_nec','=','necessidades.id')

        ->leftjoin('ofertas_part','transacoes.id_of_part','=','ofertas_part.id')
        ->leftjoin('ofertas','ofertas_part.id_of','=','ofertas.id')
        
        ->leftjoin('categorias','ofertas.id_cat','=','categorias.id')

        /*->leftjoin('categorias_1','necessidades.id_cat','=','categorias_1.id')*/

        ->leftjoinSub($categorias_1, 'categorias_1', function ($join) {
            $join->on('necessidades.id_cat', '=', 'categorias_1.id');
        })  
        
        ->leftjoin('participantes','ofertas_part.id_part','=','participantes.id')  

        /*->leftjoin('participantes_1','necessidades_part.id_part','=','participantes_1.id')*/

        ->leftjoinSub($participantes_1, 'participantes_1', function ($join) {
            $join->on('necessidades_part.id_part', '=', 'participantes_1.id');
        })
        
        ->select(
         'necessidades_part.id as id_nec',
         'necessidades_part.id_part as id_partic_necessidades',
         'necessidades_part.status as status_nec',
         'necessidades_part.obs as obs_nec',

         'necessidades.descricao as desc_nec',
         
         'ofertas_part.obs as obs_of',

         'ofertas.descricao as desc_of',

         'moedas.desc_moeda as fluxo',

         'transacoes.id as id_trans',
         'transacoes.id_nec_part as id_nec_part',
         'transacoes.id_of_part as id_of_part',
         'transacoes.quant_of as quant_of',
         'transacoes.quant_nec as quant_nec',
         'transacoes.id_st_trans as id_st_trans',
         'transacoes.quant_moeda as quant_moeda',
         'transacoes.id_moeda as id_moeda',
         'transacoes.data_inic as data_inic',
         'transacoes.data_final_nec_part as data_final_nec_part',
         'transacoes.data_final_of_part as data_final_of_part',

         'categorias.descricao as desc_cat_of',
         'categorias_1.descricao as desc_cat_nec',

         'participantes.nome_part as nome_part_of',
         'participantes.endereco as endereco_of',
         'participantes.cidade as cidade_of',
         'participantes.estado as estado_of',
         'participantes.pais as pais_of',
         
         'participantes_1.nome_part as nome_part_nec'
         )

        ->orderBy('data_inic','desc')
        ->paginate(5);
        $nec_status->appends($request->all());

        /*->get();
        dd($nec_status);*/

        return view('cons_trans_necessidades_part',['nec_status'=>$nec_status,'status'=>$status]);
        
    }    


}
