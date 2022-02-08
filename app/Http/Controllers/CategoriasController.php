<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{

    public function show_categorias(Request $request){

        
        $cats = DB::table('categorias')->orderBy('descricao')
                                      
                                      ->paginate(10);

        $cats->appends($request->all());     

        /*dd($cats); */

        return view('categorias',['cats' => $cats]);
    }

    public function query_categorias(Request $request){
    
            
            $request->session()->put('criterio', request('consulta'));

            if(isset($_GET['consulta'])){
                $cats = DB::table('categorias')->where(function($query){
                                                $query->where('descricao','like','%'.request('consulta').'%'); 
                                                      
                                              })
                                              ->orderBy('descricao')
                                              
                                              ->paginate(10);
            }
            
            $cats->appends($request->all());
            return view('categorias',['cats' => $cats]);
            
        
       }   


    public function nova_categoria(Request $request) {
    
        $cat = DB::table('categorias')->where('descricao',request('descricao'))                                      
                                     ->first();

        $id_part = Session('id_logado');                                     
                        
        if(!$cat){
            $c = DB::table('categorias')->insert([
                'descricao' => request('descricao'),
                'id_part_cat'  => $id_part,
                'dt_criacao' => date('Y-m-d H:i:s')
            ]);
            if($c){
                return back()->with('success','Categoria incluida com sucesso!');
            }else{
                return back()->with('fail','Erro na inclusão da categoria!');
            }
            
        }else{
            return back()->with('fail','Categoria já existente!');
        }
    } 
    
    public function deleta_categoria($id){

        $ofs = DB::table('ofertas')->where('id_cat','=',$id)->first();  

        if($ofs){
            return back()->with('fail','Categoria não pode ser excluida pois já está sendo usada por algum participante!');
        }else{
            $necs = DB::table('necessidades')->where('id_cat','=',$id)->first(); 

            if($necs){
                return back()->with('fail','Categoria não pode ser excluida pois já está sendo usada por algum participante!');
            }else{

                $cats = DB::table('categorias')->where('id','=',$id)->delete();  
                    
                if($cats){
                    return back()->with('success','Categoria excluida com sucesso!');    
                }else{
                    return back()->with('fail','Erro na exclusão da categoria!');
                }

            }    
        } 
        
    }
}
