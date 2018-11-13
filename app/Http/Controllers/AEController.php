<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AEController extends Controller
{
    public function index(){
        return view('accountexecutive.ae');
    }
}
