<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlterPartRequest;
use App\Models\participantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Helpers\Helper;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ParticipantesController extends Controller

    {
        public function index(){
      
          $participantes = participantes::all()->paginate(10);
                    
          return view('participantes',['participantes' => $participantes]);
        }

        public function show_none(){
      
          $redes = DB::table('redes')->orderBy('nome')->get();
                    
          return view('participantes',['redes'=>$redes]);
        }

        public function query(Request $request){

          /*$request->session()->put('cons_rede', false);*/
          $request->session()->put('criterio_cons_part', request('consulta')); 
          $request->session()->put('criterio_cons_rede', request('consulta_redes')); 

          $redes = DB::table('redes')->orderBy('nome')->get();

          if(request('consulta')){

            $string = $_GET['consulta'];

            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     

            if(request('consulta_redes')){
                  $searchRede = request('consulta_redes');

                  $part = DB::table('redesparts')->where('redes.nome','like','%'.$searchRede.'%')
                                                 ->where(function($query) use ($searchValues){
                                                          foreach ($searchValues as $value) {
                                                          $query->orwhere('nome_part','like','%'.$value.'%')
                                                                ->orwhere('endereco','like','%'.$value.'%')
                                                                ->orwhere('cidade','like','%'.$value.'%')
                                                                ->orwhere('cep','like','%'.$value.'%')
                                                                ->orwhere('email','like','%'.$value.'%')
                                                                ->orwhere('estado','like','%'.$value.'%');
                                                                
                                                          }      
                                                    })

                                                    ->join('participantes','redesparts.id_part','=','participantes.id')
                                                    ->join('redes','redesparts.id_rede','=','redes.id')

                                                    ->select('participantes.*','redes.nome as nome_rede')
                                                    
                                                    ->orderBy('nome_part','asc')
                                                    ->paginate(10);

                  $part->appends($request->all());
                  $request->session()->put('cons_rede', true);
                  return view('participantes',['part'=>$part,'redes'=>$redes]);      
                                                    
            }else{

                 $part = DB::table('participantes')->where(function($query) use ($searchValues){
                    foreach ($searchValues as $value) {
                    $query->orwhere('nome_part','like','%'.$value.'%')
                          ->orwhere('endereco','like','%'.$value.'%')
                          ->orwhere('cidade','like','%'.$value.'%')
                          ->orwhere('cep','like','%'.$value.'%')
                          ->orwhere('email','like','%'.$value.'%')
                          ->orwhere('estado','like','%'.$value.'%');
                          
                    }      
                  })
                
                  ->orderBy('nome_part','asc')
                  ->paginate(10);

                  $part->appends($request->all());
                  $request->session()->put('cons_rede', false);
                  return view('participantes',['part'=>$part,'redes'=>$redes]);
            }
             
          }else{
                if(request('consulta_redes')){

                  $searchRede = request('consulta_redes');

                  $part = DB::table('redesparts')->where('redes.nome','like','%'.$searchRede.'%')
                                                
                                                    ->join('participantes','redesparts.id_part','=','participantes.id')
                                                    ->join('redes','redesparts.id_rede','=','redes.id')

                                                    ->select('participantes.*','redes.nome as nome_rede')
                                                    
                                                    ->orderBy('nome_part','asc')
                                                    ->paginate(10);

                  $part->appends($request->all());
                  $request->session()->put('cons_rede', true);
                  return view('participantes',['part'=>$part,'redes'=>$redes]);      

                }else{    

                  $part = DB::table('participantes')->where('id','>',0)
                                                    ->orderBy('nome_part','asc')
                                                    ->paginate(10);

                  $part->appends($request->all());
                  $request->session()->put('cons_rede', false);
                  return view('participantes',['part'=>$part,'redes'=>$redes]); 
                }      
                  
          } 
                 
        }

        //metodo usado somente como exemplo
        public function search(Request $request){

              if(isset($_GET['query'])){
                 $search_text = $_GET['query'];
                 $part = DB::table('participantes')->where('nome_part','like','%'.$search_text.'%')->paginate(3);
                 $part->appends($request->all());
                 return view('search',['part'=>$part]);
              }
              else{
                return view('search'); 
              }
        }

       public function show($id){
      
             $umparticipante = participantes::FindOrfail($id);   
      
              return view('alterar_participantes',['participante' => $umparticipante]); 
        }

        public function query_details($id){
      
          $participantes = participantes::FindOrfail($id); 
                    
          return view('consultar_participante',['participante' => $participantes]);
        }

        public function update($id,StoreAlterPartRequest $request){

          $endereco_geocode = request('endereco').",".request('cidade').",".request('pais');

          $p = DB::table('participantes')->where('email','=',request('email'))
                                         ->where('id','<>',$id)
                                         ->first();
                                         
          if(!$p){                                         
             
              $part = participantes::FindOrfail($id);   
              $part->nome_part = request('nome_part');
              $part->endereco = request('endereco');
              $part->cidade = request('cidade');
              $part->cep = request('cep');
              $part->estado = request('estado');
              $part->pais = request('pais');
              $part->email = request('email');
              
              $geo = helper::GetGeoCode($endereco_geocode);
              
              $part->latitude = $geo['lat'];
              $part->longitude = $geo['long'];

              /*$part->timezone = helper::getTimezone($geo['lat'],$geo['long']);*/

              $part->ranking = 0;

              
              if($request->hasFile('part_image')){
                $file = $request->file('part_image');
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                if($size > 5000000){
                  return back()->with('fail image','tamanho maior do que o permitido!');
                }
                
                if ($extension == 'jpg' or $extension == 'jpeg' or $extension == 'png' ){

                    //Deleta a imagem anterior antes de incluir a nova.
                    $file_name_ant = $part->imagem;
                    File::delete(public_path('uploads/participantes/'.$file_name_ant));
                    //------------------------------------------------------------------------

                    $filename = request('nome_part').'_'.time().'.'.$extension;
                    $file->move('uploads/participantes/',$filename);
                    
                    $part->imagem = $filename;
                    
                }else{
                    return back()->with('fail image','Imagem com formato invalido!');
                }
              }

              $part->save();

              $query = $part->save();

              if($query){
                 $request->session()->put('imagem_logado', $part->imagem);
                 return back()->with('success','Participante alterado com successo!');
              }else{
                 return back()->with('fail','Aconteceu algum erro! Participante não foi alterado.');
              }
             
          }else{
              return back()->with('fail','Email já está sendo usado por outro participante!');
          }
          
     }  
      
       public function destroy($id){
      
        $participantes = participantes::FindOrfail($id);  
        $participantes->delete();
      
        return redirect('/participantes'); 
       }
      
      }
      

