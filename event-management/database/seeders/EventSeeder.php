<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //get all users from Users
        $users = User::all();

        //Insert 200 Events in the database with each event have random or different user
        for ($i=0; $i < 200; $i++) { 
            //Get random user from all users
            $user = $users->random();

            //create event with the above random user
            \App\Models\Event::factory()->create([
                'user_id' => $user->id
            ]);
        }

    }
}
