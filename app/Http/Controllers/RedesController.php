<?php

namespace App\Http\Controllers;

use App\Models\participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class RedesController extends Controller
{
    public function show_redes($id){

        $participante = participantes::FindOrfail($id);

        $redes = DB::table('redes')->orderBy('nome')->get();

        $rps = DB::table('redesparts')->where('id_part',$id)
                                      ->join('participantes','redesparts.id_part','=','participantes.id')
                                      ->join('redes','redesparts.id_rede','=','redes.id')
                                      ->select('participantes.*','redes.*','redesparts.*')
                                      ->paginate(10);

        return view('redes_part',['part' => $participante,'rps'=>$rps,'redes'=>$redes]);
    }

    public function query_redes(Request $request){

        if(isset($_GET['id_part'])){
           
            $id = $_GET['id_part'];
            
            $request->session()->put('criterio', request('consulta'));

            $participante = participantes::FindOrfail($id);

            $redes = DB::table('redes')->orderBy('nome')->get();

            if(isset($_GET['consulta'])){
                $rps = DB::table('redesparts')->where('id_part',$id)
                                              ->where(function($query){
                                                $query->where('nome','like','%'.request('consulta').'%') 
                                                      ->orwhere('descricao','like','%'.request('consulta').'%'); 
                                              })
                                          
                                              ->join('participantes','redesparts.id_part','=','participantes.id')
                                              ->join('redes','redesparts.id_rede','=','redes.id')
                                              ->select('participantes.*','redes.*','redesparts.*')
                                              ->paginate(10);
            }
            
            $rps->appends($request->all());
            return view('redes_part',['part' => $participante,'rps'=>$rps,'redes'=>$redes]);
            
        }
       } 
       
       public function consultar_todas_redes(Request $request){

            $request->session()->put('criterio', request('consulta'));

            if(isset($_GET['consulta'])){

                $string = $_GET['consulta'];

                // split on 1+ whitespace & ignore empty (eg. trailing space)
                $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);


                $redes = DB::table('redes')->where(function($query) use ($searchValues){
                                             foreach($searchValues as $value){
                                                     $query->where('nome','like','%'.$value.'%') 
                                                     ->orwhere('descricao','like','%'.$value.'%') 
                                                     ->orwhere('nome_part','like','%'.$value.'%') 
                                                     ->orwhere('data_inic','like','%'.$value.'%'); 
                                              }      
                                              })
                                              ->join('participantes','redes.id_part_inic','=','participantes.id')
                                              ->select(
                                                'redes.id',
                                                'redes.nome',
                                                'redes.descricao',
                                                'redes.data_inic',
                                                'redes.id_part_inic',
                                                'participantes.imagem as imagem_part',
                                                'participantes.nome_part'
                                                )
                                              ->paginate(10);
            }
            else
            {
                $redes = DB::table('redes')->join('participantes','redes.id_part_inic','=','participantes.id')
                                           ->select(
                                               'redes.id',
                                               'redes.nome',
                                               'redes.descricao',
                                               'redes.data_inic',
                                               'redes.id_part_inic',
                                               'participantes.imagem as imagem_part',
                                               'participantes.nome_part'
                                               )
                                           ->paginate(10);
            }

           /* dd ($redes);*/
            
            $redes->appends($request->all());
            return view('consultar_todas_redes',['redes'=>$redes]);

       }      

    public function incluir_redes_part(Request $request) {

       
        $rps = DB::table('redesparts')->where('id_rede',request('id_rede'))
                                        ->where('id_part',request('id_part'))
                                        ->first();
                        
        if(!$rps){
            $rps_i = DB::table('redesparts')->insert([
                'id_part' => request('id_part'),
                'id_rede' => request('id_rede')
            ]);
            return back()->with('success','Rede incluida com sucesso para o participante!');

        }else{
            return back()->with('fail','Rede já existente para esse Participante!');
        }

                      
    }  

    public function nova_rede(Request $request) {
    
        $rede = DB::table('redes')->where('nome',request('nome'))                                      
                                  ->first();
                        
        if(!$rede){
            $r = DB::table('redes')->insert([
                'nome' => request('nome'),
                'descricao' => request('descricao'),
                'id_part_inic' => request('id_part_inic'),
                'data_inic' => Date('Y-m-d')
            ]);
            return back()->with('success','Rede incluida com sucesso!');
        }else{
            return back()->with('fail','Rede já existente!');
        }
    } 
    
    public function deleta_rede_part($id){
      
        $rp = DB::table('redesparts')->where('id','=',$id)->delete();  
              
        if($rp){
            return back()->with('success','Rede excluida com sucesso para o participante!');
        }else{
            return back()->with('fail','Erro na exclusão da rede do participante!');
        }
    }

    public function deleta_rede($id){

        $rp = DB::table('redesparts')->where('id_rede',$id)->first();

       /* dd($id,$rp);*/

        if(!$rp){

            $r = DB::table('redes')->where('id','=',$id)->delete();  
                
            if($r){
                return back()->with('success','Rede excluida com sucesso!');
            }else{
                return back()->with('fail','Erro na exclusão da rede!');
            }
        }else{
             return back()->with('fail','Erro na exclusão da rede! Rede está sendo usada por algum participante!');
        }
    }         
}
