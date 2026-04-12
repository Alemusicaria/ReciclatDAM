<?php

namespace App\Mail;

use App\Models\User;
use App\Support\EmailActionLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReEngagementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $dashboardUrl;

    public function __construct(
        public User $user
    ) {
        $this->dashboardUrl = EmailActionLink::forRoute($this->user, 'dashboard');
    }

    public function build(): self
    {
        return $this->subject('Et trobem a faltar a ' . config('app.name'))
            ->markdown('emails.reactivation');
    }
}
