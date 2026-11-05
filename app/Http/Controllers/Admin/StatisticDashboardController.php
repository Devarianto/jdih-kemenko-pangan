<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\StatisticController;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Helpers\admin;

class StatisticDashboardController extends Controller
{
    use BaseTrait;

    /**
     * Dashboard Statistik Admin View
     */
    public function getIndex(Request $request = null)
    {
        $request = $request ?: request();
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = true;

        $stats = StatisticController::getStatisticsData($year, $ruleTypeId, $isAdmin);
        $matrix = StatisticController::getCrossTabMatrix($year, $ruleTypeId, $isAdmin);
        $initialDocs = StatisticController::getDocumentsQuery($request, $isAdmin, true);

        $title = 'Statistik Produk Hukum';

        return view('admin.statistics.index', compact('stats', 'matrix', 'initialDocs', 'title'));
    }

    /**
     * AJAX endpoint to reload stats and matrix on filter change
     */
    public function getData(Request $request = null)
    {
        $request = $request ?: request();
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = true;

        $stats = StatisticController::getStatisticsData($year, $ruleTypeId, $isAdmin);
        $matrix = StatisticController::getCrossTabMatrix($year, $ruleTypeId, $isAdmin);

        return response()->json([
            'status' => 'success',
            'stats' => $stats,
            'matrix' => $matrix,
        ]);
    }

    /**
     * AJAX endpoint for document drilldown (pagination, search, sorting)
     */
    public function getDocuments(Request $request)
    {
        $isAdmin = true;
        $paginated = StatisticController::getDocumentsQuery($request, $isAdmin, true);

        return response()->json([
            'status' => 'success',
            'data' => $paginated,
        ]);
    }

    /**
     * Export PDF report from Admin
     */
    public function getDownload(Request $request)
    {
        // Force isAdmin flag to true
        $request->merge(['is_admin' => 1]);
        $statisticController = app(StatisticController::class);
        return $statisticController->exportPdf($request);
    }
}

