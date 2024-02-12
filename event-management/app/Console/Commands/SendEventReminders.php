<?php

namespace App\Console\Commands;

use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifiaction to all the event attendees that the event start soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = \App\Models\Event::with('attendees.user')
            ->whereBetween('start_time',[now(),now()->addDay()]);

        $eventCount = $events->count();

        $eventLable = Str::plural('event', $eventCount);

        // Define a delay between sending emails (in seconds) as we are testing with mail trap and there is rate limit
        // $delayInSeconds = 1;

        $events->each(
            fn($event)=> $event->attendees->each(
                fn($attendee) => $attendee->user->notify(
                    new EventReminderNotification($event)
                )
            )
        );

        // $events->each(function ($event) use ($delayInSeconds) {
        //     $event->attendees->each(function ($attendee) use ($event, $delayInSeconds) {
        //         // Send notification after a delay
        //         sleep($delayInSeconds);
        //         $attendee->user->notify(new EventReminderNotification($event));
        //     });
        // });
        

        $this->info("Found {$eventCount} {$eventLable}.");
        $this->info('Reminder notification sent successfully!');
    }
}
