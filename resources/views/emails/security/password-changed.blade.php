@component('mail::message')
# Contrasenya actualitzada

Hola **{{ $user->nom ?? 'usuari' }}**, t'informem que la contrasenya del teu compte s'ha actualitzat correctament.

Si no has estat tu, et recomanem:

1. Restablir la contrasenya immediatament.
2. Revisar l'activitat recent del compte.
3. Contactar amb suport.

@component('mail::button', ['url' => $changePasswordUrl])
Canviar contrasenya ara
@endcomponent

Si no pots entrar al compte, demana un enllac de recuperacio aqui: {{ $forgotPasswordUrl }}

Aquest correu es de seguretat informativa.

{{ config('app.name') }}
@endcomponent
