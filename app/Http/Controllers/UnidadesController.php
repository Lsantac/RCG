<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadesController extends Controller
{

    public function show_unidades(Request $request){

        
        $uns = DB::table('unidades')->orderBy('descricao')
                                      
                                      ->paginate(10);

        $uns->appends($request->all());     

        /*dd($uns); */

        return view('unidades',['uns' => $uns]);
    }

    public function query_unidades(Request $request){
    
            
            $request->session()->put('criterio', request('consulta'));

            if(isset($_GET['consulta'])){
                $uns = DB::table('unidades')->where(function($query){
                                                $query->where('descricao','like','%'.request('consulta').'%'); 
                                                      
                                              })
                                              ->orderBy('descricao')
                                              
                                              ->paginate(10);
            }
            
            $uns->appends($request->all());
            return view('unidades',['uns' => $uns]);
            
        
       }   


    public function nova_unidade(Request $request) {
    
        $un = DB::table('unidades')->where('descricao',request('descricao'))                                      
                                     ->first();
                
        if(!$un){
            $u = DB::table('unidades')->insert([
                'descricao' => request('descricao'),
                'dt_criacao' => date('Y-m-d H:i:s')
            ]);
            if($u){
                return back()->with('success','Unidade incluida com sucesso!');
            }else{
                return back()->with('fail','Erro na inclusão da unidade!');
            }
            
        }else{
            return back()->with('fail','Unidade já existente!');
        }
    } 
    
    public function deleta_unidade($id){

        $ofs = DB::table('ofertas')->where('id_unid','=',$id)->first();  

        if($ofs){
            return back()->with('fail','Unidade não pode ser excluida pois já está sendo usada por algum tipo de Oferta!');
        }else{
            $necs = DB::table('necessidades')->where('id_unid','=',$id)->first(); 

            if($necs){
                return back()->with('fail','Unidade não pode ser excluida pois já está sendo usada por algum tipo de Necessidade!');
            }else{

                $uns = DB::table('unidades')->where('id','=',$id)->delete();  
                    
                if($uns){
                    return back()->with('success','Unidade excluida com sucesso!');    
                }else{
                    return back()->with('fail','Erro na exclusão da Unidade!');
                }

            }    
        } 
        
    }
}