<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function ChartTest(request $request){

        
        

        return view('charts.chart_test');

    }

}
