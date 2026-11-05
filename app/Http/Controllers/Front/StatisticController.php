<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
use App\Models\RuleType;
use App\Models\Gallery;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class StatisticController extends Controller
{
    /**
     * Aggregation engine for legal product statistics.
     * Guaranteed no N+1, dynamic aggregation from DB, respects published policy.
     *
     * @param string|int|null $year
     * @param string|int|null $ruleTypeId
     * @param bool $isAdmin
     * @return array
     */
    public static function getStatisticsData($year = null, $ruleTypeId = null, bool $isAdmin = false): array
    {
        $year = ($year !== null && $year !== '' && $year !== 'all') ? (int) $year : null;
        $ruleTypeId = ($ruleTypeId !== null && $ruleTypeId !== '' && $ruleTypeId !== 'all') ? (int) $ruleTypeId : null;

        // Base document query for Peraturan Hukum
        $docBase = Document::where('master_document_id', Document::PERATURAN);
        if (!$isAdmin) {
            $docBase->where('is_active', 1);
        }

        // Filtered document query
        $filteredQuery = clone $docBase;
        if ($year) {
            $filteredQuery->where('year', $year);
        }
        if ($ruleTypeId) {
            $filteredQuery->where('rule_type_id', $ruleTypeId);
        }

        $totalDocuments = $filteredQuery->count();

        // 1. Statistics By Rule Type
        $allRuleTypes = RuleType::where('is_active', 1)->orderBy('id', 'asc')->get();

        $ruleTypeCountsQuery = (clone $docBase)->select('rule_type_id', DB::raw('count(*) as count'));

        if ($year) {
            $ruleTypeCountsQuery->where('year', $year);
        }
        if ($ruleTypeId) {
            $ruleTypeCountsQuery->where('rule_type_id', $ruleTypeId);
        }

        $ruleTypeCounts = $ruleTypeCountsQuery->groupBy('rule_type_id')
            ->pluck('count', 'rule_type_id')
            ->toArray();

        $defaultColors = [
            '#2063D2', '#10B981', '#F59E0B', '#EF4444', 
            '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16',
            '#F97316', '#6366F1', '#14B8A6', '#64748B'
        ];

        $byType = [];
        $activeRuleTypesCount = 0;

        foreach ($allRuleTypes as $idx => $rt) {
            $count = $ruleTypeCounts[$rt->id] ?? 0;
            if ($count > 0) {
                $activeRuleTypesCount++;
            }
            $pct = $totalDocuments > 0 ? round(($count / $totalDocuments) * 100, 1) : 0.0;
            $color = !empty($rt->chart_color) ? $rt->chart_color : $defaultColors[$idx % count($defaultColors)];

            $byType[] = [
                'id' => $rt->id,
                'label' => $rt->label,
                'name' => $rt->label,
                'count' => $count,
                'percentage' => $pct,
                'color' => $color,
            ];
        }

        // Sort by count descending
        usort($byType, function ($a, $b) {
            if ($b['count'] === $a['count']) {
                return strcmp($a['label'], $b['label']);
            }
            return $b['count'] <=> $a['count'];
        });

        // 2. Statistics By Year
        $yearQuery = (clone $docBase)->select(
            'year',
            DB::raw('count(*) as total_count'),
            DB::raw('SUM(CASE WHEN status_berlaku = 1 THEN 1 ELSE 0 END) as berlaku_count'),
            DB::raw('SUM(CASE WHEN status_berlaku = 0 THEN 1 ELSE 0 END) as tidak_berlaku_count')
        )->whereNotNull('year');

        if ($ruleTypeId) {
            $yearQuery->where('rule_type_id', $ruleTypeId);
        }

        $yearDataRaw = $yearQuery->groupBy('year')->orderBy('year', 'asc')->get();

        $byYear = [];
        $topYear = ['year' => null, 'count' => 0];

        foreach ($yearDataRaw as $row) {
            $y = (int) $row->year;
            $tot = (int) $row->total_count;
            $berlaku = (int) $row->berlaku_count;
            $tidakBerlaku = (int) $row->tidak_berlaku_count;

            if ($tot > $topYear['count']) {
                $topYear = ['year' => $y, 'count' => $tot];
            }

            $byYear[] = [
                'year' => $y,
                'total_count' => $tot,
                'berlaku_count' => $berlaku,
                'tidak_berlaku_count' => $tidakBerlaku,
            ];
        }

        // 3. Status breakdown
        $statusCountsQuery = (clone $docBase)->select('status_berlaku', DB::raw('count(*) as count'));

        if ($year) {
            $statusCountsQuery->where('year', $year);
        }
        if ($ruleTypeId) {
            $statusCountsQuery->where('rule_type_id', $ruleTypeId);
        }

        $statusRaw = $statusCountsQuery->groupBy('status_berlaku')->pluck('count', 'status_berlaku')->toArray();

        $berlakuCount = $statusRaw[1] ?? 0;
        $tidakBerlakuCount = $statusRaw[0] ?? 0;
        $berlakuPct = $totalDocuments > 0 ? round(($berlakuCount / $totalDocuments) * 100, 1) : 0.0;
        $tidakBerlakuPct = $totalDocuments > 0 ? round(($tidakBerlakuCount / $totalDocuments) * 100, 1) : 0.0;

        // 4. Available Options for Filter
        $availableYears = (clone $docBase)->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $availableRuleTypes = RuleType::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->select('id', 'label')
            ->get()
            ->toArray();

        return [
            'filters' => [
                'selected_year' => $year,
                'selected_rule_type_id' => $ruleTypeId,
                'available_years' => $availableYears,
                'available_rule_types' => $availableRuleTypes,
            ],
            'summary' => [
                'total_documents' => $totalDocuments,
                'total_active_rule_types' => $activeRuleTypesCount,
                'top_year' => $topYear,
                'status_berlaku' => [
                    'count' => $berlakuCount,
                    'percentage' => $berlakuPct,
                ],
                'status_tidak_berlaku' => [
                    'count' => $tidakBerlakuCount,
                    'percentage' => $tidakBerlakuPct,
                ],
            ],
            'by_type' => $byType,
            'by_year' => $byYear,
        ];
    }

    /**
     * Cross-tabulation Matrix (Jenis Peraturan x Tahun)
     *
     * @param string|int|null $year
     * @param string|int|null $ruleTypeId
     * @param bool $isAdmin
     * @return array
     */
    public static function getCrossTabMatrix($year = null, $ruleTypeId = null, bool $isAdmin = false): array
    {
        $year = ($year !== null && $year !== '' && $year !== 'all') ? (int) $year : null;
        $ruleTypeId = ($ruleTypeId !== null && $ruleTypeId !== '' && $ruleTypeId !== 'all') ? (int) $ruleTypeId : null;

        $docBase = Document::where('master_document_id', Document::PERATURAN);
        if (!$isAdmin) {
            $docBase->where('is_active', 1);
        }

        // All distinct available years in descending order
        $allYears = (clone $docBase)->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $ruleTypesQuery = RuleType::where('is_active', 1)->orderBy('id', 'asc');
        if ($ruleTypeId) {
            $ruleTypesQuery->where('id', $ruleTypeId);
        }
        $ruleTypes = $ruleTypesQuery->get();

        // Aggregate counts: (rule_type_id, year) -> count
        $countsQuery = (clone $docBase)->select('rule_type_id', 'year', DB::raw('count(*) as count'))
            ->whereNotNull('year');

        if ($year) {
            $countsQuery->where('year', $year);
        }
        if ($ruleTypeId) {
            $countsQuery->where('rule_type_id', $ruleTypeId);
        }

        $countsRaw = $countsQuery->groupBy('rule_type_id', 'year')->get();

        $matrixMap = [];
        foreach ($countsRaw as $r) {
            $matrixMap[$r->rule_type_id][$r->year] = (int) $r->count;
        }

        $displayYears = $year ? [$year] : $allYears;

        $rows = [];
        $colTotals = array_fill_keys($displayYears, 0);
        $grandTotal = 0;

        foreach ($ruleTypes as $rt) {
            $rowCounts = [];
            $rowTotal = 0;
            foreach ($displayYears as $y) {
                $c = $matrixMap[$rt->id][$y] ?? 0;
                $rowCounts[$y] = $c;
                $rowTotal += $c;
                $colTotals[$y] += $c;
            }
            $grandTotal += $rowTotal;

            $rows[] = [
                'id' => $rt->id,
                'label' => $rt->label,
                'color' => $rt->chart_color ?: '#2563eb',
                'years' => $rowCounts,
                'total' => $rowTotal,
            ];
        }

        return [
            'years' => $displayYears,
            'all_years' => $allYears,
            'rows' => $rows,
            'col_totals' => $colTotals,
            'grand_total' => $grandTotal,
        ];
    }

    /**
     * Drilldown query for documents based on statistical filters.
     * Supports search (title/no), filters (year, rule_type_id, status_berlaku), sorting, and pagination.
     *
     * @param Request $request
     * @param bool $isAdmin
     * @param bool $paginate
     * @return array
     */
    public static function getDocumentsQuery(Request $request, bool $isAdmin = false, bool $paginate = true)
    {
        $query = Document::translate()
            ->with('rule_type')
            ->where('master_document_id', Document::PERATURAN);

        if (!$isAdmin) {
            $query->where('is_active', 1);
        }

        // Filter: Year
        $year = $request->input('year');
        if ($year && $year !== 'all') {
            $query->where('year', (int) $year);
        }

        // Filter: Rule Type
        $ruleTypeId = $request->input('rule_type_id');
        if ($ruleTypeId && $ruleTypeId !== 'all') {
            $query->where('rule_type_id', (int) $ruleTypeId);
        }

        // Filter: Status Berlaku
        $status = $request->input('status_berlaku');
        if ($status !== null && $status !== '' && $status !== 'all') {
            $query->where('status_berlaku', (int) $status);
        }

        // Search: Title or No Peraturan
        $search = trim($request->input('q', ''));
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $term = '%' . $search . '%';
                $q->where('title', 'like', $term)
                  ->orWhere('no_peraturan', 'like', $term)
                  ->orWhere('year', 'like', $term);
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'tanggal_penetapan');
        $sortDir = strtolower($request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSort = ['tanggal_penetapan', 'no_peraturan', 'year', 'id', 'status_berlaku'];
        if (!in_array($sortBy, $allowedSort)) {
            $sortBy = 'tanggal_penetapan';
        }

        $query->orderBy($sortBy, $sortDir)->orderBy('id', 'desc');

        if (!$paginate) {
            $limit = min((int) $request->input('limit', 1000), 2000);
            $items = $query->limit($limit)->get();
            return self::formatDocumentsCollection($items);
        }

        $perPage = (int) $request->input('per_page', 10);
        if ($perPage < 1 || $perPage > 100) $perPage = 10;
        $page = (int) $request->input('page', 1);
        if ($page < 1) $page = 1;

        $paginated = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
            'from' => $paginated->firstItem(),
            'to' => $paginated->lastItem(),
            'data' => self::formatDocumentsCollection($paginated->items()),
        ];
    }

    /**
     * Helper to format documents collection cleanly with formatted dates and links.
     *
     * @param iterable $items
     * @return array
     */
    protected static function formatDocumentsCollection($items): array
    {
        $formatted = [];
        $adminUrlPrefix = defined('ADMIN') ? ADMIN : config('cadmin.cadmin.admin-url', 'admin-panel');

        foreach ($items as $doc) {
            $tglPenetapan = $doc->tanggal_penetapan ? Carbon::parse($doc->tanggal_penetapan)->translatedFormat('d M Y') : '-';
            $tglPengundangan = $doc->tanggal_pengundangan ? Carbon::parse($doc->tanggal_pengundangan)->translatedFormat('d M Y') : '-';

            $formatted[] = [
                'id' => $doc->id,
                'title' => $doc->translated('title') ?: ('Dokumen #' . $doc->id),
                'no_peraturan' => $doc->no_peraturan,
                'year' => (int) $doc->year,
                'rule_type_id' => $doc->rule_type_id,
                'rule_type_name' => $doc->rule_type ? $doc->rule_type->label : '-',
                'tanggal_penetapan' => $doc->tanggal_penetapan,
                'tanggal_penetapan_formatted' => $tglPenetapan,
                'tanggal_pengundangan' => $doc->tanggal_pengundangan,
                'tanggal_pengundangan_formatted' => $tglPengundangan,
                'status_berlaku' => (int) $doc->status_berlaku,
                'status_berlaku_label' => $doc->status_berlaku == 1 ? 'Berlaku' : 'Tidak Berlaku',
                'is_active' => (int) $doc->is_active,
                'admin_edit_url' => url($adminUrlPrefix . '/document-peraturan/edit?id=' . $doc->id),
                'public_url' => !empty($doc->permalink_document) ? url($doc->permalink_document) : null,
                'pdf_url' => !empty($doc->pdf) ? route('document.download', ['type' => 'pdf', 'id' => $doc->id]) : null,
            ];
        }

        return $formatted;
    }

    /**
     * API: Full Legal Products Statistics
     * GET /api/statistics/legal-products
     */
    public function apiLegalProducts(Request $request)
    {
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = (bool) $request->query('is_admin', false);

        $data = self::getStatisticsData($year, $ruleTypeId, $isAdmin);

        return response()->json([
            'status' => 'success',
            'message' => 'Statistik Produk Hukum berhasil dimuat',
            'data' => $data,
        ]);
    }

    /**
     * API: Legal Products Statistics By Type
     * GET /api/statistics/legal-products/by-type
     */
    public function apiLegalProductsByType(Request $request)
    {
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = (bool) $request->query('is_admin', false);

        $data = self::getStatisticsData($year, $ruleTypeId, $isAdmin);

        return response()->json([
            'status' => 'success',
            'filter' => [
                'year' => $data['filters']['selected_year'],
                'rule_type_id' => $data['filters']['selected_rule_type_id'],
            ],
            'total_documents' => $data['summary']['total_documents'],
            'data' => $data['by_type'],
        ]);
    }

    /**
     * API: Legal Products Statistics By Year
     * GET /api/statistics/legal-products/by-year
     */
    public function apiLegalProductsByYear(Request $request)
    {
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = (bool) $request->query('is_admin', false);

        $data = self::getStatisticsData($year, $ruleTypeId, $isAdmin);

        return response()->json([
            'status' => 'success',
            'filter' => [
                'year' => $data['filters']['selected_year'],
                'rule_type_id' => $data['filters']['selected_rule_type_id'],
            ],
            'total_documents' => $data['summary']['total_documents'],
            'data' => $data['by_year'],
        ]);
    }

    /**
     * API: Cross-Tabulation Matrix (Jenis Peraturan x Tahun)
     * GET /api/statistics/legal-products/matrix
     */
    public function apiLegalProductsMatrix(Request $request)
    {
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $isAdmin = (bool) $request->query('is_admin', false);

        $matrix = self::getCrossTabMatrix($year, $ruleTypeId, $isAdmin);

        return response()->json([
            'status' => 'success',
            'message' => 'Matriks statistik berhasil dimuat',
            'data' => $matrix,
        ]);
    }

    /**
     * API: Documents Drilldown with pagination & search
     * GET /api/statistics/legal-products/documents
     */
    public function apiLegalProductsDocuments(Request $request)
    {
        $isAdmin = (bool) $request->query('is_admin', false);
        $paginated = self::getDocumentsQuery($request, $isAdmin, true);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar dokumen berhasil dimuat',
            'data' => $paginated,
        ]);
    }

    /**
     * Export Statistics to Formal Government PDF
     * GET /api/statistics/legal-products/export-pdf
     */
    public function exportPdf(Request $request)
    {
        $year = $request->query('year');
        $ruleTypeId = $request->query('rule_type_id');
        $statusBerlaku = $request->query('status_berlaku');
        $mode = $request->query('mode', 'all'); // 'all', 'year', 'type', 'documents'
        $isAdmin = (bool) $request->query('is_admin', false);

        $stats = self::getStatisticsData($year, $ruleTypeId, $isAdmin);
        $matrix = self::getCrossTabMatrix($year, $ruleTypeId, $isAdmin);
        $documents = self::getDocumentsQuery($request, $isAdmin, false);

        // Friendly label filters
        $yearLabel = ($year && $year !== 'all') ? "Tahun $year" : "Semua Tahun";
        $ruleTypeLabel = "Semua Jenis Peraturan";
        if ($ruleTypeId && $ruleTypeId !== 'all') {
            $rt = RuleType::find($ruleTypeId);
            if ($rt) $ruleTypeLabel = $rt->label;
        }

        $statusLabel = "Semua Status";
        if ($statusBerlaku === '1' || $statusBerlaku === 1) {
            $statusLabel = "Berlaku";
        } elseif ($statusBerlaku === '0' || $statusBerlaku === 0) {
            $statusLabel = "Tidak Berlaku";
        }

        $modeTitles = [
            'all' => 'LAPORAN STATISTIK LENGKAP DAN DAFTAR PRODUK HUKUM',
            'year' => 'LAPORAN STATISTIK PRODUK HUKUM BERDASARKAN TAHUN ' . ($year ?: ''),
            'type' => 'LAPORAN STATISTIK PRODUK HUKUM BERDASARKAN JENIS PERATURAN',
            'documents' => 'DAFTAR PRODUK HUKUM HASIL FILTER STATISTIK',
        ];

        $reportTitle = $modeTitles[$mode] ?? 'LAPORAN STATISTIK PRODUK HUKUM JDIH';
        $generatedAt = Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB';

        $pdf = Pdf::loadView('reports.statistik-pdf', [
            'reportTitle' => $reportTitle,
            'generatedAt' => $generatedAt,
            'exportModeLabel' => ucfirst($mode),
            'filterYearLabel' => $yearLabel,
            'filterRuleTypeLabel' => $ruleTypeLabel,
            'filterStatusLabel' => $statusLabel,
            'stats' => $stats,
            'matrix' => $matrix,
            'documents' => $documents,
            'hideMatrix' => ($mode === 'documents'),
            'hideByType' => ($mode === 'documents'),
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'Helvetica',
        ]);

        $filename = 'Laporan_Statistik_JDIH_' . date('Ymd_His') . '.pdf';

        if ($request->query('download') == '0') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    /**
     * API: Videos listing with classification filtering
     * GET /api/videos?category=gallery|accessibility
     */
    public function apiVideos(Request $request)
    {
        $category = strtolower(trim($request->query('category', '')));

        $query = Gallery::translate()
            ->with('classifications')
            ->whereIsActive(1)
            ->where('type', 'video');

        if ($category === 'gallery' || $category === 'galeri') {
            $query->whereHas('classifications', function ($q) {
                $q->where('code', 'galeri');
            });
        } elseif ($category === 'accessibility' || $category === 'aksesibilitas') {
            $query->whereHas('classifications', function ($q) {
                $q->where('code', 'aksesibilitas');
            });
        } elseif (!empty($category)) {
            $query->whereHas('classifications', function ($q) use ($category) {
                $q->where('code', $category);
            });
        }

        $videos = $query->orderBy('sort_id', 'asc')
            ->orderBy('date', 'desc')
            ->get();

        $formatted = $videos->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->translated('title'),
                'slug' => \Illuminate\Support\Str::slug($item->translated('title')),
                'description' => $item->translated('description'),
                'video_url' => $item->iframe,
                'embed_url' => $item->embed_url,
                'thumbnail_url' => $item->thumbnail_url,
                'date' => $item->date,
                'sort_id' => (int) $item->sort_id,
                'classifications' => $item->classifications->map(function ($c) {
                    return [
                        'id' => $c->id,
                        'code' => $c->code,
                        'name' => $c->name,
                    ];
                })->values(),
                'created_at' => $item->created_at ? $item->created_at->toIso8601String() : null,
                'updated_at' => $item->updated_at ? $item->updated_at->toIso8601String() : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'category' => $category ?: 'all',
            'total' => $formatted->count(),
            'data' => $formatted,
        ]);
    }
}
