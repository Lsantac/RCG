<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentController extends Controller
{
    public function conf_ident(request $request){

        $ident = DB::table('identidade')->first();

       /* dd($ident);*/
        
        return view('conf_ident',['ident'=>$ident]);
    }   
}
