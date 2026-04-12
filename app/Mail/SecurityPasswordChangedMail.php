<?php

namespace App\Mail;

use App\Models\User;
use App\Support\EmailActionLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SecurityPasswordChangedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $changePasswordUrl;
    public string $forgotPasswordUrl;

    public function __construct(
        public User $user
    ) {
        $userId = (int) ($this->user->id ?? 1);
        $this->changePasswordUrl = EmailActionLink::forRoute($this->user, 'users.edit', ['user' => $userId]);
        $this->forgotPasswordUrl = route('password.request');
    }

    public function build(): self
    {
        return $this->subject('Alerta de seguretat: contrasenya actualitzada')
            ->markdown('emails.security.password-changed');
    }
}
