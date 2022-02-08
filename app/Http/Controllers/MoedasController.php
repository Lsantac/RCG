<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoedasController extends Controller
{

    public function show_moedas(Request $request){

        
        $moedas = DB::table('moedas')->orderBy('desc_moeda')
                                      
                                      ->paginate(10);

        $moedas->appends($request->all());     

        /*dd($moedas); */

        return view('moedas',['moedas' => $moedas]);
    }

    public function query_moedas(Request $request){

        $string = request('consulta');

        // split on 1+ whitespace & ignore empty (eg. trailing space)
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     
    
        $request->session()->put('criterio', request('consulta'));

        if(isset($_GET['consulta'])){
            $moedas = DB::table('moedas')->where(function($query) use ($searchValues){
                                         foreach ($searchValues as $value) {
                                                  $query->orwhere('desc_moeda','like','%'.($value).'%') 
                                                        ->orwhere('obs','like','%'.($value).'%')
                                                        ->orwhere('dt_criacao','like','%'.($value).'%')
                                                  ;}                                                 
                                         })
                                         ->orderBy('desc_moeda')
                                         ->paginate(10);

            $moedas->appends($request->all());

            return view('moedas',['moedas' => $moedas]);

            }
        
       }   


    public function nova_moeda(Request $request) {
    
        $moeda = DB::table('moedas')->where('desc_moeda',request('desc_moeda'))                                      
                                     ->first();

        $id_part = Session('id_logado');                                     
                        
        if(!$moeda){
            $m = DB::table('moedas')->insert([
                'desc_moeda' => request('desc_moeda'),
                'obs'=>request('obs'),
                'id_part_moeda' => $id_part,
                'dt_criacao' => date('Y-m-d H:i:s')
            ]);
            if($m){
                return back()->with('success','Moeda incluida com sucesso!');
            }else{
                return back()->with('fail','Erro na inclusão da moeda!');
            }
            
        }else{
            return back()->with('fail','Moeda já existente!');
        }
    } 
    
    public function deleta_moeda($id){

        $trans = DB::table('transacoes')->where('id_moeda','=',$id)->first();  

        if($trans){
            return back()->with('fail','Moeda não pode ser excluida pois já está sendo usada em alguma transação!');
        }else{
            
                $moedas = DB::table('moedas')->where('id','=',$id)->delete();  
                    
                if($moedas){
                    return back()->with('success','Moeda excluida com sucesso!');    
                }else{
                    return back()->with('fail','Erro na exclusão da Moeda!');
                }

                
        } 
        
    }
}
