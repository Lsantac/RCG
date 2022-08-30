<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //

    function consulta_part(Request $request)
    {


          $string = $_GET['consulta'];

          // split on 1+ whitespace & ignore empty (eg. trailing space)
          $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);     

               $parts = DB::table('participantes')->where(function($query) use ($searchValues){
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

                $parts->appends($request->all());

               return response()->json(['parts' => $parts]);
        

      /*  $parts = DB::table('participantes')->get();
        
        return response()->json(['parts' => $parts]);*/

    }
}
