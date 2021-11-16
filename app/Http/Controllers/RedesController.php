<?php

namespace App\Http\Controllers;

use App\Models\participantes;
use Illuminate\Http\Request;
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
                'descricao' => request('descricao')
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
      
}
