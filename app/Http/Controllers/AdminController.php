<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use App\Client;

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
        $events = Event::orderBy('eventname', 'asc')->get();
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewEvents')->with('events', $events);
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewClients(){
        $clients = Client::orderBy('lastname', 'asc')->get();

        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewClients')->with('clients', $clients);
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewBEO(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewBEO');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewResources(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewResources');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewReports(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewReports');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewFiles(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewFiles');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewSettings(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewSettings');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewNotifications(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewNotifications');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function viewQuotations(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewQuotations');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function addClientView(){
        if(\Auth::user()->position === 'Admin'){
            return view('admin.addClient');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function addEventView(){
        
        if(\Auth::user()->position === 'Admin'){
            return view('admin.addEvent');
        }
        else{
            return 'return You do not have access to this page!';
        }
    }



    //Queries

    public function addClient(Request $request){
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'contactnumber' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        
        
        $date = date('Y-m-d H:i:s');
        $id = 1;
        
        $client = new Client;
        $client->firstname = $request->input('firstname');
        $client->lastname = $request->input('lastname');
        $client->contactnumber = $request->input('contactnumber');
        $client->email = $request->input('email');
        $client->assigned = $id;
        $client->address = $request->input('address');
       
        $client->save();

        return redirect('/ViewClients')->with('success', 'Client added!');
    }




}
