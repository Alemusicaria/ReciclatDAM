<?php

namespace App\Http\Controllers;

use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageAndApiController extends Controller
{
    public function clearSession(): JsonResponse
    {
        session()->forget('social_user');
        session()->forget('social_login');

        return response()->json(['status' => 'success']);
    }

    public function setLocale(Request $request): JsonResponse
    {
        $supportedLocales = array_keys(config('laravellocalization.supportedLocales') ?? []);

        if ($supportedLocales === []) {
            return response()->json([
                'status' => 'error',
                'message' => 'Supported locales are not configured.',
            ], 500);
        }

        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:' . implode(',', $supportedLocales)],
        ]);

        $locale = $validated['locale'];

        session(['locale' => $locale]);
        App::setLocale($locale);

        return response()->json([
            'status' => 'success',
            'locale' => $locale,
        ]);
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function offline(): View
    {
        return view('offline');
    }

    public function scanner(): View
    {
        return view('scanner');
    }

    public function nearbyCollectionPoints(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'distance' => 'nullable|numeric|min:0.1|max:100',
        ]);

        $lat = (float) $validated['lat'];
        $lng = (float) $validated['lng'];
        $distance = (float) ($validated['distance'] ?? 1);

        try {
            $points = PuntDeRecollida::where('disponible', true)
                ->whereRaw(
                    "
                    (6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitud)) *
                        cos(radians(longitud) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitud))
                    )) < ?",
                    [$lat, $lng, $lat, $distance]
                )
                ->get();

            return response()->json($points);
        } catch (\Exception $e) {
            Log::error('Error en punts-recollida/nearby: ' . $e->getMessage());
            return response()->json(['error' => 'Error intern en consultar punts propers.'], 500);
        }
    }

    public function alertTypes(): JsonResponse
    {
        try {
            return response()->json(TipusAlerta::all());
        } catch (\Exception $e) {
            Log::error('Error en tipus-alertes: ' . $e->getMessage());
            return response()->json(['error' => 'Error intern en consultar tipus d\'alerta.'], 500);
        }
    }
}
