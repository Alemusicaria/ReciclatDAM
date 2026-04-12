<?php

namespace App\Console\Commands;

use App\Mail\ReEngagementMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendReEngagementEmails extends Command
{
    protected $signature = 'emails:send-reactivation {--days=30 : Inactivity days threshold}';

    protected $description = 'Send re-engagement emails to inactive users';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $days = $days > 0 ? $days : 30;

        $threshold = Carbon::now()->subDays($days);

        $users = User::query()
            ->whereNotNull('email')
            ->where('created_at', '<=', $threshold)
            ->whereDoesntHave('activities', function ($query) use ($threshold) {
                $query->where('created_at', '>=', $threshold);
            })
            ->get();

        $sent = 0;

        foreach ($users as $user) {
            if (!$user instanceof User) {
                continue;
            }

            if (!is_string($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $cacheKey = sprintf('emails:reactivation:%d:%s', (int) $user->id, now()->format('Y-m-d'));

            if (!Cache::add($cacheKey, true, now()->addDay())) {
                continue;
            }

            Mail::to($user->email)->queue(new ReEngagementMail($user));
            $sent++;
        }

        $this->info("Re-engagement emails queued: {$sent}");

        return self::SUCCESS;
    }
}
