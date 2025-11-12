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
    public function getVisitor()
    {
        $now_date = Carbon::now();
        $today = Visitor::where('date', $now_date->copy()->format('Y-m-d'))->first();

        $yesterday_date = $now_date->copy()->subDay(1)->format('Y-m-d');
        $yesterday = Visitor::where('date', $yesterday_date)->first();

        $start_month = $now_date->copy()->startOfMonth()->format('Y-m-d');
        $end_month = $now_date->copy()->endOfMonth()->format('Y-m-d');
        $month = Visitor::select(DB::raw('sum(visitor) as total_visitor'))->where('date', '>=', $start_month)->where('date', '<=', $end_month)->first();

        $total = VisitorTotal::where('key', 'total')->first();

        $response = [
            'today' => is_null($today) ? 0 : $today->visitor,
            'yesterday' => is_null($yesterday) ? 0 : $yesterday->visitor,
            'month' => is_null($month) ? 0 : $month->total_visitor,
            'total' => is_null($total) ? 0 : $total->visitor,
        ];

        return response()->json($response);
    }
}
