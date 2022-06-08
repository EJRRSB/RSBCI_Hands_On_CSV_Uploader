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
        return view('dashboard');
    }

    

    

    public function getCountsData()
    {
        $person = ForbesTop::select('recipient',DB::raw('count(*) as count'))->groupBy('recipient')->orderBy('count','desc')->limit('1')->first();
        $country = ForbesTop::select('country',DB::raw('count(*) as count'))->groupBy('country')->orderBy('count','desc')->limit('1')->first();
        $career = ForbesTop::select('career',DB::raw('count(*) as count'))->groupBy('career')->orderBy('count','desc')->limit('1')->first();
        
        $data = [
            "person" => $person,
            "country" => $country,
            "career" => $career
        ];
        
        echo json_encode(array(
            "data" => $data
        )); 
    }
    




    public function getChartData()
    {
        $person = ForbesTop::select('recipient',DB::raw('count(*) as count'))->groupBy('recipient')->orderBy('count','desc')->limit('3')->get();
        $country = ForbesTop::select('country',DB::raw('count(*) as count'))->groupBy('country')->orderBy('count','desc')->limit('3')->get();
        $career = ForbesTop::select('career',DB::raw('count(*) as count'))->groupBy('career')->orderBy('count','desc')->limit('3')->get();

        $data = [
            "person" => $person,
            "country" => $country,
            "career" => $career
        ];
        
        echo json_encode(array(
            "data" => $data
        )); 
    }
}
