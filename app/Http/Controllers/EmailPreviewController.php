<?php

namespace App\Http\Controllers;

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

class EmailPreviewController extends Controller
{
    public function index()
    {
        abort_unless(app()->environment(['local', 'development', 'testing']), 403);

        $templates = [
            'welcome' => 'Benvinguda',
            'event-registration' => 'Confirmacio inscripcio event',
            'event-reminder' => 'Recordatori event',
            'prize-claimed' => 'Premi reclamat',
            'prize-status-processing' => 'Premi en proces',
            'prize-status-delivered' => 'Premi entregat',
            'prize-status-cancelled' => 'Premi cancel·lat',
            'security-password-changed' => 'Contrasenya actualitzada',
            'reactivation' => 'Reactivacio inactivitat',
        ];

        return view('emails.previews.index', compact('templates'));
    }

    public function show(string $template)
    {
        abort_unless(app()->environment(['local', 'development', 'testing']), 403);

        [$user, $event, $prize, $claim] = $this->buildPreviewData();

        $mailable = match ($template) {
            'welcome' => new WelcomeMail($user),
            'event-registration' => new EventRegistrationConfirmationMail($user, $event),
            'event-reminder' => new EventReminderMail($user, $event, 24),
            'prize-claimed' => new PrizeClaimedMail($user, $prize, $claim),
            'prize-status-processing' => new PrizeStatusUpdatedMail($user, $claim, 'pendent', 'procesant'),
            'prize-status-delivered' => new PrizeStatusUpdatedMail($user, $claim, 'procesant', 'entregat'),
            'prize-status-cancelled' => new PrizeStatusUpdatedMail($user, $claim, 'pendent', 'cancelat'),
            'security-password-changed' => new SecurityPasswordChangedMail($user),
            'reactivation' => new ReEngagementMail($user),
            default => abort(404),
        };

        return response($mailable->render());
    }

    private function buildPreviewData(): array
    {
        $user = User::query()->first() ?? new User([
            'nom' => 'Usuari',
            'cognoms' => 'Demo',
            'email' => 'demo@example.com',
            'punts_actuals' => 240,
            'punts_totals' => 880,
            'punts_gastats' => 640,
        ]);

        $event = Event::query()->with('tipus')->first() ?? new Event([
            'nom' => 'Jornada de reciclatge comunitari',
            'descripcio' => 'Event de prova per visualitzar correus.',
            'lloc' => 'Plaça Major, Cervera',
            'data_inici' => now()->addDays(1),
            'data_fi' => now()->addDays(1)->addHours(2),
            'capacitat' => 30,
            'punts_disponibles' => 20,
        ]);

        $prize = Premi::query()->first() ?? new Premi([
            'nom' => 'Ampolla reutilitzable',
            'descripcio' => 'Premi de demostracio per correu.',
            'punts_requerits' => 120,
        ]);

        $claim = PremiReclamat::query()->with('premi')->first() ?? new PremiReclamat([
            'id' => 9999,
            'punts_gastats' => 120,
            'data_reclamacio' => now(),
            'estat' => 'pendent',
            'codi_seguiment' => 'TRK-DEMO1234',
            'comentaris' => 'Aquesta es una previsualitzacio.',
        ]);

        $claim->setRelation('premi', $prize);
        $claim->setRelation('user', $user);

        return [$user, $event, $prize, $claim];
    }
}
