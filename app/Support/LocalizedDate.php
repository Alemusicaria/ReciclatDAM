<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class LocalizedDate
{
    public static function format(mixed $value, string $locale, string $pattern, string $fallback = '-'): string
    {
        if (empty($value)) {
            return $fallback;
        }

        try {
            $date = $value instanceof CarbonInterface ? $value : Carbon::parse($value);

            return $date->locale($locale)->translatedFormat($pattern);
        } catch (\Throwable) {
            return $fallback;
        }
    }

    public static function human(mixed $value, string $locale, string $fallback = '-'): string
    {
        if (empty($value)) {
            return $fallback;
        }

        try {
            $date = $value instanceof CarbonInterface ? $value : Carbon::parse($value);

            return $date->locale($locale)->diffForHumans();
        } catch (\Throwable) {
            return $fallback;
        }
    }
}
