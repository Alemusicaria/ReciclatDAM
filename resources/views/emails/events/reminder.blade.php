@component('mail::message')
# Recordatori d'event

Hola **{{ $user->nom ?? 'usuari' }}**, et recordem que aviat tens un event.

@component('mail::panel')
**Event:** {{ $event->displayName() ?? $event->nom }}

**Comenca en:** {{ $hoursBefore }} hores

**Data i hora:** {{ optional($event->data_inici)->format('d/m/Y H:i') ?? 'Per concretar' }}

**Lloc:** {{ $event->displayLocation() ?? $event->lloc ?? 'Per concretar' }}
@endcomponent

@component('mail::button', ['url' => $actionUrl])
Obrir event
@endcomponent

Ens veiem aviat.

{{ config('app.name') }}
@endcomponent
