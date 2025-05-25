@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Hola!
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Atentament,<br>
L'equip de {{ config('app.name') }}
@endif

{{-- Logo --}}
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td>
                        <img src="https://reciclatdam.com/images/logo.png" alt="Logo" width="150" style="max-width: 100%;">
                    </td>
                </tr>
            </table>
            <p style="margin-top: 15px; color: #888; font-size: 12px;">
                Recorda que el teu compromís amb el reciclatge fa la diferència!
            </p>
        </td>
    </tr>
</table>

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Si tens problemes fent clic al botó \":actionText\", copia i enganxa l'enllaç següent\n".
    'al teu navegador:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent