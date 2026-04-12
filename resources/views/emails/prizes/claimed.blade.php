@component('mail::message')
# Premi reclamat correctament

Hola **{{ $user->nom ?? 'usuari' }}**, hem registrat la teva sol·licitud de premi.

@component('mail::panel')
**Premi:** {{ $prize->displayName() ?? $prize->nom }}

**Punts gastats:** {{ $claim->punts_gastats }}

**Data reclamacio:** {{ optional($claim->data_reclamacio)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}

**Estat inicial:** {{ ucfirst($claim->estat ?? 'pendent') }}
@endcomponent

Quan canvii l'estat del teu premi, t'avisarem per correu.

@component('mail::button', ['url' => $profileUrl])
Veure el meu perfil
@endcomponent

Gracies,
{{ config('app.name') }}
@endcomponent
