@component('mail::message')
# Benvingut/da a {{ config('app.name') }}!

Hola **{{ $user->nom ?? $user->name ?? 'usuari' }}**,

Gràcies per unir-te a la comunitat de reciclatge de ReciclatDAM! Estem encantats de tenir-te amb nosaltres.

**Què pots fer ara?**

@component('mail::panel')
🌱 Escaneja codis de barres de productes per obtenir informació
📱 Reporta incidències en punts de recollida
🎮 Participa en esdeveniments i guanya ECODAMS
🏆 Bescanvia els teus punts per premis exclusius
@endcomponent

@component('mail::button', ['url' => route('login'), 'color' => 'primary'])
Accedeix al teu compte
@endcomponent

Si tens qualsevol dubte o suggeriment, no dubtis a posar-te en contacte amb nosaltres.

Moltes gràcies per contribuir a un món més sostenible!

Atentament,<br>
L'equip de {{ config('app.name') }}

<div style="text-align: center; margin-top: 30px;">
    <img src="https://reciclatdam.com/images/logo.png"  alt="{{ config('app.name') }}" class="logo-email">
    <p style="margin-top: 15px; color: #88a; font-size: 14px;">
        Junts per un futur més verd! 🌍
    </p>
</div>
@endcomponent