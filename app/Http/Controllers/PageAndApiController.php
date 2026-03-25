<?php

namespace App\Http\Controllers;

use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $distance = $request->get('distance', 1);

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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function alertTypes(): JsonResponse
    {
        try {
            return response()->json(TipusAlerta::all());
        } catch (\Exception $e) {
            Log::error('Error en tipus-alertes: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
