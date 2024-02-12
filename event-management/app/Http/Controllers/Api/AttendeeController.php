<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

   private array $relations = ['user']; //allowed relation to pass the query

   public function __construct()
   {
       $this->middleware('auth:sanctum')->except(['index','show', 'update']); //auth:sanctum is middelware which will check user is authenticate or not by checking their token in header
       $this->middleware('throttle:api')->only(['store','destroy']); //limit the api rate
       $this->authorizeResource(Attendee::class, 'attendee'); //authorize using attendee policy

   }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $this->loadRelationships(
            $event->attendees()->latest()
        );
        return AttendeeResource::collection($attendees->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        //It will automatically store event id as it will associated attendees with event
        $attendee = $this->loadRelationships(
            $event->attendees()->create([
            'user_id' => $request->user()->id 
        ])
            );

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelationships($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        //authorized user only able to delete either event organizer or attendee itself
        // $this->authorize('delete-attendee', [$event, $attendee]);
        $attendee->delete();
        return response(status: 204); 
    }
}
