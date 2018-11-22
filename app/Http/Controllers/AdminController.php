<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Event;
use App\Client;
use App\Additionals;
use App\CvjMenu;
use App\PackageStyling;
use App\CvjResources;
use Calendar;

class AdminController extends Controller
{
    public function index(){
      //   if(\Auth::user()->position === 'Admin'){
        //    return view('admin.admin');
        //}
        //else{
          //  return 'You do not have access to this page!';
        //}
        
        $events = [];

       $data = Event::all();

       if($data->count()){

          foreach ($data as $key => $value) {

            $events[] = Calendar::event(

                $value->title,

                true,

                new \DateTime($value->start_date),

                new \DateTime($value->end_date.' +1 day')

            );

          }

       }

      $calendar = Calendar::addEvents($events); 

      return view('admin.admin', compact('calendar'));



        
        
    }

    public function viewResources(){
        $resources = CvjResources::orderBy('category', 'asc')->get();
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewResources')->with('resources', $resources);
        }
        else{
            return 'return You do not have access to this page!';
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

    

    public function addEventDetailsView(){
        // $cvjmenu = CvjMenu::get();
        $packagestyling = PackageStyling::orderBy('package', 'asc')->get();
       $additionals = Additionals::orderBy('category', 'asc')->get();
        $events=Event::orderBy('id', 'desc')->first();
        return view('admin.addEventDetails')->with('packagestyling', $packagestyling)
        ->with('additionals', $additionals)
        ->with('events', $events);
    }

    public function addEventDetails(Request $request){

    }



    //Queries

    public function addEvent(Request $request){
        $this->validate($request, [
            'client' => 'required',
            'eventname' => 'required',
            'eventtype' => 'required',
            'date' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'venuetype' => 'required',
            'venueaddress' => 'required',
            'pax' => 'required',
        ]);

        $id = \Auth::user()->id;
        $type = $request->input('eventtype');

        $event = new Event;
        $event->client = $request->input('client');
        $event->eventname = $request->input('eventname');
        $event->eventtype = $request->input('eventtype');
        $event->date = $request->input('date');
        $event->starttime = $request->input('starttime');
        $event->endtime = $request->input('endtime');
        $event->venuetype = $request->input('venuetype');
        $event->venueaddress = $request->input('venueaddress');
        $event->pax = $request->input('pax');
        $event->status = "For Inquiry";
        $event->package = $request->input('eventtype');
        $event->assigned_to = $id;
        $event->save();

        if($type === 'Grand Wedding'){
           
        }
        return redirect('/AddEventDetailsView');

    }

    public function addClient(Request $request){
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'contactnumber' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        
        
        $date = date('Y-m-d H:i:s');
        $id = \Auth::user()->id;

        
        
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
