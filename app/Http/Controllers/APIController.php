<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //

    function consulta_part(Request $request)
    {

        $part = db::table('participantes')->where('id',$request->id_part)->first();

        $nome = $part->nome_part;
        $email = $part->email;
        
        return response()->json(['nome' => $nome, 'email' => $email]);
    }
}
