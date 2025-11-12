<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Visitor;
use App\Models\VisitorTotal;

use Carbon\Carbon;

class VisitorCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $date = Carbon::now()->format('Y-m-d');
        $visitor = Visitor::where('date', $date)->first();
        if ($visitor == null) {
            $visitor = new Visitor;
            $visitor->visitor = 1;
            $visitor->date = $date;
        } else {
            $visitor->visitor += 1;
            $visitor->date = $date;
        }
        $visitor->save();

        $visitor_total = VisitorTotal::where('key', 'total')->first();
        if ($visitor_total != null) {
            $visitor_total->visitor += 1;
            $visitor_total->save();
        } else {
            $visitor_total = new VisitorTotal;
            $visitor_total->key = 'total';
            $visitor_total->visitor = 1;
            $visitor_total->save();
        }

        $month_date = Carbon::now()->subMonths(3)->startOfMonth()->format('Y-m-d');
        Visitor::where('date', '<', $month_date)->delete();

        return $next($request);
    }
}
