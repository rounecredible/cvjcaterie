<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.admin');
        }
        else{
            return 'Not Admin';
        }
        
    }
}
