<?php

namespace App\Http\Controllers;

use App\Models\participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TransacoesController extends Controller
{
   
    public function trans_ofertas_part(request $request){
    
        /*$id_part = $id;*/

        $filtra_id_logado = request('filtra_id_logado');
        $id_part = request('id_part_t');
        $id_of_part = request('id_of_part_t');
        $id_logado = request('id_logado');
   
        $part = DB::table('participantes')->where('id',$id_part)
                                          ->select('participantes.*')
                                          ->first();
                                                       
        $ofps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_part)
                                         ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                         ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                         ->join('categorias','ofertas.id_cat','=','categorias.id')
                                         ->join('unidades','ofertas.id_unid','=','unidades.id')
                                      
                                         ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude','participantes.nome_part','ofertas_part.id as id_of_part',
                                                  'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                                                  'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                         ->get();
        
        /*dd($ofps);*/

        $string = $ofps[0]->desc_cat." ".$ofps[0]->desc_of." ".$ofps[0]->obs;
       
        /*dd($string);*/

        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
        
        /*dd($searchValues);*/
        

        $necps = DB::table('necessidades_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                       if($filtra_id_logado){
                                                          $verif->where('necessidades_part.id_part',"<>",$id_part);
                                                       }else{
                                                          $verif->where('necessidades_part.id_part',"=",$id_logado);
                                                       }                                               
                                                       })
            
                                               ->where(function($query) use ($searchValues){
                                                        foreach ($searchValues as $value) {
                                                                 if(strlen($value)>4){      
                                                                 $query->orwhere('obs','like','%'.($value).'%')
                                                                       ->orwhere('necessidades.descricao','like','%'.($value).'%')
                                                                       ->orwhere('categorias.descricao','like','%'.($value).'%');
                                                                 }
                                                        }
                                                
                                                })

            ->join('participantes','necessidades_part.id_part','=','participantes.id')
            ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
            ->join('categorias','necessidades.id_cat','=','categorias.id')
            ->join('unidades','necessidades.id_unid','=','unidades.id')
            
            ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                        participantes.nome_part,necessidades_part.id as id_nec_part,participantes.endereco,participantes.cidade,
                       necessidades_part.id_nec,necessidades_part.quant,necessidades_part.data,
                       necessidades_part.obs,necessidades.descricao as desc_nec,
                       categorias.descricao as desc_cat,unidades.descricao as desc_unid,
                       (6371 * (2 *
                        atan2(sqrt(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                        * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))),
                        sqrt(1-(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                        * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))))) ) )
                        AS distancia') 
                 
                  ->orderBy('distancia','asc')
                  ->paginate(3);

      
      /*dd($necps);*/
      
      $necps->appends($request->all());   

      $nome_part_cab = "";
      if($filtra_id_logado == 1){
         $nome_part_cab = $part->nome_part;
      }else{
         if($filtra_id_logado == 0){
         $nome_part_cab = request('nome_part_cab');
         }
      }

      $origem = "of";
                                        
      return view('trans_ofertas_part',[
                  'part' => $part,
                  'ofps'=>$ofps,
                  'necps'=>$necps,
                  'nome_part_cab'=>$nome_part_cab,
                  'origem'=>$origem
                  ]);
      }

      public function trans_trocas_part(request $request){
    
            $filtra_id_logado = request('filtra_id_logado');
            $id_part = request('id_part_t');
            $id_of_part = request('id_of_part_t');
            $id_logado = request('id_logado');

            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $ofps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_part)
                                             ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                             ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                             ->join('categorias','ofertas.id_cat','=','categorias.id')
                                             ->join('unidades','ofertas.id_unid','=','unidades.id')
                                          
                                             ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude','participantes.nome_part','ofertas_part.id as id_of_part',
                                                      'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                                                      'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                             ->get();

            $sql_dist = '(6371 * (2 *
                        atan2(sqrt(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                        * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))),
                        sqrt(1-(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                        * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))))) ) )
                        AS distancia';

            
            $of_tr_ps = DB::table('ofertas_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                      if($filtra_id_logado){
                                                      $verif->where('ofertas_part.id_part',"<>",$id_part);
                                                      }else{
                                                      $verif->where('ofertas_part.id_part',"=",$id_logado);
                                                      }                                               
                                                      })
                                                 
                                                 ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                                 ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                                 ->join('categorias','ofertas.id_cat','=','categorias.id')
                                                 ->join('unidades','ofertas.id_unid','=','unidades.id')
                
                ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                            participantes.nome_part,ofertas_part.id as id_of_part,participantes.endereco,participantes.cidade,
                           ofertas_part.id_of,ofertas_part.quant,ofertas_part.data,
                           ofertas_part.obs,ofertas.descricao as desc_of,
                           categorias.descricao as desc_cat,unidades.descricao as desc_unid,'.$sql_dist) 
                     
                      ->orderBy('distancia','asc')
                      ->paginate(3);
    
          
          $of_tr_ps->appends($request->all()); 
          
          $origem = "tr";
                                            
          return view('trans_trocas_part',[
                      'part' => $part,
                      'ofps'=>$ofps,
                      'of_tr_ps'=>$of_tr_ps,
                      'origem'=>$origem
                      ]);
    
          }
    

      public function trans_necessidades_part(Request $request){

            $filtra_id_logado = request('filtra_id_logado');
            $id_part = request('id_part_t');
            $id_nec_part = request('id_nec_part_t');
            $id_logado = request('id_logado');

            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $necps = DB::table('necessidades_part')->where('necessidades_part.id',$id_nec_part)
                                             ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                             ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                             ->join('categorias','necessidades.id_cat','=','categorias.id')
                                             ->join('unidades','necessidades.id_unid','=','unidades.id')
                                          
                                             ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude',
                                             'participantes.longitude','participantes.nome_part','necessidades_part.id as id_nec_part',
                                                      'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs',
                                                      'necessidades.descricao as desc_nec',
                                                      'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                             ->get();
            
            
            $string = $necps[0]->desc_cat." ".$necps[0]->desc_nec." ".$necps[0]->obs;
           
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
            
            $ofps = DB::table('ofertas_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                if($filtra_id_logado){
                                                $verif->where('ofertas_part.id_part',"<>",$id_part);
                                                }else{
                                                $verif->where('ofertas_part.id_part',"=",$id_logado);
                                                }                                               
                                                })
            
                                                ->where(function($query) use ($searchValues){
                                                            foreach ($searchValues as $value) {
                                                                     if(strlen($value)>4){      
                                                                     $query->orwhere('obs','like','%'.($value).'%')
                                                                           ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                                                           ->orwhere('categorias.descricao','like','%'.($value).'%');
                                                                     }
                                                            }
                                                    
                                                    })
    
                ->join('participantes','ofertas_part.id_part','=','participantes.id')
                ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                ->join('categorias','ofertas.id_cat','=','categorias.id')
                ->join('unidades','ofertas.id_unid','=','unidades.id')
                
                ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                            participantes.nome_part,
                            ofertas_part.id as id_of_part,participantes.endereco,participantes.cidade,
                            ofertas_part.id_of,ofertas_part.quant,ofertas_part.data,
                            ofertas_part.obs,ofertas.descricao as desc_of,
                            categorias.descricao as desc_cat,unidades.descricao as desc_unid,
                           (6371 * (2 *
                            atan2(sqrt(sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) * cos(radians('.$necps[0]->latitude.')) * cos(radians(participantes.latitude))),
                            sqrt(1-(sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) * cos(radians('.$necps[0]->latitude.')) * cos(radians(participantes.latitude))))) ) )
                            AS distancia') 
                     
                      ->orderBy('distancia','asc')
                      ->paginate(10);
    
          
          $ofps->appends($request->all());   

          $nome_part_cab = "";
          if($filtra_id_logado == 1){
             $nome_part_cab = $part->nome_part;
          }else{
             if($filtra_id_logado == 0){
                $nome_part_cab = request('nome_part_cab');
             }
          }

          $origem = "nec";
                                            
          return view('trans_necessidades_part',[
                      'part' => $part,
                      'ofps'=>$ofps,
                      'necps'=>$necps,
                      'nome_part_cab'=>$nome_part_cab,
                      'origem'=>$origem
                      ]);
    
          }
      
      public function consultar_trans_nec_part(Request $request){

            $filtra_id_logado = request('filtra_id_logado');
            $id_part = request('id_part_t');
            $id_of_part = request('id_of_part_t');
            $id_logado = request('id_logado');

            $request->session()->put('criterio_nec', request('criterio_nec'));

            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $ofps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_part)
                                             ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                             ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                             ->join('categorias','ofertas.id_cat','=','categorias.id')
                                             ->join('unidades','ofertas.id_unid','=','unidades.id')
                                          
                                             ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude','participantes.nome_part','ofertas_part.id as id_of_part',
                                                      'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                                                      'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                             ->get();

                                             
                        
            $string = request('criterio_nec');
           
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
           
            $necps = DB::table('necessidades_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                      if($filtra_id_logado){
                                                         $verif->where('necessidades_part.id_part',"<>",$id_part);
                                                      }else{
                                                         $verif->where('necessidades_part.id_part',"=",$id_logado);
                                                      }                                               
                                                      })

                                                   ->where(function($query) use ($searchValues){
                                                            foreach ($searchValues as $value) {
                                                                     $query->orwhere('obs','like','%'.($value).'%')
                                                                           ->orwhere('necessidades.descricao','like','%'.($value).'%')
                                                                           ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                                           ->orwhere('nome_part','like','%'.$value.'%')
                                                                           ->orwhere('endereco','like','%'.$value.'%')
                                                                           ->orwhere('cidade','like','%'.$value.'%')
                                                                           ->orwhere('cep','like','%'.$value.'%')
                                                                           ->orwhere('email','like','%'.$value.'%')
                                                                           ->orwhere('estado','like','%'.$value.'%');
                                                                     
                                                            }
                                                    
                                                    })
    
                ->join('participantes','necessidades_part.id_part','=','participantes.id')
                ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                ->join('categorias','necessidades.id_cat','=','categorias.id')
                ->join('unidades','necessidades.id_unid','=','unidades.id')
                
                ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                            participantes.nome_part,necessidades_part.id as id_nec_part,
                            participantes.endereco,participantes.cidade,participantes.cep,participantes.email,participantes.estado,
                           necessidades_part.id_nec,necessidades_part.quant,necessidades_part.data,
                           necessidades_part.obs,necessidades.descricao as desc_nec,
                           categorias.descricao as desc_cat,unidades.descricao as desc_unid,
                           (6371 * (2
                            * atan2(sqrt(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2)
                            * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2)
                            + sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2)
                            * cos(radians('.$ofps[0]->latitude.'))
                            * cos(radians(participantes.latitude)))
                            , sqrt(1-(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2)
                            * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2)
                            + sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2)
                            * cos(radians('.$ofps[0]->latitude.'))
                            * cos(radians(participantes.latitude))))) ) )
                            AS distancia') 
                     
                      ->orderBy('distancia','asc')
                      ->paginate(10);
                      
          
          $necps->appends($request->all());   

          $nome_part_cab = "";
          if($filtra_id_logado == 1){
             $nome_part_cab = $part->nome_part;
          }else{
             if($filtra_id_logado == 0){
               $nome_part_cab = request('nome_part_cab');
             }
          }
                                            
          return view('trans_ofertas_part',['part' => $part,'ofps'=>$ofps,'necps'=>$necps,'nome_part_cab'=>$nome_part_cab]);
    
          }     
      
      public function consultar_trans_of_part(Request $request){

            $filtra_id_logado = request('filtra_id_logado');
            $id_part = request('id_part_t');
            $id_nec_part = request('id_nec_part_t');
            $id_logado = request('id_logado');

            $request->session()->put('criterio_of', request('criterio_of'));

            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $necps = DB::table('necessidades_part')->where('necessidades_part.id',$id_nec_part)
                                             ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                             ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                             ->join('categorias','necessidades.id_cat','=','categorias.id')
                                             ->join('unidades','necessidades.id_unid','=','unidades.id')
                                          
                                             ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude',
                                             'participantes.longitude','participantes.nome_part','necessidades_part.id as id_nec_part',
                                             'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs','necessidades.descricao as desc_nec',
                                             'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                             ->get();

                                             
                        
            $string = request('criterio_of');
           
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
           
            $ofps = DB::table('ofertas_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                if($filtra_id_logado){
                                                   $verif->where('ofertas_part.id_part',"<>",$id_part);
                                                }else{
                                                   $verif->where('ofertas_part.id_part',"=",$id_logado);
                                                }                                               
                                                })


                                             ->where(function($query) use ($searchValues){
                                                            foreach ($searchValues as $value) {
                                                                     $query->orwhere('obs','like','%'.($value).'%')
                                                                           ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                                                           ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                                           ->orwhere('nome_part','like','%'.$value.'%')
                                                                           ->orwhere('endereco','like','%'.$value.'%')
                                                                           ->orwhere('cidade','like','%'.$value.'%')
                                                                           ->orwhere('cep','like','%'.$value.'%')
                                                                           ->orwhere('email','like','%'.$value.'%')
                                                                           ->orwhere('estado','like','%'.$value.'%');
                                                                     
                                                            }
                                                    
                                                    })
    
                ->join('participantes','ofertas_part.id_part','=','participantes.id')
                ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                ->join('categorias','ofertas.id_cat','=','categorias.id')
                ->join('unidades','ofertas.id_unid','=','unidades.id')
                
                ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                            participantes.nome_part,ofertas_part.id as id_of_part,
                            participantes.endereco,participantes.cidade,participantes.cep,participantes.email,participantes.estado,
                           ofertas_part.id_of,ofertas_part.quant,ofertas_part.data,
                           ofertas_part.obs,ofertas.descricao as desc_of,
                           categorias.descricao as desc_cat,unidades.descricao as desc_unid,
                           (6371 * (2
                            * atan2(sqrt(sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2)
                            * sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2)
                            + sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2)
                            * cos(radians('.$necps[0]->latitude.'))
                            * cos(radians(participantes.latitude)))
                            , sqrt(1-(sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2)
                            * sin(radians(participantes.latitude-'.$necps[0]->latitude.')/2)
                            + sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2) 
                            * sin(radians(participantes.longitude-'.$necps[0]->longitude.')/2)
                            * cos(radians('.$necps[0]->latitude.'))
                            * cos(radians(participantes.latitude))))) ) )
                            AS distancia') 
                     
                      ->orderBy('distancia','asc')
                      ->paginate(5);
                      
          
          $ofps->appends($request->all());   

          $nome_part_cab = "";
          if($filtra_id_logado == 1){
             $nome_part_cab = $part->nome_part;
          }else{
             if($filtra_id_logado == 0){
               $nome_part_cab = request('nome_part_cab');
             }
          }
                                            
          return view('trans_necessidades_part',['part' => $part,'ofps'=>$ofps,'necps'=>$necps,'nome_part_cab'=>$nome_part_cab]);
    
          }
          
          public function consultar_trans_trocas_part(Request $request){

            $filtra_id_logado = request('filtra_id_logado');
            $id_part = request('id_part_t');
            $id_of_part = request('id_of_part_t');
            $id_logado = request('id_logado');

            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $ofps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_part)
                                             ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                             ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                             ->join('categorias','ofertas.id_cat','=','categorias.id')
                                             ->join('unidades','ofertas.id_unid','=','unidades.id')
                                          
                                             ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude','participantes.nome_part','ofertas_part.id as id_of_part',
                                                      'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                                                      'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                                             ->get();

            $sql_dist = '(6371 * (2 *
            atan2(sqrt(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
            * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))),
            sqrt(1-(sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) * sin(radians(participantes.latitude-'.$ofps[0]->latitude.')/2) +sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) 
            * sin(radians(participantes.longitude-'.$ofps[0]->longitude.')/2) * cos(radians('.$ofps[0]->latitude.')) * cos(radians(participantes.latitude))))) ) )
            AS distancia';
                                             
                        
            $string = request('consultar_trans_troca_part');
           
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
           
            $of_tr_ps = DB::table('ofertas_part')->where(function($verif) use ($filtra_id_logado,$id_part,$id_logado){
                                                if($filtra_id_logado){
                                                   $verif->where('ofertas_part.id_part',"<>",$id_part);
                                                }else{
                                                   $verif->where('ofertas_part.id_part',"=",$id_logado);
                                                }                                               
                                                })

                                                ->where(function($query) use ($searchValues){
                                                            foreach ($searchValues as $value) {
                                                                     $query->orwhere('obs','like','%'.($value).'%')
                                                                           ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                                                           ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                                           ->orwhere('nome_part','like','%'.$value.'%')
                                                                           ->orwhere('endereco','like','%'.$value.'%')
                                                                           ->orwhere('cidade','like','%'.$value.'%')
                                                                           ->orwhere('cep','like','%'.$value.'%')
                                                                           ->orwhere('email','like','%'.$value.'%')
                                                                           ->orwhere('estado','like','%'.$value.'%');
                                                                     
                                                            }
                                                    
                                                    })
    
                ->join('participantes','ofertas_part.id_part','=','participantes.id')
                ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                ->join('categorias','ofertas.id_cat','=','categorias.id')
                ->join('unidades','ofertas.id_unid','=','unidades.id')
                
                ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                            participantes.nome_part,ofertas_part.id as id_of_part,
                            participantes.endereco,participantes.cidade,participantes.cep,participantes.email,participantes.estado,
                           ofertas_part.id_of,ofertas_part.quant,ofertas_part.data,
                           ofertas_part.obs,ofertas.descricao as desc_of,
                           categorias.descricao as desc_cat,unidades.descricao as desc_unid,'.$sql_dist) 
                     
                      ->orderBy('distancia','asc')
                      ->paginate(3);
                      
          
          $of_tr_ps->appends($request->all());   

          $nome_part_cab = "";
          if($filtra_id_logado == 1){
             $nome_part_cab = $part->nome_part;
          }else{
             if($filtra_id_logado == 0){
               $nome_part_cab = request('nome_part_cab');
             }
          }
                                            
          return view('trans_trocas_part',['part' => $part,'ofps'=>$ofps,'of_tr_ps'=>$of_tr_ps,'nome_part_cab'=>$nome_part_cab]);
    
          }         

      public function mens_transacoes_part(Request $request){
     
            $id_part = request('id_part_t');
            $id_of_part = request('id_of_part_t');
            $id_of_tr_part = request('id_of_tr_part_t');
            $id_nec_part = request('id_nec_part_t');
            $origem = request('origem');

            /*dd($origem);*/

            $troca = 0;

            if($id_of_tr_part > 0){
               $id_nec_part = 0;   
               $troca=1;  
            }else{
                 $id_of_tr_part = 0;
            }

           /* dd([$id_of_part,$id_of_tr_part,$id_nec_part,$troca]);*/
            
            $part = DB::table('participantes')->where('id',$id_part)
                                              ->select('participantes.*')
                                              ->first();
                                                           
            $ofps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_part)
            ->join('participantes','ofertas_part.id_part','=','participantes.id')
            ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
            ->join('categorias','ofertas.id_cat','=','categorias.id')
            ->join('unidades','ofertas.id_unid','=','unidades.id')
      
            ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude',
                  'participantes.nome_part',
                  'ofertas_part.id as id_of_part',
                  'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                  'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
            ->first();
             
            //consulta oferta de troca                                              
            if($troca){
                      $oftrps = DB::table('ofertas_part')->where('ofertas_part.id',$id_of_tr_part)
                      ->join('participantes','ofertas_part.id_part','=','participantes.id')
                      ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                      ->join('categorias','ofertas.id_cat','=','categorias.id')
                      ->join('unidades','ofertas.id_unid','=','unidades.id')
                        
                      ->select('participantes.id as id_part','participantes.nome_part','participantes.latitude','participantes.longitude',
                              'participantes.nome_part',
                              'ofertas_part.id as id_of_part',
                              'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                              'categorias.descricao as desc_cat','unidades.descricao as desc_unid')
                      ->first();

            }else{
                  $necps = DB::table('necessidades_part')->where('necessidades_part.id',$id_nec_part)
                                                   
                  ->join('participantes','necessidades_part.id_part','=','participantes.id')
                  ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                  ->join('categorias','necessidades.id_cat','=','categorias.id')
                  ->join('unidades','necessidades.id_unid','=','unidades.id')
                  
                  ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                              participantes.nome_part,necessidades_part.id as id_nec_part,participantes.endereco,participantes.cidade,
                             necessidades_part.id_nec,necessidades_part.quant,necessidades_part.data,
                             necessidades_part.obs,necessidades.descricao as desc_nec,
                             categorias.descricao as desc_cat,unidades.descricao as desc_unid') 
                       
                   ->first();

            }

            $trans = DB::table('transacoes')->where('id_nec_part', $id_nec_part)
                                            ->where('id_of_part', $id_of_part)
                                            ->where('id_of_tr_part', $id_of_tr_part)
                                            ->first();

            /*dd(request('id_nec_part_t')." , ".request('id_of_part_t')." , ".$id_of_tr_part);*/
                                            

            if($trans){
               $id_trans = $trans->id; 
            }else{
               $id_trans = 0;
            }                                            

            /*dd($id_trans);*/
         
            $msgs = DB::table('mensagens_trans')->where('mensagens_trans.id_trans',$id_trans)          
                    ->select('mensagens_trans.*','participantes.nome_part as nome_part_mens')

                    ->join('participantes','mensagens_trans.id_part','=','participantes.id')
                    ->orderBy('data','desc')
                    ->paginate(5);
    
            $msgs->appends($request->all()); 

            $trans = DB::table('transacoes')->where('transacoes.id', $id_trans)
                                            ->select('transacoes.*','moedas.desc_moeda')
                                            ->join('moedas','transacoes.id_moeda','=','moedas.id') 
                                            ->get();

           /*dd($trans);                                          */
                                            
           $soma_qt_of_trans = DB::table('transacoes')->where('transacoes.id_of_part',$id_of_part)
                                                      ->sum('transacoes.quant_of');                                                          

           $soma_qt_of_tr_trans = DB::table('transacoes')->where('transacoes.id_of_tr_part',$id_of_tr_part)
                                                         ->sum('transacoes.quant_of_tr');                                                                        

           $soma_qt_nec_trans = DB::table('transacoes')->where('transacoes.id_nec_part',$id_nec_part)
                                                       ->sum('transacoes.quant_nec'); 
                                                       
           $disp_qt_of_trans = $ofps->quant - round($soma_qt_of_trans,2);                                                        
           
           if($troca){
              $moedas =  DB::table('moedas')->where('desc_moeda','=','Troca')
                                            ->get();

              $disp_qt_of_tr_trans = $oftrps->quant - round($soma_qt_of_tr_trans,2);
              $disp_qt_nec_trans = 0; 

              return view('mens_transacoes_part',['part'  =>$part,
                                                 'ofps'  =>$ofps,
                                                 'oftrps'=>$oftrps,
                                                 'msgs'  =>$msgs,
                                                 'trans' =>$trans,
                                                 'moedas'=>$moedas,
                                                 'disp_qt_of_trans'=>$disp_qt_of_trans, 
                                                 'disp_qt_of_tr_trans'=>$disp_qt_of_tr_trans, 
                                                 'disp_qt_nec_trans'=>$disp_qt_nec_trans, 
                                                 'origem'=>$origem
                                                 ]);                      
    
           } else{
              $moedas =  DB::table('moedas')->where('desc_moeda','<>','Troca')
                                            ->get();  

              $disp_qt_nec_trans = $necps->quant - round($soma_qt_nec_trans,2); 
              $disp_qt_of_tr_trans = 0;

              return view('mens_transacoes_part',['part'  =>$part,
                                                'ofps'  =>$ofps,
                                                'necps' =>$necps,
                                                'msgs'  =>$msgs,
                                                'trans' =>$trans,
                                                'moedas'=>$moedas,
                                                'disp_qt_of_trans'=>$disp_qt_of_trans, 
                                                'disp_qt_of_tr_trans'=>$disp_qt_of_tr_trans, 
                                                'disp_qt_nec_trans'=>$disp_qt_nec_trans, 
                                                'origem'=>$origem
                                                ]);                      

           }                                                      
           
           
      }

      public function incluir_mens_trans(Request $request){

            $of_nec_tr = ""; 
            $id_part_of = request('id_part_of');
            $id_part_nec = request('id_part_nec');
            $id_part_of_tr = request('id_part_of_tr');

            if(request('id_logado') == $id_part_of){
               $of_nec_tr = 'of';
            }else{
                  if(request('id_logado') == $id_part_nec){
                    $of_nec_tr = 'nec';
                  } else{
                        if(request('id_logado') == $id_part_of_tr){
                           $of_nec_tr = 'tr';
                        }   
                  }     
            }  

            /*dd("Id logado: ".request('id_logado')." Id_of_part_t : ".request('id_of_part_t').
            " Id_nec_part_t : ".request('id_nec_part_t').
            " Id_of_tr_part_t : ".request('id_of_tr_part_t').
            " of_nec_tr: ".$of_nec_tr);*/
            
            $confere = DB::table('transacoes')->where('id_nec_part', request('id_nec_part_t'))
                                              ->where('id_of_part', request('id_of_part_t'))
                                              ->where('id_of_tr_part', request('id_of_tr_part_t'))
                                              ->first();

            if(!$confere) {
                
                  $trans = DB::table('transacoes')->insertGetId([
                        'id_nec_part' => request('id_nec_part_t'),
                        'id_of_part' => request('id_of_part_t'),
                        'id_of_tr_part' => request('id_of_tr_part_t'),
                        'quant_of'=>0,
                        'quant_nec'=>0,
                        'quant_of_tr'=>0,

                        /*Em andamento */
                        'id_st_trans' => 2, 

                        'data_inic' => date('Y-m-d H:i:s')
                  ]);

                  $id_trans = $trans;

            }else{
                  $id_trans = $confere->id;
            }

            $id_part_dest = 0;
            if($of_nec_tr == "of") {
               if($id_part_nec > 0){
                  $id_part_dest = $id_part_nec;
               }else{
                  $id_part_dest = $id_part_of_tr;
               }
            }else{
                  $id_part_dest = $id_part_of;
            }

            $msgs_i = DB::table('mensagens_trans')->insert([
                  'id_trans' => $id_trans,
                  'id_part' => request('id_logado'), 
                  'id_part_dest' => $id_part_dest, 
                  'mensagem' => request('mensagem'),
                  'data' => date('Y-m-d H:i:s'),
                  'of_nec_tr' => $of_nec_tr
                  
            ]);

            //Atualizar Status Ofertas e Necessidades - Pendente
            $ofp = DB::table('ofertas_part')->where('id',request('id_of_part_t'))
                                            ->select('ofertas_part.status');
            
            $ofp2 = $ofp->first();
            $ofp->update(['status'=>2]);  

            /*if($ofp2->status == 0){
               $ofp->update(['status'=>1]);
            }else{
                 if($ofp2->status == 1){
                    $ofp->update(['status'=>2]);     
                 } 
            }*/
            
            /*dd($of_nec_tr);  */

            if(($of_nec_tr == 'nec') or ($of_nec_tr == 'of')){
               $necp = DB::table('necessidades_part')->where('id',request('id_nec_part_t'))
                                                     ->select('necessidades_part.status');
               $necp2 = $necp->first();  
               $necp->update(['status'=>2]); 

               /*if($necp2->status == 0){
                  $necp->update(['status'=>1]);
               }else{
                    if($necp2->status == 1){
                       $necp->update(['status'=>2]);     
                    } 
               }*/
            
            }else{
                  if($of_nec_tr =='tr'){
                     $oftrp = DB::table('ofertas_part')->where('id',request('id_of_tr_part_t'))
                                                       ->select('ofertas_part.status');

                     $oftrp2 = $oftrp->first();                                                       
                     $oftrp->update(['status'=>2]);     

                     /*if($oftrp2->status == 0){
                        $oftrp->update(['status'=>1]);
                     }else{
                          if($oftrp2->status == 1){
                             $oftrp->update(['status'=>2]);     
                          } 
                     }*/
                     
                  }
            }

           return back();

      }  

      public function finalizar_trans(Request $request){

            $code = 0;
            $id_part_inclui_moeda = 0;
            $disp_qt_of_trans = request('disp_qt_of_trans');
            $disp_qt_of_tr_trans = request('disp_qt_of_tr_trans');
            $disp_qt_nec_trans = request('disp_qt_nec_trans');
            $QtOf = request('QtOf');
            $QtOfTr = request('QtOfTr');
            $QtNec = request('QtNec');

            if(request('id_logado')==request('id_part_of')){
               $of_nec_tr = 'of';
            }else{
                  if(request('id_logado')==request('id_part_nec')){
                    $of_nec_tr = 'nec';
                  } else{
                        if(request('id_logado')==request('id_part_of_tr')){
                           $of_nec_tr = 'tr';
                        }   
                  }     
            }  

            $trans = DB::table('transacoes')->where('id_nec_part', request('id_nec_part_t'))
                                            ->where('id_of_part', request('id_of_part_t'))
                                            ->where('id_of_tr_part', request('id_of_tr_part_t'))
                                            ->select('*')
                                            ->first();
            
            if($trans) { 
                $trans_up = DB::table('transacoes')->where('id',$trans->id);

                /*dd(request('Fluxo'));*/
                             
                $trans_up->update([
                  'quant_moeda'=>request('QtFluxo'),
                  'id_moeda'=>request('Fluxo'),
                  'quant_of'=>request('QtOf'),
                 ]);

                 if($of_nec_tr=='of'){
                   $trans_up->update(['data_final_of_part'=> date('Y-m-d H:i:s')]); 
                 }else{
                      if($of_nec_tr=='nec'){
                         $trans_up->update(['data_final_nec_part'=> date('Y-m-d H:i:s'),
                                            'quant_nec'=>request('QtNec'),
                                            'quant_of_tr'=>0,
                         ]); 
                      }else{
                           if($of_nec_tr=='tr'){ 
                              $trans_up->update(['data_final_of_tr_part'=> date('Y-m-d H:i:s'),
                                                 'quant_of_tr'=>request('QtOfTr'),
                                                 'quant_nec'=>0,
                              ]); 
                           }
                      }   
                 }

                  /*se for finalizado parcialmente então o status é 3, se for finalização total então é 4.*/

                  /*dd($trans);*/

                 if (($trans->data_final_of_part <> null) and (($trans->data_final_nec_part <> null) or (($trans->data_final_of_tr_part <> null)))){
                    $trans_up->update(['id_st_trans'=> 4]);/*Finalizada totalmente*/
                    $code = 4;
                  
                    //Incluindo registro de quantidade de moeda/fluxo no historico do participante da oferta
                   
                    
                    $moedas_part_of = DB::table('moedas_part')->updateOrInsert(
                    ['id_part'=>request('id_part_of'),'id_moeda'=>request('Fluxo'),'id_trans'=>$trans->id],  
                    ['quant_moeda'=> request('QtFluxo'),
                    'data' => date('Y-m-d H:i:s')]);
                    
                    //Incluindo registro de quantidade de moeda/fluxo no historico do participante da necessidade
                    if($of_nec_tr=='nec'){
                       $id_part_inclui_moeda = request('id_part_nec');
                       $fator = -1;
                    }else{
                        if($of_nec_tr=='tr'){
                           $id_part_inclui_moeda = request('id_part_of_tr');    
                           $fator = 1;
                        }  
                    }    

                    $moedas_part_nec = DB::table('moedas_part')->updateOrInsert(
                    ['id_part'=>$id_part_inclui_moeda,'id_moeda'=>request('Fluxo'),'id_trans'=>$trans->id],  
                    ['quant_moeda'=> request('QtFluxo') * $fator,
                    'data' => date('Y-m-d H:i:s')]);

                 }else{
                    $trans_up->update(['id_st_trans'=> 3]);/*Finalizada Parcialmente*/
                    $code = 3;
                 }

                  $trans_up = DB::table('transacoes')->where('id',$trans->id)
                                                     ->first();

                 if($trans_up) {  
                        /*Sucesso*/
                        session()->flash('code', $code);
                  }else{
                        /*Erro na atualização da transação!  */
                        session()->flash('code', 0);
                  }   

            }else{
                  $mens = DB::table('mensagens_trans')
                  ->where('transacoes.id_nec_part', request('id_nec_part_t'))
                  ->where('transacoes.id_of_part', request('id_of_part_t'))
                  ->where('transacoes.id_of_tr_part', request('id_of_tr_part_t'))

                  ->join('transacoes','mensagens_trans.id_trans','=','transacoes.id')

                  ->select('*')
                  ->first();

                  /*dd($mens);*/

                  if(!$mens){
                      /*Senão tiver mensagem incluida ainda então não pode finalizar a transação */
                      $code = 1;  
                  }else{
                      /*ao incluir uma mensagem, um registro de transação é incluido junto */
                      $code = 2;  
                  }
                  
                  session()->flash('code', $code);
            } 

            /*dd([$of_nec_tr, " OF: ",$disp_qt_of_trans,$QtOf," Nec: ",$disp_qt_nec_trans,$QtNec," Tr: ",$disp_qt_of_tr_trans,$QtOfTr," Code : ",$code]);*/
            /*dd($code);*/

            //Atualizar Status Ofertas e Necessidades
            $ofp = DB::table('ofertas_part')->where('id',request('id_of_part_t'))
                                            ->select('ofertas_part.status');
            if(($disp_qt_of_trans - $QtOf) > 0){
               $ofp->update(['status'=>3]);
            }else{
               $ofp->update(['status'=>$code]);
            }

            $necp = DB::table('necessidades_part')->where('id',request('id_nec_part_t'))
                                                  ->select('necessidades_part.status');
            if($necp){                                                  
               if(($disp_qt_nec_trans - $QtNec) > 0){
               $necp->update(['status'=>3]);
               }else{
               $necp->update(['status'=>$code]);
               }

            }
            
            $oftrp = DB::table('ofertas_part')->where('id',request('id_of_tr_part_t'))
                                              ->select('ofertas_part.status');
            if(($disp_qt_of_tr_trans - $QtOfTr) > 0){
                $oftrp->update(['status'=>3]);
            }else{
                $oftrp->update(['status'=>$code]);
            }         

            return back();     

      }
      
   public static function verifica_status_trans_of_nec_tr ($id_of_part,$id_nec_part,$id_of_tr_part){

   $status_trans = 0;      
   $trans = DB::table('transacoes')->where('transacoes.id_of_part',$id_of_part)
                                   ->where(function($verif) use ($id_nec_part,$id_of_tr_part){
                                       if($id_nec_part > 0){
                                          $verif->where('transacoes.id_nec_part',$id_nec_part);
                                       }else{
                                          if($id_of_tr_part > 0){
                                             $verif->where('transacoes.id_of_tr_part',$id_of_tr_part);
                                          }
                                       }                                               
                                    })
                                    ->first();

   if(isset($trans)){
      $status_trans = $trans->id_st_trans;
   }else{
      $status_trans = 0;
   }
   
   return($status_trans);   


   }   
      

}
