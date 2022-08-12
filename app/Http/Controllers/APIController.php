<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //

    function consulta_part(Request $request)
    {

        $parts = DB::table('participantes')->get();
        
        return response()->json(['parts' => $parts]);
    }
}
