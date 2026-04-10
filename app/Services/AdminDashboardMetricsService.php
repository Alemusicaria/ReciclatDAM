<?php

namespace App\Services;

use App\Models\Codi;
use App\Models\Event;
use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminDashboardMetricsService
{
    public function getDashboardStats(): array
    {
        return Cache::remember('admin.dashboard.stats', now()->addMinutes(5), function () {
            return [
                'totalUsers' => User::count(),
                'totalEvents' => Event::count(),
                'totalPremis' => Premi::count(),
                'totalCodis' => Codi::count(),
                'activeEvents' => Event::where('data_fi', '>=', Carbon::now())->count(),
                'pendingRewards' => PremiReclamat::where('estat', 'pendent')->count(),
                'totalActivePoints' => User::sum('punts_actuals'),
                'totalSpentPoints' => User::sum('punts_gastats'),
                'totalEventPoints' => DB::table('event_user')->sum('punts'),
            ];
        });
    }

    public function getMonthlyPercentages(): array
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        $newUsers = User::whereBetween('created_at', [$lastMonth, $now])->count();
        $usersBefore = User::where('created_at', '<', $lastMonth)->count();

        $newCodis = Codi::whereBetween('data_escaneig', [$lastMonth, $now])->count();
        $codisBefore = Codi::where('data_escaneig', '<', $lastMonth)->count();

        $newEvents = Event::whereBetween('created_at', [$lastMonth, $now])->count();
        $eventsBefore = Event::where('created_at', '<', $lastMonth)->count();

        return [
            'newUsersPercent' => $this->percent($newUsers, $usersBefore),
            'newCodisPercent' => $this->percent($newCodis, $codisBefore),
            'newEventsPercent' => $this->percent($newEvents, $eventsBefore),
        ];
    }

    public function getActivitySeries(int $monthsBack = 6): array
    {
        $monthsBack = max(1, $monthsBack);
        $start = Carbon::now()->subMonths($monthsBack - 1)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $months = collect(range(0, $monthsBack - 1))->map(function (int $offset) use ($start) {
            return $start->copy()->addMonths($offset);
        });

        $labels = $months->map(fn (Carbon $month) => $month->format('M Y'));

        $usersByMonth = $this->aggregateByMonth('users', 'created_at', $start, $end);
        $codisByMonth = $this->aggregateByMonth('codis', 'data_escaneig', $start, $end);
        $premisByMonth = $this->aggregateByMonth('premis_reclamats', 'data_reclamacio', $start, $end);

        $monthKeys = $months->map(fn (Carbon $month) => $month->format('Y-m'));

        return [
            'activityChartLabels' => $labels,
            'newUsersData' => $monthKeys->map(fn (string $key) => (int) ($usersByMonth[$key] ?? 0)),
            'codisScannedData' => $monthKeys->map(fn (string $key) => (int) ($codisByMonth[$key] ?? 0)),
            'premisClaimedData' => $monthKeys->map(fn (string $key) => (int) ($premisByMonth[$key] ?? 0)),
        ];
    }

    /**
     * @return array<string,int>
     */
    private function aggregateByMonth(string $table, string $column, Carbon $start, Carbon $end): array
    {
        $driver = DB::connection()->getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? "strftime('%Y-%m', $column)"
            : "DATE_FORMAT($column, '%Y-%m')";

        /** @var Collection<int,object{month_key:string,total:int|string}> $rows */
        $rows = DB::table($table)
            ->selectRaw("$monthExpression as month_key, COUNT(*) as total")
            ->whereBetween($column, [$start, $end])
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->get();

        return $rows->mapWithKeys(function ($row) {
            return [(string) $row->month_key => (int) $row->total];
        })->all();
    }

    private function percent(int $newCount, int $baseCount): int
    {
        if ($baseCount <= 0) {
            return 100;
        }

        return (int) round(($newCount / $baseCount) * 100);
    }
}
