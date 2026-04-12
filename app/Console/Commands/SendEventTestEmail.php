<?php

namespace App\Console\Commands;

use App\Mail\EventReminderMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventTestEmail extends Command
{
    protected $signature = 'emails:send-event-test {recipient : Email recipient} {--hours=24 : Hours before event for template context}';

    protected $description = 'Send a single event reminder test email';

    public function handle(): int
    {
        $recipient = (string) $this->argument('recipient');
        $hours = (int) $this->option('hours');
        $hours = $hours > 0 ? $hours : 24;

        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email recipient.');
            return self::FAILURE;
        }

        $user = User::query()->firstOrFail();
        $event = Event::query()->with('tipus')->firstOrFail();

        Mail::to($recipient)->sendNow(new EventReminderMail($user, $event, $hours));

        $this->info('Event test email sent to ' . $recipient);

        return self::SUCCESS;
    }
}
