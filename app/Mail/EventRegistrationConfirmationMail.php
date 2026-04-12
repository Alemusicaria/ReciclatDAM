<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\User;
use App\Support\EmailActionLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $actionUrl;

    public function __construct(
        public User $user,
        public Event $event
    ) {
        $eventId = (int) ($this->event->id ?? 1);
        $this->actionUrl = EmailActionLink::forRoute($this->user, 'events.show', ['id' => $eventId]);
    }

    public function build(): self
    {
        return $this->subject('Confirmacio d\'inscripcio: ' . ($this->event->displayName() ?: 'Event'))
            ->markdown('emails.events.registration-confirmation');
    }
}
