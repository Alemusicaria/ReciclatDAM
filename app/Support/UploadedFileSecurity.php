<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UploadedFileSecurity
{
    private const ALLOWED_IMAGE_MIME_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    public static function storeImage(UploadedFile $file, string $directory): string
    {
        self::scanWithOptionalCommand($file);

        $mimeType = strtolower((string) $file->getMimeType());

        if (!array_key_exists($mimeType, self::ALLOWED_IMAGE_MIME_TYPES)) {
            throw ValidationException::withMessages([
                'image' => 'El fitxer pujat no és una imatge permesa.',
            ]);
        }

        $extension = self::ALLOWED_IMAGE_MIME_TYPES[$mimeType];
        $filename = Str::uuid()->toString() . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');

        if (!is_string($path) || $path === '') {
            throw ValidationException::withMessages([
                'image' => 'No s\'ha pogut desar la imatge pujada.',
            ]);
        }

        return $path;
    }

    public static function deleteStoredFile(?string $path): void
    {
        if (!is_string($path) || $path === '') {
            return;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private static function scanWithOptionalCommand(UploadedFile $file): void
    {
        $command = trim((string) config('services.upload_scan.command', ''));

        if ($command === '') {
            return;
        }

        $commandLine = str_replace('{file}', escapeshellarg($file->getPathname()), $command);
        $output = [];
        $exitCode = 0;
        exec($commandLine, $output, $exitCode);

        if ($exitCode !== 0) {
            throw ValidationException::withMessages([
                'image' => 'La comprovació de seguretat del fitxer ha fallat.',
            ]);
        }
    }
}