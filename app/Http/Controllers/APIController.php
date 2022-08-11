<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //

    function consulta_part(Request $request)
    {

        $part = db::table('participantes')->all();

        $id = $part->id;
        $nome = $part->nome_part;
        $email = $part->email;
        
        return response()->json(['nome' => $nome, 'email' => $email, 'id' => $id]);
    }
}
