<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Get all users
        $users = User::all();

        //Get all Events
        $events = Event::all();

        //For Every User Assign some random Events
        foreach ($users as $user) {
            
            //get random event range between 1 to 3 Attendee will ateend
            $eventsToAttend = $events->random(rand(1,3)); //select random event betwwen 1 to 3

            //Create a attendee for each event to attend

            foreach($eventsToAttend as $event){

                //create a atendee set user and event to them
                \App\Models\Attendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id ,
                ]);
            }

        }
    }
}
