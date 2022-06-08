<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ForbesTop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        // $userInfo = User::findOrFail('1');
         
        // return view('home',[
        //     'userInfo' => $userInfo
        // ]);

         
        return view('home');
    }

    
}
