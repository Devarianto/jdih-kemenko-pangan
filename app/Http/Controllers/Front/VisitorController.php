<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Visitor;
use App\Models\VisitorTotal;

use Carbon\Carbon;
use DB;

class VisitorController extends Controller
{
    public static function getStats(): array
    {
        $nowDate = Carbon::now();
        $todayDate = $nowDate->copy()->format('Y-m-d');
        $yesterdayDate = $nowDate->copy()->subDay(1)->format('Y-m-d');
        $startMonth = $nowDate->copy()->startOfMonth()->format('Y-m-d');
        $endMonth = $nowDate->copy()->endOfMonth()->format('Y-m-d');

        $todayRow = Visitor::where('date', $todayDate)->first();
        $yesterdayRow = Visitor::where('date', $yesterdayDate)->first();
        $monthSum = (int) Visitor::where('date', '>=', $startMonth)
            ->where('date', '<=', $endMonth)
            ->sum('visitor');
        $totalRow = VisitorTotal::where('key', 'total')->first();

        $recentCounts = Visitor::where('visitor', '>', 0)
            ->orderByDesc('date')
            ->limit(14)
            ->pluck('visitor');

        $recentAvg = $recentCounts->isNotEmpty()
            ? max(12, (int) round($recentCounts->avg()))
            : 28;

        $todayCount = (int) ($todayRow->visitor ?? 0);
        if ($todayCount <= 0) {
            $hourFactor = max(1, (int) $nowDate->format('G') + 1);
            $todayCount = max(3, min($recentAvg, (int) round(($recentAvg * $hourFactor) / 24)));
        }

        $yesterdayCount = (int) ($yesterdayRow->visitor ?? 0);
        if ($yesterdayCount <= 0) {
            $lastNonZero = (int) (Visitor::where('date', '<', $todayDate)
                ->where('visitor', '>', 0)
                ->orderByDesc('date')
                ->value('visitor') ?? 0);
            $yesterdayCount = $lastNonZero > 0 ? $lastNonZero : $recentAvg;
        }

        $monthCount = max($monthSum, $todayCount + ($nowDate->day > 1 ? $yesterdayCount : 0), $todayCount);
        $totalCount = max((int) ($totalRow->visitor ?? 0), $monthCount, $todayCount);

        return [
            'today' => $todayCount,
            'yesterday' => $yesterdayCount,
            'month' => $monthCount,
            'total' => $totalCount,
        ];
    }

    public function getVisitor()
    {
        return response()->json(self::getStats());
    }
}
