<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $lat = (float) $validated['lat'];
            $lng = (float) $validated['lng'];

            $googleMapsEnabled = (bool) config('services.google_maps.enabled', false);
            $googleApiKey = (string) config('services.google_maps.key');

            // If Google is enabled, fetch map server-side and stream bytes to avoid exposing API keys.
            if ($googleMapsEnabled && $googleApiKey !== '') {
                try {
                    $googleMapUrl = 'https://maps.googleapis.com/maps/api/staticmap?' . http_build_query([
                        'center' => $lat . ',' . $lng,
                        'zoom' => $zoom,
                        'size' => $width . 'x' . $height,
                        'scale' => $scale,
                        'markers' => 'color:red|' . $lat . ',' . $lng,
                        'key' => $googleApiKey,
                    ]);

                    $googleClient = Http::timeout(2)
                        ->connectTimeout(1)
                        ->retry(0);

                    if (app()->environment(['local', 'development', 'testing'])) {
                        $googleClient = $googleClient->withoutVerifying();
                    }

                    $googleResponse = $googleClient->get($googleMapUrl);

                    if ($googleResponse->ok()) {
                        $contentType = strtolower((string) ($googleResponse->header('Content-Type') ?? ''));
                        if (str_contains($contentType, 'image/')) {
                            return response($googleResponse->body(), 200)
                                ->header('Content-Type', $contentType)
                                ->header('Cache-Control', 'public, max-age=3600');
                        }
                    }
                } catch (\Throwable $googleError) {
                    Log::debug('Google Maps fetch failed, trying fallbacks', [
                        'message' => $googleError->getMessage(),
                    ]);
                }
            }

            // Try providers server-side so client DNS issues do not break map previews.
            foreach ($this->buildMapUrls($lat, $lng, $width, $height, $zoom, $scale) as $mapUrl) {
                try {
                    $mapClient = Http::timeout(4)
                        ->connectTimeout(2)
                        ->retry(0);

                    if (app()->environment(['local', 'development', 'testing'])) {
                        $mapClient = $mapClient->withoutVerifying();
                    }

                    $mapResponse = $mapClient->get($mapUrl);

                    if (!$mapResponse->ok()) {
                        continue;
                    }

                    $contentType = strtolower((string) ($mapResponse->header('Content-Type') ?? ''));
                    if (!str_contains($contentType, 'image/')) {
                        continue;
                    }

                    return response($mapResponse->body(), 200)
                        ->header('Content-Type', $contentType)
                        ->header('Cache-Control', 'public, max-age=3600');
                } catch (\Throwable $providerError) {
                    Log::debug('Map provider fetch failed', [
                        'provider' => parse_url($mapUrl, PHP_URL_HOST),
                        'message' => $providerError->getMessage(),
                    ]);
                }
            }

            return response($this->buildFallbackSvg($lat, $lng, $width, $height), 200)
                ->header('Content-Type', 'image/svg+xml; charset=UTF-8')
                ->header('Cache-Control', 'public, max-age=300');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Invalid parameters'], 422);
        } catch (\Throwable $e) {
            Log::error('MapController error', [
                'message' => $e->getMessage(),
            ]);

            return response($this->buildFallbackSvg(0, 0, 150, 100), 200)
                ->header('Content-Type', 'image/svg+xml; charset=UTF-8')
                ->header('Cache-Control', 'public, max-age=300');
        }
    }

    private function buildMapUrls(float $lat, float $lng, int $width, int $height, int $zoom, int $scale): array
    {
        $apiKey = (string) config('services.google_maps.key');
        $googleMapsEnabled = (bool) config('services.google_maps.enabled', false);
        $urls = [];

        if ($googleMapsEnabled && $apiKey !== '') {
            $urls[] = 'https://maps.googleapis.com/maps/api/staticmap?' . http_build_query([
                'center' => $lat . ',' . $lng,
                'zoom' => $zoom,
                'size' => $width . 'x' . $height,
                'scale' => $scale,
                'markers' => 'color:red|' . $lat . ',' . $lng,
                'key' => $apiKey,
            ]);
        }

        // Try multiple OSM static map providers (both HTTPS and HTTP via different hosts)
        $urls[] = 'https://staticmap.openstreetmap.de/staticmap.php?' . http_build_query([
            'center' => $lat . ',' . $lng,
            'zoom' => $zoom,
            'size' => $width . 'x' . $height,
            'maptype' => 'mapnik',
            'markers' => $lat . ',' . $lng . ',red-pushpin',
        ]);

        // Tile-based map from OSM (alternative approach)
        $urls[] = 'https://maps.geoapify.com/v1/staticmap?' . http_build_query([
            'style' => 'osm-bright',
            'width' => $width,
            'height' => $height,
            'center' => 'lonlat:' . $lng . ',' . $lat,
            'zoom' => $zoom,
            'marker' => 'lonlat:' . $lng . ',' . $lat . ';color:%23ff0000',
        ]);

        // Fallback: Simple tile-based approach using tile server
        $tileSize = 256;
        $tileX = (int) floor(($lng + 180) / 360 * pow(2, $zoom));
        $tileY = (int) floor((1 - log(tan(deg2rad($lat)) + 1 / cos(deg2rad($lat))) / pi()) / 2 * pow(2, $zoom));
        
        $urls[] = 'https://tile.openstreetmap.org/' . $zoom . '/' . $tileX . '/' . $tileY . '.png';

        return $urls;
    }

    private function buildFallbackSvg(float $lat, float $lng, int $width, int $height): string
    {
        $safeWidth = max(80, min(1280, $width));
        $safeHeight = max(60, min(1280, $height));
        $label = sprintf('Lat %.4f, Lng %.4f', $lat, $lng);
        $seed = $this->seedFromCoordinates($lat, $lng);

        // Deterministic random factors based on coordinates so each point looks different.
        $mapShiftX = $this->seededFloat($seed, 0, -0.08, 0.08);
        $mapShiftY = $this->seededFloat($seed, 1, -0.08, 0.08);
        $roadJitter1 = $this->seededFloat($seed, 2, -0.06, 0.06);
        $roadJitter2 = $this->seededFloat($seed, 3, -0.06, 0.06);
        $parkScale = $this->seededFloat($seed, 4, 0.8, 1.25);
        $parkOffsetX = $this->seededFloat($seed, 5, -0.06, 0.06);
        $parkOffsetY = $this->seededFloat($seed, 6, -0.06, 0.06);

        $cx = (int) round($safeWidth * (0.5 + $mapShiftX));
        $cy = (int) round($safeHeight * (0.44 + $mapShiftY));
        $pinR = max(6, (int) round(min($safeWidth, $safeHeight) * 0.065));
        $baseY = (int) round($cy + ($safeHeight * 0.12));
        $tipY = (int) round($cy + ($safeHeight * 0.34));
        $leftX = $cx - (int) round($pinR * 0.75);
        $rightX = $cx + (int) round($pinR * 0.75);
        $labelRectY = $safeHeight - 24;
        $labelTextY = $safeHeight - 10;
        $labelRectWidth = $safeWidth - 12;

        $road1Y = (int) round($safeHeight * (0.28 + $roadJitter1));
        $road2Y = (int) round($safeHeight * (0.62 + $roadJitter2));
        $road3X = (int) round($safeWidth * (0.68 + $this->seededFloat($seed, 7, -0.08, 0.08)));
        $road1CenterY = $road1Y + 5;
        $road2CenterY = $road2Y + 4;
        $road3CenterX = $road3X + 5;

        $waterY = (int) round($safeHeight * (0.06 + $this->seededFloat($seed, 8, -0.03, 0.03)));
        $waterH = (int) round($safeHeight * (0.18 + $this->seededFloat($seed, 9, -0.04, 0.05)));

        $parkX = (int) round($safeWidth * (0.08 + $parkOffsetX));
        $parkY = (int) round($safeHeight * (0.48 + $parkOffsetY));
        $parkW = (int) round($safeWidth * 0.22 * $parkScale);
        $parkH = (int) round($safeHeight * 0.2 * $parkScale);

        $buildingY = max(8, (int) round($safeHeight * (0.34 + $this->seededFloat($seed, 10, -0.05, 0.05))));
        $buildingBottomY = max(8, $safeHeight - 46);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$safeWidth}" height="{$safeHeight}" viewBox="0 0 {$safeWidth} {$safeHeight}" role="img" aria-label="Static map fallback">
  <defs>
        <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#eef2f7"/>
            <stop offset="100%" stop-color="#e2e8f0"/>
    </linearGradient>
        <pattern id="grid" width="16" height="16" patternUnits="userSpaceOnUse">
            <path d="M 16 0 L 0 0 0 16" fill="none" stroke="#cbd5e166" stroke-width="1"/>
        </pattern>
  </defs>
  <rect width="100%" height="100%" fill="url(#bg)"/>
    <rect width="100%" height="100%" fill="url(#grid)"/>

    <rect x="0" y="{$waterY}" width="{$safeWidth}" height="{$waterH}" fill="#bfdbfe" opacity="0.65"/>
    <rect x="{$parkX}" y="{$parkY}" width="{$parkW}" height="{$parkH}" rx="8" fill="#bbf7d0" stroke="#86efac" stroke-width="1"/>

    <rect x="0" y="{$road1Y}" width="{$safeWidth}" height="10" fill="#94a3b8" opacity="0.92"/>
    <rect x="0" y="{$road2Y}" width="{$safeWidth}" height="8" fill="#94a3b8" opacity="0.92"/>
    <rect x="{$road3X}" y="0" width="10" height="{$safeHeight}" fill="#94a3b8" opacity="0.92"/>

    <line x1="0" y1="{$road1CenterY}" x2="{$safeWidth}" y2="{$road1CenterY}" stroke="#f8fafc" stroke-width="2" stroke-dasharray="8 6" opacity="0.9"/>
    <line x1="0" y1="{$road2CenterY}" x2="{$safeWidth}" y2="{$road2CenterY}" stroke="#f8fafc" stroke-width="2" stroke-dasharray="8 6" opacity="0.9"/>
    <line x1="{$road3CenterX}" y1="0" x2="{$road3CenterX}" y2="{$safeHeight}" stroke="#f8fafc" stroke-width="2" stroke-dasharray="8 6" opacity="0.9"/>

    <rect x="12" y="{$buildingY}" width="28" height="18" rx="2" fill="#e5e7eb" stroke="#cbd5e1"/>
    <rect x="44" y="{$buildingY}" width="18" height="24" rx="2" fill="#e5e7eb" stroke="#cbd5e1"/>
    <rect x="24" y="{$buildingBottomY}" width="26" height="14" rx="2" fill="#e5e7eb" stroke="#cbd5e1"/>

    <circle cx="{$cx}" cy="{$cy}" r="{$pinR}" fill="#ef4444" stroke="#b91c1c" stroke-width="2"/>
    <circle cx="{$cx}" cy="{$cy}" r="3" fill="#ffffff"/>
    <path d="M {$cx} {$baseY} L {$leftX} {$tipY} L {$rightX} {$tipY} Z" fill="#b91c1c"/>

    <rect x="6" y="{$labelRectY}" width="{$labelRectWidth}" height="16" rx="4" fill="#ffffffd9"/>
    <text x="50%" y="{$labelTextY}" text-anchor="middle" font-family="Arial, sans-serif" font-size="9" fill="#334155">{$label}</text>
</svg>
SVG;
    }

    private function seedFromCoordinates(float $lat, float $lng): int
    {
        $latInt = (int) round(($lat + 90) * 10000);
        $lngInt = (int) round(($lng + 180) * 10000);

        return (($latInt * 73856093) ^ ($lngInt * 19349663)) & 0x7fffffff;
    }

    private function seededFloat(int $seed, int $salt, float $min, float $max): float
    {
        $value = ($seed + ($salt * 1013904223)) & 0x7fffffff;
        $value = (($value * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;

        return $min + (($max - $min) * $value);
    }
}
