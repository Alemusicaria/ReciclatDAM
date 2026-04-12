<?php

namespace App\Console\Commands;

use App\Mail\EventRegistrationConfirmationMail;
use App\Mail\EventReminderMail;
use App\Mail\PrizeClaimedMail;
use App\Mail\PrizeStatusUpdatedMail;
use App\Mail\ReEngagementMail;
use App\Mail\SecurityPasswordChangedMail;
use App\Mail\WelcomeMail;
use App\Models\Event;
use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailPreviews extends Command
{
    protected $signature = 'emails:send-previews {recipient : Email address that will receive the previews}';

    protected $description = 'Send all generated email previews to a recipient';

    public function handle(): int
    {
        $recipient = (string) $this->argument('recipient');

        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->error('Recipient email is not valid.');
            return self::FAILURE;
        }

        $user = User::query()->with('rol')->first() ?? $this->demoUser();
        $event = Event::query()->with('tipus')->first() ?? $this->demoEvent();
        $prize = Premi::query()->first() ?? $this->demoPrize();
        $claim = PremiReclamat::query()->with(['premi', 'user'])->first() ?? $this->demoClaim($user, $prize);

        if (!$claim->getRelation('user')) {
            $claim->setRelation('user', $user);
        }

        if (!$claim->getRelation('premi')) {
            $claim->setRelation('premi', $prize);
        }

        $sent = [];

        Mail::to($recipient)->sendNow(new WelcomeMail($user));
        $sent[] = 'welcome';

        Mail::to($recipient)->sendNow(new EventRegistrationConfirmationMail($user, $event));
        $sent[] = 'event-registration';

        Mail::to($recipient)->sendNow(new EventReminderMail($user, $event, 24));
        $sent[] = 'event-reminder';

        Mail::to($recipient)->sendNow(new PrizeClaimedMail($user, $prize, $claim));
        $sent[] = 'prize-claimed';

        Mail::to($recipient)->sendNow(new PrizeStatusUpdatedMail($user, $claim, 'pendent', 'procesant'));
        $sent[] = 'prize-status-processing';

        Mail::to($recipient)->sendNow(new PrizeStatusUpdatedMail($user, $claim, 'procesant', 'entregat'));
        $sent[] = 'prize-status-delivered';

        Mail::to($recipient)->sendNow(new PrizeStatusUpdatedMail($user, $claim, 'pendent', 'cancelat'));
        $sent[] = 'prize-status-cancelled';

        Mail::to($recipient)->sendNow(new SecurityPasswordChangedMail($user));
        $sent[] = 'security-password-changed';

        Mail::to($recipient)->sendNow(new ReEngagementMail($user));
        $sent[] = 'reactivation';

        $this->info('Sent preview emails: ' . implode(', ', $sent));

        return self::SUCCESS;
    }

    private function demoUser(): User
    {
        $user = new User();
        $user->setRawAttributes([
            'id' => 1,
            'nom' => 'Aleix',
            'cognoms' => 'Prat Marin',
            'email' => 'aleixpratmarin1@gmail.com',
            'punts_actuals' => 240,
            'punts_totals' => 880,
            'punts_gastats' => 640,
            'foto_perfil' => null,
        ], true);

        return $user;
    }

    private function demoEvent(): Event
    {
        $event = new Event();
        $event->setRawAttributes([
            'id' => 1,
            'nom' => 'Jornada de reciclatge comunitari',
            'descripcio' => 'Event de prova per veure el correu.',
            'lloc' => 'Plaça Major, Cervera',
            'data_inici' => now()->addDay(),
            'data_fi' => now()->addDay()->addHours(2),
            'capacitat' => 30,
            'punts_disponibles' => 20,
            'imatge' => null,
        ], true);

        return $event;
    }

    private function demoPrize(): Premi
    {
        $prize = new Premi();
        $prize->setRawAttributes([
            'id' => 1,
            'nom' => 'Ampolla reutilitzable',
            'descripcio' => 'Premi de demostracio per correu.',
            'punts_requerits' => 120,
            'imatge' => null,
            'categoria' => 'accessories',
            'stock' => 10,
            'temps_enviament' => '3-5 dies',
            'rating' => 4.5,
        ], true);

        return $prize;
    }

    private function demoClaim(User $user, Premi $prize): PremiReclamat
    {
        $claim = new PremiReclamat();
        $claim->setRawAttributes([
            'id' => 9999,
            'user_id' => $user->id ?? 1,
            'premi_id' => $prize->id ?? 1,
            'punts_gastats' => 120,
            'data_reclamacio' => now(),
            'estat' => 'pendent',
            'codi_seguiment' => 'TRK-DEMO1234',
            'comentaris' => 'Aquesta es una previsualitzacio.',
        ], true);
        $claim->setRelation('premi', $prize);
        $claim->setRelation('user', $user);

        return $claim;
    }
}
