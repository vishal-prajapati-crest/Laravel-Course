<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Only user which created will be able to update event
        // Gate::define('update-event', function($user, Event $event){
        //     return $user->id === $event->user_id;
        // });

        // //Delete a attendee from an event either event organiser will able to delete attendee to thier event or attendee it self able to delete their event
        // Gate::define('delete-attendee', function($user,Event $event, Attendee $attendee){
        //     return $user->id === $event->user_id || $attendee->user_id === $user->id;
        // });
    }
}
