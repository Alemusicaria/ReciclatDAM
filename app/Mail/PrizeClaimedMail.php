<?php

namespace App\Mail;

use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\User;
use App\Support\EmailActionLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrizeClaimedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $profileUrl;

    public function __construct(
        public User $user,
        public Premi $prize,
        public PremiReclamat $claim
    ) {
        $userId = (int) ($this->user->id ?? 1);
        $this->profileUrl = EmailActionLink::forRoute($this->user, 'users.show', ['user' => $userId]);
    }

    public function build(): self
    {
        return $this->subject('Premi reclamat: ' . ($this->prize->displayName() ?: 'Premi'))
            ->markdown('emails.prizes.claimed');
    }
}
