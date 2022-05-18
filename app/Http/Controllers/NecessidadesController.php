<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\participantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class NecessidadesController extends Controller
{

  public static function verifica_sugestoes_nec ($id_part,$desc_cat,$desc_nec,$obs,$filtra_id_logado){

    $string = $desc_cat." ".$desc_nec." ".$obs;

    // split on 1+ whitespace & ignore empty (eg. trailing space)
    $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);   
   
    $ofps = DB::table('ofertas_part')->where(function($verif) use ($filtra_id_logado,$id_part){
                                              if($filtra_id_logado){
                                                $verif->where('ofertas_part.id_part',"<>",$id_part);
                                              }else{
                                                $verif->where('ofertas_part.id_part',"=",$id_part);
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
        

        ->selectRaw('participantes.id as id_part,participantes.nome_part,
                    participantes.nome_part,ofertas_part.id as id_of_part,
                   ofertas_part.id_of,ofertas_part.quant,ofertas_part.data,
                   ofertas_part.obs,ofertas.descricao as desc_of,
                   categorias.descricao as desc_cat') 

        ->get();
      
    $conta_sugestoes = $ofps->count();          

    return ($conta_sugestoes);
    
  }

    public function index(){
      
        $necps = DB::table('necessidades_part')->where('id','>',0)
                                          ->orderBy('id','desc')
                                          ->paginate(10);
                  
        return view('necessidades',['necps' => $necps]);
      }

      public function show_none(){
    
        return view('necessidades');
      }

      public function consultar_necessidades(Request $request){

            $num_linhas_por_pag = 5;

            if(isset($_GET['consulta_nec'])){

              $request->session()->put('criterio_nec', request('consulta_nec')); 

              $string = $_GET['consulta_nec'];

              // split on 1+ whitespace & ignore empty (eg. trailing space)
              $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     
    
              $necps = DB::table('necessidades_part')->where(function($query) use ($searchValues){
                                                      foreach ($searchValues as $value) {
                                                      $query->orwhere('obs','like','%'.($value).'%')
                                                            ->orwhere('nome_part','like','%'.($value).'%')
                                                            ->orwhere('necessidades.descricao','like','%'.($value).'%')
                                                            ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                            ->orwhere('unidades.descricao','like','%'.($value).'%')
                                                            ->orwhere('necessidades_part.quant','like','%'.($value).'%')
                                                            ->orwhere('data','like','%'.($value).'%')
                                                            ->orwhere('participantes.endereco','like','%'.($value).'%')
                                                            ->orwhere('participantes.cidade','like','%'.($value).'%')
                                                            ->orwhere('participantes.estado','like','%'.($value).'%')
                                                            ->orwhere('participantes.pais','like','%'.($value).'%');
                                                      }      
                                                })
                                  
                                                ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                                ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                                ->join('categorias','necessidades.id_cat','=','categorias.id')
                                                ->join('unidades','necessidades.id_unid','=','unidades.id')

                                                ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                'necessidades_part.id as id_nec_part',
                                                'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs','necessidades.descricao as desc_nec',
                                                'necessidades_part.status','necessidades_part.imagem',
                                                'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                                ->orderBy('data','desc')
                                                ->orderBy('id_nec_part','desc')
                                                ->paginate($num_linhas_por_pag);

            $necps->appends($request->all());  
            
            $necps_map = DB::table('necessidades_part')->where(function($query) use ($searchValues){
              foreach ($searchValues as $value) {
              $query->orwhere('obs','like','%'.($value).'%')
                    ->orwhere('nome_part','like','%'.($value).'%')
                    ->orwhere('necessidades.descricao','like','%'.($value).'%')
                    ->orwhere('categorias.descricao','like','%'.($value).'%')
                    ->orwhere('unidades.descricao','like','%'.($value).'%')
                    ->orwhere('necessidades_part.quant','like','%'.($value).'%')
                    ->orwhere('data','like','%'.($value).'%')
                    ->orwhere('participantes.endereco','like','%'.($value).'%')
                    ->orwhere('participantes.cidade','like','%'.($value).'%')
                    ->orwhere('participantes.estado','like','%'.($value).'%')
                    ->orwhere('participantes.pais','like','%'.($value).'%')
                    ;

              }      
              })

              ->join('participantes','necessidades_part.id_part','=','participantes.id')
              ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
              ->join('categorias','necessidades.id_cat','=','categorias.id')
              ->join('unidades','necessidades.id_unid','=','unidades.id')

              ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
              'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
              'necessidades_part.id as id_nec_part','necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs',
              'necessidades_part.status','necessidades_part.imagem',
              'necessidades.descricao as desc_nec','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

              ->orderBy('data','desc')
              ->orderBy('id_nec_part','desc')
              ->get();

            return view('necessidades',['necps'=>$necps,'necps_map'=>$necps_map]);

          }else{
            $necps = DB::table('necessidades_part')->where('necessidades_part.id','>',0) 
                                              ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                              ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                              ->join('categorias','necessidades.id_cat','=','categorias.id')
                                              ->join('unidades','necessidades.id_unid','=','unidades.id')

                                              ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part','necessidades_part.id as id_nec_part',
                                              'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                              'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs','necessidades.descricao as desc_nec',
                                              'necessidades_part.status','necessidades_part.imagem',
                                              'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                              ->orderBy('data','desc')
                                              ->orderBy('id_nec_part','desc')
                                              ->paginate($num_linhas_por_pag);

            $necps->appends($request->all());    

            $necps_map = DB::table('necessidades_part')->where('necessidades_part.id','>',0) 
                                              ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                              ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                              ->join('categorias','necessidades.id_cat','=','categorias.id')
                                              ->join('unidades','necessidades.id_unid','=','unidades.id')

                                              ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                      'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                      'necessidades_part.id as id_nec_part','necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs',
                                                      'necessidades_part.status','necessidades_part.imagem',
                                                      'necessidades.descricao as desc_nec','categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                              ->orderBy('data','desc')
                                              ->orderBy('id_nec_part','desc')
                                              ->get();

            return view('necessidades',['necps'=>$necps,'necps_map'=>$necps_map]);
          }
      }  
    

    public function consultar_necessidades_part(Request $request){

      if(isset($_GET['id_part'])){
         
        $id = $_GET['id_part'];

        $request->session()->put('criterio_nec_part', request('consulta_nec_part')); 

        $participante = participantes::FindOrfail($id);

        $necs = DB::table('necessidades')->orderBy('descricao')->get();
        $cats = DB::table('categorias')->orderBy('descricao')->get();
        $unids = DB::table('unidades')->orderBy('descricao')->get();

        if(isset($_GET['consulta_nec_part'])){

          $string = $_GET['consulta_nec_part'];

          // split on 1+ whitespace & ignore empty (eg. trailing space)
          $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     

          $necps = DB::table('necessidades_part')->where('id_part',$id)
                                           ->where(function($query) use ($searchValues){
                                                  foreach ($searchValues as $value) {
                                                  $query->orwhere('obs','like','%'.($value).'%')
                                                        ->orwhere('necessidades.descricao','like','%'.($value).'%')
                                                        ->orwhere('categorias.descricao','like','%'.($value).'%')
                                                        ->orwhere('unidades.descricao','like','%'.($value).'%')
                                                        ->orwhere('necessidades_part.quant','like','%'.($value).'%')
                                                        ->orwhere('data','like','%'.($value).'%');
                                                  }      
                                            })

                                          ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                          ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                          ->join('categorias','necessidades.id_cat','=','categorias.id')
                                          ->join('unidades','necessidades.id_unid','=','unidades.id')

                                          ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                'necessidades_part.id as id_nec_part',
                                                'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs','necessidades.descricao as desc_nec',
                                                'necessidades_part.status','necessidades_part.imagem',
                                                'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                          ->orderBy('data','desc')
                                          ->orderBy('id_nec_part','desc')
                                          ->paginate(5);

      }
      
      $necps->appends($request->all());    
      
      return view('consultar_necessidades_part',['part' => $participante,'necps'=>$necps,'necs'=>$necs,'cats'=>$cats,'unids'=>$unids]);
    }  
  }

    public function show_necessidades_part($id){

      $participante = participantes::FindOrfail($id);

      $necs = DB::table('necessidades')->orderBy('descricao')->get();
      $cats = DB::table('categorias')->orderBy('descricao')->get();
      $unids = DB::table('unidades')->orderBy('descricao')->get();
                                                     
      $necps = DB::table('necessidades_part')->where('id_part',$id)
                                    ->join('participantes','necessidades_part.id_part','=','participantes.id')
                                    ->join('necessidades','necessidades_part.id_nec','=','necessidades.id')
                                    ->join('categorias','necessidades.id_cat','=','categorias.id')
                                    ->join('unidades','necessidades.id_unid','=','unidades.id')
                                    
                                    ->select('participantes.id as id_part','participantes.latitude','participantes.longitude','participantes.nome_part',
                                                'necessidades_part.id as id_nec_part',
                                                'participantes.endereco','participantes.cidade','participantes.estado','participantes.pais',
                                                'necessidades_part.id_nec','necessidades_part.quant','necessidades_part.data','necessidades_part.obs','necessidades.descricao as desc_nec',
                                                'necessidades_part.status','necessidades_part.imagem',
                                                'categorias.descricao as desc_cat','unidades.descricao as desc_unid')

                                    ->orderBy('data','desc')
                                    ->orderBy('id_nec_part','desc')
                                    ->paginate(5);

      
      return view('consultar_necessidades_part',['part' => $participante,'necps'=>$necps,'necs'=>$necs,'cats'=>$cats,'unids'=>$unids]);
    }

  public function incluir_necessidades_part(Request $request) {

       
    /*$necps = DB::table('necessidades_part')->where('id_nec',request('id_nec'))
                                     ->where('id_part',request('id_part'))
                                     ->first();*/


      if($request->hasFile('sel_img')){
      $file = $request->file('sel_img');

      $size = $file->getSize();

      if($size > 5000000){
          return back()->with('fail size','tamanho maior do que o permitido!');
      }

      $extension = $file->getClientOriginalExtension();
      
      if($extension == 'jpg' or $extension == 'jpeg' or $extension == 'png'){

        $filename = request('id_nec').'_'.request('id_part').'_'.time().'.'.$extension;
        $file->move('uploads/nec_img/',$filename);

      }else{
          return back()->with('fail type','Tipo de imagem não permitido!');
      }
      
    }

                    
    /*if(!$necps){*/
        $necps_i = DB::table('necessidades_part')->insert([
            'id_nec' => request('id_nec'),
            'id_part' => request('id_part'),
            'data' => request('data_nec'),
            'quant' => request('quant_nec'),
            'obs' => request('obs_nec'),
            'imagem' => $filename

        ]);
        return back()->with('success','necessidade incluida com sucesso para o participante!');

    /*}else{
        return back()->with('fail','necessidade já existente para esse participante!');
    }*/

                  
  }  

  public function deleta_necessidade_part($id){
      
    $rp = DB::table('necessidades_part')->where('id','=',$id)->delete();  
          
    if($rp){
        return back()->with('success','necessidade do participante excluida com sucesso!');
    }else{
        return back()->with('fail','Erro na exclusão da necessidade do participante!');
    }
  }  

  public function altera_necessidade_part(Request $request){


    if($request->hasFile('sel_img_alt')){
      $file = $request->file('sel_img_alt');

      $size = $file->getSize();

      if($size > 5000000){
         return back()->with('fail size','tamanho maior do que o permitido!');
      }

      $extension = $file->getClientOriginalExtension();
      
      if($extension == 'jpg' or $extension == 'jpeg' or $extension == 'png'){

        $necp = DB::table('necessidades_part')->where('id',request('id_nec_part'))->first();

        if($necp){
          //Deleta a imagem anterior antes de incluir a nova.
          $file_name_ant = $necp->imagem;
          File::delete(public_path('uploads/nec_img/'.$file_name_ant));
        }

        $filename = request('id_nec').'_'.request('id_part').'_'.time().'.'.$extension;
        $file->move('uploads/nec_img/',$filename);

        $rp = DB::table('necessidades_part')->where('id',request('id_nec_part'))
                                   ->update(['id_nec' => request('id_nec'),
                                            'id_part' => request('id_part'),
                                            'data' => request('data_nec'), 
                                            'quant' => request('quant_nec'), 
                                            'obs' => request('obs_nec'), 
                                            'imagem'=>$filename
                                            ], 
                                  );  

      }else{
          return back()->with('fail type','Tipo de imagem não permitido!');
      }
      
    }else{

      $rp = DB::table('necessidades_part')->where('id',request('id_nec_part'))
                                   ->update(['id_nec' => request('id_nec'),
                                            'id_part' => request('id_part'),
                                            'data' => request('data_nec'), 
                                            'quant' => request('quant_nec'), 
                                            'obs' => request('obs_nec') 
                                            ], 
                                  );  
    }
          
    if($rp){
      return back()->with('success','necessidade do participante alterada com sucesso!');
    }else{
      return back()->with('fail','Não houve alteração da necessidade do participante!');
    }
      
  }   


  public function nova_necessidade(Request $request) {
    
    $necessidade = DB::table('necessidades')->where('descricao',request('descricao'))                                      
                              ->first();
                    
    if(!$necessidade){
        $r = DB::table('necessidades')->insert([
            'descricao' => request('descricao'),
            'status' =>  1,
            'id_cat' => request('categoria'),
            'id_unid' => request('unidade'),
        ]);
        return back()->with('success','Tipo de Necessidade incluida com sucesso!');
    }else{
        return back()->with('fail','Tipo de Necessidade já existente!');
    }
} 

}
