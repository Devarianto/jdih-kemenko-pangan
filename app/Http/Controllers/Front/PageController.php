<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;
use Cactuar\Admin\Helpers\og;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;
use Cactuar\Admin\Models\Conf;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Document;
use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\Infografis;
use App\Models\KamusHukum;
use App\Models\Rating;

use DB;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home()
    {
        $home = Menu::translate()->firstOrFail();

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->orderBy('sort_id')->get();
        $year_peraturan = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get();

        $news_first = News::translate()->whereIsActive(1)->orderBy('date', 'desc')->first();
        $news_others = News::translate()->whereIsActive(1)->offset(1)->limit(3)->orderBy('date', 'desc')->get();

        $gallery_image = Gallery::translate()->whereIsActive(1)->where('type', 'image')->orderBy('date', 'desc')->first();
        $gallery_video = Gallery::translate()->whereIsActive(1)->where('type', 'video')->orderBy('date', 'desc')->first();

        $newest_documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PERATURAN)->orderBy('tanggal_penetapan', 'desc')->limit(5)->get();
        $popular_documents = Document::translate()->whereIsActive(1)->orderBy('view_count', 'desc')->limit(4)->get();

        $menus = [];
        //Monografi
        $document_monografi = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->orderBy('tahun_terbit', 'desc')->orderBy('created_at','desc');
        $monografi_count = $document_monografi->count();
        $document_monografi = $document_monografi->limit(4)
            ->get();
        $menus['monografi'] = Menu::fe()->whereIsActive(1)->where('type', 'monografi-hukum')->first();

        // Peraturan
        $document_peraturan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('tanggal_penetapan', 'desc');
        $peraturan_count = $document_peraturan->count();
        $document_peraturan = $document_peraturan->limit(4)
            ->get();
        $menus['peraturan'] = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        // Putusan
        $document_putusan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $putusan_count = $document_putusan->count();
        $document_putusan = $document_putusan->limit(4)
            ->get();
        $menus['putusan'] = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        // Jurnal
        $document_jurnal = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $jurnal_count = $document_jurnal->count();
        $document_jurnal = $document_jurnal->limit(4)
            ->get();
        $menus['jurnal'] = Menu::fe()->whereIsActive(1)->where('type', 'jurnal-hukum')->first();

        // Kliping
        $document_kliping = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $kliping_count = $document_kliping->count();
        $document_kliping = $document_kliping->limit(4)
            ->get();
        $menus['kliping'] = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        // Majalah
        $document_majalah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $majalah_count = $document_majalah->count();
        $document_majalah = $document_majalah->limit(4)
            ->get();
        $menus['majalah'] = Menu::fe()->whereIsActive(1)->where('type', 'majalah-hukum')->first();

        // Naskah
        $document_naskah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $naskah_count = $document_naskah->count();
        $document_naskah = $document_naskah->limit(4)
            ->get();
        $menus['naskah'] = Menu::fe()->whereIsActive(1)->where('type', 'naskah-hukum')->first();


        $now_year = (int) Carbon::now()->format('Y');
        $back_year = (int) Carbon::now()->subYear(4)->format('Y');
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
            ->groupBy('year')
            ->orderBy("year", 'desc')
            ->get();

        $arr_years = [];
        for ($i=0; $i < 5; $i++) { 
            $arr_years[] = $now_year;
            $now_year -= 1;
        }

        sort($arr_years);

        $get_chart = $this->getChartStatistic($arr_years);

        $menu_statistic = Menu::fe()->whereIsActive(1)->where('type', 'about-statistik')->first();

        // Rating
        $total_rating = Rating::whereIsActive(1)->count();
        $average = Rating::whereIsActive(1)->avg('rating');
        $avg_rating = round($average, 1);

        $rating = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        $get_rating = Rating::select('rating', DB::raw('count(rating) as count_rating'))->whereIsActive(1)->groupBy('rating')->pluck('count_rating', 'rating')->toArray();
        
        foreach ($rating as $key => $data) {
            if (isset($get_rating[$key])) {
                $rating[$key] = $get_rating[$key];
            }
        }
        
        $rating = json_encode($rating);

        $popup = Conf::initial('popup-page');
        
        $artikel_count = $jurnal_count + $majalah_count;
        $document_rancangan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU);
        $rancangan_count = $document_rancangan->count();
        $menus['rancangan'] = Menu::fe()->whereIsActive(1)->where('type', 'rancangan-puu')->first();

        return view('dynamic.home', compact(
            'news_first', 'news_others', 'newest_documents', 
            'document_monografi', 'monografi_count', 
            'document_peraturan', 'peraturan_count',
            'document_putusan', 'putusan_count', 
            'document_jurnal', 'jurnal_count', 
            'document_majalah', 'majalah_count', 
            'document_kliping', 'kliping_count', 
            'document_naskah', 'naskah_count', 
            'artikel_count', 'rancangan_count',
            'menus', 'popular_documents', 
            'gallery_image', 'gallery_video', 
            'get_chart', 'menu_statistic',
            'total_rating', 'avg_rating', 'rating', 'home', 'rule_types', 'rule_themes', 'year_peraturan', 'popup'));
    }

    private function find($id=null)
    {
        if(empty($id)) $id = Permalink::active()->uniqid;

        $menu = Menu::translate()->whereIsActive(1)->findOrFail($id);

        return $menu;
    }

    public function getTemplate()
    {
        $menu = $this->find();
        
        $template = helper::dash2camel('get-'.$menu->type);
        if (!method_exists($this,$template))
            abort(404);
        
        return $this->{$template}($menu);
    }

    public function getAbout($menu)
    {
        return view('dynamic.pages.about', compact('menu'));
    }

    public function getAboutSop($menu)
    {
        return view('dynamic.pages.about-sop', compact('menu'));
    }

    public function getAboutVisiMisi($menu)
    {
        return view('dynamic.pages.about-visimisi', compact('menu'));
    }

    public function getAboutStruktur($menu)
    {
        return view('dynamic.pages.about-struktur', compact('menu'));
    }

    public function getAboutContactUs($menu)
    {
        return view('dynamic.pages.about-contactus', compact('menu'));
    }

    public function getFAQ($menu)
    {
        return view('dynamic.pages.faq', compact('menu'));
    }

    public function getInformasiRancangan($menu)
    {
        return view('dynamic.pages.informasi-rancangan', compact('menu'));
    }

    public function getAboutStatistik($menu)
    {
        $selectedYear = request()->query('year');
        $selectedRuleTypeId = request()->query('rule_type_id');

        $stats = StatisticController::getStatisticsData($selectedYear, $selectedRuleTypeId);
        $matrix = StatisticController::getCrossTabMatrix($selectedYear, $selectedRuleTypeId);

        // Populate backward-compatible variables for existing and enhanced blade templates
        $rule_types = collect($stats['by_type'])->map(function($item) {
            return (object) [
                'id' => $item['id'],
                'label' => $item['label'],
                'documents_count' => $item['count'],
                'chart_color' => $item['color'],
                'percentage' => $item['percentage'],
            ];
        });

        $years = collect($stats['filters']['available_years'])->map(function($y) {
            return (object) ['year' => $y];
        });

        $colors = collect($stats['by_type'])->pluck('color')->toArray();
        $arr_rule_label = collect($stats['by_type'])->pluck('label')->toArray();
        $arr_rule_count = collect($stats['by_type'])->pluck('count')->toArray();

        $get_chart = [
            'berlaku' => [
                'year' => collect($stats['by_year'])->pluck('year')->toArray(),
                'data' => collect($stats['by_year'])->pluck('berlaku_count')->toArray(),
            ],
            'tidak-berlaku' => [
                'year' => collect($stats['by_year'])->pluck('year')->toArray(),
                'data' => collect($stats['by_year'])->pluck('tidak_berlaku_count')->toArray(),
            ],
        ];

        return view('dynamic.pages.about-statistik', compact(
            'menu', 'rule_types', 'years', 'colors', 'arr_rule_label', 'arr_rule_count', 'get_chart', 'stats', 'matrix'
        ));
    }

    public function getChartStatistic($years)
    {
        $now_year = (int) Carbon::now()->format('Y');
        $back_year = (int) Carbon::now()->subYear(4)->format('Y');
        
        $year_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 1)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
            ->groupBy('year')
            ->pluck('count_year', 'year')
            ->toArray();

        $year_tidak_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 0)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
            ->groupBy('year')
            ->pluck('count_year', 'year')
            ->toArray();

        $arr_year_berlaku = [
            'year' => [],
            'data' => [],
        ];
        $arr_year_tidak_berlaku = [
            'year' => [],
            'data' => [],
        ];

        foreach ($years as $data) {
            $arr_year_berlaku['year'][] = $data;
            $arr_year_berlaku['data'][] = isset($year_berlaku[$data]) ? $year_berlaku[$data] : 0;
        }

        foreach ($years as $data) {
            $arr_year_tidak_berlaku['year'][] = $data;
            $arr_year_tidak_berlaku['data'][] = isset($year_tidak_berlaku[$data]) ? $year_tidak_berlaku[$data] : 0;
        }

        return ['berlaku' => $arr_year_berlaku, 'tidak-berlaku' => $arr_year_tidak_berlaku];
    }

    public function getInformasiGaleri($menu)
    {
        $galleries = Gallery::translate()->whereIsActive(1);

        $filter = request()->query('filter', 'all');
        if ($filter == 'image') {
            $galleries = $galleries->where('type', 'image');
        } else if ($filter == 'video') {
            $galleries = $galleries->where('type', 'video')
                ->whereHas('classifications', function($q) {
                    $q->where('code', 'galeri');
                });
        } else {
            // 'all': images OR videos that have the 'galeri' classification
            $galleries = $galleries->where(function($q) {
                $q->where('type', 'image')
                  ->orWhere(function($sub) {
                      $sub->where('type', 'video')
                          ->whereHas('classifications', function($c) {
                              $c->where('code', 'galeri');
                          });
                  });
            });
        }
        
        if (request()->query('sort') == 'oldest') {
            $galleries = $galleries->orderBy('date', 'asc');
        } else {
            $galleries = $galleries->orderBy('sort_id', 'asc')->orderBy('date', 'desc');
        }
        
        $galleries = $galleries->paginate(9);
        
        return view('dynamic.pages.informasi-galeri', compact('menu', 'galleries'));
    }

    public function getInformasiInfografis($menu)
    {
        $infografis = Infografis::translate()->whereIsActive(1);

        if (request()->query('sort') == 'latest') {
            $infografis = $infografis->orderBy('date', 'desc');
        } else if (request()->query('sort') == 'oldest') {
            $infografis = $infografis->orderBy('date', 'asc');
        } else {
            $infografis = $infografis->orderBy('date', 'desc');
        }
        
        $infografis = $infografis->paginate(12);
        
        return view('dynamic.pages.documentlainnya-infografis', compact('menu', 'infografis'));
    }

    public function getInformasiInfografisDetail()
    {
        $id = Permalink::active()->uniqid;
        $infografis = Infografis::translate()->whereIsActive(1)->findOrFail($id);
        $infografis->view_count += 1;
        $infografis->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'informasi-infografis')->first();
        $others = Infografis::translate()->whereIsActive(1)->where('id', '!=', $infografis->id)
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->sortByDesc('date')
            ->values();

        return view('dynamic.pages.documentlainnya-infografis-detail', compact('infografis', 'menu', 'others'));
    }

    public function getNews($menu)
    {
        $news = News::translate()->whereIsActive(1);


        if (request()->query('sort') == 'latest') {
            $news = $news->orderBy('date', 'desc');
        } else if (request()->query('sort') == 'oldest') {
            $news = $news->orderBy('date', 'asc');
        } else {
            $news = $news->orderBy('date', 'desc');
        }
        
        $news = $news->paginate(9);
        
        return view('dynamic.pages.documentlainnya-berita', compact('menu', 'news'));
    }

    public function getNewsDetail()
    {
        $id = Permalink::active()->uniqid;
        $news = News::translate()->whereIsActive(1)->findOrFail($id);
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'news')->first();
        $others = News::translate()->whereIsActive(1)->where('id', '!=', $news->id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->sortByDesc('date')
            ->values();
            
        return view('dynamic.pages.documentlainnya-berita-detail', compact('news', 'menu', 'others'));
    }

    public function getInformasiKamusHukum($menu)
    {
        $kamus = KamusHukum::translate()->whereIsActive(1);

        if (request()->query('option') && request()->query('option') != 'all') {
            $kamus = $kamus->where('title', 'like', request()->query('option').'%');
        }

        if (request()->query('search')) {
            $kamus = $kamus->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $kamus = $kamus->orderBy('title', 'asc')->paginate(6);
        
        return view('dynamic.pages.documentlainnya-kamus-hukum', compact('menu', 'kamus'));
    }

    public function getInformasiKamusHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $kamus = KamusHukum::translate()->whereIsActive(1)->findOrFail($id);
        $kamus->view_count += 1;
        $kamus->save();

        $menu = Menu::fe()->whereIsActive(1)->where('type', 'informasi-kamus-hukum')->first();
        $others = KamusHukum::translate()->whereIsActive(1)->where('id', '!=', $kamus->id)->inRandomOrder()->limit(3)->get();
        return view('dynamic.pages.documentlainnya-kamus-hukum-detail', compact('kamus', 'menu', 'others'));
    }

    public function getPeraturanHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PERATURAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('rule_type')) {
            $documents = $documents->where('rule_type_id', request()->query('rule_type'));
        }

        if (request()->query('theme')) {
            $documents = $documents->where('rule_theme_id', request()->query('theme'));
        }

        if (request()->query('year')) {
            $documents = $documents->where('year', request()->query('year'));
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->paginate(8);

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->get();
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get();
        
        return view('dynamic.pages.document-peraturan', compact('menu', 'documents', 'rule_types', 'rule_themes', 'years'));
    }

    public function getJurnalHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::JURNAL);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->orderBy('tahun_terbit', 'desc')
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-jurnal', compact('menu', 'documents', 'years'));
    }

    public function getKlipingHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::KLIPING);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->orderBy('tahun_terbit', 'desc')
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-kliping', compact('menu', 'documents', 'years'));
    }

    public function getMajalahHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::MAJALAH);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->orderBy('tahun_terbit', 'desc')
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-article', compact('menu', 'documents', 'years'));
    }

    public function getPutusanHukum($menu, $courtType = null)
    {
        $court = $courtType ?: request()->query('court');
        $query = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PUTUSAN);

        if ($court) {
            $court = strtoupper(trim($court));
            if ($court === 'MAHKAMAH-AGUNG' || $court === 'MA') {
                $query->where(function($q) {
                    $q->where('documents.court_type', 'MA')
                      ->orWhere('documents_lang.jenis_peradilan', 'like', '%Mahkamah Agung%')
                      ->orWhere('documents_lang.singkatan_peradilan', 'MA');
                });
                $court = 'MA';
            } elseif ($court === 'MAHKAMAH-KONSTITUSI' || $court === 'MK') {
                $query->where(function($q) {
                    $q->where('documents.court_type', 'MK')
                      ->orWhere('documents_lang.jenis_peradilan', 'like', '%Mahkamah Konstitusi%')
                      ->orWhere('documents_lang.singkatan_peradilan', 'MK');
                });
                $court = 'MK';
            }
        }

        if (request()->query('search')) {
            $search = request()->query('search');
            $query->where(function($q) use ($search) {
                $q->where('documents_lang.title', 'like', '%'.$search.'%')
                  ->orWhere('documents.no_putusan', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.intro', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.subjek', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.bidang_hukum', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.pokok_perkara', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.pemohon', 'like', '%'.$search.'%');
            });
        }

        if (request()->query('no_putusan')) {
            $query->where('documents.no_putusan', 'like', '%'.request()->query('no_putusan').'%');
        }

        if (request()->query('year')) {
            $yearVal = request()->query('year');
            $query->where(function($q) use ($yearVal) {
                $q->whereYear('documents.tanggal_dibacakan', $yearVal)
                  ->orWhere('documents.year', $yearVal);
            });
        }

        if (request()->query('sort') == 'oldest') {
            $query->orderBy('documents.updated_at', 'asc')->orderBy('documents.created_at', 'asc');
        } else {
            $query->orderBy('documents.updated_at', 'desc')->orderBy('documents.created_at', 'desc')->orderBy('documents.id', 'desc');
        }
        
        $documents = $query->paginate(8);

        $years = Document::selectRaw('COALESCE(year, YEAR(tanggal_dibacakan)) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->whereNotNull('tanggal_dibacakan')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-putusan', compact('menu', 'documents', 'years', 'court'));
    }

    public function getPutusanHukumRoute()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, null);
    }

    public function getPutusanMa()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, 'MA');
    }

    public function getPutusanMk()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, 'MK');
    }

    public function getMonografiHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::MONOGRAFI);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->orderBy('tahun_terbit', 'desc')
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-monografi', compact('menu', 'documents', 'years'));
    }

    public function getNaskahHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::NASKAH);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->whereYear('tanggal_berlaku', request()->query('year'));
        }
        
        $documents = $documents->orderBy('tanggal_berlaku', 'desc')->orderBy('id', 'desc')->paginate(8);

        $years = Document::selectRaw('YEAR(tanggal_berlaku) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-naskah', compact('menu', 'documents', 'years'));
    }

    public function getPeraturanTerjemahan($menu)
    {
        $documents = Document::translate()
            ->whereIsActive(1)
            ->where(function($query) {
                $query->where('master_document_id', Document::PERATURAN_TERJEMAHAN)
                    ->orWhere(function($sub) {
                        $sub->whereIn('master_document_id', [Document::PERATURAN, Document::PERATURAN_TERJEMAHAN])
                            ->where('has_translation', 1);
                    });
            });

        if ($search = request()->query('search')) {
            $documents = $documents->where(function($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                  ->orWhere('translation_title', 'like', '%'.$search.'%')
                  ->orWhere('no_peraturan', 'like', '%'.$search.'%')
                  ->orWhere('translation_no_peraturan', 'like', '%'.$search.'%');
            });
        }

        if ($year = request()->query('year')) {
            $documents = $documents->where('year', $year);
        }

        if ($ruleType = request()->query('rule_type')) {
            $documents = $documents->where('rule_type_id', $ruleType);
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);

        $years = Document::select('year')
            ->whereIsActive(1)
            ->where(function($query) {
                $query->where('master_document_id', Document::PERATURAN_TERJEMAHAN)
                    ->orWhere(function($sub) {
                        $sub->whereIn('master_document_id', [Document::PERATURAN, Document::PERATURAN_TERJEMAHAN])
                            ->where('has_translation', 1);
                    });
            })
            ->whereNotNull('year')
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get();
        
        $rule_types = \App\Models\RuleType::whereIsActive(1)->orderBy('id', 'asc')->get();

        return view('dynamic.pages.document-peraturan-terjemahan', compact('menu', 'documents', 'years', 'rule_types'));
    }

    public function getProgramPenyusunanPuu($menu)
    {
        $isEn = app()->getLocale() === 'en';
        og::set(
            'title',
            $isEn ? 'Legislation Drafting Program' : 'Program Penyusunan PUU'
        );
        og::set(
            'description',
            $isEn
                ? 'Legislation Drafting Program of the Coordinating Ministry for Food Affairs of the Republic of Indonesia'
                : 'Program Penyusunan Peraturan Perundang-Undangan Kementerian Koordinator Bidang Pangan Republik Indonesia'
        );

        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PROGRAM_PENYUSUNAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('year', request()->query('year'));
        }

        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PROGRAM_PENYUSUNAN)
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-program-penyusunan', compact('menu', 'documents', 'years'));
    }

    public function getNaskahAkademik($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::NASKAH_AKADEMIK);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = collect();
        return view('dynamic.pages.document-naskah-akademik', compact('menu', 'documents', 'years'));
    }

    public function getAnalisisEvaluasi($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::ANALISIS_EVALUASI);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = collect();
        return view('dynamic.pages.document-analisis-evaluasi', compact('menu', 'documents', 'years'));
    }

    public function getRisalahPembahasan($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::RISALAH_PEMBAHASAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = collect();
        return view('dynamic.pages.document-risalah-pembahasan', compact('menu', 'documents', 'years'));
    }

    public function getKajianHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::KAJIAN_HUKUM);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = collect();
        return view('dynamic.pages.document-kajian-hukum', compact('menu', 'documents', 'years'));
    }

    public function getPartisipasiPublik($menu = null)
    {
        return app(\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class)->index(request(), $menu);
    }

    public function getAksesibilitas($menu = null)
    {
        if (!$menu) {
            $menu = Menu::find(39) ?? Menu::fe()->whereIsActive(1)->where('type', 'aksesibilitas')->first() ?? Menu::first();
        }

        $videos = Gallery::translate()
            ->with('classifications')
            ->whereIsActive(1)
            ->where('type', 'video')
            ->whereHas('classifications', function ($q) {
                $q->where('code', 'aksesibilitas');
            });

        if (request()->query('search')) {
            $videos = $videos->where('title', 'like', '%' . request()->query('search') . '%');
        }

        if (request()->query('sort') === 'oldest') {
            $videos = $videos->orderBy('date', 'asc');
        } else {
            $videos = $videos->orderBy('sort_id', 'asc')->orderBy('date', 'desc');
        }

        $videos = $videos->paginate(6);

        return view('dynamic.pages.informasi-aksesibilitas', compact('menu', 'videos'));
    }

    public function getVideografis($menu)
    {
        return view('dynamic.pages.informasi-videografis', compact('menu'));
    }

    public function getRancanganPuu($menu)
    {
        try {
            \App\Models\Regulasi::doesntHave('document')->get()->each->syncToJdihDocument();
        } catch (\Throwable $e) {}

        $candidates = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU)
            ->whereNotNull('documents.regulasi_id')
            ->whereHas('regulasi');

        if (request()->query('search')) {
            $candidates = $candidates->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $candidates = $candidates->where('year', request()->query('year'));
        }

        if (request()->query('tahapan')) {
            $candidates = $candidates->where('tahapan_puu_id', request()->query('tahapan'));
        }

        $allCandidates = $candidates->with(['regulasi.partisipasiPublik'])->get();

        // Pastikan tiap judul rancangan hanya tampil 1x dengan tahapan/status update terakhir dari e-Regulasi
        $pickedByTitle = [];
        foreach ($allCandidates as $doc) {
            $reg = $doc->regulasi;
            if (!$reg) {
                continue;
            }

            $rawTitle = $doc->translated('title') ?: $reg->judul ?: '';
            $normTitle = mb_strtolower(trim(preg_replace('/\s+/', ' ', strip_tags($rawTitle))));
            if ($normTitle === '') {
                $normTitle = 'regulasi-' . $reg->id;
            }

            $stageRank = $reg->stagePriority();
            $updatedTs = $reg->updated_at ? $reg->updated_at->timestamp : 0;
            $regId = (int) $reg->id;

            if (!isset($pickedByTitle[$normTitle])) {
                $pickedByTitle[$normTitle] = $doc;
            } else {
                $existingReg = $pickedByTitle[$normTitle]->regulasi;
                $exStage = $existingReg ? $existingReg->stagePriority() : 0;
                $exUpdated = ($existingReg && $existingReg->updated_at) ? $existingReg->updated_at->timestamp : 0;
                $exId = $existingReg ? (int) $existingReg->id : 0;

                $isNewer = ($stageRank > $exStage)
                    || ($stageRank === $exStage && $updatedTs > $exUpdated)
                    || ($stageRank === $exStage && $updatedTs === $exUpdated && $regId > $exId);

                if ($isNewer) {
                    $pickedByTitle[$normTitle] = $doc;
                }
            }
        }

        // Urutkan sesuai Daftar Pengajuan PUU (tanggal usulan terbaru -> status update terakhir -> id terbaru)
        $uniqueDocs = collect(array_values($pickedByTitle))->sort(function ($a, $b) {
            $regA = $a->regulasi;
            $regB = $b->regulasi;
            $dateA = $regA && $regA->tgl_usulan ? $regA->tgl_usulan->format('Y-m-d') : ($regA && $regA->created_at ? $regA->created_at->format('Y-m-d') : '1970-01-01');
            $dateB = $regB && $regB->tgl_usulan ? $regB->tgl_usulan->format('Y-m-d') : ($regB && $regB->created_at ? $regB->created_at->format('Y-m-d') : '1970-01-01');
            if ($dateA !== $dateB) {
                return strcmp($dateB, $dateA);
            }
            $updA = $regA && $regA->updated_at ? $regA->updated_at->timestamp : 0;
            $updB = $regB && $regB->updated_at ? $regB->updated_at->timestamp : 0;
            if ($updA !== $updB) {
                return $updB <=> $updA;
            }
            return ($regB->id ?? 0) <=> ($regA->id ?? 0);
        })->values();

        $perPage = 8;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $documents = new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueDocs->forPage($currentPage, $perPage)->values(),
            $uniqueDocs->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU)
            ->whereNotNull('documents.regulasi_id')
            ->whereHas('regulasi')
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-rancangan-puu', compact('menu', 'documents', 'years'));
    }
}
