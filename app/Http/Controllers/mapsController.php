<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnCallback;

class mapsController extends Controller
{
    public static function query_mapa($id){

       $part = DB::table('participantes')->where('id','=',$id)->first();

       if($part){

          if($part->latitude <> null and $part->longitude <> null ){
            $markers =  DB::table('markers')->where('id','>',0)->delete();

            if($part->latitude <> null){
               $lat = $part->latitude;
            }else{
               $lat = 0;
            }

            if($part->longitude <> null){
               $long = $part->longitude;
            }else{
               $long = 0;
            }

            $markers = DB::table('markers')->insert([
                   'nome_part'=> $part->nome_part,
                   'endereco'=> $part->endereco,
                   'latitude'=> $lat,
                   'longitude'=> $long,
            ]);
 
            $_SESSION['lati'] = $lat;
            $_SESSION['longi'] = $long;
            $_SESSION['part_selecionado'] = $part->nome_part;

            return view('mostramapa');
            
          }else{
            return back()->with('fail_mapa','Latitude e Longitude precisam ser definidas para mostrar a localização do Participante : '. $part->nome_part);
          }
       }else{
          return view('participantes');
       }

        
    }

    public static function mostra_varios_parts(Request $request){

      $parts = request('parts');
     /*dd(request('parts'));*/

      if($parts){

         $markers =  DB::table('markers')->where('id','>',0)->delete();
         
         foreach($parts as $part){

               /*dd($part['latitude']);*/
             
               if($part['latitude'] <> null and $part['longitude'] <> null ){
            
               if($part['latitude'] <> null){
                  $lat = $part['latitude'];
               }else{
                  $lat = 0;
               }

               if($part['longitude'] <> null){
                  $long = $part['longitude'];
               }else{
                  $long = 0;
               }

               $markers = DB::table('markers')->insert([
                        'nome_part'=> $part['nome_part'],
                        'endereco'=> $part['endereco'],
                        'latitude'=> $lat,
                        'longitude'=> $long,
               ]);

               
               }
      
         } 

         $_SESSION['lati'] = request('latitude');
         $_SESSION['longi'] = request('longitude');
         $_SESSION['part_selecionado'] = request('nome_part');
         $_SESSION['of_nec'] = request('of_nec');

         return view('mostramapa_varios');
      
      }
      return redirect()->route('trans_ofertas_part');
   }

   
    
}