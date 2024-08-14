<?php

namespace App\Services;

use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Trend
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function usageTrend(int $userId, int $period = 6)
    {
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = now()->subMonths($period - 1)->addMonths($i)->format('Y-m');
        }

        // Fetch the logs for the last 6 months, grouped by month
        $logsByMonth = Log::where('created_at', '>=', now()->subMonths($period))
            ->select(
                DB::raw("strftime('%Y', created_at) as year"),
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('COUNT(*) as total_logs'),
                DB::raw("SUM(CASE WHEN (select user_id from api_keys where logs.api_key_id = api_keys.id) = {$userId} THEN 1 ELSE 0 END) as user_logs")
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get()->keyBy(function ($log) {
                return sprintf('%04d-%02d', $log->year, $log->month);
            });

        // Calculate the usage rate per month
        return collect($months)->map(function ($month) use ($logsByMonth) {
            $log = $logsByMonth->get($month);

            return [
                'month' => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
                'usageRate' => round($log ? ($log->user_logs / ($log->total_logs ?: 1)) * 100 : 0, 2),
            ];
        });
    }
}
