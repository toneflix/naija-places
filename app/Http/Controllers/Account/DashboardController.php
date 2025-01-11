<?php

namespace App\Http\Controllers\Account;

use App\Helpers\Providers;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Services\Trend;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $userScope = fn($q) => $q->whereUserId($user->id);

        $usage = Log::whereHas('apiKey', $userScope)->count();

        $weeklyUsage = Log::whereHas('apiKey', $userScope)->whereBetween('created_at', [
            now()->subWeek(),
            now(),
        ])->count();

        $dailyUsage = Log::whereHas('apiKey', $userScope)->whereBetween('created_at', [
            now()->subDay(),
            now(),
        ])->count();

        $usageRate = (Log::whereHas('apiKey', $userScope)->count() / (Log::count() ?: 1)) * 100;


        return Providers::response()->success([
            'data' => [
                'usage' => $usage,
                'dailyUsage' => $dailyUsage,
                'weeklyUsage' => $weeklyUsage,
                'totalKeys' => $user->apiKeys()->count(),
                'usageRate' => round($usageRate, 2),
                'usageTrend' => Trend::usageTrend($user->id, 6)
            ]
        ]);
    }
}
