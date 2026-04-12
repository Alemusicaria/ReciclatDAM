@component('mail::message')
# Estat del teu premi actualitzat

Hola **{{ $user->nom ?? 'usuari' }}**, l'estat de la teva reclamacio ha canviat.

@component('mail::panel')
**Premi:** {{ optional($claim->premi)->displayName() ?? optional($claim->premi)->nom ?? 'Premi' }}

**Estat anterior:** {{ $previousStatus }}

**Estat actual:** {{ $newStatus }}

**Codi seguiment:** {{ $claim->codi_seguiment ?: 'Encara no disponible' }}
@endcomponent

@if(!empty($claim->comentaris))
**Comentaris:** {{ $claim->comentaris }}
@endif

Pots consultar l'estat des del teu perfil.

@component('mail::button', ['url' => $profileUrl])
Obrir perfil
@endcomponent

{{ config('app.name') }}
@endcomponent
