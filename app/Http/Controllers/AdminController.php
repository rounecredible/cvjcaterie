<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;

class AdminController extends Controller
{
    public function index(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.admin');
        }
        else{
            return 'You do not have access to this page!';
        }
        
    }

    public function viewEvents(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewEvents');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewClients(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewClients');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }
}
