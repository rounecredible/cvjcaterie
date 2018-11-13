<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->position === 'Admin'){
            return view('admin.admin');
        }
        else if(\Auth::user()->position === 'AE'){
            return view('accountexecutive.ae');
        }
        //return view('home');
    }
}
