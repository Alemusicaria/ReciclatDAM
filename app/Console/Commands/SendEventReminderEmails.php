<?php

namespace App\Console\Commands;

use App\Mail\EventReminderMail;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendEventReminderEmails extends Command
{
    protected $signature = 'emails:send-event-reminders {--hours=24 : Hours before event to send reminder}';

    protected $description = 'Send event reminder emails to registered participants';

    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $hours = $hours > 0 ? $hours : 24;

        $windowStart = Carbon::now()->addHours($hours - 1);
        $windowEnd = Carbon::now()->addHours($hours);

        $events = Event::query()
            ->with('participants')
            ->whereBetween('data_inici', [$windowStart, $windowEnd])
            ->get();

        $sent = 0;

        foreach ($events as $event) {
            if (!$event instanceof Event) {
                continue;
            }

            foreach ($event->participants as $user) {
                if (!$user instanceof \App\Models\User) {
                    continue;
                }

                if (!is_string($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                $cacheKey = sprintf(
                    'emails:event-reminder:%d:%d:%d',
                    (int) $event->id,
                    (int) $user->id,
                    $hours
                );

                if (!Cache::add($cacheKey, true, now()->addHours($hours + 2))) {
                    continue;
                }

                Mail::to($user->email)->queue(new EventReminderMail($user, $event, $hours));
                $sent++;
            }
        }

        $this->info("Event reminder emails queued: {$sent}");

        return self::SUCCESS;
    }
}
