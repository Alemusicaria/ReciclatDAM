<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class AutoTranslator
{
    public static function translate(?string $value, string $manualGroup = ''): ?string
    {
        if ($value === null || trim($value) === '') {
            return $value;
        }

        $targetLocale = self::normalizeLocale(app()->getLocale());
        $cacheKey = 'auto-translation:' . $targetLocale . ':' . md5($manualGroup . '|' . $value);

        return Cache::rememberForever($cacheKey, function () use ($value, $manualGroup, $targetLocale) {
            $translated = self::translateWithGoogle($value, $targetLocale);
            if ($translated !== null && trim($translated) !== '' && $translated !== $value) {
                return $translated;
            }

            $manual = self::translateFromLanguageFiles($value, $manualGroup);
            if ($manual !== null && trim($manual) !== '' && $manual !== $value) {
                return $manual;
            }

            return $value;
        });
    }

    private static function translateWithGoogle(string $value, string $targetLocale): ?string
    {
        try {
            $translator = new GoogleTranslate($targetLocale);
            $translator->setSource('auto');
            return $translator->translate($value);
        } catch (Throwable) {
            return null;
        }
    }

    private static function translateFromLanguageFiles(string $value, string $manualGroup): ?string
    {
        if ($manualGroup === '') {
            return null;
        }

        $manualKey = 'messages.' . $manualGroup . '.' . Str::slug($value);
        $manualTranslation = __($manualKey);

        return $manualTranslation === $manualKey ? null : $manualTranslation;
    }

    private static function normalizeLocale(string $locale): string
    {
        $locale = strtolower(str_replace('_', '-', $locale));

        return Str::before($locale, '-');
    }
}