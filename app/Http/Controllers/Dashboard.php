<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ForbesTop; 
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //

    
    public function __construct()
    {  
        $this->middleware('auth');
    }

    

    public function index()
    {    
        $person = ForbesTop::select('recipient',DB::raw('count(*) as count'))->groupBy('recipient')->orderBy('count','desc')->limit('1')->first();
        $country = ForbesTop::select('country',DB::raw('count(*) as count'))->groupBy('country')->orderBy('count','desc')->limit('1')->first();
        $career = ForbesTop::select('career',DB::raw('count(*) as count'))->groupBy('career')->orderBy('count','desc')->limit('1')->first();
      
        return view('dashboard',compact('person','country','career'));
    }

    

    
    public function getChartData()
    {
        // code here
    }
}
