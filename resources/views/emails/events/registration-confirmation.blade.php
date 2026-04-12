@component('mail::message')
# Inscripcio confirmada

Hola **{{ $user->nom ?? 'usuari' }}**, la teva inscripcio s'ha registrat correctament.

@component('mail::panel')
**Event:** {{ $event->displayName() ?? $event->nom }}

**Data:** {{ optional($event->data_inici)->format('d/m/Y H:i') ?? 'Per concretar' }}

**Lloc:** {{ $event->displayLocation() ?? $event->lloc ?? 'Per concretar' }}
@endcomponent

@component('mail::button', ['url' => $actionUrl])
Veure detall de l'event
@endcomponent

Gracies per participar en la comunitat de reciclatge.

Salutacions,
{{ config('app.name') }}
@endcomponent
