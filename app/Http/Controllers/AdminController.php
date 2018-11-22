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
use App\EventMenu;
use App\Quotation;
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
        $events = Event::orderBy('eventname', 'asc')->get();
        if(\Auth::user()->position === 'Admin'){
            return view('admin.viewQuotations')->with('events', $events);
        }
        else{
            return 'return You do not have access to this page!';
        }
    }

    public function updateQuotation($id){
        $quotations = Quotation::orderBy('id', 'asc')->where('event', $id)->get();
        return view('admin.viewQuotationDetail')->with('quotations', $quotations);
    }

    public function confirmEvent($id){
        $event = Event::find($id);
        return view('admin.confirmStatusView')->with('event', $event);
    }

    public function confirm($id){
        $event = Event::find($id);

        $event->status = 'Confirmed';
        $event->save();

        return redirect('/ViewEvents')->with('success', 'Event Confirmed!');
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
        $cvjmenu = CvjMenu::where('package', 'grand')->get();
        $packagestyling = PackageStyling::orderBy('package', 'asc')->get();
       $additionals = Additionals::orderBy('category', 'asc')->get();
        $events=Event::orderBy('id', 'desc')->first();
        return view('admin.addEventDetails')->with('packagestyling', $packagestyling)
        ->with('additionals', $additionals)
        ->with('events', $events);
    }

    public function chooseEvent(){
        return view('admin.chooseEvent');
    }

    public function addGrandWeddingView(){
        $cvjmenu = CvjMenu::where('package', 'grand')->get();
        $packagestyling = PackageStyling::where('package', 'grand wedding')->get();
       $additionals = Additionals::orderBy('category', 'asc')->get();
        return view('admin.addGrandWeddingView')->with('cvjmenu', $cvjmenu)
        ->with('packagestyling', $packagestyling)
        ->with('additionals', $additionals);
        
    }

    public function addGrandWedding(Request $request){
        $this->validate($request, [
            'client' => 'required',
            'eventname' => 'required',
            'date' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'venuetype' => 'required',
            'venueaddress' => 'required',
            'pax' => 'required',

        ]);

        $id = \Auth::user()->id;
        $set = $request->input('set');

        $event = new Event;
        $event->client = $request->input('client');
        $event->eventname = $request->input('eventname');
        $event->date = $request->input('date');
        $event->starttime = $request->input('starttime');
        $event->endtime = $request->input('endtime');
        $event->venuetype = $request->input('venuetype');
        $event->venueaddress = $request->input('venueaddress');
        $event->pax = $request->input('pax');
        $event->eventtype = "grand wedding";
        $event->package = "grand wedding";
        $event->status = "For Inquiry";
        $event->assigned_to = $id;
        $event->save();

        $events=Event::orderBy('id', 'desc')->first();

        if($set === "A"){
            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'pork sisig pouches with mayo garlic dip';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'rolls and bread sticks served with herbed butter';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'assorted california maki rolls';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'soup';
            $menu->item = 'cream of chicken asparagus soup';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'us roast beef with demi glace';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'grilled baby back ribs with tamarind barbecue sauce';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'grilled salmon steak with lemon butter garlic sauce and salsa';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'baked prawns';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'baked chicken in creamy pesto';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'baked potato au gratin';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'pasta';
            $menu->item = 'gourmet sausage creamy alfredo';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'pasta';
            $menu->item = 'seafood marinara';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'vegetable salad';
            $menu->item = 'tossed greens';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'vegetable salad';
            $menu->item = 'russian potato salad';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'vegetable salad';
            $menu->item = 'apple waldorf salad';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'salad dressing';
            $menu->item = 'honey balsamic';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'salad dressing';
            $menu->item = 'cesar salad';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'rice';
            $menu->item = 'steamed white';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'strawberry, blueberry and peaches panna cotta';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'cake bites: grand pandan, strawberry dream, mango supreme';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'mini gourmet donuts: roasted nut fudge, white confetti, mgm overload';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'fresh tropical fruits in ice cold pandan syrup';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'sylvanna balls: fresh pandan, ube, strawberry';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'softdrinks';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'iced tea';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'coffee';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'tea';
            $menu->save();

            
        }
        else{

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'bacon wrapped crabsticks with teriyaki glaze';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'rolls and bread sticks with herbed butter and cheese';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'appetizer';
            $menu->item = 'tina parcels with tropical salsa';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'soup';
            $menu->item = 'seafood chowder';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'beef con champignon';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'grilled prawns with lemon butter garlic sauce';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'grilled gindara with lemon butter garlic sauce and salsa';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'baked chicken teriyaki with sesame seeds';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'callos ala madrilenes';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'courses';
            $menu->item = 'vegetable pastel with mashed potatoes';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'pasta';
            $menu->item = 'beef pomodoro';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'pasta';
            $menu->item = 'bacon-mushrooms carbonara';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'vegetable salad';
            $menu->item = 'tossed greens';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'salad dressing';
            $menu->item = 'garlic ranch dressing';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'salad dressing';
            $menu->item = 'vinaigrette dressing';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'salad dressing';
            $menu->item = 'asian sesame dressing';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'rice';
            $menu->item = 'steamed white';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'strawberry, blueberry and peaches panna cotta';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'cake bites: grand pandan, strawberry dream, mango supreme';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'mini gourmet donuts: roasted nut fudge, white confetti, mgm overload';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'fresh tropical fruits in ice cold pandan syrup';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'dessert';
            $menu->item = 'sylvanna balls: fresh pandan, ube, strawberry';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'softdrinks';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'iced tea';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'coffee';
            $menu->save();

            $menu = new EventMenu;
            $menu->event = $events->id;
            $menu->type = 'beverage';
            $menu->item = 'tea';
            $menu->save();

        }

                $pax = $request->input('pax');
                $venue = $request->input('venuetype');
                $price = 0.0;

                

                if($venue === 'on premise 1st'){
                    $price += (147000.0 + (($pax - 100) * 1070.0));
                }
                else if($venue === 'on premise 2nd'){
                    $price += (150000.0 + (($pax - 100) * 1070.0));
                }
                else if($venue === 'on premise 3rd'){
                    $price += (145000.0 + (($pax - 100) * 1070.0));
                }
                else if($venue === 'off premise'){
                    $price += (140000.0 + (($pax - 100) * 1070.0));
                }

                $quotation = new Quotation;
                $quotation->event = $events->id;
                $quotation->category = "Food & Beverages";
                $quotation->subtotal = $price * 0.4;
                $quotation->percentage = "40%";
                $quotation->save();

                $quotation = new Quotation;
                $quotation->event = $events->id;
                $quotation->category = "Package Setup & Styling";
                $quotation->subtotal = $price * 0.3;
                $quotation->percentage = "30%";
                $quotation->save();

                $quotation = new Quotation;
                $quotation->event = $events->id;
                $quotation->category = "Services";
                $quotation->subtotal = $price * 0.2;
                $quotation->percentage = "20%";
                $quotation->save();

                $quotation = new Quotation;
                $quotation->event = $events->id;
                $quotation->category = "Other Costs";
                $quotation->subtotal = $price * 0.1;
                $quotation->percentage = "10%";
                $quotation->save();


        return redirect('/ViewEvents')->with('success', 'Event added!');

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
