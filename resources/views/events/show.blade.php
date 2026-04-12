@extends('layouts.app')

@section('content')
<style>
    .event-detail-view {
        --event-surface: #ffffff;
        --event-bg: linear-gradient(135deg, #f3f8ff 0%, #f7fff6 100%);
        --event-border: #e8eef7;
        --event-text: #1b2430;
        --event-muted: #5f6f84;
        --event-accent: #1f7a8c;
    }

    .container.event-detail-view {
        max-width: 1140px;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .event-detail-view .event-shell {
        border: 1px solid var(--event-border);
        border-radius: 20px;
        background: var(--event-surface);
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(17, 34, 68, 0.08);
    }

    .event-detail-view .event-header {
        background: var(--event-bg);
        padding: 2rem;
        border-bottom: 1px solid var(--event-border);
    }

    .event-detail-view .event-title {
        color: var(--event-text);
        letter-spacing: -0.02em;
    }

    .event-detail-view .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 0.85rem;
    }

    .event-detail-view .meta-card {
        background: #fff;
        border: 1px solid var(--event-border);
        border-radius: 14px;
        padding: 0.9rem 1rem;
    }

    .event-detail-view .meta-label {
        color: var(--event-muted);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.2rem;
    }

    .event-detail-view .meta-value {
        color: var(--event-text);
        font-weight: 600;
        margin: 0;
    }

    .event-detail-view .event-description {
        color: #2d3a4c;
        line-height: 1.45;
        font-size: 0.94rem;
        max-width: 70ch;
    }

    .event-detail-view .event-description-box {
        max-width: 640px;
        margin: 0 auto;
        padding: 0.85rem 1rem;
        border: 0;
        border-radius: 12px;
        background: #ffffff;
    }

    .event-detail-view .event-body {
        height: 20vh;
        min-height: 0 !important;
        display: flex;
        flex-direction: column;
    }

    .event-detail-view .event-body .event-description-box {
        flex: 1;
        overflow-y: auto;
    }

    .event-detail-view .event-actions {
        border-top: 1px solid var(--event-border);
        background: #fcfdff;
    }

    .event-detail-view .event-actions-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .event-detail-view .event-actions-left,
    .event-detail-view .event-actions-right {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .event-detail-view .event-actions-right {
        justify-content: flex-end;
    }

    .event-detail-view .event-feedback {
        margin-top: 0.75rem;
    }

    .event-detail-view .calendar-actions-inline {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.5rem;
        min-width: min(420px, 100%);
    }

    .event-detail-view .calendar-actions-inline .calendar-action-btn {
        width: 100%;
        min-height: 38px;
        padding: 0.45rem 0.75rem;
        font-size: 0.82rem;
        line-height: 1.2;
        align-items: center;
        border: 0;
    }

    .event-detail-view #event-ics-btn {
        appearance: none;
    }

    @media (max-width: 768px) {
        .event-detail-view .event-actions-row {
            flex-direction: column;
            align-items: stretch;
        }

        .event-detail-view .event-actions-left,
        .event-detail-view .event-actions-right {
            width: 100%;
            justify-content: flex-start;
        }

        .event-detail-view .calendar-actions-inline {
            min-width: 100%;
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .event-detail-view .event-header,
        .event-detail-view .event-body,
        .event-detail-view .event-actions {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
</style>

<div class="container page-offset-profile event-detail-view" data-page-title="{{ $event->displayName() }}">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            @php
                $locale = app()->getLocale();
                $calendarStart = $event->data_inici ? $event->data_inici->copy() : null;
                $calendarEnd = $event->data_fi
                    ? $event->data_fi->copy()
                    : ($calendarStart ? $calendarStart->copy()->addHour() : null);

                $googleCalendarUrl = '';
                if ($calendarStart && $calendarEnd) {
                    $googleCalendarUrl = 'https://calendar.google.com/calendar/render?' . http_build_query([
                        'action' => 'TEMPLATE',
                        'text' => $event->displayName(),
                        'dates' => $calendarStart->copy()->utc()->format('Ymd\\THis\\Z') . '/' . $calendarEnd->copy()->utc()->format('Ymd\\THis\\Z'),
                        'details' => strip_tags((string) $event->displayDescription()),
                        'location' => strip_tags((string) $event->displayLocation()),
                    ]);
                }

                $isPast = $event->data_inici && $event->data_inici->isPast();
                $isRegistered = auth()->check() ? $event->participants->contains('id', auth()->id()) : false;
                $isFull = $event->capacitat !== null && $event->participants->count() >= $event->capacitat;
                $participantsCount = $event->participants->count();
                $spotsLeft = $event->capacitat !== null ? max($event->capacitat - $participantsCount, 0) : null;

                $currentUserEventPoints = null;
                if ($isRegistered && auth()->check()) {
                    $currentUserPivot = $event->participants->firstWhere('id', auth()->id());
                    $currentUserEventPoints = (int) optional($currentUserPivot?->pivot)->punts;
                }
            @endphp

            <article class="event-shell mb-4">
                <header class="event-header">
                    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-3">
                        <h1 class="event-title h2 mb-0">{{ $event->displayName() }}</h1>
                        @if($event->tipus)
                            <span class="badge px-3 py-2" style="background-color: {{ $event->tipus->color }}; color: #fff;">
                                {{ $event->displayTypeName() }}
                            </span>
                        @endif
                    </div>

                    <div class="event-meta-grid">
                        <div class="meta-card">
                            <div class="meta-label">{{ __('messages.events_ui.date') }}</div>
                            <p class="meta-value mb-1">
                                <i class="fas fa-calendar-alt me-2 text-secondary"></i>
                                {{ \App\Support\LocalizedDate::format($event->data_inici, $locale, 'l, d F Y') }}
                            </p>
                            <p class="meta-value mb-0">
                                <i class="fas fa-clock me-2 text-secondary"></i>
                                {{ optional($event->data_inici)->format('H:i') }}
                                @if($event->data_fi)
                                    - {{ optional($event->data_fi)->format('H:i') }}
                                @endif
                            </p>
                        </div>

                        <div class="meta-card">
                            <div class="meta-label">{{ __('messages.events_ui.location') }}</div>
                            <p class="meta-value">
                                <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                                {{ $event->displayLocation() ?: __('messages.events_ui.not_specified') }}
                            </p>
                        </div>

                        <div class="meta-card">
                            <div class="meta-label">{{ __('messages.events_ui.capacity') }}</div>
                            <p class="meta-value">
                                <i class="fas fa-users me-2 text-secondary"></i>
                                {{ $event->capacitat !== null ? $event->capacitat : __('messages.events_ui.unlimited') }}
                            </p>
                            <p class="meta-value mt-1" style="font-weight: 500; font-size: 0.9rem;">
                                Apuntats: {{ $participantsCount }}
                                @if($spotsLeft !== null)
                                    (lliures: {{ $spotsLeft }})
                                @endif
                            </p>
                        </div>

                        <div class="meta-card">
                            <div class="meta-label">ECODAMS</div>
                            <p class="meta-value">
                                <i class="fas fa-coins me-2 text-secondary"></i>
                                {{ (int) ($event->punts_disponibles ?? 0) }}
                            </p>
                        </div>
                    </div>
                </header>

                <section class="event-body p-3 p-lg-4">
                    <h2 class="h6 text-uppercase text-secondary fw-semibold mb-2">{{ __('messages.events_ui.description') }}</h2>
                    <div class="event-description-box">
                        <p class="event-description mb-0">{{ $event->displayDescription() ?: __('messages.events_ui.no_description') }}</p>
                    </div>
                </section>

                <footer class="event-actions p-4 p-lg-4">
                    <div class="event-actions-row">
                        <div class="event-actions-left">
                            <a href="{{ route('dashboard') }}#events" class="btn btn-outline-secondary px-3">
                                <i class="fas fa-arrow-left me-1"></i> Tornar a events
                            </a>

                            @if($googleCalendarUrl !== '')
                                <div class="calendar-actions-inline">
                                    <a href="{{ $googleCalendarUrl }}" target="_blank" rel="noopener noreferrer" class="btn calendar-action-btn calendar-action-btn-google text-nowrap">
                                        <i class="fas fa-calendar-plus me-1"></i>{{ __('messages.events_ui.google_calendar') }}
                                    </a>
                                    <button type="button" id="event-ics-btn" class="btn calendar-action-btn calendar-action-btn-iphone text-nowrap">
                                        <i class="fas fa-mobile-alt me-1"></i>{{ __('messages.events_ui.iphone_calendar') }}
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="event-actions-right">
                            @auth
                                @if($isPast)
                                    <button class="btn btn-secondary px-3" disabled>{{ __('messages.events_ui.event_finished') }}</button>
                                @elseif($isFull)
                                    <button class="btn btn-warning px-3" disabled>{{ __('messages.events_ui.full_capacity') }}</button>
                                @elseif($isRegistered)
                                    {{-- Registration success is shown in the feedback block below. --}}
                                @else
                                    <form action="{{ route('events.register', $event->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-primary px-3">{{ __('messages.events_ui.register') }}</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary px-3">{{ __('messages.events_ui.login_to_register') }}</a>
                            @endauth
                        </div>
                    </div>

                    @if($isRegistered && !$isPast)
                        <div class="event-feedback">
                            <div class="alert alert-success small mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('messages.events_ui.registration_success_title') }}</strong>
                                        <p class="mb-0">{{ __('messages.events_ui.registration_success_existing', ['date' => optional($event->data_inici)->format('d/m/Y'), 'time' => optional($event->data_inici)->format('H:i')]) }}</p>
                                    </div>
                                </div>
                            </div>

                            @if(($event->punts_disponibles ?? 0) > 0)
                                <div class="alert {{ $currentUserEventPoints > 0 ? 'alert-info' : 'alert-warning' }} small mt-2 mb-0">
                                    @if($currentUserEventPoints > 0)
                                        ECODAMS d'aquest event rebuts: <strong>{{ $currentUserEventPoints }}</strong>
                                    @else
                                        ECODAMS d'aquest event: <strong>{{ (int) $event->punts_disponibles }}</strong> (pendents d'assignar)
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </footer>
            </article>
        </div>
    </div>
</div>

@if($calendarStart && $calendarEnd)
<script>
    (function () {
        const icsButton = document.getElementById('event-ics-btn');
        if (!icsButton) return;

        const calendarEvent = {
            id: @json($event->id),
            title: @json($event->displayName()),
            start: @json($calendarStart->toIso8601String()),
            end: @json($calendarEnd->toIso8601String()),
            description: @json((string) $event->displayDescription()),
            location: @json((string) $event->displayLocation()),
        };

        const toCalendarUtc = (date) => {
            if (!date) return '';
            return new Date(date).toISOString().replace(/[-:]/g, '').replace(/\.\d{3}Z$/, 'Z');
        };

        const escapeIcsText = (text) => {
            return String(text || '')
                .replace(/\\/g, '\\\\')
                .replace(/;/g, '\\;')
                .replace(/,/g, '\\,')
                .replace(/\r?\n/g, '\\n');
        };

        const slugifyFileName = (text) => {
            return String(text || 'event')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '')
                .slice(0, 80) || 'event';
        };

        const formatFileDate = (date) => {
            if (!date) return 'sense-data';
            const d = new Date(date);
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${day}`;
        };

        icsButton.addEventListener('click', function () {
            const start = calendarEvent.start ? new Date(calendarEvent.start) : null;
            const end = calendarEvent.end ? new Date(calendarEvent.end) : null;
            if (!start || !end) return;

            const ics = [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//ReciclatDAM//Events//CA',
                'CALSCALE:GREGORIAN',
                'BEGIN:VEVENT',
                `UID:event-${calendarEvent.id || Date.now()}@reciclatdam`,
                `DTSTAMP:${toCalendarUtc(new Date())}`,
                `DTSTART:${toCalendarUtc(start)}`,
                `DTEND:${toCalendarUtc(end)}`,
                `SUMMARY:${escapeIcsText(calendarEvent.title || 'Event')}`,
                `DESCRIPTION:${escapeIcsText(calendarEvent.description || '')}`,
                `LOCATION:${escapeIcsText(calendarEvent.location || '')}`,
                'END:VEVENT',
                'END:VCALENDAR'
            ].join('\r\n');

            const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `${slugifyFileName(calendarEvent.title)}-${formatFileDate(start)}.ics`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        });
    })();
</script>
@endif
@endsection
