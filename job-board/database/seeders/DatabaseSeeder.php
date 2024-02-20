<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Vishal',
            'email' => 'vishal@gmail.com',
        ]);

        \App\Models\User::factory(300)->create(); //create 300 users

        //select all users in random order
        $users = \App\Models\User::all()->shuffle();

        //Now select 20 random user and make it employer
        for ($i=0; $i < 20; $i++) { 
            \App\Models\Employer::factory()->create([
                'user_id' => $users->pop()->id //it will pop and get id of user  i.e. fetch the user from $users and remove it from $users 
            ]);
        }
        
        $employers = \App\Models\Employer::all(); //all the employers

        //create 100 jobs
        for ($i=0; $i < 100; $i++) { 
            \App\Models\Job::factory()->create([
                'employer_id' => $employers->random()->id //get random employer for this job
            ]);
        }
        
        //remaing user will apply for a job
        foreach($users as $user){
            //get random number of job btw 0,4
            $jobs = \App\Models\Job::inRandomOrder()->take(rand(0,4))->get();

            //now insert each random job inside job application for user
            foreach($jobs as $job){
                \App\Models\JobApplication::factory()->create([
                    'job_id' => $job->id,
                    'user_id' => $user->id
                ]);
            }
        }

        
    }
}
