<?php

namespace App\Http\Controllers;

use App\Models\participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAlterPartRequest;

class ofertasController extends Controller
{

  public static function verifica_sugestoes_of ($id_part,$desc_cat,$desc_of,$obs,$filtra_id_logado){

    $string = $desc_cat." ".$desc_of." ".$obs;

    // split on 1+ whitespace & ignore empty (eg. trailing space)
    $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
   
    $necps = DB::table('necessidades_part')->where(function($verif) use ($filtra_id_logado,$id_part){
                                              if($filtra_id_logado){
                                                $verif->where('necessidades_part.id_part',"<>",$id_part);
                                              }else{
                                                $verif->where('necessidades_part.id_part',"=",$id_part);
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
        
        ->selectRaw('participantes.id as id_part,participantes.nome_part,participantes.latitude,participantes.longitude,
                    participantes.nome_part,necessidades_part.id as id_nec_part,
                   necessidades_part.id_nec,necessidades_part.quant,necessidades_part.data,
                   necessidades_part.obs,necessidades.descricao as desc_nec,
                   categorias.descricao as desc_cat') 
             
              ->get();

    
    $conta_sugestoes = $necps->count();          

    return ($conta_sugestoes);
    
  }
  
    public function index(){
      
        $ofps = DB::table('ofertas_part')->where('id','>',0)
                                          ->orderBy('id','desc')
                                          ->paginate(10);
                  
        return view('ofertas',['ofps' => $ofps]);
      }

      public function show_none(){
    
        return view('ofertas');
      }

      public function consultar_ofertas(Request $request){

            $num_linhas_por_pag = 5;

            if(isset($_GET['consulta_of'])){
              
              $request->session()->put('criterio_of', request('consulta_of')); 

              $string = $_GET['consulta_of'];

              // split on 1+ whitespace & ignore empty (eg. trailing space)
              $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     
    
              $ofps = DB::table('ofertas_part')->where(function($query) use ($searchValues){
                                                      foreach ($searchValues as $value) {
                                                      $query->orwhere('obs','like','%'.($value).'%')
                                                            ->orwhere('nome_part','like','%'.($value).'%')
                                                            ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                                            ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                            ->orwhere('unidades.descricao','like','%'.($value).'%')
                                                            ->orwhere('ofertas_part.quant','like','%'.($value).'%')
                                                            ->orwhere('data','like','%'.($value).'%')
                                                            ->orwhere('participantes.endereco','like','%'.($value).'%')
                                                            ->orwhere('participantes.cidade','like','%'.($value).'%')
                                                            ->orwhere('participantes.estado','like','%'.($value).'%')
                                                            ->orwhere('participantes.pais','like','%'.($value).'%')
                                                            ;

                                                      }      
                                                })
                                  
                                                ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                                ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                                ->join('categorias','ofertas.id_cat','=','categorias.id')
                                                ->join('unidades','ofertas.id_unid','=','unidades.id')

                                                ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                'ofertas_part.id as id_of_part','ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs',
                                                'ofertas_part.status',
                                                'ofertas.descricao as desc_of','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                                ->orderBy('data','desc')
                                                ->paginate($num_linhas_por_pag);
            
            $ofps->appends($request->all());  
            
            $ofps_map = DB::table('ofertas_part')->where(function($query) use ($searchValues){
                          foreach ($searchValues as $value) {
                          $query->orwhere('obs','like','%'.($value).'%')
                                ->orwhere('nome_part','like','%'.($value).'%')
                                ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                ->orwhere('categorias.descricao','like','%'.($value).'%')
                                ->orwhere('unidades.descricao','like','%'.($value).'%')
                                ->orwhere('ofertas_part.quant','like','%'.($value).'%')
                                ->orwhere('data','like','%'.($value).'%')
                                ->orwhere('participantes.endereco','like','%'.($value).'%')
                                ->orwhere('participantes.cidade','like','%'.($value).'%')
                                ->orwhere('participantes.estado','like','%'.($value).'%')
                                ->orwhere('participantes.pais','like','%'.($value).'%')
                                ;

                          }      
                    })

                    ->join('participantes','ofertas_part.id_part','=','participantes.id')
                    ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                    ->join('categorias','ofertas.id_cat','=','categorias.id')
                    ->join('unidades','ofertas.id_unid','=','unidades.id')

                    ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                    'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                    'ofertas_part.id as id_of_part','ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs',
                    'ofertas_part.status',
                    'ofertas.descricao as desc_of','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                    ->orderBy('data','desc')
                    ->get();

          }else{
            $ofps = DB::table('ofertas_part')->where('ofertas_part.id','>',0) 
                                              ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                              ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                              ->join('categorias','ofertas.id_cat','=','categorias.id')
                                              ->join('unidades','ofertas.id_unid','=','unidades.id')

                                              ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                      'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                      'ofertas_part.id as id_of_part','ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs',
                                                      'ofertas_part.status',
                                                      'ofertas.descricao as desc_of','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                              ->orderBy('data','desc')
                                              ->paginate($num_linhas_por_pag);


            $ofps->appends($request->all());    

            $ofps_map = DB::table('ofertas_part')->where('ofertas_part.id','>',0) 
                                              ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                              ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                              ->join('categorias','ofertas.id_cat','=','categorias.id')
                                              ->join('unidades','ofertas.id_unid','=','unidades.id')

                                              ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                      'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                      'ofertas_part.id as id_of_part','ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs',
                                                      'ofertas_part.status',
                                                      'ofertas.descricao as desc_of','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                              ->orderBy('data','desc')
                                              ->get();
            
          }
          return view('ofertas',['ofps'=>$ofps,'ofps_map'=>$ofps_map]);
      }  
    

    public function consultar_ofertas_part(Request $request){

      if(isset($_GET['id_part'])){
         
        $id = $_GET['id_part'];

        $request->session()->put('criterio_of_part', request('consulta_of_part')); 

        $participante = participantes::FindOrfail($id);

        $ofs = DB::table('ofertas')->orderBy('descricao')->get();
        $cats = DB::table('categorias')->orderBy('descricao')->get();
        $unids = DB::table('unidades')->orderBy('descricao')->get();

        if(isset($_GET['consulta_of_part'])){

          $string = $_GET['consulta_of_part'];

          // split on 1+ whitespace & ignore empty (eg. trailing space)
          $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     

          $ofps = DB::table('ofertas_part')->where('id_part',$id)
                                           ->where(function($query) use ($searchValues){
                                                  foreach ($searchValues as $value) {
                                                  $query->orwhere('obs','like','%'.($value).'%')
                                                        ->orwhere('ofertas.descricao','like','%'.($value).'%')
                                                        ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                        ->orwhere('unidades.descricao','like','%'.($value).'%')
                                                        ->orwhere('ofertas_part.quant','like','%'.($value).'%')
                                                        ->orwhere('data','like','%'.($value).'%');
                                                  }      
                                            })

                                          ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                          ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                          ->join('categorias','ofertas.id_cat','=','categorias.id')
                                          ->join('unidades','ofertas.id_unid','=','unidades.id')

                                          ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part','ofertas_part.id as id_of_part',
                                                'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs','ofertas.descricao as desc_of',
                                                'ofertas_part.status',
                                                'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                          ->orderBy('data','desc')
                                          ->paginate(5);

      }
      
      $ofps->appends($request->all());    
      
      return view('consultar_ofertas_part',['part' => $participante,'ofps'=>$ofps,'ofs'=>$ofs,'cats'=>$cats,'unids'=>$unids]);
    }  
  }

    public function show_ofertas_part($id){

      $participante = participantes::FindOrfail($id);

      $ofs = DB::table('ofertas')->orderBy('descricao')->get();
      $cats = DB::table('categorias')->orderBy('descricao')->get();
      $unids = DB::table('unidades')->orderBy('descricao')->get();
                                                
      $ofps = DB::table('ofertas_part')->where('id_part',$id)
                                    ->join('participantes','ofertas_part.id_part','=','participantes.id')
                                    ->join('ofertas','ofertas_part.id_of','=','ofertas.id')
                                    ->join('categorias','ofertas.id_cat','=','categorias.id')
                                    ->join('unidades','ofertas.id_unid','=','unidades.id')
                                    
                                    ->select('participantes.id as id_part','participantes.latitude','participantes.longitude',
                                    'participantes.nome_part','ofertas_part.id as id_of_part','ofertas_part.imagem',
                                    'ofertas_part.id_of','ofertas_part.quant','ofertas_part.data','ofertas_part.obs',
                                    'ofertas.descricao as desc_of','ofertas_part.status',
                                    'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                    ->orderBy('data','desc')
                                    ->paginate(5);

      /*dd($ofps);      */

      return view('consultar_ofertas_part',['part' => $participante,'ofps'=>$ofps,'ofs'=>$ofs,'cats'=>$cats,'unids'=>$unids]);
    }

  public function incluir_ofertas_part(StoreAlterPartRequest $request) {

       
   /* $ofps = DB::table('ofertas_part')->where('id_of',request('id_of'))
                                     ->where('id_part',request('id_part'))
                                     ->first();*/
                    
    /*if(!$ofps){*/

          /*dd($request->hasFile('sel_image'));*/

          if($request->hasFile('sel_image')){
              $file = $request->file('sel_image');
              $extension = $file->getClientOriginalExtension();

              
              if($extension == 'jpg' or $extension == 'jpeg' or $extension == 'png'){
                 $filename = request('id_of').$extension;
                 $file->move('uploads/of_img/',$filename);

                 
              
              }else{
                  return back()->with('fail type','Tipo de imagem não permitido!');
              }
              
           }

           $ofps_i = DB::table('ofertas_part')->insert([
                            'id_of' => request('id_of'),
                            'id_part' => request('id_part'),
                            'data' => request('data_of'),
                            'quant' => request('quant_of'),
                            'obs' => request('obs_of'),
                            'imagem'=>$filename
                        ]);
                        
            return back()->with('success','Oferta incluida com sucesso para o participante!');

    /*}else{
        return back()->with('fail','Oferta já existente para esse participante!');
    }*/

                  
  }  

  public function deleta_oferta_part($id){
      
    $rp = DB::table('ofertas_part')->where('id','=',$id)->delete();  
          
    if($rp){
        return back()->with('success','Oferta do participante excluida com sucesso!');
    }else{
        return back()->with('fail','Erro na exclusão da oferta do participante!');
    }
  }  

  public function altera_oferta_part(Request $request){
      
    $rp = DB::table('ofertas_part')->where('id',request('id_of_part'))
                                   ->update(['id_of' => request('id_of'),
                                            'id_part' => request('id_part'),
                                            'data' => request('data_of'), 
                                            'quant' => request('quant_of'), 
                                            'obs' => request('obs_of'), 
                                            ], 
                                  );  
                                  
          
    if($rp){
      return back()->with('success','Oferta do participante alterada com sucesso!');
    }else{
      return back()->with('fail','Não houve alteração da oferta do participante!');
    }
      
  }   


  public function nova_oferta(Request $request) {
    
    $oferta = DB::table('ofertas')->where('descricao',request('descricao'))                                      
                              ->first();
                    
    if(!$oferta){
        $r = DB::table('ofertas')->insert([
            'descricao' => request('descricao'),
            'status' =>  1,
            'id_cat' => request('categoria'),
            'id_unid' => request('unidade'),
        ]);
        return back()->with('success','Tipo de Oferta incluida com sucesso!');
    }else{
        return back()->with('fail','Tipo de Oferta já existente!');
    }
  } 


}
