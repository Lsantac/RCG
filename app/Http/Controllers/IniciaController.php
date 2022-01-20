<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IniciaController extends Controller
{
    public function tela_inicial(request $request){

           $id_logado = Session('id_logado');

            /*Ofertas com transações em andamento*/

            $num_mens_anda_of = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('ofertas_part.status','=',2)

            ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
            ->count(); 

            $num_mens_anda_tr = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('ofertas_part.status','=',2)

            ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
            ->count(); 

            $num_mens_anda_of_tr = $num_mens_anda_of + $num_mens_anda_tr;

            /* Necessidades com transações em andamento -------------------------------------------------------------*/

            $num_mens_anda_nec = DB::table('necessidades_part')
            ->where('necessidades_part.id_part','=',$id_logado)
            ->where('necessidades_part.status','=',2)

            ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
            ->count(); 

             /* Ofertas parcialmente finalizadas ----------------------------------------------------------------------*/

             $num_of_parc = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('ofertas_part.status','=',3)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
             ->count(); 

             $num_of_tr_parc = DB::table('ofertas_part')
             ->where('ofertas_part.id_part','=',$id_logado)
             ->where('ofertas_part.status','=',3)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
             ->count();
             
             $num_ofp_parc = $num_of_parc + $num_of_tr_parc;

             /* Necessidades parcialmente finalizadas ------------------------------------------------------------------*/
             
             $num_nec_parc = DB::table('necessidades_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',3)

             ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
             ->count();

             /* Ofertas totalmente finalizadas --------------------------------------------------------------------------*/

             $num_of_final = DB::table('ofertas_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',4)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
             ->count();     

             $num_of_tr_final = DB::table('ofertas_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',4)

             ->join('transacoes','ofertas_part.id','=','transacoes.id_of_tr_part')
             ->count(); 
             
             $num_ofp_final = $num_of_final + $num_of_tr_final;


             /* Necessidades totalmente finalizadas -------------------------------------------------------------------------*/

             $num_nec_final = DB::table('necessidades_part')
             ->where('id_part','=',$id_logado)
             ->where('status','=',4)

             ->join('transacoes','necessidades_part.id','=','transacoes.id_nec_part')
             ->count();   
             
             /*Calculo dos marcadores dos mapas -------------------------------------------------------------------------------*/
             
             $cons_markers_ofs = DB::table('ofertas_part')
            ->where('ofertas_part.id_part','=',$id_logado)
            ->where('ofertas_part.status','>',1)

            ->join('transacoes','ofertas_part.id','=','transacoes.id_of_part')
            ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
            ->leftjoin('participantes','necessidades_part.id_part','=','participantes.id')

            ->get(); 

            $markers_of =  DB::table('markers_of')->where('id','>',0)->delete();

            if($cons_markers_ofs){
                
                foreach($cons_markers_ofs as $of){

                        if($of->latitude <> null and $of->longitude <> null ){
                    
                        if($of->latitude <> null){
                            $lat = $of->latitude;
                        }else{
                            $lat = 0;
                        }

                        if($of->longitude <> null){
                            $long = $of->longitude;
                        }else{
                            $long = 0;
                        }

                        $markers_of = DB::table('markers_of')->insert([
                                'nome_part'=> $of->nome_part,
                                'endereco'=> $of->endereco,
                                'latitude'=> $lat,
                                'longitude'=> $long,
                                'status'=> $of->status,
                        ]);

                        
                        }
                
                } 
            }

            $cons_markers_necs = DB::table('necessidades_part')
            ->where('necessidades_part.id_part','=',$id_logado)
            ->where('necessidades_part.status','>',1)

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
                                'status'=> $nec->status,
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

        $ofertas_1= DB::table('ofertas')->select('*');
        $ofertas_part_1= DB::table('ofertas_part')->select('*');
        $categorias_1= DB::table('categorias')->select('*');
        $categorias_2= DB::table('categorias')->select('*');
        $participantes_1= DB::table('participantes')->select('*');
        $participantes_2= DB::table('participantes')->select('*');

        $string = request('cons_of_tela_inic');

        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY); 

        $of_status = DB::table('ofertas_part')
        ->where('ofertas_part.id_part','=',$id_logado)
        ->where('ofertas_part.status','=',$status)

        ->where(function($query) use ($searchValues){
            foreach ($searchValues as $value) {
            $query->orwhere('ofertas_part_1.obs','like','%'.($value).'%')
                  ->orwhere('necessidades_part.obs','like','%'.($value).'%')
                  ->orwhere('ofertas_part.obs','like','%'.($value).'%')

                  ->orwhere('ofertas.descricao','like','%'.($value).'%')
                  ->orwhere('ofertas_1.descricao','like','%'.($value).'%')
                  ->orwhere('necessidades.descricao','like','%'.($value).'%')

                  ->orwhere('categorias.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_1.descricao','like','%'.($value).'%')
                  ->orwhere('categorias_2.descricao','like','%'.($value).'%')

                  ->orwhere('participantes_1.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_1.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_1.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_1.estado','like','%'.($value).'%')
                  ->orwhere('participantes_1.pais','like','%'.($value).'%')

                  ->orwhere('participantes_2.nome_part','like','%'.($value).'%')
                  ->orwhere('participantes_2.endereco','like','%'.($value).'%')
                  ->orwhere('participantes_2.cidade','like','%'.($value).'%')
                  ->orwhere('participantes_2.estado','like','%'.($value).'%')
                  ->orwhere('participantes_2.pais','like','%'.($value).'%')
                  
                  ->orwhere('moedas.desc_moeda','like','%'.($value).'%')
                  ;

            }      
      })
        
        ->leftjoin('transacoes','ofertas_part.id','=','transacoes.id_of_part')
        ->leftjoin('moedas','transacoes.id_moeda','=','moedas.id')

        ->leftjoin('necessidades_part','transacoes.id_nec_part','=','necessidades_part.id')
        ->leftjoin('necessidades','necessidades_part.id_nec','=','necessidades.id')

        /*->leftJoin('ofertas_part_1','transacoes.id_of_tr_part','=','ofertas_part_1.id')*/

        ->leftjoinSub($ofertas_part_1, 'ofertas_part_1', function ($join) {
            $join->on('transacoes.id_of_tr_part', '=', 'ofertas_part_1.id');
        }) 

        ->leftjoin('ofertas','ofertas_part.id_of','=','ofertas.id')

        /*->leftjoin('ofertas_1','ofertas_part_1.id_of','=','ofertas_1.id')*/

        ->leftjoinSub($ofertas_1, 'ofertas_1', function ($join) {
            $join->on('ofertas_part_1.id_of', '=', 'ofertas_1.id');
        })  

        ->leftjoin('categorias','ofertas.id_cat','=','categorias.id')

        /*->leftjoin('categorias_1','ofertas_1.id_cat','=','categorias_1.id')*/

        ->leftjoinSub($categorias_1, 'categorias_1', function ($join) {
            $join->on('ofertas_1.id_cat', '=', 'categorias_1.id');
        })  

        /*->leftjoin('categorias_2','necessidades.id_cat','=','categorias_2.id')*/

        ->leftjoinSub($categorias_2, 'categorias_2', function ($join) {
            $join->on('necessidades.id_cat', '=', 'categorias_2.id');
        })  
        
        ->leftjoin('participantes','ofertas_part.id_part','=','participantes.id')  

        /*->leftjoin('participantes_1','ofertas_part_1.id_part','=','participantes_1.id')*/

        ->leftjoinSub($participantes_1, 'participantes_1', function ($join) {
            $join->on('ofertas_part_1.id_part', '=', 'participantes_1.id');
        })  

        /*->leftjoin('participantes_2','necessidades_part.id_part','=','participantes_2.id')*/

        ->leftjoinSub($participantes_2, 'participantes_2', function ($join) {
            $join->on('necessidades_part.id_part', '=', 'participantes_2.id');
        })  
        
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
         'participantes_1.endereco as endereco_of_tr','participantes_1.cidade as cidade_of_tr',
         'participantes_1.estado as estado_of_tr','participantes_1.pais as pais_of_tr',
         'participantes_2.nome_part as nome_part_nec','participantes_2.endereco as endereco_nec','participantes_2.cidade as cidade_nec',
         'participantes_2.estado as estado_nec','participantes_2.pais as pais_nec'
         )

        ->orderBy('data_inic','desc')
        ->paginate(5);
        $of_status->appends($request->all());

        /*->get();*/
        /*dd($of_status);*/


        return view('cons_trans_ofertas_part',['of_status'=>$of_status,'status'=>$status]);
        
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
        ->where('necessidades_part.status','=',$status)

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
