@component('mail::message')
# Et trobem a faltar

Hola **{{ $user->nom ?? 'usuari' }}**, fa dies que no et veiem per {{ config('app.name') }}.

@component('mail::panel')
Tens actualment **{{ $user->punts_actuals ?? 0 }} ECODAMS**.

Torna i segueix reciclant per desbloquejar nous premis i events.
@endcomponent

@component('mail::button', ['url' => $dashboardUrl])
Tornar a l'aplicacio
@endcomponent

Gracies per continuar reciclant.

{{ config('app.name') }}
@endcomponent
