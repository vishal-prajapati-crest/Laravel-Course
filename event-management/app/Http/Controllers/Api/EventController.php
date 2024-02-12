<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationships;

   private array $relations = ['user', 'attendees', 'attendees.user']; //allowed relation to pass the query

   public function __construct()
   {
       $this->middleware('auth:sanctum')->except(['index','show']); //auth:sanctum is middelware which will check user is authenticate or not by checking their token in header
       $this->middleware('throttle:api')->only(['store','destroy','update']); //limit the api rate
       $this->authorizeResource(Event::class, 'event');
   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Event::query()) ; //craete a query instance
  
        return EventResource::collection($query->latest()->paginate()); //conver into collection i.e. json {data:[{},{},...]}
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //First validate and append with old data and add user to each event
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255|',
                'description' => 'nullable|string',
                'start_time' =>  'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => $request->user()->id
            ]);

            return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        return new EventResource($this->loadRelationships($event));
        // return EventResource::collection($event);
        // return \App\Models\User::findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //Check the user is authorize to update the event i.e. the same user login can update their own event
        // if(Gate::denies('update-event', $event)){
        //     abort(403, 'You are not authorized to update this event.');
        // }

        //similar above check user is authorized to update event or not
        // $this->authorize('update-event', $event);
        
        
        //First validate the request if it is present in the array and then update
        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255|',
                'description' => 'nullable|string',
                'start_time' =>  'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
            ])
            );



            return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        // return response()->json([
        //     "message" => "Event Deleted Successfully"
        // ]);

        return response(status: 204);
    }
}
