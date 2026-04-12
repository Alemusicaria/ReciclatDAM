<?php

namespace App\Support;

use App\Models\User;

class EmailActionLink
{
    public static function forRoute(User $recipient, string $routeName, array $routeParameters = [], int $minutes = 10080): string
    {
        $targetUrl = route($routeName, $routeParameters);

        return self::forTarget($recipient, $targetUrl, $minutes);
    }

    public static function forTarget(User $recipient, string $targetUrl, int $minutes = 10080): string
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'email.secure-redirect',
            now()->addMinutes($minutes),
            [
                'recipient' => (int) $recipient->id,
                'target' => base64_encode($targetUrl),
            ]
        );
    }
}
