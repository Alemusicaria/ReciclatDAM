<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Generar URL de mapa estadístico protegido con API key en backend
     */
    public function staticMap(Request $request)
    {
        try {
            $validated = $request->validate([
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
                'width' => 'integer|between:1,1280',
                'height' => 'integer|between:1,1280',
            ]);

            // Valores por defecto
            $width = $validated['width'] ?? 150;
            $height = $validated['height'] ?? 100;
            $zoom = 15;
            $scale = 2;

            // Construir URL con API key en backend (nunca expuesta al frontend)
            $apiKey = config('services.google_maps.key');
            
            if (!$apiKey) {
                return response()->json(['error' => 'Map service not configured'], 500);
            }

            $mapUrl = 'https://maps.googleapis.com/maps/api/staticmap?' . http_build_query([
                'center' => "{$validated['lat']},{$validated['lng']}",
                'zoom' => $zoom,
                'size' => "{$width}x{$height}",
                'scale' => $scale,
                'markers' => "color:red|{$validated['lat']},{$validated['lng']}",
                'key' => $apiKey,
            ]);

            return response()->json([
                'url' => $mapUrl,
                'lat' => $validated['lat'],
                'lng' => $validated['lng'],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Invalid parameters'], 422);
        } catch (\Exception $e) {
            \Log::error('MapController error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
