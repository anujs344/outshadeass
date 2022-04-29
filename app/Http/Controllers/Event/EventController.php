<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
class EventController extends Controller
{
    public function CreateEvent(Request $req)
    {
        $req->validate([
            'EventName' => 'required',
            'usersid' => 'required',
        ]);
        try{
            if(Event::where('EventName',$req->EventName)->exists() == null)
            {
                foreach (explode(',',$req->usersid) as $user) {
                    Event::create([
                        'EventName' => $req->EventName,
                        'invited_by' => Auth::user()->id,
                        'invited_to' => (int)$user,
                        'createdby' => Auth::user()->id
                    ]);
                }
                return response()->json(["Result" => "Event Created"], 200);
            }
            else{
                return response()->json(["Response" => "Event Name Is Already Taken"], 200);
            }
            
        }catch(exception $e)
        {
            return response()->json($e, 400);
        }
        
    }

    public function Detail(Request $request)
    {
        $createdEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('invited_by',Auth::user()->id)
        ->where('createdby',Auth::user()->id)
        ->get()
        ->groupby('createdby');
       
        $invitedinEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('invited_to',Auth::user()->id)
        ->get();
       
        if($request->name)
       {
           $createdEvents = DB::table('users')
           ->join('events', 'users.id', '=', 'events.invited_to')
           ->where('name','Like','%'.$request->name.'%')
           ->where('invited_by',Auth::user()->id)
           ->where('createdby',Auth::user()->id)
           ->get()
           ->groupby('createdby');

           $invitedinEvents = DB::table('users')
           ->join('events', 'users.id', '=', 'events.invited_to')
           ->where('invited_to',Auth::user()->id)
           ->where('name','Like','%'.$request->name.'%')
           ->get();
       }

       if($request->date)
       {
        $createdEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('name','Like','%'.$request->name.'%')
        ->where('invited_by',Auth::user()->id)
        ->where('createdby',Auth::user()->id)
        ->orderby('created_at')
        ->get()
        ->groupby('createdby');

        $invitedinEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('invited_to',Auth::user()->id)
        ->where('name','Like','%'.$request->name.'%')
        ->orderby('created_at')
        ->get();
       }

       if($request->sort)
       {
        $createdEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('name','Like','%'.$request->name.'%')
        ->where('invited_by',Auth::user()->id)
        ->where('createdby',Auth::user()->id)
        ->orderby('created_at')
        ->get()
        ->groupby($request->sort);

        $invitedinEvents = DB::table('users')
        ->join('events', 'users.id', '=', 'events.invited_to')
        ->where('invited_to',Auth::user()->id)
        ->where('name','Like','%'.$request->name.'%')
        ->orderby('created_at')
        ->get();
       }

       return response()->json(["Creted By You" => $createdEvents,
                                "Invited In Events" => $invitedinEvents
    ], 200);
    }

    public function update(Request $req)
    {
        $req->validate([
            'EventName' => 'required',
            'NewEventName' => 'required',
            'usersid' => 'required'
        ]);

        Event::where('EventName',$req->EventName)->where('createdby',Auth::user()->id)->delete();
        if(!Event::where('EventName',$req->NewEventName)->where('createdby,Auth::user()->id')->exists())
        {
            foreach (explode(',',$req->usersid) as $user) {
                Event::create([
                    'EventName' => $req->EventName,
                    'invited_by' => Auth::user()->id,
                    'invited_to' => (int)$user,
                    'createdby' => Auth::user()->id
                ]);
            }
            return response()->json(["Response" => "Event Updated"], 200);
        }
        else{
            return response()->json(["Response"=>"Name Is Already Taken"], 400);
        }
    }
}
