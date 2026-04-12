<?php

namespace App\Mail;

use App\Models\PremiReclamat;
use App\Models\User;
use App\Support\EmailActionLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrizeStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $profileUrl;

    public function __construct(
        public User $user,
        public PremiReclamat $claim,
        public string $previousStatus,
        public string $newStatus
    ) {
        $userId = (int) ($this->user->id ?? 1);
        $this->profileUrl = EmailActionLink::forRoute($this->user, 'users.show', ['user' => $userId]);
    }

    public function build(): self
    {
        return $this->subject('Actualitzacio del teu premi: ' . $this->humanStatus($this->newStatus))
            ->markdown('emails.prizes.status-updated');
    }

    public function humanStatus(string $status): string
    {
        return match ($status) {
            'pendent' => 'Pendent',
            'procesant' => 'En proces',
            'entregat' => 'Entregat',
            'cancelat' => 'Cancel·lat',
            default => ucfirst($status),
        };
    }
}
